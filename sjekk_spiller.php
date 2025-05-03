<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else {
    
    if($account_type == 0 || $account_type == 69 || $account_type == 68 || $account_type == 3){
        header("Location: index.php");
    } else {
        
        if(isset($_POST['get_spiller'])){
            $id = $_POST['id'];
            
            header("Location: index.php?side=sjekk_spiller&id=".$id."");
        }

    if(isset($_GET['id'])){
        $check_id = mysqli_query($con, "SELECT ID FROM accounts WHERE ID = '".$_GET['id']."'");
        
        if(mysqli_num_rows($check_id) > 0){
        
$sql = "SELECT * FROM accounts WHERE ID='".$_GET['id']."'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row_ = mysqli_fetch_assoc($query);

$ID_edit =              $row_['ID'];
$role =                 $row_['role'];
$username =             $row_['username'];
$avatar =               $row_['avatar'];
$account_type =         $row_['account_type'];
$email =                $row_['email'];
$reg_ip =               $row_['reg_ip'];
$ip =                   $row_['ip'];
$register_date =        $row_['register_date'];
$exp =                  $row_['exp'];
$money =                $row_['money'];
$bullets =              $row_['bullets'];
$bank_money =           $row_['bank_money'];
$bank_nr =              $row_['bank_nr'];
$rank =                 $row_['rank'];
$city =                 $row_['city'];
$profile =              $row_['profile'];
$decimals =             $row_['decimals'];
$last_active =          $row_['last_active'];
$helse =                $row_['helse'];

if(isset($_GET['ban'])){
    echo '<div class="feedback velykket">
        <span>Brukeren ble bannet.</span> 
    </div>';
}
            
if(isset($_GET['unban'])){
    echo '<div class="feedback velykket">
        <span>Ban ble fjernet.</span> 
    </div>';
}
            
if(isset($_POST['ban'])){
    if($account_type > 0){
    echo '<div class="feedback feilmelding">
        <span>Du kan ikke banne brukere av ledelsen!</span> 
    </div>';
    } else {
        $result = "UPDATE accounts SET account_type = 68 WHERE ID='".$ID_edit."'";
        mysqli_query($con, $result) or die("Bad query: $result");
        
    header("Location: index.php?side=sjekk_spiller&id=".$ID_edit."&ban");
    }
}
            
if(isset($_POST['ip_ban'])){
    if($account_type > 0){
    echo '<div class="feedback feilmelding">
        <span>Du kan ikke ip-banne brukere av ledelsen!</span> 
    </div>';
    } else {
        $query = "INSERT into `ip_ban` (ip_ban)
        VALUES ('$ip')";
        $result = mysqli_query($con, $query);
        
    header("Location: index.php?side=sjekk_spiller&id=".$ID_edit."&ban");
    }
}
            
if(isset($_POST['ip_ban_remove'])){
    $del = mysqli_query($con, "DELETE FROM ip_ban WHERE ip_ban = '".$ip."'") or die(mysqli_error()); 
}
            
            
if(isset($_POST['unban'])){

    $result = "UPDATE accounts SET account_type = 0 WHERE ID='".$ID_edit."'";
    mysqli_query($con, $result) or die("Bad query: $result");
        
    header("Location: index.php?side=sjekk_spiller&id=".$ID_edit."&unban");
}
if(isset($_POST['change_account'])){
    if(isset($_POST['username_new'])){
        $result = "UPDATE accounts SET username = '".$_POST['username_new']."' WHERE ID='".$ID_edit."'";
        mysqli_query($con, $result) or die("Bad query: $result");
    }
    if(isset($_POST['acc_type_new'])){
        $result = "UPDATE accounts SET account_type = '".$_POST['acc_type_new']."' WHERE ID='".$ID_edit."'";
        mysqli_query($con, $result) or die("Bad query: $result");
    }
    if(isset($_POST['email_new'])){
        $result = "UPDATE accounts SET email = '".$_POST['email_new']."' WHERE ID='".$ID_edit."'";
        mysqli_query($con, $result) or die("Bad query: $result");
    }
    if(isset($_POST['exp_new'])){
        $result = "UPDATE accounts SET exp = '".$_POST['exp_new']."' WHERE ID='".$ID_edit."'";
        mysqli_query($con, $result) or die("Bad query: $result");
    }
    if(isset($_POST['penger_new'])){
        $result = "UPDATE accounts SET money = '".$_POST['penger_new']."' WHERE ID='".$ID_edit."'";
        mysqli_query($con, $result) or die("Bad query: $result");
    }
    if(isset($_POST['penger_bank_new'])){
        $result = "UPDATE accounts SET bank_money = '".$_POST['penger_bank_new']."' WHERE ID='".$ID_edit."'";
        mysqli_query($con, $result) or die("Bad query: $result");
    }
    if(isset($_POST['konto_nr_new'])){
        $result = "UPDATE accounts SET bank_nr = '".$_POST['konto_nr_new']."' WHERE ID='".$ID_edit."'";
        mysqli_query($con, $result) or die("Bad query: $result");
    }
    if(isset($_POST['city_new'])){
        $result = "UPDATE accounts SET city = '".$_POST['city_new']."' WHERE ID='".$ID_edit."'";
        mysqli_query($con, $result) or die("Bad query: $result");
    }
    if(isset($_POST['penger_bank_new'])){
        $result = "UPDATE accounts SET bullets = '".$_POST['bullets_new']."' WHERE ID='".$ID_edit."'";
        mysqli_query($con, $result) or die("Bad query: $result");
    }
    if(isset($_POST['health_new'])){
        $result = "UPDATE accounts SET helse = '".$_POST['health_new']."' WHERE ID='".$ID_edit."'";
        mysqli_query($con, $result) or die("Bad query: $result");
    }
    header("Location: index.php?side=sjekk_spiller&id=".$ID_edit."");
}
        
        ?>

<html>

<head></head>

<body>
    <div class="breadcrumb">
        <span style="color: #3e3e3e;">Admin » Sjekk spiller » </span><span style="color: #afafaf;"><?php echo $username ?></span>
        <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
    </div>
    <div class="content">
        <form method="post">
            <table>
                <tr>
                    <th style="width: 40%;">Generelt</th>
                    <th style="width: 60%;">Endringer</th>
                </tr>
<?php
            
        $check_ip_ban = mysqli_query($con, "SELECT * FROM ip_ban WHERE ip_ban = '$ip'");

        if(mysqli_num_rows($check_ip_ban) > 0) {
            echo '<span style="color: red;">Denne IP-en er IP-bannet</span>';
            ?>
                <input type="submit" class="no" style="width:auto;" name="ip_ban_remove" value="Fjern ip ban">
                <?php
        } else {
            
        }
            
            ?>
                <tr>
                    <td>Brukernavn</td>
                    <td><input style="width: 50%;" type="text" name="username_new" value="<?php echo $username ?>"> <?php if($account_type != 68){ ?><input type="submit" class="no" style="width:auto;" name="ban" value="Ban"> <?php } else { ?> <input type="submit" class="no" style="width:auto;" name="unban" value="Unban"> <?php } ?><input type="submit" class="no" style="width:auto;" name="ip_ban" value="ip_ban"></td>
                </tr>
                <tr>
                    <td>Account type</td>
                    <td><input style="width: 50%;" type="text" name="acc_type_new" value="<?php echo $account_type ?>"> = <?php echo $account_type_status[$account_type] ?></td>
                </tr>
                <tr>
                    <td>E-mail</td>
                    <td><input style="width: 100%;" type="text" name="email_new" value="<?php echo $email ?>"></td>
                </tr>
                <tr>
                    <td>EXP</td>
                    <td><input style="width: 50%;" type="text" name="exp_new" value="<?php echo $exp ?>"> = <?php echo number($exp); ?></td>
                </tr>
                <tr>
                    <td>Penger ute</td>
                    <td><input style="width: 50%;" type="text" name="penger_new" value="<?php echo $money ?>">= <?php echo number($money); ?></td>
                </tr>
                <tr>
                    <td>Bank penger</td>
                    <td><input style="width: 50%;" type="text" name="penger_bank_new" value="<?php echo $bank_money ?>"> = <?php echo number($bank_money); ?></td>
                </tr>
                <tr>
                    <td>Konto nr (bank nr)</td>
                    <td><input style="width: 50%;" type="text" name="konto_nr_new" value="<?php echo $bank_nr ?>"> = <?php echo number($bank_nr); ?></td>
                </tr>
                <tr>
                    <td>By</td>
                    <td><input style="width: 50%;" type="text" name="city_new" value="<?php echo $city ?>"> = <?php echo $city_name[$city] ?></td>
                </tr>
                <tr>
                    <td>Kuler</td>
                    <td><input style="width: 50%;" type="text" name="bullets_new" value="<?php echo $bullets ?>"> = <?php echo number($bullets) ?></td>
                </tr>
                <tr>
                    <td>Helse</td>
                    <td><input style="width: 50%;" type="text" name="health_new" value="<?php echo $helse ?>"> = <?php echo number($helse) ?></td>
                </tr>
            </table>
            <input style="width: 97%;" type="submit" name="change_account" value="Utfør endringer">
        </form>
        <div style="margin-top: 10px;" class="header header_mid">
            <span>Felles IP registrering (<?php echo $reg_ip ?>) </span>
        </div>
        <center>
            <?php 
                    $result_multi = mysqli_query($con, "SELECT * FROM accounts WHERE reg_ip='$reg_ip'");
                    while($row_multi = mysqli_fetch_assoc($result_multi)) {
                                                
                    echo fetch_nick($row_multi['ID'], $con);
                    echo ", ";
                        
                    }
                
                ?>
        </center>
        <div style="margin-top: 10px;" class="header header_mid">
            <span>Felles IP (<?php echo $ip ?>) </span>
        </div>
        <center>
            <?php 
                    $result_multi = mysqli_query($con, "SELECT * FROM accounts WHERE ip='$ip'");
                    while($row_multi = mysqli_fetch_assoc($result_multi)) {
                                                
                    echo fetch_nick($row_multi['ID'], $con);
                    echo ", ";
                        
                    }
                
                ?>
        </center>
        <div style="margin-top: 10px;" class="header header_mid">
            <span>Logg</span>
        </div>
        <?php 
        
            if(isset($_POST['spec_id'])){
                header("Location: index.php?side=sjekk_spiller&id=".$_GET['id']."&specific_id=".$_POST['spec_id']."");
            }
        
        ?>
        <div class="pad_10">
            <center>
                Velg spesifikk ID:
                <form method="post">
                    <select style="width: 20%;" name="spec_id" onchange="this.form.submit()">
                        <option value="0"></option>
                        <option value="1">Crypto</option>
                        <option value="2">Kriminalitet</option>
                        <option value="3">Biltyveri</option>
                        <option value="4">Brekk</option>
                        <option value="5">Stjel</option>
                        <option value="6">Raceclub</option>
                        <option value="7">Garasje</option>
                        <option value="8">Fynn</option>
                        <option value="9">Flyplass</option>

                    </select>
                </form>
            </center>
        </div>
        <table border="0" cellspacing="0" cellpadding="0">
            <tr style="height: 30px;">
                <th style="padding-left: 15px; width: 10%;">#ID</th>
                <th style="width: 30%;">Handling</th>
                <th style="width: 20%;">Penger</th>
                <th style="width: 20%">Penger bank</th>
                <th style="width: 20%">Dato</th>
            </tr>
            <?php

        if(isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }

        $no_of_records_per_page = 20;
        $offset = ($pageno - 1) * $no_of_records_per_page;
            
            if(isset($_GET['specific_id'])){
                $total_pages_sql = "SELECT COUNT(*) FROM logg WHERE acc_id='".$_GET['id']."' AND action = '".$_GET['specific_id']."'";
            } else {
                $total_pages_sql = "SELECT COUNT(*) FROM logg WHERE acc_id='".$_GET['id']."'";  
            }
            
        $result = mysqli_query($con, $total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);

            if(isset($_GET['specific_id'])){
                $result_logg = mysqli_query($con, "SELECT * FROM logg WHERE acc_id='".$_GET['id']."' AND action = '".$_GET['specific_id']."' ORDER BY DATE DESC LIMIT $offset, $no_of_records_per_page"); /* LIMIT $offset, $no_of_records_per_page */
            } else {
                $result_logg = mysqli_query($con, "SELECT * FROM logg WHERE acc_id='".$_GET['id']."' ORDER BY DATE DESC LIMIT $offset, $no_of_records_per_page"); /* LIMIT $offset, $no_of_records_per_page */
            }
            while($row_logg = mysqli_fetch_assoc($result_logg)) {

                $action =                $row_logg['action'];
                $text =                  $row_logg['text'];
                $money_logg =            $row_logg['money'];
                $bank_money_logg =       $row_logg['bank_money'];
                $date_logg =             $row_logg['date'];

            ?>
            <tr style="height: 30px;">
                <td style="padding-left: 15px;"><?php echo $action; ?></td>
                <td><?php echo $text; ?></td>
                <td><?php echo number($money_logg); ?></td>
                <td><?php echo number($bank_money_logg); ?></td>
                <td><?php 
                    
                    $date_ = date('Y-m-d', $date_logg);
                    $today = date('Y-m-d');
                    $yesterday = date('Y-m-d', strtotime('yesterday')); 

                    if ($date_ == $today) {
                        echo "I dag kl "; echo date('H:i:s', $date_logg);
                    } elseif ($date_ == $yesterday) {
                        echo "I går";
                        echo " kl "; echo date('H:i:s', $date_logg);
                    } else {
                        echo " "; echo date('d', $date_logg);
                        echo ". "; echo $month_short[date('n', $date_logg)];
                        echo ". kl "; echo date('H:i:s', $date_logg);
                    }

                    ?>
            </tr>
            <?php } ?>
        </table>
        <?php if($total_pages <= 1) { } else { ?>
        <div style="margin-top: 4px" class="content">
            <div class="pad_5 pagination">
                <div style="width: 20%; float: left;">
                    <span><a href="index.php?side=sjekk_spiller&id=<?php echo $_GET['id']; ?>&pageno=1">«« Første side</a></span>
                </div>
                <div style="width: 20%; float: left;">
                    <span class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                        <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "index.php?side=sjekk_spiller&id=".$_GET['id']."&pageno=".($pageno - 1); } ?>">« Forrige side</a>
                    </span>
                </div>
                <div style="width: 20%; float: left;">
                    <span style="text-align: center;">Side <?php echo $pageno ?></span>
                </div>
                <div style="width: 20%; float: left;">
                    <span class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                        <a style="float: right;" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "index.php?side=sjekk_spiller&id=".$_GET['id']."&pageno=".($pageno + 1); } ?>">Neste side »</a>
                    </span>
                </div>
                <div style="width: 20%; float: left;">
                    <span><a style="float: right;" href="index.php?side=sjekk_spiller&id=<?php echo $_GET['id']; ?>&pageno=<?php echo $total_pages; ?>">Siste side »»</a></span>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</body>

</html>

<?php
            
        } else {
            echo '<div class="feedback feilmelding">
                <span>ID = ';
            echo $_GET['id'];
            echo ' eksisterer ikke i databasen. </span> 
            </div>';
        }
    } else {

?>
<!-- CONTENT -->
<html>

<head></head>

<body>
    <div class="breadcrumb">
        <span style="color: #3e3e3e;">Admin » </span><span style="color: #afafaf;">Sjekk spiller</span>
        <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
    </div>
    <div class="content">
        <form method="post">
            <input style="width: 27.2%; margin-left: 10px;" type="text" name="id" placeholder="Legg inn ID" required>
            <input style="width: 27.2%;" type="submit" name="get_spiller" value="Finn info">
        </form>
    </div>
</body>

</html>
<?php
            
        }
    }
}

?>
