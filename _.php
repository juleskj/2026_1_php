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
define("USER_USERNAME_MIN", 2);
define("USER_USERNAME_MAX", 20);
function _validate_user_username(){
    $user_username = $_POST["user_username"] ?? "";
    $user_username = trim($user_username);
    if(strlen($user_username) < USER_USERNAME_MIN){
        throw new Exception("Username min ".USER_USERNAME_MIN." characters", 400);
    }
    if(strlen($user_username) > USER_USERNAME_MAX){
        throw new Exception("Username max ".USER_USERNAME_MAX." characters", 400);
    }
    return $user_username;
}

// ##############################
define("USER_FORENAME_MIN", 2);
define("USER_FORENAME_MAX", 20);
function _validate_user_forename(){
    $user_forename = $_POST["user_forename"] ?? "";
    $user_forename = trim($user_forename);
    if(strlen($user_forename) < USER_FORENAME_MIN){
        throw new Exception("forename min ".USER_FORENAME_MIN." characters", 400);
    }
    if(strlen($user_forename) > USER_FORENAME_MAX){
        throw new Exception("forename max ".USER_FORENAME_MAX." characters", 400);
    }
    return $user_forename;
}

// ##############################
define("USER_LASTNAME_MIN", 2);
define("USER_LASTNAME_MAX", 20);
function _validate_user_lastname(){
    $user_lastname = $_POST["user_lastname"] ?? "";
    $user_lastname = trim($user_lastname);
    if(strlen($user_lastname) < USER_LASTNAME_MIN){
        throw new Exception("forename min ".USER_LASTNAME_MIN." characters", 400);
    }
    if(strlen($user_lastname) > USER_LASTNAME_MAX){
        throw new Exception("forename max ".USER_LASTNAME_MAX." characters", 400);
    }
    return $user_lastname;
}



// ##############################
define("USER_PASSWORD_MIN", 6);
define("USER_PASSWORD_MAX", 50);
function _validate_user_password(){

    $user_password = $_POST["user_password"] ?? "";
    $user_password = trim($user_password);
    if(strlen($user_password) < USER_PASSWORD_MIN){
        throw new Exception("Password min ".USER_PASSWORD_MIN." characters", 400);
    }
    if(strlen($user_password) > USER_PASSWORD_MAX){
        throw new Exception("Password max ".USER_PASSWORD_MAX." characters", 400);
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


require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function _send_welcome_email($user_email){
    
    
    $mail = new PHPMailer(true);

    $sender_email = "juicefrog2610@gmail.com";
    $email_password = "uwms bmfe bnhk qajz" ; 


    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $sender_email;
    $mail->Password   = $email_password;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;


    $mail->setFrom($sender_email, 'JuiceFrog');
    $mail->addAddress($user_email);

    $mail->isHTML(true);

    $mail->Subject = 'Welcome to boligsiden';

    $mail->Body = "
        <h2>Welcome!</h2>
        <p>Thanks for signing up. We're excited to have you!</p>
        <p>You can now log in and start using your account.</p>
        <br>
        <p>Best regards,<br>JuiceFrog</p>
    ";

    $mail->AltBody = "Welcome! Thanks for signing up.";

    $mail->send();

}

















