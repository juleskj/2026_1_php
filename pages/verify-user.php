<?php

    session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '', // Adjust as needed
    'secure' => true, // Only send over HTTPS
    'httponly' => true,
    'samesite' => 'Lax' // or 'Strict'
    ]);


    session_start();
    date_default_timezone_set('Europe/Copenhagen'); //makes sure its the correct time stamp
    require_once __DIR__ . "/../_.php";
    require_once __DIR__ . "/../db.php";

try{

    
    $user_email = _get_validate_user_email();
    
    $sql ="SELECT verification_token, token_expires_at, is_verified FROM `users` WHERE user_email = :email";
    $stmt = $_db->prepare( $sql );

    $stmt->bindValue(":email", $user_email);
    $stmt->execute();

    $user = $stmt->fetch();
    
    if(!$user){
        throw new Exception("no user found", 401);
    }
    // TODO:check token after sql selector?
    if($user["verification_token"] === NULL){
        throw new Exception("no email found to be verified", 400);
    }

    
    if($user && strtotime($user['token_expires_at']) > time()){
    
        $sql = "UPDATE users SET verification_token= NULL, token_expires_at= NULL, is_verified = 1 
            WHERE verification_token = :token";
        $stmt = $_db->prepare($sql);

        $stmt->bindValue(":token",$user['verification_token']);
        $stmt->execute();
        
        $_SESSION['flash_state'] = "success";
        $_SESSION['flash_message'] = "Welcome to boligsiden you can now login you your account";
        header('Location: /login');
        exit;

    } else if ($user && strtotime($user['token_expires_at']) < time()) {
       
        echo "your link has expired want to renew? <a href='/resend-verification?email=$user_email'>Click here</a> to request a new one.";
        exit;        
    } else {
        throw new Exception("no user found", 401);

    }
   

}
catch(Exception $e){
    error_log("Error: " . $e->getMessage() . " (Code: " . $e->getCode() . ")");

    $_SESSION['flash_state'] = "error";
    switch ($e->getMessage()) {
        case "no user found":
            $_SESSION['flash_message'] = "no user found";
            header('Location: /login');
            exit; 

        case "no email found to be verified":
            
            $_SESSION['flash_message'] = "there is no email found to be verified";
            header('Location: /');
            exit;

        default:
            $_SESSION['flash_message'] = "An error occurred Please try again";
            header('Location: /');
            exit;
    }

}
    
    
    


