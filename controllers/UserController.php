<?php
	class UserController {

		public function __construct() {
			Application::$subtitle = "user";
		}

		public function edit_profile() {
			if (isset($_SESSION["id"])) {
				$user = Connection::getConnection()
					->query("SELECT user.nick, user.email, user_role.name as role FROM user ".
						"LEFT JOIN user_role ON user.level=user_role.id " .
						"WHERE user.id=${_SESSION["id"]};");

				if ($user->num_rows) {
					$user = $user->fetch_assoc();

					Application::$subtitle = "editProfile";
					Application::$param    = "\"" . $user["nick"] . "\"";

					View::load("edit-profile", [
						"user"  => $user["nick"],
						"email" => $user["email"],
						"role"  => $user["role"]
					]);
				} else {
					View::load("404");
				}
			} else {
				header("Location: ../");
			}
		}

		public function validate_edition() {
			if (isset($_SESSION["id"])) {
				$user = Connection::getConnection()
					->query("SELECT user.nick, user.email, user.password, user_role.name as role " .
						"FROM user LEFT JOIN user_role ON user.level=user_role.id " .
						"WHERE user.id=${_SESSION['id']};");

				if (isset($_POST["password"])) {
					if ($user) {
						$user = $user->fetch_assoc();

						if (password_verify($_POST["password"], $user["password"])) {
							$builtQuery = "UPDATE user SET";

							$execute = false;

							if (isset($_POST["newemail"]) && $_POST["newemail"] != $user["email"]) {
								$newEmailUsed = false;
								$emailQuery   = "SELECT email FROM user WHERE email='" .
									Connection::getConnection()
										->real_escape_string($_POST["newemail"])
									. "'";
								$emailCheck = Connection::getConnection()->query($emailQuery);
								$newEmailUsed = ($emailCheck->num_rows)? true : false;

								if ($newEmailUsed) {
									View::load("edit-profile", [
										"user" => $user["nick"],
										"email" => $user["email"],
										"role"  => $user["role"],
										"error" => "El email introducido ya está en uso."
									]);
								} else {
									$builtQuery .= " email='" .
										Connection::getConnection()
											->real_escape_string($_POST["newemail"])
										."'";
									$execute = true;
								}
							}

							if (isset($_POST["newpassword"]) && isset($_POST["newpasswordre"]) &&
								!empty($_POST["newpassword"]) && !empty($_POST["newpasswordre"]) &&
								$_POST["newpassword"] == $_POST["newpasswordre"]) {
								$builtQuery .= " password='" .
									password_hash($_POST["newpassword"], PASSWORD_DEFAULT) . "'";
								$execute = true;
							} else {
								View::load("edit-profile", [
									"user"  => $user["nick"],
									"email" => $user["email"],
									"role"  => $user["role"],
									"error" => "Error en la nueva contraseña."
								]);
							}

							$builtQuery .= " WHERE id=" . $_SESSION["id"] . ";";

							if ($execute) {
								$edited = Connection::getConnection()->query($builtQuery);

								if ($edited) {
									header("Location: ../user/profile/" . $user["nick"]);
									exit;
								} else {
									View::load("edit-profile", [
										"user"  => $user["nick"],
										"email" => $user["email"],
										"role"  => $user["role"],
										"error" => "Error desconocido."
									]);
								}
							} else {
								View::load("edit-profile", [
									"user"  => $user["nick"],
									"email" => $user["email"],
									"role"  => $user["role"],
									"error" => "No hay campos que modificar."
								]);
							}
						} else {
							View::load("edit-profile", [
								"user"  => $user["nick"],
								"email" => $user["email"],
								"role"  => $user["role"],
								"error" => "La contraseña introducida es incorrecta."
							]);
						}
					}
				} else {
					if ($user->num_rows) {
						$user = $user->fetch_assoc();
						View::load("edit-profile", [
							"user"  => $user["nick"],
							"email" => $user["email"],
							"role"  => $user["role"],
							"error" =>
								"Es necesario confirmar tu contraseña para poder hacer un cambio."
						]);
					} else {
						View::load("404");
					}
				}
			} else {
				View::load("404");
			}
		}

		public function account() {
			if (!isset($_SESSION["user"])) {
				// Entrar y registrar
				Application::$subtitle = "forms";
				Application::$param    = "login, register";

				if (isset($_POST["login_email"]) && isset($_POST["login_password"])) {
					// Login
					$email  = Connection::getConnection()
						->real_escape_string($_POST["login_email"]);
					$result = Connection::getConnection()
						->query("SELECT * FROM user WHERE email='${email}' AND verified = 1;");

					if ($result->num_rows) {
						$user = $result->fetch_assoc();

						if (password_verify($_POST["login_password"], $user["password"])) {
							// Contraseña coincide: login
							$_SESSION["id"]    = $user["id"];
							$_SESSION["user"]  = $user["nick"];
							$_SESSION["email"] = $user["email"];

							// Añadir a la sesión el nivel del usuario
							if ($user["level"] != null) {
								$l = Connection::getConnection()
									->query("SELECT * FROM user_role WHERE id=" .
										$user["level"] . ";");
								if ($l->num_rows) $_SESSION["level"] = $l->fetch_assoc()["slug"];
							}

							header("Location: ../");
							exit;
						} else {
							// La contraseña no coincide
							$error = "La contraseña introducida es incorrecta.";
						}
					} else {
						$error = "El email introducido no está asociado a ninguna cuenta.";
					}
				} else if (isset($_POST["reg_email"]) && isset($_POST["reg_username"]) &&
					isset($_POST["reg_password"]) && isset($_POST["reg_repassword"])) {
					// Registrar
					$email = Connection::getConnection()
						->real_escape_string($_POST["reg_email"]);
					$username = Connection::getConnection()
						->real_escape_string($_POST["reg_username"]);
					$password = ($_POST["reg_password"] == $_POST["reg_password"])?
						password_hash($_POST["reg_password"], PASSWORD_DEFAULT) : false;

					// Queries para comprobar
					$emailCheckQuery = "SELECT * FROM user WHERE email='${email}';";
					$userCheckQuery  = "SELECT * FROM user WHERE nick='${username}';";
					$userCheck  = Connection::getConnection()->query($userCheckQuery)->num_rows;
					$emailCheck = Connection::getConnection()->query($emailCheckQuery)->num_rows;

					if (!$password)  $error = "Las contraseñas introducidas no coinciden.";
					if ($userCheck)  $error = "El usuario introducido ya está en uso.";
					if ($emailCheck) $error = "El email introducido ya está en uso.";

					if ($password && !$emailCheck && !$userCheck) {
						// Contraseñas coinciden y ni el usuario ni el email están en uso: registrar
						// Aplicar rol de usuario predeterminado
						$defaultRoleQuery =
							"SELECT cvalue as value FROM config WHERE ckey='def_role';";

						$defaultRole = Connection::getConnection()->query($defaultRoleQuery);

						$verify_token = urlencode(sha1("${email}+${username}"));
						$verify_url   = $_SERVER["SERVER_NAME"] . "/user/verify/${verify_token}";

						if ($defaultRole) {
							$defaultRole = $defaultRole->fetch_assoc()["value"];
							$defaultRole = Connection::getConnection()->query("SELECT id FROM user_role WHERE slug='" .
								$defaultRole . "';")->fetch_assoc()["id"];

							$query = "INSERT INTO user (email, nick, password, level, api_token) VALUES('" .
								$email . "', '" .
								$username . "', '" .
								$password . "', " .
								$defaultRole . ", '" .
								$verify_token . "');";
						} else {
							$query = "INSERT INTO user (email, nick, password, api_token) VALUES('" .
								$email . "', '" .
								$username . "', '" .
								$password . "', '" .
								$verify_token . "');";
						}

						$registered = Connection::getConnection()->query($query);

						if ($registered) {

							require_once "help/mailing.php";

							$noRenderForm = true;

							if (isset($mailError)) {
								View::load("successful-registered", [
									"mail_error" => $mailError
								]);
							}
						} else {
							$error = "Se ha producido un error desconocido al registrarte.";
						}
					}
				}
				// View
				if (!isset($noRenderForm)) {
					View::load("login-and-register-form", [
						"login_email"  => (isset($_POST["login_email"]))?
											$_POST["login_email"] : "",
						"reg_email"    => (isset($_POST["reg_email"]))? $_POST["reg_email"] : "",
						"reg_username" => (isset($_POST["reg_username"]))?
											$_POST["reg_username"] : "",
						"error"        => (isset($error))? $error : ""
					]);
				}
			} else {
				header("Location: ../");
				exit;
			}
		}

		public function logout() {
			$_SESSION = [];
			session_destroy();
			header("Location: ../");
			exit;
		}

		public function profile($user = "") {
			Application::$subtitle = "profile";

			if (!empty($user)) {
				$q = "SELECT user.id, user.nick, user.email, user.last_connection, " .
					"user_role.name as role FROM user LEFT JOIN user_role " .
					"ON user.level=user_role.id WHERE user.nick='${user}';";
				$user = Connection::getConnection()
					->query($q);

				if ($user->num_rows) {
					$user = $user->fetch_assoc();
					Application::$param    = "\"" . $user["nick"] . "\"";
					View::load("profile", [
						"userId"   => $user["id"],
						"username" => $user["nick"],
						"role"     => $user["role"]
					]);
				} else {
					View::load("404");
				}
			} elseif (isset($_SESSION["user"])) {
				Application::$param    = "\"" . $_SESSION["user"] . "\"";
				$q = "SELECT user.id, user.nick, user.email, user.last_connection, " .
					"user_role.name as role FROM user LEFT JOIN user_role " .
					"ON user.level=user_role.id WHERE user.nick='${_SESSION["user"]}';";
				$user = Connection::getConnection()
					->query()->fetch_assoc();
					View::load("profile", [
						"userId"   => $user["id"],
						"username" => $user["nick"],
						"role"     => $user["role"]
					]);
			} else {
				header("Location: ./account");
				exit;
			}
		}

		public function verify($token) {
			if (isset($_SESSION["user"])) {
				header("Location: ../");
				exit;
			} else {

				$q = "SELECT id FROM user WHERE api_token = '${token}' AND verified = 0;";
				$user = Connection::getConnection()->query($q);

				if ($user && $user->num_rows) {
					$u = $user->fetch_assoc()["id"];

					$verifyQuery = "UPDATE user SET verified = 1 WHERE id = ${u};";
					$verified = Connection::getConnection()->query($verifyQuery);

					if ($verified) {
						echo "Has verificado tu cuenta de usuario.<br /><a href=\"../../home/index\">Página de inicio</a>";
					} else {
						echo "Error.";
					}
				} else {
					echo "El ususario a verificar no existe.";
				}
			}
			exit;
		}
	}
?>
