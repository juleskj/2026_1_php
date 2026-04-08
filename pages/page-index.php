<?php



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
