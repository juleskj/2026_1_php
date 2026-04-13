<?php

    date_default_timezone_set('Europe/Copenhagen'); //makes sure its the correct time stamp

    $token = $_GET["token"] ?? "";

     
    require_once __DIR__ . "/../_.php";
    require_once __DIR__ . "/../db.php";

    $sql ="SELECT user_email FROM `users` WHERE verification_token = :token";
    $stmt = $_db->prepare( $sql );

    $stmt->bindValue(":token", $token);
    $stmt->execute();

    $user = $stmt->fetch();

    echo json_encode($user);
    

    date_default_timezone_set('Europe/Copenhagen'); //makes sure its the correct time stamp

    $new_token = bin2hex(random_bytes(25)); // Returns 50 characters
    $new_expire_date = date('Y-m-d H:i:s', strtotime('+1 hour'));

    $sql = "UPDATE users SET verification_token= :new_token, token_expires_at= :new_expire_date 
            WHERE user_email = :user_email";

    $stmt = $_db->prepare($sql);
    $stmt->bindValue(":new_token", $new_token);
    $stmt->bindValue(":new_expire_date", $new_expire_date);
    $stmt->bindValue(":user_email", $user["user_email"]);
    $stmt->execute();
    
    _send_welcome_email($user["user_email"],$new_token, true);

    echo"ok";