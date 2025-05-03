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

<head></head>

<body>
    <div class="breadcrumb">
        <span style="color: #3e3e3e;">Diverse » </span><span style="color: #afafaf;">Garasje</span>
        <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
    </div>
    <?php
    
            if(isset($_POST['melt_all'])){
                
                $bullets = 0;
                $tot_price = 0;
                $i = 0;

                $result_garage = mysqli_query($con, "SELECT * FROM cars WHERE acc_id='$ID' AND city = '$city'");
                while($row_garage = mysqli_fetch_assoc($result_garage)) {
                    $id_ = $row_garage['ID'];
                    $car_id = $row_garage['car_id'];
                    
                    $i++;
                    
                    $tot_price = ($tot_price + $car_price[$car_id]);
                    $bullets = floor($tot_price / 3000000);

                    $del = mysqli_query($con, "DELETE FROM cars WHERE ID = '".$id_."' AND city = '$city'") or die(mysqli_error()); 
                }
                
                $give_bullets = mysqli_query($con, "UPDATE accounts SET bullets = (bullets + $bullets) WHERE ID='$ID'") or die (mysqli_error($con));
                
                $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
                VALUES ('$ID', '7', 'Smelt alle biler - Kuler: ".$bullets."', '$money', '$bank_money', '".time()."')";
                $result = mysqli_query($con, $query);
                
                if($i == 0){
                    header("Location: index.php?side=garasje&melt&melt_all=0");
                } else {
                    header("Location: index.php?side=garasje&melt&melt_all=".$bullets."");
                }
            }
    
            if(isset($_POST['melt_chosen'])){
                $name = $_POST['cars'];
                
                $bullets = 0;
                $i = 0;
                $tot_price = 0;
                
                foreach ($name as $cars){
                    $result_garage = mysqli_query($con, "SELECT * FROM cars WHERE ID='$cars'");
                    while($row_garage = mysqli_fetch_assoc($result_garage)) {
                        $id_ = $row_garage['ID'];
                        $car_id = $row_garage['car_id'];
                        $km = $row_garage['km'];

                        $i++;

                        $tot_price = ($tot_price + $car_price[$car_id]);
                        $bullets = floor($tot_price / 3000000);


                        $del = mysqli_query($con, "DELETE FROM cars WHERE ID = '".$id_."'") or die(mysqli_error()); 
                    }
                }

                $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
                VALUES ('$ID', '7', 'Smelt valgte biler - Kuler: ".$bullets."', '$money', '$bank_money', '".time()."')";
                $result = mysqli_query($con, $query);
                
                $give_cash = mysqli_query($con, "UPDATE accounts SET bullets= (bullets + $bullets) WHERE ID='$ID'") or die (mysqli_error($con));
                header("Location: index.php?side=garasje&melt&melt_chosen=".$bullets."");
            }
            
            if(isset($_POST['sell_all'])){
                
                $tot_price = 0;
                $i = 0;

                $result_garage = mysqli_query($con, "SELECT * FROM cars WHERE acc_id='$ID' AND city = '$city'");
                while($row_garage = mysqli_fetch_assoc($result_garage)) {
                    $id_ = $row_garage['ID'];
                    $car_id = $row_garage['car_id'];
                    $km = $row_garage['km'];
                    
                    $i++;
                    
                    $tot_price = ($tot_price + $car_price[$car_id]);

                    $del = mysqli_query($con, "DELETE FROM cars WHERE ID = '".$id_."' AND city = '$city'") or die(mysqli_error()); 
                }
                
                if($oppdrag == 25 && $city == 4){
                    $result = "UPDATE oppdrag SET value = ($value + $tot_price) WHERE acc_id='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                }
                
                if($oppdrag == 28 && $city == 4){
                    $result = "UPDATE oppdrag SET value = (value + $i) WHERE acc_id='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                }
                
                if($oppdrag == 33 && $city == 2){
                    $result = "UPDATE oppdrag SET value = ($value + $tot_price) WHERE acc_id='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                }

                $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
                VALUES ('$ID', '7', 'Selg alle biler - penger: ".$tot_price."', '$money', '$bank_money', '".time()."')";
                $result = mysqli_query($con, $query);
                
            $give_cash = mysqli_query($con, "UPDATE accounts SET money= ($money + $tot_price) WHERE ID='$ID'") or die (mysqli_error($con));
                
                if($i == 0){
                    header("Location: index.php?side=garasje&sell_all=0");
                } else {
                    header("Location: index.php?side=garasje&sell_all=".$tot_price."");
                }
            }
            
            if(isset($_POST['sell_chosen'])){
                $name = $_POST['cars'];
                
                $i = 0;
                $tot_price = 0;
                
                foreach ($name as $cars){
                    $result_garage = mysqli_query($con, "SELECT * FROM cars WHERE ID='$cars'");
                    while($row_garage = mysqli_fetch_assoc($result_garage)) {
                        $id_ = $row_garage['ID'];
                        $car_id = $row_garage['car_id'];
                        $km = $row_garage['km'];

                        $i++;

                        $tot_price = ($tot_price + $car_price[$car_id]);

                        $del = mysqli_query($con, "DELETE FROM cars WHERE ID = '".$id_."'") or die(mysqli_error()); 
                    }
                }
                
                if($oppdrag == 28 && $city == 4){
                    $result = "UPDATE oppdrag SET value = (value + $i) WHERE acc_id='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                }
                
                if($oppdrag == 25 && $city == 4){
                    $result = "UPDATE oppdrag SET value = ($value + $tot_price) WHERE acc_id='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                }

                $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
                VALUES ('$ID', '7', 'Selg valgte biler - penger: ".$tot_price."', '$money', '$bank_money', '".time()."')";
                $result = mysqli_query($con, $query);
                
                $give_cash = mysqli_query($con, "UPDATE accounts SET money= ($money + $tot_price) WHERE ID='$ID'") or die (mysqli_error($con));
                header("Location: index.php?side=garasje&sell_chosen=".$tot_price."");
            }
            
            if(isset($_GET['sell_all'])){
                if($_GET['sell_all'] == 0){
                    echo '<div class="feedback feilmelding">
                        <span><b>Feilmelding!</b> Du valgte ingen biler!</span> 
                    </div>';
                } else {
                    echo '<div class="feedback velykket">
                        <span><b>Vellykket!</b> Du solgte alle dine biler i '.$city_name[$city].' for '.number($_GET['sell_all']).' kr</span> 
                    </div>';
                }
            }
    
            if(isset($_GET['melt_all'])){
                if($_GET['melt_all'] == 0){
                    echo '<div class="feedback feilmelding">
                        <span><b>Feilmelding!</b> Du valgte ingen biler!</span> 
                    </div>';
                } else {
                    echo '<div class="feedback velykket">
                        <span><b>Vellykket!</b> Du smeltet dine biler i '.$city_name[$city].' og fikk '.number($_GET['melt_all']).' kuler</span> 
                    </div>';
                }
            }
    
            if(isset($_GET['melt_chosen'])){
                if($_GET['melt_chosen'] == 0){
                    echo '<div class="feedback feilmelding">
                        <span><b>Feilmelding!</b> Du valgte ingen biler!</span> 
                    </div>';
                } else {
                    echo '<div class="feedback velykket">
                        <span><b>Vellykket!</b> Du smeltet valgte biler for '.number($_GET['melt_chosen']).' kuler</span> 
                    </div>';
                }
            }
            
            if(isset($_GET['sell_chosen'])){
                if($_GET['sell_chosen'] == 0){
                    echo '<div class="feedback feilmelding">
                        <span><b>Feilmelding!</b> Du valgte ingen biler!</span> 
                    </div>';
                } else {
                    echo '<div class="feedback velykket">
                        <span><b>Vellykket!</b> Du solgte valgte biler for '.number($_GET['sell_chosen']).' kr</span> 
                    </div>';
                }
            }

        if(isset($_POST['import'])){
            if($money < 1000000){
                echo '<div class="feedback mislykket">
                    <span><b>Mislykket!</b> Du har ikke nok penger for å importere / eksportere denne bilen.</span>
                </div>';
            } else {
                
            $car_id_posted = $_POST['car_id'];
                
            $sql_car_leaf = "SELECT * FROM cars WHERE ID = '$car_id_posted'";
            $query_car_leaf = mysqli_query($con, $sql_car_leaf) or die (mysqli_error());
            $row_car_leaf = mysqli_fetch_assoc($query_car_leaf);

            $car_type = $row_car_leaf['car_id'];
            $car_km = $row_car_leaf['km'];
            $car_city = $row_car_leaf['city'];

            if($car_city != $_POST['city_chosen']){
                if($oppdrag == 7 && $city == 1){
                    if($car_type == 5 && $car_km < 40000 && $car_city == 1){
                        $result = "UPDATE oppdrag SET value = ($value + 1) WHERE acc_id='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                    }
                }

                $take_cash = mysqli_query($con, "UPDATE accounts SET money= ($money - 1000000) WHERE ID='$ID'") or die (mysqli_error($con));

                $import_car = mysqli_query($con, "UPDATE cars SET city = '".$_POST['city_chosen']."' WHERE ID='".$_POST['car_id']."'") or die (mysqli_error($con));

                header("Location: index.php?side=garasje&import");
            } else {
                echo '<div class="feedback mislykket">
                    <span><b>Mislykket!</b> Bilen er allerede i valgt by.</span>
                </div>';
            }
            }
        }       
 
    if(isset($_GET['import'])){
        echo '<div class="feedback velykket">
            <span><b>Vellykket!</b> Bilen ble flyttet til valgt by, det kostet deg 1 millioner kroner.</span> 
        </div>';
    }
            
            ?>
    <div class="content">
        <div class="tab">
            <button style="width: 34%;" class="tablinks pad_10" onclick="openTab(event, 'garasje')" <?php if(!isset($_GET['import'])){ ?> id="defaultOpen" <?php } ?>>Garasjen i <?php echo $city_name[$city] ?></button>
            <button style="width: 33%;" class="tablinks pad_10" onclick="openTab(event, 'import')"<?php if(isset($_GET['import'])){ ?> id="defaultOpen" <?php } ?>>Import / eksport</button>
            <button style="width: 33%;" class="tablinks pad_10" onclick="openTab(event, 'melt')" <?php if(!isset($_GET['melt'])){ ?> id="defaultOpen" <?php } ?>>Smelt biler</button>

        </div>

        <div id="garasje" class="tabcontent">
            <img src="img/action/garasje.png" style="width: 100%; height: auto;">
            <form method="POST" action="">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr style="height: 30px;">
                        <th style="width: 5%; margin-top: -20px !important;">
                            <label class="radio_container">
                                <input id="selectAll" type="checkbox">
                                <span style="margin-top: -10px !important;" class="checkmark"></span>
                            </label>
                        </th>
                        <th style="width: 50%;">Bil</th>
                        <th style="width: 20%;">Km</th>
                        <th style="width: 30%">Verdi</th>
                    </tr>
                    <?php

                    $i = 0;
                    $tot_price = 0;
                  
                if(isset($_GET['pageno'])) {
                    $pageno = $_GET['pageno'];
                } else {
                    $pageno = 1;
                }
            
                $no_of_records_per_page = 15;
                $offset = ($pageno-1) * $no_of_records_per_page; 

                $total_pages_sql = "SELECT COUNT(*) FROM cars WHERE acc_id='$ID' AND city = '$city'";
                $result = mysqli_query($con, $total_pages_sql);
                $total_rows = mysqli_fetch_array($result)[0];
                $total_pages = ceil($total_rows / $no_of_records_per_page);

                    $result_garage = mysqli_query($con, "SELECT * FROM cars WHERE acc_id='$ID' AND city = '$city' ORDER BY ID DESC LIMIT $offset, $no_of_records_per_page");
                    while($row_garage = mysqli_fetch_assoc($result_garage)) {

                        $id_ = $row_garage['ID'];
                        $car_id = $row_garage['car_id'];
                        $km = $row_garage['km'];

                        $tot_price = ($tot_price + $car_price[$car_id]);

                        $i++;

                    ?>
                    <tr>
                        <td style="padding-bottom: 20px;">
                            <label class="radio_container">
                                <input type="checkbox" name='cars[]' value="<?php echo $id_ ?>">
                                <span class="checkmark"></span>
                            </label>
                        </td>
                        <td><?php echo $car[$car_id] ?></td>
                        <td><?php echo number($km); ?></td>
                        <td><?php echo number($car_price[$car_id]) ?> kr</td>
                    </tr>
                    <?php } ?>
                    <tr style="background-color: #1b1b1b;">
                        <th style="padding-bottom: 20px;">
                        </th>
                        <th>Totalt antall biler: <?php 
    
                    $total = 0;
                    $tot_price_total = 0;
                    $result_garage_total = mysqli_query($con, "SELECT * FROM cars WHERE acc_id='$ID' AND city = '$city' ORDER BY ID DESC");
                    while($row_garage_total = mysqli_fetch_assoc($result_garage_total)) {
                    $total++;
                        
                        $car_id_total = $row_garage_total['car_id'];

                        $tot_price_total = ($tot_price_total + $car_price[$car_id_total]);
                        
                    }
                        echo number($total); ?> 

                    biler</th>
                        <th></th>
                        <th style="height: 50px;">Total pris alle biler: <?php echo number($tot_price_total) ?> kr</th>
                    </tr>
                </table>
                <input style="width: 47.5%;" type="submit" name="sell_chosen" value="Selg valgte">
                <input style="width: 47.5%;" type="submit" name="sell_all" value="Selg Alle">
            </form>
            
    <?php
        $sikkerhet[0] = "Alarm";
        $effektivt[0] = 5;
        $pris[0] = 10000000;

        $sikkerhet[1] = "Strømgjerde";
        $effektivt[1] = 10;
        $pris[1] = 25000000;

        $sikkerhet[2] = "Kamera";
        $effektivt[2] = 15;
        $pris[2] = 75000000;

        $sikkerhet[3] = "Vakthund";
        $effektivt[3] = 30;
        $pris[3] = 125000000;

        $sikkerhet[4] = "Livvakt";
        $effektivt[4] = 40;
        $pris[4] = 225000000;
    
        $sql = "SELECT * FROM garage_security WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row_gs = mysqli_fetch_assoc($query);

        $gs_[0] =                   $row_gs['gs_0'];
        $gs_[1] =                   $row_gs['gs_1'];
        $gs_[2] =                   $row_gs['gs_2'];
        $gs_[3] =                   $row_gs['gs_3'];
        $gs_[4] =                   $row_gs['gs_4'];

        if(isset($_GET['security'])){
            echo '<div class="feedback velykket">
                <span>Valgt sikkerhet ble kjøpt.</span>
            </div>';
        }

        if(isset($_POST['buy_security'])){
            $security = $_POST['radioBtn'];
            
            if($gs_[$security] == 1){
                echo '<div class="feedback mislykket">
                    <span>Du har allerede denne.</span>
                </div>';
            } elseif($money < $pris[$security]) {
                echo '<div class="feedback mislykket">
                    <span>Du har ikke råd til denne typen sikkerhet.</span>
                </div>';
            } else {
                $result = mysqli_query($con, "UPDATE accounts SET money = ($money - $pris[$security]) WHERE ID='$ID'") or die (mysqli_error($con));
                
                $result = mysqli_query($con, "UPDATE garage_security SET gs_$security = '1' WHERE acc_id='$ID'") or die (mysqli_error($con));
                
                header("Location: index.php?side=garasje&security");
            }
        }
    
    ?>
    <div style="margin-top: 5px;" class="content">
        <div class="header">
            <span>Sikkerhet</span>
        </div>
        <center><p>For å unngå at folk stjeler dine biler burde du ha sikkerhet i din garasje.</p></center>
        <form method="POST" action="">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 30px;">
                    <th style="padding-left: 15px; width: 50%;">Sikkerhet</th>
                    <th style="width: 20%">Effektivitet</th>
                    <th style="width: 20%">Pris</th>
                    <th style="width: 10%"></th>
                </tr>
                <?php 

                for($i = 0; $i < 5; $i++){ 
                    
                    ?>
                <tr style="height: 25px;">
                    <td style="padding-left: 15px;"><?php echo $sikkerhet[$i] ?></td>
                    <td><?php echo $effektivt[$i] ?>%</td>
                    <td><?php echo number($pris[$i]); ?></td>
                    <td><?php if($gs_[$i] == 1){ echo 'Installert'; } else { ?>
                        <label class="radio_container" style="margin-top: -12px;">
                            <input type="radio" name='radioBtn' value="<?php echo $i ?>" required>
                            <span class="checkmark"></span>
                        </label>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </table>
            <?php if($gs_[0] == 1 && $gs_[1] == 1 && $gs_[2] == 1 && $gs_[3] == 1 && $gs_[4] == 1){ echo '<center><span style="color: #009fe3">Du har alle sikkerhetstiltakene</span></center>'; } else { ?>
            <input style="width: 97%;" type="submit" name="buy_security" value="Kjøp sikkerhet">
            <?php } ?>
        </form>
    </div>
        </div>

        <div id="import" class="tabcontent">

            <form method="post" action="">
                <img src="img/action/import.png" style="width: 100%; height: auto;">
                <div style="padding-left: 10px; word-wrap: break-word; margin-top: -15px; white-space: pre-line;" class="textbox">

                    <b>Her kan du importere og eksportere biler til ønsket by</b>
                    <b>Pris pr bil er 1 000 000kr</b>
                    <p style="padding-bottom: 0; margin-bottom: -25px;">Velg bil</p>

                    <select style="width: auto;" name="car_id">
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

                    <p style="padding-bottom: 0; margin-bottom: -10px;">Velg by du ønsker bilen i</p>
                    <select style="width: auto;" name="city_chosen">
                        <option value="0">Kristiansand</option>
                        <option value="1">Oslo</option>
                        <option value="2">Bergen</option>
                        <option value="3">Stavanger</option>
                        <option value="4">Tromsø</option>
                    </select>

                    <input style="margin-left: 0; margin-bottom: -10px; width: auto;" type="submit" name="import" value="Importer / eksporter bil">

                </div>
            </form>
        </div>
        
        <div id="melt" class="tabcontent">
            <img src="img/action/melt_cars.png" style="width: 100%; height: auto;">
            <div class="pad_10">
                Ved smelting av kuler vil den ta verdien til en bil / 3 000 000 så får du antall kuler som produseres. Om du velger en bil under 3 000 000 kr vil du ikke få noen kuler.
            </div>
            <form method="POST" action="">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr style="height: 30px;">
                        <th style="width: 5%; margin-top: -20px !important;">
                            <label class="radio_container">
                                <input id="selectAll" type="checkbox">
                                <span style="margin-top: -10px !important;" class="checkmark"></span>
                            </label>
                        </th>
                        <th style="width: 50%;">Bil</th>
                        <th style="width: 20%;">Km</th>
                        <th style="width: 30%">Verdi</th>
                    </tr>
                    <?php

                    $i = 0;
                    $tot_price = 0;
                  
                if(isset($_GET['pageno'])) {
                    $pageno = $_GET['pageno'];
                } else {
                    $pageno = 1;
                }
            
                $no_of_records_per_page = 15;
                $offset = ($pageno-1) * $no_of_records_per_page; 

                $total_pages_sql = "SELECT COUNT(*) FROM cars WHERE acc_id='$ID' AND city = '$city'";
                $result = mysqli_query($con, $total_pages_sql);
                $total_rows = mysqli_fetch_array($result)[0];
                $total_pages = ceil($total_rows / $no_of_records_per_page);

                    $result_garage = mysqli_query($con, "SELECT * FROM cars WHERE acc_id='$ID' AND city = '$city' ORDER BY ID DESC LIMIT $offset, $no_of_records_per_page");
                    while($row_garage = mysqli_fetch_assoc($result_garage)) {

                        $id_ = $row_garage['ID'];
                        $car_id = $row_garage['car_id'];
                        $km = $row_garage['km'];

                        $tot_price = ($tot_price + $car_price[$car_id]);
                        $bullets = floor($tot_price / 3000000);

                        $i++;

                    ?>
                    <tr>
                        <td style="padding-bottom: 20px;">
                            <label class="radio_container">
                                <input type="checkbox" name='cars[]' value="<?php echo $id_ ?>">
                                <span class="checkmark"></span>
                            </label>
                        </td>
                        <td><?php echo $car[$car_id] ?></td>
                        <td><?php echo number($km); ?></td>
                        <td><?php echo number($car_price[$car_id]) ?> kr</td>
                    </tr>
                    <?php } ?>
                    <tr style="background-color: #1b1b1b;">
                        <th style="padding-bottom: 20px;">
                        </th>
                        <th>Totalt antall biler: <?php 
    
                    $bullets = 0;

                    $total = 0;
                    $tot_price_total = 0;
                    $result_garage_total = mysqli_query($con, "SELECT * FROM cars WHERE acc_id='$ID' AND city = '$city' ORDER BY ID DESC");
                    while($row_garage_total = mysqli_fetch_assoc($result_garage_total)) {
                    $total++;
                        
                        $car_id_total = $row_garage_total['car_id'];

                        $tot_price_total = ($tot_price_total + $car_price[$car_id_total]);
                        
                        $bullets = floor($tot_price_total / 3000000);
                    }
                        echo number($total); ?> 

                    biler</th>
                        <th></th>
                        <th style="height: 50px;">Antall kuler: <?php echo number($bullets) ?></th>
                    </tr>
                </table>
                <input style="width: 47.5%;" type="submit" name="melt_chosen" value="Smelt valgte">
                <input style="width: 47.5%;" type="submit" name="melt_all" value="Smelt Alle">
            </form>
        </div>
    </div>
    <?php if($total_pages <= 1) { } else { ?>
    <div style="margin-top: 4px" class="content">
        <div class="pad_5 pagination">
            <div style="width: 20%; float: left;">
                <span><a href="index.php?side=garasje&pageno=1">«« Første side</a></span>
            </div>
            <div style="width: 20%; float: left;">
                <span class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                    <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "index.php?side=garasje&pageno=".($pageno - 1); } ?>">« Forrige side</a>
                </span>
            </div>
            <div style="width: 20%; float: left;">
                <span style="text-align: center;">Side <?php echo $pageno ?></span>
            </div>
            <div style="width: 20%; float: left;">
                <span class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                    <a style="float: right;" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "index.php?side=garasje&pageno=".($pageno + 1); } ?>">Neste side »</a>
                </span>
            </div>
            <div style="width: 20%; float: left;">
                <span><a style="float: right;" href="index.php?side=garasje&pageno=<?php echo $total_pages; ?>">Siste side »»</a></span>
            </div>
        </div>
    </div>
    <?php } ?>
</body>

</html>
<?php } ?>
<script>
    $("#selectAll").click(function() {
        $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
    });

    $("#submit-code").click(function() {
        $("div.output").html($("#txtarea").val().replace(/\n/g, "<br>"));
    });

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
