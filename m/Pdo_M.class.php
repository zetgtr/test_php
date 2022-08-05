<?php

	class Pdo_M {
		private static $instance;
		private $db;
		
		public static function Instance(){
			if(self::$instance == null){
				self::$instance = new self();
			}
			return self::$instance;
		}

        public function __construct(){
			setlocale(LC_ALL, 'ru_RU.UTF8');	
			$this->db = new PDO(DB_DRIVER.':host=' .DB_SERVER . ';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
			$this->db->exec('SET NAMES UTF8');
			$this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		}

		public function select($query){
			$q = $this->db->prepare($query);
			$q->execute();
				
			if($q->errorCode() != PDO::ERR_NONE){
				$info = $q->errorInfo();
				die($info[2]); 
			}		
			return $q->fetchAll();
		} 
		
		public function insert($table , $object){
			$columns = array();
				
			foreach ($object as $key => $value) {
				$columns[] = $key;
				$masks[] = "'$value'";
				
				if ($value === null) {
					$object[$key] = 'NULL';
				}
			}
			
			$columns_s = implode(',', $columns);
			$masks_s = implode(',', $masks);
				
			$query = "INSERT INTO $table ($columns_s) VALUES ($masks_s)";

			$q = $this -> db -> prepare($query);
			$q->execute();
				
			if ($q -> errorCode() != PDO::ERR_NONE) {
				$info = $q -> errorInfo();
				die($info[2]);
			}
				
			return $this -> db -> lastInsertId();		
		}
	}