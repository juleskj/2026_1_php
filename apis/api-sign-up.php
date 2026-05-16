<?php 
session_start();
require_once __DIR__."/../db.php";
require_once __DIR__."/../_.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try{

        
        $user_password = _validate_user_password();
        $password_verify = $_POST["password_verify"] ?? "";
        
        
        if ($user_password !== $password_verify){
            throw new Exception("password dont match", 400);
            
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


    

        /* Begin a transaction, turning off autocommit */
        $_db->beginTransaction();
        
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

        // get the role id for user
        $role ="user";
        $role_sql = "SELECT  `role_pk` FROM `roles` WHERE role_name = :role_name";
        $stmt = $_db->prepare($role_sql);
        $stmt->bindValue(":role_name", $role);
        $stmt->execute();

        $role_pk = $stmt->fetch();

        // inser it into the db for the new signed up user
        $role_sql = "INSERT INTO `role_table`(`user_fk`, `role_fk`) VALUES (:user_pk,:role_pk)";
        $stmt = $_db->prepare($role_sql);
        $stmt->bindValue(":user_pk",$user_pk);
        $stmt->bindValue(":role_pk",$role_pk["role_pk"]);
        $stmt->execute();

        if($stmt->rowCount() === 0){
            throw new Exception("Registration failed. Please contact support.", 500);
        }


        // commit to db
        $_db->commit();

        $_SESSION['flash_state'] = "success";
        $_SESSION['flash_message'] = "Welcome to boligsiden please verfiy your account to login";

        _send_welcome_email($user_email);

        header('Location: /login');
        exit;
    }
    catch(Exception $e){
        
    // Rollback any open transactions
        if ($_db->inTransaction()) {
            $_db->rollBack();
        }

        error_log("Error: " . $e->getMessage() . " (Code: " . $e->getCode() . ")");

        // Set HTTP status code (default to 500 if not specified)
        http_response_code($e->getCode() >= 400 ? $e->getCode() : 500);
        $_SESSION['flash_state'] = "error";
        
        // Handle specific errors with switch
        $message = $e->getMessage();
        switch (true) {
            case str_contains($message, "user_email") && str_contains($message, "Duplicate entry"):
                $_SESSION['flash_message'] = "Email already exists";
                header('Location: /sign-up');
                exit;

            case str_contains($message, "password dont match"):
                $_SESSION['flash_message'] = "Passwords do not match";
                header('Location: /sign-up');
                exit;

            case str_contains($message, "user_username") && str_contains($message, "Duplicate entry"):
                $_SESSION['flash_message'] = "Username already exists";
                header('Location: /sign-up');
                exit;

            case str_contains($message, "Registration failed"):
                $_SESSION['flash_message'] = "Registration failed";
                header('Location: /sign-up');
                exit;

            default:
                // Generic error for unexpected cases
                $_SESSION['flash_message'] = "An unexpected error occurred Please try again";
                header('Location: /sign-up');
                exit;
        }

        exit;
    }
}