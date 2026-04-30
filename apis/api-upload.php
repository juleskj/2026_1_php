<?php
session_start();
require_once __DIR__ . "/../_.php";



require_once __DIR__ . "/../db.php";
require_once __DIR__ . "/../db.php";
// TODO: check if user has image if so delet it




try{
        
    if (!isset($_SESSION["user"])) {
        $_SESSION['flash_state'] = "error";
        $_SESSION['flash_message'] = "Please login to see your profile";
        header('Location: /login');
        exit;
    }
    $target_dir = "../uploads/";

    $user_pk = $_SESSION["user"]["user_pk"];



    // folder for images
    $uploadOk = 1;

    // new file name 
    $new_target_file = bin2hex(random_bytes(25));

    $temp = explode(".", $_FILES["fileToUpload"]["name"]);
    $newfilename = $new_target_file . '.' . end($temp);

    // the file path for image
    $target_file = $target_dir . $newfilename;

    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // make sure the dir exeist else make it !
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755);
    }


    // Check if image file is a actual image or fake image
    if(isset($_FILES["fileToUpload"])) {
        
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            
            $uploadOk = 1;
        } else {
            
            $uploadOk = 0;
        }
    }

    // TODO: throw new exeption
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $_SESSION['flash_state'] = "error";
        $_SESSION['flash_message'] = "Sorry your file is too large";
        header('Location: /page-profile');
        exit;
       
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "webp" ) {
        $_SESSION['flash_state'] = "error";
        $_SESSION['flash_message'] = "Sorry only JPG, JPEG, PNG, WEBP files are allowed";
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


        $_SESSION['flash_state'] = "success";
        $_SESSION['flash_message'] = "the file has been uploaded";
        header('Location: /page-profile');
        
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

            $old_target_file = $target_dir . $_SESSION["user"]["user_image"];

            if(file_exists($old_target_file)){
            
                $filepath = $target_dir . $old_target_file;

                // Get the canonicalized absolute pathname
                $absolutePath = realpath($filepath);

                // Check if the file exists and is writable
                if ($absolutePath !== false && is_writable($absolutePath)) {
                    // Attempt to delete the file
                    unlink($absolutePath);
                }

            }

            $sql = "DELETE FROM `user_images` where user_fk = :user_pk";
            $stmt = $_db->prepare($sql);
            $stmt->bindValue(":user_pk", $user_pk);
            $stmt->execute();

            $_SESSION["user"]["user_image"] = $newfilename;


            $_SESSION['flash_state'] = "success";
            $_SESSION['flash_message'] = "the file has been uploaded";
            header('Location: /page-profile');
            
        } else {
            $_SESSION['flash_state'] = "error";
            $_SESSION['flash_message'] = "Sorry there was an error uploading your file";
            header('Location: /page-profile');
        }
    }


   


    $sql = "INSERT INTO `user_images`(`user_fk`, `user_img`) VALUES (:user_pk, :img)";
    $stmt = $_db->prepare($sql);
    $stmt->bindValue(":user_pk", $user_pk);
    $stmt->bindValue(":img", $newfilename );
    $stmt->execute();


    // TODO: if user already has an img, update insted of inserting
    //TODO: if the image is already in the 
    // uplodas file delete it after update so that isnt two images for the same user

}catch ( Exception $e){


}
