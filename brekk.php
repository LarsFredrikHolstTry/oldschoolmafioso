<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else { 
    
?>
<html>

<head>
</head>

<body>
    <div class="breadcrumb">
        <span style="color: #3e3e3e;">Handlinger » </span><span style="color: #afafaf;">Brekk</span>
        <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
    </div>
    <?php

$sql = "SELECT * FROM brekk WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row = mysqli_fetch_assoc($query);

$brekk_[0] =            $row['brekk_0'];
$brekk_chance[0] =      $row['brekk_0chance'];
$brekk_[1] =            $row['brekk_1'];
$brekk_chance[1] =      $row['brekk_1chance'];
$brekk_[2] =            $row['brekk_2'];
$brekk_chance[2] =      $row['brekk_2chance'];
$brekk_[3] =            $row['brekk_3'];
$brekk_chance[3] =      $row['brekk_3chance'];

$brekk_option[0] =      "Stjel bildeler fra bilopphøgger'n.";
$brekk_option[1] =      "Stjel bildeler fra biltema.";
$brekk_option[2] =      "Stjel bildeler fra en bil på utstilling.";
$brekk_option[3] =      "Stjel en bil og ta fra hverandre alle bildeler.";

$brekk_velykket[0] =    "Bilopphøgger'n var ikke tilstede, du fikk med deg ";
$brekk_velykket[1] =    "Du fant bildeler på biltema og fikk med deg ";
$brekk_velykket[2] =    "Du fant en helt ny bil og fikk med deg ";
$brekk_velykket[3] =    "Du stjal en bil, alle delene var ødelagte utennom ";

$brekk_mislykket[0] =   "Bilopphøgger'n er større enn deg, du løp i redsel hjem.";
$brekk_mislykket[1] =   "Politiet var rett rundt hjørnet så du feiget ut og gikk hjem tomhendt.";
$brekk_mislykket[2] =   "Utstillingen var høyt bemannet med vakter og du torte ikke ta sjansen.";
$brekk_mislykket[3] =   "Bilen var utstyrt med høyteknologisk alarmsystem.";

$brekk_thing[0] =       rand(0, 8);
$brekk_thing[1] =       rand(9, 17);
$brekk_thing[2] =       rand(18, 26);
$brekk_thing[3] =       rand(27, 35);
        
$wear[0] =              rand(30, 100);
$wear[1] =              rand(20, 70);
$wear[2] =              rand(10, 40);
$wear[3] =              0;

if($happy_hour == 1){
    $brekk_exp[0] = 240 * 2;
    $brekk_exp[1] = 400 * 2;
    $brekk_exp[2] = 480 * 2;
    $brekk_exp[3] = 600 * 2;
} elseif($role == 3){
    $brekk_exp[0] =     240 * 1.1;
    $brekk_exp[1] =     400 * 1.1;
    $brekk_exp[2] =     480 * 1.1;
    $brekk_exp[3] =     600 * 1.1;
} else {
    $brekk_exp[0] =     240;
    $brekk_exp[1] =     400;
    $brekk_exp[2] =     480;
    $brekk_exp[3] =     600;
}
    
$extend = 30;
    
if($rank == 0){
    $brekk_waittime[0] = 10 + $extend;
    $brekk_waittime[1] = 30 + $extend;
    $brekk_waittime[2] = 45 + $extend;
    $brekk_waittime[3] = 60 + $extend;
} elseif($rank == 1){
    $brekk_waittime[0] = 20 + $extend;
    $brekk_waittime[1] = 40 + $extend;
    $brekk_waittime[2] = 60 + $extend;
    $brekk_waittime[3] = 90 + $extend;
} else {
    $brekk_waittime[0] = 30 + $extend;
    $brekk_waittime[1] = 60 + $extend;
    $brekk_waittime[2] = 90 + $extend;
    $brekk_waittime[3] = 120 + $extend;
}

if(isset($_GET['mislykket'])){
    echo '<div class="feedback mislykket">
        <span><b>Mislykket!</b> '.$brekk_mislykket[$_GET['mislykket']].'</span> 
    </div>';
}

if(isset($_GET['velykket'])){
    $_GET['wear'];
    echo '<div class="feedback velykket">
        <span><b>Vellykket!</b> Du fikk med deg '.$thing[$_GET['velykket']].'. Wear: '.$_GET['wear'].'%</span> 
    </div>';
}
        
        $sql_waittime = "SELECT * from brekk WHERE acc_id='$ID'";
        $result_waittime = mysqli_query($con, $sql_waittime);

        while($rows_waittime = mysqli_fetch_array($result_waittime)){
            $timeleft_waittime = $rows_waittime['brekk_seconds'];
            $available_waittime = $rows_waittime['brekk_status'];
            $last_waittime = $timeleft_waittime - time();

            if($available_waittime == 1){
                echo '<div class="feedback feilmelding">
                    <span>Du må vente <span id="countdowntimer">'.$last_waittime.'</span>s før du kan gjøre brekk igjen</span>
                </div>';
                ?>

    <script type="text/javascript">
        var seconds = document.getElementById("countdowntimer").textContent;
        var countdown = setInterval(function() {
            seconds--;
            document.getElementById("countdowntimer").textContent = seconds;
            if (seconds <= 0) window.location.href = "index.php?side=brekk";
        }, 1000);

    </script>

    <?php
            } else {
                

if(isset($_POST['submit'])){
    if(!empty($_POST['radioBtn']) || $_POST['radioBtn'] == 0){
        $selected = $_POST['radioBtn'];
        
        $waittime = $brekk_waittime[$selected] + time();
        
        $chance = rand(0, 100);

        if($brekk_chance[0] < 91){
            $result = "UPDATE brekk SET brekk_0 = ($brekk_[0] + 1), brekk_0chance = ($brekk_chance[0] + 5) WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
        } 
        
        if($brekk_chance[1] < 81){
            $result = "UPDATE brekk SET brekk_1 = ($brekk_[1] + 1), brekk_1chance = ($brekk_chance[1] + 4) WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
        } 
        
        if($brekk_chance[2] < 71){
            $result = "UPDATE brekk SET brekk_2 = ($brekk_[2] + 1), brekk_2chance = ($brekk_chance[2] + 3) WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
        } 
        
        if($brekk_chance[3] < 71){
            $result = "UPDATE brekk SET brekk_3 = ($brekk_[3] + 1), brekk_3chance = ($brekk_chance[3] + 2) WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
        }

        if($brekk_chance[$selected] > $chance){

            $result = "UPDATE accounts SET exp = ($exp + $brekk_exp[$selected]) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $result = "UPDATE daily_exp SET exp = (exp + $brekk_exp[$selected]) WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $query = "INSERT into `mine_ting` (acc_id, thing_id, wear)
            VALUES ('$ID', '$brekk_thing[$selected]', '$wear[$selected]')";
            $result = mysqli_query($con, $query);
            
            
            if($oppdrag == 2 && $city == 1){
                $result = "UPDATE oppdrag SET value = ($value + 1) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
            
            if($oppdrag == 12 && $city == 0){
                $result = "UPDATE oppdrag SET value = ($value + 1) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
            
            if($oppdrag == 22 && $city == 4){
                $result = "UPDATE oppdrag SET value = ($value + 1) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
            
            if($oppdrag == 31 && $city == 2){
                $result = "UPDATE oppdrag SET value = ($value + 1) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
            
            $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
            VALUES ('$ID', '4', 'Brekk velykket alt. ".$selected."', '$money', '$bank_money', '".time()."')";
            $result = mysqli_query($con, $query);

            header("Location: index.php?side=brekk&velykket=".$brekk_thing[$selected]."&wear=".$wear[$selected]."");
            
            
        } else {
            $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
            VALUES ('$ID', '4', 'Brekk mislykket alt. ".$selected."', '$money', '$bank_money', '".time()."')";
            $result = mysqli_query($con, $query);
            
            header("Location: index.php?side=brekk&mislykket=".$selected."");
        }
        
            $result = mysqli_query($con, "UPDATE brekk SET brekk_status='1', brekk_seconds='$waittime' WHERE acc_id='$ID'") or die (mysqli_error($con));
        
    } else {
    echo '<div class="feedback feilmelding">
            <span><b>Feilmelding!</b> Ingen brekk ble valgt, om du mener dette er feil så ta kontakt med support.</span> 
        </div>';
    }
}
            
?>

    <div class="content">
        <div class="header">
            <span>Brekk</span>
        </div>
        <img src="img/action/brekk.png" style="width: 100%; height: auto;">
        <form method="POST" action="">
            <div class="head">
                <div style="width: 70%; float: left;">Beskrivelse</div>
                <div style="width: 15%; float: left;">Ventetid</div>
                <div style="width: 15%; float: left;">Sjanse</div>
            </div>
            <?php 
                                
                for($i = 0; $i < 4; $i++){
                
                ?>
            <input id="radio_<?php echo $i ?>" class="radio isHidden" name='radioBtn' value="<?php echo $i ?>" type="radio" required>
            <label for="radio_<?php echo $i ?>" class="label" <?php if($i == 0 || $i == 2){ ?> style="background-color: #181818;" <?php } ?>>
                <div style="width: 70%; float: left;"><?php echo $brekk_option[$i]; ?></div>
                <div style="width: 15%; float: left;"><?php echo $brekk_waittime[$i]; ?>s</div>
                <div style="width: 15%; float: left;"><?php echo $brekk_chance[$i]; ?>%</div>
            </label>

            <?php } ?>
            <input style="width: 97.2%; margin-top: 7px;" type="submit" name="submit" value="Utfør brekk">
        </form>
    </div>
    <?php } } ?>
</body>

</html>

<?php } ?>

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
