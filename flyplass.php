<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else {

?>
<html>
    <head>
    <style>
        
        
        .feedback span a:hover {
            text-decoration: underline !important;
        }
    </style>
    
    </head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Diverse » </span><span style="color: #afafaf;">Flyplass</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <?php
    
    
    if(isset($_GET['reset'])){
        $price_reset = 10000000;
        if($money < $price_reset){
            echo '<div class="feedback feilmelding">
                <span>Du har ikke nok penger for å resette ventetiden.</span> 
            </div>';
        } else {
            $result = "UPDATE flyplass_cd SET flyplass_status = 0, flyplass_seconds = 0 WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $result = "UPDATE accounts SET money = (money - $price_reset) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            header("Location: index.php?side=flyplass");
        }
    }
    
$sql = "SELECT * FROM flyplass_cd WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row_fplyass_cd = mysqli_fetch_assoc($query);
    
        if($row_fplyass_cd['flyplass_status'] == 1){
            $seconds = $row_fplyass_cd['flyplass_seconds'];
                echo '<div class="feedback feilmelding">
                    <span>Du må vente ';
                echo secondsToMinutes($seconds - time());
                echo ' før du kan fly igjen. <a style="text-decoration: none; color: black;" href="index.php?side=flyplass&reset">Reset ventetid (10m)</a></span> 
                    </div>';

        } else {
        
        if(isset($_POST['submit'])){
            $waittime_flyplass = 270 + time();

            $selected = $_POST['radioBtn'];
            
            if($city_price[$selected] > $money){
                    echo '<div class="feedback feilmelding">
                        <span><b>Feilmelding!</b> Du har ikke nok penger til å reise</span> 
                    </div>';
            } else {
                if($city == $selected){
                    echo '<div class="feedback feilmelding">
                        <span><b>Feilmelding!</b> Du er allerede i denne byen</span> 
                    </div>';
                } else {
                    $result = "UPDATE accounts SET city = $selected, money = ($money - $city_price[$selected]) WHERE ID='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    
                    $result = "UPDATE flyplass_cd SET flyplass_status = 1, flyplass_seconds = $waittime_flyplass WHERE acc_id='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
                    VALUES ('$ID', '9', 'Flyplass - reise til ".$city_name[$selected]."', '$money', '$bank_money', '".time()."')";
                    $result = mysqli_query($con, $query);

                    header("Location: index.php?side=flyplass&city=$selected");
                }
            }
        }
        
        if(isset($_GET['city'])){
            echo '<div class="feedback velykket">
                <span><b>Velkommen</b> til '.$city_name[$_GET['city']].'!</span> 
            </div>';
        }
        
        ?>
        <div class="content">
            <img src="img/action/flyplass.png" style="width: 100%; height: auto;">
            <form method="POST" action="">
                <div class="head">
                    <div style="width: 50%; float: left;">By</div>
                    <div style="width: 25%; float: left;">Ventetid</div>
                    <div style="width: 25%; float: left;">Pris</div>
                </div>
                <?php for($i = 0; $i < 5; $i++){ ?>
            <input id="radio_<?php echo $i ?>" class="radio isHidden" name='radioBtn' value="<?php echo $i ?>" type="radio" required>
            <label for="radio_<?php echo $i ?>" class="label" <?php if($i == 0 || $i == 2 || $i == 4){ ?> style="background-color: #181818;" <?php } ?>>
                <div style="width: 50%; float: left;"><?php echo $city_name[$i]; ?></div>
                <div style="width: 25%; float: left;"><?php echo $reise_ventetid; ?>s</div>
                <div style="width: 25%; float: left;"><?php echo number($city_price[$i]); ?></div>
            </label>

                <?php } ?>
            <input style="width: 97.5%; margin-top: 7px;" type="submit" name="submit" value="Reis til valgt by">
            </form>
        </div>
    </body>
</html>

<?php } }  ?>
<style>
    .isHidden {
        display: none;
        /* hide radio buttons */
    }

    .label {
        display: inline-block;
        background-color: #1b1b1b;
        width: 100%;
        height: 25px;
        padding: 8px 10px 0px 10px;
    }

    .head {
        width: 100%;
        height: 25px;
        padding: 8px 10px 0px 10px;
        color: #afafaf;
    }

    .label:hover {
        color: #a0a0a0;
        cursor: pointer;
        background-color: #202020 !important;
    }

    .radio:checked+.label {
        /* target next sibling (+) label */
        color: #a0a0a0;
        background-color: #303030 !important;
    }
</style>