<?php
// start the session
session_start();

$msg = "hello";
$flash_state = "success";
include '../micro-components/_flash-message.php';


// if the session for viewed_homes is not make its initlisted
if (!isset($_SESSION['viewed_homes'])) {
    $_SESSION['viewed_homes'] = [];

}

$title = "Home";

require_once __DIR__."/../micro-components/_header.php";

require_once __DIR__."/../micro-components/_footer.php";

