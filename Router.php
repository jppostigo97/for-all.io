<?php
	/**
	 * Excepción básica para el routing.
	 */
	class RouterException extends Exception {

		public function __construct($msg) {
			parent::__construct($msg);
		}
	}

	/**
	 * No se ha encontrado el controlador indicado.
	 */
	class MissingControllerException extends RouterException {

		public function __construct($controller) {
			parent::__construct("No se ha encontrado el controlador <b>${controller}</b>.");
		}
	}

	/**
	 * No se ha encontrado el método (acción).
	 */
	class MissingActionException extends RouterException {

		public function __construct($action, $controller) {
			parent::__construct("No se ha encontrado la acción <b>${action}</b> para el controlador <b>${controller}</b>.");
		}
	}

	/**
	 * La acción no puede ser realizada (probablemente debido a un mal alcance del método).
	 */
	class BadActionScopeException extends RouterException {

		public function __construct($action, $controller) {
			parent::__construct("No es posible realizar la acción <b>${action}</b> del controlador <b>${controller}</b>.");
		}
	}

	/**
	 * Enrutador.
	 */
	final class Router {
		
		// Controlador y acción por defecto
		static private $DEFAULT_CONTROLLER = "Home";
		static private $DEFAULT_ACTION     = "index";

		/** Nombre del controlador */
		static public $controller = "";
		/** Nombre de la acción */
		static public $action = "";
		/** Parámetros */
		static public $params = [];
		/** Ruta base */
		static public $base = ".";

		/**
		 * Parsear la ruta y obtener la información necesaria de la misma.
		 * 
		 * @return null Si no hay parámetros en la URL.
		 */
		static public function parseUrl() {
			if (isset($_GET["url"])) {
				// Obtener el array de la ruta
				$routeArray = explode("/", filter_var(rtrim($_GET['url'], "/"), FILTER_SANITIZE_URL));
				// Obtener el controlador en base a la URL
				if (count($routeArray) > 0) {
					// Información sobre el controlador
					$controllerName  = ucfirst(strtolower($routeArray[0]));
					$controllerClass = $controllerName . "Controller";
					$controllerFile  = Application::CONTROLLER_PATH . $controllerClass . ".php";
					// Buscar e incluir el archivo del controlador
					if (file_exists($controllerFile)) {
						// Guardar el controlador
						require_once $controllerFile;
						self::$controller = $controllerClass;
						// Obtener la acción en base a la URL
						if (count($routeArray) > 1) {
							// Guardar la acción y cambiar la base de la URL
							self::$action = strtolower($routeArray[1]);
							self::$base .= ".";

							// Obtener los parámetros en base a la URL
							if (count($routeArray) > 2) {
								unset($routeArray[0]);
								unset($routeArray[1]);

								// Guardar los parámetros y cambiar la base de la URL
								foreach ($routeArray as $param) {
									self::$params[] = $param;
									self::$base .= "/..";
								}
							}
						}
					}
				}
			} else {
				// No hay ruta alguna
				return null;
			}
		}

		/**
		 * Ejecuta la acción.
		 */
		static public function run() {

			// Actualizar la última conexión del usuario autenticado
			if (isset($_SESSION["id"]) && !empty($_SESSION["id"])) {
				$id = $_SESSION["id"];
				$q = "UPDATE user SET last_connection = CURRENT_TIMESTAMP WHERE id = ${id};";

				$updatedLastConnection = Connection::getConnection()->query($q);
			}

			$actionArray = [self::$controller, self::$action];
			
			if (!empty(self::$controller) &&
				method_exists(self::$controller, self::$action) && is_callable($actionArray)) {

				if (!empty(self::$params)) call_user_func_array($actionArray, self::$params);
				else call_user_func($actionArray);

			} else {

				$controllerClass = self::$DEFAULT_CONTROLLER . "Controller";
				require_once Application::CONTROLLER_PATH . $controllerClass . ".php";

				call_user_func([new $controllerClass(), self::$DEFAULT_ACTION]);
			}
		}
	}
?>