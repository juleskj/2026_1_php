<?php


$title = "Login";

require_once __DIR__."/../micro-components/_header.php";

?>

<main id="page-login">
    <form id="login-form" action="/api-login" method="POST">
        <label for="email">
            email 
            <input type="email" name="user_email" id="email" value="jules@gmail.com">
        </label>
        
        <label for="password">
            password 
            <input type="password" name="user_password" id="password" value="password">
        </label>
       
        <button class="filled-btn blue">submit</button>
    </form>

</main>

<?php

require_once __DIR__."/../micro-components/_footer.php";