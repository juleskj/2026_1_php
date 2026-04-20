<?php

session_start();

require_once __DIR__."/../_.php";

try{   
    
    $user_email = _validate_user_email();
    $user_password = _validate_user_password();


    require_once __DIR__."/../db.php";
    // Fetch user from database
    $sql = " SELECT * FROM users WHERE user_email = :email";

    $stmt = $_db->prepare($sql);
    $stmt->bindValue(":email", $user_email);
    $stmt->execute();

    $user = $stmt->fetch();

    // checks if there actually is a user
    if (!$user) {
        throw new Exception("no user", 401);
        exit;
        
    }

    // checks if the user is verified
    if(!$user["is_verified"]){
        throw new Exception("user not verified", 401);
        exit;
    }

    // checks if the password is correct
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

        require_once __DIR__ . "/../session_utils.php";
        // TODO: fetch all the save_homes and put into session when the user logs in
        get_saved_homes();

        header('Location: /');
    } else {
        throw new Exception("password incorect", 401);
        exit;
    }

}catch (Exception $e){

    http_response_code(401);
    $_SESSION['flash_message'] = "Invalid email or password.";
    header('Location: /login');
    exit;

}
