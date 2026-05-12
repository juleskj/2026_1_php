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


$lat = $_POST["lat"];
$lon = $_POST["lon"];

echo $lat . " " . $lon;


?>

<browser mix-replace="#submit-btn">
    <button type="submit" id="submit-btn" disabled>Save Bolig</button>
</browser>