<?php

session_start();
require_once __DIR__ . "/../_.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    try{
    
        $item_pk =  $item_pk ?? " ";

        if (!is_csrf_valid()) {
            throw new Exception("Invalid CSRF token", 403);
        }
                
                
        if (!isset($_SESSION['user']) || $_SESSION['user'] !== true){
                    
            $item_pk = _validate_property_pk();
            
            $user_pk = $_SESSION['user']["user_pk"];

            require_once __DIR__ . "/../db.php";

            $sql = "DELETE FROM `saved_property` WHERE user_fk = :user_pk AND property_fk = :property_pk";
            $stmt = $_db->prepare($sql);
            $stmt->bindValue(":property_pk",$item_pk );
            $stmt->bindValue(":user_pk",$user_pk );
            $stmt->execute();

            require_once __DIR__ . "/../session_utils.php";

            track_unsaved_homes($item_pk);
            

        }

    }catch(Exception $e){

        error_log("Error: " . $e->getMessage() . " (Code: " . $e->getCode() . ")");
        $_SESSION['flash_state'] = "error";

        $message = $e->getMessage();
        switch (true) {
            case str_contains($message, "Invalid CSRF token"):
                $_SESSION['flash_message'] = "Invalid CSRF token";
                header('Location: /page-profile');
                exit;
            
            default:
                $_SESSION['flash_message'] = "An error occurred Please try again";
                header('Location: /');
                exit;
        }
    }

    
?>


<browser mix-replace="#save-form-<?=_($item_pk)?>">

    <form id="save-form-<?=_($item_pk)?>" mix-post="api-save-property">
        <input type="hidden" name="item_pk" value="<?= _($item_pk) ?>">
       <?php set_csrf();?>
        <button class="bookmark regular"></button>
    </form>

</browser>

<?php
}


?>