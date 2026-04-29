<?php


session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    require_once __DIR__ . "/../_.php";
    
    try{

        if(filter_has_var(INPUT_POST, 'token')) {
            $token = $_POST['token'] ?? "";
            
            if (!$token || $token !== $_SESSION['token']) {
                throw new Exception('token validation failed.', 400);
            }

        } else {
            throw new Exception('token validation failed.', 400);
            
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
        error_log($e->getMessage()); // Log the error
        header('Location: /');
        // header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
        exit;
    
    }


}

?>

<browser mix-replace="#save-form-<?=_($item_pk)?>">

    <form id="save-form-<?=_($item_pk)?>" mix-post="api-unsave-property">
        <input type="hidden" name="item_pk" value="<?= _($item_pk) ?>">
        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
        <button class="bookmark solid"></button>
    </form>

</browser> 






