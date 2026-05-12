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

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    try{
        $title = "admin";
        require_once __DIR__ . "/../session_utils.php";
        require_once __DIR__ . "/../db.php";
        

        if (!isset($_SESSION["user"])) {
           throw new Exception("no user found", 401);
        }

        if(!in_array("admin",  $_SESSION["user"]["user_role"])){
           throw new Exception("user not admin", 403);
        }

        

    }catch(Exception $e){

        error_log("Error: " . $e->getMessage() . " (Code: " . $e->getCode() . ")");


        $_SESSION['flash_state'] = "error";
        $message = $e->getMessage();
        switch (true) {
            case str_contains($message, "no user found"):
                $_SESSION['flash_message'] = "You do not have permission to access this page";
                header('Location: /login');
                exit;

            case str_contains($message, "user not admin"):
                $_SESSION['flash_message'] = "You do not have permission to access this page";
                header('Location: /');
                exit;

            default:
                $_SESSION['flash_message'] = "An error occurred Please try again";
                header('Location: /');
                exit;
        }

    }


   $title = "Home";

    require_once __DIR__."/../micro-components/_header.php";
    ?>

        <main>
            <h1>hello</h1>

            <section>
                <article>

                <!-- `pk`, `lat`, `lon`, `price`, `type`, `city_name`, 
                    `house_number`, `road_name`, `zip_code`, 
                    `days_listed`, `energy_label`, `floor_square_meters`,
                    `lot_square_meters`, `monthly_expenses`, 
                    `number_of_rooms`, `price_per_meter`, 
                    `main_image_path`, `floor_plan_path`, 
                    `deleted_at`, `number_of_baths`, `year_build`, 
                    `main_image_alt` -->
                    
                    <img src="https://placehold.co/600x400" alt="">
                    <form id="add-bolig-form" mix-post="/api-add-new-property" >
                        <fieldset>
                            <legend>Address</legend>
                            <label>
                                Road name
                                <input name="road_name" type="text" placeholder="road name" required value="melissehaven">
                            </label>
                            <label>
                                city name
                                <input name="city_name" type="text" placeholder="city name" required value="herlev">
                            </label>
                            <label >
                                house number
                                <input name="house_number" type="text" placeholder="house number" required value="34b">
                            </label>
                            <input type="hidden" id="lat" name="lat" />
                            <input type="hidden" id="lon" name="lon" />
                        </fieldset>
                        <fieldset>
                            <legend>
                                overall bolig info
                            </legend>
                            <label >
                                lot square meters
                                <input name="lot_square_meters" type="text" placeholder="lot square meters">
                            </label>
                            <label >
                                floor square meters
                                <input name="floor_square_meters" type="text" placeholder="floor square meters">
                            </label>
                            <label >
                                number of rooms
                                <input name="number_of_rooms" type="text" placeholder="beds">
                            </label>
                            <label >
                                number of baths
                                <input name="number_of_baths" type="text" placeholder="baths">
                            </label>
                            <label >
                                year build
                                <input name="year_build" type="text" placeholder="year build">
                            </label>
                            <label >
                                energy label
                                <input name="energy_label" type="text" placeholder="energy label">
                            </label>
                        </fieldset>
                        <input name="monthly_expenses" type="text" placeholder="monthly expenses">


                        <button onclick="geocodeAddress()">Get Coordinates</button>

                    </form>

                    <div id="coordinates-result"></div>    
                        
                       

                       
                </article>




            </section>
        
        </main>


    <?php



    require_once __DIR__."/../micro-components/_footer.php";
    
    ?>

    <script>

        async function geocodeAddress() {
            
            const cityName= document.querySelector('input[name="city_name"]').value.trim();
            const roadName= document.querySelector('input[name="road_name"]').value.trim();
            const houseNumber= document.querySelector('input[name="house_number"]').value.trim();
            
            const address = cityName + " " + roadName + " " + houseNumber;

            
            if (!address) {
                alert("Please enter an address.");
                return;
            }

            try {
                
                const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`;

                const response = await fetch(url);

                const data = await response.json();
                console.log(data)

                if (data.length > 0) {
                const lat = parseFloat(data[0].lat);
                const lon = parseFloat(data[0].lon);

                // Update hidden fields
                document.getElementById('lat').value = lat;
                document.getElementById('lon').value = lon;

                
                document.getElementById('coordinates-result').textContent =
                    `Latitude: ${lat}, Longitude: ${lon}`;

            
                } else {
                alert("Address not found. Try a more specific query.");
                }
            } catch (error) {
                console.error("Error fetching coordinates:", error);
                alert("Failed to fetch coordinates. Check the console for details.");
            }
        }

    </script>

 