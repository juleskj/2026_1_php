<?php


function track_viewed_homes($item_pk = null) {
    /*
        here i check if the item_pk is null and in the url, 
        if its in the url i gets put in the items_pk variable
    */
    
    if ($item_pk === null && isset($_GET["item_pk"])) {
        $item_pk = $_GET["item_pk"];
    }

    // If the session array doesn't exist, create it
    if (!isset($_SESSION['viewed_homes'])) {
        $_SESSION['viewed_homes'] = [];
    }

    /*
        if the item_pk is not null, when we got it from the url,
        we add it to the session. but it if is null skip it 
    */
    if ($item_pk !== null && !in_array($item_pk, $_SESSION['viewed_homes'])) {
        array_push($_SESSION['viewed_homes'], $item_pk);
    }

    // Return the session array
    return $_SESSION['viewed_homes'];
}


// get the homes from the session viewed homes and get them from the db
function get_viewed_homes(){
    require_once __DIR__ . "/db.php";
    global $_db; 
    
    // if the session for viewed_homes is not make its initlisted
    if (!isset($_SESSION['viewed_homes'])) {
        $_SESSION['viewed_homes'] = [];

    }

    $viewed_homes = [];

    if (!empty($_SESSION['viewed_homes'])) {
        // Create a placeholder string for the IN clause ("?","?")
        $placeholders = implode(',', array_fill(0, count($_SESSION['viewed_homes']), '?'));

        

        // Prepare the SQL query with placeholders
        $sql = "SELECT * FROM `items` WHERE pk IN ($placeholders) LIMIT 10";
        $stmt = $_db->prepare($sql);

        
        // Bind all home IDs at once
        foreach ($_SESSION['viewed_homes'] as $key => $home_id) {
            $stmt->bindValue($key + 1, $home_id);
        }

        $stmt->execute();
        $viewed_homes = $stmt->fetchAll();

    }
    return $viewed_homes;
}



