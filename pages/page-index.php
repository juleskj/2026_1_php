<?php
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '', // Adjust as needed
    'secure' => true, // Only send over HTTPS
    'httponly' => true,
    'samesite' => 'Lax' // or 'Strict'
]);


// start the session
session_start();

// if the session for viewed_homes is not make its initlisted
if (!isset($_SESSION['viewed_homes'])) {
    $_SESSION['viewed_homes'] = [];

}

$title = "Home";


require_once __DIR__."/../micro-components/_header.php";
require_once __DIR__."/../micro-components/_main.php";
require_once __DIR__."/../micro-components/_footer.php";
