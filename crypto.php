
<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else {
    
    $sql = "SELECT * FROM crypto_farm WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
    $query = mysqli_query($con, $sql) or die (mysqli_error());
    $row_cf = mysqli_fetch_assoc($query);
    
    $farm = $row_cf['farm'];
    $gpu = $row_cf['gpu'];
    $rigg = $row_cf['rigg'];
    $status = $row_cf['status'];

    $farm_name[0] = "Soverom";
    $farm_price[0] = 0;
    $farm_max[0] = 10;
    
    $farm_name[1] = "Garasje";
    if($role == 1){
        $farm_price[1] = 26000000 * 0.9; // 26 000 000 - 10%
    } else {
        $farm_price[1] = 26000000; // 26 000 000
    }
    $farm_max[1] = 50;

    $farm_name[2] = "Gård";
    if($role == 1){
        $farm_price[2] = 100000000 * 0.9; // 100 000 000 - 10%
    } else {
        $farm_price[2] = 100000000; // 100 000 000
    }
    $farm_max[2] = 100;

    $farm_name[3] = "Lite lager";
    if($role == 1){
        $farm_price[3] = 350000000 * 0.9; // 350 000 000 - 10%
    } else {
        $farm_price[3] = 350000000; // 350 000 000    
    }
    $farm_max[3] = 150;

    $farm_name[4] = "Stort lager";
    if($role == 1){
        $farm_price[4] = 1000000000 * 0.9; // 1 000 000 000 - 10%
    } else {
        $farm_price[4] = 1000000000; // 1 000 000 000    
    }
    $farm_max[4] = 225;
    
    $gpu_max[0] = 1;
    $gpu_price[0] = 0;
    
    $gpu_max[1] = 2;
    if($role == 1){
        $gpu_price[1] = 120000000 * 0.9; // 120 000 000 - 10%
    } else {
        $gpu_price[1] = 120000000; // 120 000 000
    }
    
    $gpu_max[2] = 4;    
    if($role == 1){
        $gpu_price[2] = 500000000 * 0.9; // 500 000 000 - 10%
    } else {
        $gpu_price[2] = 500000000; // 500 000 000
    }
    
    $gpu_max[3] = 8;
    if($role == 1){
        $gpu_price[3] = 2000000000 * 0.9; // 2 000 000 000 - 10%
    } else {
        $gpu_price[3] = 2000000000; // 2 000 000 000
    }

    if($role == 1){
        $pris_rigg = 100000 * 0.9;
    } else {
        $pris_rigg = 100000;
    }
    
    $pr_time = 25000;

    /*
    
    $krim_bonus = $antall_krim * 0.015;
    echo number($rigg * ($pr_time * $krim_bonus) * $gpu_max[$gpu]);

    */
    
    // Pr rigg = 100 000kr
    // Utbetaling pr rigg = 500kr
    // Inntekt pr time = rigg * 500 * gpu_max

    
    if(isset($_POST['outtake'])){
                $check_family = mysqli_query($con, "SELECT acc_id FROM family_member WHERE acc_id = '$ID'");
                if(mysqli_num_rows($check_family) > 0){
                    $sql = "SELECT * FROM family_member WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
                    $query = mysqli_query($con, $sql) or die (mysqli_error());
                    $row_member = mysqli_fetch_assoc($query);

                    $family_id = $row_member['family_id'];

                    $sql = "SELECT * FROM family WHERE ID='".$family_id."'";
                    $query = mysqli_query($con, $sql) or die (mysqli_error());
                    $row_family = mysqli_fetch_assoc($query);

                    $family_bedrift = $row_family['fam_bedrift'];

                    $boost[0] = 1;
                    $boost[1] = 1.1;
                    $boost[2] = 1.25;
                    $boost[3] = 1.5;

                    $outtake = ($rigg * $pr_time * $gpu_max[$gpu]) * $boost[$row_family['fam_bedrift']];
                } else {
                    $outtake = ($rigg * $pr_time) * $gpu_max[$gpu];
                }

            $result = "UPDATE crypto_farm SET status = 0 WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");

            $result = "UPDATE stats SET crypto = (crypto + $outtake) WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");

            $result = "UPDATE accounts SET money = (money + $outtake) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");

            if($oppdrag == 35){
                $result = "UPDATE oppdrag SET value = ($value + 1) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }

            $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
            VALUES ('$ID', '1', 'Crypto penger ut = ".$outtake."', '$money', '$bank_money', '".time()."')";
            $result = mysqli_query($con, $query);

            header("Location: index.php?side=crypto&uttak=$outtake");
    }
    
    if(isset($_POST['upgrade'])){
        if($farm < 4){
            if($money >= $farm_price[$farm + 1]){
                $result = "UPDATE crypto_farm SET farm = (farm + 1) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
                
                $farm_pr = $farm_price[$farm + 1];
                
                $result = "UPDATE accounts SET money = (money - $farm_pr) WHERE ID='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
                
                $result = "UPDATE stats SET crypto = (crypto - $farm_pr) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
                
                header("Location: index.php?side=crypto&farm_buy");
            } else {
                echo '<div class="feedback feilmelding">
                    <span>Du har ikke nok penger til denne farmen.</span> 
                </div>';
            }
        } else {
            echo '<div class="feedback feilmelding">
                <span>Du har allerede den beste farmen.</span> 
            </div>';
        }
    }
    
    if(isset($_POST['buy_rigg'])){
        $rigg_ant = $_POST['rigg_ant'];
        $total_price = $rigg_ant * $pris_rigg;
        
        if($rigg_ant < 1){
            echo '<div class="feedback feilmelding">
                <span>Du må velge ett beløp høyere enn 1.</span> 
            </div>';
        } elseif($total_price > $money){
            echo '<div class="feedback feilmelding">
                <span>Du har ikke nok penger for antall rigg.</span> 
            </div>';
        } elseif($farm_max[$farm] < $rigg_ant + $rigg){
            echo '<div class="feedback feilmelding">
                <span>Du har ikke nok plass til antall rigg.</span> 
            </div>';
        } else {
            $result = "UPDATE crypto_farm SET rigg = (rigg + $rigg_ant) WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $result = "UPDATE stats SET crypto = (crypto - $total_price) WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $result = "UPDATE accounts SET money = (money - $total_price) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            header("Location: index.php?side=crypto&rigg");
        }
    }
    
    if(isset($_POST['upgrade_gpu'])){
        if($farm_max[$farm] != $rigg){
            echo '<div class="feedback feilmelding">
                <span>Du må maxe riggen før du kan oppgradere gpu.</span> 
            </div>';
        } elseif($gpu == 2 && $farm < 3) {
            echo '<div class="feedback feilmelding">
                <span>8gpu er kun mulig på lite og stort lager.</span> 
            </div>';
        } elseif($gpu == 1 && $farm < 2) {
            echo '<div class="feedback feilmelding">
                <span>4gpu er kun mulig på gård eller bedre.</span> 
            </div>';
        } elseif($gpu == 0 && $farm < 1) {
            echo '<div class="feedback feilmelding">
                <span>2gpu er kun mulig på garasje eller bedre.</span> 
            </div>';
        } else {
            if($gpu < 3){
                if($farm < $gpu){
                    echo '<div class="feedback feilmelding">
                        <span>Du må ha bedre farm for å oppgradere GPU.</span> 
                    </div>';
                } else {
                    if($money >= $gpu_price[$gpu + 1]){
                        $result = "UPDATE crypto_farm SET gpu = (gpu + 1) WHERE acc_id='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        $gpu_pr = $gpu_price[$gpu + 1];
                        
                        $result = "UPDATE stats SET crypto = (crypto - $gpu_pr) WHERE acc_id='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        $result = "UPDATE accounts SET money = (money - $gpu_pr) WHERE ID='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        header("Location: index.php?side=crypto&gpu_buy");
                    } else {
                        echo '<div class="feedback feilmelding">
                            <span>Du har ikke nok penger til denne gpuen.</span> 
                        </div>';
                    }
                }
                } else {
                    echo '<div class="feedback feilmelding">
                        <span>Du har allerede den beste gpuen.</span> 
                    </div>';
                
            }
        }
    }
    
    if(isset($_GET['gpu_buy'])){
        echo '<div class="feedback velykket">
            <span>du oppgraderte til ';
        echo $gpu_max[$gpu];
        echo 'gpu.</span> 
        </div>';
    }

    if(isset($_GET['uttak'])){
        echo '<div class="feedback velykket">
            <span>Du tok ut ';
        echo number($_GET['uttak']);
        echo 'kr av din crypto farm.</span> 
        </div>';
    }
    
    if(isset($_GET['farm_buy'])){
        echo '<div class="feedback velykket">
            <span>Farmen ble kjøpt.</span> 
        </div>';
    }
    
    if(isset($_GET['rigg'])){
        echo '<div class="feedback velykket">
            <span>Antall rigg ble kjøpt.</span> 
        </div>';
    }
    
?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Diverse » </span><span style="color: #afafaf;">Crypto</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <div class="header">
                <span>Crypto farm</span>
            </div>
            <img src="img/action/crypto.png">
            <form method="post">
                <div style="width: 35%; float: left; padding: 20px 25px 15px 25px;">
                <b>Din farm</b><br><?php echo $farm_name[$farm]; ?><br><br>
                <b>Max rigg</b><br><?php echo number($farm_max[$farm]); ?> stk<br><br>
                <b>Din rigg</b><br><?php echo number($rigg); ?> stk<br><br>
                <b>Antall gpu</b><br><?php echo $gpu_max[$gpu]; ?><br><br>
                <b>Inntekt pr time</b><br><?php echo number($rigg * $pr_time * $gpu_max[$gpu]); ?>kr<br><br>

                </div>

                <div style="width: 40%; float: right; padding: 10px 25px 15px 25px;">
                <?php if($farm < 4){ ?>

                <b>Oppgrader farm</b>
                <input type="submit" style="margin: 5 0 5 0;" name="upgrade" value="Oppgrader til <?php echo $farm_name[$farm + 1]; ?>">
                Pris: <?php echo number($farm_price[$farm + 1]); ?>kr

                <?php 
                    } else { 
                        echo '<div style="padding: 25 0 25 0;"><span style="color: #009fe3;">Du har den beste farmen</span></div>'; 
                    } 
                ?>

                <?php if($rigg < $farm_max[4]){ ?>
                <br><br>
                <b>Kjøp rigg</b>
                <br>
                <input type="number" min="1" max="5000" name="rigg_ant" style="width: 51%;" placeholder="antall">
                <input type="submit" style="width: 47%; margin: 5 0 5 0;" name="buy_rigg" value="Kjøp"><br>
                Pris pr: <?php echo number($pris_rigg); ?>kr

                <?php 
                    } else { 
                        echo '<div style="padding: 25 0 25 0;"><span style="color: #009fe3;">Du har max antall rigg</span></div>'; 
                    } 
                ?>

                <?php if($gpu < 3){ ?>
                <br><br>
                <b>Oppgrader gpu</b>
                <br>
                <input type="submit" style="margin: 5 0 5 0;" name="upgrade_gpu" value="Oppgrader til <?php echo $gpu_max[$gpu + 1]; ?>gpu"><br>
                Pris: <?php echo number($gpu_price[$gpu + 1]); ?>kr

                <?php 
                    } else { 
                        echo '<div style="padding: 25 0 25 0;"><span style="color: #009fe3;">Du har max antall gpu</span></div>'; 
                    } 
                ?>
                </div>
                    <?php if($status == 1 && ($rigg * $pr_time * $gpu_max[$gpu]) > 0){ ?>
                <input type="submit" style="margin: 7px; width: 97.3%;" name="outtake" value="Ta ut penger: <?php 
                                           
            $check_family = mysqli_query($con, "SELECT acc_id FROM family_member WHERE acc_id = '$ID'");
            if(mysqli_num_rows($check_family) > 0){
                $sql = "SELECT * FROM family_member WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row_member = mysqli_fetch_assoc($query);

                $family_id = $row_member['family_id'];

                $sql = "SELECT * FROM family WHERE ID='".$family_id."'";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row_family = mysqli_fetch_assoc($query);

                $family_bedrift = $row_family['fam_bedrift'];
                
                $boost_percentage[0] = 0;
                $boost_percentage[1] = $rigg * $pr_time * $gpu_max[$gpu] * 1.1 - $rigg * $pr_time * $gpu_max[$gpu];
                $boost_percentage[2] = $rigg * $pr_time * $gpu_max[$gpu] * 1.25 - $rigg * $pr_time * $gpu_max[$gpu];
                $boost_percentage[3] = $rigg * $pr_time * $gpu_max[$gpu] * 1.50 - $rigg * $pr_time * $gpu_max[$gpu];

                if($family_bedrift > 0){
                    echo number($rigg * $pr_time * $gpu_max[$gpu]);
                    echo 'kr (+';
                    echo number($boost_percentage[$row_family['fam_bedrift']]);
                    echo 'kr)';
                } else {
                    echo number($rigg * $pr_time * $gpu_max[$gpu]);
                }
            } else {
                echo number($rigg * $pr_time * $gpu_max[$gpu]);
                echo 'kr';
            }
                    ?>">
                    <?php } ?>
            </form>
        </div>
    </body>
</html>
<?php 

}

?>