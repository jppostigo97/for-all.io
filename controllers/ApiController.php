<?php
	/**
	 * APIController - API
	 */
	class ApiController {

		/**
		 * Todo lo que se dibuje desde el API no tendrá plantilla.
		 */
		public function __construct() {
			View::template(null);
		}

		/**
		 * Imprimir el parámetro (array) como un JSON.
		 *
		 * @param array $json_array Array -> JSON
		 */
		static private function print_json($json_array) {
			header("Content-Type: application/json");
			echo json_encode($json_array);
			Connection::getConnection()->close();
			exit;
		}

		public function ban_user($id) {
			$q = "SELECT * FROM user WHERE id=${id};";

			$result = [];

			if ($users = Connection::getConnection()->query($q)) {
				$user = $users->fetch_assoc();

				$newActive = ($user["active"] == 0)? 1 : 0;

				$query = "UPDATE user SET active=${newActive} WHERE id=${id};";

				if (Connection::getConnection()->query($query)) {
					$result = [
						"banned" => ($user["active"] == 0)? "false" : "true"
					];
				} else {
					$result = [
						"status" => "error",
						"error"  => "cant-modify"
					];
				}
			} else {
				$result = [
					"status" => "error",
					"error"  => "no-user"
				];
			}

			self::print_json($result);
		}

		public function users() {
			$q = "SELECT user.id, user.email, user.nick, user.reg_date, user.last_connection, " .
				"user.verified, user.active, user_role.name as role " .
				"FROM user JOIN user_role ON user.level=user_role.id;";
			
			$users = Connection::getConnection()->query($q);

			$result = [];

			if ($users) {
				while ($u = $users->fetch_assoc()) $result[] = $u;
			} else {
				$result = [
					"status" => "error",
					"error"  => "no-users"
				];
			}

			self::print_json($result);
		}

		public function create_forum() {
			$result = [];

			if (isset($_POST["title"]) && isset($_POST["description"])) {
				$t = Connection::getConnection()->real_escape_string($_POST["title"]);
				$d = Connection::getConnection()->real_escape_string($_POST["description"]);

				$q = "INSERT INTO forum (title, description) VALUES ('${t}', '${d}');";
				
				if (Connection::getConnection()->query($q)) {
					header("Location: ../admin/index#/forums");
					exit;
				} else {
					$result = [
						"status" => "error",
						"error"  => "cant-create-forum"
					];
				}
			} else {
				$result = [
					"status" => "error",
					"error"  => "no-params"
				];
			}

			self::print_json($result);
		}

		public function forums() {
			$q = "SELECT id, title, description, ordered FROM forum ORDER BY title;";

			$forums = Connection::getConnection()->query($q);

			$result = [];

			if ($forums) {
				while ($f = $forums->fetch_assoc()) $result[] = $f;
			} else {
				$result = [
					"status" => "error",
					"error"  => "no-forums"
				];
			}

			self::print_json($result);
		}

		public function edit_forum($forumId) {
			$result = [];
			$checkForumQuery = "SELECT id FROM forum WHERE id = ${forumId};";

			if (Connection::getConnection()->query($checkForumQuery)) {
				// Params
				$newTitle = (isset($_POST["title"]))?
					Connection::getConnection()->real_escape_string($_POST["title"]) : null;
				$newDescription = (isset($_POST["description"]))?
					Connection::getConnection()->real_escape_string($_POST["description"]) : null;

				$query = "UPDATE forum SET ";

				if ($newTitle != null) $query .= "title='${newTitle}'";
				if ($newTitle != null && $newDescription != null) $query .= ", ";
				if ($newDescription != null) $query .= "description='${newDescription}'";

				$query .= " WHERE id=${forumId};";

				if ($newTitle != null || $newDescription != null) {
					if (Connection::getConnection()->query($query)) {
						header("Location: ../../admin/index#/forums");
						exit;
					} else {
						$result = [
							"status" => "error",
							"error"  => "cant-edit"
						];
					}
				} else {
					$result = [
						"status" => "error",
						"erorr"  => "no-params"
					];
				}

			} else {
				$result = [
					"status" => "error",
					"error"  => "no-forum"
				];
			}
		}

		public function delete_forum($forumId) {
			$result = [];
			$checkForumQuery = "SELECT id FROM forum WHERE id = ${forumId};";

			if (Connection::getConnection()->query($checkForumQuery)) {
				$q = "DELETE FROM forum WHERE id = ${forumId};";

				if (Connection::getConnection()->query($q)) {
					$result = [
						"deleted" => "true"
					];
				} else {
					$result = [
						"status" => "error",
						"error"  => "cant-delete"
					];
				}
			} else {
				$result = [
					"status" => "error",
					"error"  => "no-forum"
				];
			}

			self::print_json($result);
		}

		public function create_subforum($forum = 0) {
			$result = [];

			if (isset($_POST["title"]) && isset($_POST["description"]) && $forum != 0) {
				$t = Connection::getConnection()->real_escape_string($_POST["title"]);
				$d = Connection::getConnection()->real_escape_string($_POST["description"]);

				$checkForumQuery = "SELECT id FROM forum WHERE id=${forum};";

				if (Connection::getConnection()->query($checkForumQuery)) {
					$q = "INSERT INTO subforum (title, description, forum) VALUES ('${t}', '${d}', ${forum});";

					if (Connection::getConnection()->query($q)) {
						header("Location: ../../admin/index#/forums");
						exit;
					} else {
						$result = [
							"status" => "error",
							"error"  => "cant-create"
						];
					}
				} else {
					$result = [
						"status" => "error",
						"error"  => "no-forum"
					];
				}
			} else {
				$result = [
					"status" => "error",
					"error"  => "no-params"
				];
			}

			self::print_json($result);
		}

		public function subforums($forum = 0) {
			$result = [];

			if ($forum != 0) {
				$q = "SELECT id, title, description, ordered FROM subforum WHERE forum=${forum} " .
					"ORDER BY title;";

				$subforums = Connection::getConnection()->query($q);

				if ($subforums) {
					while ($s = $subforums->fetch_assoc()) $result[] = $s;
				} else {
					$result = [
						"status" => "error",
						"error"  => "no-subforums"
					];
				}
			} else {
				$result = [
					"status" => "error",
					"error"  => "no-forum"
				];
			}

			self::print_json($result);
		}

		public function edit_subforum($subforumId) {
			$result = [];
			$checkSubforumQuery = "SELECT id FROM subforum WHERE id=${subforumId};";

			if (Connection::getConnection()->query($checkSubforumQuery)) {
				// Params
				$newTitle = isset($_POST["title"])?
					Connection::getConnection()->real_escape_string($_POST["title"]) : null;
				$newDescription = isset($_POST["description"])?
					Connection::getConnection()->real_escape_string($_POST["description"]) : null;

				$query = "UPDATE subforum SET ";

				if ($newTitle != null) $query .= "title = '${newTitle}'";
				if ($newTitle != null && $newDescription != null) $query .= ", ";
				if ($newDescription != null) $query .= "description = '${newDescription}'";

				$query .= " WHERE id = ${subforumId};";

				if ($newTitle != null || $newDescription != null) {
					if (Connection::getConnection()->query($query)) {
						header("Location: ../../admin/index#/forums");
						exit;
					} else {
						$result = [
							"status" => "error",
							"error"  => "cant-edit"
						];
					}
				} else {
					$result = [
						"status" => "error",
						"error"  => "no-params"
					];
				}
			} else {
				$result = [
					"status" => "error",
					"error"  => "no-subforum"
				];
			}
		}

		public function delete_subforum($subforumId) {
			$result = [];
			$checkSubforumQuery = "SELECT id FROM subforum WHERE id = ${subforumId};";

			if (Connection::getConnection()->query($checkSubforumQuery)) {
				$q = "DELETE FROM subforum WHERE id = ${subforumId};";

				if (Connection::getConnection()->query($q)) {
					$result = [
						"deleted" => "true"
					];
				} else {
					$result = [
						"status" => "error",
						"error"  => "cant-delete"
					];
				}
			} else {
				$result = [
					"status" => "error",
					"error"  => "no-subforum"
				];
			}

			self::print_json($result);
		}

		public function threads() {
			$result = [];
			
			$q = "SELECT thread.id as id, thread.title as title, " .
				"thread.date_created as creation, user.nick as author, " .
				"subforum.id as subforum, subforum.title as subforumTitle FROM thread ".
				"LEFT JOIN user ON thread.creator=user.id " .
				"LEFT JOIN subforum ON thread.subforum=subforum.id " .
				"ORDER BY creation DESC LIMIT 50;";
			
			$threads = Connection::getConnection()->query($q);

			echo Connection::getConnection()->error;

			if ($threads) {
				while ($t = $threads->fetch_assoc()) $result[] = $t;
			} else {
				$result = [
					"status" => "error",
					"error"  => "no-threads"
				];
			}
			
			self::print_json($result);
		}

		public function delete_thread($threadId) {
			$result = [];

			$q = "DELETE FROM thread WHERE id=${threadId};";

			if (Connection::getConnection()->query($q)) {
				$result = [
					"deleted" => "true"
				];
			} else {
				$result = [
					"status" => "error",
					"error"  => "cant-delete"
				];
			}

			self::print_json($result);
		}

		public function default_role() {
			$q = "SELECT cvalue FROM config WHERE ckey='def_role';";
			$default = Connection::getConnection()->query($q);

			$result = [];

			if ($default) {
				$result = [
					"value" => $default->fetch_assoc()["cvalue"]
				];
			} else {
				$result = [
					"status" => "error",
					"error"  => "no-role"
				];
			}

			self::print_json($result);
		}

		public function roles() {
			$roles = Connection::getConnection()->query("SELECT id, slug, name FROM user_role");
			$result = [];
			if ($roles) {
				while ($role = $roles->fetch_assoc()) $result[] = $role;
			} else {
				$result = ["status" => "error", "error" => "no-roles"];
			}

			self::print_json($result);
		}

		public function messages($thread, $page = 1) {
			$t = $thread + 0;
			$p = (($page - 1) * 2);

			$query = "SELECT message.content, message.date_created, user.nick FROM message " .
				"JOIN user ON message.author=user.id WHERE message.thread=" . $t .
				" LIMIT " . $p . ", 5;";

			$objects = Connection::getConnection()->query($query);
			echo Connection::getConnection()->error;
			if ($objects->num_rows) {
				$response = [];

				while ($m = $objects->fetch_assoc()) {
					$profilePicPath = "assets/img/" . $m["nick"] . ".jpg";
					$profilePic = (file_exists($profilePicPath))? "y" : "n";
					$response[] = [
						"content" => $m["content"],
						"date"    => $m["date_created"],
						"author"  => $m["nick"],
						"profile" => $profilePic
					];
				}

				self::print_json($response);
			} else {
				self::print_json(["status" => "error", "error" => "no-content"]);
			}
		}

		public function message_pages($thread) {
			$q = "SELECT COUNT(id)/5 as cantidad FROM message WHERE thread=${thread};";

			if ($a = Connection::getConnection()->query($q)) {
				$a = $a->fetch_assoc()["cantidad"];
				self::print_json(["pages" => $a]);
			} else {
				self::print_json(["status" => "error", "error" => "no-content"]);
			}
		}
	}
?>
