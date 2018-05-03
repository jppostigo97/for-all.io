<?php
	class ThreadController {

		public function new($subforum = 0) {
			if ($subforum != 0) {
				$sub = Connection::getConnection()
					->query("SELECT * FROM subforum WHERE id=${subforum};");

				if ($sub->num_rows) {
					$sub = $sub->fetch_assoc();

					Application::$subtitle = "newThread";

					View::load("write-message", [
						"thread"         => 0,
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
	}
?>