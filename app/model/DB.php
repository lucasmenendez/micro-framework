<?php 
	
	class DB{

		private $host;
		private $table;
		private $user;
		private $pass;
		
		private $connection;
		private $query;

		function __construct() {

			$this->host = DB_HOST;
			$this->user = DB_USER;
			$this->pass = DB_PASS;
			$this->table = DB_TABLE;
			$this->connection = new PDO("mysql:dbname=".$this->table."; host=".$this->host, $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

		}


		public function run($q, $data = array()) {

			$this->query = $this->connection->prepare($q);
				
			try{
				return $this->query->execute($data);
			} catch (PDOException $e) {
				print_r($e);
				return false;
			}

		}

		public function result() {

			return $this->query->fetchAll(PDO::FETCH_ASSOC);

		}

		public function count() {

			return $this->query->rowCount();

		}

		public function lastID() {

			return $this->connection->lastInsertId();

		}

	}