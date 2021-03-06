<?php
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);

	session_start();
	include("app/config.php");

	spl_autoload_register(function ($class) {
		$is_core_controller	= is_file("core/controller/$class.php");
		$is_controller		= is_file("app/controller/$class.php");

		$is_core_model	= is_file("core/model/$class.php");
		$is_model		= is_file("app/model/$class.php");
		
		$is_core_lib	= is_file("core/lib/$class.php");
		$is_lib			= is_file("app/lib/$class.php");

		if ($is_core_controller) {
			include("core/controller/$class.php");
		} else if ($is_controller) {
			include("app/controller/$class.php");
		} else if ($is_core_model) {
			include("core/model/$class.php");
		} else if ($is_model) {
			include("app/model/$class.php");
		} else if ($is_core_lib) {
			include_once("core/lib/$class.php");
		} else if ($is_lib) {
			include_once("app/lib/$class.php");
		}
	});

	$controller	= "dashboardController";
	$action		= "index";
	$temp		= new Controller;

	if ($temp->checkUser()) {
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
			"title"		=> "Error 404",
			"content"	=> "File not found."
		);

		$temp->render("error", $render_data);
	}
