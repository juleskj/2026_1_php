<?php
session_start();


$item_pk = $_POST["item_pk"];

if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    echo "no token";
    exit;
}

echo json_encode($item_pk);