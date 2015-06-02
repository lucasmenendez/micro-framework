<?php

	class User {

		public $user_id;
		public $user_username;
		public $user_password;

		function __construct($user_id = null, $user_username = null, $user_password = null) {

			$this->user_id = $user_id;
			$this->user_username = $user_username;
			$this->user_password = $user_password;

		}

		public function create() {

			$db = new DB;
			return $db->run("INSERT INTO users (user_username, user_password, user_id) VALUES (?,?,?)", array($this->user_username, $this->user_password, $this->user_id));

		}

		public function update() {

			$db = new DB;
			return $db->run("UPDATE users SET user_password = ? WHERE user_username = ? AND user_id = ?", array($this->user_password, $this->user_username, $this->user_id));
		}

		public function delete() {

			$db = new DB;
			return $db->run("DELETE FROM users WHERE user_username = ? AND user_id = ?", array($this->user_id));
		}

		public static function getById($id) {

			$db = new DB;
			$db->run("SELECT * FROM users WHERE user_id = ?", array($id));
			
			$user = new User;
			foreach ($db->result()[0] as $attr => $value) {
				$user->$attr = $value;
			}
			
			return $user;

		}

		public static function getByUsername($username) {

			$db = new DB;
			$db->run("SELECT * FROM users WHERE user_username = ?", array($username));
			
			$user = new User;
			foreach ($db->result()[0] as $attr => $value) {
				$user->$attr = $value;
			}
			
			return $user;

		}

		public static function exist($username) {

			$db = new DB;
			$db->run("SELECT count('x') AS count FROM users WHERE user_username = ?", array($username));
			return $db->result()[0]['count'] > 0;
		}


	}