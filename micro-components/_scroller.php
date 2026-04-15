
<?php
    $user = "";

    if(!empty($_SESSION["user"])){
        $user = $_SESSION["user"];
    }


?>


<section class="scroll-container">

    <h2><?php _($scroller_header ?? "header")?></h2>
            
    <section class="scroller" >
        <?php foreach ($items as $item): ?>
            <article id="<?= _($item["pk"]) ?>" class="scroll-item">
                <?php if($user){ ?>
                    <button onclick="saveProperty(this);" class="bookmark"></button>
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
                        <p><span><?php _($item['number_of_rooms'] ?? '') ?> beds</span><span>1 ba</span><span><?php _($item['lot_square_meters']) . " " || _($item['floor_square_meters'] ?? '')  ?> sqft</span></p>
                        <p><?php _($item['house_number'] ?? '')?> <?php _($item['road_name'])?>, <?php _($item['city_name'])?> <?php _($item['zip_code']) ?></p>
                    </article>
                </a>
            </article>
        <?php endforeach; ?>  
        <a class="see-more filled-btn white" href="/page-map">See more <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>     

    </section>
</section>

<script>

function saveProperty(button){

    console.log(button);
    const item_pk = button.closest(".scroll-item").id

    console.log(item_pk)

    fetch(`api-save-property?item_pk=${item_pk}`)
    .then(res=>res.text())
    .then(data=> data)
    .catch(error=>console.log(error))



}

</script>

