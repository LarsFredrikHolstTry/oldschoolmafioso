<?php 

if(!isset($_GET['side'])){
    header("Location: index.php");
} elseif($city != 1) { 
    echo '<div class="feedback feilmelding">
            <span>Dette heistet kan kun utføres i Oslo</span> 
        </div>';
} elseif($rank < 1) {
    echo '<div class="feedback feilmelding">
            <span>Du må være ranken Associates eller høyere for å gjøre heist i Oslo</span> 
        </div>';
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else {

$sql = "SELECT * FROM heist_cd WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row_cd = mysqli_fetch_assoc($query);

    if($row_cd['heist_seconds'] > time()){

if(isset($_GET['mislykket'])){
    echo '<div class="feedback mislykket">
        <span>Dere feilet heistet. Ingen penger for dere!</span> 
    </div>';
}

if(isset($_GET['velykket'])){
    $cashout = $_GET['cash'];

    echo '<div class="feedback velykket">
        <span>Dere klarte å rane klysen for juveler! Dere får ';
    echo number($cashout);
    echo 'kr hver.</span> 
    </div>';
}

?>

<div class="breadcrumb">
    <span style="color: #3e3e3e;">Oslo » </span><span style="color: #afafaf;">Heist i Oslo</span>
    <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
</div>
<div class="content">
    <div class="header">
        <span>Heist</span>
    </div>
    <img src="img/action/heist.png" style="width: 100%; height: auto;">
    <div class="feedback feilmelding">
        <span>Du må vente <?php echo secondsToTime($row_cd['heist_seconds'] - time()); ?> før du kan gjøre heist igjen</span>
    </div>
</div>

<?php
        
    } else {

    $cooldown = 7200 + time(); // 2 timer
      
    $gun[0] = "Glock";
    $gun[1] = "Uzi";
    $gun[2] = "M4A4";
    $gun[3] = "AK-47";
    $gun[4] = "RPG";
    $gun[5] = "Grenade Launcher";

    $pris = 1000000; // 1 000 000kr

    if(isset($_POST['submit'])){
        if($money < $pris){
            echo '<div class="feedback feilmelding">
                <span>Du har ikke nok penger til å starte heist</span> 
            </div>';
        } else {
            $random_id = uniqid();
            
            $result = "UPDATE accounts SET money = ($money - $pris) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");

            $query = "INSERT into `heist` (heist_id, leader)
            VALUES ('$random_id', '$ID')";
            $result = mysqli_query($con, $query);

            header("Location: index.php?side=heist");
        }
    }
    
    if(isset($_POST['start_heist'])){
        
        $times_ten = mt_rand(1, 15);

        if($happy_hour == 1){
            if($times_ten == 1){
                $payout = mt_rand(100000000, 200000000);
            } else {
                $payout = mt_rand(50000000, 90000000);
            }
        } elseif($role == 1){
            $payout = mt_rand(15000000, 79000000);
        } else {
            $payout = mt_rand(10000000, 65000000);
        }
        
        if($happy_hour == 1){
            $exp_heist = mt_rand(4500, 9500);
        } else {
            $exp_heist = mt_rand(2500, 5000);
        }

        $sql = "SELECT * FROM heist WHERE leader='".$ID."'";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row_hesst = mysqli_fetch_assoc($query);
        
        $heist_id = $row_hesst['heist_id'];
        $robber_[0] = $row_hesst['robber_0'];
        $robber_[1] = $row_hesst['robber_1'];
        $robber_[2] = $row_hesst['robber_2'];
        $robber_[3] = $row_hesst['robber_3'];
        $robber_[4] = $row_hesst['robber_4'];
        $robber_[5] = $row_hesst['robber_5'];
        $robber_[6] = $row_hesst['robber_6'];
        $robber_[7] = $row_hesst['robber_7'];
        $robber_[8] = $row_hesst['robber_8'];
        
        $chance = 0;
        $j = 1;
        for($i = 0; $i < 9; $i++){
            if($robber_[$i] == 0){
                
            } else {
                $sql = "SELECT * FROM accounts WHERE ID='".$robber_[$i]."'";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row_heis = mysqli_fetch_assoc($query);
                
                $chance = $chance + ($row_heis['vapen'] * 20);
                
                $j++;
            }
        }
        
        $chance = $chance + ($vapen * 20);
        $total_chance = $chance / $j;
        
        $hunna = mt_rand(0, 100);
        
        if($j < 2){
            echo '<div class="feedback feilmelding">
                <span>Det kreves minst 2 stk til å utføre heistet.</span> 
            </div>';
        } elseif($total_chance < $hunna) {
            $sql = "SELECT * FROM heist WHERE leader='".$ID."'";
            $query = mysqli_query($con, $sql) or die (mysqli_error());
            $row_hesst = mysqli_fetch_assoc($query);

            $heist_id = $row_hesst['heist_id'];
            $robber_[0] = $row_hesst['robber_0'];
            $robber_[1] = $row_hesst['robber_1'];
            $robber_[2] = $row_hesst['robber_2'];
            $robber_[3] = $row_hesst['robber_3'];
            $robber_[4] = $row_hesst['robber_4'];
            $robber_[5] = $row_hesst['robber_5'];
            $robber_[6] = $row_hesst['robber_6'];
            $robber_[7] = $row_hesst['robber_7'];
            $robber_[8] = $row_hesst['robber_8'];

            for($i = 0; $i < 9; $i++){
                if($robber_[$i] == 0){

                } else {
                    $result = "UPDATE heist_cd SET heist_status = 1, heist_seconds = '$cooldown' WHERE acc_id='".$robber_[$i]."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    
                    $result = "UPDATE accounts SET vapen = 0 WHERE ID='".$robber_[$i]."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    
                    $query = "INSERT into `varsel` (acc_id, text, date)
                    VALUES ('$robber_[$i]', 'Beklager! Heistet du var med på var en flopp.', '".time()."')";
                    $result = mysqli_query($con, $query);
                }
            }
            
            $result = "UPDATE heist_cd SET heist_status = 1, heist_seconds = '$cooldown' WHERE acc_id='".$ID."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $result = "UPDATE accounts SET vapen = 0 WHERE ID='".$ID."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $query = "INSERT into `varsel` (acc_id, text, date)
            VALUES ('$ID', 'Beklager! Heistet du var med på var en flopp.', '".time()."')";
            $result = mysqli_query($con, $query);
            
            $del = mysqli_query($con, "DELETE FROM heist WHERE heist_id = '$heist_id'") or die(mysqli_error()); 
            $del = mysqli_query($con, "DELETE FROM heist_inv WHERE heist_id = '$heist_id'") or die(mysqli_error()); 
            
            header("Location: index.php?side=heist&mislykket");
        } else {
            $sql = "SELECT * FROM heist WHERE leader='".$ID."'";
            $query = mysqli_query($con, $sql) or die (mysqli_error());
            $row_hesst = mysqli_fetch_assoc($query);

            $heist_id = $row_hesst['heist_id'];
            $robber_[0] = $row_hesst['robber_0'];
            $robber_[1] = $row_hesst['robber_1'];
            $robber_[2] = $row_hesst['robber_2'];
            $robber_[3] = $row_hesst['robber_3'];
            $robber_[4] = $row_hesst['robber_4'];
            $robber_[5] = $row_hesst['robber_5'];
            $robber_[6] = $row_hesst['robber_6'];
            $robber_[7] = $row_hesst['robber_7'];
            $robber_[8] = $row_hesst['robber_8'];

            for($i = 0; $i < 9; $i++){
                if($robber_[$i] == 0){

                } else {
                    $result = "UPDATE accounts SET money = (money + $payout), vapen = 0, exp = (exp + $exp_heist) WHERE ID='".$robber_[$i]."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    
                    $result = "UPDATE heist_cd SET heist_status = 1, heist_seconds = '$cooldown' WHERE acc_id='".$robber_[$i]."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    
                    $query = "INSERT into `varsel` (acc_id, text, date)
                    VALUES ('$robber_[$i]', 'Gratulerer! Heistet du var med på var vellykket og du får med deg ".number($payout)."kr.', '".time()."')";
                    $result = mysqli_query($con, $query);
                }
            }
            
            $result = "UPDATE heist_cd SET heist_status = 1, heist_seconds = '$cooldown' WHERE acc_id='".$ID."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $result = "UPDATE accounts SET money = (money + $payout), vapen = 0 WHERE ID='".$ID."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $query = "INSERT into `varsel` (acc_id, text, date)
            VALUES ('$ID', 'Gratulerer! Heistet du var med på var vellykket og du får med deg ".number($payout)."kr.', '".time()."')";
            $result = mysqli_query($con, $query);
            
            $del = mysqli_query($con, "DELETE FROM heist WHERE heist_id = '$heist_id'") or die(mysqli_error()); 
            $del = mysqli_query($con, "DELETE FROM heist_inv WHERE heist_id = '$heist_id'") or die(mysqli_error()); 

            header("Location: index.php?side=heist&velykket&cash=$payout");
        }
    }
    
    if(isset($_POST['cancel_heist'])){
        $del = mysqli_query($con, "DELETE FROM heist WHERE leader = '$ID'") or die(mysqli_error()); 
        $del = mysqli_query($con, "DELETE FROM heist_inv WHERE leader = '$ID'") or die(mysqli_error()); 
        
        echo '<div class="feedback velykket">
            <span>Du avbrøt ranet</span> 
        </div>';
    }
    
    if(isset($_GET['godta'])){
        $check_heist = mysqli_query($con, "SELECT * FROM heist WHERE 
                    '".$ID."' IN(robber_0, robber_1, robber_2, robber_3, robber_4, robber_5, robber_6, robber_7, robber_8)");

        if(mysqli_num_rows($check_heist) > 0) {
            echo '<div class="feedback mislykket">
                <span>Du er allerede i en heist!</span> 
            </div>';
        } else {
            $sql = "SELECT * FROM heist WHERE heist_id='".$_GET['godta']."'";
            $query = mysqli_query($con, $sql) or die (mysqli_error());
            $row_hesst = mysqli_fetch_assoc($query);

            $robber_[0] = $row_hesst['robber_0'];
            $robber_[1] = $row_hesst['robber_1'];
            $robber_[2] = $row_hesst['robber_2'];
            $robber_[3] = $row_hesst['robber_3'];
            $robber_[4] = $row_hesst['robber_4'];
            $robber_[5] = $row_hesst['robber_5'];
            $robber_[6] = $row_hesst['robber_6'];
            $robber_[7] = $row_hesst['robber_7'];
            $robber_[8] = $row_hesst['robber_8'];

            if($robber_[0] == 0){
                $result = "UPDATE heist SET robber_0 = $ID WHERE heist_id='".$_GET['godta']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            } elseif($robber_[1] == 0){
                $result = "UPDATE heist SET robber_1 = $ID WHERE heist_id='".$_GET['godta']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            } elseif($robber_[2] == 0){
                $result = "UPDATE heist SET robber_2 = $ID WHERE heist_id='".$_GET['godta']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            } elseif($robber_[3] == 0){
                $result = "UPDATE heist SET robber_3 = $ID WHERE heist_id='".$_GET['godta']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            } elseif($robber_[4] == 0){
                $result = "UPDATE heist SET robber_4 = $ID WHERE heist_id='".$_GET['godta']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            } elseif($robber_[5] == 0){
                $result = "UPDATE heist SET robber_5 = $ID WHERE heist_id='".$_GET['godta']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            } elseif($robber_[6] == 0){
                $result = "UPDATE heist SET robber_6 = $ID WHERE heist_id='".$_GET['godta']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            } elseif($robber_[7] == 0){
                $result = "UPDATE heist SET robber_7 = $ID WHERE heist_id='".$_GET['godta']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            } elseif($robber_[8] == 0){
                $result = "UPDATE heist SET robber_8 = $ID WHERE heist_id='".$_GET['godta']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            } else {
                echo '<div class="feedback feilmelding">
                    <span>Det ranet du prøver å bli med i er fullt.</span> 
                </div>';
            }

            $del = mysqli_query($con, "DELETE FROM heist_inv WHERE heist_id = '".$_GET['godta']."' AND acc_id = $ID") or die(mysqli_error()); 

            header("Location: index.php?side=heist");
        }
    }

    
    
?>
<!-- CONTENT -->
<html>

<head></head>

<body>
    <div class="breadcrumb">
        <span style="color: #3e3e3e;">Oslo » </span><span style="color: #afafaf;">Heist i Oslo</span>
        <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
    </div>
    <div class="content">
        <?php 
            
            if(isset($_POST['inv_heist'])){
                $sql = "SELECT * FROM heist WHERE leader='$ID'";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row_led = mysqli_fetch_assoc($query);

                $ID_heist =                 $row_led['heist_id'];

                $sql = "SELECT * FROM accounts WHERE username='".$_POST['inv_name']."'";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row_inv = mysqli_fetch_assoc($query);

                $ID_inv =                   $row_inv['ID'];

                $check_heist = mysqli_query($con, "SELECT * FROM heist WHERE leader = '$ID_inv' OR robber_0 = '$ID_inv' OR robber_1 = '$ID_inv' OR robber_2 = '$ID_inv' OR robber_3 = '$ID_inv' OR robber_4 = '$ID_inv' OR robber_5 = '$ID_inv' OR robber_6 = '$ID_inv' OR robber_7 = '$ID_inv' OR robber_8 = '$ID_inv'");
                
                $check_inv_heist = mysqli_query($con, "SELECT * FROM heist_inv WHERE leader = '$ID' AND acc_id = '$ID_inv'");

                $check_if_user_exist = mysqli_query($con, "SELECT * FROM accounts WHERE ID = '$ID_inv'");

                if(mysqli_num_rows($check_if_user_exist) != 1){ 
                    echo '<div class="feedback feilmelding">
                        <span>Brukeren finnes ikke.</span> 
                    </div>';
                } elseif(mysqli_num_rows($check_heist) > 0) {
                    echo '<div class="feedback feilmelding">
                        <span>Brukeren er allerede i en aktiv heist.</span> 
                    </div>';
                } elseif(mysqli_num_rows($check_inv_heist) > 0){
                    echo '<div class="feedback feilmelding">
                        <span>Brukeren er allerede invitert til ditt heist.</span> 
                    </div>';
                } else {
                    $query = "INSERT into `heist_inv` (acc_id, heist_id, leader)
                    VALUES ('$ID_inv', '$ID_heist', '$ID')";
                    $result = mysqli_query($con, $query);
                    
                    $query = "INSERT into `varsel` (acc_id, text, date)
                    VALUES ('$ID_inv', 'Du har blitt invitert til ett heist i Oslo av ".$username."', '".time()."')";
                    $result = mysqli_query($con, $query);
                                    
                    echo '<div class="feedback velykket">
                        <span>Brukeren ble invitert!</span> 
                    </div>';
                }
            }
    
            if(isset($_GET['spark_id'])){
                $spark_id = $_GET['spark_id'];
                
                $sql = "SELECT * FROM heist WHERE robber_0 = '$spark_id' OR robber_1 = '$spark_id' OR robber_2 = '$spark_id' OR robber_3 = '$spark_id' OR robber_4 = '$spark_id' OR robber_5 = '$spark_id' OR robber_6 = '$spark_id' OR robber_7 = '$spark_id' OR robber_8 = '$spark_id'";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row_kick = mysqli_fetch_assoc($query);

                $robber_[0] = $row_kick['robber_0'];
                $robber_[1] = $row_kick['robber_1'];
                $robber_[2] = $row_kick['robber_2'];
                $robber_[3] = $row_kick['robber_3'];
                $robber_[4] = $row_kick['robber_4'];
                $robber_[5] = $row_kick['robber_5'];
                $robber_[6] = $row_kick['robber_6'];
                $robber_[7] = $row_kick['robber_7'];
                $robber_[8] = $row_kick['robber_8'];

                for($i = 0; $i < 9; $i++){
                    if($robber_[$i] == $_GET['spark_id']){
                        $result = "UPDATE heist SET robber_".$i." = 0 WHERE robber_".$i." = '".$_GET['spark_id']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                        
                        echo '<div class="feedback velykket">
                            <span>Spiller ble sparket</span> 
                        </div>';
                    } else {
                        
                    }
                }
            }
        
            if(isset($_GET['forlat_id'])){
                $forlat_id = $_GET['forlat_id'];
                
                if($forlat_id == $ID){

                
                    $sql = "SELECT * FROM heist WHERE robber_0 = '$forlat_id' OR robber_1 = '$forlat_id' OR robber_2 = '$forlat_id' OR robber_3 = '$forlat_id' OR robber_4 = '$forlat_id' OR robber_5 = '$forlat_id' OR robber_6 = '$forlat_id' OR robber_7 = '$forlat_id' OR robber_8 = '$forlat_id'";
                    $query = mysqli_query($con, $sql) or die (mysqli_error());
                    $row_kick = mysqli_fetch_assoc($query);

                    $robber_[0] = $row_kick['robber_0'];
                    $robber_[1] = $row_kick['robber_1'];
                    $robber_[2] = $row_kick['robber_2'];
                    $robber_[3] = $row_kick['robber_3'];
                    $robber_[4] = $row_kick['robber_4'];
                    $robber_[5] = $row_kick['robber_5'];
                    $robber_[6] = $row_kick['robber_6'];
                    $robber_[7] = $row_kick['robber_7'];
                    $robber_[8] = $row_kick['robber_8'];

                    for($i = 0; $i < 9; $i++){
                        if($robber_[$i] == $_GET['forlat_id']){
                            $result = "UPDATE heist SET robber_".$i." = 0 WHERE robber_".$i." = '".$_GET['forlat_id']."'";
                            mysqli_query($con, $result) or die("Bad query: $result");

                            header("Location: index.php?side=heist");
                        }
                    }
                } else {
                   echo 'Du er allerede kastet ut, startet heist eller ikke med i heist.';
                }
            }

            ?>
        <div class="header">
            <span>Heist</span>
        </div>
        <img src="img/action/heist.png" style="width: 100%; height: auto;">
        <?php  
    
            $check_heist = mysqli_query($con, "SELECT * FROM heist WHERE leader = '$ID' OR robber_0 = '$ID' OR robber_1 = '$ID' OR robber_2 = '$ID' OR robber_3 = '$ID' OR robber_4 = '$ID' OR robber_5 = '$ID' OR robber_6 = '$ID' OR robber_7 = '$ID' OR robber_8 = '$ID'");
            if(mysqli_num_rows($check_heist) != 1) {
            
            ?>
        <form method="post">
            <p class="pad_10">
                Prisen for å utføre ett heist er <?php echo number($pris); ?> kr og det kreves mellom 2 - 10 deltakere til å utføre
            </p>
            <input style="width: 97.5%;" type="submit" name="submit" value="Start heist">
        </form>
        <?php 

                $check_heist_inv = mysqli_query($con, "SELECT * FROM heist_inv WHERE acc_id = '$ID'");
                if(mysqli_num_rows($check_heist_inv) > 0) { 
            
            ?>
        <br><br>
        <div class="header" style="border-top: 1px solid #2c2c2c;">
            <span>Invitasjoner</span>
        </div>

        <table border="0" cellspacing="0" cellpadding="0">
            <tr style="height: 30px;">
                <th style="padding-left: 10px; width: 60%;">Leder</th>
                <th style="width: 20%;"></th>
                <th style="width: 20%;"></th>
            </tr>
            <?php 

                    $i = 0;
                    $result_inves = mysqli_query($con, "SELECT * FROM heist_inv WHERE acc_id = '$ID'");
                    while($row_inves = mysqli_fetch_assoc($result_inves)) {
            
                        $acc_id_leder = $row_inves['leader'];
                        $heist_id_inves = $row_inves['heist_id'];

                        $i++;
                
                ?>
            <tr style="height: 25px;">
                <td style="padding-left: 10px;"><?php fetch_nick($acc_id_leder, $con); ?></td>
                <td><a style="color: green;" href="index.php?side=heist&godta=<?php echo $heist_id_inves ?>">Godta</a></td>
                <td><a style="color: orange;" href="index.php?side=heist&avsla=<?php echo $heist_id_inves ?>">Avslå</a></td>
            </tr>
            <?php } ?>
        </table>

        <?php } } else {
                
            $sql = "SELECT * FROM heist WHERE leader = '$ID' OR robber_0 = '$ID' OR robber_1 = '$ID' OR robber_2 = '$ID' OR robber_3 = '$ID' OR robber_4 = '$ID' OR robber_5 = '$ID' OR robber_6 = '$ID' OR robber_7 = '$ID' OR robber_8 = '$ID'";
            $query = mysqli_query($con, $sql) or die (mysqli_error());
            $row_heist = mysqli_fetch_assoc($query);

            $heist_leader = $row_heist['leader'];

            $sql = "SELECT * FROM accounts WHERE ID = '$heist_leader'";
            $query = mysqli_query($con, $sql) or die (mysqli_error());
            $row_acc_leader = mysqli_fetch_assoc($query);
                
            echo "<center style='padding: 5px;'>Deres oppdrag er å stjele smykker og juveler fra en klyse i hovedstaden som skylder meg noen hundre millioner. Klarer dere å utpresse han så skal dere få en <b>god</b> slant med penger. Ett lite tips: Jo bedre våpen du har, jo større sjanse er det for å klare utpressingen.</br> <span style='color: #555555'><i> - Parque.</i></span></center>";

            if($heist_leader == $ID){
            ?>
        <form method="post">
            <center>
                <p class="pad_10">
                    Inviter brukere til ditt heist
                </p>
                <input style="margin-left: 10px; width: 25%;" type="text" name="inv_name" palceholder="brukernanv"><input style="width: auto;" type="submit" name="inv_heist" value="Inviter"><br><br>
                <input class="no" style="width: auto;" type="submit" name="cancel_heist" onclick="return confirm('Er du sikker på at du vil avbryte heistet?');" value="Avbryt heist">
                <input style="width: auto;" type="submit" name="start_heist" value="Utfør heist">
            </center>
        </form>
        <?php } ?>
        <br>
        <div class="header" style="border-top: 1px solid #2c2c2c;">
            <span>Deltakere</span>
        </div>
        <table border="0" cellspacing="0" cellpadding="0">
            <tr style="height: 30px;">
                <th style="width: 40%; padding-left: 10px;">Brukernavn</th>
                <th style="width: 25%;">Våpen</th>
                <th style="width: 25%;">Sjanse</th>
            </tr>
            <tr style="height: 25px;">
                <td style="padding-left: 10px;"><?php fetch_nick($row_heist['leader'], $con); ?></td>
                <td><?php echo $gun[$row_acc_leader['vapen']]; ?></td>
                <td><?php echo $row_acc_leader['vapen'] * 20; ?>%</td>
            </tr>
            <?php

                $robber_[0] = $row_heist['robber_0'];
                $robber_[1] = $row_heist['robber_1'];
                $robber_[2] = $row_heist['robber_2'];
                $robber_[3] = $row_heist['robber_3'];
                $robber_[4] = $row_heist['robber_4'];
                $robber_[5] = $row_heist['robber_5'];
                $robber_[6] = $row_heist['robber_6'];
                $robber_[7] = $row_heist['robber_7'];
                $robber_[8] = $row_heist['robber_8'];

                $j = 1;
                for($i = 0; $i < 9; $i++){
                    if($robber_[$i] == 0){
                        
                    } else {
                        
                    $j++;
                        
                    $sql = "SELECT * FROM accounts WHERE ID = '$robber_[$i]'";
                    $query = mysqli_query($con, $sql) or die (mysqli_error());
                    $row_acc = mysqli_fetch_assoc($query);
                        
                    $chance = ($row_acc['vapen'] * 20);

                ?>
            <tr style="height: 25px;">
                <td style="padding-left: 10px;"><?php fetch_nick($robber_[$i], $con); if($heist_leader == $ID){ ?><a href="?side=heist&spark_id=<?php echo $robber_[$i] ?>">[Spark]</a><?php } ?>
                
                <?php if($heist_leader != $ID && $robber_[$i] == $ID){ ?><a href="?side=heist&forlat_id=<?php echo $robber_[$i] ?>">[Forlat]</a><?php } ?>
                </td>
                <td><?php echo $gun[$row_acc['vapen']]; ?></td>
                <td><?php echo $chance ?>%</td>
            </tr>
            <?php 

                    }
                }

                ?>
        </table>
        <?php } ?>
    </div>
</body>

</html>
<?php 
}
}

?>