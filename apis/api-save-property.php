<?php


session_start();
require_once __DIR__ . "/../_.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    try{

        if (!is_csrf_valid()) {
            throw new Exception("Invalid CSRF token", 403);
        }

        $item_pk = _validate_property_pk();
        // TODO: make sure user is in session
        
        if (isset($_SESSION['user']) || $_SESSION['user'] === true) {
            
            // TODO: get user id
            $user_pk = $_SESSION['user']["user_pk"];
            
            // // TODO: connect db
            require_once __DIR__ . "/../db.php";
            // // TODO: inset into db
            $sql = "INSERT INTO saved_property(user_fk, property_fk) VALUES (:user_pk,:property_pk)";
            $stmt= $_db->prepare($sql);
            $stmt->bindValue(":user_pk", $user_pk);
            $stmt->bindValue(":property_pk", $item_pk);
            $stmt->execute();
    
            require_once __DIR__ . "/../session_utils.php";

            // TODO:save the propety in saved_homes_session
            $saved_home = track_saved_homes($item_pk);
    
        }  else{

            header('Location: /');
            exit;
        }
    
    
    } catch (Exception $e){
        

    
    
        error_log("Error: " . $e->getMessage() . " (Code: " . $e->getCode() . ")");
        $_SESSION['flash_state'] = "error";
        
        $message = $e->getMessage();
        switch (true) {
            case str_contains($message, "Invalid CSRF token"):
                $_SESSION['flash_message'] = "Invalid CSRF token";
                header('Location: /');
                exit;

            default:
                $_SESSION['flash_message'] = "An error has occurred Please try again";
                header('Location: /');
                exit;
        }
        
    }


?>

<browser mix-replace="#save-form-<?=_($item_pk)?>">

    <form id="save-form-<?=_($item_pk)?>" mix-post="api-unsave-property">
        <input type="hidden" name="item_pk" value="<?= _($item_pk) ?>">
       <?php set_csrf();?>
        <button class="bookmark solid"></button>
    </form>

</browser> 


<?php
}

?>


