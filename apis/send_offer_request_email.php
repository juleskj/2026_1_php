<?php
session_start();

require_once __DIR__ . "/../db.php";
require_once __DIR__ . "/../_.php";

date_default_timezone_set('Europe/Copenhagen'); //makes sure its the correct time stamp

try{
   
    $item_pk = _validate_pk($_POST["item_pk"]) ?? "";
   
    

    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        echo "no token";
        exit;
    }


    if(!isset($_SESSION["user"])){
        echo "no user";
        exit;
    }

    $user  = $_SESSION["user"];
    $user_pk = $user["user_pk"];


    $date = date('Y-m-d H:i:s');
    $byer_namers = $user["user_forename"] . " " . $user["user_lastname"];

    $_db->beginTransaction();

    $sql=" SELECT price FROM items WHERE pk = :item_pk";
    $stmt = $_db->prepare($sql);
    $stmt->bindValue(":item_pk", $item_pk);
    $stmt->execute();

    if($stmt->rowCount() === 0){
        echo "no property";
        exit;

    }

    $property_price = $stmt->fetch();
    $property_price = number_format($property_price["price"], 0, ',', '.') . "kr";

    
    $sql2 = "INSERT INTO `user_property_offers`(`user_fk`, `property_fk`) VALUES (:user_pk , :item_pk)";
    $stmt = $_db->prepare($sql2);
    $stmt->bindValue(":user_pk", $user_pk);
    $stmt->bindValue(":item_pk", $item_pk);
    $stmt->execute();

    $_db->commit();
    
    _send_offer_request($date, $byer_namers, $property_price);

    $_SESSION['flash_state'] = "success";
    $_SESSION['flash_message'] = "an offer has been sent";

    header("Location: /page-map?item_pk=$item_pk");
    exit;
   
    // echo "ok";

}catch(Exception $e){

    if (isset($_db)) {
        $_db->rollback();
    }

    echo $e;
}