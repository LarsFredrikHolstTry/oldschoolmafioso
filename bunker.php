<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else { 
    
    $house[2] = "sveitservilla";
    $house[3] = "villa";
    
    if($role == 1){
        $pris_bunker = 5000000 * 0.9;
    } else {
        $pris_bunker = 5000000;
    }
    
?>
<!-- CONTENT -->
<html>

<head></head>

<body>
    <div class="breadcrumb">
        <span style="color: #3e3e3e;">Drap » </span><span style="color: #afafaf;">Bunker</span>
        <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
    </div>
    <?php if($beskyttelse > 1){
        
    if(isset($_GET['inn'])){
        echo '<div class="feedback velykket">
            <span>Du gikk i bunker</span> 
        </div>';
    }
        
    if(isset($_GET['ut'])){
        echo '<div class="feedback velykket">
            <span>Du gikk ut av din bunker</span> 
        </div>';
    }

    if($role == 1){
        $bunker_pris = 250000 * 0.9;
    } else {
        $bunker_pris = 250000;
    }
        
    if(isset($_POST['bunker'])){
        if($money < $bunker_pris){
            echo '<div class="feedback feilmelding">
                <span><b>Feilmelding!</b> Du har ikke nok penger for bunkertillatelse!</span> 
            </div>';
        } elseif($beskyttelse < 2){
            echo '<div class="feedback feilmelding">
                <span><b>Feilmelding!</b> Du har ikke en bolig som kan ha bunkertillatelse!</span> 
            </div>';
        } elseif($bunker == 1) {
            echo '<div class="feedback feilmelding">
                <span><b>Feilmelding!</b> Du har allerede bunkertillatelse!</span> 
            </div>';
        } else {
            $result = "UPDATE accounts SET bunker = '1', money = (money - $bunker_pris) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");

            header("Location: index.php?side=bunker&bunker_built");
        }
    }
        
        if(isset($_GET['bunker_built'])){
            echo '<div class="feedback velykket">
                <span>Du har bygget bunker på din bolig!</span> 
            </div>';
        }

    if(isset($_POST['bunker_in'])){
        if($money < $pris_bunker){
            echo '<div class="feedback mislykket">
                <span>Du har ikke nok penger til å gå i bunker.</span> 
            </div>';
        } else {
            $week_in_seconds =  86399 + time();

            $result = "UPDATE bunker SET bunker_status = 1, bunker_seconds = '$week_in_seconds' WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $result = "UPDATE accounts SET money = ($money - $pris_bunker) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
            VALUES ('$ID', 'Bunker - bunker inn', '$money', '$bank_money', '".time()."')";
            $result = mysqli_query($con, $query);

            header("Location: index.php?side=bunker&inn");
        }
    }
        
    if(isset($_POST['bunker_out'])){
        $cooldown =  300 + time(); // 150
        
        $result = "UPDATE bunker SET bunker_status = 2, bunker_seconds = '$cooldown' WHERE acc_id='".$_SESSION['ID']."'";
        mysqli_query($con, $result) or die("Bad query: $result");
        
        $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
        VALUES ('$ID', 'Bunker - bunker ut', '$money', '$bank_money', '".time()."')";
        $result = mysqli_query($con, $query);
        
        header("Location: index.php?side=bunker&ut");
    }
    
    
    ?>
    <div class="content">
        <div class="header">
            <span>Bunker</span>
        </div>
        <img src="img/action/bunker.png">
        <form method="POST" action="">
            <div style="padding: 10px; word-wrap: break-word; margin-top: -15px; white-space: pre-line;" class="textbox">
            Ettersom at du har en <?php echo $house[$beskyttelse] ?> kan du gå i bunker for å unngå å bli drept av andre spillere.<br>
            <?php if($bunker == 0){ ?>
                <center><t>For å kunne gå i bunker må du først bygge en bunker.<br><br></t><input style="width: auto; margin: 0;" class="no" type="submit" name="bunker" value="Bygg bunker - 250 000kr"></center>
            <?php } elseif($bunker_status == 1){ ?>
                <center><t>Du blir automatisk kastet ut av bunkeren om <?php echo secondsToTime($bunker_seconds - time()); ?><br><br></t><input style="width: auto; margin: 0;" class="no" type="submit" name="bunker_out" value="Gå ut av bunker nå"></center>
            <?php } elseif($bunker_status == 2) { ?>
                <center><span>Du kan ikke gå i bunker før <?php echo secondsToTime($bunker_seconds - time()); ?></span></center>
            <?php } else { ?>
                <center><input style="width: auto; margin: 0;" type="submit" name="bunker_in" value="Gå i bunker (Pris: <?php echo number($pris_bunker); ?> kr)"></center>
            <?php } ?>
            </div>
        </form>
    </div>
    <?php 
        } else {
            header("Location: index.php?side=bolig");
        } 
    ?>
</body>

</html>
<?php 

}

?>
