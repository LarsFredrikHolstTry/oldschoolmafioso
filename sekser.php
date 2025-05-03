
<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else { 

?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Gambling » </span><span style="color: #afafaf;">Sekser</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <?php

        $maxbet = 50000000;     // 50 000 000kr
        $minbet = 1000000;      // 1 000 000kr

        if(isset($_POST['submit'])){
            $amount = preg_replace('/\s+/', '', $_POST['amount']);

            $dice = mt_rand(1, 6);
            
            if($amount < 0){
                echo '<div class="feedback feilmelding">
                    <span>Du kan ikke satse minus.</span> 
                </div>';
            } elseif($amount > $maxbet){
                echo '<div class="feedback feilmelding">
                    <span>Du kan ikke satse mer enn maxbet.</span> 
                </div>';
            } elseif($amount <= $money){
                if($dice == 6){
                    $result = "UPDATE accounts SET money = ($money + ($amount * 6)) WHERE ID='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $win_amnt = ($amount * 6);
                    
                    if($oppdrag == 29 && $city == 4){
                        $result = "UPDATE oppdrag SET value = (value + $win_amnt) WHERE acc_id='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                    }
                    
                    $result = "UPDATE stats SET gambling = (gambling + $win_amnt) WHERE acc_id='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    
                    $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                    VALUES ('$ID', 'Sekser - vinn - $win_amnt', '$money', '$bank_money', '".time()."')";
                    $result = mysqli_query($con, $query);
                    
                    header("Location: index.php?side=sekser&win=$win_amnt");
                } else {
                    $result = "UPDATE accounts SET money = ($money - $amount) WHERE ID='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    
                    if($oppdrag == 29 && $city == 4){
                        $result = "UPDATE oppdrag SET value = (value - $amount) WHERE acc_id='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                    }
                    
                    $result = "UPDATE stats SET gambling = (gambling - $amount) WHERE acc_id='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    
                    $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
                    VALUES ('$ID', 'Sekser - tap - $amount', '$money', '$bank_money', '".time()."')";
                    $result = mysqli_query($con, $query);
                    
                    header("Location: index.php?side=sekser&loose=$amount");
                }
            } else {
                header("Location: index.php?side=sekser&toomuch");
            }
        }

        if(isset($_GET['toomuch'])){
            echo '<div class="feedback feilmelding">
                <span>Du kan ikke satse mer penger enn det du har på hånden!</span> 
            </div>';
        }

        if(isset($_GET['loose'])){
            echo '<div class="feedback mislykket">
                <span>Du trillet '.mt_rand(1, 5).' og tapte '.number($_GET['loose']).'kr!</span> 
            </div>';
        }

        if(isset($_GET['win'])){
            echo '<div class="feedback velykket">
                <span>Du trillet 6 og vant '.number($_GET['win']).'kr!</span> 
            </div>';
        }

        ?>
        <div class="content">
        <form action="" method="post">
                <?php if($oppdrag == 29 && $city == 4){ ?>
                    <div class="feedback velykket"><span>Du har i oppdrag å vinne 100 000 000 på gambling.<br>Du har: <?php echo number($value) ?> / 100 000 000</span></div>     
                <?php } ?>
            <div class="header">
                <span>Sekser</span>
            </div>
            <img src="img/action/sekser.png" style="width: 100%; height: auto;">
            <p>
                <center>Hovedmålet med dette spillet er å få terningkast 6<br>Vinnersjanse: 1:6<br><br>
                    <input style="width: auto;" id="number" min="<?php echo $minbet ?>" max="<?php echo $maxbet ?>" type="text" name="amount" placeholder="Maxbet: <?php echo number($maxbet) ?>" required>
                    <input style="width: auto;" type="submit" name="submit" value="Kast terning">
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
