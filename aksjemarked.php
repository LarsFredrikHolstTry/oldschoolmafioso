<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else { 

$stock_name[0] = "Mafioso Eiendom C";
$stock_name[1] = "Den Sveitsiske bank";
$stock_name[2] = "Det Norske Dampskibselskap";
$stock_name[3] = "Sansung";
$stock_name[4] = "Eple";
$stock_name[5] = "Potet Solutions Inc.";
$stock_name[6] = "Fart & Bart AS";

if($happy_hour == 1){
    $kurtasje = 0;
} else {
    $kurtasje = 100000;
}

$max_stocks = 1000000;
    
$sql = "SELECT * FROM my_stocks WHERE acc_id='".$ID."'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row_my_stocks = mysqli_fetch_assoc($query);

$my_stock[0] =      $row_my_stocks['stock_0'];
$my_stock[1] =      $row_my_stocks['stock_1'];
$my_stock[2] =      $row_my_stocks['stock_2'];
$my_stock[3] =      $row_my_stocks['stock_3'];
$my_stock[4] =      $row_my_stocks['stock_4'];
$my_stock[5] =      $row_my_stocks['stock_5'];
$my_stock[6] =      $row_my_stocks['stock_6'];

$money_used =       $row_my_stocks['money_used'];
$money_earned =     $row_my_stocks['money_earned'];
    

// oppdater prisene på aksjene
if(isset($_POST['new_price'])){
    for($j = 0; $j < count($stock_name); $j++){
        $sql = "SELECT * FROM stocks WHERE stock_id = '".$j."' ORDER BY date DESC";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row_stock = mysqli_fetch_assoc($query);

        $stock_price[$j] = $row_stock['price'];
        $random = mt_rand(-25, 25);

        $max_price = 170;

        if($stock_price[$j] + $random > $max_price){
            $new_price = $stock_price[$j] - mt_rand(10, 20);
        } elseif($stock_price[$j] + $random < 0) {
            $result_konk = mysqli_query($con, "SELECT * FROM my_stocks WHERE stock_$j != 0");
            while($row_konk = mysqli_fetch_assoc($result_konk)) {
                $query = "INSERT into `varsel` (acc_id, text, date)
                VALUES ('".$row_konk['acc_id']."', '".$stock_name[$j]." har gått konkurs, og siden du hadde beholdning i dette selskapet har du mistet dine aksjer.', '".time()."')";
                $result = mysqli_query($con, $query);
                
                $result = "UPDATE my_stocks SET stock_$j = 0 WHERE acc_id='".$row_konk['acc_id']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
            
            $new_price = mt_rand(15, 25);
        }  else {
            $new_price = $stock_price[$j] + $random;
        }
        
        $query = "INSERT into `stocks` (stock_id, price, date)
        VALUES ('".$j."', '".$new_price."', '".time()."')";
        $result = mysqli_query($con, $query);
    }
    header("Location: index.php?side=aksjemarked&home");
}

// finne prisen for de forskjellige aksjene
for($i = 0; $i < count($stock_name); $i++){
    $sql = "SELECT * FROM stocks WHERE stock_id = '".$i."' ORDER BY date DESC";
    $query = mysqli_query($con, $sql) or die (mysqli_error());
    $row_stock = mysqli_fetch_assoc($query);
    
    $stock_price[$i] = $row_stock['price'];
}

// finne prisdifferansen
for($k = 0; $k < count($stock_name); $k++){
    $sql = "SELECT * FROM stocks WHERE stock_id = '".$k."' AND date = ( SELECT MAX(date) FROM stocks WHERE date < ( SELECT MAX(date) FROM stocks ))";
    $query = mysqli_query($con, $sql) or die (mysqli_error());
    $row_old = mysqli_fetch_assoc($query);
    
    $old_price[$k] = $row_old['price'];
    
    $sql = "SELECT * FROM stocks WHERE stock_id = '".$k."' ORDER BY date DESC";
    $query = mysqli_query($con, $sql) or die (mysqli_error());
    $row_new = mysqli_fetch_assoc($query);
    
    $new_price[$k] = $row_new['price'];
    
    if($old_price[$k] > $new_price[$k]){
        $price_differance[$k] = "lower";
    } else {
        $price_differance[$k] = "higher";
    }
}

    # Fjerning av aksjeverdi eldre enn 5 dager:
    # $del = mysqli_query($con, "DELETE FROM stocks WHERE date < $time - 86400") or die(mysqli_error()); 

    
    /*
    $price = 100;
    $random = mt_rand(-7, 7);
    
    $max_price = 150;
    
    if($price + $random > $max_price){
        $new_price = $price - mt_rand(10, 20);
    } elseif($price + $random < 0) {
        $new_price = mt_rand(15, 25);
    } else {
        $new_price = $price + $random;
    }

    $random = mt_rand(-100, 100);
    echo 50 + $random;
    */

    if(isset($_POST['sell'])){
        $too_much = false;
        $total_price = 0;
        $total_stocks = 0;
        
        for($i = 0; $i < count($stock_name); $i++){
            $sql = "SELECT * FROM stocks WHERE stock_id = '".$i."' ORDER BY date DESC";
            $query = mysqli_query($con, $sql) or die (mysqli_error());
            $row_stock = mysqli_fetch_assoc($query);

            $stock_price[$i] = $row_stock['price'];
            
            $_POST[$i] = preg_replace('/\s+/', '', $_POST[$i]);
            
            if($_POST[$i] == null){
                $stock_sell_amount[$i] = 0;
            } elseif($_POST[$i] > $my_stock[$i]){
                $too_much = true;
            } elseif(!is_numeric($_POST[$i])){
                $stock_sell_amount[$i] = 0;
            } elseif($_POST[$i] < 0){
                $minus = true;
            } else {
                $stock_sell_amount[$i] = $_POST[$i];
                $total_stocks = $total_stocks + $stock_sell_amount[$i];
                $total_price = $total_price + ($stock_sell_amount[$i] * $stock_price[$i]);
                
                $result = "UPDATE my_stocks SET stock_$i = (stock_$i - $_POST[$i]) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
        }
        
        if($too_much == true){
            header("Location: index.php?side=aksjemarked&home&feedback=4");
        } elseif($minus == true){
            header("Location: index.php?side=aksjemarked&home&feedback=0");
        } else {
            $result = "UPDATE accounts SET money = ($money + $total_price) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $result = "UPDATE my_stocks SET money_earned = (money_earned + $total_price) WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            for($i = 0; $i < count($stock_name); $i++){
                if($stock_sell_amount[$i] > 0){
                    $query = "INSERT into `stocks_logg` (acc_id, stock_id, date, action, amount, price)
                    VALUES ('".$ID."', '".$i."', '".time()."', '1', '$stock_sell_amount[$i]', '$stock_price[$i]')";
                    $result = mysqli_query($con, $query);
                }
            }
            
            header("Location: index.php?side=aksjemarked&home&feedback=5&sell=".$total_stocks."");
        }
        
        
        
        // sjekk om spilleren har antall aksjer han ønsker å selge
        // Sjekk pris pr aksje
        // gi spiller penger (aksjetype + antall) * pris
        // fjern aksjer fra spilleren
    }

if(isset($_POST['buy'])){
    $bokstav = false;
    $too_much_stocks = false;
    $minus = false;
    $konk = false;
    $total_price = 0;
    $total_stocks = 0;

    for($i = 0; $i < count($stock_name); $i++){
        $sql = "SELECT * FROM stocks WHERE stock_id = '".$i."' ORDER BY date DESC";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row_stock = mysqli_fetch_assoc($query);

        $stock_price[$i] = $row_stock['price'];
        
        $_POST[$i] = preg_replace('/\s+/', '', $_POST[$i]);
        
        if(($_POST[$i] + $my_stock[$i]) > $max_stocks){
            $too_much_stocks = true;
        } elseif($_POST[$i] == null || $_POST[$i] == 0){
            $stock_buy_amount[$i] = 0;
        } elseif($_POST[$i] < 0){
            $minus = true;
        } elseif(!is_numeric($_POST[$i])){
            $stock_buy_amount[$i] = 0;
        } elseif($stock_price[$i] <= 0){
            $konk = true;
        } else {
            $stock_buy_amount[$i] = $_POST[$i];
            $total_stocks = $total_stocks + $stock_buy_amount[$i];
            $total_price = $total_price + ($stock_buy_amount[$i] * $stock_price[$i]);
        }
    }

    $total_price = $total_price + $kurtasje;
    
    if($too_much_stocks == true){
        header("Location: index.php?side=aksjemarked&home&feedback=7");
    } elseif($minus == true){
        header("Location: index.php?side=aksjemarked&home&feedback=0");
    } elseif($konk == true){
        header("Location: index.php?side=aksjemarked&home&feedback=6");
    } elseif($total_stocks == 0) {
        header("Location: index.php?side=aksjemarked&home&feedback=3");
    } else {
        if($total_price > $money){
            header("Location: index.php?side=aksjemarked&home&feedback=1");

        } else {

            $result = "UPDATE accounts SET money = ($money - $total_price) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");

            for($i = 0; $i < count($stock_name); $i++){
                $result = "UPDATE my_stocks SET stock_$i = (stock_$i + $stock_buy_amount[$i]) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
            
            for($i = 0; $i < count($stock_name); $i++){
                if($stock_buy_amount[$i] > 0){
                    $query = "INSERT into `stocks_logg` (acc_id, stock_id, date, action, amount, price)
                    VALUES ('$ID', '$i', '".time()."', '0', '$stock_buy_amount[$i]', '$stock_price[$i]')";
                    $result = mysqli_query($con, $query);
                }
            }
            $result = "UPDATE my_stocks SET money_used = (money_used + $total_price) WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");

            header("Location: index.php?side=aksjemarked&home&feedback=2&buy=".$total_stocks."");
        }
    }

}

?>
<!-- CONTENT -->
<html>
<head>
</head>
<body>

    <div class="breadcrumb">
        <span style="color: #3e3e3e;">Diverse » </span><span style="color: #afafaf;">Aksjemarked</span>
        <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
    </div>

    <?php
    
    
    if(isset($_GET['feedback'])){
        if($_GET['feedback'] == 0){
            echo '<div class="feedback feilmelding">
                <span>Ugyldig input (minus tall).</span> 
            </div>';
        } elseif($_GET['feedback'] == 1){
            echo '<div class="feedback mislykket">
                <span>Du har ikke nok penger til å kjøpe de valgte aksjene.</span> 
            </div>';
        } elseif($_GET['feedback'] == 2){
            echo '<div class="feedback velykket">
                <span>Du har handlet '.number($_GET['buy']).' aksjer.</span> 
            </div>';
        } elseif($_GET['feedback'] == 3){
            echo '<div class="feedback mislykket">
                <span>Ingen aksjer ble valgt.</span> 
            </div>';
        } elseif($_GET['feedback'] == 4){
            echo '<div class="feedback mislykket">
                <span>Du kan ikke selge flere aksjer enn du har selv.</span> 
            </div>';
        } elseif($_GET['feedback'] == 5){
            echo '<div class="feedback velykket">
                <span>Du har solgt '.number($_GET['sell']).' aksjer.</span> 
            </div>';
        }  elseif($_GET['feedback'] == 6){
            echo '<div class="feedback mislykket">
                <span>Firmaet er konkurs og du kan derfor ikke kjøpe aksjer av det.</span> 
            </div>';
        }   elseif($_GET['feedback'] == 7){
            echo '<div class="feedback mislykket">
                <span>Du kan ikke eie mer enn '.number($max_stocks).' aksjer pr selskap.</span> 
            </div>';
        } elseif($_GET['feedback'] == 8){
            echo '<div class="feedback mislykket">
                <span>Ugyldig input</span> 
            </div>';
        } 
    }
    
    ?>
    <div class="content">
        <div class="tab">
            <button style="width: 50%;" class="tablinks pad_10" onclick="openTab(event, 'home')" <?php if(isset($_GET['home'])){ ?> id="defaultOpen" <?php } ?>>Handel</button>
            <button style="width: 50%;" class="tablinks pad_10" onclick="openTab(event, 'my_acc')" <?php if(isset($_GET['my_acc'])){ ?> id="defaultOpen" <?php } ?>>Min konto</button>
        </div>

        <div id="my_acc" class="tabcontent">
            <img src="img/action/aksjemarked.png">
            
            <div class="pad_10" style="text-align: center;">
                Total gevinst / tap:
                <?php 
    
    if($money_used == null && $money_earned == null){ 
        echo 0; 
    } elseif($money_used > 0 && $money_earned == null) { 
        echo '<span style="color: red;">';
        echo number($money_used);
        echo '</span>';
    } elseif($money_earned - $money_used < 0) {
        echo '<span style="color: red;">';
        echo number($money_earned - $money_used); 
        echo '</span>';
    } elseif($money_earned - $money_used > 0){
        echo '<span style="color: green;">';
        echo number($money_earned - $money_used); 
        echo '</span>';
    }
                    
                    ?> kr<br>
                Total verdi: <?php 
                
                $total_value = 0;
                for($value = 0; $value < count($my_stock); $value++){
                    if(is_numeric($my_stock[$value]) && is_numeric($stock_price[$value])){
                    $total_value = $my_stock[$value] * $stock_price[$value];
                    } else {
                        echo '0';
                    }
                }
                    
                    echo number($total_value); echo ' kr';
                   
                ?>
            </div>
            <div class="header header_mid">
                <span>Oversikt</span>
            </div>
            <table class="cellpadding" border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 30px;">
                    <th style="width: 40%; padding-left: 15px;">Aksje</th>
                    <th style="width: 20%; text-align: center;">Endring fra forrige 10. min</th>
                    <th style="width: 20%">Pris</th>
                    <th style="width: 20%">Min beholdning</th>

                </tr>
                <?php for($i = 0; $i < count($stock_name); $i++){ ?>
                <tr style="height: 30px;">
                    <td style="padding-left: 15px;"><a href="index.php?side=aksjegraf&company=<?php echo $i ?>"><?php echo $stock_name[$i]; ?></a></td>
                    <td style="text-align: center;">
                        <?php if($price_differance[$i] == "higher"){ ?>
                        <span class="help" data-balloon-length="medium" aria-label="<?php echo "Tidligere pris: "; echo $old_price[$i]; ?> kr" data-balloon-pos="up"><i style="color: green;" class="fas fa-arrow-up"></i></span>
                        <?php } else { ?>
                        <span class="help" data-balloon-length="medium" aria-label="<?php echo "Tidligere pris: "; echo $old_price[$i]; ?> kr" data-balloon-pos="up"><i style="color: red;" class="fas fa-arrow-down"></i></span>
                        <?php } ?>
                    </td>
                    <td><?php if($stock_price[$i] <= 0) { echo '<span style="color: red;">KONKURS</span>'; } else { echo number($stock_price[$i]); echo ' kr'; } ?> </td>
                    <td style="text-align: center;"><?php if($my_stock[$i] == null || $my_stock[$i] == 0){ echo '0'; } else { echo number($my_stock[$i]); } ?></td>
                </tr>
                <?php } ?>
            </table>
            
            <div class="header header_mid">
                <span>Siste 20 kjøp / salg</span>
            </div>
            <table class="cellpadding" border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 30px;">
                    <th style="width: 35%; padding-left: 15px;">Aksje</th>
                    <th style="width: 20%;">Kurs</th>
                    <th style="width: 15%">Handling</th>
                    <th style="width: 15%">Antall</th>
                    <th style="width: 15%">Tid</th>
                </tr>
                <?php             
    
            $act[0] = "Kjøp";
            $act[1] = "Salg";

        
            $result_last_20 = mysqli_query($con, "SELECT * FROM stocks_logg WHERE acc_id = '".$ID."' ORDER BY date DESC LIMIT 20");
            while($row_last_20 = mysqli_fetch_assoc($result_last_20)) { 
                
                ?>
                <tr style="height: 30px;">
                    <td style="padding-left: 15px;"><a href="index.php?side=aksjegraf&company=<?php echo $row_last_20['stock_id']; ?>"><?php echo $stock_name[$row_last_20['stock_id']]; ?></a></td>
                    <td><?php echo number($row_last_20['price']); ?></td>
                    <td><?php echo $act[$row_last_20['action']]; ?></td>
                    <td><?php echo number($row_last_20['amount']); ?></td>
                    <td><?php 
                    echo " "; echo date('d', $row_last_20['date']);
                    echo ". "; echo $month[date('n', $row_last_20['date'])];
                    echo " kl "; echo date('H:i', $row_last_20['date']);
                        ?></td>
                </tr>
                
                <?php } ?>
            </table>
        </div>


        <div id="home" class="tabcontent">
            <img src="img/action/aksjemarked.png">
            <div style="padding: 5px 18px;">På aksjemarked kan du kjøpe aksjer i håp om at de vil øke i verdi. Aksjemarkedet er åpent 24/7 og prisen endres hvert 10. minutt. <i>Kjøp lavt, selg høyt.</i><br>
            </div>
            <div style="padding: 5px 18px;">Dersom et selskap går konkurs så mister du aksjene du har i dette selskapet.<br>
            </div>
            <div style="padding: 5px 18px;">Kurtasje pr handel er på <?php echo number($kurtasje); ?> kr. <span class="help" data-balloon-length="medium" aria-label="Kurtasje er prisen du betaler for å kjøpe en aksje eller andre verdipapir. Det er en avgift du betaler til megleren din for å gjennomføre en handel på børsen." data-balloon-pos="up">(?)</span>
                <span style="color:#3e3e3e;">På happy hour er kurtasje satt til 0 kr</span><br>
            </div>
            <form method="post">
                <table class="cellpadding" border="0" cellspacing="0" cellpadding="0">
                    <tr style="height: 30px;">
                        <th style="width: 40%; padding-left: 15px;">Aksje</th>
                        <th style="width: 20%; text-align: center;">Endring fra forrige 10. min</th>
                        <th style="width: 20%">Pris</th>
                        <th style="width: 20%">Antall</th>

                    </tr>
                    <?php for($i = 0; $i < count($stock_name); $i++){ ?>
                    <tr style="height: 30px;">
                        <td style="padding-left: 15px;"><a href="index.php?side=aksjegraf&company=<?php echo $i ?>"><?php echo $stock_name[$i]; ?></a></td>
                        <td style="text-align: center;">
                            <?php if($price_differance[$i] == "higher"){ ?>
                            <span class="help" data-balloon-length="medium" aria-label="<?php echo "Tidligere pris: "; echo $old_price[$i]; ?> kr" data-balloon-pos="up"><i style="color: green;" class="fas fa-arrow-up"></i></span>
                            <?php } else { ?>
                            <span class="help" data-balloon-length="medium" aria-label="<?php echo "Tidligere pris: "; echo $old_price[$i]; ?> kr" data-balloon-pos="up"><i style="color: red;" class="fas fa-arrow-down"></i></span>
                            <?php } ?>
                        </td>
                        <td><?php if($stock_price[$i] <= 0) { echo '<span style="color: red;">KONKURS</span>'; } else { echo number($stock_price[$i]); echo ' kr'; } ?> </td>
                        <td><?php if($stock_price[$i] <= 0) { } else { ?><input type="text" id="number<?php echo $i; ?>" name="<?php echo $i; ?>" placeholder="<?php if($my_stock[$i] == null || $my_stock[$i] == 0){ echo '0'; } else { echo number($my_stock[$i]); } ?>"><?php } ?></td>
                    </tr>
                    <?php } ?>
                </table>

                <input type="submit" name="buy" style="width: 48%; float: left;" value="Kjøp">
                <input type="submit" name="sell" style="width: 48%" value="Selg">
            </form>
        </div>

    </div>
</body>

</html>
<?php 

}
?>


<script>
    <?php for($i = 0; $i < count($stock_name); $i++){ ?>
    $('#number<?php echo $i; ?>').on("keyup", function() {
        this.value = this.value.replace(/ /g, '');
        var number = this.value;
        this.value = number.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    });
    <?php } ?>

    function openTab(evt, tabPage) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabPage).style.display = "block";
        evt.currentTarget.className += " active";
    }

    document.getElementById("defaultOpen").click();
</script>