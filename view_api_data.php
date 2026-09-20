<?php
include_once 'controllers/session_control.php';
include_once 'controllers/functions.php';
include_once 'config/app.php';

$session = new session_control();
$functions = new functions();

if(isset($_POST["token"]) && isset($_POST["source"])){
    $token = $_POST["token"];
    $source = $_POST["source"];
    echo $functions->getApi($token, $source);
}else{
    echo "Selecione os dados que deseja consultar.";
}