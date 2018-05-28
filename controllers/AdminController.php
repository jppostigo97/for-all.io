<?php
	class AdminController {

		public function __construct() {
			Application::$subtitle = "adminPanel";
		}

		public function index() {
			$userid = (isset($_SESSION["id"]))? $_SESSION["id"] : 0;
			$user   = Connection::getConnection()->query("SELECT * FROM user WHERE id=$userid;");
			if ($user->num_rows) {
				Application::$subtitle = "adminPanel";
				View::load("admin-panel");
			} else {
				header("Location: ..");
				exit;
			}
		}
	}
?>