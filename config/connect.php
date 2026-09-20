<?php
include_once 'config.php';

class connect extends config{
	
	var $pdo;
	
	function __construct(){
		$this->pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->db, $this->user, $this->pass);	
	}

	
	function query($sql, $params = null){
		$stmt = $this->pdo->prepare($sql);

		if($params){
			foreach($params as $key => $value){
				$stmt->bindValue($key, $value);
			}
		}

		$run = $stmt->execute();
		return $stmt;
	}
	
	function fetch_array($stmt){ 
		$rs = $stmt->fetch(PDO::FETCH_ASSOC);
		return $rs;
	}

	function row($stmt){
		return $stmt->rowCount();
	}
	
	
	function fetch_all($stmt){ 
		$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rs;
	}
	
	function queryData($sql){
		$stmt = $this->pdo->prepare($sql);
		$run = $stmt->execute();
		return $run;

	}
	
	function insertData($sql){
		$stmt = $this->pdo->prepare($sql);
		$run = $stmt->execute();
		$lastID = $this->pdo->lastInsertId();
		
		if ($lastID){
			return $lastID;
		}else{
			return $run;
		}

	}
}