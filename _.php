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
    $user_email = filter_var(trim($_POST["user_email"] ?? ""), FILTER_VALIDATE_EMAIL);
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

// ##############################
require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function _send_welcome_email($user_email, $isReverify = false){
    
    
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

    $verificationLink = "http://127.0.0.1/verify-user?email=" . urlencode($user_email);

    if($isReverify){

        $mail->Subject = "Please Reverify Your Email";
        $mail->Body = "
            <h2>Reverify Your Account</h2>
            <p>Your previous verification link expired. No worries!</p>
            <p>Click the link below to verify your account:</p>
            <a href='$verificationLink'>Verify Now</a>
            <br>
            <p>Best regards,<br>JuiceFrog</p>
        ";

    } else {
        
        $mail->Subject = 'Welcome to boligsiden';
    
        $mail->Body = "
            <h2>Welcome!</h2>
            <p>Thanks for signing up. We're excited to have you!</p>
            <p>Please verify your account to log in</p>
            <a href='$verificationLink'>verify your account</a>
            <br>
            <p>Best regards,<br>JuiceFrog</p>
        ";
    }

    $mail->AltBody = "Welcome! Thanks for signing up.";

    $mail->send();

}


// ##############################
function _validate_property_pk() {
    
    $property_pk = filter_input(INPUT_POST, "item_pk") ?? null;

    if(empty($property_pk)){
        throw new Exception("property id missing", 400);
    }
    if (strlen($property_pk) !== 50) {
        throw new Exception("invalide property id", 400);
    }
    
    if (!ctype_xdigit($property_pk)) {
        throw new Exception("invalide property id format", 400);
    }

    return $property_pk;

}



define("FLASH_MSG_MIN", 0);
define("FLASH_MSG_MAX", 200);
function _validate_flash_message($flash_msg){
    $flash_msg = trim($flash_msg);
    
    if(strlen($flash_msg) < FLASH_MSG_MIN){
        throw new Exception("flash must be at least ".FLASH_MSG_MIN." characters long", 400);
    }
    if(strlen($flash_msg) > FLASH_MSG_MAX){
        throw new Exception("flash must be max ".FLASH_MSG_MAX." characters long", 400);
    }
    $pattern = '/^[a-zA-Z ]*$/';
    if (!preg_match($pattern, $flash_msg)) {
        throw new Exception("Invalid flash. Only letters and spaces are allowed.", 400);
    }
    return $flash_msg;
}



function _render_flash_msg(){

    $message = "";
    $flash_state = "";

    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        $flash_state = $_SESSION['flash_state'] ?? "message"; // Default to "message" if not set

        
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_state']);
    }


    if ($message) {
        $msg = $message;
        include '../micro-components/_flash-message.php';
    }


    // how to user
    /*
     * remebemr start_session;
     * when you user do
     * 
     *  $_SESSION['flash_state'] = "error";
        $_SESSION['flash_message'] = "password dont match";
        header('Location: $_SERVER['PHP_SELF'];);
    
    */


}


// ################################

function uploadImg() {

    $target_dir = "../uploads/";
    $uploadOk = 1;

    $new_target_file = bin2hex(random_bytes(25));

    $temp = explode(".", $_FILES["fileToUpload"]["name"]);
    $newfilename = $new_target_file . '.' . end($temp);



    $target_file = $target_dir . $newfilename;

    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));



    if (file_exists($target_dir)) {
        echo _("The directory $target_dir exists.");
    } else {
        mkdir($target_dir, 0755);
        echo "The directory $target_dir was successfully created.";
        
    }


    // Check if image file is a actual image or fake image
    if(isset($_FILES["fileToUpload"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    }

    if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
    }

    if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "webp" ) {
    echo "Sorry, only JPG, JPEG, PNG, WEBP files are allowed.";
    $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". _( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

}



// ############################

define("MAX_FILE_SIZE", 500000);
define("ALLOWED_TYPES", ["jpg", "png", "jpeg", "webp"]);
function _validate_uploded_file(array $file): array{

    $check = getimagesize($file["tmp_name"]);
    if($check === false) {
        return ['valid' => false, 'message' => "sorry your file is not a valide image"];
    } 

    if ($file["size"] > MAX_FILE_SIZE) {
        return ['valid' => false, 'message' => "sorry your image is too large"];
    }
     
    $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    if (!in_array($imageFileType, ALLOWED_TYPES)){
        return ['valid'=> false, 'message' => "sorry only JPG JPEG PNG and WEBP files allowed"];
    }

    return ['valid' => true, 'message' => ""];
}


// ####################

function _delete_old_user_image(string $user_pk, string $old_file_name, string $target_dir, PDO $_db):void{

    $old_file_path  = $target_dir . $old_file_name;

    if(file_exists($old_file_path)){


        // Get the canonicalized absolute pathname
        $absolute_path = realpath($old_file_path);

        // Check if the file exists and is writable
        if ($absolute_path !== false && is_writable($absolute_path)) {
            unlink($absolute_path);
        }

    }

    $sql = "DELETE FROM `user_images` where user_fk = :user_pk";
    $stmt = $_db->prepare($sql);
    $stmt->bindValue(":user_pk", $user_pk);
    $stmt->execute();

}