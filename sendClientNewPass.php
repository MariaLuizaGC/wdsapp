<?php
include_once 'controllers/functions.php';
include_once 'controllers/model.php';
include_once 'config/app.php';

$model = new model();
$functions = new functions();

$emailpost = $_POST["email"];
$rsUser = $functions->search("clients","email",$emailpost);

if(!$emailpost){
	$error="Informe um endereço de e-mail para continuar";
	$errors=1;
	echo $error;
	exit;
}

if(!$rsUser) {
	$error="Não encontramos seu cadastro. Impossível solicitar uma nova senha.";
	$errors=1;
	echo $error;
	exit;
}

	
$email  = $rsUser["email"];
$user = $rsUser["nome"];
$id = $rsUser["id"];

if($rsUser["password"]){
	$password = $rsUser["password"];
}else{
	$password = $functions->createPassword();
	$password = hash('sha256',$password);
	$newPassword = 1;
}

$salt = time()+60;
$token = $email.$salt;
$token = hash('sha256',$token);

$qryUpdate = "UPDATE clients SET password = '".$password."', temporary_salt = '".$salt."' WHERE id = ".$id;
$rsExec = $model->model_exec($qryUpdate);
	

$urlToken = _HOST_.'acesso/token/'.$token;

$corpo = '
	Olá '.$user.', 
	<br />
	<br />
	<strong>Esta é uma solicitação para criar um senha de acesso ao seu painel do WDS App.</strong>
	<br />
	<br />
	<br />
	<br />
	Acesse a url abaixo, informe seu e-mail de cadastro, uma nova senha e pronto! Já poderá acessar a plataforma.
	<br />
	<br />
	<strong>Clique agora e crie sua senha: <a href="'.$urlToken.'" title="Gerar uma nova senha">Gerar uma nova senha >></a></strong>
	<br />
	<br />
	<br />
	Caso você não consiga clicar no link acima, 
	<br />
	<br />
	copie o link completo e cole na barra de endereços do seu navegador.
	<br />
	<br />
	<a href="'.$urlToken.'" title="Gerar uma nova senha">'.$urlToken.'</a>
	<br />
	<br />
	<br />
	<br />
	<strong>Caso você não tenha solicitado alterações no seu cadastro, sugerimos que altere a senha do seu endereço de e-mail e da sua conta no WDS App. </strong> <a href="'._HOST_.'" target="_blank">'._HOST_.'</a>

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
    $mail->Timeout = 3600;
    $mail->CharSet    = PHPMailer::CHARSET_UTF8;
    $mail->Subject  = "Seu Acesso ao WDS App - Crie uma nova senha";
    $mail->Body       = $corpo;
    $mail->setFrom($mailConf["mailuser"], $mailConf["mailfrom"]);
    $mail->addReplyTo($mailConf["mailuser"], $mailConf["mailfrom"]);
    $mail->addAddress($email);

	$enviado = $mail->send();

	$mail->ClearAllRecipients();
	$mail->ClearAttachments();

	if($enviado){
		$return  = "success";
	}else{
		$return  =  "Não foi possível enviar o token de acesso. Contate o Administrador";
	}
    
    echo utf8_decode($return);
