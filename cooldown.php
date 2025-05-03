
<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else { 
    $warning = "Du har vært på for mange sidevisninger innen 1 minutt og får derfor en cooldown.";
?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="content">
            <?php echo $warning; ?>
        </div>
    </body>
</html>
<?php 

}

?>