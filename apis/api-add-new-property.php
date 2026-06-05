<?php

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '', 
    'secure' => true, 
    'httponly' => true,
    'samesite' => 'Strict' 
    ]);

    
session_start();
require_once __DIR__ . "/../routes.php";
require_once __DIR__ . "/../_.php";
require_once __DIR__ . "/../db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try{


        if (!is_csrf_valid()) {
            throw new Exception("Invalid CSRF token", 403);
        }


        // check if the user is actually admin before adding property
        if (!isset($_SESSION["user"])) {
           throw new Exception("no user found", 401);
        }

        if(!in_array("admin",  $_SESSION["user"]["user_role"])){
           throw new Exception("user not admin", 403);
        }

        // generate pk for house
        $pk = bin2hex(random_bytes(25));
        // dayslisted just sat to one
        $days_listed =  1;
        
        // all the rule set for the date in the save property form
        $validation_rules  = require_once __DIR__ . "/../config/validation_rules.php";
        $property_rules = $validation_rules['property'];
        
        
        // validate and saniatice all the data from the form
        $validated_data = [];
        foreach ($property_rules as $field => $rules) {
            $value = $_POST[$field] ?? null;
            $validated_data[$field] = _validate_field($field, $value, $rules);
            
        };



        // insert sql for the save propery
        $sql = "INSERT INTO items(pk, lat, lon, price, type, city_name, 
        house_number, road_name, zip_code, days_listed, energy_label, floor_square_meters, 
        lot_square_meters, monthly_expenses, number_of_rooms, price_per_meter, main_image_path, 
        floor_plan_path, deleted_at, number_of_baths, year_build, main_image_alt) 
        VALUES (:pk,:lat,:lon,:price,:type,:city_name,
        :house_number,:road_name,:zip_code,:days_listed,
        :energy_label,:floor_square_meters,:lot_square_meters,
        :monthly_expenses,:number_of_rooms,:price_per_meter,
        :main_image_path ,:floor_plan_path,'0',:number_of_baths,
        :year_build, :main_image_alt)";

        $stmt = $_db->prepare($sql);
        $stmt->bindValue(":pk", $pk);
        $stmt->bindValue(":days_listed", $days_listed);
        
        // bind all the values
        foreach ($validated_data as $field => $value) {
            $stmt->bindValue(":$field", $value);
        }          

        $stmt->execute();
       


    } catch ( Exception $e){

        error_log("Error: " . $e->getMessage() . " (Code: " . $e->getCode() . ")");


        $_SESSION['flash_state'] = "error";
        $message = $e->getMessage();
        switch (true) {
            case str_contains($message, "Invalid CSRF token"):
                $_SESSION['flash_message'] = "Invalid CSRF token";
                header('Location: /admin');
                exit;
            case str_contains($message, "no user found"):
                $_SESSION['flash_message'] = "You do not have permission to access this page";
                header('Location: /admin');
                exit;

            case str_contains($message, "user not admin"):
                $_SESSION['flash_message'] = "You do not have permission to access this page";
                header('Location: /admin');
                exit;
            
                
            case str_contains($message, "required"):
                $_SESSION['flash_message'] = $e;
                header('Location: /admin');
                exit;

            case str_contains($message, "must be an integer"):
                $_SESSION['flash_message'] = $e;
                header('Location: /admin');
                exit;

            case str_contains($message, "must be a number"):
                $_SESSION['flash_message'] = $e;
                header('Location: /admin');
                exit;
                
            case str_contains($message, "must be a string"):
                $_SESSION['flash_message'] = $e;
                header('Location: /admin');
                exit;          
            
            
            default:
                $_SESSION['flash_message'] = "An error occurred Please try again";
                header('Location: /admin');
                exit;
        }

    }
    
}

?>

<browser mix-replace="#submit-btn">
    <button type="submit" id="submit-btn" disabled>Save Bolig</button>
</browser>