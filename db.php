<?php

// Load .env
foreach (file(__DIR__ . '/.env') as $line) {
    $line = trim($line);
    if ($line === '' || str_starts_with($line, '#')) continue;
    [$key, $value] = explode('=', $line, 2);
    $_ENV[trim($key)] = trim($value);
}
// PDO
try{


  $dbConnection = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=utf8mb4';

  // utf8 every character in the world
  // mb4 every character and also emojies
  $options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // try-catch
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // ['nickname']
    //PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ // ->nickname
    // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_NUM // [[2],[],[]]
  ];
  $_db = new PDO($dbConnection, $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $options);

  
}catch(PDOException $ex){
  echo $ex;  
  exit(); //die
}