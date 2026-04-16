<?php
    require_once __DIR__."/../_.php";
    require_once __DIR__ . "/../db.php";

    try{


    $beds = $_POST["beds"] ?? '';
    $baths = $_POST["baths"] ?? '';
    $cityName = _validate_city_search();


    $sql = "SELECT * FROM items";

    $conditions = [];
    $params = [];

    // add conditions based on user input
    if (!empty($beds)) {
    $conditions[] = "number_of_rooms = :number_beds";
    $params[":number_beds"] = $beds;
    }
    if (!empty($baths)) {
    $conditions[] = "number_of_baths = :number_baths";
    $params[":number_baths"] = $baths;
    }

    // Handle city search
    if (!empty($cityName)) {
    $conditions[] = "city_name LIKE :city";
    $params[":city"] = $cityName . '%';
    }

    // combine conditions with AND
    if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
    }


    // prepare and execute the query
    $stmt = $_db->prepare($sql);

    foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
    }

    $stmt->execute();
    $items = $stmt->fetchAll();

    // return the data
    $data = ["url"=>
        [
            ["city_name"=>$cityName],
            ["beds"=>$beds],
            ["baths"=>$baths],

        ], 
        "items"=>$items
    ];


} catch(Exception $e){
    if(str_contains($e, "city_search") && str_contains($e, "must be max")){
    http_response_code(409);
    _("Search too long");
        exit;
    }

    http_response_code($e->getCode());
    _($e->getMessage());
    exit;

}


?>

<browser mix-function="clearMarkers">
<?= json_encode($data) ?>
</browser>









