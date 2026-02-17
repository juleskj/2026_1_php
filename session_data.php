<?php

require_once __DIR__."/_.php";

session_start();

// To check if a variable exists, use isset
if(  ! isset($_SESSION["user"]) ){
    header("Location: /login.php");
}















