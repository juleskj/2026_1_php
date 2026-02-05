<?php 

try{
    require_once __DIR__."/_.php";
    $user_email = _validate_user_email();
    $user_password = _validate_user_password();
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
    $user_pk = bin2hex(random_bytes(25)); // Returns 50 characters

    require_once __DIR__."/db.php";
    $sql = "INSERT INTO user (user_pk, user_email, user_password) VALUES (:user_pk, :email, :password)";
    $stmt = $_db->prepare( $sql );

    $stmt->bindValue(":user_pk", $user_pk);
    $stmt->bindValue(":email", $user_email);
    $stmt->bindValue(":password", $hashed_password);

    $stmt->execute();

    _("ok");
    exit();
}
catch(Exception $e){

    if(str_contains($e, "user_email")){
        http_response_code(400);
        _("email already exists");
        exit;
    }

    http_response_code($e->getCode());
    _($e->getMessage());
    exit;
}