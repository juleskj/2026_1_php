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
           throw new Exception("no user found", 401);
        }

        if(!in_array("admin",  $_SESSION["user"]["user_role"])){
           throw new Exception("user not admin", 403);
        }

        

    }catch(Exception $e){

        error_log("Error: " . $e->getMessage() . " (Code: " . $e->getCode() . ")");


        $_SESSION['flash_state'] = "error";
        $message = $e->getMessage();
        switch (true) {
            case str_contains($message, "no user found"):
                $_SESSION['flash_message'] = "You do not have permission to access this page";
                header('Location: /login');
                exit;

            case str_contains($message, "user not admin"):
                $_SESSION['flash_message'] = "You do not have permission to access this page";
                header('Location: /');
                exit;

            default:
                $_SESSION['flash_message'] = "An error occurred Please try again";
                header('Location: /');
                exit;
        }

    }


   $title = "Home";

    require_once __DIR__."/../micro-components/_header.php";
    require_once __DIR__."/../micro-components/_footer.php";
    
echo "ok";
