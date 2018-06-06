<?php
	class PublicController {
		public function __construct() {
			View::template(null);
		}

		private function print($result) {
			header("Content-Type: application/json");
			echo json_encode($result);
			exit;
		}

		static private function grantPermission($token) {
			$q = "SELECT id FROM user WHERE api_token = '${token}';";
			$r = Connection::getConnection()->query($q);

			return ($r && $r->num_rows)? true : false;
		}

		static private function showError() {
			echo "No se han encontrado registros con las claves proporcionadas.";
			exit;
		}

		static private function showTokenError() {
			echo "El token usuario proporcionado no es válido.";
			exit;
		}

		/**
		 * forum
		 * message
		 * subforum
		 * thread
		 * user
		 */

		// TODO: calcar el método de obtener foros para sacar subforos, usuarios, hilos y mensajes

		public function forum($token, $id = 0) {
			if (isset($token) && self::grantPermission($token)) {
				if ($id == 0) {
					$q = "SELECT id, title, description FROM forum ORDER BY title;";

					$resultSet = Connection::getConnection()->query($q);

					if ($resultSet &&  $resultSet->num_rows) {
						$result = [];
						while ($r = $resultSet->fetch_assoc()) $result[] = $r;
						self::print($result);
					} else {
						self::showError();
					}
				} elseif ($id > 0) {
					$q = "SELECT id, title, description FROM forum " .
						"WHERE id = ${id} ORDER BY title;";
					
					$result = Connection::getConnection()->query($q);

					if ($result && $result->num_rows) {
						self::print($result->fetch_assoc());
					} else {
						self::showError();
					}
				} else {
					self::showError();
				}
			} else {
				self::showTokenError();
			}
		}

		public function message($token, $thread = 0) {
			if (isset($token) && self::grantPermission($token)) {
				if ($thread > 0) {
					$q = "SELECT message.id as id, message.content, message.date_created, " .
						"user.id as author_id, user.nick as user, " .
						"thread.id as thread_id, thread.title as thread " .
						"FROM message " .
						"JOIN user ON message.author = user.id " .
						"JOIN thread ON message.thread = thread.id " .
						"WHERE message.thread = ${thread} ORDER BY message.date_created;";

					$res = Connection::getConnection()->query($q);

					if ($res && $res->num_rows) {
						$result = [];
						while ($r = $res->fetch_assoc()) $result[] = $r;
						self::print($result);
					} else {
						self::showError();
					}
				} else {
					self::showError();
				}
			} else {
				self::showTokenError();
			}
		}
		
		public function subforum($token, $id = 0) {
			if (isset($token) && self::grantPermission($token)) {
				if ($id > 0) {
					$q = "SELECT subforum.id, subforum.title, subforum.description, " . 
						"forum.title as forum FROM subforum " .
						"JOIN forum ON subforum.forum = forum.id " .
						"WHERE subforum.id = ${id};";

					$result = Connection::getConnection()->query($q);

					if ($result && $result->num_rows) {
						self::print($result->fetch_assoc());
					} else {
						self::showError();
					}
				} else {
					self::showError();
				}
			} else {
				self::showTokenError();
			}
		}
		
		public function thread($token, $id = 0) {
			if (isset($token) && self::grantPermission($token)) {
				if ($id > 0) {
					$q = "SELECT thread.id, thread.title, thread.date_created, " .
						"user.id as author_id, user.nick as author, " .
						"subforum.id as subforum_id, subforum.title as subforum " .
						"FROM thread " .
						"JOIN user ON thread.creator = user.id " .
						"JOIN subforum ON thread.subforum = subforum.id " .
						"WHERE thread.id = ${id};";

					$result = Connection::getConnection()->query($q);

					if ($result && $result->num_rows) {
						self::print($result->fetch_assoc());
					} else {
						self::showError();
					}
				} else {
					self::showError();
				}
			} else {
				self::showTokenError();
			}
		}
		
		public function user($token, $id = 0) {
			if (isset($token) && self::grantPermission($token)) {
				if ($id > 0) {
					$q = "SELECT user.id, user.nick, user.reg_date, " .
						"user.last_connection, user.verified, user.active as is_valid, " .
						"user_role.name as role " .
						"FROM user " .
						"JOIN user_role ON user.level = user_role.id " .
						"WHERE user.id = ${id};";

					$result = Connection::getConnection()->query($q);

					if ($result && $result->num_rows) {
						self::print($result->fetch_assoc());
					} else {
						self::showError();
					}
				} else {
					self::showError();
				}
			} else {
				self::showTokenError();
			}
		}

	}
?>