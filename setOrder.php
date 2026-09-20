<?php
include_once 'controllers/session_control.php';
include_once 'controllers/functions.php';
include_once 'controllers/model.php';
include_once 'controllers/header.php';
include_once 'config/app.php';

$session = new session_control();
$functions = new functions();
$model = new model();

$auth_token = "";
if($_POST["auth_token"]){$auth_token = base64_decode($_POST["auth_token"]);}
$checkAuthToken = $functions->search("users","id",$auth_token);
if(!$checkAuthToken){
    $errMsg = "Ocorreu um erro durante o cadastro. Contacte o Administrador";
    echo $errMsg;
    exit();
}

$id = "";
$cliente = "";
$vendedor = "";
$obs = "";
$act = "";

if($_POST["act"]){$act = $_POST["act"];}
if($_POST["id"]){$id = $_POST["id"];}
if($_POST["cliente"]){$cliente = $_POST["cliente"];}
if($_POST["vendedor"]){$vendedor = $_POST["vendedor"];}
if($_POST["obs"]){$obs = $_POST["obs"];}



$data = date("Y-m-d");

if($act == 'new' ) {

    if(!$cliente) $errMsg = 'Informe o Cliente';
    if(!$vendedor) $errMsg = 'Informe o Vendedor';

}else if($act == 'del' || $act == 'faturar' | $act == 'edit'){
	if(!$id) $errMsg = 'Ops! Impossível continuar. Tente novamente.';

}

if($errMsg){
	echo $errMsg;
}else{

	if($act == 'new'){

		$qry = '
			insert into orders (
            data,
			client_id,
			seller_id,
			status
			)';
		$qry .= '
			VALUES (
			"'.$data.'",
			"'.$cliente.'",
			"'.$vendedor.'",
			"Aberto"';
		$qry .= ')';
		
		$exec = $model->model_exec($qry);
		
		if(!$exec){
			$errMsg = "Ocorreu um erro durante o cadastro. Contacte o Administrador";
			echo $errMsg;
			exit();
		}else{
            $return = "1;".$exec;
        }
		
	}else if($act == 'edit'){

        if($vendedor) {
            $qry = 'update orders SET seller_id = "' . $vendedor . '" WHERE id = ' . $id;
        }else{
            $qry = 'update orders SET observacoes = "'.$obs.'" WHERE id = '.$id;
        }

        $exec = $model->model_exec($qry);

		if(!$exec){
			$errMsg = "Ocorreu um erro durante a atualização do cadastro. Contacte o Administrador";
			echo $errMsg;
			exit();
		}else{
            $return = 1;
        }
    }else if($act == 'faturar'){

        $qry = 'update orders SET status = "Faturado" WHERE id = '.$id;
        $exec = $model->model_exec($qry);

        if(!$exec){
            $errMsg = "Ocorreu um erro durante a atualização do cadastro. Contacte o Administrador";
            echo $errMsg;
            exit();
        }else{

            $order_data = $functions->search('orders','id',$id);
            $seller_data = $functions->search('users','id',$vendedor);

            $seller_fee = ($order_data["valor"]*$seller_data["fee_percent"])/100;
            $qry = '
			insert into sellers_fee (
                seller_id,
                client_id,
                order_id,
                data,
                valor
			)';
            $qry .= '
			VALUES (
			"'.$vendedor.'",
			"'.$order_data["client_id"].'",
			"'.$id.'",
			"'.$data.'",
			"'.$seller_fee.'"
			)';

            $exec = $model->model_exec($qry);

            $return = 1;
        }
	}else if($act == 'del'){

        $qry = 'update orders SET status = "Cancelado" WHERE id = '.$id;
		$exec = $model->model_exec($qry);
        $return = 1;
	}else{
        $errMsg = "Ocorreu um erro durante a atualização do cadastro. Contacte o Administrador";
        echo $errMsg;
        exit();
    }
	
	if($errMsg){
		echo $errMsg;
	}else{
		
		echo $return;
	}
	
}