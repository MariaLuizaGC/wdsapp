<?php
include_once 'controllers/session_control.php';
include_once 'controllers/functions.php';
include_once 'controllers/model.php';
include_once 'controllers/header.php';
include_once 'config/app.php';

$session = new session_control();
$functions = new functions();
$model = new model();

if(!isset($_SESSION["id_user_WDSApp_session"])){
    $errMsg = "Ocorreu um erro durante o cadastro. Contacte o Administrador";
    echo $errMsg;
    exit();
}

$id = "";
$cliente = "";
$vendedor = "";
$obs = "";
$act = "";

$data_array = [];

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

		$data_array = [
			":data" 	 => $data,
			":client_id" => $cliente,
			":seller_id" => $vendedor,
			":status" 	 => "Aberto",
		];

		$qry = '
			insert into orders (
            data,
			client_id,
			seller_id,
			status
			)';
		$qry .= '
			VALUES (
			:data,
			:client_id,
			:seller_id,
			:status';
		$qry .= ')';
		
		$exec = $model->model_exec($qry, $data_array);
		
		if(!$exec){
			$errMsg = "Ocorreu um erro durante o cadastro. Contacte o Administrador";
			echo $errMsg;
			exit();
		}else{
            $return = "1;".$exec;
        }
		
	}else if($act == 'edit'){

		$data_array = [
			":seller_id" => $vendedor,
			":id" 	 	 => $id,
		];
        if($vendedor) {
            $qry = 'update orders SET seller_id = :seller_id WHERE id = :id';
        }else{
			$data_array = [
				":observacoes" => $obs,
				":id" 	 	   => $id,
			];

            $qry = 'update orders SET observacoes = :observacoes WHERE id = :id';
        }

        $exec = $model->model_exec($qry, $data_array);

		if(!$exec){
			$errMsg = "Ocorreu um erro durante a atualização do cadastro. Contacte o Administrador";
			echo $errMsg;
			exit();
		}else{
            $return = 1;
        }
    }else if($act == 'faturar'){
		$data_array = [
			":status" => "Faturado",
			":id" 	  => $id,
		];

        $qry = 'update orders SET status = :status WHERE id = :id';
        $exec = $model->model_exec($qry, $data_array);

        if(!$exec){
            $errMsg = "Ocorreu um erro durante a atualização do cadastro. Contacte o Administrador";
            echo $errMsg;
            exit();
        }else{

            $order_data = $functions->search('orders','id',$id);
            $seller_data = $functions->search('users','id',$order_data["seller_id"]);

            $seller_fee = ($order_data["valor"]*$seller_data["fee_percent"])/100;

			$data_array = [
				":seller_id" => $order_data["seller_id"],
				":client_id" => $order_data["client_id"],
				":order_id"  => $id,
				":data" 	 => $data,
				":valor" 	 => $seller_fee,
			];
			
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
			:seller_id,
			:client_id,
			:order_id,
			:data,
			:valor
			)';

            $exec = $model->model_exec($qry, $data_array);

            $return = 1;
        }
	}else if($act == 'del'){
		$data_array = [
			":status" => "Cancelado",
			":id" 	  => $id,
		];

        $qry = 'update orders SET status = :status WHERE id = :id';
		$exec = $model->model_exec($qry, $data_array);
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