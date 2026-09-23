<?php
include_once 'controllers/session_control.php';
include_once 'controllers/functions.php';
$session = new session_control();
$functions = new functions();
$rsExec = $functions->setLog($_SESSION["id_user_WDSApp_session"], "Logoff", $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);

session_destroy();
echo '1';