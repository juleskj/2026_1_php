<?php



session_start();
require_once __DIR__ . "/../_.php";

require_once __DIR__ . "/../db.php";

try{
        
    if (!isset($_SESSION["user"])) {
        $_SESSION['flash_state'] = "error";
        $_SESSION['flash_message'] = "Please login to see your profile";
        header('Location: /login');
        exit;
    }

    $target_dir = "../uploads/";
    $user_pk = $_SESSION["user"]["user_pk"];
    $uploadOk = 1;

    
    $new_target_file = bin2hex(random_bytes(25));
    $temp = explode(".", $_FILES["fileToUpload"]["name"]);
    $newfilename = $new_target_file . '.' . end($temp);

   
    $target_file = $target_dir . $newfilename;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


    // make sure the dir exeist else make it !
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755);
    }

    // validates image
    $validation = _validate_uploded_file($_FILES["fileToUpload"]);

    if (!$validation['valid']) {
        $_SESSION['flash_state'] = "error";
        $_SESSION['flash_message'] = $validation['message'];
        header('Location: /page-profile');
        exit;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $_SESSION['flash_state'] = "error";
        $_SESSION['flash_message'] = "Sorry your file was not uploaded";
        header('Location: /page-profile');
        exit;
        // if everything is ok, try to upload file
    } else {
        
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

            // delete the old image from the uplods file and db
            if (isset($_SESSION["user"]["user_image"])) {
                _delete_old_user_image($user_pk, $_SESSION["user"]["user_image"], $target_dir, $_db);
            }
           
            $_SESSION["user"]["user_image"] = $newfilename;


            $sql = "INSERT INTO `user_images`(`user_fk`, `user_img`) VALUES (:user_pk, :img)";
            $stmt = $_db->prepare($sql);
            $stmt->bindValue(":user_pk", $user_pk);
            $stmt->bindValue(":img", $newfilename );
            $stmt->execute();


            $_SESSION['flash_state'] = "success";
            $_SESSION['flash_message'] = "the file has been uploaded";
            header('Location: /page-profile');
            exit;
            
        } else {
            $_SESSION['flash_state'] = "error";
            $_SESSION['flash_message'] = "Sorry there was an error uploading your file";
            header('Location: /page-profile');
            exit;
        }
    }


}catch ( Exception $e){


}
