
<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else {

    if(isset($_GET['mislykket'])){
        echo '<div class="feedback mislykket">
            <span>Du feilet drapet!</span> 
        </div>';
    }
    
    if(isset($_GET['velykket'])){
        echo '<div class="feedback velykket">
            <span>Du drepte '.$_GET['velykket'].', det ble brukt '.number($_GET['kuler']).' kuler, du fikk med deg '.number($_GET['money']).' kr fra drapsofferet!</span> 
        </div>';
    }
    
    if(isset($_GET['damage'])){
        echo '<div class="feedback feilmelding">
            <span>Du drepte ikke spilleren men pådro spilleren '.$_GET['damage'].'% skade!</span>
        </div>';
    }
    
    // kuletabell
    if($vapen == 0){
        $exp_pr_kuler = 250;
    } elseif($vapen == 1){
        $exp_pr_kuler = 350;
    } elseif($vapen == 2){
        $exp_pr_kuler = 450;
    } elseif($vapen == 3){
        $exp_pr_kuler = 550;
    } elseif($vapen == 4){
        $exp_pr_kuler = 650;
    } elseif($vapen == 5){
        $exp_pr_kuler = 750;
    }


    if(isset($_POST['drep'])){
        $waittime = 21600 + time();
        
        $check_sort = mysqli_query($con, "SELECT * FROM accounts WHERE username = '".$_POST['username']."'");

        if(mysqli_num_rows($check_sort) > 0) {
            $sql = "SELECT * FROM accounts WHERE username='".$_POST['username']."'";
            $query = mysqli_query($con, $sql) or die (mysqli_error());
            $row_victim = mysqli_fetch_assoc($query);
                        
            $exp_victim = $row_victim['exp'];
            $exp_outcome = $exp_victim / 10;
            
            $cash_victim = $row_victim['money'];
            $bank_victim = $row_victim['bank_money'];
            
            $total_victim_cash = $cash_victim + $bank_victim;
            $give_twentyfive = $total_victim_cash * 0.25;
            $cash_outcome = mt_rand($give_twentyfive, ($total_victim_cash / 2));
            

            $check_livvakt = mysqli_query($con, "SELECT * FROM livvakt WHERE acc_id = '".$row_victim['ID']."'");
            if(mysqli_num_rows($check_livvakt) > 0) {
                $sql = "SELECT * FROM livvakt WHERE acc_id='".$row_victim['ID']."'";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row_livvakt = mysqli_fetch_assoc($query);
                
                if($row_livvakt['lvl'] == 0){
                    $livvakt_boost = 1;
                } elseif($row_livvakt['lvl'] == 1){
                    $livvakt_boost = 1.1;
                } elseif($row_livvakt['lvl'] == 2){
                    $livvakt_boost = 1.15;
                } elseif($row_livvakt['lvl'] == 3){
                    $livvakt_boost = 1.2;
                }
            } else {
                $livvakt_boost = 1;
            }
            
            if($role == 2){
                $antall_kuler_krav = (($exp_victim * $livvakt_boost) / $exp_pr_kuler ) * 0.9;
            } else {
                $antall_kuler_krav = (($exp_victim * $livvakt_boost) / $exp_pr_kuler );
            }

            
            $username_victim = $row_victim['username'];

            
            $sql = "SELECT * FROM bunker WHERE acc_id='".$row_victim['ID']."'";
            $query = mysqli_query($con, $sql) or die (mysqli_error());
            $row_bunker = mysqli_fetch_assoc($query);


            if(($register_date + 432000) > time()){
                // starttid
                echo '<div class="feedback mislykket">
                    <span>Du har startbeskyttelse (5 dager fra registrering) og kan ikke drepe.</span> 
                </div>';
            } elseif(($row_victim['register_date'] + 432000) > time()){
                // starttid
                echo '<div class="feedback mislykket">
                    <span>Brukeren har start beskyttelse (5 dager fra registrering).</span> 
                </div>';
            } elseif($_POST['bullets'] > $bullets_mine){
                //  bruker flere kuler enn man har
                echo '<div class="feedback mislykket">
                    <span>Du kan ikke bruke flere kuler enn du har.</span> 
                </div>';
            } elseif($_POST['bullets'] < 0){
                //  bruker minus kuler
                echo '<div class="feedback mislykket">
                    <span>Du kan ikke bruke mindre enn 1 kule.</span> 
                </div>';
            } elseif($row_victim['account_type'] == 1 || $row_victim['account_type'] == 2 || $row_victim['account_type'] == 3){
                // brukeren er admin
                echo '<div class="feedback mislykket">
                    <span>Brukeren er med i crewet og kan ikke drepes.</span> 
                </div>';
            } elseif($row_victim['account_type'] == 69){
                // brukeren allerede død
                echo '<div class="feedback mislykket">
                    <span>Brukeren er allerede død.</span> 
                </div>';
            } elseif($row_bunker['bunker_status'] == 1){
                // GI HALV HP ETTER ANGREP //
                $timeout_time = time() + 43200;
                $query = "INSERT into `half_hp` (acc_id, timeout)
                VALUES ('$ID', '$timeout_time')";
                $result = mysqli_query($con, $query);
                
                $result = "UPDATE accounts SET helse = (helse / 2) WHERE ID = '".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
                // GI HALV HP ETTER ANGREP //
                
                // mislykket, bruker i bunker
                $result = "UPDATE drep_cd SET drep_status = 1, drep_seconds = $waittime WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");

                $query = "INSERT into `varsel` (acc_id, text, date)
                VALUES ('".$row_victim['ID']."', 'Du har blitt angrepet, men du var i bunker!', '".time()."')";
                $result = mysqli_query($con, $query);
                
                header("Location: index.php?side=drep&mislykket");
            } elseif($row_victim['city'] != $city){
                // GI HALV HP ETTER ANGREP //
                $timeout_time = time() + 43200;
                $query = "INSERT into `half_hp` (acc_id, timeout)
                VALUES ('$ID', '$timeout_time')";
                $result = mysqli_query($con, $query);
                
                $result = "UPDATE accounts SET helse = (helse / 2) WHERE ID = '".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
                // GI HALV HP ETTER ANGREP //
                
                // mislykket, feil by
                $result = "UPDATE drep_cd SET drep_status = 1, drep_seconds = $waittime WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");

                $query = "INSERT into `varsel` (acc_id, text, date)
                VALUES ('".$row_victim['ID']."', 'Du har blitt angrepet, men du var i en annen by!', '".time()."')";
                $result = mysqli_query($con, $query);
                
                header("Location: index.php?side=drep&mislykket");
            } elseif($_POST['bullets'] < $antall_kuler_krav){
                
                // GI HALV HP ETTER ANGREP //
                $timeout_time = time() + 43200;
                $query = "INSERT into `half_hp` (acc_id, timeout)
                VALUES ('$ID', '$timeout_time')";
                $result = mysqli_query($con, $query);
                
                $result = "UPDATE accounts SET helse = (helse / 2) WHERE ID = '".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
                // GI HALV HP ETTER ANGREP //
                
                // mislykket, for få kuler
                $resterende = ($_POST['bullets'] * $exp_pr_kuler) / ($exp_victim * $livvakt_boost);
                $take_health = $resterende * 100;
                
                if($take_health > $row_victim['helse']){
                    $result = "UPDATE drep_cd SET drep_status = 1, drep_seconds = $waittime WHERE acc_id='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $result = "UPDATE accounts SET exp = (exp + $exp_outcome), money = (money + $cash_outcome), bullets = (bullets - ".$_POST['bullets'].") WHERE ID='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    
                    $result = "UPDATE daily_exp SET exp = (exp + $exp_outcome) WHERE acc_id='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $result = "UPDATE accounts SET helse = (helse - $take_health) WHERE ID='".$row_victim['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    
                    $result = "UPDATE stats SET kills = (kills + 1) WHERE acc_id='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    
                    $query = "INSERT into `last_events` (acc_id, event, time)
                    VALUES ('".$row_victim['ID']."', 'ble drept', '".time()."')";
                    $result = mysqli_query($con, $query);

                    $result_vitne = mysqli_query($con, "SELECT * FROM accounts WHERE city='$city' ORDER BY RAND() LIMIT 15");
                    while($row_vitne = mysqli_fetch_assoc($result_vitne)) {
                        if($row_vitne['ID'] != $ID){
                            $query = "INSERT into `varsel` (acc_id, text, date)
                            VALUES ('".$row_vitne['ID']."', 'Du så ".$username." drepe ".$username_victim."', '".time()."')";
                            $result = mysqli_query($con, $query);
                        }
                    }
                    
                    header("Location: index.php?side=drep&velykket=".$row_victim['username']."&kuler=".$_POST['bullets']."&money=".$cash_outcome."");
                } else {
                    
                    $result = "UPDATE drep_cd SET drep_status = 1, drep_seconds = $waittime WHERE acc_id='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $result = "UPDATE accounts SET bullets = (bullets - ".$_POST['bullets'].") WHERE ID='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $result = "UPDATE accounts SET helse = (helse - $take_health) WHERE ID='".$row_victim['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $query = "INSERT into `varsel` (acc_id, text, date)
                    VALUES ('".$row_victim['ID']."', 'Du har blitt angrepet!', '".time()."')";
                    $result = mysqli_query($con, $query);

                    header("Location: index.php?side=drep&damage=$take_health");
                }
            } else {
                // GI HALV HP ETTER ANGREP //
                $timeout_time = time() + 43200;
                $query = "INSERT into `half_hp` (acc_id, timeout)
                VALUES ('$ID', '$timeout_time')";
                $result = mysqli_query($con, $query);
                
                $result = "UPDATE accounts SET helse = (helse / 2) WHERE ID = '".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
                // GI HALV HP ETTER ANGREP //
                
                $query = "INSERT into `last_events` (acc_id, event, time)
                VALUES ('".$row_victim['ID']."', 'ble drept', '".time()."')";
                $result = mysqli_query($con, $query);
                
                $result = "UPDATE drep_cd SET drep_status = 1, drep_seconds = $waittime WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
                
                $result = "UPDATE accounts SET exp = (exp + $exp_outcome), money = (money + $cash_outcome), bullets = (bullets - ".$_POST['bullets'].") WHERE ID='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
                
                $result = "UPDATE daily_exp SET exp = (exp + $exp_outcome) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
                
                $result = "UPDATE accounts SET account_type = 69 WHERE ID='".$row_victim['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
                
                $result = "UPDATE stats SET kills = (kills + 1) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");

                $result_vitne = mysqli_query($con, "SELECT * FROM accounts WHERE city='$city' ORDER BY RAND() LIMIT 15");
                while($row_vitne = mysqli_fetch_assoc($result_vitne)) {
                    if($row_vitne['ID'] != $ID){
                        $query = "INSERT into `varsel` (acc_id, text, date)
                        VALUES ('".$row_vitne['ID']."', 'Du så ".$username." drepe ".$username_victim."', '".time()."')";
                        $result = mysqli_query($con, $query);
                    }
                }
                
                header("Location: index.php?side=drep&velykket=".$row_victim['username']."&kuler=".$_POST['bullets']."&money=".$cash_outcome."");
            }
        } else {
            echo '<div class="feedback feilmelding">
                <span>Brukeren finnes ikke</span> 
            </div>';
        }
    }

?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Drap » </span><span style="color: #afafaf;">Drep</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
            <?php 
    
    $sql = "SELECT * FROM drep_cd WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
    $query = mysqli_query($con, $sql) or die (mysqli_error());
    $row_drep_cd = mysqli_fetch_assoc($query);
    
    if($row_drep_cd['drep_status'] == 1){
        echo '<div class="feedback feilmelding">
            <span>Du må vente ';
        echo secondsToTime($row_drep_cd['drep_seconds'] - time());
        echo ' før du kan drepe igjen.</span> 
        </div>';
        
    } else {
            
            ?>
        
        <div class="content">

        <div class="header">
            <span>Drep spiller</span>
        </div>
        <img src="img/action/drep.png">
            <form method="POST" action="">
                <center>
                <p>Ventetid: 6t</p>
                <p>Hvem ønsker du å drepe?</p>
                <input type="text" name="username" placeholder="Brukernavn" style="width: 40%;" required>

                <p>Hvor mange kuler vil du bruke?<br>Du har: <?php echo number($bullets_mine) ?> kuler</p>
                <input type="number" name="bullets" placeholder="Antall kuler" style="width: 40%;" required>
                <br>
                <input type="submit" style="width: 20%;" name="drep" value="Drep">
                </center>
            </form>
            <?php } 
     ?>
        </div>
    </body>
</html>
<?php 

}

?>