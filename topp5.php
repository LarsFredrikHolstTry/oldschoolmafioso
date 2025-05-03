
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
            <span style="color: #3e3e3e;">Mafioso » </span><span style="color: #afafaf;">Topp 5</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <div class="header">
                <span>Topp 5</span>
            </div>
            <p style="padding: 0px 10px;">På topp 5 vil de 5 beste rankede innen dette døgnet ligge. Kl 23:30 vil man få ut premie for hvilken plassering man er på.</p>
            
            <table border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 25px;">
                    <th style="width: 40%; padding-left: 10px;">Plassering</th>
                    <th style="width: 40%;">Brukernavn</th>
                    <th style="width: 20%; text-align: right;">Sist aktiv</th>
                </tr>
                <?php 
                
                $i = 0;
                $result = mysqli_query($con, "SELECT * FROM daily_exp WHERE NOT acc_id = 1 ORDER BY exp DESC LIMIT 5");
                while($row_best = mysqli_fetch_assoc($result)) {

                    $acc_id = $row_best['acc_id'];
                    $i++;
                    
                    $sql = "SELECT * FROM accounts WHERE ID='".$acc_id."'";
                    $query = mysqli_query($con, $sql) or die (mysqli_error());
                    $row_last_active = mysqli_fetch_assoc($query);
                    
                    $last_active_profile = $row_last_active['last_active'];
                
                ?>
                <tr style="height: 25px;">
                    <td style="padding-left: 10px;"><?php echo $i ?>.</td>
                    <td><?php echo fetch_nick($acc_id, $con); ?><?php if($account_type == 2) { echo '<span style="color: black;">EXP: '; echo number($row_best['exp']); echo '</span>'; } ?></td>
                    <td style="text-align: right;"><?php  
                
                    $date = date('Y-m-d', $last_active_profile);
                    $today = date('Y-m-d');
                    $yesterday = date('Y-m-d', strtotime('yesterday')); 

                    if($last_active_profile > (time() - 100)){
                        echo "<span style='color: #009fe3;'>Nå</span>";
                    } elseif ($date == $today) {
                        echo "<span style='color: #009fe3;'>I dag (";
                        echo date('H:i', $last_active_profile);
                        echo ")</span>";
                    } elseif ($date == $yesterday) {
                        echo "I går";
                        echo " kl "; echo date('H:i', $last_active_profile);
                    } else {
                        echo " "; echo date('d', $last_active_profile);
                        echo ". "; echo $month_short[date('n', $last_active_profile)];
                        echo " - "; echo date('H:i', $last_active_profile); 
                    }
                                
                        ?></td>
                </tr>
                <?php 
                
                }
                
                ?>
            </table>
            <div class="header">
                <span>Utbetalinger</span>
            </div>
            <table border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 25px;">
                    <th style="width: 40%; padding-left: 10px;">Plassering</th>
                    <th style="width: 40%;">Penger</th>
                    <th style="width: 20%; text-align: right;">Kuler</th>
                </tr>
                <?php 
                    
                    $cash_utbetaling[0] = 50000000;
                    $cash_utbetaling[1] = 40000000;
                    $cash_utbetaling[2] = 30000000;
                    $cash_utbetaling[3] = 20000000;
                    $cash_utbetaling[4] = 10000000;
                
                    $kuler_utbetaling[0] = 25;
                    $kuler_utbetaling[1] = 20;
                    $kuler_utbetaling[2] = 15;
                    $kuler_utbetaling[3] = 10;
                    $kuler_utbetaling[4] = 5;
         

                
                for($i = 0; $i < 5; $i++){
                    
                ?>
                <tr style="height: 25px;">
                    <td style="width: 40%; padding-left: 10px;"><?php echo $i + 1  ?>.</td>
                    <td style="width: 40%;"><?php echo number($cash_utbetaling[$i]); ?></td>
                    <td style="width: 20%; text-align: right;"><?php echo number($kuler_utbetaling[$i]); ?></td>
                </tr>
                <?php 
                
                }
 
                ?>
            </table>
        </div>
    </body>
</html>
<?php 

}

?>