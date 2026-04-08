<?php 

try{
    require_once __DIR__."/../_.php";
    $user_email = _validate_user_email();
    $user_password = _validate_user_password();
    $user_username = _validate_user_username();
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
    $user_pk = bin2hex(random_bytes(25)); // Returns 50 characters

    require_once __DIR__."/../db.php";
    $sql = <<<SQL
            INSERT INTO users(
                user_username,
                user_password,
                user_forname,
                user_lastname,
                user_pk,
                user_email
            )
            VALUES (
                :username,
                :password,
                'jens',
                'jensen',
                :user_pk,
                :email
            )
            SQL;
    
    
    
    
    $stmt = $_db->prepare( $sql );

    $stmt->bindValue(":user_pk", $user_pk);
    $stmt->bindValue(":email", $user_email);
    $stmt->bindValue(":username", $user_username);
    $stmt->bindValue(":password", $hashed_password);

    $stmt->execute();

    _("ok");
    exit;
}
catch(Exception $e){

    
    
    if(str_contains($e, "user_email") && str_contains($e, "Duplicate entry")){
    http_response_code(409);
    _("email already exists");
        exit;
    }

    if(str_contains($e, "user_username") && str_contains($e, "Duplicate entry")){
        http_response_code(400);
        _("username already exists");
        exit;
    }

    http_response_code($e->getCode());
    _($e->getMessage());
    exit;
}