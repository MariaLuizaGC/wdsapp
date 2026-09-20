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
$email = "";
$level = "";
$comissao = 0;

if($_POST["act"]){$act = $_POST["act"];}

if($_POST["id"]){$id = $_POST["id"];}

if($_POST["user"]){$nome = $_POST["user"];}
if($_POST["email"]){$email = $_POST["email"];}
if($_POST["level"]){$level = $_POST["level"];}
if($_POST["comissao"]){$comissao = $_POST["comissao"];}


if($act == 'new' || $act == 'edit'){
	
	if(!$level) $errMsg = 'Informe o Nível de Acesso';
	if(!$email) $errMsg = 'Informe um E-mail';
	if(!$nome) $errMsg = 'Informe um Nome de Usuário';
	if(!$act) $errMsg = 'Ops! Impossível continuar. Tente novamente.';
	
}else if($act == 'del'){
	if(!$id) $errMsg = 'Ops! Impossível continuar. Tente novamente.';
	if($_SESSION["id_user_WDSApp_session"]==$id){
		$errMsg = 'Não é possível excluir seu próprio usuário';
	}
}else if($act == 'edit'){
	if(!$id) $errMsg = 'Ops! Impossível continuar. Tente novamente.';
}
if($errMsg){
	echo $errMsg;
}else{
	
	if($act == 'new'){

		$rsUser = $functions->search("users", "email", $email);
		
		if($rsUser){
			$errMsg = "Já existe outro usuário com este endereço de e-mail";
			echo $errMsg;
			exit();
		}
		
		
		
		$password = $functions->createPassword();
		$password = hash('sha256', md5($password));

		
		
		$qryUser = '
			insert into users (
			email,
			senha,
			level,
			user,
		    fee_percent
			)';

		$qryUser .= '
			VALUES (
			"'.$email.'",
			"'.$password.'",
			"'.$level.'",
			"'.$nome.'",
			"'.$comissao.'"
			';

		$qryUser .= ')';
		
		$execUser = $model->model_exec($qryUser);
		
		if(!$execUser){
			$errMsg = "Ocorreu um erro durante o cadastro. Contacte o Administrador";
			echo $errMsg;
			exit();
		}
		
		
		$data['email'] = $email;

		$header = Array('Content-Type: multipart/form-data');
		$url = _HOST_.'sendTokenUser.php';
		$req = curl_init();

		curl_setopt($req, CURLOPT_URL, $url);
		curl_setopt($req, CURLOPT_HTTPHEADER, $header);
		curl_setopt($req, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($req, CURLOPT_POSTFIELDS, $data);

		$result = curl_exec($req);
		curl_close($req);

        if(strlen($result) == 64){
            echo $result;
            exit();
        }else{
            $alertMsg = $result;
        }
	
	}else if($act == 'edit'){
		
		$conn = new connect();

		$qry = "SELECT * FROM users WHERE email = '".$email."'";
		$query = $conn->query($qry);
		$row = $conn->row($query);
		
		if($row > 1){
			$errMsg = "Já existe outro usuário com este endereço de e-mail";
			echo $errMsg;
			exit();
		}else if($row == 1){
			$rs = $conn->fetch_array($query);
			if($rs["id"] != $id){
				$errMsg = "Já existe outro usuário com este endereço de e-mail";
				echo $errMsg;
				exit();
			}
		}
	
		$qryUser = '
			update users SET 
			email = "'.$email.'",
			user = "'.$nome.'",
			level = "'.$level.'",
			fee_percent = "'.$comissao.'" 
			WHERE id = '.$id;
		
		$execUser = $model->model_exec($qryUser);
		
		if(!$execUser){
			$errMsg = "Ocorreu um erro durante a atualização do cadastro. Contacte o Administrador";
			echo $errMsg;
			exit();
		}

		
	
	
	}else if($act == 'del'){
		
		$qryUser = 'DELETE FROM users  WHERE id = '.$id;
		$execUser = $model->model_exec($qryUser);


	}
	
	
	if($alertMsg){
		echo $alertMsg;
	}else{
		
		echo 1;
	}

}