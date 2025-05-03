
<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else {
    
$sql = "SELECT * FROM jackpot WHERE ID='1'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row = mysqli_fetch_assoc($query);

$jackpot =                   $row['jackpot'];

$min_bet = 100000;
$max_bet = 25000000;
    
    $rare =     1;                          // odds: 10%
    $medium =   array(2, 3);                // odds: 30%
    $common =   array(4, 5, 6, 7, 8, 9);    // odds: 60%
    $all =      array(2, 3, 4, 5, 6, 7, 8, 9);

    if(isset($_POST['spin'])){
        
        $slot_[0] = 0;
        $slot_[1] = 0;
        $slot_[2] = 0;

        $rare_odd = 10;
        $medium_odd = 30;

        $bet = preg_replace('/\s+/', '', $_POST['bet']);
        
        if(is_numeric($bet)){
            if($bet > $money){
                echo '<div class="feedback mislykket">
                    <span>Du kan ikke spille for mer enn du har på hånden!</span> 
                </div>';
            } elseif($bet > $max_bet || $bet < $min_bet){
                echo '<div class="feedback mislykket">
                    <span>Du kan ikke spille for mer enn max bet eller mindre enn min bet!</span> 
                </div>';
            } else {

                for($i = 0; $i < 3; $i++){
                    $odds = mt_rand(0, 100);

                    if($odds < $rare_odd){
                        $chance = 1;
                    } elseif($odds < $medium_odd){
                        $chance = mt_rand(2, 3);
                    } else {
                        $chance = mt_rand(4, 9);
                    }

                    $slot_[$i] = $chance;
                }

                if($slot_[0] == 1 && $slot_[1] == 1 && $slot_[2] == 1){
                    // JACKPOT WIN
                    $bet_feedback =     ($jackpot * 0.9);
                    $string =           number_format($bet_feedback, 0, '', '');

                    $bet =              ($jackpot * 0.9);

                    $result = "UPDATE accounts SET money = (money + $jackpot) WHERE ID ='".mysqli_real_escape_string($con, $_SESSION['ID'])."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $result = "UPDATE jackpot SET jackpot = 0 WHERE ID ='1'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $result = "UPDATE stats SET gambling = (gambling + $bet) WHERE acc_id='".$ID."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                    VALUES ('$ID', 'Slot - vinn - ".number($bet)."', '$money', '$bank_money', '".time()."')";
                    $result = mysqli_query($con, $query);
                    
                    if($oppdrag == 29 && $city == 4){
                        $result = "UPDATE oppdrag SET value = (value + $jackpot) WHERE acc_id='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                    }

                    header("Location: index.php?side=slots&slot_0=".$slot_[0]."&slot_1=".$slot_[1]."&slot_2=".$slot_[2]."&jackpot_win=".$string."");
                } elseif(($slot_[0] == 2 && $slot_[1] == 2 && $slot_[2] == 2)){
                    // x15
                    $bet_feedback =     ($bet * 15) * 0.9;
                    $bet =              (($bet * 15) * 0.9) - $bet;

                    $result = "UPDATE accounts SET money = (money + $bet) WHERE ID ='".mysqli_real_escape_string($con, $_SESSION['ID'])."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $result = "UPDATE stats SET gambling = (gambling + $bet) WHERE acc_id='".$ID."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                    VALUES ('$ID', 'Slot - vinn - ".number($bet)."', '$money', '$bank_money', '".time()."')";
                    $result = mysqli_query($con, $query);
                    
                    if($oppdrag == 29 && $city == 4){
                        $result = "UPDATE oppdrag SET value = (value + $bet) WHERE acc_id='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                    }

                    header("Location: index.php?side=slots&slot_0=".$slot_[0]."&slot_1=".$slot_[1]."&slot_2=".$slot_[2]."&win=".$bet_feedback."");
                } elseif(($slot_[0] == 3 && $slot_[1] == 3 && $slot_[2] == 3)){
                    // x10
                    $bet_feedback =     ($bet * 10) * 0.9;
                    $bet =              (($bet * 10) * 0.9) - $bet;

                    $result = "UPDATE accounts SET money = (money + $bet) WHERE ID ='".mysqli_real_escape_string($con, $_SESSION['ID'])."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $result = "UPDATE stats SET gambling = (gambling + $bet) WHERE acc_id='".$ID."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                    VALUES ('$ID', 'Slot - vinn - ".number($bet)."', '$money', '$bank_money', '".time()."')";
                    $result = mysqli_query($con, $query);
                    
                    if($oppdrag == 29 && $city == 4){
                        $result = "UPDATE oppdrag SET value = (value + $bet) WHERE acc_id='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                    }

                    header("Location: index.php?side=slots&slot_0=".$slot_[0]."&slot_1=".$slot_[1]."&slot_2=".$slot_[2]."&win=".$bet_feedback."");
                } elseif(($slot_[0] == 4 && $slot_[1] == 4 && $slot_[2] == 4)
                         || 
                         ($slot_[0] == 5 && $slot_[1] == 5 && $slot_[2] == 5)
                         || 
                         ($slot_[0] == 6 && $slot_[1] == 6 && $slot_[2] == 6)
                         || 
                         ($slot_[0] == 7 && $slot_[1] == 7 && $slot_[2] == 7)
                         || 
                         ($slot_[0] == 8 && $slot_[1] == 8 && $slot_[2] == 8)
                         || 
                         ($slot_[0] == 9 && $slot_[1] == 9 && $slot_[2] == 9)){
                    // x5
                    $bet_feedback =     ($bet * 5) * 0.9;
                    $bet =              ((($bet * 5) * 0.9) - $bet);

                    $result = "UPDATE accounts SET money = (money + $bet) WHERE ID ='".mysqli_real_escape_string($con, $_SESSION['ID'])."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $result = "UPDATE stats SET gambling = (gambling + $bet) WHERE acc_id='".$ID."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                    VALUES ('$ID', 'Slot - vinn - ".number($bet)."', '$money', '$bank_money', '".time()."')";
                    $result = mysqli_query($con, $query);
                    
                    if($oppdrag == 29 && $city == 4){
                        $result = "UPDATE oppdrag SET value = (value + $bet) WHERE acc_id='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                    }

                    header("Location: index.php?side=slots&slot_0=".$slot_[0]."&slot_1=".$slot_[1]."&slot_2=".$slot_[2]."&win=".$bet_feedback."");
                } elseif(
                        $slot_[0] == 1 && (in_array($slot_[1], $all)) && (in_array($slot_[2], $all))
                        || 
                        (in_array($slot_[0], $all)) && $slot_[1] == 1 && (in_array($slot_[2], $all))
                        ||
                        (in_array($slot_[0], $all)) && (in_array($slot_[1], $all)) && $slot_[2] == 1
                        ){

                    // x2
                    $bet_feedback =     ($bet * 2) * 0.9;
                    $bet =              ((($bet * 2) * 0.9) - $bet);

                    $result = "UPDATE accounts SET money = (money + $bet) WHERE ID ='".mysqli_real_escape_string($con, $_SESSION['ID'])."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $result = "UPDATE stats SET gambling = (gambling + $bet) WHERE acc_id='".$ID."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                    VALUES ('$ID', 'Slot - vinn - ".number($bet)."', '$money', '$bank_money', '".time()."')";
                    $result = mysqli_query($con, $query);

                    if($oppdrag == 29 && $city == 4){
                        $result = "UPDATE oppdrag SET value = (value + $bet) WHERE acc_id='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                    }
                    
                    header("Location: index.php?side=slots&slot_0=".$slot_[0]."&slot_1=".$slot_[1]."&slot_2=".$slot_[2]."&win=".$bet_feedback."");
                } elseif(($slot_[0] == 1 && $slot_[1] == 1 && (in_array($slot_[2], $all)))
                        || 
                        ((in_array($slot_[0], $all)) && $slot_[1] == 1 && $slot_[2] == 1)
                        ||
                        ($slot_[0] == 1 && (in_array($slot_[1], $all)) && $slot_[2] == 1)){

                    // x3
                    $bet_feedback =     ($bet * 3) * 0.9;
                    $bet =              ((($bet * 3) * 0.9) - $bet);

                    $result = "UPDATE accounts SET money = (money + $bet) WHERE ID ='".mysqli_real_escape_string($con, $_SESSION['ID'])."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $result = "UPDATE stats SET gambling = (gambling + $bet) WHERE acc_id='".$ID."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                    VALUES ('$ID', 'Slot - vinn - ".number($bet)."', '$money', '$bank_money', '".time()."')";
                    $result = mysqli_query($con, $query);
                    
                    if($oppdrag == 29 && $city == 4){
                        $result = "UPDATE oppdrag SET value = (value + $bet) WHERE acc_id='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                    }

                    header("Location: index.php?side=slots&slot_0=".$slot_[0]."&slot_1=".$slot_[1]."&slot_2=".$slot_[2]."&win=".$bet_feedback."");
                } else {
                    $result = "UPDATE accounts SET money = (money - $bet) WHERE ID ='".mysqli_real_escape_string($con, $_SESSION['ID'])."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $result = "UPDATE jackpot SET jackpot = (jackpot + ($bet * 0.9))";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $result = "UPDATE stats SET gambling = (gambling - $bet) WHERE acc_id='".$ID."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                    VALUES ('$ID', 'Slot - tap - ".number($bet)."', '$money', '$bank_money', '".time()."')";
                    $result = mysqli_query($con, $query);
                    
                    if($oppdrag == 29 && $city == 4){
                        $result = "UPDATE oppdrag SET value = (value - $bet) WHERE acc_id='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                    }

                    header("Location: index.php?side=slots&slot_0=".$slot_[0]."&slot_1=".$slot_[1]."&slot_2=".$slot_[2]."&loose=".$bet."");
                }
            }
        } else {
            echo '<div class="feedback feilmelding">
                <span>Du har en bokstav i inputen.</span> 
            </div>';
        }
    }
    
    if(isset($_GET['jackpot_win'])){
        echo '<div class="feedback velykket" style="background-color: green; border: 1px solid lightgreen;">
            <span><center>! JACKPOT !</br> Du vant '.number($_GET['jackpot_win']).' kr!<center></span> 
        </div>';
    } elseif(isset($_GET['win'])){
        echo '<div class="feedback velykket">
            <span>Gratulerer, du vant '.number($_GET['win']).' kr!</span> 
        </div>';
    } elseif(isset($_GET['loose'])){
        echo '<div class="feedback mislykket">
            <span>Du tapte '.number($_GET['loose']).' kr!</span> 
        </div>';
    }
    
?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Gambling » </span><span style="color: #afafaf;">Enarmet banditt</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <form method="post">
                <?php if($oppdrag == 29 && $city == 4){ ?>
                    <div class="feedback velykket"><span>Du har i oppdrag å vinne 100 000 000 på gambling.<br>Du har: <?php echo number($value) ?> / 100 000 000</span></div>     
                <?php } ?>
                <img src="img/action/slots.png">
                    <br><br>
                    <center><div style="width: 40% !important; padding: 6px; border-radius: 5px; background-color: #151515; width: auto;">Jackpot: <?php echo number($jackpot); ?> kr</div><br>
                Min-bet: <?php echo number($min_bet); ?> | Max-bet: <?php echo number($max_bet); ?></center>
                <div style="width: 100%; height: 150px;">

                <div class="pad_10" style="margin: 0 auto; width: 378px;">
                    <div style="padding: 10px; width: 100px; border: 1px solid #2c2c2c; background-color: #1a1a1a; margin: 2px; float: left; height: 100px;">
                        <?php if(isset($_GET['slot_0'])){ ?>
                            <img src="img/slot_machine/<?php echo $_GET['slot_0']; ?>.png">
                        <?php } else { ?>
                            <img src="img/slot_machine/<?php echo mt_rand(1, 9); ?>.png">
                        <?php } ?>
                    </div>
                    <div style="padding: 10px; width: 100px; border: 1px solid #2c2c2c; background-color: #1a1a1a; margin: 2px; float: left; height: 100px;">
                        <?php if(isset($_GET['slot_1'])){ ?>
                            <img src="img/slot_machine/<?php echo $_GET['slot_1']; ?>.png">
                        <?php } else { ?>
                            <img src="img/slot_machine/<?php echo mt_rand(1, 9); ?>.png">
                        <?php } ?>
                    </div>
                    <div style="padding: 10px; width: 100px; border: 1px solid #2c2c2c; background-color: #1a1a1a; margin: 2px; float: left; height: 100px;">
                        <?php if(isset($_GET['slot_2'])){ ?>
                            <img src="img/slot_machine/<?php echo $_GET['slot_2']; ?>.png">
                        <?php } else { ?>
                            <img src="img/slot_machine/<?php echo mt_rand(1, 9); ?>.png">
                        <?php } ?>
                    </div>
                </div>
                </div>
                <center>
                <p style="margin: 0;">Hvor mye vil du satse?</p>
                <input type="text" name="bet" id="number" placeholder="Innsats.." style="width: auto;">
                <input type="submit" name="spin" style="margin: 0; margin-top: 10px; width: auto;" value="spill!">
                </center>
            </form>
            <br>
        <div class="header" style="border-top: 1px solid #2c2c2c">
            <span>Utbetalinger</span>
        </div>
        <div class="pad_10" style="padding-bottom: 0;">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 30px;">
                    <th style="width: 60%; padding-left: 15px;">Kombinasjon</th>
                    <th style="width: 40%;">Utbetaling</th>
                </tr>
                <tr style="height: 55px;">
                    <td style="padding-left: 15px;"><img style="width: 35px; height: auto; margin-right: 10px;" src="img/slot_machine/1.png"><img style="width: 35px; height: auto; margin-right: 10px;" src="img/slot_machine/1.png"><img style="width: 35px; height: auto;" src="img/slot_machine/1.png"></td>
                    <td>Jackpot</td>
                </tr>
                <tr style="height: 55px;">
                    <td style="padding-left: 15px;"><img style="width: 35px; height: auto;margin-right: 10px;" src="img/slot_machine/2.png"><img style="width: 35px; height: auto;margin-right: 10px;" src="img/slot_machine/2.png"><img style="width: 35px; height: auto;" src="img/slot_machine/2.png"></td>
                    <td>x15</td>
                </tr>
                <tr style="height: 55px;">
                    <td style="padding-left: 15px;"><img style="width: 35px; height: auto;margin-right: 10px;" src="img/slot_machine/3.png"><img style="width: 35px; height: auto;margin-right: 10px;" src="img/slot_machine/3.png"><img style="width: 35px; height: auto;" src="img/slot_machine/3.png"></td>
                    <td>x10</td>
                </tr>
                <?php for($i = 4; $i < 10; $i++){ ?>
                <tr style="height: 55px;">
                    <td style="padding-left: 15px;"><img style="width: 35px; height: auto;margin-right: 10px;" src="img/slot_machine/<?php echo $i; ?>.png"><img style="width: 35px; height: auto;margin-right: 10px;" src="img/slot_machine/<?php echo $i; ?>.png"><img style="width: 35px; height: auto;" src="img/slot_machine/<?php echo $i; ?>.png"></td>
                    <td>x5</td>
                </tr>
                <?php } ?>
                <tr style="height: 55px;">
                    <td style="padding-left: 15px;"><img style="width: 35px; height: auto;margin-right: 10px;" src="img/slot_machine/1.png"><img style="width: 35px; height: auto;margin-right: 10px;" src="img/slot_machine/1.png"><img style="width: 35px; height: auto;margin-right: 10px;" src="img/slot_machine/all.png"></td>
                    <td>x3</td>
                </tr>
                <tr style="height: 55px;">
                    <td style="padding-left: 15px;"><img style="width: 35px; height: auto;margin-right: 10px;" src="img/slot_machine/1.png"><img style="width: 35px; height: auto;margin-right: 10px;" src="img/slot_machine/all.png"><img style="width: 35px; height: auto;margin-right: 10px;" src="img/slot_machine/all.png"></td>
                    <td>x2</td>
                </tr>
            </table>
        </div>
        </div>
    </body>
</html>
<?php 

}

?>

<script>

$('#number').on("keyup", function() {
    this.value = this.value.replace(/ /g,'');
    var number = this.value;
    this.value = number.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
});

</script>