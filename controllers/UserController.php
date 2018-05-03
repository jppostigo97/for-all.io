<?php
	class UserController {

		public function __construct() {
			Application::$subtitle = "user";
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
						->query("SELECT * FROM user WHERE email='${email}';");

					if ($result->num_rows) {
						$user = $result->fetch_assoc();
						
						if (password_verify($_POST["login_password"], $user["password"])) {
							// Contraseña coincide: login
							$_SESSION["id"]    = $user["id"];
							$_SESSION["user"]  = $user["nick"];
							$_SESSION["email"] = $user["email"];

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
						$query = "INSERT INTO user (email, nick, password) VALUES('" .
							$email . "', '" .
							$username . "', '" .
							$password . "');";
						
						$registered = Connection::getConnection()->query($query);
						
						if ($registered) {
							// TODO: mandar email de validación al usuario al registrar con éxito
							$noRenderForm = true;
							View::load("successful-registered");
						} else {
							$error = "Se ha producido un error desconocido al registrarte.";
						}
					}
				}
				// View
				if (!isset($noRenderForm)) {
					View::load("login-and-register-form", [
						"login_email" => (isset($_POST["login_email"]))? $_POST["login_email"] : "",
						"reg_email" => (isset($_POST["reg_email"]))? $_POST["reg_email"] : "",
						"reg_username" => (isset($_POST["reg_username"]))?
							$_POST["reg_username"] : "",
						"error" => (isset($error))? $error : ""
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
				$user = Connection::getConnection()
					->query("SELECT * FROM user WHERE nick='${user}';");
					
				if ($user->num_rows) {
					$user = $user->fetch_assoc();
					Application::$param    = "\"" . $user["nick"] . "\"";
					View::load("profile", [
						"username" => $user["nick"],
						"email"    => $user["email"]
					]);
				}
			} elseif (isset($_SESSION["user"])) {
				Application::$param    = "\"" . $_SESSION["user"] . "\"";
				View::load("profile", [
					"username" => $_SESSION["user"],
					"email"    => $_SESSION["email"]
				]);
			} else {
				header("Location: ./account");
				exit;
			}
		}
	}
?>