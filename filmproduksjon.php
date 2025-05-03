
<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else { 
    
$sql = "SELECT * FROM filmproduction WHERE acc_id='".$ID."'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row_mp = mysqli_fetch_assoc($query);

$ID =                        $row_mp['ID'];
$filmproduction_status =     $row_mp['filmproduction_status'];
$filmproduction_seconds =    $row_mp['filmproduction_seconds'];
    
$cheap_movie_price =        1000000;
$medium_movie_price =       5000000;
$expensive_movie_price =    20000000;
    
$cheap_movie_exp =        500;
$medium_movie_exp =       1000;
$expensive_movie_exp =    1500;
    
$cheap_movie_chance =               8; // 80%
$medium_movie_chance =              6; // 60%
$expensive_movie_chance =           4; // 60%
    
$cheap_movie_payout = mt_rand(1200000, 1400000);
$medium_movie_payout = mt_rand(7000000, 8000000);
$expensive_movie_payout = mt_rand(32000000, 36000000);

$waittime_mp = 600 + time();


$chance = rand(1, 10);

    
?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Diverse » </span><span style="color: #afafaf;">Filmproduksjon</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <?php 
    
if(isset($_GET['flopp'])){
    echo '<div class="feedback mislykket">
        <span>Filmen ble en flopp, du mistet pengene dine.</span> 
    </div>';
}
    
if(isset($_GET['velykket'])){
    echo '<div class="feedback velykket">
        <span>Filmen ble en suksess, du tjente ';
    echo number($_GET['velykket']);
    echo ' kr på filmen!</span> 
    </div>';
    
    $check_ho = mysqli_query($con, "SELECT * FROM hurtig_oppdrag WHERE acc_id = '".$_SESSION['ID']."'");

    if(mysqli_num_rows($check_ho) > 0) {
        if($oppdrag_ho == 5 || $oppdrag_ho == 2){
            echo '<div class="feedback velykket"><span><b>Hurtig oppdrag:</b> Du har klart '.$value_ho.' av '.$kriterium[$oppdrag_ho].' velykkede filmproduksjoner</span></div>';
        }
    }
}
    
    if($filmproduction_status == 1){
            
                $waiting = $filmproduction_seconds - time();
                
                echo '<div class="feedback feilmelding">
                    <span>Du må vente <span id="countdowntimer">';
                echo $waiting;       
                echo '</span> sekunder før du kan produsere film igjen.</span> </div>';
?>
        <script type="text/javascript">
            var seconds = document.getElementById("countdowntimer").textContent;
            var countdown = setInterval(function() {
                seconds--;
                document.getElementById("countdowntimer").textContent = seconds;
                if (seconds <= 0) window.location.href = "index.php?side=filmproduksjon";
            }, 1000);

        </script>

        <?php
            } else { 
        

if(isset($_POST['cheap_movie'])){

    if($happy_hour == 1){
        $mp_exp = $cheap_movie_exp * 2;
    } elseif($role == 3){
        $mp_exp = $cheap_movie_exp * 1.1;
    } else {
        $mp_exp = $cheap_movie_exp;
    }
    
    if($money < $cheap_movie_price){
        echo '<div class="feedback mislykket">
            <span>Du har ikke nok penger til å produsere film.</span> 
        </div>';
    } elseif($cheap_movie_chance > $chance) {
        $check_ho = mysqli_query($con, "SELECT * FROM hurtig_oppdrag WHERE acc_id = '".$_SESSION['ID']."'");

        if(mysqli_num_rows($check_ho) > 0) {
            if($oppdrag_ho == 2){
                $result = "UPDATE hurtig_oppdrag SET value = ($value_ho + 1) WHERE acc_id = '".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
        }

        if(mysqli_num_rows($check_ho) > 0) {
            if($oppdrag_ho == 5){
                $result = "UPDATE hurtig_oppdrag SET value = ($value_ho + 1) WHERE acc_id = '".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
        }

        if($oppdrag == 17){
            $result = "UPDATE oppdrag SET value = ($value + 1) WHERE acc_id = '".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
        }

        $result = mysqli_query($con, "UPDATE filmproduction SET filmproduction_status='1', filmproduction_seconds='$waittime_mp' WHERE acc_id='".$_SESSION['ID']."'") or die (mysqli_error($con));

        $result = "UPDATE stats SET filmproduksjon = (filmproduksjon + $cheap_movie_payout) WHERE acc_id='".$_SESSION['ID']."'";
        mysqli_query($con, $result) or die("Bad query: $result");

        $result = "UPDATE accounts SET money = (money + $cheap_movie_payout), exp = ($exp + $mp_exp) WHERE ID='".$_SESSION['ID']."'";
        mysqli_query($con, $result) or die("Bad query: $result");
        
        $result = "UPDATE daily_exp SET exp = (exp + $mp_exp) WHERE acc_id='".$_SESSION['ID']."'";
        mysqli_query($con, $result) or die("Bad query: $result");

        header("Location: index.php?side=filmproduksjon&velykket=$cheap_movie_payout");
    } else {
        $result = mysqli_query($con, "UPDATE filmproduction SET filmproduction_status='1', filmproduction_seconds='$waittime_mp' WHERE acc_id='".$_SESSION['ID']."'") or die (mysqli_error($con));

        $result = "UPDATE stats SET filmproduksjon = (filmproduksjon - $cheap_movie_price) WHERE acc_id='".$_SESSION['ID']."'";
        mysqli_query($con, $result) or die("Bad query: $result");

        $result = "UPDATE accounts SET money = (money - $cheap_movie_price) WHERE ID='".$_SESSION['ID']."'";
        mysqli_query($con, $result) or die("Bad query: $result");
        
        header("Location: index.php?side=filmproduksjon&flopp");
    }
}
    

if(isset($_POST['medium_movie'])){
    if($happy_hour == 1){
        $mp_exp = $medium_movie_exp * 2;
    } elseif($role == 3){
        $mp_exp = $medium_movie_exp * 1.1;
    } else {
        $mp_exp = $medium_movie_exp;
    }
    
    if($money < $medium_movie_price){
        echo '<div class="feedback mislykket">
            <span>Du har ikke nok penger til å produsere film.</span> 
        </div>';
    } elseif($medium_movie_chance > $chance) {
        $check_ho = mysqli_query($con, "SELECT * FROM hurtig_oppdrag WHERE acc_id = '".$_SESSION['ID']."'");

        if(mysqli_num_rows($check_ho) > 0) {
            if($oppdrag_ho == 2){
                $result = "UPDATE hurtig_oppdrag SET value = ($value_ho + 1) WHERE acc_id = '".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
        }

        if(mysqli_num_rows($check_ho) > 0) {
            if($oppdrag_ho == 5){
                $result = "UPDATE hurtig_oppdrag SET value = ($value_ho + 1) WHERE acc_id = '".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
        }

        $result = mysqli_query($con, "UPDATE filmproduction SET filmproduction_status='1', filmproduction_seconds='$waittime_mp' WHERE acc_id='".$_SESSION['ID']."'") or die (mysqli_error($con));

        $result = "UPDATE stats SET filmproduksjon = (filmproduksjon + $medium_movie_payout) WHERE acc_id='".$_SESSION['ID']."'";
        mysqli_query($con, $result) or die("Bad query: $result");

        $result = "UPDATE accounts SET money = (money + $medium_movie_payout), exp = ($exp + $mp_exp) WHERE ID='".$_SESSION['ID']."'";
        mysqli_query($con, $result) or die("Bad query: $result");
        
        $result = "UPDATE daily_exp SET exp = (exp + $mp_exp) WHERE acc_id='".$_SESSION['ID']."'";
        mysqli_query($con, $result) or die("Bad query: $result");

        header("Location: index.php?side=filmproduksjon&velykket=$medium_movie_payout");
    } else {
        $result = mysqli_query($con, "UPDATE filmproduction SET filmproduction_status='1', filmproduction_seconds='$waittime_mp' WHERE acc_id='".$_SESSION['ID']."'") or die (mysqli_error($con));

        $result = "UPDATE stats SET filmproduksjon = (filmproduksjon - $medium_movie_price) WHERE acc_id='".$_SESSION['ID']."'";
        mysqli_query($con, $result) or die("Bad query: $result");

        $result = "UPDATE accounts SET money = (money - $medium_movie_price) WHERE ID='".$_SESSION['ID']."'";
        mysqli_query($con, $result) or die("Bad query: $result");
        
        header("Location: index.php?side=filmproduksjon&flopp");
    }
}
    
if(isset($_POST['expensive_movie'])){
    if($happy_hour == 1){
        $mp_exp = $expensive_movie_exp * 2;
    } elseif($role == 3){
        $mp_exp = $expensive_movie_exp * 1.1;
    } else {
        $mp_exp = $expensive_movie_exp;
    }
    
    if($money < $expensive_movie_price){
        echo '<div class="feedback mislykket">
            <span>Du har ikke nok penger til å produsere film.</span> 
        </div>';
    } elseif($expensive_movie_chance > $chance) {
        $check_ho = mysqli_query($con, "SELECT * FROM hurtig_oppdrag WHERE acc_id = '".$_SESSION['ID']."'");

        if(mysqli_num_rows($check_ho) > 0) {
            if($oppdrag_ho == 2){
                $result = "UPDATE hurtig_oppdrag SET value = ($value_ho + 1) WHERE acc_id = '".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
        }

        if(mysqli_num_rows($check_ho) > 0) {
            if($oppdrag_ho == 5){
                $result = "UPDATE hurtig_oppdrag SET value = ($value_ho + 1) WHERE acc_id = '".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
        }

        if($oppdrag == 19){
            $result = "UPDATE oppdrag SET value = ($value + 1) WHERE acc_id = '".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
        }
        
        if($oppdrag == 32 && $city == 2){
            $result = "UPDATE oppdrag SET value = ($value + 1) WHERE acc_id = '".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
        }

        $result = mysqli_query($con, "UPDATE filmproduction SET filmproduction_status='1', filmproduction_seconds='$waittime_mp' WHERE acc_id='".$_SESSION['ID']."'") or die (mysqli_error($con));

        $result = "UPDATE stats SET filmproduksjon = (filmproduksjon + $expensive_movie_payout) WHERE acc_id='".$_SESSION['ID']."'";
        mysqli_query($con, $result) or die("Bad query: $result");

        $result = "UPDATE accounts SET money = (money + $expensive_movie_payout), exp = ($exp + $mp_exp) WHERE ID='".$_SESSION['ID']."'";
        mysqli_query($con, $result) or die("Bad query: $result");
        
        $result = "UPDATE daily_exp SET exp = (exp + $mp_exp) WHERE acc_id='".$_SESSION['ID']."'";
        mysqli_query($con, $result) or die("Bad query: $result");

        header("Location: index.php?side=filmproduksjon&velykket=$expensive_movie_payout");
    } else {
        $result = mysqli_query($con, "UPDATE filmproduction SET filmproduction_status='1', filmproduction_seconds='$waittime_mp' WHERE acc_id='".$_SESSION['ID']."'") or die (mysqli_error($con));

        $result = "UPDATE stats SET filmproduksjon = (filmproduksjon - $expensive_movie_price) WHERE acc_id='".$_SESSION['ID']."'";
        mysqli_query($con, $result) or die("Bad query: $result");

        $result = "UPDATE accounts SET money = (money - $expensive_movie_price) WHERE ID='".$_SESSION['ID']."'";
        mysqli_query($con, $result) or die("Bad query: $result");
        
        header("Location: index.php?side=filmproduksjon&flopp");
    }
}

        
        ?>
        <div class="content">
            <form method="post">
                <div class="header">
                    <span>Filmproduksjon</span>
                </div>
                <img src="img/action/filmproduksjon.png">
                <p class="pad_10">Velkommen til filmproduksjon!<br><br> Her kan du produsere filmer, du velger selv hvor mye du er villig til å bruke på filmen, husk at jo mer du bruker på utstyr, desto mer utbytte får du.</p>
                <div style="width: 100%; padding: 10px; height: 105px; border-bottom: 1px solid #2c2c2c; border-top: 1px solid #2c2c2c;">
                    <div style="width: 55%; float:left;">
                    <b>Filmutstyr set 1</b><br>
                    Webcam med microfon <b>Pris: 100k</b><br>
                    Dell Laptop <b>Pris: 900k</b><br>
                    Totalpris: <b><?php echo number($cheap_movie_price); ?>kr</b><br><br>
                    <b>Risiko: </b><span style="color: green">Lav</span><br>
                    120% - 140% utbetaling<br>
                    80% sjanse
                    </div>
                    <div style="width: 35%; float:left; text-align: right;">
                        <input type="submit" value="Produser billig film" name="cheap_movie">
                    </div>
                </div>
                <div style="width: 100%; padding: 10px; height: 120px; border-bottom: 1px solid #2c2c2c;">
                    <div style="width: 55%; float:left;">
                    <b>Filmutstyr set 2</b><br>
                    Sony Kamera A7 III <b>Pris: 1,5M</b><br>
                    Røde VideoMic Go <b>Pris: 500K</b><br>
                    Macbook pro <b>Pris: 3M</b><br>
                    Totalpris: <b><?php echo number($medium_movie_price); ?>kr</b><br><br>
                    <b>Risiko: </b><span style="color: orange">Middels</span><br>
                    140% - 160% utbetaling<br>
                    60% sjanse
                    </div>
                    <div style="width: 35%; float:left; text-align: right;">
                        <input type="submit" value="Produser film" name="medium_movie">
                    </div>
                </div>
                <div style="width: 100%; padding: 10px; height: 110px;">
                    <div style="width: 55%; float:left;">
                    <b>Filmutstyr set 3</b><br>
                    Blackmagic Studio Camera 4K <b>Pris: 5M</b><br>
                    Neumann U87 AI Studiomikrofon <b>Pris: 2,5M</b><br>
                    Mac pro 2020 <b>Pris: 12,5M</b><br>
                    Totalpris: <b><?php echo number($expensive_movie_price); ?>kr</b><br><br>
                    <b>Risiko: </b><span style="color: red">Vanskelig</span><br>
                    160% - 180% utbetaling<br>
                    40% sjanse
                    </div>
                    <div style="width: 35%; float:left; text-align: right;">
                        <input type="submit" value="Produser dyr film" name="expensive_movie">
                    </div>
                </div>
            </form>
        </div>
        <?php } ?>
    </body>
</html>
<?php 

}

?>