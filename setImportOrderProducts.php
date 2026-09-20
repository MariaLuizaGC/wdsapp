<?php
include_once 'controllers/session_control.php';
include_once 'controllers/functions.php';
include_once 'controllers/model.php';
include_once 'controllers/header.php';
include_once 'config/app.php';

$session = new session_control();
$functions = new functions();
$model = new model();


$pedido = "";

if($_POST["pedido"]){$pedido = $_POST["pedido"];}

if(!$_FILES["file"]) $errMsg = 'Selecione um arquivo XML';
if(!$pedido) $errMsg = 'Ops! Impossível continuar. Tente novamente.';

if($errMsg){
	echo $errMsg;
}else{

    $src = "files/";
    $name = $_FILES['file']['name'];
    $temp = $_FILES['file']['tmp_name'];
    if(move_uploaded_file($temp, $src.$name)) {
        //echo 1;
    } else {
        $errMsg = "Erro, não foi possível fazer a importação ";
        echo $errMsg;
        exit();
    }

    $xml_data = simplexml_load_file($src.$name,"SimpleXMLElement",LIBXML_DTDVALID);

    if($xml_data) {

        $qry = '
        insert into order_products ( 
        order_id,
        product_id,
        quantidade,
        valor_unit,
        file
        )
        VALUES ';

        $x = null;

        foreach ($xml_data->order->produto as $item) {
            $produto = $item->id;
            $qtde = $item->quantidade;

            $produto_data = $functions->search("products", "id", $produto);
            if (!$produto_data) {
                $errMsg = 'Ops! Produto não encontrado. Produto ID: '.$produto;
                echo $errMsg;
                exit();
            }

            if ($x) $qry .= ',';

            $qry .= '
               (
                "' . $pedido . '",
                "' . $produto . '",
                "' . $qtde . '",
                "' . $produto_data["valor"] . '",
                "' . $src.$name . '"';
            $qry .= ')';
            $x++;
        }



        $exec = $model->model_exec($qry);

        if (!$exec) {
            $errMsg = "Ocorreu um erro durante o cadastro. Contacte o Administrador";
            echo $errMsg;
            exit();
        }

        $conn = new connect();

        $qry = "SELECT SUM(quantidade*valor_unit) as total FROM order_products where order_id = " . $pedido;
        $query = $conn->query($qry);
        $pedido_data = $conn->fetch_array($query);

        $qry = '
        update orders SET 
        valor = "' . $pedido_data["total"] . '"
        WHERE id = ' . $pedido;

        $exec = $model->model_exec($qry);
    }else{
        $errMsg = "Arquivo Inválido";
        echo $errMsg;
        exit();
    }

	if($errMsg){
		echo $errMsg;
	}else{
		echo 1;
	}
	
}