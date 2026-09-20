<?php
ob_start();
date_default_timezone_set('America/Sao_Paulo');
error_reporting(0);
class session_control{

    function session_control(){
		
        $session_name = 'SEC_WDSAPP';
        $lifetime = 3600; // 1h
        $path = '/';
        $domain = $_SERVER['SERVER_NAME'];
        $secure = true;
        $httponly = true;

        session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
        session_name($session_name);

        session_start();

        $_SESSION["session_time"] = 1800;

        if($_SESSION["log_session_time"]){
            $session_time = time() - $_SESSION["log_session_time"];
            if($session_time > $_SESSION["session_time"]){
                session_destroy();
            }
            else{
                $_SESSION["log_session_time"] = time();
            }
        }
        else{
            $_SESSION["log_session_time"] = time();
        }


	}

	function __construct(){
		session_start();

		$_SESSION["session_time"] = 30;

		if($_SESSION["log_session_time"]){
			$session_time = time() - $_SESSION["log_session_time"];
			if($session_time > $_SESSION["session_time"]){
				session_destroy();
			}
			else{
				$_SESSION["log_session_time"] = time();
			}
		}
		else{
			$_SESSION["log_session_time"] = time();
		}

	}

	function setSession($vars,$val){
		$_SESSION[$vars] = $val;
	}
	
	function getSession($var){
		return $_SESSION[$var];
	}

}