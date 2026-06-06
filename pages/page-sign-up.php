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

$title = "Sign up";

require_once __DIR__."/../micro-components/_header.php";
require_once __DIR__."/../_.php";


_render_flash_msg();
?>




<main >

    <section>
        <h1>Sign up</h1>
        
        <div class="alert-msg"><p>welcome to boligsiden please sign up</p></div>

        <form action="api-sign-up" method="post" id="signup-form">
        <?php set_csrf();?>
        <label for="username">Username must be between
            <?= _(USER_USERNAME_MIN) ?> and
            <?= _(USER_USERNAME_MAX) ?> characters.
            <input min="<?= _(USER_USERNAME_MIN) ?>" max="<?= _(USER_USERNAME_MAX) ?>" id="username" type="text" name="user_username" value="jules307">
        </label>
        
        <label for="email">Email

            <input id="email" type="email" name="user_email" value="juljen2730@gmail.com">
        </label>
        
        <label for="password">Password must be between
            <?= _(USER_PASSWORD_MIN) ?> and
            <?= _(USER_PASSWORD_MAX) ?> characters.
        
            <input min="<?= _(USER_PASSWORD_MIN) ?>" max="<?= _(USER_PASSWORD_MAX) ?>" id="password" type="password" name="user_password" value="password">
        </label>
        
        <label for="password_verify">Please verify password
            
            <input min="<?= _(USER_PASSWORD_MIN) ?>" max="<?= _(USER_PASSWORD_MAX) ?>" id="password_verify" type="password" name="password_verify" value="password">
        </label>
        
        <label for="forename">Forename
            
            <input id="forename" type="text" name="user_forename" value="jules">
        </label>
        
        <label for="lastname">Lastname
            <input id="lastname" type="text" name="user_lastname" value="jensen">
            
        </label>
        
        <div id="message">
            <!-- Only this content will be updated -->
            <p></p>
        </div>
       
        
        <button class="filled-btn blue">sign up</button>
        
    </form>
</section>
    
</main>

<?php

require_once __DIR__."/../micro-components/_footer.php";


