<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else { 
    
    // ventetid
    $enkel =        2100; // 35 min
    $vanskelig =    7200; // 2 timer (120 min)

    // enkle hurtige oppdrag
    $hurtig_oppdrag[0] = "Utfør 10 krim";
    $kriterium[0] =      10;
    $hurtig_oppdrag[1] = "Stjel 1 Tesla Cybertruck";
    $kriterium[1] =      1;
    $hurtig_oppdrag[2] = "Lag 2 vellykkede filmer";
    $kriterium[2] =      2;

    // vanskelige hurtige oppdrag
    $hurtig_oppdrag[3] = "Stjel 15 biler";
    $kriterium[3] =      15;
    $hurtig_oppdrag[4] = "Stjel 3 Nissan Leaf";
    $kriterium[4] =      3;
    $hurtig_oppdrag[5] = "Lag 4 vellykkede filmer";
    $kriterium[5] =      4;
    
    // payout enkel hurtig oppdrag
    $payout_enkel_exp[0] =          550;
    $payout_enkel_cash[0] =         15000000;
    
    // payout vanskelig hurtig oppdrag
    $payout_vanskelig_exp[0] =      2250;
    $payout_vanskelig_cash[0] =     35000000;

    if(isset($_POST['submit'])){
        if(!empty($_POST['radioBtn']) || $_POST['radioBtn'] == 0){
            // Enkel
            if($_POST['radioBtn'] == 1){
                $cooldown = time() + $enkel;
                $random_mission = mt_rand(0, 2);
                
                $query = "INSERT into `hurtig_oppdrag` (acc_id, oppdrag, oppdrag_seconds, oppdrag_status)
                VALUES ('$ID', '$random_mission', '$cooldown', '1')";
                $result = mysqli_query($con, $query);
                
                header("Location: index.php?side=hurtig_oppdrag");
                
            } elseif($_POST['radioBtn'] == 2){
                $cooldown = time() + $vanskelig;
                $random_mission = mt_rand(3, 5);
                
                $query = "INSERT into `hurtig_oppdrag` (acc_id, oppdrag, value, oppdrag_seconds, oppdrag_status)
                VALUES ('$ID', '$random_mission', '0', '$cooldown', '1')";
                $result = mysqli_query($con, $query);
                
                header("Location: index.php?side=hurtig_oppdrag");
            }
        } else {
            echo '<div class="feedback feilmelding">
                <span><b>Feilmelding!</b> Ingen oppdrag ble valgt, om du mener dette er feil så ta kontakt med support.</span> 
            </div>';
        }
    }
?>
<!-- CONTENT -->
<html>

<head></head>

<body>
    <div class="breadcrumb">
        <span style="color: #3e3e3e;">Oppdrag » </span><span style="color: #afafaf;">Hurtig oppdrag</span>
        <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
    </div>
    <?php 
    
$check_sort = mysqli_query($con, "SELECT * FROM hurtig_oppdrag WHERE acc_id = '$ID'");

if(mysqli_num_rows($check_sort) != 1) {

    ?>
    <div class="content">
        <div class="header">
            <span>Hurtig oppdrag</span>
        </div>
        <img src="img/action/hurtig_oppdrag.png" style="width: 100%; height: auto;">
        <form method="post">
            <div class="head">
                <div style="width: 70%; float: left;">Beskrivelse</div>
                <div style="width: 30%; float: left;">Tidsfrist</div>
            </div>

            <input id="radio_1" class="radio isHidden" name='radioBtn' value="1" type="radio">
            <label for="radio_1" class="label" style="background-color: #181818;">
                <div style="width: 70%; float: left;">Enkel hurtig oppdrag</div>
                <div style="width: 30%; float: left;">35 min</div>
            </label>

            <input id="radio_2" class="radio isHidden" name='radioBtn' value="2" type="radio">
            <label for="radio_2" class="label">
                <div style="width: 70%; float: left;">Vanskelig hurtig oppdrag</div>
                <div style="width: 30%; float: left;">2 timer</div>
            </label>
            <input style="width: 97.2%; margin-top: 7px;" type="submit" name="submit" value="Start hurtig oppdrag">
        </form>
    </div>
    <?php } else { ?>
    <div class="content">
        <div class="header">
            <span>Hurtig oppdrag</span>
        </div>
        <img src="img/action/hurtig_oppdrag.png" style="width: 100%; height: auto;">
            <p class="pad_10">
                <b>Ditt oppdrag: </b><?php echo $hurtig_oppdrag[$oppdrag_ho]; ?>
                <br><b>Du har: </b><?php echo $value_ho; ?> av <?php echo $kriterium[$oppdrag_ho]; ?>
                <br><b>Gjenstående tid: </b><?php echo secondsToTime($ho_seconds - time()); ?>
            </p>
    </div>
    <?php } ?>
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
