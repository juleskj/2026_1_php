<?php
require_once __DIR__.'/router.php';

get('/', 'pages/page-index.php');
get('/contact-us', 'pages/page-contact-us.php');
get('/about-us', 'pages/page-about-us.php');
get('/page-map', 'pages/page-map.php');


get('/apis/api-get-map-item', 'apis/api-get-map-item.php');
put('/apis/api-delete-item', '/apis/api-delete-item.php');
get('/items/$category', 'pages/items.php');
get('/items/$category/size/$size', 'pages/items.php');


// Load .env
foreach (file(__DIR__ . '/.env') as $line) {
    $line = trim($line);
    if ($line === '' || str_starts_with($line, '#')) continue;
    [$key, $value] = explode('=', $line, 2);
    $_ENV[trim($key)] = trim($value);
}

