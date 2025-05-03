
<?php 

if(!isset($_GET['side'])){
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else {

    $red =      array(1, 3, 5, 7, 9, 12, 14, 16, 18, 19, 21, 23, 25, 27, 30, 32, 34, 36);
    $black =    array(2, 4, 6, 8, 10, 11, 13, 15, 17, 20, 22, 24, 26, 28, 29, 31, 33, 35);
    $even =     array(2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30, 32, 34, 36);
    $odd =      array(1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23, 25, 27, 29, 31, 33, 35);

    $min_bet = 100000;
    $max_bet = 25000000;

    if(isset($_POST['spill'])){
        $bet_number = preg_replace('/\s+/', '', $_POST['bet_number']);

        $total =    rand(0, 36);
        $green =    0;

        if(is_numeric($bet_number)){
            if(!isset($_POST['radio_roulette'])){
                echo '<div class="feedback mislykket">
                    <span>Du må velge et tall, partall, oddetall eller farge!</span> 
                </div>';
            } elseif($bet_number > $money) {
                echo '<div class="feedback mislykket">
                    <span>Du kan ikke satse mer enn du har på hånden</span> 
                </div>';
            } elseif($bet_number < $min_bet) {
                echo '<div class="feedback mislykket">
                    <span>Du må satse minst '.number($min_bet).' kr</span> 
                </div>';
            } elseif($bet_number > $max_bet) {
                echo '<div class="feedback mislykket">
                    <span>Du kan ikke satse mer enn maxbet som er '.number($max_bet).' kr</span> 
                </div>';
            } else {
                if($_POST['radio_roulette'] == "black"){
                    if((in_array($total, $black))){
                        // Hvis man velger sort men tallet blir sort
                        // Vinn (innsats * 2) * 0.9
                        $win = (($bet_number * 2) * 0.9) - $bet_number;

                        $result = "UPDATE accounts SET money = (money + $win) WHERE ID='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        $result = "UPDATE stats SET gambling = (gambling + $win) WHERE acc_id='".$ID."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        if($oppdrag == 29 && $city == 4){
                            $result = "UPDATE oppdrag SET value = (value + $win) WHERE acc_id='".$_SESSION['ID']."'";
                            mysqli_query($con, $result) or die("Bad query: $result");
                        }

                        $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                        VALUES ('$ID', 'Roulette - vinn - ".number($win)."', '$money', '$bank_money', '".time()."')";
                        $result = mysqli_query($con, $query);

                        header("Location: index.php?side=roulette&status=1&cashout=".$bet_number."&number=".$total."");
                    } elseif((in_array($total, $red))) {
                        // Hvis man velger sort men tallet blir rødt
                        // Tap innsats
                        $result = "UPDATE stats SET gambling = (gambling - $bet_number) WHERE acc_id='".$ID."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        $result = "UPDATE accounts SET money = (money - $bet_number) WHERE ID='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        if($oppdrag == 29 && $city == 4){
                            $result = "UPDATE oppdrag SET value = (value - $bet_number) WHERE acc_id='".$_SESSION['ID']."'";
                            mysqli_query($con, $result) or die("Bad query: $result");
                        }

                        $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                        VALUES ('$ID', 'Roulette - tap - ".number($bet_number)."', '$money', '$bank_money', '".time()."')";
                        $result = mysqli_query($con, $query);

                        header("Location: index.php?side=roulette&status=2&number=".$total."");
                    }
                } elseif($_POST['radio_roulette'] == "red"){
                    if((in_array($total, $black))){
                        // Hvis man velger rød men tallet blir sort
                        // Tap innsats
                        $result = "UPDATE stats SET gambling = (gambling - $bet_number) WHERE acc_id='".$ID."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        $result = "UPDATE accounts SET money = (money - $bet_number) WHERE ID='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        if($oppdrag == 29 && $city == 4){
                            $result = "UPDATE oppdrag SET value = (value - $bet_number) WHERE acc_id='".$_SESSION['ID']."'";
                            mysqli_query($con, $result) or die("Bad query: $result");
                        }

                        $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                        VALUES ('$ID', 'Roulette - tap - ".number($bet_number)."', '$money', '$bank_money', '".time()."')";
                        $result = mysqli_query($con, $query);

                        header("Location: index.php?side=roulette&status=3&number=".$total."");
                    } elseif((in_array($total, $red))) {
                        // Hvis man velger rød men tallet blir rød
                        // Vinn (innsats * 2) * 0.9
                        $win = (($bet_number * 2) * 0.9) - $bet_number;

                        $result = "UPDATE stats SET gambling = (gambling + $win) WHERE acc_id='".$ID."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        $result = "UPDATE accounts SET money = (money + $win) WHERE ID='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        if($oppdrag == 29 && $city == 4){
                            $result = "UPDATE oppdrag SET value = (value + $win) WHERE acc_id='".$_SESSION['ID']."'";
                            mysqli_query($con, $result) or die("Bad query: $result");
                        }


                        $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                        VALUES ('$ID', 'Roulette - vinn - ".number($win)."', '$money', '$bank_money', '".time()."')";
                        $result = mysqli_query($con, $query);

                        header("Location: index.php?side=roulette&status=4&cashout=".$bet_number."&number=".$total."");
                    }
                }  elseif($_POST['radio_roulette'] == 'even'){
                    if((in_array($total, $even))){
                        // Hvis man velger partall men tallet blir partall
                        // Vinn (innsats * 2) * 0.9
                        $win = (($bet_number * 2) * 0.9) - $bet_number;

                        $result = "UPDATE stats SET gambling = (gambling + $win) WHERE acc_id='".$ID."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        $result = "UPDATE accounts SET money = (money + $win) WHERE ID='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        if($oppdrag == 29 && $city == 4){
                            $result = "UPDATE oppdrag SET value = (value + $win) WHERE acc_id='".$_SESSION['ID']."'";
                            mysqli_query($con, $result) or die("Bad query: $result");
                        }


                        $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                        VALUES ('$ID', 'Roulette - vinn - ".number($win)."', '$money', '$bank_money', '".time()."')";
                        $result = mysqli_query($con, $query);

                        header("Location: index.php?side=roulette&status=5&cashout=".$bet_number."&number=".$total."");
                    } elseif((in_array($total, $odd))) {
                        // Hvis man velger partall men tallet blir oddetall
                        // Tap innsats
                        $result = "UPDATE stats SET gambling = (gambling - $bet_number) WHERE acc_id='".$ID."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        $result = "UPDATE accounts SET money = (money - $bet_number) WHERE ID='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        if($oppdrag == 29 && $city == 4){
                            $result = "UPDATE oppdrag SET value = (value - $bet_number) WHERE acc_id='".$_SESSION['ID']."'";
                            mysqli_query($con, $result) or die("Bad query: $result");
                        }

                        $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                        VALUES ('$ID', 'Roulette - tap - ".number($bet_number)."', '$money', '$bank_money', '".time()."')";
                        $result = mysqli_query($con, $query);

                        header("Location: index.php?side=roulette&status=6&number=".$total."");
                    }
                }  elseif($_POST['radio_roulette'] == 'odd'){
                    if((in_array($total, $odd))){
                        // Hvis man velger oddetall men tallet blir oddetall
                        // Vinn innsats * 2
                        $win = (($bet_number * 2) * 0.9) - $bet_number;

                        $result = "UPDATE stats SET gambling = (gambling + $win) WHERE acc_id='".$ID."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        $result = "UPDATE accounts SET money = (money + $win) WHERE ID='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        if($oppdrag == 29 && $city == 4){
                            $result = "UPDATE oppdrag SET value = (value + $win) WHERE acc_id='".$_SESSION['ID']."'";
                            mysqli_query($con, $result) or die("Bad query: $result");
                        }


                        $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                        VALUES ('$ID', 'Roulette - vinn - ".number($win)."', '$money', '$bank_money', '".time()."')";
                        $result = mysqli_query($con, $query);

                        header("Location: index.php?side=roulette&status=7&cashout=".$bet_number."&number=".$total."");
                    } elseif((in_array($total, $even))) {
                        // Hvis man velger oddetall men tallet blir partall
                        // Tap innsats
                        $result = "UPDATE stats SET gambling = (gambling - $bet_number) WHERE acc_id='".$ID."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        $result = "UPDATE accounts SET money = (money - $bet_number) WHERE ID='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        if($oppdrag == 29 && $city == 4){
                            $result = "UPDATE oppdrag SET value = (value - $bet_number) WHERE acc_id='".$_SESSION['ID']."'";
                            mysqli_query($con, $result) or die("Bad query: $result");
                        }

                        $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                        VALUES ('$ID', 'Roulette - tap - ".number($bet_number)."', '$money', '$bank_money', '".time()."')";
                        $result = mysqli_query($con, $query);

                        header("Location: index.php?side=roulette&status=8&number=".$total."");
                    }
                } elseif($_POST['radio_roulette'] == $green && $total == $green){
                    // Grønn valgt og grønn fått
                    // vinn (innsats * 37) * 0.9
                    $win = (($bet_number * 37) * 0.9) - $bet_number;

                    $result = "UPDATE stats SET gambling = (gambling + $win) WHERE acc_id='".$ID."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $result = "UPDATE accounts SET money = (money + $win) WHERE ID='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    if($oppdrag == 29 && $city == 4){
                        $result = "UPDATE oppdrag SET value = (value + $win) WHERE acc_id='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                    }


                    $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                    VALUES ('$ID', 'Roulette - vinn - ".number($win)."', '$money', '$bank_money', '".time()."')";
                    $result = mysqli_query($con, $query);

                    header("Location: index.php?side=roulette&status=9&cashout=".$bet_number."");
                } elseif($_POST['radio_roulette'] == $green && $total != $green){
                    // Grønn valgt og grønn fått
                    // tap innsats
                    $result = "UPDATE stats SET gambling = (gambling - $bet_number) WHERE acc_id='".$ID."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $result = "UPDATE accounts SET money = (money - $bet_number) WHERE ID='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                        if($oppdrag == 29 && $city == 4){
                            $result = "UPDATE oppdrag SET value = (value - $bet_number) WHERE acc_id='".$_SESSION['ID']."'";
                            mysqli_query($con, $result) or die("Bad query: $result");
                        }

                    $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                    VALUES ('$ID', 'Roulette - tap - ".number($bet_number)."', '$money', '$bank_money', '".time()."')";
                    $result = mysqli_query($con, $query);

                    header("Location: index.php?side=roulette&status=10&number=".$total."");
                } elseif($_POST['radio_roulette'] != $total){
                    // Ikke riktig valgt spesifikk tall
                    $result = "UPDATE stats SET gambling = (gambling - $bet_number) WHERE acc_id='".$ID."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $result = "UPDATE accounts SET money = (money - $bet_number) WHERE ID='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    if($oppdrag == 29 && $city == 4){
                        $result = "UPDATE oppdrag SET value = (value - $bet_number) WHERE acc_id='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                    }

                    $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                    VALUES ('$ID', 'Roulette - tap - ".number($bet_number)."', '$money', '$bank_money', '".time()."')";
                    $result = mysqli_query($con, $query);

                    header("Location: index.php?side=roulette&status=11&mynumber=".$_POST['radio_roulette']."&number=".$total."");
                } elseif($_POST['radio_roulette'] == $total){
                    // Valgt riktig spesifikk tall
                    // vinner (innsats * 37) * 0.9
                    $win = (($bet_number * 37) * 0.9) - $bet_number;

                    $result = "UPDATE stats SET gambling = (gambling + $win) WHERE acc_id='".$ID."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $result = "UPDATE accounts SET money = (money + $win) WHERE ID='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    if($oppdrag == 29 && $city == 4){
                        $result = "UPDATE oppdrag SET value = (value + $win) WHERE acc_id='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                    }

                    $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                    VALUES ('$ID', 'Roulette - vinn - ".number($win)."', '$money', '$bank_money', '".time()."')";
                    $result = mysqli_query($con, $query);

                    header("Location: index.php?side=roulette&status=12&mynumber=".$_POST['radio_roulette']."&number=".$total."&cashout=".$bet_number."");
                }
            }
        } else {
            echo '<div class="feedback feilmelding">
                <span>Du har en bokstav i tallet.</span> 
            </div>';
        }
    }

?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Gambling » </span><span style="color: #afafaf;">Roulette</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <?php
    
    if(isset($_GET['status'])){
        if($_GET['status'] == 1){
            $win = ($_GET['cashout'] * 2) * 0.9;
            echo '<div class="feedback velykket">
                <span>Du valgte sort og kulen landet på sort '.$_GET['number'].', du vinner '.number($win).' kr</span> 
            </div>';
        } elseif($_GET['status'] == 2){
            echo '<div class="feedback mislykket">
                <span>Du valgte sort, men kulen landet på rød '.$_GET['number'].' og du taper.</span> 
            </div>';
        } elseif($_GET['status'] == 3){
            echo '<div class="feedback mislykket">
                <span>Du valgte rød, men kulen landet på sort '.$_GET['number'].' og du taper.</span> 
            </div>';
        } elseif($_GET['status'] == 4){
            $win = ($_GET['cashout'] * 2) * 0.9;
            echo '<div class="feedback velykket">
                <span>Du valgte rød og kulen landet på rød '.$_GET['number'].', du vinner '.number($win).' kr</span> 
            </div>';
        } elseif($_GET['status'] == 5){
            $win = ($_GET['cashout'] * 2) * 0.9;
            echo '<div class="feedback velykket">
                <span>Du valgte partall og kulen landet på '.$_GET['number'].'! Du vinner '.number($win).' kr</span> 
            </div>';
        } elseif($_GET['status'] == 6){
            echo '<div class="feedback mislykket">
                <span>Du valgte partall, men kulen landet på '.$_GET['number'].' og du taper.</span> 
            </div>';
        } elseif($_GET['status'] == 7){
            $win = ($_GET['cashout'] * 2) * 0.9;
            echo '<div class="feedback velykket">
                <span>Du valgte oddetall og kulen landet på '.$_GET['number'].'! Du vinner '.number($win).' kr</span> 
            </div>';
        } elseif($_GET['status'] == 8){
            echo '<div class="feedback mislykket">
                <span>Du valgte oddetall, men kulen landet på '.$_GET['number'].' og du taper.</span> 
            </div>';
        } elseif($_GET['status'] == 9){
            $win = ($_GET['cashout'] * 37) * 0.9;
            echo '<div class="feedback velykket">
                <span>Du valgte tallet 0 og kulen landet på 0! Du vinner '.number($win).' kr</span> 
            </div>';
        } elseif($_GET['status'] == 10){
            echo '<div class="feedback mislykket">
                <span>Du valgte tallet 0, men kulen landet på '.$_GET['number'].', du taper.</span> 
            </div>';
        } elseif($_GET['status'] == 11){
            echo '<div class="feedback mislykket">
                <span>Du valgte tallet '.$_GET['mynumber'].', men kulen landet på '.$_GET['number'].', du taper.</span> 
            </div>';
        } elseif($_GET['status'] == 12){
            $win = ($_GET['cashout'] * 37) * 0.9;
            echo '<div class="feedback velykket">
                <span>Du valgte tallet '.$_GET['mynumber'].', og kulen landet på '.$_GET['number'].', du vinner '.number($win).' kr.</span> 
            </div>';
        }
    }
    
    ?>
        <div class="content">
                <?php if($oppdrag == 29 && $city == 4){ ?>
                    <div class="feedback velykket"><span>Du har i oppdrag å vinne 100 000 000 på gambling.<br>Du har: <?php echo number($value) ?> / 100 000 000</span></div>     
                <?php } ?>
            <img src="img/action/roulette.png">
            <p style="text-align: center;"><?php echo 'Staten'; ?> tar 10% av vinnersummen<br>
            min-bet: <?php echo number($min_bet); ?> kr | max-bet: <?php echo number($max_bet); ?> kr</p>
            <div class="pad_10">
                <center>
                    <form method="post">
                        <center>

                        </center>
                        
                        <?php for($i = 1; $i < 37; $i++){ ?>
                        <input id="radio_<?php echo $i ?>" class="radio isHidden" value="<?php echo $i ?>" name="radio_roulette" type="radio">
                        <label for="radio_<?php echo $i ?>" <?php if(in_array($i, $red)){ ?> style="background-color: #b91314;" <?php } else { ?>style="background-color: #101010;" <?php } ?> class="label"><?php echo $i ?></label>
                        <?php } ?>
                        <input id="radio_even" class="radio isHidden" value="even" name="radio_roulette" type="radio">
                        <label for="radio_even" style="width: 13%; background-color: #2b2b2b;" class="label">Partall</label>
                        
                        <input id="radio_odd" class="radio isHidden" value="odd" name="radio_roulette" type="radio">
                        <label for="radio_odd" style="width: 13%; background-color: #2b2b2b;" class="label">Oddetall</label>
                        
                        <input id="radio_0" class="radio isHidden" value="0" name="radio_roulette" type="radio">
                        <label for="radio_0" style="width: 14.7%; background-color: #024f27;" class="label">0</label>
                        
                        <input id="radio_red" class="radio isHidden" value="red" name="radio_roulette" type="radio">
                        <label for="radio_red" style="width: 13%; background-color: #b91314;" class="label">Rød</label>
                        
                        <input id="radio_black" class="radio isHidden" value="black" name="radio_roulette" type="radio">
                        <label for="radio_black" style="width: 13%; background-color: #101010;" class="label">Sort</label>
                        <br><br>
                        Innsats: <input type="text" id="number" name="bet_number" placeholder="Antall" style="width: 125px;"><input type="submit" style="width: auto;" name="spill" value="Spill">
                    </form>
                </center>
            </div>
            <br>
            <div class="header" style="border-top: 1px solid #2c2c2c">
                <span>Regler</span>
            </div>
            <div class="pad_10" style="padding-bottom: 0;">
                Rulett er et sjansespill. En croupier snurrer et ruletthjul som har 37 nummererte lommer der en kule kan lande. Lommene er nummerert fra 1 til 36 og veksler mellom rød og sort, der nummer 1 er rød. I tillegg er det en grønn lomme med nummer 0.<br><br>
            <table border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 30px;">
                    <th style="width: 30%; padding-left: 15px;">Navn på veddemåte</th>
                    <th style="width: 35%;">Vinnende rom</th>
                    <th style="width: 20%;">Utbetaling</th>
                    <th style="width: 15%;">Odds</th>
                </tr>
                <tr style="height: 25px;">
                    <td style="padding-left: 15px;">0</td>
                    <td>0</td>
                    <td>35 til 1</td>
                    <td>37 til 1</td>
                </tr>
                <tr style="height: 25px;">
                    <td style="padding-left: 15px;">Gitt tall</td>
                    <td>Selvvalgt nummer</td>
                    <td>35 til 1</td>
                    <td>37 til 1</td>
                </tr>
                <tr style="height: 25px;">
                    <td style="padding-left: 15px;">Oddetall</td>
                    <td>1, 3, 5, ..., 35</td>
                    <td>1 til 1</td>
                    <td>1,111 til 1</td>
                </tr>
                <tr style="height: 25px;">
                    <td style="padding-left: 15px;">Partall</td>
                    <td>2, 4, 6, ..., 36</td>
                    <td>1 til 1</td>
                    <td>1,111 til 1</td>
                </tr>
                <tr style="height: 55px;">
                    <td style="padding-left: 15px;">Rød</td>
                    <td><?php 
    
                        foreach($red as $value){
                            echo $value . ", ";
                        }
    
                        ?></td>
                    <td>1 til 1</td>
                    <td>1,111 til 1</td>
                </tr>
                <tr style="height: 55px;">
                    <td style="padding-left: 15px;">Sort</td>
                    <td><?php 
    
                        foreach($black as $value){
                            echo $value . ", ";
                        }
    
                        ?></td>
                    <td>1 til 1</td>
                    <td>1,111 til 1</td>
                </tr>
            </table>
                NB! 0 er verken partall eller oddetall i dette spillet.

            </div>
        </div>

    </body>
</html>
<?php 

}

?>

<style>

.isHidden {
  display: none; /* hide radio buttons */
}

.label {
    color: #7b7b7b;
    display: inline-block;
    margin-top: 5px;
    width: 10px;
    height: 10px;
    padding: 10px 13px 15px 13px;
    transition: .2s;
}

.label:hover {
    cursor: pointer;
}
    
.radio:checked + .label {   /* target next sibling (+) label */
    outline: 1px solid white;
    color: white;
}

</style>

<script>

$('#number').on("keyup", function() {
    this.value = this.value.replace(/ /g,'');
    var number = this.value;
    this.value = number.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
});

</script>