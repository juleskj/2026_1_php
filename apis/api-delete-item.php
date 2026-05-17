<?php 
session_start();

try{
    $item_pk = $_GET['item_pk'];
    // TODO: validate item pk
    require_once __DIR__ . "/../_.php";
    require_once __DIR__ . "/../db.php";

    $sql = "UPDATE `items` SET deleted_at = '1' WHERE pk = :item_pk";
    $stmt = $_db->prepare( $sql );

    $stmt->bindValue(":item_pk", $item_pk);
    $stmt->execute();

    $sql = "SELECT * FROM `items` WHERE pk = :item_pk";
    $stmt = $_db->prepare( $sql );

    $stmt->bindValue(":item_pk", $item_pk);

    $stmt->execute();
    $item = $stmt->fetch();
    
}catch(Exception $e){
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
?>


<browser mix-update="#info">
    <?php

    require __DIR__ . "/../micro-components/_aside.php"

    ?>
</browser>





