<?php 
include_once 'controllers/session_control.php';
include_once 'controllers/functions.php';
include_once 'config/app.php';

$session = new session_control();
$functions = new functions();

$user = $_POST["user"];
$password = $_POST["senha"];

$session->setSession('user_WDSApp_session', $user);

$user_data = $functions->authUser($user , $password);

if($user_data != ''){
    $session->setSession('id_user_WDSApp_session', $user_data["id"]);
    $session->setSession('nome_user_WDSApp_session', $user_data["user"]);

    date_default_timezone_set('America/Sao_Paulo');

    echo '1';

} else {
    echo ("Email ou senha incorretos");
}