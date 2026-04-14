<?php 

try{

    session_start();

    require_once __DIR__."/../_.php";
    $user_password = _validate_user_password();
    $password_verify = $_POST["password_verify"] ?? "";
    
    if ($user_password !== $password_verify){
        throw new Exception("password dont match", 400);
        exit;
    }
        
    $user_email = _validate_user_email();
    $user_username = _validate_user_username();

    $user_forename = _validate_user_forename();
    $user_lastname = _validate_user_lastname();

    $token = bin2hex(random_bytes(25)); // Returns 50 characters
    date_default_timezone_set('Europe/Copenhagen'); //makes sure its the correct time stamp


    $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
    $user_pk = bin2hex(random_bytes(25)); // Returns 50 characters


    require_once __DIR__."/../db.php";
    
    $sql = <<<SQL
            INSERT INTO users(
                user_username,
                user_password,
                user_forename,
                user_lastname,
                user_pk,
                user_email,
                is_verified,
                verification_token,
                token_expires_at
            )
            VALUES (
                :username,
                :password,
                :forename,
                :lastname,
                :user_pk,
                :email,
                0,
                :token,
                :expire_at
            )
            SQL;

    $stmt = $_db->prepare( $sql );

    $stmt->bindValue(":user_pk", $user_pk);
    $stmt->bindValue(":email", $user_email);
    $stmt->bindValue(":username", $user_username);
    $stmt->bindValue(":forename", $user_forename);
    $stmt->bindValue(":lastname", $user_lastname);
    $stmt->bindValue(":password", $hashed_password);
    $stmt->bindValue(":token", $token);
    $stmt->bindValue(":expire_at", $expires_at);


    $stmt->execute();

    $_SESSION['flash_message'] = "Welcome to boligsiden! please verfiy your account to login";

    _send_welcome_email($user_email);

    header('Location: /login');
    exit;
}
catch(Exception $e){

    

    if(str_contains($e, "user_email") && str_contains($e, "Duplicate entry")){
        http_response_code(400);

        $_SESSION['flash_message'] = "email already exists";
        header('Location: /sign-up');

        exit;
    }

    if(str_contains($e, "password dont match")){
        http_response_code(400);

        $_SESSION['flash_message'] = "password dont match";
        header('Location: /sign-up');
        
        exit;
    }


    if(str_contains($e, "user_username") && str_contains($e, "Duplicate entry")){
        http_response_code(400);
        
        $_SESSION['flash_message'] = "username already exists";
        header('Location: /sign-up');

        exit;
    }

    http_response_code($e->getCode());
    
    exit;
}