<?php

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once __DIR__ . "/../_.php";

    try{

    
        if(filter_has_var(INPUT_POST, 'token')) {
            $token = $_POST['token'];
            
            if (!$token || $token !== $_SESSION['token']) {
                throw new Exception('token validation failed.', 400);
            }

        } else {
            throw new Exception('token validation failed.', 400);
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

        error_log($e->getMessage()); // Log the error
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
        exit;
   
    }

    

}


?>

<browser mix-replace="#save-form-<?=_($item_pk)?>">

    <form id="save-form-<?=_($item_pk)?>" mix-post="api-save-property">
        <input type="hidden" name="item_pk" value="<?= _($item_pk) ?>">
        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
        <button class="bookmark regular"></button>
    </form>

</browser>
