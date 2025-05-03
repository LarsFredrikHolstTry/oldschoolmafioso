<?php

$servername = "cpanel80.proisp.no";
$user = "mafiovrx";
$pass = "82vH84K24g9m+8";
$db = "mafiovrx_mafioso2";

$con = mysqli_connect($servername, $user, $pass, $db);

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


function number($number){
    return number_format($number, 0, '.', ' ');
}

$i = 0;
$result_daily = mysqli_query($con, "SELECT * FROM daily_exp WHERE NOT acc_id = 1 ORDER BY exp DESC LIMIT 5");
while($row_best = mysqli_fetch_assoc($result_daily)) {
    
    $acc_id = $row_best['acc_id'];

    $sql = "SELECT * FROM accounts WHERE ID='".$acc_id."'";
    $query = mysqli_query($con, $sql) or die (mysqli_error());
    $row_top5 = mysqli_fetch_assoc($query);
    
    $result = "UPDATE accounts SET money = (money + ".$cash_utbetaling[$i]."), bullets = (bullets + ".$kuler_utbetaling[$i].") WHERE ID = ".$acc_id."";
    mysqli_query($con, $result) or die("Bad query: $result");

    $query = "INSERT into `varsel` (acc_id, text, date)
    VALUES ('".$acc_id."', 'Du havnet på ".($i + 1).". plass på dagens topp 5 og får dermed ".number($cash_utbetaling[$i])." kr og ".number($kuler_utbetaling[$i])." kuler!', '".time()."')";
    $result = mysqli_query($con, $query);
    
    $i++;
}

?>