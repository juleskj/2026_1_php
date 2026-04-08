<?php

// ##############################
function _($text){
    echo htmlspecialchars($text);

}

define("city_search_min", 0);
define("city_search_max", 20);
function _validate_city_search(){
    $city_name = trim($_POST['city_name'])  ?? '';

    if(strlen($city_name) < city_search_min){
        throw new Exception("search must be at least ".city_search_min." characters long", 400);
    }
    if(strlen($city_name) > city_search_max){
        throw new Exception("search must be max ".city_search_max." characters long", 400);
    }
    $pattern = '/^[a-zA-Z ]*$/';
    if (!preg_match($pattern, $city_name)) {
        throw new Exception("Invalid search input. Only letters and spaces are allowed.", 400);
    }
    return $city_name;
}



// ##############################
define("USER_EMAIL_MIN", 6);
define("USER_EMAIL_MAX", 50);
function _validate_user_email() {
    $user_email = $_POST["user_email"] ?? "";
    $user_email = trim($user_email);
    if (strlen($user_email) < USER_EMAIL_MIN) {
        throw new Exception("Email must be at least " . USER_EMAIL_MIN . " characters long", 400);
    }
    if (strlen($user_email) > USER_EMAIL_MAX) {
        throw new Exception("Email must be max " . USER_EMAIL_MAX . " characters long", 400);
    }
    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email $user_email", 400);
    }
    return $user_email;
}

// ##############################
define("user_username_min", 6);
define("user_username_max", 20);
function _validate_user_username(){
    $user_username = $_POST["user_username"] ?? "";
    $user_username = trim($user_username);
    if(strlen($user_username) < user_username_min){
        throw new Exception("Username min ".user_username_min." characters", 400);
    }
    if(strlen($user_username) > user_username_max){
        throw new Exception("Username max ".user_username_max." characters", 400);
    }
    return $user_username;
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

















