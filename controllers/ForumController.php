<?php
	class ForumController {

		public function show($subforumId) {
			$subforum = Connection::getConnection()
				->query("SELECT * FROM subforum WHERE id=${subforumId};");

			if ($subforum->num_rows) {
				$subforum = $subforum->fetch_assoc();

				Application::$subtitle = "subforum";
				Application::$param    = "\"" . $subforum["title"] . "\"";

				View::load("subforum", [
					"subforum_id"    => $subforumId,
					"subforum_title" => $subforum["title"]
				]);
			} else {
				View::load("404");
			}
		}
	}
?>