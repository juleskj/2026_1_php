



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    sign up
    <!--
    $user_email = _validate_user_email();
    $user_password = _validate_user_password();
    $user_username = _validate_user_username();
    $hashed_password  
    -->


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

</body>
</html>