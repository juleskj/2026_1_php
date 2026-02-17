<?php
require_once __DIR__."/_.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app.css">

    <link 
        rel="stylesheet" 
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    />


    <script src="app.js" defer></script>
    <title>
        <?php _($title ?? "Company") ?>
    </title>
</head>
<body>

    <nav>
        <a href="/">Home</a>
        <a href="/signup">Signup</a>
        <a href="/login">Login</a>
    </nav>








    
