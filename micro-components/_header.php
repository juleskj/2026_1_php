<?php

require_once __DIR__."/../_.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />    
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
    <script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>

    <script src="https://kit.fontawesome.com/a6a9ce4355.js" crossorigin="anonymous"></script>

    <link rel="icon" type="image/x-icon" href="/images/house-solid-full.svg">
    <link rel="stylesheet" href="css/app.css">
    <title>
        <?php
            _($title ?? "Company");
        ?>

    </title>
</head>
<body>
    <nav>
        <a href="/">Home</a>
        <a href="/page-map">Map</a>
        <a href="/login">Login</a>
        <a class="filled-btn blue" href="/sign-up">Sign up</a>
       
        <!-- <button mix-get="/apis/api-get-more-items"> get more items</button> -->
        
    </nav>

    
