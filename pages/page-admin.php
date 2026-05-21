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
        
    require_once __DIR__ . "/../session_utils.php";
    require_once __DIR__ . "/../db.php";

    
        try{
            
        

            if (!isset($_SESSION["user"]) || !is_array($_SESSION["user"])) {

                throw new Exception("no user found", 401);
            
            }

            if (!isset($_SESSION["user"]["user_role"]) || !in_array("admin", $_SESSION["user"]["user_role"], true)) {
                
                throw new Exception("user not admin", 403);
                
            }

            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            

            $user = $_SESSION["user"];

            // TODO: get items so that admin can "delete/sold" them
            //TODO: user can contact about a bolig and admin can accept or declin and the user gets and email.
            
            
            require_once __DIR__ . "/../db.php";
            $sql ="SELECT * FROM `user_property_offers`";
            $stmt = $_db->prepare($sql);
            $stmt->execute();
            $all_offers = $stmt->fetchAll();

            

            $all_offers_data = [];
            

            foreach($all_offers as $offer){
                $sql ="CALL `get_offer_details_of_user_and_property`(:user_fk, :property_fk)";
                $stmt = $_db->prepare($sql);
                $stmt->bindValue(":user_fk", $offer["user_fk"]);
                $stmt->bindValue(":property_fk", $offer["property_fk"]);
                $stmt->execute();
                $one_offers_data = $stmt->fetch();
                
                array_push($all_offers_data, $one_offers_data);
                

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
    


    $title = "admin";
    require_once __DIR__."/../micro-components/_header.php";
    _render_flash_msg();

    ?>

        <main>
            <section id="admin-content">
                <aside class="admin-info">
                    

                    <img id="profile-img" src="/../uploads/<?= _($user["user_image"]) ?>" alt="">

                    <div id="update-pfp-module">
                        <button class="filled-btn white" data-module="update-pfp" onclick="showModule(this);">update profile pic</button>    

                        <div class="hidden" id="update-pfp-form">

                            <form action="api-upload" method="POST" enctype="multipart/form-data">
                                Select image to upload:
                                <input type="file" name="fileToUpload" id="fileToUpload" onChange="inputOnChange(this);">
                                <input type="submit" value="Upload Image" name="submit">
                            </form>
                        </div>
                    </div>
                    <section>
                        <h2>@<?= _($user["user_username"]) ?></h2>
                        <p><?= _($user["user_forename"]) ?> <?= _($user["user_lastname"]) ?> </p>
                    </section>

                </aside>
                    
                <section>
                   
                    <section class="scroll-container">

                        <h2>offers from buyers</h2>
                        <!-- TODO: make button to decline or accept offer from buyer -->
                        <!-- TODO: send email to buyer regarding request -->
                         
                        <section class="scroller" >
                        <?php if(!empty($all_offers_data)): ?>
                            <?php foreach ($all_offers_data as $offer): ?>
                                <a href="/page-map?item_pk=<?= $offer['pk'] ?>">
                                    <article class="bolig-kort">
                                        <!-- Property Image -->
                                        <?php if (empty($offer['floor_plan_path'])): ?>
                                            <div class="img-container">
                                                <?php if ($offer['deleted_at']): ?>
                                                    <p><span>SOLD</span></p>
                                                <?php endif; ?>
                                                <img
                                                    loading="lazy"
                                                    src="<?= _(_is_lmage_accessible($offer['main_image_path'])) ?>"
                                                    alt="Property image"
                                                >
                                            </div>
                                        <?php else: ?>
                                            <ul>
                                                <li class="img-container">
                                                    <?php if ($offer['deleted_at']): ?>
                                                        <p><span>SOLD</span></p>
                                                    <?php endif; ?>
                                                    <img
                                                        class="property-img"
                                                        loading="lazy"
                                                        src="<?= _(_is_lmage_accessible($offer['main_image_path'])) ?>"
                                                        alt="Property image"
                                                    >
                                                </li>
                                                <li>
                                                    <img
                                                        class="property-img floor-plan-img"
                                                        loading="lazy"
                                                        src="<?= _($offer['floor_plan_path']) ?>"
                                                        alt="Floor plan"
                                                    >
                                                </li>
                                            </ul>
                                        <?php endif; ?>

                                        <!-- Property Info -->
                                        <div class="bolig-info">
                                            <p><span><?= _($offer["type"]) ?></span></p>
                                            <h3><?= _($offer['road_name']) ?> <?= _($offer['house_number']) ?></h3>
                                            <p><?= _($offer['zip_code']) ?> <?= _($offer['city_name']) ?></p>
                                            <p class="pris"><?= _(number_format($offer['price'], 0, ',', '.') . "kr") ?></p>
                                        </div>

                                        <!-- User Info (Offer Maker) -->
                                        <div class="user-info">
                                            <p><strong>Offer by:</strong> <?= _($offer['user_forename']) ?> <?= _($offer['user_lastname']) ?></p>
                                            <p><strong>Email:</strong> <?= _($offer['user_email']) ?></p>
                                        </div>
                                    </article>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </section>
                        
                    </section>
            

                    <article>
                        <div id="save-property-module">
                            <button class="filled-btn blue" data-module="save-property" onclick="showModule(this);">add new property</button>    

                            <div class="hidden" id="save-property-form">

                                <img class="property-image" src="https://placehold.co/600x400" alt="">
                                <form id="add-bolig-form" mix-post="/api-add-new-property" >
                                    <input type="hidden" value="<?= _($_SESSION['csrf_token']) ?>" name="csrf_token">
                                    <fieldset id="address">
                                        <legend>Address</legend>
                                        <label>
                                            zip code
                                            <input name="zip_code" pattern="\d{4}" type="string"  min="4" max="4" placeholder="zip code" required value="2730">
                                        </label>
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
                                        <div id="coordinates-result"></div>
                                    </fieldset>
                                    <fieldset id="property-info">
                                        <legend>
                                            overall bolig info
                                        </legend>
                                    
                                        
                                        <label>
                                            Lot square meters
                                            <input
                                                name="lot_square_meters"
                                                type="text"
                                                placeholder="lot square meters"
                                                pattern="^[0-9]+(\.[0-9]{1,2})?$"
                                                title="Must be a positive number (e.g., 100 or 123.45)"
                                                required
                                            >
                                        </label>
            
                                        
                                        <label>
                                            Floor square meters
                                            <input
                                                name="floor_square_meters"
                                                type="text"
                                                placeholder="floor square meters"
                                                pattern="^[0-9]+(\.[0-9]{1,2})?$"
                                                title="Must be a positive number (e.g., 80 or 99.99)"
                                                required
                                            >
                                        </label>
            
                                    
                                        <label>
                                            Number of baths
                                            <input
                                                type="number"
                                                name="number_of_baths"
                                                min="1"
                                                max="10"
                                                step="1"
                                                required
                                                placeholder="e.g., 3">
                                        </label>
            
                                        
                                    <label>
                                            Number of Rooms
                                            <input
                                                type="number"
                                                name="number_of_rooms"
                                                min="1"
                                                max="20"
                                                step="1"
                                                required
                                                placeholder="e.g., 3">
                                        </label>
            
                                        
                                        <label>
                                            Year built
                                            <input
                                                name="year_build"
                                                type="text"
                                                placeholder="year built"
                                                pattern="^(19|20)\d{2}$"
                                                title="Must be a 4-digit year (e.g., 1990, 2025)"
                                                required
                                            >
                                        </label>
            
                                    
                                        <label>
                                            Energy label
                                            <input
                                                name="energy_label"
                                                type="text"
                                                placeholder="energy label"
                                                pattern="^(A1|A2|B|C|D|E|F|G)$"
                                                title="Must be a valid energy label (A1, A2, B, C, D, E, F, G)"
                                                required
                                            >
                                        </label>
                                        <label>
                                            House type
                                            <input
                                                name="type"
                                                type="text"
                                                placeholder="House type"
                                                
                                                title="Must be a positive number (e.g., 100 or 123.45)"
                                                required
                                            >
                                        </label>
                                    
                                    </fieldset>
                                    <fieldset id="expenses">
                                        <legend>Expenses</legend>
                                        <label>
                                            monthly expenses
                                            <input name="monthly_expenses" type="text" placeholder="monthly expenses">
                                        </label>
                                        <label>
                                            price per meter
                                            <input name="price_per_meter" type="text" placeholder="price per meter">
                                        </label>
                                        <label>
                                            price
                                            <input name="price" type="text" placeholder="price">
                                        </label>
                                    </fieldset>
            
            
                                    <button type="button" onclick="geocodeAddress()">Resolve Coordinates</button>
                                    <button type="submit" id="submit-btn" disabled>Save Bolig</button>
                                    
            
                                </form>
                            </div>
                        </div>

                            
                                                
                    </article>

                </section>
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
            const zipCode= document.querySelector('input[name="zip_code"]').value.trim();

            const address = cityName + " "+ zipCode + " " + roadName + " " + houseNumber;

            
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

                document.getElementById('submit-btn').disabled = false;

            
                } else {
                alert("Address not found. Try a more specific query.");
                document.getElementById('submit-btn').disabled = true;
                }
            } catch (error) {
                console.error("Error fetching coordinates:", error);
                alert("Failed to fetch coordinates. Check the console for details.");
                document.getElementById('submit-btn').disabled = true;
            }
        }

    </script>

 