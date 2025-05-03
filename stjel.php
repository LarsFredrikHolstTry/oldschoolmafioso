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
        <span style="color: #3e3e3e;">Handlinger » </span><span style="color: #afafaf;">Stjel</span>
        <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
    </div>
    <?php
                
    if(isset($_GET['forsok'])){
        if($_GET['forsok'] == 'velykket' && isset($_GET['car'])){
            echo '<div class="feedback velykket">
                <span>Du klarte å stjele en ';
            echo $car[$_GET['car']];
                echo ' fra spilleren!</span> 
            </div>';
        } else {
            if($_GET['forsok'] == 'velykket'){
                echo '<div class="feedback velykket">
                    <span>Du klarte å stjele ';
                echo number($_GET['outcome']);
                    echo 'kr fra spilleren!</span> 
                </div>';
            } elseif($_GET['forsok'] = 'feilet'){
                echo '<div class="feedback mislykket">
                    <span>Du klarte ikke å stjele fra spilleren!</span> 
                </div>';
            }
        }
    }
    
        $sql_waittime = "SELECT * from steal WHERE acc_id='$ID'";
        $result_waittime = mysqli_query($con, $sql_waittime);

        while($rows_waittime = mysqli_fetch_array($result_waittime)){
            $timeleft_waittime = $rows_waittime['steal_seconds'];
            $available_waittime = $rows_waittime['steal_status'];
            $last_waittime = $timeleft_waittime - time();

            if($available_waittime == 1){
                echo '<div class="feedback feilmelding">
                    <span>Du må vente <span id="countdowntimer">'.$last_waittime.'</span>s før du kan stjele fra spiller igjen</span> 
                </div>';
                ?>

    <script type="text/javascript">
        var seconds = document.getElementById("countdowntimer").textContent;
        var countdown = setInterval(function() {
            seconds--;
            document.getElementById("countdowntimer").textContent = seconds;
            if (seconds <= 0) window.location.href = "index.php?side=stjel";
        }, 1000);

    </script>

    <?php
            } else {
        ?>

    <div class="content">
        <?php

    if(isset($_POST['steal_from_player'])){
        if(isset($_POST['random_player']) && isset($_POST['chosen_player'])){
                echo '<div class="feedback feilmelding">
                    <span>Du kan kun velge spesifikk spiller!</span> 
                </div>';
            
        } else {
    if(isset($_POST['rob_option'])){
        
        $player_name = $_POST['chosen_player_name'];
    
        $player_name = mysqli_real_escape_string($con, nl2br(htmlentities($player_name, ENT_QUOTES, 'UTF-8')));
        strip_tags($player_name);
        
        $check_username = mysqli_query($con, "SELECT username FROM accounts WHERE username = '".$player_name."'");

        
        
        if(mysqli_num_rows($check_username) > 0) {
        
        
if($happy_hour == 1){
    $steal_exp = 140 * 2;
} elseif($role == 3){
    $steal_exp = 140 * 1.1;
} else {
    $steal_exp = 140;
}
        
$extend = 30;
     
if($rank == 0){
    $waittime = 140 + $extend + time();
} elseif($rank == 1){
    $waittime = 160 + $extend + time();
} else {
    $waittime = 190 + $extend + time();
}

            if($_POST['rob_option'] == 1){ // stjele penger
                if((!isset($player_name)) || $player_name == null){
                    echo '<div class="feedback feilmelding">
                        <span>Du må velge en spiller!</span> 
                    </div>';
                } else {
                    $chance = mt_rand(1, 3);
                    
                    if($chance == 2 || $chance == 3){

                            $sql = "SELECT * FROM accounts WHERE username='".$player_name."'";
                            $query = mysqli_query($con, $sql) or die (mysqli_error());
                            $row_info = mysqli_fetch_assoc($query);
                            
                            $ID_victim = $row_info['ID'];
                            $account_type_victim = $row_info['account_type'];

                            if($account_type_victim == 1 || $account_type_victim == 2 || $account_type_victim == 3){
                                echo '<div class="feedback feilmelding">
                                    <span>Du kan ikke rane fra medlemmer av ledelsen!</span> 
                                </div>';
                            } elseif($account_type_victim == 68 || $account_type_victim == 69){
                                echo '<div class="feedback feilmelding">
                                    <span>Du kan ikke rane fra døde eller deaktiverte brukere!</span> 
                                </div>';
                            } elseif($row_info['username'] == $username){
                                echo '<div class="feedback feilmelding">
                                    <span>Du kan ikke rane fra deg selv!</span> 
                                </div>';
                            } elseif($row_info['money'] < 10000){
                                $result = mysqli_query($con, "UPDATE steal SET steal_status='1', steal_seconds='$waittime' WHERE acc_id='$ID'") or die (mysqli_error($con));

                                $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
                                VALUES ('$ID', '5', 'Stjel penger feilet', '$money', '$bank_money', '".time()."')";
                                $result = mysqli_query($con, $query);
                                
                                header("Location: index.php?side=stjel&forsok=feilet");
                            } elseif($row_info['beskyttelse'] == 3 || $row_info['beskyttelse'] == 2){
                                $result = mysqli_query($con, "UPDATE steal SET steal_status='1', steal_seconds='$waittime' WHERE acc_id='$ID'") or die (mysqli_error($con));
                                
                                $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
                                VALUES ('$ID', '5', 'Stjel penger feilet', '$money', '$bank_money', '".time()."')";
                                $result = mysqli_query($con, $query);
                                
                                header("Location: index.php?side=stjel&forsok=feilet");
                            } elseif($ID_victim == $ID){
                                $result = mysqli_query($con, "UPDATE steal SET steal_status='1', steal_seconds='$waittime' WHERE acc_id='$ID'") or die (mysqli_error($con));
                                
                                $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
                                VALUES ('$ID', '5', 'Stjel penger feilet', '$money', '$bank_money', '".time()."')";
                                $result = mysqli_query($con, $query);
                                
                                header("Location: index.php?side=stjel&forsok=feilet");
                            } else {
                                
                                $money_victim = $row_info['money'];
                                $money_stolen = mt_rand(0, $money_victim);

                                $result = mysqli_query($con, "UPDATE accounts SET money = ($money_victim - $money_stolen) WHERE username='".$player_name."'") or die (mysqli_error($con));

                                $result = mysqli_query($con, "UPDATE accounts SET money = ($money + $money_stolen), exp = ($exp + $steal_exp) WHERE ID='".$ID."'") or die (mysqli_error($con));
                                
                                $result = "UPDATE daily_exp SET exp = (exp + $steal_exp) WHERE acc_id='".$_SESSION['ID']."'";
                                mysqli_query($con, $result) or die("Bad query: $result");

                                $result = mysqli_query($con, "UPDATE steal SET steal_status='1', steal_seconds='$waittime' WHERE acc_id='$ID'") or die (mysqli_error($con));

                                $query = "INSERT into `varsel` (acc_id, text, date)
                                VALUES ('$ID_victim', 'Du har blitt frastjålet ".number($money_stolen)."kr av en ukjent spiller.', '".time()."')";
                                $result = mysqli_query($con, $query);
                                
                                $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
                                VALUES ('$ID', '5', 'Stjel velykket, Penger = ".$money_stolen."', '$money', '$bank_money', '".time()."')";
                                $result = mysqli_query($con, $query);

                                header("Location: index.php?side=stjel&forsok=velykket&outcome=$money_stolen");
                            }

                    } else {
                        $result = mysqli_query($con, "UPDATE steal SET steal_status='1', steal_seconds='$waittime' WHERE acc_id='$ID'") or die (mysqli_error($con));
                        
                        header("Location: index.php?side=stjel&forsok=feilet");
                    }
                }
            } elseif($_POST['rob_option'] == 2){ // stjele bil
                if((!isset($player_name)) || $player_name == null){
                    echo '<div class="feedback feilmelding">
                        <span>Du må velge en spiller!</span> 
                    </div>';
                } else {
                    $chance = mt_rand(1, 3);
                    
                    if($chance == 2 || $chance == 3){

                            $sql = "SELECT * FROM accounts WHERE username='".$player_name."'";
                            $query = mysqli_query($con, $sql) or die (mysqli_error());
                            $row_car_info = mysqli_fetch_assoc($query);
                            
                            $ID_victim = $row_car_info['ID'];
                            $account_type_victim = $row_car_info['account_type'];
                        
                        
                            $sql = "SELECT * FROM garage_security WHERE acc_id='".$ID_victim."'";
                            $query = mysqli_query($con, $sql) or die (mysqli_error());
                            $row_gs = mysqli_fetch_assoc($query);
                        
                            $gs_[0] =                   $row_gs['gs_0'];
                            $gs_[1] =                   $row_gs['gs_1'];
                            $gs_[2] =                   $row_gs['gs_2'];
                            $gs_[3] =                   $row_gs['gs_3'];
                            $gs_[4] =                   $row_gs['gs_4'];
                        
                            if($gs_[0] == 1){
                                $chance = 5;
                            } if($gs_[0] == 1 && $gs_[1] == 1){
                                $chance = 15;
                            } if($gs_[0] == 1 && $gs_[1] == 1 && $gs_[2] == 1){
                                $chance = 30;
                            } if($gs_[0] == 1 && $gs_[1] == 1 && $gs_[2] == 1 && $gs_[3] == 1){
                                $chance = 60;
                            } if($gs_[0] == 1 && $gs_[1] == 1 && $gs_[2] == 1 && $gs_[3] == 1 && $gs_[4] == 1){
                                $chance = 100;
                            }
                        
                            $chance_of_succ = mt_rand(0, 100);
                        
                            if($account_type_victim == 1 || $account_type_victim == 2 ||$account_type_victim == 3){
                                echo '<div class="feedback feilmelding">
                                    <span>Du kan ikke rane fra medlemmer av ledelsen!</span> 
                                </div>';
                            } elseif($account_type_victim == 68 || $account_type_victim == 69){
                                echo '<div class="feedback feilmelding">
                                    <span>Du kan ikke rane fra døde eller deaktiverte brukere!</span> 
                                </div>';
                            } elseif($chance >= $chance_of_succ){
                                $result = mysqli_query($con, "UPDATE steal SET steal_status='1', steal_seconds='$waittime' WHERE acc_id='$ID'") or die (mysqli_error($con));

                                $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
                                VALUES ('$ID', '5', 'Stjel bil feilet', '$money', '$bank_money', '".time()."')";
                                $result = mysqli_query($con, $query);

                                header("Location: index.php?side=stjel&forsok=feilet");
                            } else {
                                $check_cars = mysqli_query($con, "SELECT acc_id FROM cars WHERE acc_id = '".$ID_victim."'");
                                if(mysqli_num_rows($check_cars) > 0) {

                                    $sql = "SELECT * FROM cars WHERE acc_id='".$ID_victim."' ORDER BY RAND() LIMIT 1";
                                    $query = mysqli_query($con, $sql) or die (mysqli_error());
                                    $row_car = mysqli_fetch_assoc($query);

                                    $car_id = $row_car['ID'];
                                    $car_car_id = $row_car['car_id'];
                                    $car_acc_id = $row_car['acc_id'];

                                    $result = mysqli_query($con, "UPDATE cars SET acc_id = $ID, city = $city WHERE ID='".$car_id."'") or die (mysqli_error($con));

                                    $result = mysqli_query($con, "UPDATE accounts SET exp = ($exp + $steal_exp) WHERE ID='".$ID."'") or die (mysqli_error($con));

                                    $result = mysqli_query($con, "UPDATE steal SET steal_status='1', steal_seconds='$waittime' WHERE acc_id='$ID'") or die (mysqli_error($con));

                                    $query = "INSERT into `varsel` (acc_id, text, date)
                                    VALUES ('$ID_victim', 'Du har blitt frastjålet en ".$car[$car_car_id]." av en ukjent spiller.', '".time()."')";
                                    $result = mysqli_query($con, $query);
                                    
                                    $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
                                    VALUES ('$ID', '5', 'Stjel bil velykket, bil_id = ".$car_car_id."', '$money', '$bank_money', '".time()."')";
                                    $result = mysqli_query($con, $query);

                                    header("Location: index.php?side=stjel&forsok=velykket&car=$car_car_id");

                                } else {
                                    $result = mysqli_query($con, "UPDATE steal SET steal_status='1', steal_seconds='$waittime' WHERE acc_id='$ID'") or die (mysqli_error($con));

                                    $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
                                    VALUES ('$ID', '5', 'Stjel bil feilet', '$money', '$bank_money', '".time()."')";
                                    $result = mysqli_query($con, $query);

                                    header("Location: index.php?side=stjel&forsok=feilet");
                                }
                            }

                    } else {
                        $result = mysqli_query($con, "UPDATE steal SET steal_status='1', steal_seconds='$waittime' WHERE acc_id='$ID'") or die (mysqli_error($con));
                        
                        header("Location: index.php?side=stjel&forsok=feilet");
                    }
                }
            }
        } else {
            echo '<div class="feedback feilmelding">
                <span>Spilleren eksisterer ikke!</span> 
            </div>';
        }
        } else {
            echo '<div class="feedback feilmelding">
                <span>Du må velge hva du ønsker å stjele!</span> 
            </div>';
        }
    }
    
    }

    
    ?>
        <div class="header">
            <span>Stjel</span>
        </div>
        <img src="img/action/stjel.png">
        <form method="POST" action="">
            <div style="width: 50%; float: left;">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr style="height: 30px;">
                        <th style="width: 5%; margin-top: -20px !important;"></th>
                        <th style="width: 95%;">Hva ønsker du å stjele?</th>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 20px;">
                            <label class="radio_container">
                                <input type="radio" name='rob_option' value="1">
                                <span class="checkmark"></span>
                            </label>
                        </td>
                        <td>Penger</td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 20px;">
                            <label class="radio_container">
                                <input type="radio" name='rob_option' value="2">
                                <span class="checkmark"></span>
                            </label>
                        </td>
                        <td>Kjøretøy</td>
                    </tr>
                </table>
            </div>
            <div style="width: 50%; float: left;">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr style="height: 30px;">
                        <th style="width: 95%;">Hvem ønsker du å stjele fra?</th>
                    </tr>
                    <tr style="background-color: #1b1b1b;">
                        <td><input type="text" name="chosen_player_name" placeholder="Spiller"></td>
                    </tr>
                </table>
                <input style="width: 47.5%;" type="submit" name="steal_from_player" value="Utfør tyveri">
            </div>
        </form>
    </div>
</body>

</html>
<?php 
                
        }
    }
}

?>

<script>
    $("#selectAll").click(function() {
        $("input[type=radio]").prop('checked', $(this).prop('checked'));
    });

</script>
