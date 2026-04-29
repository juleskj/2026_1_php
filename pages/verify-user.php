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

    $user_email = $_GET["email"] ?? "";
    // TODO: validate email wtf????
    // TODO:get is_verified to chekc if user if already verified
    $sql ="SELECT verification_token, token_expires_at, is_verified FROM `users` WHERE user_email = :email";
    $stmt = $_db->prepare( $sql );

    $stmt->bindValue(":email", $user_email);
    $stmt->execute();

    $user = $stmt->fetch();
    
    if(!$user){
        $_SESSION['flash_message'] = "no user found";
        header('Location: /login');
        exit;
    }
    // TODO:check token after sql selector?
    if($user["verification_token"] === NULL){
        $_SESSION['flash_message'] = "no email found to be verified";
        header('Location: /login');
        exit;
    }

    
    if($user && strtotime($user['token_expires_at']) > time()){
    
        // TODO set is verified to the actually time their verified and not 1
        // TODO: change is_verified in db to hold time()
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
        // TODO: do not echo!
        echo "your link has expired want to renew? <a href='/resend-verification?email=$user_email'>Click here</a> to request a new one.";
        exit;        
    } else {
        $_SESSION['flash_state'] = "error";
        $_SESSION['flash_message'] = "no user found to";
        header('Location: /login');
        exit; 

    }
   

}
catch(Exception $e){


}
    
    
    


