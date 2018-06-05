<?php
	class PublicController {
		public function __construct() {
			View::template(null);
		}

		private function print($result) {
			echo json_decode($result);
			exit;
		}

		private function grantPermission($token) {
			$query = "SELECT id FROM user WHERE token = '${token}';";
			
			return (Connection::getConnection()->query($q))? true : false;
		}

		private function showError() {
			echo "No se han encontrado registros con las claves proporcionadas.";
			exit;
		}

		private function showTokenError() {
			echo "El token usuario proporcionado no es válido.";
			exit;
		}
	}
?>