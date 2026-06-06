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

$title = "Login";

require_once __DIR__ . "/../_.php";
require_once __DIR__."/../micro-components/_header.php";



_render_flash_msg();

?>

<main id="page-login">
    <section>
        <h1>Login to boligside</h1>
        <!-- <div class="alert-msg"><p>Please login</p></div> -->

        <form id="login-form" action="/api-login" method="POST">
            <?php set_csrf();?>
            <label for="email">
                email 
                <input type="email" name="user_email" id="email" value="juljen2730@gmail.com">
            </label>
            
            <label for="password">
                password 
                <input type="password" name="user_password" id="password" value="password">
            </label>
            
            <button class="filled-btn blue">submit</button>
        </form>
    </section>

</main>

<?php

require_once __DIR__."/../micro-components/_footer.php";