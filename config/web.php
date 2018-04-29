<?php
	/**
	 * Configuración de la aplicación web.
	 */
	final class Web {
		
		// Información básica
		static public $title       = "forAll.io";
		static public $description = "Build, design, develop";

		// Rutas a archivos
		public const CONTROLLER_PATH = "controllers/";
		public const LIB_PATH        = "libs/";
		public const MODEL_PATH      = "models/";
		public const VIEW_PATH       = "views/";
		public const TEMPLATE_PATH   = "templates/";

		// Prohibir que se instancie
		private function __construct() {}
	}
?>