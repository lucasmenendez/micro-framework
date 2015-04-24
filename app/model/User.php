<?php

	class User {

		public $user_username;
		public $user_password;
		public $user_token;
		public $user_date_registered;

		function __construct($user_token = null, $user_username = null, $user_password = null, $user_date_registered = null) {

			$this->user_token = $user_token;
			$this->user_username = $user_username;
			$this->user_password = $user_password;
			$this->user_date_registered = $user_date_registered;

		}

		public function create() {

			$db = new DB;
			return $db->run("INSERT INTO users (user_username, user_password, user_token) VALUES (?,?,?)", array($this->user_username, $this->user_password, $this->user_token));

		}

		public function update() {

			$db = new DB;
			return $db->run("UPDATE users SET user_password = ? WHERE user_username = ? AND user_token = ?", array($this->user_password, $this->user_username, $this->user_token));
		}

		public function delete() {

			$db = new DB;
			return $db->run("DELETE FROM users WHERE user_username = ? AND user_token = ?", array($this->user_token));
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

		public static function getByToken($token) {

			$db = new DB;
			$db->run("SELECT * FROM users WHERE user_token = ?", array($token));
			
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