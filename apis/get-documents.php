<?php

require_once __DIR__ . "/../db.php";
try{
    
$sql = "SELECT * FROM zips";
$stmt = $_db->prepare($sql);
$stmt->execute();
$zips = $stmt->fetchAll();


foreach ($zips as $zip) {
    // foreach throw all the zips

    // makes document pk 50 char
    $document_pk = bin2hex(random_bytes(25));
    $zip_fk = $zip["zip_pk"];
    $document =  file_get_contents("https://api.boligsiden.dk/search/map/cases?zipCodes=$zip_fk");

    if ($document){
                

        $sql = "INSERT INTO documents VALUES(:document_pk,:zip_fk,:document)";
        $stmt = $_db->prepare($sql);
        $stmt->bindValue(":document_pk", $document_pk);
        $stmt->bindValue(":zip_fk", $zip_fk);
        $stmt->bindValue(":document", $document);
        $stmt->execute();
        
    }

    echo "documents retrieved";
}
}catch(Exception $e){

echo "ups..";

}