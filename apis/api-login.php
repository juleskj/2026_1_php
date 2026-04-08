<?php

try{
    session_start();

    require_once __DIR__."/../_.php";

    // TODO: validate username
    // TODO:validate email
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
        throw new Exception("User not found");   
    }

    //TODO:validate hashed password to check if actually password
    if (password_verify($user_password, $user['user_password'])) {
        // TODO: Put user in session
        
        $_SESSION["user"] = $user;


        _(json_encode($user));
        _("ok");
    } else {
        throw new Exception("Password incorect");
    }
}catch (Exception $e){

    _($e);

}
finally{
    die;
}