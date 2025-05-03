<?php 

$innbrudd_option[0] = "Ran verktøy fra en garasje";
$innbrudd_option[1] = "Stjel ting fra datasenter";
$innbrudd_option[2] = "Bryt deg inn i en bolig";

$innbrudd_waittime[0] = 100;
$innbrudd_waittime[1] = 100;
$innbrudd_waittime[2] = 100;

$innbrudd_chance[0] = 80;
$innbrudd_chance[1] = 60;
$innbrudd_chance[2] = 40;

/* Garasje */
$garasje_obj[0] = "Race booster";
$garasje_obj[1] = "Verktøyskrin";
$garasje_obj[2] = "Vernehjem";
$garasje_obj[3] = "Spade";
$garasje_obj[4] = "Grill";
$garasje_obj[5] = "Sykkel";
$garasje_obj[6] = "Stige";
$garasje_obj[7] = "Motorsag";
$garasje_obj[8] = "Hammer";
$garasje_obj[9] = "Slegge";
$garasje_obj[10] = "Gressklipper";

/* Datasenter */
$datasenter_obj[0] = "Mystisk harddisk";
$datasenter_obj[1] = "Modem";
$datasenter_obj[2] = "Nøkkelkort";
$datasenter_obj[3] = "Minnepenn";
$datasenter_obj[4] = "Server";
$datasenter_obj[5] = "Ram";
$datasenter_obj[6] = "Hovedkort";
$datasenter_obj[7] = "Server kabinett";
$datasenter_obj[8] = "Prosessor";
$datasenter_obj[9] = "Grafikkort";
$datasenter_obj[10] = "Strøm Generator";

/* Bolig */
$bolig_obj[0] = "Personlig Happy Hour (1t)";
$bolig_obj[1] = "Øl";
$bolig_obj[2] = "Brannslukker";
$bolig_obj[3] = "Gaffateip";
$bolig_obj[4] = "Zippo Lighter";
$bolig_obj[5] = "Marius Genser";
$bolig_obj[6] = "Mobiltelefon";
$bolig_obj[7] = "Vodka";
$bolig_obj[8] = "Strømpe";
$bolig_obj[9] = "Sløyekniv";
$bolig_obj[10] = "Balltre";

$chance = mt_rand(1, 100);

if($chance == 1){
    $obj_drop = 0;
} elseif($chance < 7){
    $obj_drop = 1;
} elseif($chance < 8){
    $obj_drop = mt_rand(1, 10);
}  else {
    $obj_drop = mt_rand(11, 20);
}

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else { 
    
?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Handlinger » </span><span style="color: #afafaf;">Innbrudd</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <div class="header">
                <span>Innbrudd</span>
            </div>
            <img src="img/action/innbrudd.png">
            <form method="POST" action="">
                <div class="head">
                    <div style="width: 70%; float: left;">Beskrivelse</div>
                    <div style="width: 15%; float: left;">Ventetid</div>
                    <div style="width: 15%; float: left;">Sjanse</div>
                </div>
                <?php 

                for($i = 0; $i < 3; $i++){

                ?>

                <input id="radio_<?php echo $i ?>" class="radio isHidden" name='radioBtn' value="<?php echo $i ?>" type="radio">
                <label for="radio_<?php echo $i ?>" class="label" <?php if($i == 0 || $i == 2){ ?> style="background-color: #181818;" <?php } ?>>
                    <div style="width: 70%; float: left;"><?php echo $innbrudd_option[$i]; ?></div>
                    <div style="width: 15%; float: left;"><?php echo $innbrudd_waittime[$i]; ?>s</div>
                    <div style="width: 15%; float: left;"><?php echo $innbrudd_chance[$i]; ?>%</div>
                </label>

                <?php 

                } 

                ?>
                <input style="width: 97.2%; margin-top: 7px;" type="submit" name="submit" value="Utfør innbrudd">
            </form>
        </div>
    </body>
</html>
<?php 

}

?>

<style>
    .isHidden {
        display: none;
        /* hide radio buttons */
    }

    .label {
        display: inline-block;
        background-color: #1b1b1b;
        width: 100%;
        height: 25px;
        padding: 8px 10px 0px 10px;
    }

    .head {
        width: 100%;
        height: 25px;
        padding: 8px 10px 0px 10px;
        color: #afafaf;
    }

    .label:hover {
        color: #a0a0a0;
        cursor: pointer;
        background-color: #202020 !important;
    }

    .radio:checked+.label {
        /* target next sibling (+) label */
        color: #a0a0a0;
        background-color: #303030 !important;
    }
</style>