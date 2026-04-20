<?php
    $user =  $_SESSION["user"] ?? "";

    $saved_homes = $_SESSION["saved_homes"] ?? [];

    if (empty($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(random_bytes(32));
    }

?>


<section class="scroll-container">

    <h2><?php _($scroller_header ?? "header")?></h2>
            
    <section class="scroller" >
        <?php foreach ($items as $item): ?>
            <article id="<?= _($item["pk"]) ?>" class="scroll-item">
                
                <?php if($user){ ?>
                    <form id="save-form-<?=_($item['pk'])?>" mix-post="<?= in_array($item["pk"], $saved_homes) ? "api-unsave-property" : "api-save-property" ?>">
                        <input type="hidden" name="item_pk" value="<?= _($item['pk'], ENT_QUOTES, 'UTF-8') ?>">
                        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                        <button class="bookmark <?= in_array($item["pk"], $saved_homes) ? "solid" : "regular" ?>"></button>
                    </form>
                <?php } ?>

                <a href="/page-map?item_pk=<?= $item['pk']?>">
                    <img 
                    class="property-img" 
                    loading="lazy" 
                    src="<?= _($item['main_image_path']); ?>" 
                    alt="image of property"
                    >              
                    <article>
                        
                        <p class="type <?= str_replace(' ', '_',  $item['type']); ?>"><?= _($item['type'] ?? '') ?></p>
                        <h3><?php _(number_format($item['price'], 0, ',', '.')) ?>kr</h3>
                        <p><span><?php _($item['number_of_rooms'] ?? '0') ?> beds</span><span>1 ba</span><span><?php _($item['lot_square_meters']) . " " || _($item['floor_square_meters'] ?? '')  ?> sqft</span></p>
                        <p><?php _($item['house_number'] ?? '')?> <?php _($item['road_name'])?>, <?php _($item['city_name'])?> <?php _($item['zip_code']) ?></p>
                    </article>
                </a>
            </article>
        <?php endforeach; ?>  
        <a class="see-more filled-btn white" href="/page-map">See more <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>     

    </section>
</section>

<script>



</script>

