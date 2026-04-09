<?php

session_start(); 


$_SESSION = array(); 
session_destroy();   


header('Content-Type: application/json');

_(json_encode(['success' => true]));