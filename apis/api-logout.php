<?php
session_start(); 

try{



    $_SESSION = array(); 
    session_destroy();   


    header('Content-Type: application/json');

    _(json_encode(['success' => true]));
    
} catch (Exception $e){

    error_log("Error: " . $e->getMessage() . " (Code: " . $e->getCode() . ")");


        $_SESSION['flash_state'] = "error";
        $message = $e->getMessage();
        switch (true) {
            
            default:
                $_SESSION['flash_message'] = "An error occurred Please try again";
                header('Location: /');
                exit;
        }
}