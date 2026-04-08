<?php
    require_once __DIR__ . "/../db.php";
    require_once __DIR__ . "/../session_utils.php";
       

    if (!empty($_SESSION['viewed_homes'])) {
        $viewed_homes = get_viewed_homes();
    }

    $sql = "SELECT * FROM affordable_homes";
    $stmt = $_db->prepare($sql);
    $stmt->execute();
    $affordable_homes = $stmt->fetchAll();


    $sql = "SELECT * FROM `familiy_homes`";
    $stmt = $_db->prepare($sql);
    $stmt->execute();
    $familiy_house = $stmt->fetchAll();
    
?>


<main id="page-index" >

    <section id="hero" >
        <img src="images/tom-rumble-7lvzopTxjOU-unsplash.jpg" alt="placeholder hero">
        <h1>Rentals. Homes.
            <br>
            Agents. Loans.
        </h1>

    </section>


    <?php

    if(!empty($viewed_homes)){
        $items = $viewed_homes;
        $scroller_header = "Resently viewed homes";
        include '_scroller.php';
    }
    
    ?>

    <?php
    $items = $affordable_homes;
    $scroller_header = "Find homes you can afford";
    include '_scroller.php';
    
    ?>

    <section class="grid_1-1-1">
        <article>
            <img src="https://placehold.co/400" alt="placeholder">
                Buy a home
            A real estate agent can provide you with a clear breakdown of costs so that you can avoid surprise expenses.
            <a href="/"></a>
        </article>
        <article>
            <img src="https://placehold.co/400" alt="placeholder">
                Buy a home
            A real estate agent can provide you with a clear breakdown of costs so that you can avoid surprise expenses.
            <a href="/"></a>
        </article>
        <article>
            <img src="https://placehold.co/400" alt="placeholder">
                Buy a home
            A real estate agent can provide you with a clear breakdown of costs so that you can avoid surprise expenses.
            <a href="/"></a>
        </article>


    </section>

    <?php
    $items = $familiy_house;
    $scroller_header = "Familiy homes";
    include '_scroller.php';
    
    ?>

    </section>
            
    

</main>
