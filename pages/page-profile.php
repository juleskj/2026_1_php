<?php
session_start();
try{


$title = "Profile";

if (!isset($_SESSION["user"])) {
    $_SESSION['flash_message'] = "Please login to see your profile";
    header('Location: /login');
    exit;
}


$user = "";
if(!empty($_SESSION["user"])){
    $user = $_SESSION["user"];
}



}catch(Exception $e){

}
require_once __DIR__."/../micro-components/_header.php";

?>

<main >
    <h1>Profile</h1>
    <section>
        <h2><?= _($user["user_forename"]) . "" .  _($user["user_lastname"])?></h2>
    </section>
</main>

<?php

require_once __DIR__."/../micro-components/_footer.php";


