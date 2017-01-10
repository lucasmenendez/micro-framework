<?php
	class User {
		public $id;
		public $username;
		public $password;
		public $admin;
		
		private $db;
		function __construct($id = null, $username = null, $password = null, $admin = null) {
			$this->id = $id;
			$this->username = $username;
			$this->password = $password;
			$this->admin	= $admin;
	
			$this->db = new DB();
		}

		public function create() {
			return $this->db->run("INSERT INTO users (username, password, admin) VALUES (?,?,?)", array($this->username, $this->password, $this->admin));
		}

		public function update() {
			return $this->db->run("UPDATE users SET password = ?, admin = ? WHERE username = ? AND id = ?", array($this->password, $this->admin, $this->username, $this->id));
		}

		public function delete() {
			return $this->db->run("DELETE FROM users WHERE username = ? AND id = ?", array($this->id));
		}

		public static function getById($id) {
			$db = new DB();
			$db->run("SELECT * FROM users WHERE id = ?", array($id));
			
			$user = new User;
			foreach ($db->result()[0] as $attr => $value) {
				$user->$attr = $value;
			}
			return $user;
		}

		public static function getByUsername($username) {
			$db = new DB();
			$db->run("SELECT * FROM users WHERE username = ?", array($username));
			
			$user = new User;
			foreach ($db->result()[0] as $attr => $value) {
				$user->$attr = $value;
			}
			return $user;
		}

		public static function exist($username) {
			$db = new DB();
			$db->run("SELECT count('x') AS count FROM users WHERE username = ?", array($username));
			return $db->result()[0]['count'] > 0;
		}
	}
