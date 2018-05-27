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
