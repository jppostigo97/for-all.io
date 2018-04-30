<?php

	session_start();

	// --- Carga de archivos --

	require_once "application.php";
	
	require_once "connection.php"; // configuración

	require_once "View.php";
	
	require_once "Router.php"; // funcionamiento

	// --- / Carga de archivos
	
	Router::run();

?>