<?php

$servername = "cpanel80.proisp.no";
$user = "mafiovrx";
$pass = "82vH84K24g9m+8";
$db = "mafiovrx_mafioso2";

$con = mysqli_connect($servername, $user, $pass, $db);

$stock_name[0] = "Mafioso Eiendom C";
$stock_name[1] = "Den Sveitsiske bank";
$stock_name[2] = "Det Norske Dampskibselskap";
$stock_name[3] = "Sansung";
$stock_name[4] = "Eple";
$stock_name[5] = "Potet Solutions Inc.";
$stock_name[6] = "Fart & Bart AS";

$time = time();

$del = mysqli_query($con, "DELETE FROM stocks WHERE date < $time - 86400") or die(mysqli_error()); 

    for($j = 0; $j < count($stock_name); $j++){
        $sql = "SELECT * FROM stocks WHERE stock_id = '".$j."' ORDER BY date DESC";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row_stock = mysqli_fetch_assoc($query);

        $stock_price[$j] = $row_stock['price'];
        $random = mt_rand(-35, 35);

        $max_price = 170;

        if($stock_price[$j] + $random > $max_price){
            $new_price = $stock_price[$j] - mt_rand(10, 20);
        } elseif($stock_price[$j] + $random < 0) {
            $result_konk = mysqli_query($con, "SELECT * FROM my_stocks WHERE stock_$j != 0");
            while($row_konk = mysqli_fetch_assoc($result_konk)) {
                $query = "INSERT into `varsel` (acc_id, text, date)
                VALUES ('".$row_konk['acc_id']."', '".$stock_name[$j]." har gått konkurs, og siden du hadde beholdning i dette selskapet har du mistet dine aksjer.', '".time()."')";
                $result = mysqli_query($con, $query);
                
                $result = "UPDATE my_stocks SET stock_$j = 0 WHERE acc_id='".$row_konk['acc_id']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
            
            $new_price = mt_rand(15, 125);
        } else {
            $new_price = $stock_price[$j] + $random;
        }
        
        $query = "INSERT into `stocks` (stock_id, price, date)
        VALUES ('".$j."', '".$new_price."', '".time()."')";
        $result = mysqli_query($con, $query);
    }


?>