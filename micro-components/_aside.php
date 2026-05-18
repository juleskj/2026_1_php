


<section  class="vertical-scroller" >
    
    <div class="property-info">

    


    <?php if (empty($item['floor_plan_path'])): ?>
        <div class="img-container">

            <?php if ($item['deleted_at']): ?>
                <p><span> SOLD </span></p>
            <?php endif;?>
            
            <img 
            class="property-img" 
            loading="lazy" 
            src="<?= _($item['main_image_path']); ?>" 
            alt="image of property"
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
            src="<?= _($item['main_image_path']); ?>" 
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
    <button class="filled-btn blue" onclick="map.flyTo([<?= _($item['lat']) ?>, <?= _($item['lon']) ?>], 15);">
        zoom in on map
    </button>   
    <section>
        <p><?= _($item['type']) ?></p>
        <h3><?=  _($item['road_name'])?> <?= _($item['house_number'])  ?></h3>
        <p><?= _($item['zip_code'] ?? "-") . _($item['city_name']) ?></p>
        <p class="property-price">  <?=  _(number_format($item['price'], 0, ',', '.')) ?> kr</p>
    </section>
    
            
      
    <?php if (isset($item['floor_square_meters']) && $item['floor_square_meters'] !== null): ?>
        <article class="row">
            <h4><i class="fa-solid fa-house" style="color: rgb(64, 92, 185);"></i> Home size</h4>
            <p><?= _($item['floor_square_meters']) ?> M²</p>
        </article>
    <?php endif; ?>

   
    <?php if (isset($item['lot_square_meters']) && $item['lot_square_meters'] !== null): ?>
        <article class="row">
            <h4><i class="fa-solid fa-house" style="color: rgb(64, 92, 185);"></i> plot size</h4>
            <p><?= _($item['lot_square_meters']) ?> M²</p>
        </article>
    <?php endif; ?>

    
    <?php if (isset($item['number_of_rooms']) && $item['number_of_rooms'] !== null): ?>
        <article class="row">
            <h4><i class="fa-solid fa-door-open" style="color: rgb(64, 92, 185);"></i> Number of rooms</h4>
            <p><?= _($item['number_of_rooms']) ?></p>
        </article>
    <?php endif; ?>

  
    <?php if (isset($item['number_of_baths']) && $item['number_of_baths'] !== null): ?>
        <article class="row">
            <h4><i class="fa-solid fa-bath" style="color: rgb(64, 92, 185);"></i> Number of bathrooms</h4>
            <p><?= _($item['number_of_baths']) ?></p>
        </article>
    <?php endif; ?>   
       

    <article class="row">
        <h4>M² price</h4>
        <p><?=_(number_format($item['price_per_meter'], 0, ',', '.'))  ?> kr</p>

    </article>  
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