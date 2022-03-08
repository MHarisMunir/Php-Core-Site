<?php
   require APPROOT . '/views/includes/head.php';
?>
<div id="section-landing">
    <?php
       require APPROOT . '/views/includes/navigation.php';
    ?>

    <div class="wrapper-landing">
        <h1>Muhammad</h1>
        <h2>Haris Munir</h2>
        <h3><?php print_r($_COOKIE['jwt']); ?></h3>
        <br>
    </div>
</div>
