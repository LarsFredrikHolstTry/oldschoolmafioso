
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
            <span style="color: #afafaf;">Statistikk</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <div style="height: 135px; width: 100%;">
                    <div class="header">
                        <span>Generelt</span>
                    </div>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr style="height: 25px;">
                            <td style="padding-left: 10px;">Antall levende spillere: <?php 
                            
                        $players_alive = mysqli_query($con, "SELECT * FROM accounts WHERE account_type = 0");

                        echo mysqli_num_rows($players_alive);
                            
                            ?></td>
                        </tr>
                        <tr style="height: 25px;">
                            <td style="padding-left: 10px;">Antall døde spillere: <?php 
                            
                        $players_dead = mysqli_query($con, "SELECT * FROM accounts WHERE account_type = 69");

                        echo mysqli_num_rows($players_dead);
                            
                            ?></td>
                        </tr>
                        
                        <tr style="height: 25px;">
                            <td style="padding-left: 10px;">Antall penger i omløp (levende spillere): <?php 
                            
                            $result_hand = mysqli_query($con, 'SELECT SUM(money) AS money_sum FROM accounts WHERE account_type = 0'); 
                            $row_hand = mysqli_fetch_assoc($result_hand); 
                            $sum_hand = $row_hand['money_sum'];
    
                            $result_bank = mysqli_query($con, 'SELECT SUM(bank_money) AS bank_sum FROM accounts WHERE account_type = 0'); 
                            $row_bank = mysqli_fetch_assoc($result_bank); 
                            $sum_bank = $row_bank['bank_sum'];

                        echo number($sum_hand + $sum_bank);
                            
                            ?> kr</td>
                        </tr>
                        
                        <tr style="height: 25px;">
                            <td style="padding-left: 10px;">Antall kuler i omløp (levende spillere): <?php 
                            
                            $result_bullez = mysqli_query($con, 'SELECT SUM(bullets) AS bullet_sum FROM accounts WHERE account_type = 0'); 
                            $row_bullez = mysqli_fetch_assoc($result_bullez); 
                            $sum_bullez = $row_bullez['bullet_sum'];

                        echo number($sum_bullez);
                            
                            ?> kuler</td>
                        </tr>
                    </table>
            </div>
            <div style="height: 283px; width: 100%;">
                <div style="width: 50%; float: left;">
                    <div class="header">
                        <span>Topp 10 beste spillere</span>
                    </div>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <?php 

                        $i = 0;
                        $result = mysqli_query($con, "SELECT * FROM accounts WHERE account_type = 0 ORDER BY EXP DESC LIMIT 10");
                        while($row_best = mysqli_fetch_assoc($result)) {

                            $usrnm = $row_best['ID'];
                            $i++;
                        ?>
                        <tr style="height: 25px;">
                            <td 
                                <?php if($i == 1){ ?>
                                style="color: gold; padding-left: 10px;" 
                                <?php } elseif($i == 2){ ?>
                                style="color: silver; padding-left: 10px;" 
                                <?php } elseif($i == 3){ ?>
                                style="color: #cd7f32 ; padding-left: 10px;" 
                                <?php }else { ?>
                                style="color: #555555 ; padding-left: 10px;" 
                                <?php } ?>
                                ><?php echo $i; ?>. plass</td>
                            <td><?php echo fetch_nick($usrnm, $con); ?></td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
                <div style="width: 50%; float: right; box-shadow: -1px 0px 0px 0px #2c2c2c, 1px 0px 0px 0px #2c2c2c;">
                    <div class="header">
                        <span>Topp 10 rikeste spillere</span>
                    </div>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <?php 

                        $i = 0;
                        $result = mysqli_query($con, "SELECT * FROM accounts WHERE account_type = 0 ORDER BY (money + bank_money) DESC LIMIT 10");
                        while($row_best = mysqli_fetch_assoc($result)) {

                            $usrnm = $row_best['ID'];
                            $i++;
                        ?>
                        <tr style="height: 25px;">
                            <td                             
                                <?php if($i == 1){ ?>
                                style="color: gold; padding-left: 10px;" 
                                <?php } elseif($i == 2){ ?>
                                style="color: silver; padding-left: 10px;" 
                                <?php } elseif($i == 3){ ?>
                                style="color: #cd7f32 ; padding-left: 10px;" 
                                <?php }else { ?>
                                style="color: #555555 ; padding-left: 10px;" 
                                <?php } ?>><?php echo $i; ?>. plass</td>
                            <td><?php echo fetch_nick($usrnm, $con); ?></td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <div style="border-top: 1px solid #2c2c2c;" class="header">
                <span>Kulefabrikker</span>
            </div>
            <table border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 25px;">
                    <th style="padding-left: 10px;">By</th>
                    <th>Eier</th>
                    <th>Pris pr kule</th>
                    <th>Kuler</th>
                </tr>
                <?php 
    
    for($j = 0; $j < 5; $j++){
        $sql = "SELECT * FROM kf WHERE city = $j";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row_kf_krs = mysqli_fetch_assoc($query);

        if($row_kf_krs['city'] == null){
            $kf_cowner[$j] =    0;
            $kf_price[$j] =     6000000;
            $kf_bullets[$j] =   0;
        } else {
            $kf_cowner[$j] =    $row_kf_krs['owner'];
            $kf_price[$j] =     $row_kf_krs['price'];
            $kf_bullets[$j] =   $row_kf_krs['bullets'];
        }
    }

            for($i = 0; $i < 5; $i++){

                ?>
                
                <tr style="height: 25px;">
                    <td style="padding-left: 10px;"><?php echo $city_name[$i]; ?></td>
                    <td><?php echo fetch_nick($kf_cowner[$i], $con); ?></td>
                    <td><?php echo number($kf_price[$i]); ?></td>
                    <td><?php echo number($kf_bullets[$i]); ?></td>
                </tr>
                <?php } ?>
            </table>
            
            <div style="border-top: 1px solid #2c2c2c;" class="header">
                <span>Personlig statistikk</span>
            </div>
            <?php 
    
$sql = "SELECT * FROM crime WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row_crime = mysqli_fetch_assoc($query);

$sql = "SELECT * FROM gta WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row_gta = mysqli_fetch_assoc($query);

$sql = "SELECT * FROM stats WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row_stats = mysqli_fetch_assoc($query);
            
            ?>
            <table border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 25px;">
                    <td style="padding-left: 10px;">Antall EXP:</td>
                    <td><?php echo number($exp); ?></td>
                </tr>
                <tr style="height: 25px;">
                    <td style="padding-left: 10px;">Antall EXP i dag:</td>
                    <td><?php 
    
$sql = "SELECT * FROM daily_exp WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row_daily = mysqli_fetch_assoc($query);
    
    echo number($row_daily['exp']); ?></td>
                </tr>
                <tr style="height: 25px;">
                    <td style="padding-left: 10px;">Antall velykkede krim utført:</td>
                    <td><?php echo number($row_crime['crime_0'] + $row_crime['crime_1'] + $row_crime['crime_2'] + $row_crime['crime_3'] + $row_crime['crime_4']); ?></td>
                </tr>
                <tr style="height: 25px;">
                    <td style="padding-left: 10px;">Antall velykkede biltyveri utført:</td>
                    <td><?php echo number($row_gta['gta_0'] + $row_gta['gta_1'] + $row_gta['gta_2']); ?></td>
                </tr>
                <tr style="height: 25px;">
                    <td style="padding-left: 10px;">Gambling</td>
                    <td><?php if($row_stats['gambling'] == null){ echo '0'; } elseif($row_stats['gambling'] < 0) { echo '<span style="color: orange;">'; echo number($row_stats['gambling']); echo '</span>'; } else { echo '<span style="color: green;">'; echo number($row_stats['gambling']); echo '</span>'; } ?></td>
                </tr>
                <tr style="height: 25px;">
                    <td style="padding-left: 10px;">Crypto fortjeneste</td>
                    <td><?php if($row_stats['crypto'] == null){ echo '0'; } elseif($row_stats['crypto'] < 0) { echo '<span style="color: orange;">'; echo number($row_stats['crypto']); echo '</span>'; } else { echo '<span style="color: green;">'; echo number($row_stats['crypto']); echo '</span>'; } ?></td>
                </tr>
                <tr style="height: 25px;">
                    <td style="padding-left: 10px;">Filmproduksjon fortjeneste</td>
                    <td><?php if($row_stats['filmproduksjon'] == null){ echo '0'; } elseif($row_stats['filmproduksjon'] < 0) { echo '<span style="color: orange;">'; echo number($row_stats['filmproduksjon']); echo '</span>'; } else { echo '<span style="color: green;">'; echo number($row_stats['filmproduksjon']); echo '</span>'; } ?></td>
                </tr>
            </table>
        </div>
    </body>
</html>
<?php 

}

?>