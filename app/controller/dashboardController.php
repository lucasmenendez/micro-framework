<?php 

	class dashboardController extends Controller {

		public function index() {
			
			$render_data['title'] = "Home";
			$this->render('index', $render_data);

		}


		public function login() {

			if (isset($_POST['action']) && $_POST['action'] == "login") {

				$user = User::getByUsername($_POST['user_username']);
				extract($_POST);

				if ($user->user_username == $user_username && $user->user_password == hash("sha512", md5($user_password)) {

					$data = (object) array(
						"username" => $username,
						"expire" => time() + (60*30),
						"token" => sha1(md5($username . (time() + (60*30)) ));
					);

					setcookie("session_data", json_encode($data), time() + (60 * 30), "/");
					header("Location: index.php");
					die();
 
				} else {

					$render_data['error'] = "Username or password wrong.";
					$render_data['title'] = "Login";
					$this->render("login", $render_data);

				}

			} else {

				$render_data['title'] = "Login";
				$this->render("login", $render_data);

			}

		}

		public function profile() {

			$session = json_decode($_COOKIE['session_data']);

			if ($session->token == sha1(md5($session->username . $session->expire))) {

				if (isset($_POST['action']) && $_POST['action'] == 'update') {

					$user = User::getByUsername($session->username);

					if ($user->user_password == sha1(md5($_POST['oldpassword']))) {

						$user->user_password = sha1(md5($_POST['newpassword']));

						if ($user->update()) {
							$render_data['info'] = "User updated.";
						} else {
							$render_data['error'] = "We have a problem updating your user account.";
						}

					} else {

						$render_data['alert'] = "Wrong password, try again.";
					
					}		

				}

				$render_data['data'] = (array)$user;
				$render_data['title'] = "My profile";
				$this->render('profile', $render_data);	
			
			} else {

				header("Location: index.php?c=dashboard&a=login");
				die();

			}	

		}

		public function logout() {

			setcookie("session_data", "", time() - 3600);
			header('Location: index.php');

		}

	}