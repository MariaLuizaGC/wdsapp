<?php
include_once 'controllers/functions.php';
include_once 'controllers/session_control.php';
include_once 'controllers/model.php';
include_once 'config/app.php';

$model = new model();
$session = new session_control();
$functions = new functions();


$token = $_POST["token"];
$email = $_POST["email"];
$password = $_POST["senha"];

$rsToken = $functions->checkClientToken($token, $email);

if($rsToken){

    $salt = time();
    $newPassword = hash('sha256',md5($salt . $password));

    $checkSalt = $functions->search("hashc","ref",$rsToken);

    if($checkSalt){
        $qrySalt = "UPDATE hashc SET hash = '".$salt."' WHERE id = ".$checkSalt["id"];     
    }
    else
    {
        $qrySalt = "INSERT INTO hashc (ref, hash) VALUES (".$rsToken.", '".$salt."')";        
    }

    $rsExecSalt = $model->model_exec($qrySalt);

    if($rsExecSalt)
    {
        $qryUpdate = "UPDATE clients SET password = '".$newPassword."', temporary_salt = '' WHERE id = ".$rsToken;
        $rsExec = $model->model_exec($qryUpdate);
        if ($rsExec){
            echo 1;
        }else{
            echo "Impossível criar uma nova senha. Contate o Administrador.";
        }        
    }
    else
    {
        echo "Impossível criar uma nova senha. Contate o Administrador.";
    }
}else{
    echo "Não foi possível reconhecer os dados informados.";
}