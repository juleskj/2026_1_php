<?php
session_start();
require_once __DIR__ . "/../_.php";

if (!isset($_SESSION["user"])) {
    $_SESSION['flash_state'] = "error";
    $_SESSION['flash_message'] = "Please login to see your profile";
    header('Location: /login');
    exit;
}

$user_pk = $_SESSION["user"]["user_pk"];


// uploads image

$target_dir = "../uploads/";
$uploadOk = 1;

$new_target_file = bin2hex(random_bytes(25));

$temp = explode(".", $_FILES["fileToUpload"]["name"]);
$newfilename = $new_target_file . '.' . end($temp);



$target_file = $target_dir . $newfilename;

$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));



if (file_exists($target_dir)) {
    echo _("The directory $target_dir exists.");
} else {
    mkdir($target_dir, 0755);
    echo "The directory $target_dir was successfully created.";
    
}


// Check if image file is a actual image or fake image
if(isset($_FILES["fileToUpload"])) {
$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
} else {
    echo "File is not an image.";
    $uploadOk = 0;
}
}

if (file_exists($target_file)) {
echo "Sorry, file already exists.";
$uploadOk = 0;
}

if ($_FILES["fileToUpload"]["size"] > 500000) {
echo "Sorry, your file is too large.";
$uploadOk = 0;
}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "webp" ) {
echo "Sorry, only JPG, JPEG, PNG, WEBP files are allowed.";
$uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". _( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


require_once __DIR__ . "/../db.php";




$sql = "INSERT INTO `user_images`(`user_fk`, `user_img`) VALUES (:user_pk, :img)";
$stmt = $_db->prepare($sql);
$stmt->bindValue(":user_pk", $user_pk);
$stmt->bindValue(":img", $newfilename );
$stmt->execute();


