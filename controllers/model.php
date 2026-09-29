<?php
include_once 'config/connect.php';

class model extends connect{

	function model(){
		//contrutor
	}

	function model_exec($query, $params = null){
		
		$conn = new connect();
		if ($rs = $conn->insertData($query, $params)){
			return $rs;	
		}else{
			return false;
		}
	
	}
	
}