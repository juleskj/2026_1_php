<?php

    require_once __DIR__ . "/../_.php";

    $flash_state = $flash_state ?? "";

    $msg = $msg ?? '';
    $msg = _validate_flash_message($msg);

?>


<div class="flash-message hidden <?= _($flash_state ?? "message") ?>">

    <?php if($flash_state == "error"){
        ?>
        <i class="fa-solid fa-xmark" style="color: rgb(64, 92, 185);"></i>
    <?php

    }if($flash_state == "success"){
    ?>
        <i class="fa-solid fa-check" style="color: rgb(64, 92, 185);"></i>
    <?php
    } 
    
    ?>




    <p ><?= _($msg ?? "no message") ?></p>
</div>


<script>

    

    function showFlash() {
        const flash = document.querySelector(".flash-message");

        
        flash.classList.remove("hidden");
        flash.classList.add("fade-in");

        
        setTimeout(() => {
            flash.classList.remove("fade-in");
            flash.classList.add("fade-out");

        
            setTimeout(() => {
            flash.classList.add("hidden");
            flash.classList.remove("fade-out");
            }, 500);
        }, 5000);
    }
        
    if("<?php _($msg)?>" !== "welcome to boligsiden please sign up"){
        showFlash();
    
    }
    
      

</script>