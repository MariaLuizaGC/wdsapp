<?php
include_once 'controllers/functions.php';
include_once 'controllers/model.php';
include_once 'config/app.php';

$model = new model();
$functions = new functions();

if(!isset($_SESSION["id_user_WDSApp_session"])){
    $errMsg = "Ocorreu um erro durante o cadastro. Contacte o Administrador";
    echo $errMsg;
    exit();
}

$emailpost = $_POST["email"];
$rsUser = $functions->search("clients","email",$emailpost);

if(!$emailpost){
	$error="ERR01 - Cadastro realizado com sucesso. Porém NÃO foi possível enviar o email de acesso";
	$errors=1;
	echo $error;
	exit;
}

if(!$rsUser) {
	$error="ERR02 - Cadastro realizado com sucesso. Porém NÃO foi possível enviar o email de acesso";
	$errors=1;
	echo $error;
	exit;
}

$id = $rsUser["id"];
$email  = $rsUser["email"];
$user = $rsUser["user"];


// if($rsUser["password"]){
// 	$password = $rsUser["password"];
// }else{
// 	$password = $functions->createPassword();	
// }

$salt = time()+60;
$token = $email.$salt;
$token = hash('sha256',$token);

// $qryUpdate = "UPDATE clients SET password = '".$password."' WHERE id = ".$id;
$qryUpdate = "UPDATE clients SET temporary_salt = ".$salt." WHERE id = ".$id;
$rsExec = $model->model_exec($qryUpdate);


$urlToken = _HOST_.'acesso/token/'.$token;

$corpo = '
	Olá '.$user.', 
	<br />
	<br />
	<strong>Você acaba de receber seu acesso ao WDS App.</strong>
	<br />
	<br />
	<br />
	<br />
	Acesse a url abaixo, informe seu e-mail, uma nova senha e pronto! Já poderá acessar a plataforma.
	<br />
	<br />
	<strong>Acesse agora: <a href="'.$urlToken.'" title="Acesse Agora">Seu Acesso WDS App >></a></strong>
	<br />
	<br />
	<br />
	Caso você não consiga clicar no link acima, 
	<br />
	<br />
	copie o link completo e cole na barra de endereços do seu navegador.
	<br />
	<br />
	<a href="'.$urlToken.'" title="Seu Acesso WDS App">'.$urlToken.'</a>
	<br />
	<br />
	<br />
	<br />
	<strong>Este é uma mensagem pessoal e instransferível, não compartilhe seus dados de acesso. </strong> 
	<br />
	<br />
	<br />
	<br />
	<span style="font-size:12px">
	<strong>WDS App</strong>
	<br />
	<br />
	</span>
	';



    $mailConf = $functions->getMailData();

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    $mail = new PHPMailer(true);

    $mail->IsSMTP();
    $mail->IsHTML(true);
    $mail->Host       =  $mailConf["smtphost"];
    $mail->SMTPAuth   = true;
    $mail->Username   = $mailConf["mailuser"];
    $mail->Password   = $mailConf["mailpass"];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->Timeout    = 3600;
    $mail->CharSet    = PHPMailer::CHARSET_UTF8;
    $mail->Subject    = "Seu Acesso ao WDS App - Crie uma nova senha";
    $mail->Body       = $corpo;
    $mail->setFrom($mailConf["mailuser"], $mailConf["mailfrom"]);
    $mail->addReplyTo($mailConf["mailuser"], $mailConf["mailfrom"]);
    $mail->addAddress($email);

	$enviado = $mail->Send();

	$mail->ClearAllRecipients();
	$mail->ClearAttachments();

	if($enviado){
		$qryUpdate = "UPDATE users SET email_token = 1 WHERE id = ".$id;
		$rsExec = $model->model_exec($qryUpdate);
		
		$return = "success";
	}
	else{
		$return =  "Cadastro realizado com sucesso. Porém NÃO foi possível enviar o email de acesso";
	}

    echo $return;