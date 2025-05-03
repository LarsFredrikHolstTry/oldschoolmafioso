
<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else { 
    
    $img[0] = '<img src="img/guns/glock.png" style="width: 100%; height: auto;">';
    $gun[0] = "Glock";
    $desc[0] = "Svakt, billig våpen.";
    if($role == 1){
        $price[0] = 0;
    } else {
        $price[0] = 0;
    }
    
    $img[1] = '<img src="img/guns/uzi.png" style="width: 100%; height: auto;">';
    $gun[1] = "Uzi";
    $desc[1] = "Mye kuler på kort tid.";
    if($role == 1){
        $price[1] = 100000 * 0.9;
    } else {
        $price[1] = 100000;
    }
    
    $img[2] = '<img src="img/guns/m4.png" style="width: 100%; height: auto;">';
    $gun[2] = "M4A4";
    $desc[2] = "Mye effektivt";
    if($role == 1){
        $price[2] = 250000 * 0.9;
    } else {
        $price[2] = 250000;
    }
    
    $img[3] = '<img src="img/guns/ak47.png" style="width: 100%; height: auto;">';
    $gun[3] = "AK-47";
    $desc[3] = "Mer effektivt";
    if($role == 1){
        $price[3] = 450000 * 0.9;
    } else {
        $price[3] = 450000;
    }
    
    $img[4] = '<img src="img/guns/rpg.png" style="width: 100%; height: auto;">';
    $gun[4] = "RPG";
    $desc[4] = "Litt effektivt for heist";
    if($role == 1){
        $price[4] = 1450000 * 0.9;
    } else {
        $price[4] = 1450000;
    }
    
    $img[5] = '<img src="img/guns/gl.png" style="width: 100%; height: auto;">';
    $gun[5] = "Grenade Launcher";
    $desc[5] = "Mye effektivt for heist";
    if($role == 1){
        $price[5] = 4500000 * 0.9;
    } else {
        $price[5] = 4500000;
    }

    $heist_chance[0] = 0;
    $heist_chance[1] = 20;
    $heist_chance[2] = 40;
    $heist_chance[3] = 60;
    $heist_chance[4] = 80;
    $heist_chance[5] = 100;

    
    
?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Drap » </span><span style="color: #afafaf;">Våpen</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <?php 
            
    
    if(isset($_POST['submit'])){
        $weapon = $_POST['radioBtn'];
        $weapon = mysqli_real_escape_string($con, nl2br(htmlentities($weapon, ENT_QUOTES, 'UTF-8')));

        $legal_weapon = array(0, 1, 2, 3, 4, 5);
        
        if(!in_array($weapon, $legal_weapon)){
            echo '<div class="feedback mislykket">
                <span>Ugyldig verdi.</span> 
            </div>';
        } elseif($money < $price[$weapon]){
            echo '<div class="feedback mislykket">
                <span>Du har ikke nok penger for dette våpenet.</span> 
            </div>';
        } elseif($vapen == $weapon){
            echo '<div class="feedback feilmelding">
                <span>Du har allerede dette våpenet.</span> 
            </div>';
        } elseif($weapon == 4 && $rank < 3){
            echo '<div class="feedback feilmelding">
                <span>Du må være ranken El Capitan for å kjøpe RPG.</span> 
            </div>';
        } elseif($weapon == 5 && $rank < 4){
            echo '<div class="feedback feilmelding">
                <span>Du må være ranken Counselor for å kjøpe Granade Launcher.</span> 
            </div>';
        } else {
            $result = "UPDATE accounts SET vapen = $weapon, money = ($money - $price[$weapon]) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            if($oppdrag == 4 && $city == 1){
                $result = "UPDATE oppdrag SET value = 1 WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
            
            $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
            VALUES ('$ID', 'våpen - kjøp våpen - ".$gun[$weapon]."', '$money', '$bank_money', '".time()."')";
            $result = mysqli_query($con, $query);
            
            header("Location: index.php?side=vapen&kjopt=$weapon");
        }
    }
    
    if(isset($_GET['kjopt'])){
        echo '<div class="feedback velykket">
            <span>Du kjøpte en '.$gun[$_GET['kjopt']].' for '.number($price[$_GET['kjopt']]).'kr</span> 
        </div>';
    }
    
            ?>
            <div class="header">
                <span>Våpen</span>
            </div>
            <img src="img/action/vapen.png">
            <form method="POST" action="">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 30px;">
                        <th style="width: 15%;"></th>
                        <th style="width: 15%;">Våpen</th>
                        <th style="width: 40%">Beskrivelse</th>
                        <th style="width: 20%">Pris</th>
                        <th style="width: 10%"></th>
                    </tr>
                    <?php for($i = 0; $i < count($img); $i++){ 
                    ?>
                    <tr>
                        <td><?php echo $img[$i] ?></td>
                        <td><?php echo $gun[$i] ?></td>
                        <td><?php if($vapen == $i){ echo '<span style="color: green">Du har dette våpenet</span>'; } else { echo $desc[$i]; } ?><br>
                        <span style="color: #3e3e3e;">Heist sjanse: <?php echo $heist_chance[$i]; ?>%</span></td>
                        <td><?php echo number($price[$i]) ?>kr</td>
                        <td>
                            <label class="radio_container" style="margin-top: -12px;">
                            <input type="radio" name='radioBtn' value="<?php echo $i ?>" required>
                            <span class="checkmark"></span>
                            </label>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
                <input style="width: 97%;" type="submit" name="submit" value="Kjøp valgt våpen">
            </form>
        </div>
    </body>
</html>
<?php 

}

?>