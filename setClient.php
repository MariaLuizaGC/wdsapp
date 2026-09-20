<?php
include_once 'controllers/session_control.php';
include_once 'controllers/functions.php';
include_once 'controllers/model.php';
include_once 'controllers/header.php';
include_once 'config/app.php';

$session = new session_control();
$functions = new functions();
$model = new model();

$act = "";
$id = "";
$nome = "";
$sobrenome = "";
$documento = "";
$telefone = "";
$email = "";
$user = "";
$password = "";
$endereco = "";
$cidade = "";
$uf = "";
$cep = "";
$pais = "";

if($_POST["act"]){$act = $_POST["act"];}
if($_POST["id"]){$id = $_POST["id"];}

if($act == 'new' || $act == 'edit'){

    if($_POST["nome"]){$nome = utf8_decode($_POST["nome"]);}
    if($_POST["sobrenome"]){$sobrenome = utf8_decode($_POST["sobrenome"]);}
    if($_POST["documento"]){$documento = utf8_decode($_POST["documento"]);}
    if($_POST["telefone"]){$telefone = preg_replace('/[^0-9-()]/','',$_POST["telefone"]);}
    if($_POST["email"]){$email = $_POST["email"];}


    if($_POST["endereco"]){$endereco = $_POST["endereco"];}
    if($_POST["cidade"]){$cidade = $_POST["cidade"];}
    if($_POST["estado"]){$uf = $_POST["estado"];}
    if($_POST["cep"]){$cep = preg_replace('/[^0-9-]/','',$_POST["cep"]);}
    if($_POST["pais"]){$pais = $_POST["pais"];}



    if(!$endereco OR !$cidade OR !$cep OR !$uf  OR !$pais ){
        $errMsg = 'Informe o Endereço Completo'.$endereco.' - '.$cidade.' - '.$cep.' - '.$uf .' - '.$pais;
    }
    if(!$telefone) $errMsg = 'Informe um Telefone';
    if(!$documento) $errMsg = 'Informe o Documento';
    if(!$nome) $errMsg = 'Informe o Nome';
    if(!$sobrenome) $errMsg = 'Informe o Sobrenome';
    if(!$email) $errMsg = 'Informe um E-mail';
    if(!$act) $errMsg = 'Ops! Impossível continuar. Tente novamente.';

}else if($act == 'del'){
    if(!$id) $errMsg = 'Ops! Impossível continuar. Tente novamente.';
}
if($errMsg){
    echo $errMsg;
}else {
    if ($act == 'new' || $act == 'edit') {
        $conn = new connect();
        $qry = "SELECT * FROM clients WHERE email = '" . $email . "' or documento = '" . $documento . "'";
        $query = $conn->query($qry);
        $seachClient = $conn->row($query);
        $rsClient = $conn->fetch_array($query);
    }
    if ($act == 'new' ) {

        if ($seachClient) {
            $errMsg = "Já existe outro cliente com este endereço de e-mail ou documento";
            echo $errMsg;
            exit();
        }


        $password = $functions->createPassword();


        $qry = '
			insert into clients (
			nome,
            sobrenome,
			documento,
			telefone,
			email,
			password,
			endereco,
			cidade,
			estado,
			cep,
			pais
			)';

        $qry .= '
			VALUES (
			"' . $nome . '",
			"' . $sobrenome . '",
			"' . $documento . '",
			"' . $telefone . '",
			"' . $email . '",
			"' . $password . '",
			"' . $endereco . '",
			"' . $cidade . '",
			"' . $uf . '",
			"' . $cep . '",
			"' . $pais . '"
			';

        $qry .= ')';


    } else if ($act == 'edit') {


        if ($seachClient > 1) {
            $errMsg = "Já existe outro cliente com este endereço de e-mail ou documento";
            echo $errMsg;
            exit();
        } else if ($seachClient == 1) {

            if ($rsClient["id"] != $id) {
                $errMsg = "Já existe outro cliente com este endereço de e-mail ou documento";
                echo $errMsg;
                exit();
            }
        }

        $qry = 'update clients SET ';

        $qry .= '
			nome = "' . $nome . '",
			sobrenome = "' . $sobrenome . '",
			documento = "' . $documento . '",
			email = "' . $email . '",
			telefone = "' . $telefone . '",
			endereco = "' . $endereco . '",
			cidade = "' . $cidade . '",
			estado = "' . $uf . '",
			cep = "' . $cep . '",
			pais = "' . $pais . '"';
        $qry .= ' WHERE id = ' . $id;

    } else if ($act == 'del') {

        $qry = 'DELETE FROM clients  WHERE id = ' . $id;

    }

    $exec = $model->model_exec($qry);
    if (!$exec) {
        $errMsg = "Ocorreu um erro durante a atualização do cadastro. Contacte o Administrador";
        echo $errMsg;
        exit();
    }

    if ($errMsg) {
        echo $errMsg;
    } else {
        echo 1;
    }
}