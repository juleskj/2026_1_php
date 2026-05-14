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
        
        $days_listed =  $_POST[""] ?? null;
        

        $main_image_path =  $_POST[""] ?? null;
        $floor_plan_path =  $_POST[""] ?? null;
        $main_image_alt =  $_POST[""]?? null;

        $validation_rules  = require_once __DIR__ . "/../config/validation_rules.php";
        $property_rules = $validation_rules['property'];
        
        require_once __DIR__ . "/../_.php";

        $validated_data = [];
        foreach ($property_rules as $field => $rules) {
            $value = $_POST[$field] ?? null;
            $validated_data[$field] = _validate_field($field, $value, $rules);
            
        };
        
        


    } catch ( Exception $e){

        echo $e;

    }
    
}

?>

<browser mix-replace="#submit-btn">
    <button type="submit" id="submit-btn" disabled>Save Bolig</button>
</browser>