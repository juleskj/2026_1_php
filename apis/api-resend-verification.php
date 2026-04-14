<?php
// TODO make throw new execetions

try{

        date_default_timezone_set('Europe/Copenhagen'); //makes sure its the correct time stamp

        $user_email = $_GET["email"] ?? "";

     
    require_once __DIR__ . "/../_.php";
    require_once __DIR__ . "/../db.php";

    $sql ="SELECT verification_token FROM `users` WHERE user_email = :email";
    $stmt = $_db->prepare( $sql );

    $stmt->bindValue(":email", $user_email);
    $stmt->execute();

    $user = $stmt->fetch();
    
   

    if($user['verification_token']){
        $new_token = bin2hex(random_bytes(25)); // Returns 50 characters
        $new_expire_date = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $sql = "UPDATE users SET verification_token= :new_token, token_expires_at= :new_expire_date 
        WHERE user_email = :email";

        $stmt = $_db->prepare($sql);
        $stmt->bindValue(":new_token", $new_token);
        $stmt->bindValue(":new_expire_date", $new_expire_date);
        $stmt->bindValue(":email", $user_email);
        $stmt->execute();
        
        _send_welcome_email($user_email, true);

        echo"ok";
        
    } else {
        echo "no token";
        exit;
                    
    }
        
}catch(Exception $e){

}
    
    

