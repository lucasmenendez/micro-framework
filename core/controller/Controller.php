<?php 
	class Controller {
		private $header_view;
		private $footer_view;

		function __construct() {
			$this->header_view	= "core/view/header.php";
			$this->footer_view	= "core/view/footer.php";

			$header_view	= "app/view/header.php";
			$footer_view	= "app/view/footer.php";

			if (is_file($header_view)) {
				$this->header_view = $header_view;
			}

			if (is_file($footer_view)) {
				$this->footer_view = $footer_view;
			}
		}

		public function render($view, $render_data = array()) {
			$core_view	= sprintf("core/view/%s.php", $view);
			$view		= sprintf("app/view/%s.php", $view);

			$is_core_view	= is_file($core_view);
			$is_view		= is_file($view);

			if (!$is_core_view && !$is_view) {
				$render_data = array(
					"title"		=> "Error 404",
					"content"	=> "File not found."
				);

				$this->render("error", $render_data);
				return;
			}

			if (!empty($render_data)) {
				extract($render_data);
			}

			include($this->header_view);
			$this->catchException($render_data);
			
			if ($is_core_view) {
				include($core_view);
			} else if ($is_view) {
				include($view);
			}
			
			if (isset($injection)) $this->inject($injection);
			include($this->footer_view);
		}		

		public function currentUser() {
			if (isset($_SESSION['username'])) {
				$username = $_SESSION["username"];
				return User::getByUsername($username);
			}
			return false;
		}

		public function checkUser() {
			if (isset($_SESSION['username'])) {
				return User::exist($_SESSION["username"]);
			}
			return false;
		}

		public function contains($haystack, $needles) {
			foreach ($haystack as $key => $value) {
				$needles = (!is_array($needles)) ? array($needles) : $needles;

				foreach ($needles as $index => $needle) {
					if ($key == $needle) {
						unset($needles[$index]);
					}
				}
			
				if (is_array($value)) {
					$needles = $this->contains($value, $needles);
				}
			}

			return $needles;
		}

		public function checkArgs($haystack, $needles) {
			return count($this->contains($haystack, $needles)) == 0;
		}

		public function checkAction($action) {
			return isset($_POST["action"]) && $_POST["action"] == $action;
		}

		public function checkForm($needles) {
			$haystack = $_POST;
			return $this->checkArgs($haystack, $needles);
		}

		private function catchException($render_data = array()) {
			$data = isset($_SESSION['type']) ? null : $render_data;	

			$type		= null;
			$content	= "";

			if (is_null($data)) {
				extract($_SESSION);

				$is_type	= isset($type) && ($type == "info" || $type == "alert" || $type == "error");
				$is_content	= isset($content) && !is_null($content);

				if ($is_type && $is_content) {
					unset($_SESSION['type']);
					unset($_SESSION['content']);
				}
			} else {
				extract($data);
				if (isset($info)) {
					$type		= "info";
					$content	= $info;
				} else if (isset($alert)) {
					$type		= "alert";
					$content	= $alert;
				} else if (isset($error)) {
					$type		= "error";
					$content	= $error;
				}
			}
			
			if (!is_null($type)) {
				echo sprintf("<p id='message' class='%s' />%s</p>", $type, $content);
			}

			return;
		}

		public function redirectTo($uri, $exception = array()) {
			if (!empty($exception)) {
				$type		= isset($exception['type']) ? $exception['type'] : null;
				$content	= isset($exception['content']) ? $exception['content'] : false;
				$valid_type	= $type == "ok" || $type == "alert" || $type == "error";

				if ($valid_type && $content) {
					$_SESSION['type']		= $type;
					$_SESSION['content']	= $content;
				}
			}

			header(sprintf("Location: %s", $uri));
			die();
		}

		private function inject($injection) {
			$json		= json_encode($injection);
			$snippet	= "<script>injection = JSON.parse('%s');</script>";
			echo sprintf($snippet, $json);	
		}
	}
