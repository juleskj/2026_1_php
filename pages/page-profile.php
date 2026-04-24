<?php
try{
    session_start();
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

?>
<main >
    <section id="main-content">
        <section class="user-info">
        
            <img src="https://placehold.co/600x400" alt="">

            <section>
                <h2>name</h2>
                <p>adress zip</p>
                <p>phone</p>

            </section>



        </section>
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


