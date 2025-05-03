<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else { 
    
$city_name[0] = "Kristiansand";
$city_name[1] = "Oslo";
$city_name[2] = "Bergen";
$city_name[3] = "Stavanger";
$city_name[4] = "Tromsø";
    
$check_krs = mysqli_query($con, "SELECT city FROM kf WHERE city = 0");
if(mysqli_num_rows($check_krs) > 0) {
    $sql = "SELECT * FROM kf WHERE city = 0";
    $query = mysqli_query($con, $sql) or die (mysqli_error());
    $row = mysqli_fetch_assoc($query);

    $owner[0] =     $row['owner'];
    $price[0] =     $row['price'];
    $bullets[0] =   $row['bullets'];
    $kf_bank[0] =   $row['kf_bank'];
    $strike[0] =    $row['strike'];
} else {
    $owner[0] =     0;
    $price[0] =     6000000;
    $bullets[0] =   0;
}
    
    
$check_osl = mysqli_query($con, "SELECT city FROM kf WHERE city = 1");
if(mysqli_num_rows($check_osl) > 0) {
    $sql = "SELECT * FROM kf WHERE city=1";
    $query = mysqli_query($con, $sql) or die (mysqli_error());
    $row = mysqli_fetch_assoc($query);
    
    $owner[1] =     $row['owner'];
    $price[1] =     $row['price'];
    $bullets[1] =   $row['bullets'];
    $kf_bank[1] =   $row['kf_bank'];
    $strike[1] =    $row['strike'];
} else {
    $owner[1] =     0;
    $price[1] =     6000000;
    $bullets[1] =   0;
}
    
$check_ber = mysqli_query($con, "SELECT city FROM kf WHERE city = 2");
if(mysqli_num_rows($check_ber) > 0) {
    $sql = "SELECT * FROM kf WHERE city=2";
    $query = mysqli_query($con, $sql) or die (mysqli_error());
    $row = mysqli_fetch_assoc($query);
    
    $owner[2] =     $row['owner'];
    $price[2] =     $row['price'];
    $bullets[2] =   $row['bullets'];
    $kf_bank[2] =   $row['kf_bank'];
    $strike[2] =    $row['strike'];
} else {
    $owner[2] =     0;
    $price[2] =     6000000;
    $bullets[2] =   0;
}
    
$check_sta = mysqli_query($con, "SELECT city FROM kf WHERE city = 3");
if(mysqli_num_rows($check_sta) > 0) {
    $sql = "SELECT * FROM kf WHERE city=3";
    $query = mysqli_query($con, $sql) or die (mysqli_error());
    $row = mysqli_fetch_assoc($query);
    
    $owner[3] =     $row['owner'];
    $price[3] =     $row['price'];
    $bullets[3] =   $row['bullets'];
    $kf_bank[3] =   $row['kf_bank'];
    $strike[3] =    $row['strike'];
} else {
    $owner[3] =     0;
    $price[3] =     6000000;
    $bullets[3] =   0;
}
    
$check_tro = mysqli_query($con, "SELECT city FROM kf WHERE city = 4");
if(mysqli_num_rows($check_tro) > 0) {
    $sql = "SELECT * FROM kf WHERE city=4";
    $query = mysqli_query($con, $sql) or die (mysqli_error());
    $row = mysqli_fetch_assoc($query);
    
    $owner[4] =     $row['owner'];
    $price[4] =     $row['price'];
    $bullets[4] =   $row['bullets'];
    $kf_bank[4] =   $row['kf_bank'];
    $strike[4] =    $row['strike'];
} else {
    $owner[4] =     0;
    $price[4] =     6000000;
    $bullets[4] =   0;
}

?>
<html>

<head></head>

<body>
    <div class="breadcrumb">
        <span style="color: #3e3e3e;">Drap » </span><span style="color: #afafaf;">Kulefabrikk</span>
        <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
    </div>
    <?php
    
$price_pr_bullet = 1500000;
    
if(isset($_POST['money_bank'])){
    $money_bank_in = preg_replace('/\s+/', '', $_POST['money_bank_in']);
    
    if(!is_numeric($money_bank_in)){
        echo '<div class="feedback feilmelding">
            <span>Ugyldig sum</span> 
        </div>';
    } elseif($money_bank_in > $money){
        echo '<div class="feedback feilmelding">
            <span>Du kan ikke sette inn mere penger enn du allerede har på hånden.</span> 
        </div>';
    } elseif($money_bank_in < 0){
        echo '<div class="feedback feilmelding">
            <span>Ugyldig sum</span> 
        </div>';
    } else {
        $result = "UPDATE kf SET kf_bank = (kf_bank + $money_bank_in) WHERE city='$city'";
        mysqli_query($con, $result) or die("Bad query: $result");
        
        $result = "UPDATE accounts SET money = (money - $money_bank_in) WHERE ID='".$_SESSION['ID']."'";
        mysqli_query($con, $result) or die("Bad query: $result");
        
        echo '<div class="feedback velykket">
            <span>Pengene ble tatt satt inn og er på KF-konto om få strakser.</span> 
        </div>';
    }
}
    
if(isset($_POST['money_bank_out'])){
    $money_bank_in = preg_replace('/\s+/', '', $_POST['money_bank_in']);
    
    if(!is_numeric($money_bank_in)){
        echo '<div class="feedback feilmelding">
            <span>Ugyldig sum</span> 
        </div>';
    } elseif($money_bank_in > $kf_bank[$city]){
        echo '<div class="feedback feilmelding">
            <span>Du kan ikke ta ut mer enn du har på kf kontoen.</span> 
        </div>';
    } elseif($money_bank_in < 0){
        echo '<div class="feedback feilmelding">
            <span>Ugyldig sum</span> 
        </div>';
    } else {
        $result = "UPDATE kf SET kf_bank = (kf_bank - $money_bank_in) WHERE city='$city'";
        mysqli_query($con, $result) or die("Bad query: $result");
        
        $result = "UPDATE accounts SET money = (money + $money_bank_in) WHERE ID='".$_SESSION['ID']."'";
        mysqli_query($con, $result) or die("Bad query: $result");
        
        echo '<div class="feedback velykket">
            <span>Pengene ble tatt ut og er på din konto om få strakser.</span> 
        </div>';
    }
}

if(isset($_POST['bullet_production'])){
    $bullet_production_amount = $_POST['bullet_production_amount'];
        
    $total_price = ($bullet_production_amount * $price_pr_bullet);
    
    if($total_price > $kf_bank[$city]){
        echo '<div class="feedback feilmelding">
            <span>Du kan ikke produsere flere kuler enn du har råd til!</span> 
        </div>';
    } elseif($bullet_production_amount < 0){
        echo '<div class="feedback feilmelding">
            <span>Du må produsere minst 1 kule!</span> 
        </div>';
    } else {
        if(($bullet_production_amount + $bullets[$city]) >= 100){
            $result = "UPDATE kf SET strike = 0 WHERE city='$city'";
            mysqli_query($con, $result) or die("Bad query: $result");
        }
        
        $result = "UPDATE kf SET kf_bank = (kf_bank - $total_price) WHERE owner='$ID'";
        mysqli_query($con, $result) or die("Bad query: $result");
        
        $result = "UPDATE kf SET bullets = ($bullets[$city] + $bullet_production_amount) WHERE city='$city' AND owner = '$ID'";
        mysqli_query($con, $result) or die("Bad query: $result");
        
        $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
        VALUES ('$ID', 'kf - produsere kuler - $bullet_production_amount', '$money', '$bank_money', '".time()."')";
        $result = mysqli_query($con, $query);
        
        header("Location: index.php?side=kf&bullets_produced");
    }
}
    
$price_buy = 150000000;
    
if(isset($_GET['bullets_produced'])){
    echo '<div class="feedback velykket">
        <span>Kuler ble produsert.</span> 
    </div>';
}
    
if(isset($_GET['baught'])){
    echo '<div class="feedback velykket">
        <span>Gratulerer med kjøp av kulefabrikken i '.$city_name[$city].'</span> 
    </div>';
}
    
if(isset($_GET['bullets_baught'])){
    $bullets_baught = $_GET['bullets_baught'];
    
    echo '<div class="feedback velykket">
        <span>Du kjøpte ';
    echo number($bullets_baught);
    echo ' kuler!</span> 
        </div>';
}
    
if(isset($_GET['shutdown'])){
    echo '<div class="feedback feilmelding">
        <span>Kulefabrikken ble lagt ned.</span> 
    </div>';
}

if(isset($_POST['buy_factory'])){
    $check_ownership = mysqli_query($con, "SELECT owner FROM kf WHERE owner = $ID");
    
    $check_availability = mysqli_query($con, "SELECT city FROM kf WHERE city = '".$city."'");
    if(mysqli_num_rows($check_availability) > 0) {
        echo '<div class="feedback feilmelding">
            <span>Kulefabrikken er ikke ledig. Den ble enten kjøpt for deg eller den allerede har en eier som ikke er staten!</span> 
        </div>';
    } elseif(mysqli_num_rows($check_ownership) > 0){
        echo '<div class="feedback feilmelding">
            <span>Du eier allerede en kulefabrikk.</span> 
        </div>';
    } else {
        if($money < $price_buy){
            echo '<div class="feedback feilmelding">
                <span>Du har ikke nok penger til å kjøpe kulefabrikken i '.$city_name[$city].'</span> 
            </div>';
        } else {
            $query = "INSERT into `kf` (owner, price, bullets, city, kf_bank)
            VALUES ('$ID', '3000000', '0', '$city', '$price_buy')";
            $result = mysqli_query($con, $query);
            
            $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
            VALUES ('$ID', 'kf - kjøp kf - ".$city_name[$city]."', '$money', '$bank_money', '".time()."')";
            $result = mysqli_query($con, $query);
            
            $result = "UPDATE accounts SET money = ($money - $price_buy) WHERE ID='$ID'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            header("Location: index.php?side=kf&baught=true");
        }
    }
}
    
if(isset($_POST['submit'])){
    $submit_bullets = preg_replace('/\s+/', '', $_POST['submit_bullets']);
    
    if($owner[$city] == $ID){
        echo '<div class="feedback feilmelding">
            <span>Du kan ikke kjøpe kuler fra din egen kulefabrikk.</span> 
        </div>';
    } elseif(($submit_bullets * $price[$city]) > $money){
        echo '<div class="feedback feilmelding">
            <span>Du har ikke nok penger til å kjøpe '.number($submit_bullets).' kuler.</span> 
        </div>';
    } elseif($submit_bullets > $bullets[$city]){
        echo '<div class="feedback feilmelding">
            <span>Du kan ikke kjøpe flere kuler enn det som er i fabrikken.</span> 
        </div>';
    } elseif($submit_bullets < 0){
        echo '<div class="feedback feilmelding">
            <span>Du kan ikke kjøpe minus kuler.</span> 
        </div>';
    } else {
        
        $result = "UPDATE accounts SET money = ($money - ($submit_bullets * $price[$city])) WHERE ID='$ID'";
        mysqli_query($con, $result) or die("Bad query: $result");
        
        $result = "UPDATE kf SET bullets = ($bullets[$city] - $submit_bullets) WHERE city='$city'";
        mysqli_query($con, $result) or die("Bad query: $result");
        
        $sql = "SELECT * FROM kf WHERE city = $city";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row_owner = mysqli_fetch_assoc($query);

        $id_owner = $row_owner['owner'];

        $sql = "SELECT * FROM accounts WHERE ID = $id_owner";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row_owner_acc = mysqli_fetch_assoc($query);

        $bank_money_owner = $row_owner_acc['bank_money'];
        
        $result = "UPDATE accounts SET bullets = ($bullets_mine + $submit_bullets) WHERE ID='$ID'";
        mysqli_query($con, $result) or die("Bad query: $result");
 
        $result = "UPDATE kf SET kf_bank = (kf_bank + ($submit_bullets * $price[$city])) WHERE owner='$id_owner'";
        mysqli_query($con, $result) or die("Bad query: $result");
        
        $query = "INSERT into `varsel` (acc_id, text, date)
        VALUES ('$id_owner', 'Noen har kjøpt kuler i din kulefabrikk for ".number($submit_bullets * $price[$city])."kr. Pengene ligger i KF-banken.', '".time()."')";
        $result = mysqli_query($con, $query);

        $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
        VALUES ('$ID', 'kf - kjøpe kuler - ".$city_name[$city]." - ".$submit_bullets."', '$money', '$bank_money', '".time()."')";
        $result = mysqli_query($con, $query);

        header("Location: index.php?side=kf&bullets_baught=$submit_bullets");
    }
}
    
if(isset($_POST['shutdown'])){
    $del = mysqli_query($con, "DELETE FROM kf WHERE owner = '".$ID."' AND city = '$city'") or die(mysqli_error()); 
    
    $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
    VALUES ('$ID', 'kf - lagt ned kf - ".$city_name[$city]."', '$money', '$bank_money', '".time()."')";
    $result = mysqli_query($con, $query);
    
    header("Location: index.php?side=kf&shutdown");
}
    
    ?>
    <div class="content">
        <form method="post">
            <div class="header">
                <span>Kulefabrikk</span>
            </div>
            <img src="img/action/KF.png" style="width: 100%; height: auto;">
            <center>
                <div class="pad_10">
                Hver fjerde time (04:00, 08:00, 12:00, 16:00, 20:00 og 00:00) produseres det automatisk opp til 100 kuler for fabrikken dersom det er mindre enn 100 kuler og nok penger hos eieren.
                </div>
                <p>Du har: <?php echo number($bullets_mine); ?> kuler<br>
                    Denne kulefabrikken eies av <?php echo fetch_nick($owner[$city], $con); ?> <br>Pris pr kule er satt til <?php echo number($price[$city]); ?>kr<br><br>
                    Antall kuler i fabrikken: <?php echo number($bullets[$city]); ?></p>
                <input style="width: auto;" id="number" type="text" name="submit_bullets" placeholder="Antall kuler">
                <input style="width: auto;" type="submit" name="submit" value="Kjøp kuler">
            </center>
        </form>
    </div>

    <?php 
    
    if($owner[$city] == 0){
        $check_kf_fynn = mysqli_query($con, "SELECT * FROM fynn WHERE cat = 1 AND city = $city");

        if(mysqli_num_rows($check_kf_fynn) > 0) { ?>
    
    <div class="content" style="margin-top: 4.5px;">
        <form method="post">
            <div class="header">
                <span>Ledig kulefabrikk</span>
            </div>
            <center>
                <p>Denne kulefabrikken er til salgs på fynn.no</p>
                <a href="index.php?side=fynn&property" class="link_as_button">Gå til fynn.no</a>
            </center>
        </form>
    </div>
    
    <?php } else {
        ?>

    <div class="content" style="margin-top: 4.5px;">
        <form method="post">
            <div class="header">
                <span>Ledig kulefabrikk</span>
            </div>
            <center>
                <p>Denne kulefabrikken er ledig og du har dermed førsteretten<br> til å kjøpe den for <?php echo number($price_buy); ?>kr. Pengene du bruker for å kjøpe fabrikken blir lagt i kulefabrikk banken.</p>
                <input style="width: auto;" type="submit" name="buy_factory" value="Kjøp kulefabrikk">
            </center>
        </form>
    </div>

    <?php
        }
    }
    if($owner[$city] == $ID){
        
        ?>

    <div class="content" style="margin-top: 4.5px;">
        <form method="post">
            <div class="header">
                <span>Produser kuler</span>
            </div>
            <center>
                <p>Antall kuler i fabrikken: <?php echo number($bullets[$city]); ?><br>Pris pr kule er <?php echo number($price_pr_bullet); ?>kr å produsere</p>
                <input style="width: auto;" type="number" name="bullet_production_amount" placeholder="Antall kuler" required>
                <input style="width: auto;" type="submit" name="bullet_production" value="Produser kuler">
            </center>
        </form>
    </div>
    <div class="content" style="margin-top: 4.5px;">
        <form method="post">
            <div class="header">
                <span>KF-bank</span>
            </div>
            <center>
                <div class="pad_10">Hver fjerde time (04:00, 08:00, 12:00, 16:00, 20:00 og 00:00) produseres det automatisk opp til 100 kuler for fabrikken dersom det er mindre enn 100 kuler. Om du ikke har nok penger til å produsere opp til 100 kuler så vil kulefabrikken bli lagt ned etter 6 forsøk på rad. Du kan når som helst produsere opp til 100 kuler for å resette forsøkene som avtalegiroen bruker.</div>
                
                <p>Penger i banken: <?php if($kf_bank[$city] == null) { echo 0; } else { echo number($kf_bank[$city]); } ?>kr</p>
                <input style="width: auto;" type="text"  id="number1" name="money_bank_in" placeholder="Sum...">
                <input style="width: auto;" type="submit" name="money_bank" value="Sett inn">
                <input style="width: auto;" type="submit" name="money_bank_out" value="Ta ut">

            </center>
        </form>
    </div>
    <div class="content" style="margin-top: 4.5px;">
        <form method="post">
            <div class="header">
                <span>Legg ned kulefabrikk</span>
            </div>
            <center>
                <p>Om du velger å legge ned kulefabrikken mister du alle kulene dine.<br><span style="color: orange">Du får heller ingen penger for å legge den ned.</span></p>
                <input class="no" style="width: auto;" type="submit" name="shutdown" value="Legg ned kulefabrikken">
            </center>
        </form>
    </div>
    
    <?php 
    
        }
        
        ?>
</body>

</html>
<?php 

}

?>

<script src="jquery-3.4.1.min.js"></script>
<script>
$('#number').on("keyup", function() {
    this.value = this.value.replace(/ /g,'');
    var number = this.value;
    this.value = number.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
});
    
$('#number1').on("keyup", function() {
    this.value = this.value.replace(/ /g,'');
    var number = this.value;
    this.value = number.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
});
</script>