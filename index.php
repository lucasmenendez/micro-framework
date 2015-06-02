<?php

	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);

	session_start();
	include("app/config.php");

	function __autoload($class){

		if (is_file("app/controller/$class.php")){

			include("app/controller/$class.php");

		} else if (is_file("app/model/$class.php")) {

			include("app/model/$class.php");

		}

	}

	$temp = new Controller;

	if ($temp->auth()) {

		$controller = (isset($_GET['c']) && !empty($_GET['c'])) ? $_GET['c'] . "Controller" : "dashboardController";
		$action = (isset($_GET['a']) && !empty($_GET['a'])) ? $_GET['a'] : "index";

	} else {

		$controller = "dashboardController";
		$action = "login";

	}

	if (method_exists($controller, $action)) {
			
		$object = new $controller;
		$object->$action();

	} else {

		$temp->error("Error 404. File not found.");

	}
