<?php
include_once 'controllers/session_control.php';
include_once 'controllers/functions.php';
include_once 'controllers/model.php';
include_once 'controllers/header.php';
include_once 'config/app.php';

$session = new session_control();
$functions = new functions();
$model = new model();

$id = "";
$produto = "";
$valor = "";

if($_POST["act"]){$act = $_POST["act"];}
if($_POST["id"]){$id = $_POST["id"];}
if($_POST["produto"]){$produto = $_POST["produto"];}
if($_POST["valor"]){$valor = $_POST["valor"];}

if($act == 'new' || $act == 'edit' ){

	if(!$produto) $errMsg = 'Informe o nome do Produto';
	if(!$valor) $errMsg = 'Informe o valor do Produto';
	
}else if($act == 'del'){
	if(!$id) $errMsg = 'Ops! Impossível continuar. Tente novamente.';

}

if($errMsg){
	echo $errMsg;
}else{
	
	if($act == 'new'){

		
		$qry = '
			insert into products ( 
			produto,
			valor
			)';
		$qry .= '
			VALUES (
			"'.$produto.'",
			"'.$valor.'"';
		$qry .= ')';
		
		$exec = $model->model_exec($qry);
		
		if(!$exec){
			$errMsg = "Ocorreu um erro durante o cadastro. Contacte o Administrador";
			echo $errMsg;
			exit();
		}
		
	}else if($act == 'edit'){
		
		$qry = '
			update products SET 
			produto = "'.$produto.'",
			valor = "'.$valor.'"
			WHERE id = '.$id;
		
		$exec = $model->model_exec($qry);
		
		if(!$exec){
			$errMsg = "Ocorreu um erro durante a atualização do cadastro. Contacte o Administrador";
			echo $errMsg;
			exit();
		}
	}else if($act == 'del'){
		$qry = 'DELETE FROM products WHERE id = '.$id;
		$exec = $model->model_exec($qry);
		
	}else{
        $errMsg = "Ocorreu um erro durante a atualização do cadastro. Contacte o Administrador";
        echo $errMsg;
        exit();
    }
	
	if($errMsg){
		echo $errMsg;
	}else{
		
		echo 1;
	}
	
}


?>