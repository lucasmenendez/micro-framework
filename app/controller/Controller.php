<?php 

	class Controller {

		protected function render($view, $render_data = array()) {

			if (!empty($render_data)) {

				extract($render_data);

			}

			include("app/view/header.php");
			if(isset($info)) $this->info($info);
			if(isset($alert)) $this->alert($alert);
			if(isset($error)) $this->error($error);
			include("app/view/$view.php");
			include("app/view/footer.php");

		}

		public function auth() {

			if (isset($_SESSION['token']) && !empty($_SESSION['token'])) {

				$user = User::getByUsername($_SESSION['username']);

				return $user->user_token == $_SESSION['token'];

			}

			return false;

		}

		protected function info($msg) {

			echo "<p id='message' class='info' />$msg</p>";

		}

		protected function alert($msg) {

			echo "<p id='message' class='alert' />$msg</p>";

		}

		protected function error($msg) {

			echo "<p id='message' class='error' />$msg</p>";

		}


	}