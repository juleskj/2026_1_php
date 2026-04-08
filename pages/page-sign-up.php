<?php


$title = "Sign up";

require_once __DIR__."/../micro-components/_header.php";

?>

<main >
   <form action="/api-sign-up" method="POST">
        <label for="username">Username</label>
        <input id="username" type="text" name="user_username" value="jens24">
        <br>
        <label for="email">email</label>
        <input id="email" type="email" name="user_email" value="jens24@gmail.com">
        <br>
        <label for="password">password</label>
        <input id="password" type="password" name="user_password" value="Password123">
        <br>
        <label for="forename">forename</label>
        <input id="forename" type="text" name="user_forename" value="jens">
        <br>
        <label for="lastname">lastname</label>
        <input id="lastname" type="text" name="user_lastname" value="jensen">
        
        <div id="message">
            <!-- Only this content will be updated -->
            <p></p>
        </div>

        <button>sign up</button>

    </form>

</main>

<?php

require_once __DIR__."/../micro-components/_footer.php";


