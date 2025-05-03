<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else { 
    
    $detektiv_pris[0] = 100000000;
    $detektiv_pris[1] = 75000000;
    $detektiv_pris[2] = 50000000;
    $detektiv_pris[3] = 35000000;
    $detektiv_pris[4] = 25000000;
    $detektiv_pris[5] = 17500000;
    $detektiv_pris[6] = 10000000;
    
    $detektiv_upgrade[0] = 10000000;
    $detektiv_upgrade[1] = 17500000;
    $detektiv_upgrade[2] = 25000000;
    $detektiv_upgrade[3] = 35000000;
    $detektiv_upgrade[4] = 50000000;
    $detektiv_upgrade[5] = 75000000;
    $detektiv_upgrade[6] = 100000000;

    $detektiv_tid[0] = 660;
    $detektiv_tid[1] = 570;
    $detektiv_tid[2] = 480;
    $detektiv_tid[3] = 390;
    $detektiv_tid[4] = 300;
    $detektiv_tid[5] = 210;
    $detektiv_tid[6] = 120;

    $ventetid = time() + $detektiv_tid[$det_tid];
    
    if(isset($_POST['sok'])){
        $sql = "SELECT * FROM accounts WHERE username='".$_POST['username']."'";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row_victim = mysqli_fetch_assoc($query);
        

        $check_user = mysqli_query($con, "SELECT * FROM accounts WHERE username = '".$_POST['username']."'");

        if(mysqli_num_rows($check_user) > 0) {

            $city_victim = $row_victim['city'];
            $acc_typ_victim = $row_victim['account_type'];

            $chance = mt_rand(0, 10);
            $my_chance = 9;

            if($acc_typ_victim == 69){
                echo '<div class="feedback feilmelding">
                    <span>Brukeren er død.</span> 
                </div>';
            } elseif($acc_typ_victim == 1 || $acc_typ_victim == 2 || $acc_typ_victim == 3){ 
                echo '<div class="feedback feilmelding">
                    <span>Brukeren er i crewet.</span> 
                </div>';
            } elseif($money < $detektiv_pris[$det_pris]){
                echo '<div class="feedback mislykket">
                    <span>Du har ikke nok penger!</span> 
                </div>';
            } else {
                if($my_chance > $chance){
                    $query = "INSERT into `detektiv` (acc_id, text, countdown)
                    VALUES ('".$_SESSION['ID']."', '".$_POST['username']." ble funnet i ".$city_name[$city_victim]."', '$ventetid')";
                    $result = mysqli_query($con, $query);
                    
                    $result = "UPDATE accounts SET money = (money - $detektiv_pris[$det_pris]) WHERE ID='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    header("Location: index.php?side=detektiv&sok");
                } else {
                    $query = "INSERT into `detektiv` (acc_id, text, countdown)
                    VALUES ('".$_SESSION['ID']."', 'Jeg fant ikke ".$_POST['username'].", beklager...', '$ventetid')";
                    $result = mysqli_query($con, $query);
                    
                    $result = "UPDATE accounts SET money = (money - $detektiv_pris[$det_pris]) WHERE ID='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    header("Location: index.php?side=detektiv&sok");
                }
            }
        } else {
            echo '<div class="feedback mislykket">
                <span>Brukeren finnes ikke!</span> 
            </div>';
        }
    }
    
    if(isset($_GET['sok'])){
        echo '<div class="feedback velykket">
            <span>Søket er i gang!</span> 
        </div>';
    }
?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Drap » </span><span style="color: #afafaf;">Detektiv</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <?php         
    
$check_sort = mysqli_query($con, "SELECT * FROM detektiv WHERE acc_id = '$ID'");

if(mysqli_num_rows($check_sort) == 1) {
    if($det_tid < 6){
        echo '<div class="feedback feilmelding">
            <span>Du har allerede et aktivt søk, når detektiven er ferdig med søket så får du vite byen spilleren er i, det anbefales at du oppgraderer ventetiden slik at du ikke må vente lenge mellom søkene.</span> 
        </div>'; 
    } else {
        echo '<div class="feedback feilmelding">
            <span>Du har allerede et aktivt søk, når detektiven er ferdig med søket så får du vite byen spilleren er i.</span> 
        </div>'; 
    }
} else {
    
        ?>
        <div class="content">
            <div class="header">
                <span>Detektiv<?php if($username == "Cancer"){ echo 'en til Skitzo'; }?></span>
            </div>
            <img src="img/action/detektiv.png">
            <form method="POST" action="">
                <center>
                    <p>Hvem ønske du å søke etter?</p>
                    <input type="text" name="username" placeholder="Brukernavn" style="width: 40%;">
                    <input type="submit" style="width: 20%;" name="sok" value="Søk ">
                </center>
            </form>
        </div>
        <?php 
} 

    if(isset($_POST['upgrade_tid'])){
        if($money < $detektiv_upgrade[$det_tid]){
            echo '<div class="feedback mislykket">
                <span>Du har ikke nok penger!</span> 
            </div>';
        } elseif($det_tid == 6){
            echo '<div class="feedback mislykket">
                <span>Du har den beste detektiven når det kommer til tid!</span> 
            </div>';
        } else {
            $result = "UPDATE accounts SET money = (money - $detektiv_upgrade[$det_tid]) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $result = "UPDATE accounts SET detektiv_tid = (detektiv_tid + 1) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            header("Location: index.php?side=detektiv&upgrade");
        }
    }
    
    if(isset($_POST['upgrade_pris'])){
        if($money < $detektiv_upgrade[$det_pris]){
            echo '<div class="feedback mislykket">
                <span>Du har ikke nok penger!</span> 
            </div>';
        } elseif($det_pris == 6){
            echo '<div class="feedback mislykket">
                <span>Du har den beste detektiven når det kommer til pris!</span> 
            </div>';
        } else {
            $result = "UPDATE accounts SET money = (money - $detektiv_upgrade[$det_pris]) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $result = "UPDATE accounts SET detektiv_pris = (detektiv_pris + 1) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            header("Location: index.php?side=detektiv&upgrade");
        }
    }
    
    if(isset($_GET['upgrade'])){
        echo '<div class="feedback velykket">
            <span>Detektiven ble oppgradert!</span> 
        </div>';
    }

        ?>
        
        <div class="content" style="padding-bottom: 0; margin-top: 3px;">
            <div class="header">
                <span>Oppgrader detektiv</span>
            </div>
            <form method="POST" action="">
                <div style="border-bottom: 1px solid #2c2c2c; padding: 10px;"><center>Oppgrader din detektiv for å effektivisere søket.</center></div>
                <div style="border-right: 1px solid #2c2c2c; width: 50%; float: left; height: auto; padding-top: 10px; padding-bottom: 10px;">
                    <center><b>Søketid lvl <?php echo $det_tid; ?></b>                        
                        <br>Søketid: <?php echo number($detektiv_tid[$det_tid]); ?>s
                        <?php if($det_tid < 6) { ?>
                        <br>Pris for oppgradering: <?php echo number($detektiv_upgrade[$det_tid]); ?>kr
                        <br><input type="submit" style="margin-top: 10px; width: auto;" name="upgrade_tid" value="Oppgrader">
                        <?php } ?>
                    </center>
                </div>
                <div style="width: 49%; float: left; height: auto; padding-top: 10px; padding-bottom: 10px;">
                    <center><b>Pris lvl <?php echo $det_pris; ?></b>
                        <br>Pris pr søk: <?php echo number($detektiv_pris[$det_pris]); ?>
                        <?php if($det_pris < 6) { ?>
                        <br>Pris for oppgradering: <?php echo number($detektiv_upgrade[$det_pris]); ?>kr
                        <br><input type="submit" style="margin-top: 10px; width: auto;" name="upgrade_pris" value="Oppgrader">
                        <?php } ?>
                    </center>
                </div>
            </form>
        </div>
    </body>
</html>
<?php 

}

?>