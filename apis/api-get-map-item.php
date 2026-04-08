<?php 
try{

    session_start();
    require_once __DIR__ . '/../session_utils.php';
    require_once __DIR__ . "/../_.php";
    

    $item_pk = $_GET['item_pk'] ?? '';

    // looks if there is any item_pk sent
    if (isset($_GET["item_pk"])) {

        $item_pk = $_GET["item_pk"];
        // TODO: validate item pk

        $viewed_homes = track_viewed_homes();

        require_once __DIR__ . "/../db.php";
        // get item from db
        $sql = "SELECT * FROM `items` WHERE pk = :item_pk";
        $stmt = $_db->prepare( $sql );

        $stmt->bindValue(":item_pk", $item_pk);

        $stmt->execute();
        $item = $stmt->fetch();
    }
    
}catch(Exception $e){

}


require __DIR__ . "/../micro-components/_aside.php";








