<?php 

try{

    session_start();

    require_once __DIR__."/../_.php";
    $user_password = _validate_user_password();
    $password_verify = $_POST["password_verify"] ?? "";
    
    if ($user_password !== $password_verify){
        throw new Exception("password dont match");
        exit;
    }
        
    $user_email = _validate_user_email();
    $user_username = _validate_user_username();

    $user_forename = _validate_user_forename();
    $user_lastname = _validate_user_lastname();

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
                user_email
            )
            VALUES (
                :username,
                :password,
                :forename,
                :lastname,
                :user_pk,
                :email
            )
            SQL;
    $stmt = $_db->prepare( $sql );

    $stmt->bindValue(":user_pk", $user_pk);
    $stmt->bindValue(":email", $user_email);
    $stmt->bindValue(":username", $user_username);
    $stmt->bindValue(":forename", $user_forename);
    $stmt->bindValue(":lastname", $user_lastname);
    $stmt->bindValue(":password", $hashed_password);

    $stmt->execute();

    $_SESSION['flash_message'] = "Welcome to boligsiden! pleas login to your new account";
    header('Location: /login');
    exit;
}
catch(Exception $e){


    if(str_contains($e, "user_email") && str_contains($e, "Duplicate entry")){
        http_response_code(409);

        $_SESSION['flash_message'] = "email already exists";
        header('Location: /sign-up');

        exit;
    }

    if(str_contains($e, "password dont match")){
        http_response_code(409);

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
    // _($e->getMessage());
    exit;
}