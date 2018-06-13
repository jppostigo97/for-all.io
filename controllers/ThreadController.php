<?php
	class ThreadController {

		public function show($thread = 0) {
			if ($thread != 0) {
				$t = Connection::getConnection()
					->query("SELECT * FROM thread WHERE id=${thread};");

				if ($t->num_rows) {
					$t = $t->fetch_assoc();
					$id    = $t["id"];
					$title = $t["title"];

					Application::$subtitle = "thread";
					Application::$param    = "\"" . $title . "\"";

					View::load("show-thread", [
						"thread" => $id,
						"title"  => $title
					]);
				} else {
					View::load("404");
				}
			} else {
				header("Location: ../");
				exit;
			}
		}

		public function new($subforum = 0) {
			if ($subforum != 0) {
				$sub = Connection::getConnection()
					->query("SELECT * FROM subforum WHERE id=${subforum};");

				if ($sub->num_rows) {
					$sub = $sub->fetch_assoc();

					Application::$subtitle = "newThread";

					View::load("write-message", [
						"thread_id"      => 0,
						"subforum_id"    => $subforum,
						"subforum_title" => $sub["title"],
						"author"         => $_SESSION["user"]
					]);
				} else {
					View::load("404");
				}
			} else {
				header("Location: ../");
				exit;
			}
		}

		public function answer($thread = 0) {
			if ($thread != 0) {
				$t = Connection::getConnection()
					->query("SELECT * FROM thread WHERE id=" .$thread . ";");

				if ($t->num_rows) {
					$t = $t->fetch_assoc();

					Application::$subtitle = "newMessage";

					View::load("write-message", [
						"thread_id"     => $thread,
						"thread_title"  => $t["title"],
						"author"        => $_SESSION["user"]
					]);
				} else {
					View::load("404");
				}
			} else {
				header("Location: ../");
				exit;
			}
		}

		public function validate() {
			if (isset($_SESSION["id"]) && !empty($_SESSION["id"])) {
				if (isset($_POST["message_content"]) && !empty($_POST["message_content"])) {
					if (isset($_POST["thread_id"]) && !empty($_POST["thread_id"])) {
						// Nuevo mensaje en hilo ya existente
						$newMessageContent = Connection::getConnection()->
							real_escape_string($_POST["message_content"]);

						$query = "INSERT INTO message (thread, content, author) VALUES (" .
							$_POST["thread_id"]
							. ", '" .
							$newMessageContent
							. "', " .
							$_SESSION["id"]
							. ");";
						if (Connection::getConnection()->query($query)) {
							header("Location: ../thread/show/" . $_POST["thread_id"]);
							exit;
						} else {
							View::load("write-message", [
								"error" => "No se ha podido mandar el mensaje.<br />" .
									"Por favor, inténtalo más tarde."
							]);
						}
					} elseif (isset($_POST["subforum"]) && !empty($_POST["subforum"]) &&
						isset($_POST["thread_title"]) && !empty($_POST["thread_title"])) {
						// Nuevo mensaje en nuevo hilo: crear hilo
						$newThreadTitle = Connection::getConnection()->real_escape_string($_POST["thread_title"]);

						$threadQuery = "INSERT INTO thread (title, creator, subforum) VALUES ('" .
							$newThreadTitle . "', " . $_SESSION["id"] . ", " .
							$_POST["subforum"] . ")";

						// Crear el hilo y obtenerlo antes de crear el mensaje
						if ($newThread = Connection::getConnection()->query($threadQuery)) {
							// Se ha podido crear el hilo: continuar creando el mensaje
							$getLastThreadQuery = "SELECT * FROM thread WHERE creator=" .
								$_SESSION["id"] . " ORDER BY ID DESC;";
							// Obtenemos este último hilo
							$newThread = Connection::getConnection()->query($getLastThreadQuery)->
								fetch_assoc()["id"];

							$messageContent = Connection::getConnection()->
								real_escape_string($_POST["message_content"]);
							// Consulta para crear el mensaje
							$messageQuery = "INSERT INTO message (thread, content, author) " .
								"VALUES (" .
								$newThread
								. ", '" .
								$messageContent
								. "', " .
								$_SESSION["id"]
								. ")";

							if ($newMessage = Connection::getConnection()->query($messageQuery)) {
								// Redirigir al nuevo mensaje
								header("Location: ../thread/show/" . $newThread);
								exit;
							} else {
								View::load("write-message", [
									"error" => "Se ha producido un error inesperado.<br />" .
										"Por favor, inténtalo más tarde."
								]);
							}
						} else {
							View::load("write-message", [
								"error" => "No se ha podido crear el hilo de conversación.<br />" .
									"Por favor, vuelve a intentarlo más tarde."
							]);
						}
					} else {
						View::load("write-message", [
							"error" => /*"Esto no debería ocurrir.<br />" .
								"Por favor, contacta con el administrador y dile que aumente la seguridad del portal."*/
								var_dump($_POST)
						]);
					}
				} else {
					View::load("write-message", [
						"error" => "El contenido del mensaje no puede estar vacío."
					]);
				}
			} else {
				View::load("404");
			}
		}
	}
?>
