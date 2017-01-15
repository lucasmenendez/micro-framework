<?php 
	class Controller {
		public function render($view, $render_data = array()) {
			if (!empty($render_data)) {
				extract($render_data);
			}

			include("app/view/header.php");
			$this->catchException($render_data);
			include("app/view/$view.php");
			if (isset($injection)) $this->inject($injection);
			include("app/view/footer.php");
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

		public function checkAction($action) {
			return isset($_POST["action"]) && $_POST["action"] == $action;
		}

		public function checkArgs($haystack, $needles) {
			if (!is_array($needles)) $needles = array($needles);

			foreach ($needles as $needle) {
				$found = false;
				foreach ($haystack as $key => $value) {
					if ($needle == $key) {
						$found = (!is_null($value) && $value != "");
						break;
					}
				}

				if (!$found) {
					return false;
				}
			}

			return true;
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
