<?php
include_once 'controllers/session_control.php';
include_once 'controllers/functions.php';
include_once 'controllers/model.php';
include_once 'controllers/header.php';
include_once 'config/app.php';

$session = new session_control();
$functions = new functions();
$model = new model();

$produto = "";
$pedido = "";
$id = "";
$act = "";

if($_POST["produto"]){$produto = $_POST["produto"];}
if($_POST["qtde"]){$qtde = $_POST["qtde"];}
if($_POST["pedido"]){$pedido = $_POST["pedido"];}
if($_POST["id"]){$id = $_POST["id"];}
if($_POST["act"]){$act = $_POST["act"];}


if($act == 'new'){

    if(!$qtde) $qtde = 1;
	if(!$produto) $errMsg = 'Selecione um Produto';
    if(!$pedido) $errMsg = 'Ops! Impossível continuar. Tente novamente.';

}else if($act == 'del'){
	if(!$id) $errMsg = 'Ops! Impossível continuar. Tente novamente.';
}

if($errMsg){
	echo $errMsg;
}else{
	
	if($act == 'new'){

        $produto_data = $functions->search("products","id",$produto);
        if(!$produto_data){
            $errMsg = 'Ops! Produto não encontrado.';
            echo $errMsg;
            exit();
        }
		
		$qry = '
			insert into order_products ( 
            order_id,
			product_id,
            quantidade,
			valor_unit  
			)';
		$qry .= '
			VALUES (
			"'.$pedido.'",
			"'.$produto.'",
			"'.$qtde.'",
			"'.$produto_data["valor"].'"';
		$qry .= ')';
		
		$exec = $model->model_exec($qry);
		
		if(!$exec){
			$errMsg = "Ocorreu um erro durante o cadastro. Contacte o Administrador";
			echo $errMsg;
			exit();
		}

        $conn = new connect();

        $qry = "SELECT SUM(quantidade*valor_unit) as total FROM order_products where order_id = ".$pedido;
        $query = $conn->query($qry);
        $pedido_data = $conn->fetch_array($query);

        if(!$pedido_data["total"]){
            $pedido_data["total"] = 0;
        }

        $qry = '
			update orders SET 
			valor = '.$pedido_data["total"].'
			WHERE id = '.$pedido;

        $exec = $model->model_exec($qry);

		
	}else if($act == 'del'){

        $produto_data = $functions->search("order_products","id",$id);
        $pedido = $produto_data["order_id"];

		$qry = 'DELETE FROM order_products WHERE id = '.$id;
		$exec = $model->model_exec($qry);

        $conn = new connect();

        $qry = "SELECT SUM(quantidade*valor_unit) as total FROM order_products where order_id = ".$pedido;
        $query = $conn->query($qry);
        $pedido_data = $conn->fetch_array($query);

        $qry = '
			update orders SET 
			valor = "'.$pedido_data["total"].'"
			WHERE id = '.$pedido;

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