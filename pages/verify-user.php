<?php

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

    date_default_timezone_set('Europe/Copenhagen'); //makes sure its the correct time stamp
    
    $testdate = date("Y-m-d H:i:s", strtotime("-1 hour"));
    
    echo $testdate . " " . date( "Y-m-d H:i:s", time());
    // strtotime($user['token_expires_at'])

    if(strtotime($user['token_expires_at']) > time()){
        echo "verified!";
        exit;
    } else {
        echo "expired token.";
        
    }
    // $sql = "UPDATE users SET is_verified = 1, verification_token = NULL, token_expires_at = NULL
    // WHERE verification_token = ?";

    echo json_encode($user["user_username"]);


    exit;

