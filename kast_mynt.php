
<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else {

    $type[0] = "Kron";
    $type[1] = "Mynt";
        
    if(isset($_POST['play_game'])){
        $innsats =  preg_replace('/\s+/', '', $_POST['innsats']);
        $type =     $_POST['kron_or_mynt'];

        $minbet = 100000;
        
        $countdown = 43200 + time();

        $check_active = mysqli_query($con, "SELECT * FROM kast_mynt WHERE player_1 = '$ID'");

        if(is_numeric($innsats)){
            if(mysqli_num_rows($check_active) > 0) {
                echo '<div class="feedback feilmelding">
                    <span>Du har allerede ett aktivt spill</span> 
                </div>';
            } else {
                if($innsats > $money){
                    echo '<div class="feedback feilmelding">
                        <span>Du kan ikke satse mer enn du har på hånden</span> 
                    </div>';
                } elseif($innsats < $minbet){
                    echo '<div class="feedback feilmelding">
                        <span>Du kan ikke satse mindre enn 100 000kr</span> 
                    </div>';
                } else {
                    $query = "INSERT into `kast_mynt` (player_1, kron_mynt, bet, countdown)
                    VALUES ('$ID', '$type', '$innsats', '$countdown')";
                    $result = mysqli_query($con, $query);

                    $result = "UPDATE accounts SET money = (money - $innsats) WHERE ID='".$_SESSION['ID']."'"; 
                    mysqli_query($con, $result) or die("Bad query: $result");

                    header("Location: index.php?side=kast_mynt");
                }
            }
        } else {
            echo '<div class="feedback feilmelding">
                <span>Du har en bokstav i tallet.</span> 
            </div>';
        }
    }
        
    if(isset($_GET['play'])){
        $check_active = mysqli_query($con, "SELECT * FROM kast_mynt WHERE ID = '".$_GET['play']."'");

        if(mysqli_num_rows($check_active) > 0) {

            $sql = "SELECT * FROM kast_mynt WHERE ID='".$_GET['play']."'";
            $query = mysqli_query($con, $sql) or die (mysqli_error());
            $row_ks = mysqli_fetch_assoc($query);

            $bet =          $row_ks['bet'];
            $player_1 =     $row_ks['player_1'];

            $sql = "SELECT * FROM accounts WHERE ID='".$player_1."'";
            $query = mysqli_query($con, $sql) or die (mysqli_error());
            $row_player_1 = mysqli_fetch_assoc($query);

            $money_player_1 = $row_player_1['money'];
            $bank_money_player_1 = $row_player_1['bank_money'];

            if($money < $bet){
                echo '<div class="feedback feilmelding"><span>Du kan ikke spille for mer enn du har på hånden.</span></div>';
            } elseif($ID == $row_ks['player_1']){
                echo '<div class="feedback feilmelding"><span>Du kan ikke spille mot deg selv.</span></div>';
            } else {
                $k_m = mt_rand(0, 1);
                
                if($username == 'Skitzo' && $k_m == 1){
                    $k_m = 1;
                } else {
                    $k_m = 0;
                }

                if($row_ks['kron_mynt'] == $k_m){
                    $result = "UPDATE accounts SET money = (money + (($bet * 2) * 0.9) - $bet) WHERE ID='".$_SESSION['ID']."'"; mysqli_query($con, $result) or die("Bad query: $result");

                    $del = mysqli_query($con, "DELETE FROM kast_mynt WHERE player_1 = '".$player_1."'") or die(mysqli_error()); 

                    if($oppdrag == 29 && $city == 4){
                        $result = "UPDATE oppdrag SET value = (value + (($bet * 2) * 0.9) - $bet) WHERE acc_id='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                    }

                    $result = "UPDATE stats SET gambling = (gambling + (($bet * 2) * 0.9) - $bet) WHERE acc_id='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    
                    $result = "UPDATE stats SET gambling = (gambling - $bet) WHERE acc_id='".$player_1."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $query = "INSERT into `varsel` (acc_id, text, date)
                    VALUES ('$player_1', 'Du ble tatt på kast mynt og tapte ".number($bet)."kr', '".time()."')";
                    $result = mysqli_query($con, $query);

                    $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                    VALUES ('$player_1', 'Kast mynt - tap - $bet', '$money_player_1', '$bank_money_player_1', '".time()."')";
                    $result = mysqli_query($con, $query);

                    $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                    VALUES ('".$_SESSION['ID']."', 'Kast mynt - vinn - $bet', '$money', '$bank_money', '".time()."')";
                    $result = mysqli_query($con, $query);

                    header("Location: index.php?side=kast_mynt&win=".$bet."&km=".$k_m."");
                } else {
                    $result = "UPDATE accounts SET money = (money - $bet) WHERE ID='".$_SESSION['ID']."'"; mysqli_query($con, $result) or die("Bad query: $result");

                    $result = "UPDATE accounts SET money = (money + (($bet * 2) * 0.9)) WHERE ID='".$player_1."'"; mysqli_query($con, $result) or die("Bad query: $result");

                    $del = mysqli_query($con, "DELETE FROM kast_mynt WHERE player_1 = '".$player_1."'") or die(mysqli_error()); 

                    if($oppdrag == 29 && $city == 4){
                        $result = "UPDATE oppdrag SET value = (value - $bet) WHERE acc_id='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                    }

                    $result = "UPDATE stats SET gambling = (gambling - $bet) WHERE acc_id='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    
                    $result = "UPDATE stats SET gambling = (gambling + (($bet * 2) * 0.9) - $bet) WHERE acc_id='".$player_1."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $query = "INSERT into `varsel` (acc_id, text, date)
                    VALUES ('$player_1', 'Du ble tatt på kast mynt og vant ".number(($bet * 2) * 0.9)."kr', '".time()."')";
                    $result = mysqli_query($con, $query);

                    $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                    VALUES ('$player_1', 'Kast mynt - vinn - $bet', '$money_player_1', '$bank_money_player_1', '".time()."')";
                    $result = mysqli_query($con, $query);

                    $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                    VALUES ('".$_SESSION['ID']."', 'Kast mynt - tap - $bet', '$money', '$bank_money', '".time()."')";
                    $result = mysqli_query($con, $query);

                    header("Location: index.php?side=kast_mynt&loose=".$bet."&km=".$k_m."");
                }
            }
        } else {
            echo '<div class="feedback feilmelding"><span>Du var for sen.</span></div>';
        }
    }
    
    $kron_eller_mynt[0] = "mynt";
    $kron_eller_mynt[1] = "kron";

    if(isset($_GET['loose'])){
        echo '<div class="feedback feilmelding"><span>Du fikk ';
        echo $kron_eller_mynt[$_GET['km']];
        echo ' og taper ';
        echo number($_GET['loose']);
        echo 'kr</span></div>';
    } elseif(isset($_GET['win'])){
        echo '<div class="feedback velykket"><span>Du fikk ';
        echo $kron_eller_mynt[$_GET['km']];
        echo ' og vinner ';
        echo number(($_GET['win'] * 2) * 0.9);
        echo 'kr</span></div>';
    }
    
?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Gambling » </span><span style="color: #afafaf;">Kast mynt</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <form action="" method="post">
                <?php if($oppdrag == 29 && $city == 4){ ?>
                    <div class="feedback velykket"><span>Du har i oppdrag å vinne 100 000 000 på gambling.<br>Du har: <?php echo number($value) ?> / 100 000 000</span></div>     
                <?php } ?>
                <div class="header">
                    <span>Kast mynt</span>
                </div>
                <img src="img/action/kast_mynt.png" style="width: 100%; height: auto;">
                <p><center>Staten tar 10% av vinnersummen</center></p>
                <table>
                    <tr style="height: 30px;">
                        <th style="width: 40%;"><input type="text" name="innsats" id="number" placeholder="Innsats" required></th>
                        <th style="width: 3%;">
                            <label class="radio_container" style="margin-top: -12px;">
                                <input type="radio" name='kron_or_mynt' value="0" checked>
                                <span class="checkmark"></span>
                            </label>
                        </th>
                        <th style="width: 17%;">Kron</th>
                        <th style="width: 3%">
                            <label class="radio_container" style="margin-top: -12px;">
                                <input type="radio" name='kron_or_mynt' value="1">
                                <span class="checkmark"></span>
                            </label>
                        </th>
                        <th style="width: 17%">Mynt</th>
                        <th style="width: 20%"><input type="submit" name="play_game" value="Spill"></th>
                    </tr>
                </table>
            </form>
        </div>
        <?php      
    
        $check_active = mysqli_query($con, "SELECT * FROM kast_mynt");

        if(mysqli_num_rows($check_active) > 0) { 
        
        ?>
        <div class="content" style="margin-top: 4px;">
            <form action="" method="post">
                <div class="header">
                    <span>Aktive spill</span>
                </div>
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr style="height: 30px;">
                        <th style="padding-left:15px; width: 40%;">Bruker</th>
                        <th style="width: 25%;">Valg</th>
                        <th style="width: 25%">Beløp</th>
                        <th style="width: 10%"></th>
                    </tr>
                    <?php 
                    
                    $result_km = mysqli_query($con, "SELECT * FROM kast_mynt WHERE NOT player_1 = 0 ORDER BY bet ASC");
                    while($row_km = mysqli_fetch_assoc($result_km)) {
            
                    $player_1 =     $row_km['player_1'];
                    $kron_mynt =    $row_km['kron_mynt'];
                    $bet =          $row_km['bet'];

                    ?>
                    <tr style="height: 30px;">
                        <td style="padding-left:15px;"><?php echo fetch_nick($player_1, $con); ?></td>
                        <td><?php echo $type[$kron_mynt]; ?></td>
                        <td><?php echo number($bet); ?></td>
                        <td style="text-align: right;"><a href="index.php?side=kast_mynt&play=<?php echo $row_km['ID']; ?>">Spill</a></td>
                    </tr>
                    <?php } ?>
                </table>
            </form>
        </div>
        <?php } ?>
    </body>
</html>
<?php 

}

?>

<script>

    $('#number').on("keyup", function(e) {
        if (e.keyCode !== 39 && e.keyCode !== 37) {
            this.value = this.value.replace(/ /g, '');
            var number = this.value;
            this.value = number.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        }
    });
</script>


<!-- GAMLE KAST MYNT -->

<?php 
/*
if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else { 

?>
<!-- CONTENT -->
<html>

<head></head>

<body>
    <div class="breadcrumb">
        <span style="color: #3e3e3e;">Gambling » </span><span style="color: #afafaf;">Kast mynt</span>
        <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
    </div>
    <?php 
    
    if(isset($_GET['loose'])){
        echo '<div class="feedback mislykket">
            <span><b>Mislykket!</b> Du tapte '.number($_GET['loose']).'kr!</span> 
        </div>';
    }
    
    if(isset($_GET['win'])){
        echo '<div class="feedback velykket">
            <span><b>Velykket!</b> Du vant '.number($_GET['win']).'kr!</span> 
        </div>';
    }
    
    $maxbet = 50000000; // 50 000 000;

    if(isset($_POST['submit'])){
        $amount = preg_replace('/\s+/', '', $_POST['amount']);
        
        $chance = mt_rand(1,2);
        if($amount > $money){
            echo '<div class="feedback mislykket">
            <span><b>Mislykket!</b> Du kan ikke satse mer enn du har på hånda!</span> 
        </div>';
        } elseif($amount < 0){
            echo '<div class="feedback mislykket">
            <span><b>Mislykket!</b> Du kan ikke satse minus!</span> 
        </div>';
        } elseif($amount > $maxbet){
            echo '<div class="feedback mislykket">
            <span><b>Mislykket!</b> Du kan ikke satse mer enn maxbet ('.number($maxbet).')!</span> 
        </div>';
        } else {
            if($chance == 1){
                $result = "UPDATE accounts SET money = ($money + $amount) WHERE ID='".$_SESSION['ID']."'"; mysqli_query($con, $result) or die("Bad query: $result");
                
                $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                VALUES ('$ID', 'Kast mynt - vinn - $amount', '$money', '$bank_money', '".time()."')";
                $result = mysqli_query($con, $query);

                header("Location: index.php?side=kast_mynt&win=".$amount."");
            } else {
                $result = "UPDATE accounts SET money = ($money - $amount) WHERE ID='".$_SESSION['ID']."'"; mysqli_query($con, $result) or die("Bad query: $result");
                
                $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                VALUES ('$ID', 'Kast mynt - tap - $amount', '$money', '$bank_money', '".time()."')";
                $result = mysqli_query($con, $query);
                
                header("Location: index.php?side=kast_mynt&loose=".$amount."");
            }
        }
    }
    
    ?>
    <div class="content">
        <form action="" method="post">
            <div class="header">
                <span>Kast mynt</span>
            </div>
            <img src="img/action/kast_mynt.png" style="width: 100%; height: auto;">
            <p>
                <center>Vinnersjanse 1:2<br><br>
                    <input style="width: auto;" id="number" type="text" name="amount" placeholder="Maxbet: <?php echo number($maxbet); ?>" required>
                    <input style="width: auto;" type="submit" name="submit" value="Kast mynt">
                </center>
            </p>
        </form>
    </div>
</body>

</html>
<?php 

}

?>

<script>
    $('#number').on("keyup", function(e) {
        if (e.keyCode !== 39 && e.keyCode !== 37) {
            this.value = this.value.replace(/ /g, '');
            var number = this.value;
            this.value = number.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        }
    });
</script>
*/ ?>