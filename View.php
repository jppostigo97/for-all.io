<?php
	/**
	 * Excepción: Archivo de vista no encontrado (plantilla o parcial)
	 */
	class ViewFileNotFoundException extends Exception {

		public function __construct($file) {
			parent::__construct("No se ha podido encontrar el archivo de vista ${file}");
		}
	}

	/**
	 * Clase View
	 * Gestiona y procesa plantillas y renders
	 */
	final class View {

		/** Plantilla a utilizar */
		static private $template = "";
		/** Lista de archivos a utilizar */
		static private $files    = [];
		/** Lista de parámetros para cada archivo */
		static private $params   = [];

		/**
		 * Utilizar una plantilla.
		 * 
		 * @param string $newTemplate Plantilla a utilizar.
		 */
		static public function template($newTemplate) {
			// Componer el nombre y la ruta de la plantilla
			$fileName     = strtolower($newTemplate);
			$fullFileName = Web::TEMPLATE_PATH . $fileName . ".php";

			// Comprobar la existencia de la plantilla y gestionarla
			if (file_exists($fullFileName))
				self::$template = $newTemplate;
			else
				throw new ViewFileNotFoundException($fileName);
		}

		/**
		 * Añade una nueva vista a la cola de renderizado.
		 * 
		 * @param string $newFile Nueva vista a renderizar.
		 * @param array $params   Parámetros de la vista.
		 */
		static public function load($newFile, $params = []) {
			// Componer el nombre y la ruta de la vista
			$fileName     = strtolower($newFile);
			$fullFileName = Web::VIEW_PATH . $fileName . ".php";

			// Comprobar la existencia de la plantilla y gestionarla
			if (file_exists($fullFileName)) {
				self::$files[] = $fullFileName;

				// Gestionar los parámetros de la vista
				if ($params != []) self::$params[$fullFileName] = $params;
			} else {
				throw new ViewFileNotFoundException($fileName);
			}
		}

		/**
		 * Renderiza la plantilla y las vistas en cola.
		 */
		static public function render() {
			// Contenido
			$pageContent = "";
			$viewContent = "";
			
			// Cargar la plantilla
			ob_start();
			require_once self::$template;
			$pageContent = ob_get_flush();
			ob_end_clean();

			// Cargar el contenido de cada vista
			foreach (self::$files as $view) {
				// Cargar los parámetros de la vista
				foreach (self::$params[$view] as $param => $value)
					$$param = $value;
				
				// Cargar el contenido de la vista
				ob_start();
				require_once $view;
				$currentViewContent = ob_get_flush();
				ob_end_clean();

				// Sustituir el contenido de los parámetros de la vista
				foreach (self::$params[$view] as $param => $value) {
					str_replace("[[" . $param . "]]",   $value, $currentViewContent);
					str_replace("[[ " . $param . " ]]", $value, $currentViewContent);
				}

				$viewContent .= $currentViewContent;
			}

			str_replace("[[forallio-content]]",   $viewContent, $pageContent);
			str_replace("[[ forallio-content ]]", $viewContent, $pageContent);

			echo $pageContent;
		}
	}
?>