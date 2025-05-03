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
        <span style="color: #3e3e3e;">Handlinger » </span><span style="color: #afafaf;">Kriminalitet</span>
        <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
    </div>
    <?php
        
$sql = "SELECT * FROM crime WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row = mysqli_fetch_assoc($query);

$crime_[0] =            $row['crime_0'];
$crime_chance[0] =      $row['crime_0chance'];
$crime_[1] =            $row['crime_1'];
$crime_chance[1] =      $row['crime_1chance'];
$crime_[2] =            $row['crime_2'];
$crime_chance[2] =      $row['crime_2chance'];
$crime_[3] =            $row['crime_3'];
$crime_chance[3] =      $row['crime_3chance'];
$crime_[4] =            $row['crime_4'];
$crime_chance[4] =      $row['crime_4chance'];

$krim_option[0] = "Ran fra en gammel dame.";
$krim_option[1] = "Gjør brekk på 7-eleven.";
$krim_option[2] = "Utpress en mann i dress.";
$krim_option[3] = "Stjel en bil og selg på finn.";
$krim_option[4] = "Svindle folk på nettet.";

$krim_velykket[0] = "Du ranet en gammel dame for ";
$krim_velykket[1] = "Du pekte på mannen i kassen med en mac-10 og du fikk ut ";
$krim_velykket[2] = "Mannen ble redd og du fikk med deg ";
$krim_velykket[3] = "Du stjal en drittbil, men du fikk ";
$krim_velykket[4] = "Du svindlet på nettet for ";
        
$krim_mislykket[0] = "Den gamle damen kunne karate, det kunne ikke du.";
$krim_mislykket[1] = "Politiet var tilfeldigivs på 7-eleven for å kjøpe donuts, du gikk hjem tomhendt.";
$krim_mislykket[2] = "Mannen i dress hadde en kniv på innerlommen, du ble stukket ned.";
$krim_mislykket[3] = "Bilen var utstyrt med høyteknologisk alarmsystem.";
$krim_mislykket[4] = "Telenor hadde tekniske utfordringer og du hadde ikke internettilkobling.";

$krim_money[0] = floor(rand(100, 400));
$krim_money[1] = floor(rand(100, 1500));
$krim_money[2] = floor(rand(400, 3500));
$krim_money[3] = floor(rand(600, 5500));
$krim_money[4] = floor(rand(1500, 40500));

if($happy_hour == 1){
    $krim_exp[0] = 240 * 2;
    $krim_exp[1] = 400 * 2;
    $krim_exp[2] = 480 * 2;
    $krim_exp[3] = 600 * 2;
    $krim_exp[4] = 720 * 2;
} elseif($role == 3) {
    $krim_exp[0] = 240 * 1.1;
    $krim_exp[1] = 400 * 1.1;
    $krim_exp[2] = 480 * 1.1;
    $krim_exp[3] = 600 * 1.1;
    $krim_exp[4] = 720 * 1.1;
} else {
    $krim_exp[0] = 240;
    $krim_exp[1] = 400;
    $krim_exp[2] = 480;
    $krim_exp[3] = 600;
    $krim_exp[4] = 720;
}
    
$extend = 30;
    
if($rank == 0){
    $krim_waittime[0] = 10 + $extend;
    $krim_waittime[1] = 20 + $extend;
    $krim_waittime[2] = 30 + $extend;
    $krim_waittime[3] = 40 + $extend;
    $krim_waittime[4] = 50 + $extend;
} elseif($rank == 1){
    $krim_waittime[0] = 20 + $extend;
    $krim_waittime[1] = 30 + $extend;
    $krim_waittime[2] = 40 + $extend;
    $krim_waittime[3] = 50 + $extend;
    $krim_waittime[4] = 60 + $extend;
} elseif($rank == 2){
    $krim_waittime[0] = 30 + $extend;
    $krim_waittime[1] = 40 + $extend;
    $krim_waittime[2] = 50 + $extend;
    $krim_waittime[3] = 60 + $extend;
    $krim_waittime[4] = 70 + $extend;
} elseif($rank == 3){
    $krim_waittime[0] = 40 + $extend;
    $krim_waittime[1] = 50 + $extend;
    $krim_waittime[2] = 60 + $extend;
    $krim_waittime[3] = 70 + $extend;
    $krim_waittime[4] = 80 + $extend;
} else {
    $krim_waittime[0] = 50 + $extend;
    $krim_waittime[1] = 60 + $extend;
    $krim_waittime[2] = 70 + $extend;
    $krim_waittime[3] = 80 + $extend;
    $krim_waittime[4] = 90 + $extend;
}

if(isset($_GET['mislykket'])){
    echo '<div class="feedback mislykket">
        <span><b>Mislykket!</b> '.$krim_mislykket[$_GET['mislykket']].'</span> 
    </div>';
}

if(isset($_GET['velykket'])){
    $_GET['penger'];
    echo '<div class="feedback velykket">
        <span>'.$krim_velykket[$_GET['velykket']].''.number($_GET['penger']).'kr</span> 
    </div>';
    
    $check_ho = mysqli_query($con, "SELECT * FROM hurtig_oppdrag WHERE acc_id = '$ID'");
    if(mysqli_num_rows($check_ho) > 0) {
        if($oppdrag_ho == 0){
            echo '<div class="feedback velykket">
                <span><b>Hurtig oppdrag:</b> Du har klart '.$value_ho.' av '.$kriterium[$oppdrag_ho].' kriminaliteter</span> 
            </div>';
        }
    }
}

        
        $sql_waittime = "SELECT * from crime WHERE acc_id='$ID'";
        $result_waittime = mysqli_query($con, $sql_waittime);

        while($rows_waittime = mysqli_fetch_array($result_waittime)){
            $timeleft_waittime = $rows_waittime['crime_seconds'];
            $available_waittime = $rows_waittime['crime_status'];
            $last_waittime = $timeleft_waittime - time();

            if($available_waittime == 1){
                echo '<div class="feedback feilmelding">
                    <span>Du må vente <span id="countdowntimer">'.$last_waittime.'</span>s før du kan gjøre en kriminell handling igjen</span> 
                </div>';
                ?>

    <script type="text/javascript">
        
        timer(<?php echo $last_waittime ?>, "countdowntimer");

    </script>

    <?php
            } else {
                

if(isset($_POST['radioBtn'])){
    if(!empty($_POST['radioBtn']) || $_POST['radioBtn'] == 0){
        $selected = $_POST['radioBtn'];
        
        $waittime = $krim_waittime[$selected] + time();
        
        $chance = rand(0, 100);
        
        if($crime_chance[0] <= 90){
            $result = "UPDATE crime SET crime_0chance = ($crime_chance[0] + 5) WHERE acc_id='".$_SESSION['ID']."'"; mysqli_query($con, $result) or die("Bad query: $result");
        }
        
        if($crime_chance[1] <= 85){
            $result = "UPDATE crime SET crime_1chance = ($crime_chance[1] + 4) WHERE acc_id='".$_SESSION['ID']."'"; mysqli_query($con, $result) or die("Bad query: $result");
        }
        
        if($crime_chance[2] <= 80){
            $result = "UPDATE crime SET crime_2chance = ($crime_chance[2] + 3) WHERE acc_id='".$_SESSION['ID']."'"; mysqli_query($con, $result) or die("Bad query: $result");
        }
        
        if($crime_chance[3] <= 75){
            $result = "UPDATE crime SET crime_3chance = ($crime_chance[3] + 2) WHERE acc_id='".$_SESSION['ID']."'"; mysqli_query($con, $result) or die("Bad query: $result");
        }
        
        if($crime_chance[4] <= 70){
            $result = "UPDATE crime SET crime_4chance = ($crime_chance[4] + 1) WHERE acc_id='".$_SESSION['ID']."'"; mysqli_query($con, $result) or die("Bad query: $result");
        }

        if($crime_chance[$selected] > $chance){
            if($happy_hour == 1){
                $cashout = floor(($krim_money[$selected] * 2));
            } elseif($role == 1){
                $cashout = floor(($krim_money[$selected] * 1.1));
            } else {
                $cashout = floor($krim_money[$selected]);
            }

            $result = "UPDATE accounts SET money = ($money + $cashout), exp = ($exp + $krim_exp[$selected]) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $result = "UPDATE daily_exp SET exp = (exp + $krim_exp[$selected]) WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            if($oppdrag == 0 && $city == 1){
                $result = "UPDATE oppdrag SET value = ($value + 1) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
            
            if($oppdrag == 10 && $city == 0){
                $result = "UPDATE oppdrag SET value = ($value + 1) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
            
            if($oppdrag == 20 && $city == 4){
                $result = "UPDATE oppdrag SET value = ($value + 1) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
            
            if($oppdrag == 30 && $city == 2){
                $result = "UPDATE oppdrag SET value = ($value + 1) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
            
            $check_ho = mysqli_query($con, "SELECT * FROM hurtig_oppdrag WHERE acc_id = '$ID'");
            if(mysqli_num_rows($check_ho) > 0) {
                if($oppdrag_ho == 0){
                    $result = "UPDATE hurtig_oppdrag SET value = ($value_ho + 1) WHERE acc_id = '".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                }
            }
            
            $result = "UPDATE crime SET crime_$selected = ($crime_[$selected] + 1) WHERE acc_id='".$_SESSION['ID']."'"; mysqli_query($con, $result) or die("Bad query: $result");

            $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
            VALUES ('$ID', '2', 'Krim velykket alt. ".$selected." Penger = ".$cashout."', '$money', '$bank_money', '".time()."')";
            $result = mysqli_query($con, $query);

            header("Location: index.php?side=kriminalitet&velykket=".$selected."&penger=".$cashout."");
            
        } else {
            $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
            VALUES ('$ID', '2', 'Krim mislykket alt. ".$selected."', '$money', '$bank_money', '".time()."')";
            $result = mysqli_query($con, $query);
            
            header("Location: index.php?side=kriminalitet&mislykket=".$selected."");
        }
        
        $result = mysqli_query($con, "UPDATE crime SET crime_status='1', crime_seconds='$waittime' WHERE acc_id='$ID'") or die (mysqli_error($con));
        
    } else {
    echo '<div class="feedback feilmelding">
            <span><b>Feilmelding!</b> Ingen krim ble valgt, om du mener dette er feil så ta kontakt med support.</span> 
        </div>';
    }
}
            
?>

    <div class="content">
        <div class="header">
            <span>Kriminalitet</span>
        </div>
        <img src="img/action/krim.png">

        <form method="POST" action="">
            <div class="head">
                <div style="width: 70%; float: left;">Beskrivelse</div>
                <div style="width: 15%; float: left;">Ventetid</div>
                <div style="width: 15%; float: left;">Sjanse</div>
            </div>
            <?php 
                                
            for($i = 0; $i < 5; $i++){

            ?>

            <input id="radio_<?php echo $i ?>" class="radio isHidden" name='radioBtn' value="<?php echo $i ?>" type="radio">
            <label for="radio_<?php echo $i ?>" class="label" <?php if($i == 0 || $i == 2 || $i == 4){ ?> style="background-color: #181818;" <?php } ?>>
                <div style="width: 70%; float: left;"><?php echo $krim_option[$i]; ?></div>
                <div style="width: 15%; float: left;"><?php echo $krim_waittime[$i]; ?>s</div>
                <div style="width: 15%; float: left;"><?php echo $crime_chance[$i]; ?>%</div>
            </label>

            <?php 
                
            } 
            
            ?>
            <input style="width: 97.2%; margin-top: 7px;" type="submit" name="submit" value="Utfør krim">
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
