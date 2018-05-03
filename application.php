<?php
	/**
	 * Configuración de la aplicación.
	 */
	class Application {
		
		// Información básica
		static public $tabTitle    = "forAll.io";
		static public $title       = "forAll";
		static public $subtitle    = "home";
		static public $param       = "";
		static public $description = "Build, design, develop";

		// Rutas a archivos
		public const CONTROLLER_PATH = "controllers/";
		public const LIB_PATH        = "libs/";
		public const VIEW_PATH       = "views/";
		public const TEMPLATE_PATH   = "templates/";

		// Prohibir que se instancie
		private function __construct() {}
	}
?>