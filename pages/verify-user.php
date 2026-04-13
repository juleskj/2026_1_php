<?php

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

    
    $testdate = date("Y-m-d H:i:s", strtotime("-1 hour"));
    
    // $user['token_expires_at'] actullul token

    if(strtotime($testdate) > time()){
        echo "verified!";
        exit;
        } else {
        // TODO:resend a new verification token in case its invalide
        echo "your link has expired want to renew? <a href='/resend-verification?token=$token'>Click here</a> to request a new one.";
                
    }
    
    echo json_encode($user["user_username"]);


    exit;

