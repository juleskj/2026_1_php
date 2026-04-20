<?php

require_once __DIR__ . "/../_.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    
    try{
        
        $item_pk = validate_property_pk();
        // TODO: make sure user is in session
        $user = "";

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("CSRF token validation failed.");
        }
        
        if (!empty($_SESSION['user'])) {
            
            // TODO: get user id
            $user = $_SESSION['user'];
            $user_pk = $user["user_pk"];
            
            // // TODO: connect db
            require_once __DIR__ . "/../db.php";
            // // TODO: inset into db
            $sql = "INSERT INTO saved_property(user_fk, property_fk) VALUES (:user_pk,:property_pk)";
            $stmt= $_db->prepare($sql);
            $stmt->bindValue(":user_pk", $user_pk);
            $stmt->bindValue(":property_pk", $item_pk);
            $stmt->execute();
    
            require_once __DIR__ . "/../session_utils.php";
    
            $saved_home = track_saved_homes($item_pk);
    
        }  
    
    
    } catch (Exception $e){
    
    
    }


}

?>

<browser mix-replace="#save-<?=_($item_pk)?>">
    <button class="bookmark solid "></button>

</browser>






