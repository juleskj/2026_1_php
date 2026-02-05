<?php

// ##############################
function _($text){
    echo htmlspecialchars($text);

}

// ##############################
define("user_email_min", 6);
define("user_email_max", 50);
function _validate_user_email(){
    $user_email = $_POST["user_email"] ??  "";
    $user_email = trim($user_email);
    if(strlen($user_email) < user_email_min){
        throw new Exception("Email must be at least ".user_email_min." characters long", 400);
    }
    if(strlen($user_email) > user_email_max){
        throw new Exception("Email must be max ".user_email_max." characters long", 400);
    }
    if ( ! filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email $user_email", 400);
    }    
    return $user_email;
}

// ##############################
define("user_password_min", 6);
define("user_password_max", 50);
function _validate_user_password(){
    $user_password = $_POST["user_password"] ?? "";
    $user_password = trim($user_password);
    if(strlen($user_password) < user_password_min){
        throw new Exception("Password min ".user_password_min." characters", 400);
    }
    if(strlen($user_password) > user_password_max){
        throw new Exception("Password max ".user_password_max." characters", 400);
    }
    return $user_password;
}

// ##############################
function _no_cache(){
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");
    header('Clear-Site-Data: "cache", "cookies", "storage", "executionContexts"');
}

















