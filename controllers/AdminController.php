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

		public function validate_config() {
			$userid = (isset($_SESSION["id"]))? $_SESSION["id"] : 0;
			$user   = Connection::getConnection()->query("SELECT * FROM user WHERE id=$userid;");
			if ($user->num_rows) {
				Application::$subtitle = "adminPanel";
				if (isset($_POST["def_role"])) {
					$newDefRole = Connection::getConnection()->real_escape_string($_POST["def_role"]);
					$q = "UPDATE config SET cvalue='${newDefRole}' WHERE ckey='def_role';";

					if (Connection::getConnection()->query($q)) {
						header("Location: ../admin/index");
						exit;
					} else {
						View::template(null);
						echo "Error.";
						exit;
					}
				} else {
					View::template(null);
					echo "Error.";
					exit;
				}
			} else {
				header("Location: ..");
				exit;
			}
		}
	}
?>