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





function track_saved_homes($item_pk = null) {
    /*
        here i check if the item_pk is null and in the url, 
        if its in the url i gets put in the items_pk variable
    */
    
    if ($item_pk === null && isset($_post["item_pk"])) {
        $item_pk = $_post["item_pk"];
    }

    // If the session array doesn't exist, create it
    if (!isset($_SESSION['saved_homes'])) {
        $_SESSION['saved_homes'] = [];
    }

    /*
        if the item_pk is not null, when we got it from the url,
        we add it to the session. but it if is null skip it 
    */
    if ($item_pk !== null && !in_array($item_pk, $_SESSION['saved_homes'])) {
        array_push($_SESSION['saved_homes'], $item_pk);
    }

    // Return the session array
    return $_SESSION['saved_homes'];
}


function track_unsaved_homes($item_pk = null) {
    /*
        here i check if the item_pk is null and in the url, 
        if its in the url i gets put in the items_pk variable
    */
    
    if ($item_pk === null && isset($_POST["item_pk"])) {
        $item_pk = $_POST["item_pk"];
    }

    // If the session array doesn't exist, create it
    if (!isset($_SESSION['saved_homes'])) {
        $_SESSION['saved_homes'] = [];
    }

    // if the item pk is not null unset the item in the array
    if ($item_pk !== null) {
        $needle = array_search($item_pk, $_SESSION['saved_homes']);
        if ($needle !== false) { // Check if the key exists
            unset($_SESSION['saved_homes'][$needle]);
        }
    }
    
    return $_SESSION['saved_homes'];
}


function get_saved_homes() {
    //    TODO: get the information from db
    require_once __DIR__ . "/db.php";
    global $_db; 
    
    if (isset($_SESSION['user'])) {
        $sql = "SELECT property_fk FROM `saved_property` WHERE user_fk = :user_pk";
        $stmt = $_db->prepare($sql);
        $stmt->bindValue(":user_pk", $_SESSION['user']['user_pk'] );
        $stmt->execute();

        $saved_properties = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

        if(!isset($_SESSION['saved_homes'])){
            $_SESSION['saved_homes'] = $saved_properties;
        }

    }

    return $_SESSION['saved_homes'];
}




