<?php


 session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '', // Adjust as needed
    'secure' => true, // Only send over HTTPS
    'httponly' => true,
    'samesite' => 'Strict' 
    ]);


    session_start();

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    try{
        $title = "admin";
        require_once __DIR__ . "/../session_utils.php";
        require_once __DIR__ . "/../db.php";
        

        if (!isset($_SESSION["user"])) {
            $_SESSION['flash_state'] = "error";
            $_SESSION['flash_message'] = "please login";
            header('Location: /login');
            exit;
        }

        if(!in_array("admin",  $_SESSION["user"]["user_role"])){
            $_SESSION['flash_state'] = "error";
            $_SESSION['flash_message'] = "user not allowed";
            header('Location: /');
            exit;
        }

        

    }catch(Exception $e){
        echo "ups..";
    }


   $title = "Home";

    require_once __DIR__."/../micro-components/_header.php";
    
echo "ok";
