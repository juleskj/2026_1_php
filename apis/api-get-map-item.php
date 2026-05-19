<?php 

    session_start();
try{
    require_once __DIR__ . '/../session_utils.php';
    require_once __DIR__ . "/../_.php";
    

    $item_pk = $_GET['item_pk'] ?? '';

    // looks if there is any item_pk sent
    if (isset($_GET["item_pk"]) && _validate_pk($_GET["item_pk"])) {
        
        $item_pk = _validate_pk($_GET["item_pk"]) ?? "";

        $viewed_homes = track_viewed_homes();
        
        require_once __DIR__ . "/../db.php";
        // get item from db
        $sql = "SELECT * FROM `items` WHERE pk = :item_pk";
        $stmt = $_db->prepare( $sql );

        $stmt->bindValue(":item_pk", $item_pk);
        
        $stmt->execute();
        
        if($stmt->rowCount() === 0){
            $_SESSION['flash_state'] = "error";
            $_SESSION['flash_message'] = "The selected property doesnt exist.";
           
            $firstNElements = [];
            $sql = "SELECT * FROM `items` LIMIT 10";
            $stmt = $_db->prepare($sql);
            $stmt->execute();
            $firstNElements = $stmt->fetchAll();

            
            include __DIR__ . '/../micro-components/_vertical_scroller.php';
            exit;
        }
        $item = $stmt->fetch();
    }
    
}catch(Exception $e){
    error_log("Error: " . $e->getMessage() . " (Code: " . $e->getCode() . ")");

    

    $_SESSION['flash_state'] = "error";
    $message = $e->getMessage();
    switch (true) {
        case str_contains($message, "exactly 50 characters long"):
            $_SESSION['flash_message'] = "invalid id";
            header('Location: /page-map');
            exit;
        case str_contains($message, "valid hexadecimal string"):
            $_SESSION['flash_message'] = "invalid id";
            header('Location: /page-map');
            exit;

        default:
            $_SESSION['flash_message'] = "An error occurred Please try again";
            header('Location: /page-map');
            exit;
            
    }
}

require __DIR__ . "/../micro-components/_aside.php"; ?>










