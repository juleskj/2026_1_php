<?php


$title = "Sign up";

require_once __DIR__."/../micro-components/_header.php";

?>

<main >
    <section>
        <h1>Sign up</h1>

        <form id="signup-form" action="/api-sign-up" method="POST">
            <label for="username">Username must be between
            <?= _(USER_USERNAME_MIN) ?> and
            <?= _(USER_USERNAME_MAX) ?> characters.
            <input min="<?= _(USER_USERNAME_MIN) ?>" max="<?= _(USER_USERNAME_MAX) ?>" id="username" type="text" name="user_username" value="jens24">
        </label>
        
        <label for="email">Email

            <input id="email" type="email" name="user_email" value="jens24@gmail.com">
        </label>
        
        <label for="password">Password must be between
            <?= _(USER_PASSWORD_MIN) ?> and
            <?= _(USER_PASSWORD_MAX) ?> characters.
        
            <input min="<?= _(USER_PASSWORD_MIN) ?>" max="<?= _(USER_PASSWORD_MAX) ?>" id="password" type="password" name="user_password" value="Password123">
        </label>
        
        <label for="password_verify">Please verify password
            
            <input min="<?= _(USER_PASSWORD_MIN) ?>" max="<?= _(USER_PASSWORD_MAX) ?>" id="password_verify" type="password" name="password_verify" value="Password1234">
        </label>
        
        <label for="forename">Forename
            
            <input id="forename" type="text" name="user_forename" value="jens">
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


