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

		// Instancia
		static private $instance = null;
		
		// Conexión mysqli con la BBDD
		private $connection;

		// Singleton
		private function __constructor() {
			$this->connection = new mysqli(self::DBHOST,
				self::DBUSER, self::DBPASS,
				self::DBNAME);
			$this->connection->set_charset("utf8");
		}

		/**
		 * Devolver la instancia de la conexión. Crearla si es necesario.
		 * 
		 * @return Connection Conexión.
		 */
		public function getInstance() {
			if (self::$instance == null) self::$instance = new Connection();

			return self::$instance;
		}

		/**
		 * Devuelve la conexión con la BBDD en forma de objeto mysqli.
		 * 
		 * @return mysqli  Conexión con la BBDD.
		 * @return boolean *false* si no se ha instanciado.
		 */
		public function getConnection() {
			if (self::$instance != null) return $this->connection;

			return false;
		}
	}
?>