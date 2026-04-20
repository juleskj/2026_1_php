<?php

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once __DIR__ . "/../_.php";

    try{
        $item_pk = validate_property_pk();

        $user = "";

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            exit("CSRF token validation failed.");
        }

        if (!empty($_SESSION['user'])){

            $user = $_SESSION['user'];
            $user_pk = $user["user_pk"];

            require_once __DIR__ . "/../db.php";

            $sql = "DELETE FROM `saved_property` WHERE user_fk = :user_pk AND property_fk = :property_pk";
            $stmt = $_db->prepare($sql);
            $stmt->bindValue(":property_pk",$item_pk );
            $stmt->bindValue(":user_pk",$user_pk );
            $stmt->execute();

            
            require_once __DIR__ . "/../session_utils.php";

            track_unsaved_homes($item_pk);
            echo json_encode($_SESSION['saved_homes']);
            // echo  $item_pk;

        }

    }catch(Exception $e){


    }

}


?>

<browser mix-replace="#save-form-<?=_($item_pk)?>">

    <form id="save-form-<?=_($item_pk)?>" mix-post="api-save-property">
        <input type="hidden" name="item_pk" value="<?= _($item_pk) ?>">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <button class="bookmark regular"></button>
    </form>

</browser>
