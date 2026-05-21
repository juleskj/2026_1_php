<?php

session_start();

require_once __DIR__."/../_.php";
require_once __DIR__."/../db.php";

try{   
    $user_email = _validate_user_email();
    $user_password = _validate_user_password();


    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $_SESSION['flash_state'] = "error";
        $_SESSION['flash_message'] = "Invalid CSRF token";
        header('Location: /login');
        exit;
    }


    

    $_db->beginTransaction();

    // Fetch user from database
    $sql = "call get_user_data_by_email(:email)";

    $stmt = $_db->prepare($sql);
    $stmt->bindValue(":email", $user_email);
    $stmt->execute();

    $user = $stmt->fetch();

    // checks if there actually is a user
    if (!$user) {
        throw new Exception("no user", 401);
        
    }

    // checks if the user is verified
    if(!$user["is_verified"]){
        throw new Exception("user not verified", 401);
    }

    // checks if the password is correct
    if (password_verify($user_password, $user['user_password'])) {
       
        // remove password from user
        unset($user['user_password']);


        // get the users role
        $sql = "SELECT get_user_role(:user_pk) AS role_list";
        $stmt = $_db->prepare($sql);
        $stmt->bindValue(":user_pk",$user['user_pk']);
        $stmt->execute();

        $user_role = $stmt->fetch();

        $_db->commit();
        
        // put user in session
        $_SESSION['user'] = [
            'user_pk'    => $user['user_pk'],    
            'user_email' => $user['user_email'],
            'user_username' => $user['user_username'],
            'user_lastname' => $user['user_lastname'],
            'user_forename' => $user['user_forename'],
            'user_image' => $user['user_img'],
            'user_role' =>  explode(',', $user_role['role_list']),
        ];

        require_once __DIR__ . "/../session_utils.php";
        // TODO: fetch all the save_homes and put into session when the user logs in
        get_saved_homes();

        header('Location: /');
    } else {
        throw new Exception("password incorect", 401);
       
    }

}catch (Exception $e){

    if (isset($_db)) {
        $_db->rollback();
    }
    

    error_log("Error: " . $e->getMessage() . " (Code: " . $e->getCode() . ")");
    
    $_SESSION['flash_state'] = "error";
    $message = $e->getMessage();
    switch (true)  {
        case str_contains($message,"no user"):
            $_SESSION['flash_message'] = "User not found";
            header('Location: /login');
            exit;
        case str_contains($message,"user not verified");
            $_SESSION['flash_message'] = "Please verify your email";
            header('Location: /login');
            exit;
        case str_contains($message,"Password"):
            $_SESSION['flash_message'] = "invalide password or email";
            header('Location: /login');
            exit;

        case str_contains($message,"email"):
            $_SESSION['flash_message'] = "invalide password or email";
            header('Location: /login');
            exit;

        default:
            $_SESSION['flash_message'] = "invalide password or email";
            header('Location: /login');
            exit;
    }

}
