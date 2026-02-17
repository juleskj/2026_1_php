<?php 

try{
    require_once __DIR__."/_.php";
    $user_email = _validate_user_email();
    $user_username = _validate_user_username();
    $user_password = _validate_user_password();
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
    $user_pk = bin2hex(random_bytes(25)); // Returns 50 characters

    require_once __DIR__."/db.php";
    $sql = "INSERT INTO user (user_pk, user_email, user_username, user_password) 
    VALUES (:user_pk, :email, :username, :password)";
    $stmt = $_db->prepare( $sql );

    $stmt->bindValue(":user_pk", $user_pk);
    $stmt->bindValue(":email", $user_email);
    $stmt->bindValue(":username", $user_username);
    $stmt->bindValue(":password", $hashed_password);

    $stmt->execute();

    _("ok");
    exit();
}
catch(Exception $e){



    /*
    PDOException: SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'a@a.com' for key 'user_email' in
    /var/www/html/api-sign-up.php:18
    Stack trace:
    #0 /var/www/html/api-sign-up.php(18): PDOStatement->execute()
    #1 {main}SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry &#039;a@a.com&#039; for key
    &#039;user_email&#039;
    */

    
    if(  str_contains($e, "Duplicate entry") && str_contains($e, "user_email")){
        http_response_code(409);
        _("email already exists");
        exit;
    }

    if(  str_contains($e, "Duplicate entry") && str_contains($e, "user_username")){
        http_response_code(409);
        _("email already exists");
        exit;
    }


    http_response_code($e->getCode());
    _($e->getMessage());
    exit;
}