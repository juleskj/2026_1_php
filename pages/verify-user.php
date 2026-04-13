<?php
    session_start();
    date_default_timezone_set('Europe/Copenhagen'); //makes sure its the correct time stamp

    $token = $_GET["token"] ?? "";

    if(!$token){
        echo "no user";
        exit;
    }

    
    require_once __DIR__ . "/../_.php";
    require_once __DIR__ . "/../db.php";


    $sql ="SELECT user_username, token_expires_at FROM `users` WHERE verification_token = :token";
    $stmt = $_db->prepare( $sql );

    $stmt->bindValue(":token", $token);
    $stmt->execute();

    $user = $stmt->fetch();

    if(!$user){
        echo "no user found";
        exit;
    }

    // checks if the users token exporation is leter then the time now
    if(strtotime($user['token_expires_at']) > time()){
        
        $sql = "UPDATE users SET verification_token= NULL, token_expires_at= NULL, is_verified = 1 
            WHERE verification_token = :token";
        $stmt = $_db->prepare($sql);

        $stmt->bindValue(":token",$token);
        $stmt->execute();

        $_SESSION['flash_message'] = "Welcome to boligsiden! you can now login you your account";

        header('Location: /login');
        exit;

    } else {
        // TODO:resend a new verification token in case its invalide
        echo "your link has expired want to renew? <a href='/resend-verification?token=$token'>Click here</a> to request a new one.";
        exit;        
    }
    
    


