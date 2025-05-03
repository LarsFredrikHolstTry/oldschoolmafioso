<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else { 
    
?>
<!-- CONTENT -->
<html>

<head></head>

<body>
    <div class="breadcrumb">
        <span style="color: #3e3e3e;">Diverse » </span><span style="color: #afafaf;">Fynn.no</span>
        <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
    </div>
    <?php
    
    if(isset($_GET['sell'])){
        echo '<div class="feedback velykket">
            <span>Bilen ble lagt ut for salg!</span> 
        </div>';
    }
    
    if(isset($_GET['sell_prop'])){
        echo '<div class="feedback velykket">
            <span>Eiendelen ble lagt ut for salg!</span> 
        </div>';
    }
    
    if(isset($_GET['sell_bullets'])){
        echo '<div class="feedback velykket">
            <span>Kuler ble lagt ut for salg!</span> 
        </div>';
    }
    
    ?>
    <div class="content">
        <div class="header">
            <span>Fynn.no</span>
        </div>
        <a href="index.php?side=fynn"><img src="img/action/fynn.png"></a>
        <?php if(isset($_GET['cars'])){
            
            ?>
        <table border="0" cellspacing="0" cellpadding="0">
            <tr style="height: 30px;">
                <th style="padding-left: 15px; width: 50%;">Bil</th>
                <th style="width: 20%;">Pris</th>
                <th style="width: 15%;">Km</th>
                <th style="width: 15%;"></th>
            </tr>
            <?php 
                
                $result_cars = mysqli_query($con, "SELECT * FROM fynn WHERE cat = 0");

                $i = 0;
                while($row_cars = mysqli_fetch_assoc($result_cars)) {
                    
                    $car_fynn_ID =          $row_cars['ID'];
                    $car_fynn_price =       $row_cars['price'];
                    $car_fynn_type =        $row_cars['car_type'];
                    $car_fynn_km =          $row_cars['km'];
                    $car_fynn_city =        $row_cars['city'];
                    $car_fynn_acc_id =      $row_cars['acc_id'];


                    $i++;
                    
                ?>
            <tr style="height: 30px;">
                <td style="padding-left: 15px; width: 25%;"><?php echo $car[$car_fynn_type]; echo ' i '; echo $city_name[$car_fynn_city]; ?></td>
                <td><?php echo number($car_fynn_price); ?></td>
                <td><?php echo number($car_fynn_km); ?></td>
                <td><?php if($car_fynn_acc_id == $ID){ ?>
                    <a class="no link_as_button" style="text-align: right;" href="index.php?side=fynn&cars&remove=<?php echo $car_fynn_ID ?>">Fjern</a>
                <?php } else { ?>
                    <a class="link_as_button" style="text-align: right;" href="index.php?side=fynn&cars&buy=<?php echo $car_fynn_ID ?>">Kjøp</a>
                <?php } ?>
                </td>
            </tr>
            <?php }  
        
                if($i == 0){
                    echo '<center><span style="color: orange">Det er ingen biler på markedet!</span></center>'; 
                } 

                if(isset($_POST['sell'])){
                    $check_max = mysqli_query($con, "SELECT * FROM fynn WHERE acc_id = $ID");
                    $price = preg_replace('/\s+/', '', $_POST['price_car']);

                    if(mysqli_num_rows($check_max) > 4) {
                        echo '<div class="feedback feilmelding">
                            <span>Du kan max ha 5 ting om gangen ute på fynn.no</span> 
                        </div>';
                    } else {

                        if($price > 999999999){
                            echo '<div class="feedback feilmelding">
                                <span>Prisen kan ikke være høyere enn 999 999 999</span> 
                            </div>';
                        } elseif($price < 0){
                            echo '<div class="feedback feilmelding">
                                <span>Prisen kan ikke være mindre enn 0kr</span> 
                            </div>';
                        } else {
                            $sql = "SELECT * FROM cars WHERE ID='".$_POST['car_id']."'";
                            $query = mysqli_query($con, $sql) or die (mysqli_error());
                            $row_car = mysqli_fetch_assoc($query);

                            $car_city = $row_car['city'];
                            $car_type = $row_car['car_id'];
                            $car_km = $row_car['km'];

                            $date = time() + 43200;

                            $del = mysqli_query($con, "DELETE FROM cars WHERE ID = '".$_POST['car_id']."'") or die(mysqli_error());
                            
                            $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
                            VALUES ('$ID', '8', 'Fynn - salg_bilID: ".$car_type." - pris: ".$price."', '$money', '$bank_money', '".time()."')";
                            $result = mysqli_query($con, $query);

                            $query = "INSERT into `fynn` (acc_id, price, cat, car_type, km, city, date)
                            VALUES ('$ID', '$price', '0', '$car_type', '$car_km', '$car_city', '$date')";
                            $result = mysqli_query($con, $query);

                            header("Location: index.php?side=fynn&cars&sell");
                        }
                    }
                }
        
                if(isset($_GET['buy'])){
                    $sql = "SELECT * FROM fynn WHERE ID='".$_GET['buy']."'";
                    $query = mysqli_query($con, $sql) or die (mysqli_error());
                    $row_buy = mysqli_fetch_assoc($query);
                    
                    $price_staten = $row_buy['price'] * 0.9;
                    
                    if($row_buy['acc_id'] == $ID){
                        echo '<div style="width: 97%" class="feedback feilmelding">
                            <span>Du kan ikke kjøpe din egne ting.</span> 
                        </div>';
                    } elseif($row_buy['price'] > $money){
                        echo '<div style="width: 97%" class="feedback feilmelding">
                            <span>Du har ikke nok penger.</span> 
                        </div>';
                    } else {
                        $query = "INSERT into `cars` (acc_id, car_id, city, km)
                        VALUES ('".$ID."', '".$row_buy['car_type']."', '".$row_buy['city']."', '".$row_buy['km']."')";
                        $result = mysqli_query($con, $query);
                        
                        $result = "UPDATE accounts SET money = (money - ".$row_buy['price'].") WHERE ID='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                        
                        $result = "UPDATE accounts SET bank_money = (bank_money + ".$price_staten.") WHERE ID='".$row_buy['acc_id']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                        
                        $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
                        VALUES ('$ID', '8', 'Fynn - kjop_bilID: ".$car_type." - pris: ".$price_staten."', '$money', '$bank_money', '".time()."')";
                        $result = mysqli_query($con, $query);

                        $query = "INSERT into `varsel` (acc_id, text, date)
                        VALUES ('".$row_buy['acc_id']."', 'Du solgte en bil på fynn.no og du får dermed ".number($price_staten)." kr, pengene er i banken.', '".time()."')";
                        $result = mysqli_query($con, $query);
                        
                        $del = mysqli_query($con, "DELETE FROM fynn WHERE ID = '".$_GET['buy']."'") or die(mysqli_error());

                        header("Location: index.php?side=fynn&cars&baught");
                    }
                }
        
                if(isset($_GET['baught'])){
                    echo '<div class="feedback velykket">
                        <span>Bilen ble kjøpt!</span> 
                    </div>';
                }
        
                if(isset($_GET['remove'])){
                    $sql = "SELECT * FROM fynn WHERE ID='".$_GET['remove']."'";
                    $query = mysqli_query($con, $sql) or die (mysqli_error());
                    $row_remove = mysqli_fetch_assoc($query);
                    
                    if($row_remove['acc_id'] != $ID){
                        echo '<div class="feedback feilmelding">
                            <span>Du kan kun fjerne dine egne ting.</span> 
                        </div>';
                    } else {
                        $query = "INSERT into `cars` (acc_id, car_id, city, km)
                        VALUES ('".$row_remove['acc_id']."', '".$row_remove['car_type']."', '".$row_remove['city']."', '".$row_remove['km']."')";
                        $result = mysqli_query($con, $query);
                        
                        $del = mysqli_query($con, "DELETE FROM fynn WHERE ID = '".$_GET['remove']."'") or die(mysqli_error());

                        header("Location: index.php?side=fynn&cars&removed");
                    }
                }

                if(isset($_GET['removed'])){
                    echo '<div class="feedback velykket">
                        <span>Bilen ble fjernet og den er nå i din garasje.</span> 
                    </div>';
                }
            
            
            ?>
        </table>
        <div class="header" style="border-top: 1px solid #2c2c2c">
            <span>Legg bil ut på markedet</span>
        </div>
        <div class="pad_10" style="padding-top: 0;">
            <form method="post">
                <p style="margin-bottom: 4px;">Velg bil</p>
                <select style="width: auto;" name="car_id" required>
                    <?php
                        $result_garage = mysqli_query($con, "SELECT * FROM cars WHERE acc_id='$ID'");
                    while($row_garage = mysqli_fetch_assoc($result_garage)) {

                        $id_ =          $row_garage['ID'];
                        $car_id =       $row_garage['car_id'];
                        $km =           $row_garage['km'];
                        $city_car =     $row_garage['city'];

                    ?>
                    <option value="<?php echo $id_ ?>"><?php echo $car[$car_id]; ?> i <?php echo $city_name[$city_car]; ?> (km: <?php echo number($km); ?>)</option>
                    <?php } ?>
                </select>

                <p style="margin-bottom: 4px;">Velg pris</p>
                <input type="text" name="price_car" id="number" style="width: 40%" placeholder="Pris" required>
                <input type="submit" name="sell" style="width: auto;" value="Legg ut for salg">
                <p>10% av summen går til fynn.no i gebyr ved salgt</p>
            </form>
        </div>

        <?php } elseif(isset($_GET['property'])){ ?>
        
        
        
        <table border="0" cellspacing="0" cellpadding="0">
            <tr style="height: 30px;">
                <th style="padding-left: 15px; width: 50%;">Eiendel</th>
                <th style="width: 20%;">Pris</th>
                <th style="width: 15%;">By</th>
                <th style="width: 15%;"></th>
            </tr>
            <?php 
                
                $result_property = mysqli_query($con, "SELECT * FROM fynn WHERE cat = 1");

                $i = 0;
                while($row_property = mysqli_fetch_assoc($result_property)) {
                    
                    $property_fynn_ID =          $row_property['ID'];
                    $property_fynn_price =       $row_property['price'];
                    $property_fynn_city =        $row_property['city'];
                    $property_fynn_acc_id =      $row_property['acc_id'];

                    $i++;
                    
                ?>
            <tr style="height: 30px;">
                <td style="padding-left: 15px; width: 25%;">Kulefabrikk</td>
                <td><?php echo number($property_fynn_price); ?></td>
                <td><?php echo $city_name[$property_fynn_city]; ?></td>
                <td><?php if($property_fynn_acc_id == $ID){ ?>
                    <a class="no link_as_button" style="text-align: right;" href="index.php?side=fynn&property&remove=<?php echo $property_fynn_ID ?>">Fjern</a>
                <?php } else { ?>
                    <a class="link_as_button" style="text-align: right;" href="index.php?side=fynn&property&buy=<?php echo $property_fynn_ID ?>">Kjøp</a>
                <?php } ?>
                </td>
            </tr>
            <?php }  
        
                if($i == 0){
                    echo '<center><span style="color: orange">Det er ingen eiendeler på markedet!</span></center>'; 
                } 

                if(isset($_POST['sell'])){
                    if($_POST['price_property'] > 99999999999){
                        echo '<div class="feedback feilmelding">
                            <span>Prisen kan ikke være høyere enn 99 999 999 999</span> 
                        </div>';
                    } elseif($_POST['price_property'] < 0){
                        echo '<div class="feedback feilmelding">
                            <span>Prisen kan ikke være mindre enn 0kr</span> 
                        </div>';
                    } else {
                        $sql = "SELECT * FROM kf WHERE ID='".$_POST['kf_id']."'";
                        $query = mysqli_query($con, $sql) or die (mysqli_error());
                        $row_property = mysqli_fetch_assoc($query);

                        $property_city = $row_property['city'];

                        $price = preg_replace('/\s+/', '', $_POST['price_property']);

                        $date = time() + 43200;

                        $del = mysqli_query($con, "DELETE FROM kf WHERE ID = '".$_POST['kf_id']."'") or die(mysqli_error());
                        
                        $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
                        VALUES ('$ID', '8', 'Fynn - salg_kf_by: ".$property_city." - pris: ".$price."', '$money', '$bank_money', '".time()."')";
                        $result = mysqli_query($con, $query);

                        $query = "INSERT into `fynn` (acc_id, price, cat, city, date)
                        VALUES ('$ID', '$price', '1', '$property_city', '$date')";
                        $result = mysqli_query($con, $query);

                        header("Location: index.php?side=fynn&property&sell_prop");
                    }
                }
        
                if(isset($_GET['buy'])){
                    $sql = "SELECT * FROM fynn WHERE ID='".$_GET['buy']."'";
                    $query = mysqli_query($con, $sql) or die (mysqli_error());
                    $row_buy = mysqli_fetch_assoc($query);
                    
                    $price_staten = $row_buy['price'] * 0.9;
                    
                    if($row_buy['acc_id'] == $ID){
                        echo '<div style="width: 97%" class="feedback feilmelding">
                            <span>Du kan ikke kjøpe din egne ting.</span> 
                        </div>';
                    } elseif($row_buy['price'] > $money){
                        echo '<div style="width: 97%" class="feedback feilmelding">
                            <span>Du har ikke nok penger.</span> 
                        </div>';
                    } else {
                        $query = "INSERT into `kf` (owner, price, bullets, city)
                        VALUES ('".$ID."', '6000000', '0', '".$row_buy['city']."')";
                        $result = mysqli_query($con, $query);
                        
                        $result = "UPDATE accounts SET money = (money - ".$row_buy['price'].") WHERE ID='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                        
                        $result = "UPDATE accounts SET bank_money = (bank_money + ".$price_staten.") WHERE ID='".$row_buy['acc_id']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                        
                        $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
                        VALUES ('$ID', '8', 'Fynn - kjop_kfBy: ".$row_buy['city']." - pris: ".$price_staten."', '$money', '$bank_money', '".time()."')";
                        $result = mysqli_query($con, $query);

                        $query = "INSERT into `varsel` (acc_id, text, date)
                        VALUES ('".$row_buy['acc_id']."', 'Du solgte en eiendel på fynn.no og du får dermed ".number($price_staten)." kr, pengene er i banken.', '".time()."')";
                        $result = mysqli_query($con, $query);
                        
                        $del = mysqli_query($con, "DELETE FROM fynn WHERE ID = '".$_GET['buy']."'") or die(mysqli_error());

                        header("Location: index.php?side=fynn&property&baught");
                    }
                }
        
                if(isset($_GET['baught'])){
                    echo '<div class="feedback velykket">
                        <span>Eiendelen ble kjøpt!</span> 
                    </div>';
                }
        
                if(isset($_GET['remove'])){
                    $sql = "SELECT * FROM fynn WHERE ID='".$_GET['remove']."'";
                    $query = mysqli_query($con, $sql) or die (mysqli_error());
                    $row_remove = mysqli_fetch_assoc($query);
                    
                    if($row_remove['acc_id'] != $ID){
                        echo '<div class="feedback feilmelding">
                            <span>Du kan kun fjerne dine egne ting.</span> 
                        </div>';
                    } else {
                        $query = "INSERT into `kf` (owner, price, bullets, city)
                        VALUES ('".$row_remove['acc_id']."', '6000000', '0', '".$row_remove['city']."')";
                        $result = mysqli_query($con, $query);
                        
                        $del = mysqli_query($con, "DELETE FROM fynn WHERE ID = '".$_GET['remove']."'") or die(mysqli_error());

                        header("Location: index.php?side=fynn&property&removed");
                    }
                }

                if(isset($_GET['removed'])){
                    echo '<div class="feedback velykket">
                        <span>Eiendelen ble fjernet og du er nå eieren av eiendelen.</span> 
                    </div>';
                }
            
            ?>
        </table>
        <div class="header" style="border-top: 1px solid #2c2c2c">
            <span>Legg eiendel ut på markedet</span>
        </div>
        <div class="pad_10" style="padding-top: 0;">
            <form method="post">
                <center><br><i style="color: red;" class="fas fa-exclamation-triangle"></i> OBS! Når du legger ut KF så fjernes alt av kuler i fabrikken <i style="color: red;" class="fas fa-exclamation-triangle"></i></center>
                <p style="margin-bottom: 4px;">Velg eiendel</p>
                <select style="width: auto;" name="kf_id" required>
                    <?php
                        $result_eiendel = mysqli_query($con, "SELECT * FROM kf WHERE owner='$ID'");
                    while($row_eiendel = mysqli_fetch_assoc($result_eiendel)) {

                        $id_ =              $row_eiendel['ID'];
                        $city_eiendel =     $row_eiendel['city'];

                    ?>
                    <option value="<?php echo $id_ ?>">Kulefabrikk i <?php echo $city_name[$city_eiendel]; ?></option>
                    <?php } ?>
                </select>

                <p style="margin-bottom: 4px;">Velg pris</p>
                <input type="text" name="price_property" id="number" style="width: 40%" placeholder="Pris" required>
                <input type="submit" name="sell" style="width: auto;" value="Legg ut for salg">
                <p>10% av summen går til fynn.no i gebyr ved salgt</p>
            </form>
        </div>

            

        <?php } elseif(isset($_GET['bullets'])){ ?>

        
        <?php 
                                                
        $check_priv = mysqli_query($con, "SELECT * FROM fynn WHERE cat = 2 AND (city = '$username' OR acc_id = '$ID')"); 
        if(mysqli_num_rows($check_priv) > 0) {
            
        $result_bullets_private = mysqli_query($con, "SELECT * FROM fynn WHERE cat = 2 AND (city = '$username' OR acc_id = '$ID')");
            
        ?>
        
        <div class="header">
            <span>Private / dine tilbud</span>
        </div>
        
        <table border="0" cellspacing="0" cellpadding="0">
            <tr style="height: 30px;">
                <th style="padding-left: 15px; width: 25%;">Antall kuler</th>
                <th style="width: 30%;">Pris</th>
                <th style="width: 15%;">Pris pr kule</th>
                <th style="width: 15%;">Kjøper</th>
                <th style="width: 15%;"></th>
            </tr>
            <?php 

                $i = 0;
                while($row_bullets_private = mysqli_fetch_assoc($result_bullets_private)) {
                    
                    $bullets_fynn_ID =          $row_bullets_private['ID'];
                    $bullets_fynn_price =       $row_bullets_private['price'];
                    $bullets_fynn_acc_id =      $row_bullets_private['acc_id'];
                    $bullets_fynn_km =          $row_bullets_private['km'];

                    $i++;
                    
                ?>
            <tr style="height: 30px;">
                <td style="padding-left: 15px; width: 25%;"><?php echo number($bullets_fynn_km); ?></td>
                <td><?php echo number($bullets_fynn_price); ?> kr</td>
                <td><?php echo number($bullets_fynn_price / $bullets_fynn_km); ?> kr</td>
                <td><?php if($row_bullets_private['city'] == null){ echo 'Alle'; } else { echo $row_bullets_private['city']; } ?></td>
                <td><?php if($bullets_fynn_acc_id == $ID){ ?>
                    <a class="no link_as_button" style="text-align: right;" href="index.php?side=fynn&bullets&remove=<?php echo $bullets_fynn_ID ?>">Fjern</a>
                <?php } else { ?>
                    <a class="link_as_button" style="text-align: right;" href="index.php?side=fynn&bullets&buy=<?php echo $bullets_fynn_ID ?>">Kjøp</a>
                <?php } ?>
                </td>
            </tr>
            
        <?php 
                } 
        }                              
            ?>
        </table>
        
        <table border="0" cellspacing="0" cellpadding="0">
            <tr style="height: 30px;">
                <th style="padding-left: 15px; width: 25%;">Antall kuler</th>
                <th style="width: 30%;">Pris</th>
                <th style="width: 30%;">Pris pr kule</th>
                <th style="width: 15%;"></th>
            </tr>
            <?php 
                
                $result_bullets = mysqli_query($con, "SELECT * FROM fynn WHERE cat = 2 AND city IS NULL OR city = ''");

                $i = 0;
                while($row_bullets = mysqli_fetch_assoc($result_bullets)) {
                    
                    $bullets_fynn_ID =          $row_bullets['ID'];
                    $bullets_fynn_price =       $row_bullets['price'];
                    $bullets_fynn_acc_id =      $row_bullets['acc_id'];
                    $bullets_fynn_km =          $row_bullets['km'];

                    $i++;
                    
                ?>
            <tr style="height: 30px;">
                <td style="padding-left: 15px; width: 25%;"><?php echo number($bullets_fynn_km); ?></td>
                <td><?php echo number($bullets_fynn_price); ?> kr</td>
                <td><?php echo number($bullets_fynn_price / $bullets_fynn_km); ?> kr</td>
                <td><?php if($bullets_fynn_acc_id == $ID){ ?>
                    <a class="no link_as_button" style="text-align: right;" href="index.php?side=fynn&bullets&remove=<?php echo $bullets_fynn_ID ?>">Fjern</a>
                <?php } else { ?>
                    <a class="link_as_button" style="text-align: right;" href="index.php?side=fynn&bullets&buy=<?php echo $bullets_fynn_ID ?>">Kjøp</a>
                <?php } ?>
                </td>
            </tr>
            <?php }  
        
                if($i == 0){
                    echo '<center><span style="color: orange">Det er ingen kuler på markedet!</span></center>'; 
                } 

                if(isset($_POST['sell'])){
                    $price_bullets =    preg_replace('/\s+/', '', $_POST['price_bullets']);
                    $ant_bullets =      preg_replace('/\s+/', '', $_POST['ant_bullets']);
                    
                    $check_max = mysqli_query($con, "SELECT * FROM fynn WHERE acc_id = $ID");

                    if(mysqli_num_rows($check_max) > 4) {
                        echo '<div class="feedback feilmelding">
                            <span>Du kan max ha 5 ting om gangen ute på fynn.no</span> 
                        </div>';
                    } else {
                        if($price_bullets > 99999999999){
                            echo '<div class="feedback feilmelding">
                                <span>Prisen kan ikke være høyere enn 99 999 999 999</span> 
                            </div>';
                        } elseif($ant_bullets > $bullets_mine) {
                            echo '<div class="feedback feilmelding">
                                <span>Du kan ikke selge flere kuler enn du har.</span> 
                            </div>';
                        } elseif($price_bullets < 0){
                            echo '<div class="feedback feilmelding">
                                <span>Prisen kan ikke være mindre enn 0kr</span> 
                            </div>';
                        } elseif($ant_bullets <= 0){
                            echo '<div class="feedback feilmelding">
                                <span>Du må selge minst 1 kule</span> 
                            </div>';
                        } else {
                            $date = time() + 43200;

                            $result = "UPDATE accounts SET bullets = (bullets - ".$ant_bullets.") WHERE ID='".$_SESSION['ID']."'";
                            mysqli_query($con, $result) or die("Bad query: $result");

                            if(isset($_POST['username_private'])){
                                $query = "INSERT into `fynn` (acc_id, price, cat, km, date, city)
                                VALUES ('$ID', '$price_bullets', '2', '$ant_bullets', '$date', '".$_POST['username_private']."')";
                                $result = mysqli_query($con, $query);
                            } else {
                                $query = "INSERT into `fynn` (acc_id, price, cat, km, date)
                                VALUES ('$ID', '$price_bullets', '2', '$ant_bullets', '$date')";
                                $result = mysqli_query($con, $query);
                            }
                            
                            $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
                            VALUES ('$ID', '8', 'Fynn - kuler_salgAMOUNT: ".$ant_bullets." - pris: ".$price_bullets."', '$money', '$bank_money', '".time()."')";
                            $result = mysqli_query($con, $query);

                            header("Location: index.php?side=fynn&bullets&sell_bullets");
                        }
                    }
                }
        
                if(isset($_GET['buy'])){
                    $sql = "SELECT * FROM fynn WHERE ID='".$_GET['buy']."'";
                    $query = mysqli_query($con, $sql) or die (mysqli_error());
                    $row_buy = mysqli_fetch_assoc($query);
                    
                    $price_staten = $row_buy['price'] * 0.9;
                    
                    if($row_buy['acc_id'] == $ID){
                        echo '<div style="width: 97%" class="feedback feilmelding">
                            <span>Du kan ikke kjøpe din egne ting.</span> 
                        </div>';
                    } elseif($row_buy['price'] > $money){
                        echo '<div style="width: 97%" class="feedback feilmelding">
                            <span>Du har ikke nok penger.</span> 
                        </div>';
                    } else {
                        $result = "UPDATE accounts SET bullets = (bullets + ".$row_buy['km'].") WHERE ID='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                        
                        $result = "UPDATE accounts SET money = (money - ".$row_buy['price'].") WHERE ID='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                        
                        $result = "UPDATE accounts SET bank_money = (bank_money + ".$price_staten.") WHERE ID='".$row_buy['acc_id']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        $query = "INSERT into `varsel` (acc_id, text, date)
                        VALUES ('".$row_buy['acc_id']."', 'Du solgte kuler på fynn.no og du får dermed ".number($price_staten)." kr, pengene er i banken.', '".time()."')";
                        $result = mysqli_query($con, $query);
                        
                        $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
                        VALUES ('$ID', '8', 'Fynn - kuler_kjopAMOUNT: ".$row_buy['km']." - pris: ".$price_staten."', '$money', '$bank_money', '".time()."')";
                        $result = mysqli_query($con, $query);
                        
                        $del = mysqli_query($con, "DELETE FROM fynn WHERE ID = '".$_GET['buy']."'") or die(mysqli_error());

                        header("Location: index.php?side=fynn&bullets&baught");
                    }
                }
        
                if(isset($_GET['baught'])){
                    echo '<div class="feedback velykket">
                        <span>kuler ble kjøpt!</span> 
                    </div>';
                }
        
                if(isset($_GET['remove'])){
                    $sql = "SELECT * FROM fynn WHERE ID='".$_GET['remove']."'";
                    $query = mysqli_query($con, $sql) or die (mysqli_error());
                    $row_remove = mysqli_fetch_assoc($query);
                    
                    if($row_remove['acc_id'] != $ID){
                        echo '<div class="feedback feilmelding">
                            <span>Du kan kun fjerne dine egne ting.</span> 
                        </div>';
                    } else {
                        $result = "UPDATE accounts SET bullets = (bullets + ".$row_remove['km'].") WHERE ID='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                        
                        $del = mysqli_query($con, "DELETE FROM fynn WHERE ID = '".$_GET['remove']."'") or die(mysqli_error());

                        header("Location: index.php?side=fynn&bullets&removed_bullets");
                    }
                }

                if(isset($_GET['removed_bullets'])){
                    echo '<div class="feedback velykket">
                        <span>Kulene ble fjernet fra fynn.no.</span> 
                    </div>';
                }
            
            ?>
        </table>
        <div class="header" style="border-top: 1px solid #2c2c2c">
            <span>Legg kuler ut på markedet</span>
        </div>
        <div class="pad_10" style="padding-top: 0;">
            <form method="post">
                <p style="margin-bottom: 4px;"><b>Privat tilbud</b><span style="color: #3e3e3e;"><br>Dersom du skal selge til 1 spesifikk person skriver du brukernavnet til spilleren her.<br>La det stå blankt dersom tilbudet skal være åpent for alle.</span></p>
                <input type="text" name="username_private" style="width: 40%" placeholder="Brukernavn">
                
                <p style="margin-bottom: 4px;">Antall kuler</p>
                <input type="text" name="ant_bullets" id="number" style="width: 40%" placeholder="Antall kuler" required>

                <p style="margin-bottom: 4px;">Velg totalpris <span style="color: #3e3e3e;">(ikke pris pr kule)</span></p>
                <input type="text" name="price_bullets" id="number2" style="width: 40%" placeholder="Pris" required>
                <input type="submit" name="sell" style="width: auto;" value="Legg ut for salg">
                <p>10% av summen går til fynn.no i gebyr ved salgt</p>

            </form>
        </div>

    <?php } else { ?>
        <a style="text-decoration: none; color: grey;" href="index.php?side=fynn&cars">
            <div class="fax" style="width: 28%; float: left; height: 70px; padding: 10px;">
                <center><i style="font-size: 55px;" class="fas fa-car"></i><br>
                    Biler</center>
            </div>
        </a>
        <a style="text-decoration: none; color: grey;" href="index.php?side=fynn&property">
            <div class="fax" style="width: 28%; float: left; height: 70px; padding: 10px;">
                <center><i style="font-size: 55px;" class="fas fa-industry"></i><br>
                    Eiendeler</center>
            </div>
        </a>
        <a style="text-decoration: none; color: grey;" href="index.php?side=fynn&bullets">
            <div class="fax" style="width: 28%; float: left; height: 70px; padding: 10px;">
                <center><i style="font-size: 55px;" class="fas fa-bullseye"></i><br>
                    Kuler</center>
            </div>
        </a>
        <?php } ?>
    </div>
</body>

</html>
<?php 

}

?>

<style>
    .fax:hover {
        color: #009fe3;
        cursor: pointer;
    }
</style>

<script>

$('#number').on("keyup", function() {
    this.value = this.value.replace(/ /g,'');
    var number = this.value;
    this.value = number.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
});
    
$('#number2').on("keyup", function() {
    this.value = this.value.replace(/ /g,'');
    var number = this.value;
    this.value = number.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
});
</script>