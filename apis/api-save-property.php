<?php

require_once __DIR__ . "/../_.php";

session_start();


try{
    
    
    $item_pk = validate_property_pk();
    // TODO: make sure user is in session
    $user = "";
    
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

        echo $item_pk;
    }     

} catch (Exception $e){




}






