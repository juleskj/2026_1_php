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



function _get_validate_user_email() {
    $user_email = filter_var(trim($_GET["user_email"] ?? ""), FILTER_VALIDATE_EMAIL);
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

   
    $sender_email   = $_ENV['MAIL_FROM'];
    $email_password = $_ENV['MAIL_PASSWORD'];
   


    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $sender_email;
    $mail->Password   = $email_password;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;


    $mail->setFrom($sender_email, $_ENV['MAIL_FROM_NAME']);
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



function _send_offer_request($date, $buyer_namer, $property_price){
    
    
    $mail = new PHPMailer(true);

    $sender_email   = $_ENV['MAIL_FROM'];
    $email_password = $_ENV['MAIL_PASSWORD'];
    
    $admin_email = $_ENV['ADMIN_EMAIL'];


    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $sender_email;
    $mail->Password   = $email_password;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;


    $mail->setFrom($sender_email, $_ENV['MAIL_FROM_NAME']);
    $mail->addAddress($admin_email);

    $mail->isHTML(true);

    
    $mail->Subject = "Offer made on property";
    $mail->Body = "
       <h2>New Offer Received for Your Property</h2>
        <p>A new purchase offer has been submitted for <strong>[Property Address]</strong>.</p>

        <p><strong>Offer Details:</strong></p>
        <ul>
        <li><strong>Amount:</strong> $property_price</li>
        <li><strong>Buyer:</strong> $buyer_namer</li>
        <li><strong>Submitted:</strong> $date</li>
        <li><strong>Additional Terms:</strong> [e.g., Contingencies, Closing Date]</li>
        </ul>

        <p>Please review and <strong>approve, counter, or reject</strong> this offer at your earliest convenience.</p>

        
        <br>
        <p>Best regards,<br>JuiceFrog</p>
    ";

    

    $mail->AltBody = "request";

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
    $pattern = '/^[a-zA-Z0-9 .,!]*$/';
    if (!preg_match($pattern, $flash_msg)) {
        throw new Exception("Invalid flash Only letters and spaces are allowed", 400);
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




// ###################### validate save new property 

function _validate_field($field, $value, $rules) {
    // Check if the field is required and missing
    if ($rules['required'] && ($value === null || $value === '')) {
        throw new Exception("Field '$field' is required", 400);
    }

    // Skip validation if the field is not required and empty
    if (!$rules['required'] && ($value === null || $value === '')) {
        return null;
    }

    // Trim strings
    if (is_string($value)) {
        $value = trim($value);
    }

    // Validate type
    switch ($rules['type']) {
        case 'int':
            if (!is_numeric($value) || (int)$value != $value) {
                throw new Exception("Field '$field' must be an integer", 400);
            }
            $value = (int)$value;
            break;
        case 'float':
            if (!is_numeric($value)) {
                throw new Exception("Field '$field' must be a number", 400);
            }
            $value = (float)$value;
            break;
        case 'string':
            if (!is_string($value)) {
                throw new Exception("Field '$field' must be a string", 400);
            }
            break;
    }

    // Validate min/max for strings (length) and numbers (value)
    if (isset($rules['min'])) {
        if ($rules['type'] === 'string' && strlen($value) < $rules['min']) {
            throw new Exception("Field '$field' must be at least {$rules['min']} characters long.", 400);
        } elseif (($rules['type'] === 'int' || $rules['type'] === 'float') && $value < $rules['min']) {
            throw new Exception("Field '$field' must be at least {$rules['min']}.", 400);
        }
    }

    if (isset($rules['max'])) {
        if ($rules['type'] === 'string' && strlen($value) > $rules['max']) {
            throw new Exception("Field '$field' must be at most {$rules['max']} characters long.", 400);
        } elseif (($rules['type'] === 'int' || $rules['type'] === 'float') && $value > $rules['max']) {
            throw new Exception("Field '$field' must be at most {$rules['max']}.", 400);
        }
    }

    // Validate pattern (for strings)
    if (isset($rules['pattern']) && !preg_match($rules['pattern'], $value)) {
        throw new Exception("Field '$field' has an invalid format.", 400);
    }

    return $value;
}



function _is_lmage_accessible($imageUrl) {
    $ch = curl_init($imageUrl);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 5);

    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if($httpCode !== 200){
        return "../images/johnson-U6Q6zVDgmSs-unsplash.jpg";
    }

    // Return true if the status code is 200 (OK)
    return $imageUrl;
}

 function _row_block_HTML($value, $icon, $metric, $text) {
    ob_start(); ?>
    <?php if($value != null):?>
    <article class="row">
        <h4><i class="fa-solid <?= _($icon) ?>" style="color: rgb(64, 92, 185);"></i> <?= _($text) ?></h4>
        <p><?= _($value) . _($metric) ?></p>
    </article>
    
    <?php
    endif;
    return ob_get_clean();
} 



function _validate_pk(string $pk): string {
    // Check length (must be exactly 50 characters)
    if (strlen($pk) !== 50) {
        throw new Exception("Primary key must be exactly 50 characters long", 400);
    }

    // Check if the pk is a valid hexadecimal string
    if (!ctype_xdigit($pk)) {
        throw new Exception("Primary key must be a valid hexadecimal string", 400);
    }

    return $pk;
}



function set_csrf()
{
	if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
	if (!isset($_SESSION["csrf_token"])) {
		$_SESSION["csrf_token"] = bin2hex(random_bytes(50));
	}
	echo '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($_SESSION["csrf_token"]) . '">';
}

function is_csrf_valid()
{
	if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
	if (!isset($_SESSION['csrf_token']) || !isset($_POST['csrf_token'])) {
		return false;
	}
	if(!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])){
		return false;
	}
	if ($_SESSION['csrf_token'] != $_POST['csrf_token']) {
		return false;
	}
	return true;
}

