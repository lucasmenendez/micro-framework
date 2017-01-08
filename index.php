<?php
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);

	session_start();
	include("app/config.php");

	function __autoload ($class) {
		$is_controller	= is_file("app/controller/$class.php");
		$is_model		= is_file("app/model/$class.php");
		$is_lib			= is_file("app/lib/$class.php");

		if ($is_controller) {
			include("app/controller/$class.php");
		} else if ($is_model) {
			include("app/model/$class.php");
		} else if ($is_lib) {
			include_once("app/lib/$class.php");
		}
	}

	$controller	= "dashboardController";
	$action		= "index";
	$temp		= new Controller;

	if ($temp->auth()) {
		if (isset($_GET['c']) && !empty($_GET['c'])) {
			$controller = sprintf("%sController", $_GET['c']);
		}
		
		if (isset($_GET['a']) && !empty($_GET['a'])) {
			$action = $_GET["a"];
		}
	} else {
		$action = "login";
	}

	if (method_exists($controller, $action)) {
		$object = new $controller;
		$object->$action();
	} else {
		$render_data = array(
			"title"	=> "Error 404",
			"info"	=> "File not found."
		);

		$temp->errorPage($render_data);
	}
