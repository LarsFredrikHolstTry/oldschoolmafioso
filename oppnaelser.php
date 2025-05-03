<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else { 
    
?>
<!-- CONTENT -->
<html>
    <head>
    
    <style>
        
        .float_5 {
            width: 20%; 
            height: auto; 
            float:left;
        }
        
    </style>
    
    </head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Mafioso » </span><span style="color: #afafaf;">Oppnåelser</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <div class="header">
                <span>Oppnåelser</span>
            </div>
            <div class="pad_10">Her vil du se hva du har oppånådd av antall krim, biltyveri osv.</div>
            <div class="header">
                <span>Kriminalitet</span>
            </div>
            <div style="height: 80px;">
            <?php 
            
                for($i = 1; $i < 6; $i++){
            ?>
            <div class="float_5">
                <div class="pad_10">
                    <img style="<?php if($i > 2){ ?> filter: grayscale(100%); <?php } ?>"src="img/ach/<?php echo $i ?>.png">
                </div>
            </div>
            <?php } ?>
            </div>
            <div class="header">
                <span>Biltyveri</span>
            </div>
            <div style="height: 80px;">
            <?php 
            
                for($i = 6; $i < 11; $i++){
            ?>
            <div class="float_5">
                <div class="pad_10">
                    <img style="<?php if($i > 8){ ?> filter: grayscale(100%); <?php } ?>" src="img/ach/<?php echo $i ?>.png">
                </div>
            </div>
            <?php } ?>
            </div>
        </div>
    </body>
</html>
<?php 

}

?>