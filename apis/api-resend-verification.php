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
    

    echo $token;