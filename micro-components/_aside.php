

<?php

$user = $user ?? [];

if(isset($_SESSION["user"])){
    $user = $_SESSION["user"];
}

$item = $item ?? [];

require_once __DIR__ . "/../routes.php";



?>



<section  class="vertical-scroller" >
    
    <div class="property-info">

    <?php if (empty($item['floor_plan_path'])): ?>
        <div class="img-container">

            <?php if ($item['deleted_at']): ?>
                <p><span> SOLD </span></p>
            <?php endif;?>
            
            <img 
                class='property-img'
                loading='lazy' 
                src="<?= _(_is_lmage_accessible($item['main_image_path']))?>" 
                alt='image of property'
            >      
        </div>
    <?php else: ?>
           
    <ul>
        <li class="img-container">
            
            <?php if ($item['deleted_at']): ?>
                <p><span> SOLD </span></p>
            <?php endif;?>
            
            <img 
            class="property-img" 
            loading="lazy" 
            src="<?= _(_is_lmage_accessible($item['main_image_path']))?>" 
            alt="image of property"
            >                    
            
        </li>
        <li>
            <img 
            class="property-img floor-plan-img" 
            loading="lazy" 
            src="<?= _($item['floor_plan_path']); ?>" 
            alt="image of property">
        </li>
            
    </ul>
    <?php endif;?>
    <button class="filled-btn white" onclick="map.flyTo([<?= _($item['lat']) ?>, <?= _($item['lon']) ?>], 15);">
        zoom in on map
    </button>  
    
    <!-- the user is only allowed to send a request when they are logged in -->
    <?php if($user):?>
    <form id="make-offer-form" mix-post="send_offer_request_email" onsubmit="mixhtml(); return false;">
        <input type="hidden" value="<?=_($item['pk'])?>" name="item_pk">
        <?php set_csrf(); ?>
        <button class="filled-btn blue">Make an offer</button>

    </form>
    <?php endif;?>

    <section>
        <p><?= _($item['type']) ?></p>
        <h3><?=  _($item['road_name'])?> <?= _($item['house_number'])  ?></h3>
        <p><?= _($item['zip_code'] ?? "-") . _($item['city_name']) ?></p>
        <p class="property-price">  <?=  _(number_format($item['price'], 0, ',', '.')) . " " ?> kr.</p>
    </section>
    
    
    

    
    
    <?= _row_block_HTML($item['floor_square_meters'], "fa-house", "M²", "Home size") ?>
    <?= _row_block_HTML($item['lot_square_meters'], "fa-house", "M²", "Plot size") ?>
    <?= _row_block_HTML($item['number_of_rooms'], "fa-door-open", "", "Number of rooms") ?>
    <?= _row_block_HTML($item['number_of_baths'], "fa-bath", "", "Number of bathrooms") ?>

    <?php if ($item['price_per_meter']): ?> 
    <article class="row">
        <h4>M² price</h4>
        <p><?=_(number_format($item['price_per_meter'], 0, ',', '.'))  ?> kr</p>

    </article> 
    <?php endif;?>


    <?php if ($item['energy_label']): ?> 
        <article class="row">
            <h4>Energy label</h4>
            <div class="energy-label <?= _($item['energy_label' ])  ?>"><span><?= _($item['energy_label' ])  ?></p>
            </span></div>
            <p>
        </article>  
    <?php endif;?>

    
    
    <?php if (!$item['deleted_at']): ?>
        <button id="sold" onclick="mixhtml(); return false;"
            mix-put="api-delete-item?item_pk=<?=_($item['pk'])?>">Mark as sold
        </button>
    <?php endif;?>

    

   </div>

</section>


