<?php

	session_start();

	// --- Carga de archivos --

	// configuraciones
	require_once "config/connection.php";
	require_once "config/web.php";
	// MVC
	require_once "View.php";
	// Funcionamiento
	require_once "Router.php";

	// --- / Carga de archivos

	Router::run();


?>