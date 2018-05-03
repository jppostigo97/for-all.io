<?php
	/**
	 * Configuración de la conexión con la BBDD.
	 */
	final class Connection {

		// Configuración de la conexión
		private const DBHOST = "localhost";
		private const DBNAME = "forallio";
		private const DBUSER = "root";
		private const DBPASS = "";

		// Conexión mysqli con la BBDD
		static private $connection = null;

		/**
		 * Devolver la conexión con la BBDD.
		 * 
		 * @return mysqli Conexión con la BBDD.
		 */
		public function getConnection() {
			if (self::$connection == null) {
				self::$connection = new mysqli(self::DBHOST,
					self::DBUSER, self::DBPASS,
					self::DBNAME);
				self::$connection->set_charset("utf8");
			}

			return self::$connection;
		}
	}
?>