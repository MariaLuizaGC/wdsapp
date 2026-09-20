<?php
include_once 'controllers/session_control.php';
include_once 'controllers/functions.php';
include_once 'config/app.php';

$session = new session_control();
$functions = new functions();

if($_POST["log"]){
    $file = json_decode(base64_decode($_POST["log"]));
    $exc = system("rm ".$file->logfile);
    if(!$exc){
        echo "Log Removido";
    }else{
        echo $exc;
    }
    $datetime = date("Y-m-d H:i:s");
    $datetime_log = date("Ymd");
    $log = $datetime." - Log Removed - ".$file->logfile;
    $log .= "\n";
    file_put_contents("log/" . $datetime_log . ".txt", $log, FILE_APPEND);
}