<?php

/*
    `pk`, `lat`, `lon`, `price`, `type`, `city_name`, 
    `house_number`, `road_name`, `zip_code`, 
    `days_listed`, `energy_label`, `floor_square_meters`,
    `lot_square_meters`, `monthly_expenses`, 
    `number_of_rooms`, `price_per_meter`, 
    `main_image_path`, `floor_plan_path`, 
    `deleted_at`, `number_of_baths`, `year_build`, 
    `main_image_alt` 

*/
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try{
        
        $pk = bin2hex(random_bytes(25));
        $city_name = $_POST[""] ?? null;
        $house_number =  $_POST[""] ?? null;
        $type =  $_POST[""] ?? null;
        $price =  $_POST[""] ?? null;
        $lat = $_POST["lat"];
        $lon = $_POST["lon"];
        $zip_code =  $_POST[""]->zipCode ?? null;
        $days_listed =  $_POST[""] ?? null;
        $energy_label =  $_POST[""] ?? null;
        $monthly_expenses=  $_POST[""] ?? null;
        $lot_square_meters =  $_POST[""] ?? null;
        $floor_square_meters =  $_POST[""] ?? null;
        $road_name =  $_POST[""] ?? null;

        $main_image_path =  $_POST[""] ?? null;
        $floor_plan_path =  $_POST[""] ?? null;
        $number_of_rooms =  $_POST[""] ?? null;
        $price_per_meter =  $_POST[""] ?? null;
                        
        $number_of_baths =  $_POST[""];
        $year_build = $_POST[""] ?? null;
        $main_image_alt =  $_POST[""]?? null;





        $lat = $_POST["lat"];
        $lon = $_POST["lon"];
        
        echo $lat . " " . $lon;


    } catch ( Exception $e){


    }
    
}

?>

<browser mix-replace="#submit-btn">
    <button type="submit" id="submit-btn" disabled>Save Bolig</button>
</browser>