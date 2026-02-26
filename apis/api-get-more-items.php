<?php

// If the code doesn't continue with HTML, then no need to close the PHP tag
// 55.67097961082087, 12.524201760514044

// Connect to the database and get more items, not just 1
// hard code 2 items and respond back to the browser
// the browser show the 2 new properties

// You will need a loop, bcs you could have 10 items or more

$data = [
    "lat" => "55.67097961082087",
    "lon" => "12.524201760514044",
    "item_pk" => "3"
];
$data = json_encode($data); // this is json string it is NOT JSON

echo "<browser mix-function='test'>$data</browser>";





