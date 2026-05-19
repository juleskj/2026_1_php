
<?php

$firstNElements = $firstNElements ?? [];
?>


<h2 class="info-h2">Udvalgte boliger</h2>
<div class="vertical-scroller">
    <!-- Eksempel på boligkort -->
        <?php if($firstNElements): ?>
        <?php foreach ($firstNElements as $item){ ?>

        <a href="/page-map?item_pk=<?= $item['pk']?>">
        <article class="bolig-kort">

        <?php if (empty($item['floor_plan_path'])): ?>
            <div class="img-container">

                <?php if ($item['deleted_at']): ?>
                    <p><span> SOLD </span></p>
                <?php endif;?>
                
                <img 
                    
                    loading="lazy" 
                    src="<?= _(_is_lmage_accessible($item['main_image_path'])); ?>" 
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
                src="<?= _(_is_lmage_accessible($item['main_image_path'])); ?>" 
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
                <div class="bolig-info">
                <p><span><?= _( $item["type"]) ?></span></p>
                <h3><?=  _($item['road_name'])?> <?= _($item['house_number'])  ?></h3>
                <p><?= _($item['zip_code']) ?> <?= _($item['city_name']) ?></p>
                <p class="pris"><?= _(number_format($item['price'], 0, ',', '.') . "kr")?></p>
            </div>
        </article>
        </a>
    <?php } ?>
    <?php endif; ?>
    
</div>


</article>
