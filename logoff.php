<?php
include_once 'controllers/session_control.php';
$session = new session_control();

session_destroy();
echo '1';