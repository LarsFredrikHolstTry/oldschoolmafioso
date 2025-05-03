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

<head></head>

<body>
    <div class="breadcrumb">
        <span style="color: #3e3e3e;">Handlinger » </span><span style="color: #afafaf;">Biltyveri</span>
        <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
    </div>
    <?php

$sql = "SELECT * FROM gta WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row = mysqli_fetch_assoc($query);
   
$gta_[0] =            $row['gta_0'];
$gta_chance[0] =      $row['gta_0chance'];
$gta_[1] =            $row['gta_1'];
$gta_chance[1] =      $row['gta_1chance'];
$gta_[2] =            $row['gta_2'];
$gta_chance[2] =      $row['gta_2chance'];

$gta_option[0] = "Stjel bil fra gaten.";
$gta_option[1] = "Stjel bil fra bruktbilforhandler.";
$gta_option[2] = "Stjel bil fra deluxe bilforhandler.";
        
$gta_velykket[0] = "Du fikk med deg en ";
$gta_velykket[1] = "Du banket opp eieren av bruktbilforhandleren og stjal en ";
$gta_velykket[2] = "De ble redde da de så deg og du fikk med deg en ";

$gta_mislykket[0] = "Du ble sett av politiet og tørte ikke prøve deg.";
$gta_mislykket[1] = "Eieren av bruktbilforhandleren hadde hagle, du løp hjem.";
$gta_mislykket[2] = "Bilforhandleren var utstyrt med høyteknologisk sikkerhet, du hadde ikke en sjans.";

if($happy_hour == 1){
    $gta_exp[0] = 200 * 2;
    $gta_exp[1] = 400 * 2;
    $gta_exp[2] = 800 * 2;
} elseif($role == 3){
    $gta_exp[0] = 200 * 1.1;
    $gta_exp[1] = 400 * 1.1;
    $gta_exp[2] = 800 * 1.1;
} else {
    $gta_exp[0] = 200;
    $gta_exp[1] = 400;
    $gta_exp[2] = 800;
}
    
$extend = 60;
    
if($rank == 0){
    $gta_waittime[0] = 30 + $extend;
    $gta_waittime[1] = 60 + $extend;
    $gta_waittime[2] = 90 + $extend;
} elseif($rank == 1){
    $gta_waittime[0] = 40 + $extend;
    $gta_waittime[1] = 70 + $extend;
    $gta_waittime[2] = 100 + $extend;
} else {
    $gta_waittime[0] = 60 + $extend;
    $gta_waittime[1] = 90 + $extend;
    $gta_waittime[2] = 120 + $extend;
}
        
if(isset($_GET['mislykket'])){
    echo '<div class="feedback mislykket">
        <span><b>Mislykket!</b> '.$gta_mislykket[$_GET['mislykket']].'</span> 
    </div>';
}

if(isset($_GET['velykket'])){
    $_GET['car'];
    echo '<div class="feedback velykket">
        <span><b>Vellykket!</b> '.$gta_velykket[$_GET['velykket']].''.$car[$_GET['car']].'</span> 
    </div>';
    
    $check_ho = mysqli_query($con, "SELECT * FROM hurtig_oppdrag WHERE acc_id = '$ID'");
    if(mysqli_num_rows($check_ho) > 0) {
        if($oppdrag_ho == 4 && $car == 12){
            echo '<div class="feedback velykket">
                <span><b>Hurtig oppdrag:</b> Du har klart '.$value_ho.' av '.$kriterium[$oppdrag_ho].' leafer</span> 
            </div>';
        } elseif($oppdrag_ho == 3){
            echo '<div class="feedback velykket">
                <span><b>Hurtig oppdrag:</b> Du har klart '.$value_ho.' av '.$kriterium[$oppdrag_ho].' biltyveri</span> 
            </div>';
        }
    }
}

$sql_waittime = "SELECT * from gta WHERE acc_id='$ID'";
$result_waittime = mysqli_query($con, $sql_waittime);

while($rows_waittime = mysqli_fetch_array($result_waittime)){
    $timeleft_waittime = $rows_waittime['gta_seconds'];
    $available_waittime = $rows_waittime['gta_status'];
    $last_waittime = $timeleft_waittime - time();

    if($available_waittime == 1){
        echo '<div class="feedback feilmelding">
            <span>Du må vente <span id="countdowntimer">'.$last_waittime.'</span>s før du kan stjele en bil igjen</span> 
        </div>';
        ?>

    <script type="text/javascript">
        var seconds = document.getElementById("countdowntimer").textContent;
        var countdown = setInterval(function() {
            seconds--;
            document.getElementById("countdowntimer").textContent = seconds;
            if (seconds <= 0) window.location.href = "index.php?side=biltyveri";
        }, 1000);

    </script>

    <?php

    } else {

if(isset($_POST['submit'])){
    if(!empty($_POST['radioBtn']) || $_POST['radioBtn'] == 0){
        $selected = $_POST['radioBtn'];
        
        $waittime = $gta_waittime[$selected] + time();
        
        $chance = rand(0, 100);
        
        if($gta_chance[0] < 90){
            $result = "UPDATE gta SET gta_0chance = ($gta_chance[0] + 5) WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
        } 
        
        if($gta_chance[1] < 80){
            $result = "UPDATE gta SET gta_1chance = ($gta_chance[1] + 3) WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
        } 
        
        if($gta_chance[2] < 70){
            $result = "UPDATE gta SET gta_2chance = ($gta_chance[2] + 1) WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
        }

        if($gta_chance[$selected] > $chance){
            
        if($selected == 0){
            $car = rand(0, 3);
            $query = "INSERT into `cars` (acc_id, car_id, city, km)
            VALUES ('$ID', '$car', '$city', '$car_km[0]')";
            $result = mysqli_query($con, $query);
        } elseif($selected == 1){
            $car = rand(4, 7);
            $query = "INSERT into `cars` (acc_id, car_id, city, km)
            VALUES ('$ID', '$car', '$city', '$car_km[1]')";
            $result = mysqli_query($con, $query);
            
            $check_ho = mysqli_query($con, "SELECT * FROM hurtig_oppdrag WHERE acc_id = '$ID'");
            if(mysqli_num_rows($check_ho) > 0) {
                if($oppdrag_ho == 4 && $car == 5){
                    $result = "UPDATE hurtig_oppdrag SET value = ($value_ho + 1) WHERE acc_id = '".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    } elseif($oppdrag_ho == 3){
                        $result = "UPDATE hurtig_oppdrag SET value = ($value_ho + 1) WHERE acc_id = '".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                }
            }

            
        } elseif($selected == 2){
            $car = rand(8, 12);
            $query = "INSERT into `cars` (acc_id, car_id, city, km)
            VALUES ('$ID', '$car', '$city', '$car_km[2]')";
            $result = mysqli_query($con, $query);
            
            if($oppdrag == 8 && $city == 1 && $car == 8 && $car_km[2] < 5000){
                $result = "UPDATE oppdrag SET value = ($value + 1) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
            
            if($oppdrag == 16 && $city == 0 && $car == 11){
                $result = "UPDATE oppdrag SET value = ($value + 1) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
            
            $check_ho = mysqli_query($con, "SELECT * FROM hurtig_oppdrag WHERE acc_id = '$ID'");
            if(mysqli_num_rows($check_ho) > 0) {
                if($oppdrag_ho == 1 && $car == 12){
                    $result = "UPDATE hurtig_oppdrag SET value = ($value_ho + 1) WHERE acc_id = '".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                }
            }
            
        }
       
            $result = "UPDATE daily_exp SET exp = (exp + $gta_exp[$selected]) WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $result = "UPDATE accounts SET exp = ($exp + $gta_exp[$selected]) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            if($oppdrag == 1 && $city == 1){
                $result = "UPDATE oppdrag SET value = ($value + 1) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
            
            if($oppdrag == 11 && $city == 0){
                $result = "UPDATE oppdrag SET value = ($value + 1) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
            
            
            if($oppdrag == 21 && $city == 4){
                $result = "UPDATE oppdrag SET value = ($value + 1) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
            
            if($oppdrag == 24 && $city == 4){
                $result = "UPDATE oppdrag SET value = ($value + 1) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
            
            $check_ho = mysqli_query($con, "SELECT * FROM hurtig_oppdrag WHERE acc_id = '$ID'");
            if(mysqli_num_rows($check_ho) > 0) {
                if($oppdrag_ho == 3){
                    $result = "UPDATE hurtig_oppdrag SET value = ($value_ho + 1) WHERE acc_id = '".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                }
            }
            
            $result = "UPDATE gta SET gta_$selected = ($gta_[$selected] + 1) WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
            VALUES ('$ID', '3', 'Biltyveri velykket alt. ".$selected."', '$money', '$bank_money', '".time()."')";
            $result = mysqli_query($con, $query);

            header("Location: index.php?side=biltyveri&velykket=".$selected."&car=".$car."");
            

        } else {
            $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
            VALUES ('$ID', '3', 'Biltyveri mislykket alt. ".$selected."', '$money', '$bank_money', '".time()."')";
            $result = mysqli_query($con, $query);
            
            header("Location: index.php?side=biltyveri&mislykket=".$selected."");
        }
        
            $result = mysqli_query($con, "UPDATE gta SET gta_status='1', gta_seconds='$waittime' WHERE acc_id='$ID'") or die (mysqli_error($con));
        
    } else {
    echo '<div class="feedback feilmelding">
            <span><b>Feilmelding!</b> Ingen krim ble valgt, om du mener dette er feil så ta kontakt med support.</span> 
        </div>';
    }
}

?>

    <div class="content">
        <div class="header">
            <span>Biltyveri</span>
        </div>
        <img src="img/action/gta.png">
        <form method="POST" action="">
            <div class="head">
                <div style="width: 70%; float: left;">Beskrivelse</div>
                <div style="width: 15%; float: left;">Ventetid</div>
                <div style="width: 15%; float: left;">Sjanse</div>
            </div>
                <?php 

                for($i = 0; $i < 3; $i++){ ?>
            <input id="radio_<?php echo $i ?>" class="radio isHidden" name='radioBtn' value="<?php echo $i ?>" type="radio" required>
            <label for="radio_<?php echo $i ?>" class="label" <?php if($i == 0 || $i == 2){ ?> style="background-color: #181818;" <?php } ?>>
                <div style="width: 70%; float: left;"><?php echo $gta_option[$i]; ?></div>
                <div style="width: 15%; float: left;"><?php echo $gta_waittime[$i]; ?>s</div>
                <div style="width: 15%; float: left;"><?php echo $gta_chance[$i]; ?>%</div>
            </label>
                <?php } ?>
            <input style="width: 97.2%; margin-top: 7px;" type="submit" name="submit" value="Utfør biltyveri">
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

