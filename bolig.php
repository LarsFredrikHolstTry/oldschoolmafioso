<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else { 
    
    $img[0] = '<img src="img/house/skur.png" style="width: 100%; height: auto;">';
    $house[0] = "Skur";
    $desc[0] = "Ingen beskyttelse<br>Bunker: <span style='color: red;'>nei</span>";
    if($role == 1){
        $price[0] = 0;
    } else {
        $price[0] = 0;
    }
    
    $img[1] = '<img src="img/house/enebolig.png" style="width: 100%; height: auto;">';
    $house[1] = "Enebolig";
    $desc[1] = "Lite beskyttelse<br>Bunker: <span style='color: red;'>nei</span>";
    if($role == 1){
        $price[1] = 1000000 * 0.9;
    } else {
        $price[1] = 1000000;
    }
    
    $img[2] = '<img src="img/house/sveitservilla.png" style="width: 100%; height: auto;">';
    $house[2] = "Sveitservilla";
    $desc[2] = "Middels beskyttelse<br>Bunker: <span style='color: green;'>ja</span>";
    if($role == 1){
        $price[2] = 15000000 * 0.9;
    } else {
        $price[2] = 15000000;
    }
    
    $img[3] = '<img src="img/house/villa.png" style="width: 100%; height: auto;">';
    $house[3] = "Villa";
    $desc[3] = "Høy beskyttelse<br>Bunker: <span style='color: green;'>ja</span>";
    if($role == 1){
        $price[3] = 45000000 * 0.9;
    } else {
        $price[3] = 45000000;
    }
    
?>
<!-- CONTENT -->
<html>

<head></head>

<body>
    <div class="breadcrumb">
        <span style="color: #3e3e3e;">Drap » </span><span style="color: #afafaf;">Bolig</span>
        <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
    </div>
        <?php 
            
    if(isset($_POST['submit'])){
        $house_chosen = $_POST['radioBtn'];
        $house_chosen = mysqli_real_escape_string($con, nl2br(htmlentities($house_chosen, ENT_QUOTES, 'UTF-8')));

        $legal_houses = array(0, 1, 2, 3);
        
        if(!in_array($house_chosen, $legal_houses)){
            echo '<div class="feedback mislykket">
                <span>Ugyldig input.</span> 
            </div>';
        }elseif($money < $price[$house_chosen]){
            echo '<div class="feedback mislykket">
                <span>Du har ikke nok penger for denne boligen.</span> 
            </div>';
        } elseif($beskyttelse == $house_chosen){
            echo '<div class="feedback feilmelding">
                <span>Du har allerede denne boligen.</span> 
            </div>';
        } else {
            $result = "UPDATE accounts SET beskyttelse = $house_chosen, money = ($money - $price[$house_chosen]) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            if($oppdrag == 5 && $city == 1){
                $result = "UPDATE oppdrag SET value = 1 WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
            
            $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
            VALUES ('$ID', 'Bolig - kjøp bolig - ".$house[$house_chosen]."', '$money', '$bank_money', '".time()."')";
            $result = mysqli_query($con, $query);
            
            header("Location: index.php?side=bolig&kjopt=$house_chosen");
        }
    }
    
    if(isset($_GET['kjopt'])){
        echo '<div class="feedback velykket">
            <span>Du kjøpte en '.$house[$_GET['kjopt']].' for '.number($price[$_GET['kjopt']]).'kr</span> 
        </div>';
    }
    
            ?>
    <div class="content">
        <div class="header">
            <span>Bolig</span>
        </div>
        <img src="img/action/bolig.png">
        <form method="POST" action="">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 30px;">
                    <th style="width: 25%;"></th>
                    <th style="width: 15%;">Bolig</th>
                    <th style="width: 30%">Beskrivelse</th>
                    <th style="width: 20%">Pris</th>
                    <th style="width: 10%"></th>
                </tr>
                <?php for($i = 0; $i < count($img); $i++){ 
                    ?>
                <tr>
                    <td><?php echo $img[$i] ?></td>
                    <td><?php echo $house[$i] ?></td>
                    <td>
                        <?php
                        
                        if($beskyttelse == $i){ 
                            echo '<span style="color: green">Du har denne boligen!</span>'; 
                
                            if($beskyttelse < 2){
                                echo '<br>Bunker: <span style="color: red;">nei</span>';
                            } else {
                                if($bunker == 1){
                                    echo '<br>Bunkertillatelse: <span style="color: green;">Ja</span>';
                                } else {
                                    echo '<br>Bunker: <span style="color: orange;"><a href="index.php?side=bunker">Bygg bunker</a></span>';
                                }
                            }

                        } else { 
                            echo $desc[$i]; 
                        } 
                
                        ?>
                        
                    </td>
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
            <input style="width: 97%;" type="submit" name="submit" value="Kjøp valgt bolig">
        </form>
    </div>
</body>

</html>
<?php 

}

?>
