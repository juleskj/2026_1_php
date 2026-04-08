<?php

try{
    
    require_once __DIR__ . "/../db.php";
    $sql = "SELECT * FROM `full_property`";
    $stmt = $_db->prepare( $sql );
    
    $stmt->execute();

    $data = $stmt->fetchAll();

    $data = json_encode($data);

    echo "<browser mix-function='test'>$data</browser>";

    exit;
}catch(Exception $e){

}






