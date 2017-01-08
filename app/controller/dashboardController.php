<?php 

	class dashboardController extends Controller {
		public function index() {
			$render_data['title'] = "Home";
			$this->render('index', $render_data);
		}

		public function login() {
			$render_data = array(
				"title"	=> "Login"
			);

			if (isset($_POST['action']) && $_POST['action'] == "login") {
				extract($_POST);
				$render_data['error'] = "Wrong username. User not found.";
				
				if (User::exist($username)) {
					$user = User::getByUsername($username);
					if ($user->password == hash("sha256", $password)) {
						$_SESSION["username"] = $username;

						header("Location: index.php");
						die();
					} else {
						$render_data['error'] = "Wrong password. Access denied.";
					}
				}
			}
			
			$this->render("login", $render_data);
		}

		public function profile() {
			$username	= $_SESSION['username'];
			$user		= User::getByUsername($username);

			if (isset($_POST['action']) && $_POST['action'] == 'update') {
				if (isset($_POST['oldpassword']) && isset($_POST['newpassword'])) {	
					extract($_POST);

					if ($user->password == hash('sha256', $_POST['oldpassword'])) {
						$user->password = hash('sha256', $_POST['newpassword']);

						if ($user->update()) {
							$render_data['info'] = "User updated.";
						} else {
							$render_data['error'] = "We have a problem updating your user account.";
						}
					} else {
						$render_data['alert'] = "Wrong password, try again.";
					}
				} else {
					$render_data['alert'] = "Both passwords required.";
				}
			}

			$render_data['data'] = (array)$user;
			$render_data['title'] = "My profile";

			$this->render('profile', $render_data);	
		}

		public function logout() {
			unset($_COOKIE['session_data']);
			setcookie("session_data", null, (time() - 3600), "/");
			session_destroy();
			header('Location: index.php');
		}
	}
