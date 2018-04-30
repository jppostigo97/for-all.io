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
		
		/** Nombre del controlador */
		static public $controller = "Home";
		/** Nombre de la acción */
		static public $action     = "index";
		/** Parámetros */
		static public $params     = [];

		/**
		 * Parsear la ruta y obtener la información necesaria de la misma.
		 * 
		 * @return true Si la acción se ha realizado correctamente.
		 * @return null Si no hay parámetros en la URL.
		 */
		static public function parseUrl() {
			if (isset($_GET["url"])) {
				// Obtener el array de la ruta
				$routeArray = explode("/", $_GET["url"]);

				// Obtener el controlador en base a la URL
				if (count($routeArray) > 0) {
					// Información sobre el controlador
					$controllerName  = ucfirst(strtolower($routeArray[0]));
					$controllerClass = $controllerName . "Controller";
					$controllerFile  = Application::CONTROLLER_PATH . $controllerClass . ".php";

					// Buscar e incluir el archivo del controlador
					if (file_exists($controllerFile)) {
						require_once $controller_file;
						if (class_exists($controllerClass)) {
							// Guardar el controlador y liberar espacio
							self::$controller = $controllerName;
							unset($routeArray[0]);

							// Obtener la acción en base a la URL
							if (count($routeArray) > 0) {
								// Guardar la acción y liberar espacio
								self::$action = strtolower($routeArray[0]);
								unset($routeArray[0]);

								// Comprobar que la acción existe y puede ser llamada o lanzar errores en caso contrario
								if (method_exists($controllerClass, self::$action)) {
									if (is_callable([$controllerClass, self::$action])) {
										// Obtener los parámetros en base a la URL
										if (count($routeArray) > 0) {
											foreach ($routeArray as $param)
												self::$params[] = $param;
										}
									} else {
										// No es posible realizar la acción
										throw new BadActionScopeException(self::$action, $controllerName);
									}
								} else {
									// No se ha encontrado la acción
									throw new MissingActionException(self::$action, $controllerName);
								}
							}
						} else {
							// No se ha encontrado el controlador
							throw new MissingControllerException($controllerName);
						}
					} else {
						// No se ha encontrado el archivo del controlador
						throw new MissingControllerException($controllerName . "(FILE)");
					}
				}
				return true; // Todo ha ido correctamente
			} else {
				// No hay ruta alguna
				return null;
			}
		}

		/**
		 * Ejecuta la acción.
		 */
		static public function run() {
			$controllerClass = self::$controller . "Controller";
			
			try {
				require_once Application::CONTROLLER_PATH . $controllerClass . ".php";
				$controllerInstance = new $controllerClass;
			} catch(Exception $e) {
				throw new MissingControllerException(self::$controller);
			}
			
			$actionArray = [$controllerInstance, self::$action];

			try {
				// Realizar la acción...
				if (self::$params == [])
					call_user_func_array($actionArray, self::$params); // ... con parámetros
				else
					call_user_func($actionArray); // ... sin parámetros

				View::render();
			} catch(Exception $e) {
				throw new BadActionScopeException(self::$action, self::$controller);
			}
		}
	}
?>