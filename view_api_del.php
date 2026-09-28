<?php
include_once 'controllers/session_control.php';
include_once 'controllers/functions.php';
include_once 'config/app.php';

$session = new session_control();
$functions = new functions();

if($_POST["log"]){
    $file = base64_decode($_POST["log"]);
    $file = preg_replace("/[^0-9\.txt]/", "", $file);
    $logfile = "log/" . $file;

    if(strlen($file) == 12 && file_exists($logfile)){
        unlink($logfile);
        echo "Log Removido";

        $datetime = date("Y-m-d H:i:s");
        $datetime_log = date("Ymd");
        $log = $datetime." - Log Removed - ".$file;
        $log .= "\n";
        file_put_contents("log/" . $datetime_log . ".txt", $log, FILE_APPEND);
    }
    else{
        echo "Arquivo de log não encontrado";
    }
}