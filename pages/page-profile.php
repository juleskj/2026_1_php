<?php
    session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '', // Adjust as needed
    'secure' => true, // Only send over HTTPS
    'httponly' => true,
    'samesite' => 'Lax' // or 'Strict'
    ]);


    session_start();
    
    try{
        $title = "Profile";
        require_once __DIR__ . "/../session_utils.php";
        require_once __DIR__ . "/../db.php";
        
   
        if (!isset($_SESSION["user"])) {
            $_SESSION['flash_state'] = "error";
            $_SESSION['flash_message'] = "Please login to see your profile";
            header('Location: /login');
            exit;
        }
            
        if (!empty($_SESSION['viewed_homes'])) {
            $viewed_homes = get_viewed_homes();
        }
        


    }catch(Exception $e){

    }

    require_once __DIR__."/../micro-components/_header.php";

    _render_flash_msg();

?>
<main >
    <section id="profil-content">
        <aside class="user-info">

            <img id="profile-img" src="/../uploads/<?= _($user["user_image"]) ?>" alt="">
            <form action="api-upload" method="POST" enctype="multipart/form-data">
                Select image to upload:
                <input type="file" name="fileToUpload" id="fileToUpload" onChange="inputOnChange(this);">
                <input type="submit" value="Upload Image" name="submit">
            </form>
            <section>
                <h2>name</h2>
                <p>adress zip</p>
                <p>phone</p>

            </section>



        </aside>
        <section>

            <h1>Profile</h1>
            <h2>welcome back <?= _($user["user_forename"] . " ". $user["user_lastname"]) ?></h2>

            
            <?php

                if(!empty($viewed_homes)){
                    $items = $viewed_homes;
                    $scroller_header = "Your recently viewed homes!";
                    require_once __DIR__ . "/../micro-components/_scroller.php";
                }
            
            ?>
        </section>
    </section>
   
 

    


  
    

</main>


<?php

require_once __DIR__."/../micro-components/_footer.php";


