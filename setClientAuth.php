<?php
include_once 'controllers/session_control.php';
include_once 'controllers/functions.php';
include_once 'config/app.php';

$session = new session_control();
$functions = new functions();

$user = $_POST["user"];
$password = $_POST["senha"];

$session->setSession('client_WDSApp_session', $user);

$user_data = $functions->clientAuth($user , $password);

if($user_data != ''){
    $session->setSession('id_client_WDSApp_session', $user_data["id"]);
    $session->setSession('nome_client_WDSApp_session', $user_data["nome"]);

    echo 1;

} else {
    echo ("Email ou senha incorretos");
}