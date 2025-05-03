<?php 

if(!isset($_GET['side'])){
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else {

$car_name[1] = "Audi RS6";
$car_name[2] = "Ferrari 458 Italia";
$car_name[3] = "BMW M4";

$car_price[1] = "890000";
$car_price[2] = "1500000";
$car_price[3] = "790000";

$car_image[1] = 'background-image: url("img/cars/0.png")';
$car_image[2] = 'background-image: url("img/cars/1.png")';
$car_image[3] = 'background-image: url("img/cars/2.png")';

?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Handlinger » </span><span style="color: #afafaf;">Race club</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
<?php 
    
    if(isset($_POST['1'])){
        if($money < $car_price[1]){
            echo '<div class="feedback mislykket">
                <span>Du har ikke nok penger for å kjøpe '.$car_name[1].'</span> 
            </div>';
        } else {
            $result = "UPDATE accounts SET money = ($money - $car_price[1])WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $result = "UPDATE race_club SET car = 1, hk = 290 WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
        }
    } elseif(isset($_POST['2'])){
        if($money < $car_price[2]){
            echo '<div class="feedback mislykket">
                <span>Du har ikke nok penger for å kjøpe '.$car_name[2].'</span> 
            </div>';
        } else {
            $result = "UPDATE accounts SET money = ($money - $car_price[2]) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $result = "UPDATE race_club SET car = 2, hk = 390 WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
        }
    } elseif(isset($_POST['3'])){
        if($money < $car_price[3]){
            echo '<div class="feedback mislykket">
                <span>Du har ikke nok penger for å kjøpe '.$car_name[3].'</span> 
            </div>';
        } else {
            $result = "UPDATE accounts SET money = ($money - $car_price[3]) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $result = "UPDATE race_club SET car = 3, hk = 350 WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
        }
    }
    
    if(isset($_POST['buy_things'])){
        if($money < 1000000){
            echo '<div class="feedback mislykket">
                <span>Du har ikke nok penger for å opprette garasje!</span> 
            </div>';

        } else {
            $result = "UPDATE accounts SET money = ($money - 1000000) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
            VALUES ('$ID', '6', 'Opprette garasje', '$money', '$bank_money', '".time()."')";
            $result = mysqli_query($con, $query);
            
            $query = "INSERT into `race_club` (acc_id)
            VALUES ('$ID')";
            $result = mysqli_query($con, $query);
        }

    }
    
    if(isset($_POST['throw_car_parts'])){
        $name = $_POST['thing'];

        $i = 0;

        foreach ($name as $thing){
            $result_thing = mysqli_query($con, "SELECT * FROM mine_ting WHERE ID='$thing'");
            while($row_thing = mysqli_fetch_assoc($result_thing)) {
                $id_ = $row_thing['ID'];
                $i++;
                $del = mysqli_query($con, "DELETE FROM mine_ting WHERE ID = '".$id_."'") or die(mysqli_error()); 
            }
        }
        header("Location: index.php?side=raceclub&deler&del");
    }
    
    if(isset($_POST['use_all_engine_part'])){
        $result_things_engine = mysqli_query($con, "SELECT * FROM mine_ting WHERE acc_id='$ID' AND thing_id IN(0, 4, 5, 9, 13, 14, 18, 22, 23, 27, 31, 32)");
        while($row_things_engine = mysqli_fetch_assoc($result_things_engine)) {
            
            $id_ = $row_things_engine['ID'];
            $total_wear = (100 - $row_things_engine['wear']);

            $result = "UPDATE race_club SET engine = (engine + $total_wear) WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");

            $del = mysqli_query($con, "DELETE FROM mine_ting WHERE ID = '".$id_."'") or die(mysqli_error()); 

        }
            header("Location: index.php?side=raceclub&motor&bruk_all_motor");

    }
    
    if(isset($_POST['use_all_suspension_part'])){
        $result_things_suspension = mysqli_query($con, "SELECT * FROM mine_ting WHERE acc_id='$ID' AND thing_id IN(1, 2, 3, 10, 11, 12, 19, 20, 21, 28, 29, 30)");
        while($row_things_suspension = mysqli_fetch_assoc($result_things_suspension)) {
            
            $id_ = $row_things_suspension['ID'];
            $total_wear = (100 - $row_things_suspension['wear']);

            $result = "UPDATE race_club SET suspension = (suspension + $total_wear) WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");

            $del = mysqli_query($con, "DELETE FROM mine_ting WHERE ID = '".$id_."'") or die(mysqli_error()); 

        }
            header("Location: index.php?side=raceclub&suspension&bruk_all_suspension");

    }
    
    if(isset($_POST['use_all_tires_part'])){
        $result_things_tires = mysqli_query($con, "SELECT * FROM mine_ting WHERE acc_id='$ID' AND thing_id IN(6, 7, 8, 15, 16, 17, 24, 25, 26, 33, 34, 35)");
        while($row_things_tires = mysqli_fetch_assoc($result_things_tires)) {
            
            $id_ = $row_things_tires['ID'];
            $total_wear = (100 - $row_things_tires['wear']);

            $result = "UPDATE race_club SET tires = (tires + $total_wear) WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");

            $del = mysqli_query($con, "DELETE FROM mine_ting WHERE ID = '".$id_."'") or die(mysqli_error()); 

        }
        header("Location: index.php?side=raceclub&tires&bruk_all_tires");
    }
    
    
    
    if(isset($_POST['use_engine_part'])){
        $name = $_POST['thing'];

        foreach ($name as $thing){
            $result_thing = mysqli_query($con, "SELECT * FROM mine_ting WHERE ID='$thing'");
            while($row_thing = mysqli_fetch_assoc($result_thing)) {
                $id_ = $row_thing['ID'];
                $total_wear = (100 - $row_thing['wear']);
                
                $result = "UPDATE race_club SET engine = (engine + $total_wear)WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");

                $del = mysqli_query($con, "DELETE FROM mine_ting WHERE ID = '".$id_."'") or die(mysqli_error()); 
            }
        }
        header("Location: index.php?side=raceclub&motor&bruk");
    }
    
    if(isset($_POST['use_suspension_part'])){
        $name = $_POST['thing'];

        foreach ($name as $thing){
            $result_thing = mysqli_query($con, "SELECT * FROM mine_ting WHERE ID='$thing'");
            while($row_thing = mysqli_fetch_assoc($result_thing)) {
                $id_ = $row_thing['ID'];
                $total_wear = (100 - $row_thing['wear']);
                
                $result = "UPDATE race_club SET suspension = (suspension + $total_wear)WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");

                $del = mysqli_query($con, "DELETE FROM mine_ting WHERE ID = '".$id_."'") or die(mysqli_error()); 
            }
        }
        header("Location: index.php?side=raceclub&suspension&bruk");
    }
    
    if(isset($_POST['use_tires_part'])){
        $name = $_POST['thing'];

        foreach ($name as $thing){
            $result_thing = mysqli_query($con, "SELECT * FROM mine_ting WHERE ID='$thing'");
            while($row_thing = mysqli_fetch_assoc($result_thing)) {
                $id_ = $row_thing['ID'];
                $total_wear = (100 - $row_thing['wear']);
                
                $result = "UPDATE race_club SET tires = (tires + $total_wear)WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");

                $del = mysqli_query($con, "DELETE FROM mine_ting WHERE ID = '".$id_."'") or die(mysqli_error()); 
            }
        }
        header("Location: index.php?side=raceclub&tires&bruk");
    }
    
    if(isset($_GET['none'])){
        echo '<div class="feedback feilmelding">
            <span>Ingen andre racere ble funnet</span> 
        </div>';
    }

    if(isset($_POST['race'])){
        $sql_me = "SELECT * FROM race_club WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
        $query_me = mysqli_query($con, $sql_me) or die (mysqli_error());
        $row_me = mysqli_fetch_assoc($query_me);
        
        $total_power_me = $row_me['engine'] + $row_me['suspension'] + $row_me['tires']; 
        
        $sql_oponent = "SELECT * FROM race_club WHERE NOT acc_id = $ID ORDER BY RAND() LIMIT 1";
        $query_oponent = mysqli_query($con, $sql_oponent) or die (mysqli_error());
        $row_oponent = mysqli_fetch_assoc($query_oponent);
        
        if($row_oponent['acc_id'] == null){
            header("Location: index.php?side=raceclub&home&none");
        } else {
            $total_power_oponent = $row_oponent['engine'] + $row_oponent['suspension'] + $row_oponent['tires'];
            
            $chance = mt_rand(0, 10);
            
            if($happy_hour == 1){
                $raceclub_exp = 140 * 2;
            } elseif($role == 3){
                $raceclub_exp = 140 * 1.1;
            } else {
                $raceclub_exp = 140;
            }

            if($total_power_me < $total_power_oponent){
                $goliat = 1;
            } else {
                $goliat = 10;
            }
            
            $cooldown = 120 + time();
            
            if($goliat > $chance){
                if($oppdrag == 27 && $city == 4){
                    $result = "UPDATE oppdrag SET value = (value + 1) WHERE acc_id='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                }
                
                $result = "UPDATE accounts SET exp = (exp + $raceclub_exp) WHERE ID='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
                
                $result = "UPDATE daily_exp SET exp = (exp + $raceclub_exp) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
                
                $result = "UPDATE race_club SET vinn = (vinn + 1) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
                
                $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
                VALUES ('$ID', '6', 'Race vinn', '$money', '$bank_money', '".time()."')";
                $result = mysqli_query($con, $query);

                header("Location: index.php?side=raceclub&home&win&user=".$row_oponent['acc_id']."");
                
                
            } else {
                $result = "UPDATE accounts SET exp = (exp + $raceclub_exp) WHERE ID='".$row_oponent['acc_id']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
                
                $result = "UPDATE race_club SET tap = (tap + 1) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
                
                $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
                VALUES ('$ID', '6', 'Race tap', '$money', '$bank_money', '".time()."')";
                $result = mysqli_query($con, $query);

                header("Location: index.php?side=raceclub&home&loose&user=".$row_oponent['acc_id']."");
            }
            
            $result = "UPDATE race_club_cd SET race_club_status = '1', race_club_seconds = '$cooldown' WHERE acc_id='$ID'";
            mysqli_query($con, $result) or die("Bad query: $result");
        }
    }
    
    if(isset($_GET['selg_bil'])){
        $result = "UPDATE race_club SET car = 0 WHERE acc_id='".$ID."'";
        mysqli_query($con, $result) or die("Bad query: $result");
        
        header("Location: index.php?side=raceclub&home");
    }
    
    if(isset($_GET['loose'])){
        $sql_user = "SELECT * FROM accounts WHERE ID = '".$_GET['user']."'";
        $query_user = mysqli_query($con, $sql_user) or die (mysqli_error());
        $row_user = mysqli_fetch_assoc($query_user);
        
        echo '<div class="feedback feilmelding">
            <span>Du tapte racet mot ';
        echo $row_user['username'];
        echo '!</span> 
        </div>';
    } elseif(isset($_GET['win'])){
        $sql_user = "SELECT * FROM accounts WHERE ID = '".$_GET['user']."'";
        $query_user = mysqli_query($con, $sql_user) or die (mysqli_error());
        $row_user = mysqli_fetch_assoc($query_user);
        
        echo '<div class="feedback velykket">
            <span>Du vant racet mot ';
        echo $row_user['username'];
        echo '!</span> 
        </div>';
        
    }
    
    if(isset($_GET['del'])){
        echo '<div class="feedback velykket">
            <span>Valgte bildeler ble vraket</span> 
        </div>';
    }
    
    if(isset($_GET['bruk'])){
        echo '<div class="feedback velykket">
            <span>Deler ble brukt for å oppgradere bilen!</span> 
        </div>';
    }
    
    if(isset($_GET['bruk_all_motor'])){
        echo '<div class="feedback velykket">
            <span>Alle motordeler ble brukt for å oppgradere bilen!</span> 
        </div>';
    }
    
    if(isset($_GET['bruk_all_suspension'])){
        echo '<div class="feedback velykket">
            <span>Alle suspension deler ble brukt for å oppgradere bilen!</span> 
        </div>';
    }
    
    if(isset($_GET['bruk_all_tires'])){
        echo '<div class="feedback velykket">
            <span>Alle dekk deler ble brukt for å oppgradere bilen!</span> 
        </div>';
    }
    
?>
        <div class="content">
            <div class="header">
                <span>Race club</span>
            </div>
            <?php        
    
            $check_member = mysqli_query($con, "SELECT acc_id FROM race_club WHERE acc_id='".$_SESSION['ID']."'");

            if(mysqli_num_rows($check_member) > 0) {
                
                $sql = "SELECT * FROM race_club WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row_raceclub = mysqli_fetch_assoc($query);
                
                $car =          $row_raceclub['car'];
                $hk  =          $row_raceclub['hk'];
                $engine =       $row_raceclub['engine'];
                $suspension =   $row_raceclub['suspension'];
                $tires =        $row_raceclub['tires'];
                
                $vinn =         $row_raceclub['vinn'];
                $tap =          $row_raceclub['tap'];

            
            ?>
            <div class="tab">
                <button style="width: 20%;" class="tablinks pad_10" onclick="openTab(event, 'bil')"  <?php if(isset($_GET['home'])){ ?> id="defaultOpen" <?php } ?>>Min bil</button>
                <button style="width: 20%;" class="tablinks pad_10" onclick="openTab(event, 'deler')" <?php if(isset($_GET['deler'])){ ?> id="defaultOpen" <?php } ?>>Mine deler</button>
                <button style="width: 20%;" class="tablinks pad_10" onclick="openTab(event, 'motor')" <?php if(isset($_GET['motor'])){ ?> id="defaultOpen" <?php } ?>>Motor</button>
                <button style="width: 20%;" class="tablinks pad_10" onclick="openTab(event, 'suspension')" <?php if(isset($_GET['suspension'])){ ?> id="defaultOpen" <?php } ?>>Suspension</button>
                <button style="width: 20%;" class="tablinks pad_10" onclick="openTab(event, 'dekk')" <?php if(isset($_GET['tires'])){ ?> id="defaultOpen" <?php } ?>>Dekk</button>
            </div>
            
            <div id="bil" class="tabcontent">
                <?php if($car == 0) { ?>
                <p style="text-align: center;">Du har for tiden ingen bil. Velg bilen du ønsker å kjøpe.</p>
                
            <div class="role_container">
                <form method="POST" action="">
                <?php for($i = 1; $i < 4; $i++){ ?>
                <button name="<?php echo $i ?>" type="submit"> 
                    <div class="role_<?php echo $i ?>">
                        <style>
                            
                        .role_<?php echo $i ?> {
                            position: relative;
                            width: 160px;
                            height: 208px;
                            margin: 5px;
                            float: left;
                            display: inline-block;
                             transition: 0.3s;
                            border: 1px solid #2c2c2c;
                        }
                            
                        .role_<?php echo $i ?> {
                            <?php echo $car_image[$i] ?>
                        }


                        .role_<?php echo $i ?>:hover {
                            <?php echo $car_image[$i] ?>
                        }
                        </style>
                        <div class="header">
                            <span><?php echo $car_name[$i] ?></span>
                        </div>
                        <div class="role_footer">
                            <p style="margin: 0; padding: 5px">
                                <center><b>Pris: </b><?php echo number($car_price[$i]); ?> Kr</center>
                            </p>
                        </div>
                    </div>
                </button>
                <?php } ?>
                </form>
            </div>
                <?php } else { ?>
                    <div style="width: 40%; float: left;">
                    <div class="role_<?php echo $car ?>">
                        <style>
                            
                        .role_<?php echo $car ?> {
                            position: relative;
                            width: 160px;
                            height: 208px;
                            margin: 5px;
                            float: left;
                            display: inline-block;
                             transition: 0.3s;
                            border: 1px solid #2c2c2c;
                        }
                            
                        .role_<?php echo $car ?> {
                            <?php echo $car_image[$car] ?>
                        }

                        .role_<?php echo $car ?>:hover {
                            <?php echo $car_image[$car] ?>
                        }
                        </style>
                        <div class="header">
                            <span><?php echo $car_name[$car] ?></span>
                        </div>
                        <div class="role_footer">
                            <p style="margin: 0; padding: 5px">
                                <center><b>Hestekrefter: </b><?php echo number($hk); ?>hk</center><br>
                                <center><a class="link_as_button" href="index.php?side=raceclub&selg_bil" onclick="return confirm('Er du sikker på at du vil vrake bilen?');">Vrak bilen</a></center>
                            </p>
                        </div>
                    </div>
                    </div>

                <div style="width: 45%; float:right; padding: 25px;">
                    <form method="post">
                        <b>Race level: <?php echo floor(($total_power_me = $row_raceclub['engine'] + $row_raceclub['suspension'] + $row_raceclub['tires']) / 100); ?></b><br><br>
                        <div style="float: left; width: 50%">
                            <b style="color: green;">Vinn:</b> <?php echo number($vinn); ?><br><br><br>
                            <b>Motor:</b> <?php echo number($engine); ?><br><br>
                        </div>
                        <div style="float: right; width: 50%">
                        <div style="float: left; width: 100%">
                            <b style="color: orange;">Tap:</b> <?php echo number($tap); ?><br><br><br>
                            <b>Dekk:</b> <?php echo number($tires); ?><br><br>
                        </div>
                        </div>
                        <div style="float: right; width: 100%;">
                            <b>Suspension:</b> <?php echo number($suspension); ?><br><br>
                        </div><br><br><br><br><br><br><br><br><br>
                        <?php                 
                              
                        $sql = "SELECT * FROM race_club_cd WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
                        $query = mysqli_query($con, $sql) or die (mysqli_error());
                        $row_raceclub_cd = mysqli_fetch_assoc($query);
                              
                        if($row_raceclub_cd['race_club_status'] == 1){ ?>
                        <span>Du må vente <?php echo secondsToMinutes($row_raceclub_cd['race_club_seconds'] - time()); ?> før du kan race igjen</span>
                        <?php } else { ?>
                        <input type="submit" name="race" style="margin: 0;width: auto" value="Race">
                        <?php } ?>
                    </form>
                </div>
                <?php } ?>
            </div>
            <div id="deler" class="tabcontent pad_10">
                <form method="POST" action="">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr style="height: 30px;">
                            <th style="width: 5%; margin-top: -20px !important;">
                            </th>
                            <th style="width: 50%;">Objekt</th>
                            <th style="width: 20%;">Kategori</th>
                            <th style="width: 30%">Skade</th>
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

                    $total_pages_sql = "SELECT COUNT(*) FROM mine_ting WHERE acc_id='".$_SESSION['ID']."'";
                    $result = mysqli_query($con, $total_pages_sql);
                    $total_rows = mysqli_fetch_array($result)[0];
                    $total_pages = ceil($total_rows / $no_of_records_per_page);

                        $result_things = mysqli_query($con, "SELECT * FROM mine_ting WHERE acc_id='$ID' ORDER BY ID DESC LIMIT $offset, $no_of_records_per_page");
                        while($row_things = mysqli_fetch_assoc($result_things)) {

                            $id_ =          $row_things['ID'];
                            $wear =         $row_things['wear'];
                            $thing_id =     $row_things['thing_id'];

                            $i++;

                        ?>
                        <tr>
                            <td style="padding-bottom: 20px;">
                                <label class="radio_container">
                                    <input type="checkbox" name='thing[]' value="<?php echo $id_ ?>">
                                    <span class="checkmark"></span>
                                </label>
                            </td>
                            <td><?php echo $thing[$thing_id] ?></td>
                            <td></td>
                            <td><?php echo number($wear); ?>%</td>
                        </tr>
                        <?php } ?>
                    </table>
                    <input style="width: 47.5%;" type="submit" name="throw_car_parts" onclick="return confirm('Er du sikker på at du vil vrake bildelene?');" value="Kast bildel(er)">
                </form>
                
                <?php if($total_pages <= 1) { } else { ?>
                <div style="margin-top: 6px; margin-bottom: -5px; width: 99%;" class="content">
                    <div class="pad_5 pagination">
                        <div style="width: 30%; float: left;">
                            <span class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                                <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "index.php?side=raceclub&deler&pageno=".($pageno - 1); } ?>">« Forrige side</a>
                            </span>
                        </div>
                        <div style="width: 40%; float: left;">
                            <span style="text-align: center;">Side <?php echo $pageno ?></span>
                        </div>
                        <div style="width: 30%; float: left;">
                            <span class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                                <a style="float: right;" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "index.php?side=raceclub&deler&pageno=".($pageno + 1); } ?>">Neste side »</a>
                            </span>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div id="motor" class="tabcontent pad_10">
                <form method="POST" action="">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr style="height: 30px;">
                            <th style="width: 5%; margin-top: -20px !important;">
                            </th>
                            <th style="width: 50%;">Objekt</th>
                            <th style="width: 20%;">Kategori</th>
                            <th style="width: 30%">Skade</th>
                        </tr>
                        <?php

                    if(isset($_GET['pageno'])) {
                        $pageno_engine = $_GET['pageno'];
                    } else {
                        $pageno_engine = 1;
                    }

                    $no_of_records_per_page_engine = 15;
                    $offset_engine = ($pageno_engine - 1) * $no_of_records_per_page_engine; 
                    // 0, 4, 5, 9,  13, 14, 18, 22, 23, 27, 31, 32
                    $total_pages_sql_engine = "SELECT COUNT(*) FROM mine_ting WHERE acc_id='$ID' AND 
                    thing_id IN(0, 4, 5, 9, 13, 14, 18, 22, 23, 27, 31, 32)";
                    $result_engine = mysqli_query($con, $total_pages_sql_engine);
                    $total_rows_engine = mysqli_fetch_array($result_engine)[0];
                    $total_pages_engine = ceil($total_rows_engine / $no_of_records_per_page_engine);

                        $result_things_engine = mysqli_query($con, "SELECT * FROM mine_ting WHERE acc_id='$ID' AND thing_id IN(0, 4, 5, 9, 13, 14, 18, 22, 23, 27, 31, 32) ORDER BY ID DESC LIMIT $offset_engine, $no_of_records_per_page_engine");
                        while($row_things_engine = mysqli_fetch_assoc($result_things_engine)) {
                            
                            $id_ =          $row_things_engine['ID'];
                            $wear =         $row_things_engine['wear'];
                            $thing_id =     $row_things_engine['thing_id'];

                            if($thing_id == 0 || $thing_id == 4 || $thing_id == 5 || $thing_id == 9 || $thing_id == 13 || $thing_id == 14 || $thing_id == 18 || $thing_id == 22 || $thing_id == 23 || $thing_id == 27 || $thing_id == 31 || $thing_id == 32){

                        ?>
                        <tr>
                            <td style="padding-bottom: 20px;">
                                <label class="radio_container">
                                    <input type="checkbox" name='thing[]' value="<?php echo $id_ ?>">
                                    <span class="checkmark"></span>
                                </label>
                            </td>
                            <td><?php echo $thing[$thing_id] ?></td>
                            <td></td>
                            <td><?php echo number($wear); ?>%</td>
                        </tr>
                        <?php } } ?>
                    </table>
                    <input style="width: 47.5%;" type="submit" name="use_engine_part" value="Bruk motordel(er)">
                    <input style="width: 47.5%;" type="submit" name="use_all_engine_part" value="Bruk alle motordeler">
                </form>
                
                <?php if($total_pages_engine <= 1) { } else { ?>
                <div style="margin-top: 6px; margin-bottom: -5px; width: 99%;" class="content">
                    <div class="pad_5 pagination">
                        <div style="width: 30%; float: left;">
                            <span class="<?php if($pageno_engine <= 1){ echo 'disabled'; } ?>">
                                <a href="<?php if($pageno_engine <= 1){ echo '#'; } else { echo "index.php?side=raceclub&motor&pageno=".($pageno - 1); } ?>">« Forrige side</a>
                            </span>
                        </div>
                        <div style="width: 40%; float: left;">
                            <span style="text-align: center;">Side <?php echo $pageno ?></span>
                        </div>
                        <div style="width: 30%; float: left;">
                            <span class="<?php if($pageno_engine >= $total_pages_engine){ echo 'disabled'; } ?>">
                                <a style="float: right;" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "index.php?side=raceclub&motor&pageno=".($pageno_engine + 1); } ?>">Neste side »</a>
                            </span>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div id="suspension" class="tabcontent pad_10">
                <form method="POST" action="">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr style="height: 30px;">
                            <th style="width: 5%; margin-top: -20px !important;">
                            </th>
                            <th style="width: 50%;">Objekt</th>
                            <th style="width: 20%;">Kategori</th>
                            <th style="width: 30%">Skade</th>
                        </tr>
                        <?php

                    if(isset($_GET['pageno'])) {
                        $pageno_suspension = $_GET['pageno'];
                    } else {
                        $pageno_suspension = 1;
                    }

                    $no_of_records_per_page_suspension = 15;
                    $offset_suspension = ($pageno_suspension - 1) * $no_of_records_per_page_suspension; 
                    // 1, 2, 3, 10, 11, 12, 19, 20, 21, 28, 29, 30
                    $total_pages_sql_suspension = "SELECT COUNT(*) FROM mine_ting WHERE  acc_id='$ID' AND 
                    thing_id IN(1, 2, 3, 10, 11, 12, 19, 20, 21, 28, 29, 30)";
                    $result_suspension = mysqli_query($con, $total_pages_sql_suspension);
                    $total_rows_suspension = mysqli_fetch_array($result_suspension)[0];
                    $total_pages_suspension = ceil($total_rows_suspension / $no_of_records_per_page_suspension);

                        $result_things_suspension = mysqli_query($con, "SELECT * FROM mine_ting WHERE acc_id='$ID' AND thing_id IN(1, 2, 3, 10, 11, 12, 19, 20, 21, 28, 29, 30) ORDER BY ID DESC LIMIT $offset_suspension, $no_of_records_per_page_suspension");
                        while($row_things_suspension = mysqli_fetch_assoc($result_things_suspension)) {

                            $id_ =          $row_things_suspension['ID'];
                            $wear =         $row_things_suspension['wear'];
                            $thing_id =     $row_things_suspension['thing_id'];
                            
                            if($thing_id == 1 || $thing_id == 2 || $thing_id == 3 || $thing_id == 10 || $thing_id == 11 || $thing_id == 12 || $thing_id == 19 || $thing_id == 20 || $thing_id == 21 || $thing_id == 28 || $thing_id == 29 || $thing_id == 30){

                        ?>
                        <tr>
                            <td style="padding-bottom: 20px;">
                                <label class="radio_container">
                                    <input type="checkbox" name='thing[]' value="<?php echo $id_ ?>">
                                    <span class="checkmark"></span>
                                </label>
                            </td>
                            <td><?php echo $thing[$thing_id] ?></td>
                            <td></td>
                            <td><?php echo number($wear); ?>%</td>
                        </tr>
                        <?php } } ?>
                    </table>
                    <input style="width: 47.5%;" type="submit" name="use_suspension_part" value="Bruk suspension del(er)">
                    <input style="width: 47.5%;" type="submit" name="use_all_suspension_part" value="Bruk alle suspension deler">
                </form>
                
                <?php if($total_pages_suspension <= 1) { } else { ?>
                <div style="margin-top: 6px; margin-bottom: -5px; width: 99%;" class="content">
                    <div class="pad_5 pagination">
                        <div style="width: 30%; float: left;">
                            <span class="<?php if($pageno_suspension <= 1){ echo 'disabled'; } ?>">
                                <a href="<?php if($pageno_suspension <= 1){ echo '#'; } else { echo "index.php?side=raceclub&suspension&pageno=".($pageno - 1); } ?>">« Forrige side</a>
                            </span>
                        </div>
                        <div style="width: 40%; float: left;">
                            <span style="text-align: center;">Side <?php echo $pageno ?></span>
                        </div>
                        <div style="width: 30%; float: left;">
                            <span class="<?php if($pageno_suspension >= $total_pages_suspension){ echo 'disabled'; } ?>">
                                <a style="float: right;" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "index.php?side=raceclub&suspension&pageno=".($pageno_suspension + 1); } ?>">Neste side »</a>
                            </span>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div id="dekk" class="tabcontent pad_10">
                <form method="POST" action="">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr style="height: 30px;">
                            <th style="width: 5%; margin-top: -20px !important;">
                            </th>
                            <th style="width: 50%;">Objekt</th>
                            <th style="width: 20%;">Kategori</th>
                            <th style="width: 30%">Skade</th>
                        </tr>
                        <?php

                    if(isset($_GET['pageno'])) {
                        $pageno_tires = $_GET['pageno'];
                    } else {
                        $pageno_tires = 1;
                    }

                    $no_of_records_per_page_tires = 15;
                    $offset_tires = ($pageno_tires - 1) * $no_of_records_per_page_tires; 
                    // 6, 7, 8, 15, 16, 17, 24, 25, 26, 33, 34, 35
                    $total_pages_sql_tires = "SELECT COUNT(*) FROM mine_ting WHERE acc_id='$ID' AND thing_id IN(6, 7, 8, 15, 16, 17, 24, 25, 26, 33, 34, 35)";
                    $result_tires = mysqli_query($con, $total_pages_sql_tires);
                    $total_rows_tires = mysqli_fetch_array($result_tires)[0];
                    $total_pages_tires = ceil($total_rows_tires / $no_of_records_per_page_tires);

                        $result_things_tires = mysqli_query($con, "SELECT * FROM mine_ting WHERE acc_id='$ID' AND thing_id IN(6, 7, 8, 15, 16, 17, 24, 25, 26, 33, 34, 35) ORDER BY ID DESC LIMIT $offset_tires, $no_of_records_per_page_tires");
                        while($row_things_tires = mysqli_fetch_assoc($result_things_tires)) {

                            $id_ =          $row_things_tires['ID'];
                            $wear =         $row_things_tires['wear'];
                            $thing_id =     $row_things_tires['thing_id'];
                            
                            if($thing_id == 6 || $thing_id == 7 || $thing_id == 8 || $thing_id == 15 || $thing_id == 16 || $thing_id == 17 || $thing_id == 25 || $thing_id == 22 || $thing_id == 23 || $thing_id == 24 || $thing_id == 27 || $thing_id == 26 || $thing_id == 33 || $thing_id == 34 || $thing_id == 35){

                        ?>
                        <tr>
                            <td style="padding-bottom: 20px;">
                                <label class="radio_container">
                                    <input type="checkbox" name='thing[]' value="<?php echo $id_ ?>">
                                    <span class="checkmark"></span>
                                </label>
                            </td>
                            <td><?php echo $thing[$thing_id] ?></td>
                            <td></td>
                            <td><?php echo number($wear); ?>%</td>
                        </tr>
                        <?php } } ?>
                    </table>
                    <input style="width: 47.5%;" type="submit" name="use_tires_part" value="Bruk dekk del(er)">
                    <input style="width: 47.5%;" type="submit" name="use_all_tires_part" value="Bruk alle dekk deler">
                </form>
                
                <?php if($total_pages_tires <= 1) { } else { ?>
                <div style="margin-top: 6px; margin-bottom: -5px; width: 99%;" class="content">
                    <div class="pad_5 pagination">
                        <div style="width: 30%; float: left;">
                            <span class="<?php if($pageno_tires <= 1){ echo 'disabled'; } ?>">
                                <a href="<?php if($pageno_tires <= 1){ echo '#'; } else { echo "index.php?side=raceclub&tires&pageno=".($pageno - 1); } ?>">« Forrige side</a>
                            </span>
                        </div>
                        <div style="width: 40%; float: left;">
                            <span style="text-align: center;">Side <?php echo $pageno ?></span>
                        </div>
                        <div style="width: 30%; float: left;">
                            <span class="<?php if($pageno_tires >= $total_pages_tires){ echo 'disabled'; } ?>">
                                <a style="float: right;" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "index.php?side=raceclub&tires&pageno=".($pageno_tires + 1); } ?>">Neste side »</a>
                            </span>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php } else { ?>
            <img src="img/action/raceclub.png" style="width: 100%; height: auto;">
                <div style="padding: 10px; word-wrap: break-word; margin-top: -15px; white-space: pre-line;" class="textbox">
                    <b>Velkommen til Race club!</b>
                    <p style="padding-bottom: 0px; margin-bottom: -10px;">For å starte med raceclub må du kjøpe deg en mekke-garasje, dette koster 1 million kroner og kan romme 1 bil.</p>
                </div>
                    <form method="post">
                    <input style="width: 97.2%;" type="submit" name="buy_things" value="Kjøp garasje"></form>
            
            <?php } ?>
        </div>
    </body>
</html>
<?php 

}

?>

<script>

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