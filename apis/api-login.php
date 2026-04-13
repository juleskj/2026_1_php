<?php

session_start();
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__."/../_.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;




try{   
    
    $mail = new PHPMailer(true);

    $sender_email = "juicefrog2610@gmail.com";
    $email_password = "uwms bmfe bnhk qajz" ; 



    $user_email = _validate_user_email();
    $user_password = _validate_user_password();


    require_once __DIR__."/../db.php";
    // Fetch user from database
    $sql = " SELECT * FROM users WHERE user_email = :email";

    $stmt = $_db->prepare($sql);
    $stmt->bindValue(":email", $user_email);
    $stmt->execute();

    $user = $stmt->fetch();


    if (!$user) {
        throw new Exception("no user");
        exit;
        
    }

    //TODO:validate hashed password to check if actually password
    if (password_verify($user_password, $user['user_password'])) {
       
        // remove password from user
        unset($user['user_password']);
        
        // put user in session
        $_SESSION['user'] = [
            'user_pk'    => $user['user_pk'],    
            'user_email' => $user['user_email'],
            'user_username' => $user['user_username'],
            'user_lastname' => $user['user_lastname'],
            'user_forename' => $user['user_forename'],
        ];


    // TODO:make into funktion 
    // sending a verification email
    // TODO: welcome mail when verifired
    // TODO: welcome mail when verifired
    // TODO:reset password

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
        // redirect to home page
        header('Location: /');
    } else {
        throw new Exception("password incorect");
        exit;
    }
}catch (Exception $e){

    if(str_contains($e, "no user")){
        http_response_code(400);

       $_SESSION['flash_message'] = "no user found, did you spell your email corect?";
        header('Location: /login');
        exit;
    }

    if(str_contains($e, "password incorect")){
        http_response_code(400);

        $_SESSION['flash_message'] = "Password incorect";
        header('Location: /login');
        exit;
    }


    _($e);


}
finally{
    die;
}