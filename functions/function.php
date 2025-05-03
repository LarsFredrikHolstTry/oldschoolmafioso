<?php

ob_start();
include('./auth.php');

$sql = "SELECT * FROM accounts WHERE ID='".$_SESSION['ID']."'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row = mysqli_fetch_assoc($query);

$ID =                   $row['ID'];
$role =                 $row['role'];
$username =             $row['username'];
$avatar =               $row['avatar'];
$account_type =         $row['account_type'];
$email =                $row['email'];
$ip =                   $row['ip'];
$register_date =        $row['register_date'];
$exp =                  $row['exp'];
$money =                $row['money'];
$bullets_mine =         $row['bullets'];
$bank_money =           $row['bank_money'];
$bank_nr =              $row['bank_nr'];
$rank =                 $row['rank'];
$city =                 $row['city'];
$profile =              $row['profile'];
$decimals =             $row['decimals'];
$last_active =          $row['last_active'];
$vapen =                $row['vapen'];
$beskyttelse =          $row['beskyttelse'];
$bunker =               $row['bunker'];
$helse =                $row['helse'];
$det_pris =             $row['detektiv_pris'];
$det_tid =              $row['detektiv_tid'];
$header =               $row['header'];
$design =               $row['design'];
$act_bar =              $row['action_bar'];

function hash_cookie($value){
    $cookie_test = $value;
    $hashed_cookie = password_hash($cookie_test, PASSWORD_DEFAULT);
    return $hashed_cookie;
}

$sql = "SELECT * FROM bunker WHERE acc_id='$ID'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row_bunker = mysqli_fetch_assoc($query);

$bunker_status =        $row_bunker['bunker_status'];
$bunker_seconds =       $row_bunker['bunker_seconds'];
$modem =                $row_bunker['modem'];

$time = time();

$del = mysqli_query($con, "DELETE FROM half_hp WHERE timeout < $time") or die(mysqli_error()); 

$result = "UPDATE oppdrag SET value = '0' WHERE value < 0";
mysqli_query($con, $result) or die("Bad query: $result");

$result = "UPDATE family SET status = '1', countdown = '0' WHERE countdown < $time";
mysqli_query($con, $result) or die("Bad query: $result");

$result = "UPDATE bunker SET bunker_status = '0', bunker_seconds = '0' WHERE bunker_seconds < $time";
mysqli_query($con, $result) or die("Bad query: $result");

$result = "UPDATE flyplass_cd SET flyplass_status = '0', flyplass_seconds = '0' WHERE flyplass_seconds < $time";
mysqli_query($con, $result) or die("Bad query: $result");

$result = "UPDATE heist_cd SET heist_status = '0', heist_seconds = '0' WHERE heist_seconds < $time";
mysqli_query($con, $result) or die("Bad query: $result");

$result = "UPDATE drep_cd SET drep_status = '0', drep_seconds = '0' WHERE drep_seconds < $time";
mysqli_query($con, $result) or die("Bad query: $result");

$result = "UPDATE race_club_cd SET race_club_status = '0', race_club_seconds = '0' WHERE race_club_seconds < $time";
mysqli_query($con, $result) or die("Bad query: $result");

$result = "UPDATE accounts SET account_type = 69 WHERE helse <= 0";
mysqli_query($con, $result) or die("Bad query: $result");

    $check_kf = mysqli_query($con, "SELECT * FROM kf WHERE NOT owner = 0");

    if(mysqli_num_rows($check_kf) > 0) {
        $result_kf = mysqli_query($con, "SELECT * FROM kf WHERE NOT owner = 0");
        while($row_kf = mysqli_fetch_assoc($result_kf)) {
        $sql = "SELECT * FROM accounts WHERE ID='".$row_kf['owner']."'";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row_dead = mysqli_fetch_assoc($query);
            
            if($row_dead['account_type'] == 69 || $row_dead['account_type'] == 68){
                $del = mysqli_query($con, "DELETE FROM kf WHERE owner = '".$row_kf['owner']."'") or die(mysqli_error()); 
            }
        }
    }

    $check_detektiv = mysqli_query($con, "SELECT * FROM detektiv");
    if(mysqli_num_rows($check_detektiv) > 0) {
        $result_detektiv = mysqli_query($con, "SELECT * FROM detektiv");
        while($row_detektiv = mysqli_fetch_assoc($result_detektiv)) {
            if($row_detektiv['countdown'] < time()){
                
                $query = "INSERT into `varsel` (acc_id, text, date)
                VALUES ('".$row_detektiv['acc_id']."', '".$row_detektiv['text']."', '".time()."')";
                $result = mysqli_query($con, $query);
                
                $del = mysqli_query($con, "DELETE FROM detektiv WHERE acc_id = '".$row_detektiv['acc_id']."'") or die(mysqli_error()); 
            }
        }
    }

    $check_kasst = mysqli_query($con, "SELECT * FROM fynn WHERE cat = 0");
    if(mysqli_num_rows($check_kasst) > 0) { 
        $result_fynn = mysqli_query($con, "SELECT * FROM fynn WHERE date < $time AND cat = 0");
        while($row_fynn = mysqli_fetch_assoc($result_fynn)) {
            
            $acc_id = $row_fynn['acc_id'];
            $ID_car = $row_fynn['ID'];

            $query = "INSERT into `cars` (acc_id, car_id, city, km)
            VALUES ('$acc_id', '".$row_fynn['car_type']."', '".$row_fynn['city']."', '".$row_fynn['km']."')";
            $result = mysqli_query($con, $query);

            $query = "INSERT into `varsel` (acc_id, text, date)
            VALUES ('$acc_id', 'Din bil på fynn.no ble ikke solgt innen 12 timer og den blir derfor flyttet til din garasje.', '".time()."')";
            $result = mysqli_query($con, $query);

            $del = mysqli_query($con, "DELETE FROM fynn WHERE ID = $ID_car") or die(mysqli_error()); 
        }
    }

    $check_kf = mysqli_query($con, "SELECT * FROM fynn WHERE cat = 1");
    if(mysqli_num_rows($check_kf) > 0) { 
        $result_fynn = mysqli_query($con, "SELECT * FROM fynn WHERE date < $time AND cat = 1");
        while($row_fynn = mysqli_fetch_assoc($result_fynn)) {
            
            $acc_id = $row_fynn['acc_id'];
            $ID_kf = $row_fynn['ID'];

            $query = "INSERT into `kf` (owner, price, bullets, city)
            VALUES ('$acc_id', '6000000', '0', '".$row_fynn['city']."')";
            $result = mysqli_query($con, $query);

            $query = "INSERT into `varsel` (acc_id, text, date)
            VALUES ('$acc_id', 'Din kulefabrikk på fynn.no ble ikke solgt innen 12 timer.', '".time()."')";
            $result = mysqli_query($con, $query);

            $del = mysqli_query($con, "DELETE FROM fynn WHERE ID = $ID_kf") or die(mysqli_error()); 
        }
    }



    $check_fynn_bullets = mysqli_query($con, "SELECT * FROM fynn WHERE cat = 2");
    if(mysqli_num_rows($check_fynn_bullets) > 0) { 
        $result_fynn = mysqli_query($con, "SELECT * FROM fynn WHERE date < $time AND cat = 2");
        while($row_fynn = mysqli_fetch_assoc($result_fynn)) {
            
            $acc_id = $row_fynn['acc_id'];
            $ID_bull = $row_fynn['ID'];

            $result = "UPDATE accounts SET bullets = (bullets + ".$row_fynn['km'].") WHERE ID='".$acc_id."'";
            mysqli_query($con, $result) or die("Bad query: $result");

            $query = "INSERT into `varsel` (acc_id, text, date)
            VALUES ('$acc_id', 'Dine kuler ble ikke solgt innen 12 timer og du har dermed fått kulene tilbake.', '".time()."')";
            $result = mysqli_query($con, $query);

            $del = mysqli_query($con, "DELETE FROM fynn WHERE ID = $ID_bull") or die(mysqli_error()); 
        }
    }


    $check_kasst = mysqli_query($con, "SELECT * FROM kast_mynt");
    if(mysqli_num_rows($check_kasst) > 0) { 
        $result_km = mysqli_query($con, "SELECT * FROM kast_mynt WHERE countdown < $time");
        while($row_km = mysqli_fetch_assoc($result_km)) {
            
            $innsats = $row_km['bet'];
            $id_kass = $row_km['player_1'];

            $result = "UPDATE accounts SET money = (money + $innsats) WHERE ID = $id_kass";
            mysqli_query($con, $result) or die("Bad query: $result");
            
                $query = "INSERT into `varsel` (acc_id, text, date)
                VALUES ('$id_kass', 'Ingen tok deg på kast mynt og du får derfor pengene tilbake.', '".time()."')";
                $result = mysqli_query($con, $query);

            $del = mysqli_query($con, "DELETE FROM kast_mynt WHERE countdown < $time") or die(mysqli_error()); 
        }
    }

    $check_fam = mysqli_query($con, "SELECT * FROM family_member WHERE role = 1");
    if(mysqli_num_rows($check_fam) > 0) {
        $result_fam = mysqli_query($con, "SELECT * FROM family_member WHERE role = 1");
        while($row_fam = mysqli_fetch_assoc($result_fam)) {
        $sql = "SELECT * FROM accounts WHERE ID='".$row_fam['acc_id']."'";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row_dead = mysqli_fetch_assoc($query);
            
            if($row_dead['account_type'] == 69 || $row_dead['account_type'] == 68){
                $del = mysqli_query($con, "DELETE FROM family_applicant WHERE family_id = '".$row_fam['family_id']."'") or die(mysqli_error()); 
                
                $del = mysqli_query($con, "DELETE FROM family_member WHERE acc_id = '".$row_fam['acc_id']."'") or die(mysqli_error()); 

                $del = mysqli_query($con, "DELETE FROM family WHERE ID = '".$row_fam['family_id']."'") or die(mysqli_error()); 
            }
        }
    }

    $check_fam_okonom = mysqli_query($con, "SELECT * FROM family_member WHERE role = 2");
    if(mysqli_num_rows($check_fam_okonom) > 0) {
        $result_fam_okonom = mysqli_query($con, "SELECT * FROM family_member WHERE role = 2");
        while($row_fam_okonom = mysqli_fetch_assoc($result_fam_okonom)) {
            $check_fam_existenca = mysqli_query($con, "SELECT * FROM family WHERE ID = '".$row_fam_okonom['family_id']."'");
            if(mysqli_num_rows($check_fam_existenca) > 0) {

            } else {
                $del = mysqli_query($con, "DELETE FROM family_member WHERE acc_id = '".$row_fam_okonom['acc_id']."'") or die(mysqli_error()); 
            }
        }
    }

    $check_fam_member = mysqli_query($con, "SELECT * FROM family_member WHERE role = 0");
    if(mysqli_num_rows($check_fam_member) > 0) {
        $result_fam_member = mysqli_query($con, "SELECT * FROM family_member WHERE role = 0");
        while($row_fam_member = mysqli_fetch_assoc($result_fam_member)) {
            $check_fam_existence = mysqli_query($con, "SELECT * FROM family WHERE ID = '".$row_fam_member['family_id']."'");
            if(mysqli_num_rows($check_fam_existence) > 0) {

            } else {
                $del = mysqli_query($con, "DELETE FROM family_member WHERE acc_id = '".$row_fam_member['acc_id']."'") or die(mysqli_error()); 
            }
        }
    }

    $check_dead_fam = mysqli_query($con, "SELECT * FROM family_member WHERE role = 0");
    if(mysqli_num_rows($check_dead_fam) > 0) {
        $result_dead_fam = mysqli_query($con, "SELECT * FROM family_member WHERE role = 0");
        while($row_dead_fam = mysqli_fetch_assoc($result_dead_fam)) {
        $sql = "SELECT * FROM accounts WHERE ID='".$row_dead_fam['acc_id']."'";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row_dead = mysqli_fetch_assoc($query);
            
            if($row_dead['account_type'] == 69 || $row_dead['account_type'] == 68){
                $del = mysqli_query($con, "DELETE FROM family_applicant WHERE family_id = '".$row_dead_fam['family_id']."'") or die(mysqli_error()); 
                
                $del = mysqli_query($con, "DELETE FROM family_member WHERE acc_id = '".$row_dead_fam['acc_id']."'") or die(mysqli_error()); 
            }
        }
    }

    $check_dead_okonom = mysqli_query($con, "SELECT * FROM family_member WHERE role = 2");
    if(mysqli_num_rows($check_dead_okonom) > 0) {
        $result_dead_okonom = mysqli_query($con, "SELECT * FROM family_member WHERE role = 2");
        while($row_dead_okonom = mysqli_fetch_assoc($result_dead_okonom)) {
        $sql = "SELECT * FROM accounts WHERE ID='".$row_dead_okonom['acc_id']."'";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row_dead = mysqli_fetch_assoc($query);
            
            if($row_dead['account_type'] == 69 || $row_dead['account_type'] == 68){
                $del = mysqli_query($con, "DELETE FROM family_applicant WHERE family_id = '".$row_dead_okonom['family_id']."'") or die(mysqli_error()); 
                
                $del = mysqli_query($con, "DELETE FROM family_member WHERE acc_id = '".$row_dead_okonom['acc_id']."'") or die(mysqli_error()); 
            }
        }
    }


if($account_type == 69 || $account_type == 68){
    $cookie_name = "remember_forever";
    unset($_COOKIE[$cookie_name]);
    // empty value and expiration one hour before
    setcookie($cookie_name, '', time() - 3600);
    
    session_destroy();
}

$sql = "SELECT * FROM page_views WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row_pw = mysqli_fetch_assoc($query);

$sql = "SELECT * FROM oppdrag WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row_mission = mysqli_fetch_assoc($query);

$oppdrag =  $row_mission['oppdrag'];
$value =    $row_mission['value'];

$payout_enkel =         15000000;   // 5 000 000 kr
$exp_enkel =            550;        // 500 exp

$payout_vanskelig =     35000000;   // 50 000 000 kr
$exp_vanskelig =        2250;       // 1500 exp

$check_sort = mysqli_query($con, "SELECT * FROM hurtig_oppdrag WHERE acc_id = '$ID'");
if(mysqli_num_rows($check_sort) > 0) {
    $sql = "SELECT * FROM hurtig_oppdrag WHERE acc_id='$ID'";
    $query = mysqli_query($con, $sql) or die (mysqli_error());
    $row_ho = mysqli_fetch_assoc($query);
    
    // enkle hurtige oppdrag
    $hurtig_oppdrag[0] = "Utfør 10 krim";
    $kriterium[0] =      10;
    $hurtig_oppdrag[1] = "Stjel 1 Tesla Cybertruck";
    $kriterium[1] =      1;
    $hurtig_oppdrag[2] = "Lag 2 velykkede filmer";
    $kriterium[2] =      2;

    // vanskelige hurtige oppdrag
    $hurtig_oppdrag[3] = "Stjel 15 biler";
    $kriterium[3] =      15;
    $hurtig_oppdrag[4] = "Stjel 3 Nissan Leaf";
    $kriterium[4] =      3;
    $hurtig_oppdrag[5] = "Lag 4 velykkede filmer";
    $kriterium[5] =      4;

    $oppdrag_ho =       $row_ho['oppdrag'];
    $value_ho =         $row_ho['value'];
    $ho_seconds =       $row_ho['oppdrag_seconds'];
    $ho_status =        $row_ho['oppdrag_status'];
    
    if($ho_seconds < time() && $value_ho < $kriterium[$oppdrag_ho]){
        $query = "INSERT into `varsel` (acc_id, text, date)
        VALUES ('$ID', 'Du klarte dessverre ikke det hurtige oppdraget du var på.', '".time()."')";
        $result = mysqli_query($con, $query);

        $del = mysqli_query($con, "DELETE FROM hurtig_oppdrag WHERE acc_id = '$ID'") or die(mysqli_error()); 
    } elseif($ho_seconds > time() && $value_ho <= $kriterium[$oppdrag_ho]) {
        if($oppdrag_ho == 0 || $oppdrag_ho == 1 || $oppdrag_ho == 2){
            if($value_ho >= $kriterium[$oppdrag_ho]){
                $query = "INSERT into `varsel` (acc_id, text, date)
                VALUES ('$ID', 'Du har klart et enkelt hurtig oppdrag og får derfor 15 000 000kr og 550exp', '".time()."')";
                $result = mysqli_query($con, $query);

                $result = "UPDATE accounts SET money = ($money + $payout_enkel), exp = ($exp + $exp_enkel) WHERE ID='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");

                $result = "UPDATE daily_exp SET exp = (exp + $exp_enkel) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");

                $del = mysqli_query($con, "DELETE FROM hurtig_oppdrag WHERE acc_id = '$ID'") or die(mysqli_error()); 
            }
        } elseif($oppdrag_ho == 3 || $oppdrag_ho == 4 || $oppdrag_ho == 5){
            if($value_ho == $kriterium[$oppdrag_ho]){
                $query = "INSERT into `varsel` (acc_id, text, date)
                VALUES ('$ID', 'Du har klart et vanskelig hurtig oppdrag og får derfor 35 000 000kr og 2 250exp', '".time()."')";
                $result = mysqli_query($con, $query);

                $result = "UPDATE accounts SET money = ($money + $payout_vanskelig), exp = ($exp + $exp_vanskelig) WHERE ID='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
                
                $result = "UPDATE daily_exp SET exp = (exp + $exp_vanskelig) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
                
                if($oppdrag == 26 && $city == 4){
                    $result = "UPDATE oppdrag SET value = ($value + 1) WHERE acc_id='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                }

                $del = mysqli_query($con, "DELETE FROM hurtig_oppdrag WHERE acc_id = '$ID'") or die(mysqli_error()); 
            }
        }
    }
}


$days = [" ", "Mandag", "Tirsdag", "Onsdag", "Torsdag", "Fredag", "Lørdag", "Søndag"];
$month = [" ", "Januar", "Februar", "Mars", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Desember"];

$month_short = [" ", "Jan", "Feb", "Mars", "April", "Mai", "Juni", "Juli", "Aug", "Sep", "Okt", "Nov", "Des"];
$days_short = ["Søn", "Man", "Tirs", "Ons", "Tors", "Fre", "Lør"];

$time = time();

/**
* for a 30 minute timeout, specified in seconds
*/
$timeout_duration = 31556952;

/**
* Here we look for the user's LAST_ACTIVITY timestamp. If
* it's set and indicates our $timeout_duration has passed,
* blow away any previous $_SESSION data and start a new one.
*/
if (isset($_SESSION['last_active']) && 
   ($time - $_SESSION['last_active']) > $timeout_duration) {
    session_unset();
    session_destroy();
    session_start();
}

/**
* Finally, update LAST_ACTIVITY so that our timeout
* is based on it and not the user's login time.
*/
$_SESSION['last_active'] = $time;

$result = mysqli_query($con, "UPDATE accounts SET last_active='$time' WHERE ID='$ID'")
or die (mysqli_error($con));

///////////////////////////////////
/*          HAPPY HOUR           */
///////////////////////////////////
$sql = "SELECT * FROM happy_hour";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row = mysqli_fetch_assoc($query);

$happy_hour =           $row['happy_hour'];
$start =                $row['start'];
$end =                  $row['end'];

///////////////////////////////////
/*     LEGGE INN I race_club_cd       */
///////////////////////////////////
$check_sort = mysqli_query($con, "SELECT * FROM race_club_cd WHERE acc_id = '$ID'");

if(mysqli_num_rows($check_sort) != 1) {
    $query = "INSERT into `race_club_cd` (acc_id)
    VALUES ('$ID')";
    $result = mysqli_query($con, $query);
}

///////////////////////////////////
/*     LEGGE INN I jackpot       */
///////////////////////////////////
$check_sort = mysqli_query($con, "SELECT * FROM jackpot WHERE ID = '1'");

if(mysqli_num_rows($check_sort) != 1) {
    $query = "INSERT into `jackpot` (jackpot)
    VALUES ('1000000')";
    $result = mysqli_query($con, $query);
}


///////////////////////////////////
/*     LEGGE INN I drep_cd       */
///////////////////////////////////
$check_sort = mysqli_query($con, "SELECT * FROM drep_cd WHERE acc_id = '$ID'");

if(mysqli_num_rows($check_sort) != 1) {
    $query = "INSERT into `drep_cd` (acc_id)
    VALUES ('$ID')";
    $result = mysqli_query($con, $query);
}

///////////////////////////////////
/*     LEGGE INN I my_stocks       */
///////////////////////////////////
$check_sort = mysqli_query($con, "SELECT * FROM my_stocks WHERE acc_id = '$ID'");

if(mysqli_num_rows($check_sort) != 1) {
    $query = "INSERT into `my_stocks` (acc_id)
    VALUES ('$ID')";
    $result = mysqli_query($con, $query);
}

///////////////////////////////////
/*     LEGGE INN I flyplass_cd       */
///////////////////////////////////
$check_sort = mysqli_query($con, "SELECT * FROM crypto_farm WHERE acc_id = '$ID'");

if(mysqli_num_rows($check_sort) != 1) {
    $query = "INSERT into `crypto_farm` (acc_id)
    VALUES ('$ID')";
    $result = mysqli_query($con, $query);
}

///////////////////////////////////
/*     LEGGE INN I paskeegg       */
///////////////////////////////////
$check_sort = mysqli_query($con, "SELECT * FROM paskeegg WHERE acc_id = '$ID'");

if(mysqli_num_rows($check_sort) != 1) {
    $query = "INSERT into `paskeegg` (acc_id)
    VALUES ('$ID')";
    $result = mysqli_query($con, $query);
}

///////////////////////////////////
/*     LEGGE INN I flyplass_cd       */
///////////////////////////////////
$check_sort = mysqli_query($con, "SELECT * FROM flyplass_cd WHERE acc_id = '$ID'");

if(mysqli_num_rows($check_sort) != 1) {
    $query = "INSERT into `flyplass_cd` (acc_id)
    VALUES ('$ID')";
    $result = mysqli_query($con, $query);
}

///////////////////////////////////
/*     LEGGE INN I page_views       */
///////////////////////////////////
$check_sort = mysqli_query($con, "SELECT * FROM page_views WHERE acc_id = '$ID'");

if(mysqli_num_rows($check_sort) != 1) {
    $query = "INSERT into `page_views` (acc_id)
    VALUES ('$ID')";
    $result = mysqli_query($con, $query);
}

///////////////////////////////////
/*     LEGGE INN I stats         */
///////////////////////////////////
$check_sort = mysqli_query($con, "SELECT * FROM daily_exp WHERE acc_id = '$ID'");

if(mysqli_num_rows($check_sort) != 1) {
    $query = "INSERT into `daily_exp` (acc_id)
    VALUES ('$ID')";
    $result = mysqli_query($con, $query);
}

///////////////////////////////////
/*     LEGGE INN I livvakt       */
///////////////////////////////////
$check_sort = mysqli_query($con, "SELECT * FROM livvakt WHERE acc_id = '$ID'");

if(mysqli_num_rows($check_sort) != 1) {
    $query = "INSERT into `livvakt` (acc_id)
    VALUES ('$ID')";
    $result = mysqli_query($con, $query);
}

///////////////////////////////////
/*     LEGGE INN I stats       */
///////////////////////////////////
$check_sort = mysqli_query($con, "SELECT * FROM stats WHERE acc_id = '$ID'");

if(mysqli_num_rows($check_sort) != 1) {
    $query = "INSERT into `stats` (acc_id)
    VALUES ('$ID')";
    $result = mysqli_query($con, $query);
}

///////////////////////////////////
/*     LEGGE INN I narkotika       */
///////////////////////////////////
$check_sort = mysqli_query($con, "SELECT * FROM narkotika WHERE acc_id = '$ID'");

if(mysqli_num_rows($check_sort) != 1) {
    $query = "INSERT into `narkotika` (acc_id)
    VALUES ('$ID')";
    $result = mysqli_query($con, $query);
}

///////////////////////////////////
/*     LEGGE INN I garage_security       */
///////////////////////////////////
$check_sort = mysqli_query($con, "SELECT * FROM garage_security WHERE acc_id = '$ID'");

if(mysqli_num_rows($check_sort) != 1) {
    $query = "INSERT into `garage_security` (acc_id)
    VALUES ('$ID')";
    $result = mysqli_query($con, $query);
}

///////////////////////////////////
/*     LEGGE INN I bnker       */
///////////////////////////////////
$check_sort = mysqli_query($con, "SELECT * FROM bunker WHERE acc_id = '$ID'");

if(mysqli_num_rows($check_sort) != 1) {
    $query = "INSERT into `bunker` (acc_id)
    VALUES ('$ID')";
    $result = mysqli_query($con, $query);
}

///////////////////////////////////
/*     LEGGE INN I Steal       */
///////////////////////////////////
$check_sort = mysqli_query($con, "SELECT * FROM steal WHERE acc_id = '$ID'");

if(mysqli_num_rows($check_sort) != 1) {
    $query = "INSERT into `steal` (acc_id)
    VALUES ('$ID')";
    $result = mysqli_query($con, $query);
}

///////////////////////////////////
/*     LEGGE INN I Oppdrag       */
///////////////////////////////////
$check_sort = mysqli_query($con, "SELECT * FROM oppdrag WHERE acc_id = '$ID'");

if(mysqli_num_rows($check_sort) != 1) {
    $query = "INSERT into `oppdrag` (acc_id)
    VALUES ('$ID')";
    $result = mysqli_query($con, $query);
}

///////////////////////////////////
/*     LEGGE INN I rank_up       */
///////////////////////////////////
$check_sort = mysqli_query($con, "SELECT * FROM rank_up WHERE acc_id = '$ID'");

if(mysqli_num_rows($check_sort) != 1) {
    $query = "INSERT into `rank_up` (acc_id)
    VALUES ('$ID')";
    $result = mysqli_query($con, $query);
}

///////////////////////////////////
/*      LEGGE INN I BREKK        */
///////////////////////////////////
$check_sort = mysqli_query($con, "SELECT * FROM brekk WHERE acc_id = '$ID'");

if(mysqli_num_rows($check_sort) != 1) {
    $query = "INSERT into `brekk` (acc_id)
    VALUES ('$ID')";
    $result = mysqli_query($con, $query);
}

///////////////////////////////////
/*      LEGGE INN I CRIME        */
///////////////////////////////////
$check_sort = mysqli_query($con, "SELECT * FROM crime WHERE acc_id = '$ID'");

if(mysqli_num_rows($check_sort) != 1) {
    $query = "INSERT into `crime` (acc_id)
    VALUES ('$ID')";
    $result = mysqli_query($con, $query);
}

///////////////////////////////////
/*     LEGGE INN I HEIST_CD      */
///////////////////////////////////
$check_sort = mysqli_query($con, "SELECT * FROM heist_cd WHERE acc_id = '$ID'");

if(mysqli_num_rows($check_sort) != 1) {
    $query = "INSERT into `heist_cd` (acc_id)
    VALUES ('$ID')";
    $result = mysqli_query($con, $query);
}

///////////////////////////////////
/*       LEGGE INN I GTA         */
///////////////////////////////////
$check_sort = mysqli_query($con, "SELECT * FROM gta WHERE acc_id = '$ID'");

if(mysqli_num_rows($check_sort) != 1) {
    $query = "INSERT into `gta` (acc_id)
    VALUES ('$ID')";
    $result = mysqli_query($con, $query);
}

///////////////////////////////////
/*  LEGGE INN I filmproduction   */
///////////////////////////////////
$check_sort = mysqli_query($con, "SELECT * FROM filmproduction WHERE acc_id = '$ID'");

if(mysqli_num_rows($check_sort) != 1) {
    $query = "INSERT into `filmproduction` (acc_id)
    VALUES ('$ID')";
    $result = mysqli_query($con, $query);
}

//////////////////////////////
// RESET BREKK VENTETID //
//////////////////////////////
$sql_brekk = "SELECT * from brekk WHERE acc_id='$ID'";
$result_brekk = mysqli_query($con, $sql_brekk);

$current_time = time();
while($rows_brekk = mysqli_fetch_array($result_brekk)){
    $timeleftbrekk = $rows_brekk['brekk_seconds'];
    $last_brekk = ($timeleftbrekk - $current_time);
}

if($last_brekk <= 0){
    $result = mysqli_query($con, "UPDATE brekk SET brekk_status='0', brekk_seconds='0' WHERE acc_id='$ID'")
    or die (mysqli_error($con));
}
//////////////////////////////
// RESET BREKK VENTETID //
//////////////////////////////

//////////////////////////////
// RESET MOVIEPRODUCTION VENTETID //
//////////////////////////////
$sql2 = "SELECT * from filmproduction WHERE acc_id='$ID'";
$result2 = mysqli_query($con, $sql2);

$current_time = time();
while($rows2 = mysqli_fetch_array($result2)){
    $timeleft1 = $rows2['filmproduction_seconds'];
    $last_film = ($timeleft1 - $current_time);
}

if($last_film <= 0){
    $result = mysqli_query($con, "UPDATE filmproduction SET filmproduction_status='0', filmproduction_seconds='0' WHERE acc_id='$ID'")
    or die (mysqli_error($con));
}
//////////////////////////////
// RESET MOVIEPRODUCTION VENTETID //
//////////////////////////////

//////////////////////////////
// RESET KRIM VENTETID //
//////////////////////////////
$sql2 = "SELECT * from crime WHERE acc_id='$ID'";
$result2 = mysqli_query($con, $sql2);

$current_time = time();
while($rows2 = mysqli_fetch_array($result2)){
    $timeleft1 = $rows2['crime_seconds'];
    $last_krim = ($timeleft1 - $current_time);
}

if($last_krim <= 0){
    $result = mysqli_query($con, "UPDATE crime SET crime_status='0', crime_seconds='0' WHERE acc_id='$ID'")
    or die (mysqli_error($con));
}
//////////////////////////////
// RESET KRIM VENTETID //
//////////////////////////////

//////////////////////////////
// RESET GTA VENTETID //
//////////////////////////////
$sql = "SELECT * from gta WHERE acc_id='$ID'";
$result = mysqli_query($con, $sql);

$current_time = time();
while($rows = mysqli_fetch_array($result)){
    $timeleft = $rows['gta_seconds'];
    $last_gta = ($timeleft - $current_time);
}

if($last_gta <= 0){
    $result = mysqli_query($con, "UPDATE gta SET gta_status='0', gta_seconds='0' WHERE acc_id='$ID'")
    or die (mysqli_error($con));
}
//////////////////////////////
// RESET GTA VENTETID //
//////////////////////////////

//////////////////////////////
// RESET STJEL VENTETID //
//////////////////////////////
$sql = "SELECT * from steal WHERE acc_id='$ID'";
$result = mysqli_query($con, $sql);

$current_time = time();
while($rows = mysqli_fetch_array($result)){
    $timeleft = $rows['steal_seconds'];
    $last_steal = ($timeleft - $current_time);
}

if($last_steal <= 0){
    $result = mysqli_query($con, "UPDATE steal SET steal_status='0', steal_seconds='0' WHERE acc_id='$ID'")
    or die (mysqli_error($con));
}
//////////////////////////////
// RESET STJEL VENTETID //
//////////////////////////////


// Rolle statuser
$role_status[0] = "N/A";
$role_status[1] = "Investor";
$role_status[2] = "Torpedo";
$role_status[3] = "Mafioso";

// Benefits
$role_benefit[1] = "10% avslag på alt";
$role_benefit[2] = "10% mindre kuler ved drap";
$role_benefit[3] = "10% mer exp";

// Account types
$account_type_status[69] = "<span style='color: red '>Død</span>";
$account_type_status[68] = "<span style='color: red '>Deaktivert</span>";
$account_type_status[0] = "Bruker";
$account_type_status[1] = "Moderator";
$account_type_status[2] = "Administrator";
$account_type_status[3] = "Forum Moderator";

// Byer
$city_name[0] = "Kristiansand";
$city_name[1] = "Oslo";
$city_name[2] = "Bergen";
$city_name[3] = "Stavanger";
$city_name[4] = "Tromsø";

if($role == 1){
    $city_price[0] =  355000 * 0.9;
} else {
    $city_price[0] =  355000;
}

if($role == 1){
    $city_price[1] =  405000 * 0.9;
} else {
    $city_price[1] =  405000;
}

if($role == 1){
    $city_price[2] =  347000 * 0.9;
} else {
    $city_price[2] =  347000;
}

if($role == 1){
    $city_price[3] =  514000 * 0.9;
} else {
    $city_price[3] =  514000;
}

if($role == 1){
    $city_price[4] =  275000 * 0.9;
} else {
    $city_price[4] =  275000;
}

$reise_ventetid = 270;

// biler

// Class 1
$car[0] = "1995 Honda Civic Si Hatchback";
$car_price[0] = 50000;
$car[1] = "2002 Volkswagen Passat Sedan";
$car_price[1] = 70000;
$car[2] = "1999 BMW 5-serie E39";
$car_price[2] = 30000;
$car[3] = "2000 Volvo V70";
$car_price[3] = 50000;
$car_km[0] = rand(100000, 400000);

// Class 2
$car[4] = "2011 Toyota Avensis Advance";
$car_price[4] = 150000;
$car[5] = "2013 Nissan Leaf";
$car_price[5] = 120000;
$car[6] = "2009 Jaguar XF";
$car_price[6] = 330000;
$car[7] = "2006 Audi A6";
$car_price[7] = 130000;
$car_km[1] = rand(5000, 50000);

// Class 3
$car[8] = "2019 Tesla Model 3";
$car_price[8] = 660000;
$car[9] = "2019 Audi Q3 Sport Advanced";
$car_price[9] = 960000;
$car[10] = "2019 G-Klasse Geländewagen";
$car_price[10] = 1550000;
$car[11] = "2019 Aston Martin Vanquish";
$car_price[11] = 1150000;
$car[12] = "2020 Tesla Cybertruck";
$car_price[12] = 650000;
$car_km[2] = rand(0, 10000);

////////////////////////////////////////
/*               RANKS                */
////////////////////////////////////////
$sql = "SELECT * FROM rank_up WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row = mysqli_fetch_assoc($query);

$rank_1 = $row['rank_1'];
$rank_2 = $row['rank_2'];
$rank_3 = $row['rank_3'];
$rank_4 = $row['rank_4'];
$rank_5 = $row['rank_5'];
$rank_6 = $row['rank_6'];
$rank_7 = $row['rank_7'];
$rank_8 = $row['rank_8'];
$rank_9 = $row['rank_9'];
$rank_10 = $row['rank_10'];
$rank_11 = $row['rank_11'];
$rank_12 = $row['rank_12'];
$rank_13 = $row['rank_13'];

$rank_name[0] =     "Sivilist";
$rank_exp_from[0] =	0;
$rank_exp_to[0] =	5000;

$rank_name[1] =     "Assistent";
$rank_exp_from[1] =	5001;
$rank_exp_to[1] =	25000;

$rank_name[2] =     "Pøbel";
$rank_exp_from[2] =	25001;
$rank_exp_to[2] =	75000;

$rank_name[3] =     "Soldat";
$rank_exp_from[3] =	75001;
$rank_exp_to[3] =	215000;

$rank_name[4] =     "Konsulent";
$rank_exp_from[4] =	215001;
$rank_exp_to[4] =	550000;

$rank_name[5] =     "Rådmann";
$rank_exp_from[5] =	550001;
$rank_exp_to[5] =	1550000;

$rank_name[6] =     "Guvernør";
$rank_exp_from[6] =	1550001;
$rank_exp_to[6] =	4550000;

$rank_name[7] =     "Senator";
$rank_exp_from[7] =	4550001;
$rank_exp_to[7] =	9500000;

$rank_name[8] =     "Visepresident";
$rank_exp_from[8] =	9500001;
$rank_exp_to[8] =	20000000;

$rank_name[9] =     "President";
$rank_exp_from[9] =	20000001;
$rank_exp_to[9] =	50000000;

$rank_name[10] =     "Legende";
$rank_exp_from[10] = 50000001;
$rank_exp_to[10] =	 100000000;

$rank_name[11] =     "Mafioso";
$rank_exp_from[11] = 100000001;
$rank_exp_to[11] =	 INF;

if($exp > $rank_exp_from[0] && $exp < $rank_exp_to[0]){
    $sql = "UPDATE accounts SET rank ='0' WHERE ID='".$_SESSION['ID']."' LIMIT 1";
    mysqli_query($con, $sql);
} elseif($exp > $rank_exp_from[1] && $exp < $rank_exp_to[1]){
    $sql = "UPDATE accounts SET rank ='1' WHERE ID='".$_SESSION['ID']."' LIMIT 1";
    mysqli_query($con, $sql);
    
    if($rank_1 == 0){
        $query = "INSERT into `varsel` (acc_id, text, date)
        VALUES ('$ID', 'Gratulerer! Du har ranket opp til ".$rank_name[1]."', '".time()."')";
        $result = mysqli_query($con, $query);

        $sql = "UPDATE rank_up SET rank_1 ='1' WHERE acc_id='".$_SESSION['ID']."' LIMIT 1";
        mysqli_query($con, $sql);
        
    }
} elseif($exp > $rank_exp_from[2] && $exp < $rank_exp_to[2]){
    $sql = "UPDATE accounts SET rank ='2' WHERE ID='".$_SESSION['ID']."' LIMIT 1";
    mysqli_query($con, $sql);
    if($rank_2 == 0){
        $query = "INSERT into `varsel` (acc_id, text, date)
        VALUES ('$ID', 'Gratulerer! Du har ranket opp til ".$rank_name[2]."', '".time()."')";
        $result = mysqli_query($con, $query);
        
        $sql = "UPDATE rank_up SET rank_2 ='1' WHERE acc_id='".$_SESSION['ID']."' LIMIT 1";
        mysqli_query($con, $sql);
    }
} elseif($exp > $rank_exp_from[3] && $exp < $rank_exp_to[3]){
    $sql = "UPDATE accounts SET rank ='3' WHERE ID='".$_SESSION['ID']."' LIMIT 1";
    mysqli_query($con, $sql);
    if($rank_3 == 0){
        $query = "INSERT into `varsel` (acc_id, text, date)
        VALUES ('$ID', 'Gratulerer! Du har ranket opp til ".$rank_name[3]."', '".time()."')";
        $result = mysqli_query($con, $query);
        
        $sql = "UPDATE rank_up SET rank_3 ='1' WHERE acc_id='".$_SESSION['ID']."' LIMIT 1";
        mysqli_query($con, $sql);
        
        $check_verv = mysqli_query($con, "SELECT * FROM verv_konk WHERE username = '$username'");
        if(mysqli_num_rows($check_verv) > 0) {
            $sql = "UPDATE verv_konk SET rank = (rank + 5) WHERE username='$username' LIMIT 1";
            mysqli_query($con, $sql);
        }
    }
} elseif($exp > $rank_exp_from[4] && $exp < $rank_exp_to[4]){
    $sql = "UPDATE accounts SET rank ='4' WHERE ID='".$_SESSION['ID']."' LIMIT 1";
    mysqli_query($con, $sql);
    if($rank_4 == 0){
        $query = "INSERT into `varsel` (acc_id, text, date)
        VALUES ('$ID', 'Gratulerer! Du har ranket opp til ".$rank_name[4]."', '".time()."')";
        $result = mysqli_query($con, $query);
        
        $sql = "UPDATE rank_up SET rank_4 ='1' WHERE acc_id='".$_SESSION['ID']."' LIMIT 1";
        mysqli_query($con, $sql);
        
        $check_verv = mysqli_query($con, "SELECT * FROM verv_konk WHERE username = '$username'");
        if(mysqli_num_rows($check_verv) > 0) {
            $sql = "UPDATE verv_konk SET rank = (rank + 1) WHERE username='$username' LIMIT 1";
            mysqli_query($con, $sql);
        }
    }
} elseif($exp > $rank_exp_from[5] && $exp < $rank_exp_to[5]){
    $sql = "UPDATE accounts SET rank ='5' WHERE ID='".$_SESSION['ID']."' LIMIT 1";
    mysqli_query($con, $sql);
    if($rank_5 == 0){
        $query = "INSERT into `varsel` (acc_id, text, date)
        VALUES ('$ID', 'Gratulerer! Du har ranket opp til ".$rank_name[5]."', '".time()."')";
        $result = mysqli_query($con, $query);
        
        $sql = "UPDATE rank_up SET rank_5 ='1' WHERE acc_id='".$_SESSION['ID']."' LIMIT 1";
        mysqli_query($con, $sql);
        
        $check_verv = mysqli_query($con, "SELECT * FROM verv_konk WHERE username = '$username'");
        if(mysqli_num_rows($check_verv) > 0) {
            $sql = "UPDATE verv_konk SET rank = (rank + 1) WHERE username='$username' LIMIT 1";
            mysqli_query($con, $sql);
        }
    }
} elseif($exp > $rank_exp_from[6] && $exp < $rank_exp_to[6]){
    $sql = "UPDATE accounts SET rank ='6' WHERE ID='".$_SESSION['ID']."' LIMIT 1";
    mysqli_query($con, $sql);
    if($rank_6 == 0){
        $query = "INSERT into `last_events` (acc_id, event, time)
        VALUES ('$ID', 'ranket opp til ".$rank_name[6]."', '".time()."')";
        $result = mysqli_query($con, $query);
        
        $query = "INSERT into `varsel` (acc_id, text, date)
        VALUES ('$ID', 'Gratulerer! Du har ranket opp til ".$rank_name[6]."', '".time()."')";
        $result = mysqli_query($con, $query);
        
        $sql = "UPDATE rank_up SET rank_6 ='1' WHERE acc_id='".$_SESSION['ID']."' LIMIT 1";
        mysqli_query($con, $sql);
        
        $check_verv = mysqli_query($con, "SELECT * FROM verv_konk WHERE username = '$username'");
        if(mysqli_num_rows($check_verv) > 0) {
            $sql = "UPDATE verv_konk SET rank = (rank + 1) WHERE username='$username' LIMIT 1";
            mysqli_query($con, $sql);
        }
    }
} elseif($exp > $rank_exp_from[7] && $exp < $rank_exp_to[7]){
    $sql = "UPDATE accounts SET rank ='7' WHERE ID='".$_SESSION['ID']."' LIMIT 1";
    mysqli_query($con, $sql);
    if($rank_7 == 0){
        $query = "INSERT into `last_events` (acc_id, event, time)
        VALUES ('$ID', 'ranket opp til ".$rank_name[7]."', '".time()."')";
        $result = mysqli_query($con, $query);
        
        $query = "INSERT into `varsel` (acc_id, text, date)
        VALUES ('$ID', 'Gratulerer! Du har ranket opp til ".$rank_name[7]."', '".time()."')";
        $result = mysqli_query($con, $query);
        
        $sql = "UPDATE rank_up SET rank_7 ='1' WHERE acc_id='".$_SESSION['ID']."' LIMIT 1";
        mysqli_query($con, $sql);
        
        $check_verv = mysqli_query($con, "SELECT * FROM verv_konk WHERE username = '$username'");
        if(mysqli_num_rows($check_verv) > 0) {
            $sql = "UPDATE verv_konk SET rank = (rank + 1) WHERE username='$username' LIMIT 1";
            mysqli_query($con, $sql);
        }
    }
}  elseif($exp > $rank_exp_from[8] && $exp < $rank_exp_to[8]){
    $sql = "UPDATE accounts SET rank ='8' WHERE ID='".$_SESSION['ID']."' LIMIT 1";
    mysqli_query($con, $sql);
    if($rank_8 == 0){
        $query = "INSERT into `last_events` (acc_id, event, time)
        VALUES ('$ID', 'ranket opp til ".$rank_name[8]."', '".time()."')";
        $result = mysqli_query($con, $query);
        
        $query = "INSERT into `varsel` (acc_id, text, date)
        VALUES ('$ID', 'Gratulerer! Du har ranket opp til ".$rank_name[8]."', '".time()."')";
        $result = mysqli_query($con, $query);
        
        $sql = "UPDATE rank_up SET rank_8 ='1' WHERE acc_id='".$_SESSION['ID']."' LIMIT 1";
        mysqli_query($con, $sql);
        
        $check_verv = mysqli_query($con, "SELECT * FROM verv_konk WHERE username = '$username'");
        if(mysqli_num_rows($check_verv) > 0) {
            $sql = "UPDATE verv_konk SET rank = (rank + 1) WHERE username='$username' LIMIT 1";
            mysqli_query($con, $sql);
        }
    }
} elseif($exp > $rank_exp_from[9] && $exp < $rank_exp_to[9]){
    $sql = "UPDATE accounts SET rank ='9' WHERE ID='".$_SESSION['ID']."' LIMIT 1";
    mysqli_query($con, $sql);
    if($rank_9 == 0){
        $query = "INSERT into `last_events` (acc_id, event, time)
        VALUES ('$ID', 'ranket opp til ".$rank_name[9]."', '".time()."')";
        $result = mysqli_query($con, $query);
        
        $query = "INSERT into `varsel` (acc_id, text, date)
        VALUES ('$ID', 'Gratulerer! Du har ranket opp til ".$rank_name[9]."', '".time()."')";
        $result = mysqli_query($con, $query);
        
        $sql = "UPDATE rank_up SET rank_9 ='1' WHERE acc_id='".$_SESSION['ID']."' LIMIT 1";
        mysqli_query($con, $sql);
        
        $check_verv = mysqli_query($con, "SELECT * FROM verv_konk WHERE username = '$username'");
        if(mysqli_num_rows($check_verv) > 0) {
            $sql = "UPDATE verv_konk SET rank = (rank + 1) WHERE username='$username' LIMIT 1";
            mysqli_query($con, $sql);
        }
    }
} elseif($exp > $rank_exp_from[10] && $exp < $rank_exp_to[10]){
    $sql = "UPDATE accounts SET rank ='10' WHERE ID='".$_SESSION['ID']."' LIMIT 1";
    mysqli_query($con, $sql);
    if($rank_10 == 0){
        $query = "INSERT into `last_events` (acc_id, event, time)
        VALUES ('$ID', 'ranket opp til ".$rank_name[10]."', '".time()."')";
        $result = mysqli_query($con, $query);
        
        $query = "INSERT into `varsel` (acc_id, text, date)
        VALUES ('$ID', 'Gratulerer! Du har ranket opp til ".$rank_name[10]."', '".time()."')";
        $result = mysqli_query($con, $query);
        
        $sql = "UPDATE rank_up SET rank_10 ='1' WHERE acc_id='".$_SESSION['ID']."' LIMIT 1";
        mysqli_query($con, $sql);
        
        $check_verv = mysqli_query($con, "SELECT * FROM verv_konk WHERE username = '$username'");
        if(mysqli_num_rows($check_verv) > 0) {
            $sql = "UPDATE verv_konk SET rank = (rank + 1) WHERE username='$username' LIMIT 1";
            mysqli_query($con, $sql);
        }
    }
} elseif($exp > $rank_exp_from[11] && $exp < $rank_exp_to[11]){
    $sql = "UPDATE accounts SET rank ='11' WHERE ID='".$_SESSION['ID']."' LIMIT 1";
    mysqli_query($con, $sql);
    if($rank_11 == 0){
        $query = "INSERT into `last_events` (acc_id, event, time)
        VALUES ('$ID', 'ranket opp til ".$rank_name[11]."', '".time()."')";
        $result = mysqli_query($con, $query);
        
        $query = "INSERT into `varsel` (acc_id, text, date)
        VALUES ('$ID', 'Gratulerer! Du har ranket opp til ".$rank_name[11]."', '".time()."')";
        $result = mysqli_query($con, $query);
        
        $sql = "UPDATE rank_up SET rank_11 ='1' WHERE acc_id='".$_SESSION['ID']."' LIMIT 1";
        mysqli_query($con, $sql);
        
        $check_verv = mysqli_query($con, "SELECT * FROM verv_konk WHERE username = '$username'");
        if(mysqli_num_rows($check_verv) > 0) {
            $sql = "UPDATE verv_konk SET rank = (rank + 1) WHERE username='$username' LIMIT 1";
            mysqli_query($con, $sql);
        }
    }
}

if($rank < 11) {
    $rankplusen = ($rank + 1);
    $percent4 = ($rank_exp_from[$rankplusen] - $exp);
    $percent5 = ($rank_exp_to[$rank] - $rank_exp_from[$rank]);
    $percent6 = ($percent4 / $percent5) * 100;
    $percent7 = (100 - $percent6);
} elseif($rank == 11) {
    $percent7 = 100;
}

function number($number){
    return number_format($number, 0, '.', ' ');
}

//////////////////////////////
//        BB-KODER          //
//////////////////////////////
include("bb_codes.php");

$family_role[0] = "Medlem av ";
$family_role[1] = "Gudfar for ";
$family_role[2] = "Økonom for ";

$family_role_without[0] = "Medlem";
$family_role_without[1] = "Gudfar";
$family_role_without[2] = "Økonom";

$status[0] = 'Nyopprettet';
$status[1] = 'Stabil';
$status[2] = 'I krig';
$status[3] = 'Ruinert';

include("money_rank.php");

function secondsToTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%h time(r), %i minutt(er) og %s sekund');
}

function secondsToMinutes($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%i minutt og %s sekund');
}

function fetch_nick($id_forum, $connection){

    $sql = "SELECT * FROM accounts WHERE ID='". mysqli_real_escape_string($connection, $id_forum)."'";
    $query = mysqli_query($connection, $sql) or die (mysqli_error());
    $row = mysqli_fetch_assoc($query);
    
    $account_type = $row['account_type'];
    

    if($id_forum == "0"){ ?>
    <a style="color: chocolate; text-decoration: none;" href="index.php?side=profil&bruker=0">Staten</a>
    <?php } elseif($account_type == 2){ ?>
    <a style="color: #fff429; text-decoration: none;" href="index.php?side=profil&bruker=<?php echo $id_forum ?>"><?php echo $row['username']; ?></a>
    <?php } elseif($account_type == 1){ ?>
    <a style="color: #009fe3; text-decoration: none;" href="index.php?side=profil&bruker=<?php echo $id_forum ?>"><?php echo $row['username']; ?></a>
    <?php } elseif($account_type == 0) { ?>
    <a style="color: grey; text-decoration: none;" href="index.php?side=profil&bruker=<?php echo $id_forum ?>"><?php echo $row['username']; ?></a>
    <?php } elseif($account_type == 69 || $account_type == 68) { ?>
    <a style="<?php if(isset($_GET['side']) == 'forum'){ ?> color: grey; <?php } else { ?> color: red; <?php } ?> text-decoration: none;" href="index.php?side=profil&bruker=<?php echo $id_forum ?>"><?php echo $row['username']; ?></a>
    <?php } elseif($account_type == 3) { ?>
    <a style="color: #93fcff; text-decoration: none;" href="index.php?side=profil&bruker=<?php echo $id_forum ?>"><?php echo $row['username']; ?></a>
    <?php }
}

function fetch_nick_quote($id_forum, $connection){

    $sql = "SELECT * FROM accounts WHERE ID='". mysqli_real_escape_string($connection, $id_forum)."'";
    $query = mysqli_query($connection, $sql) or die (mysqli_error());
    $row = mysqli_fetch_assoc($query);
    
    echo $row['username'];
}

function forum_avatar($id_forum, $connection){
    
    $sql = "SELECT * FROM accounts WHERE ID='". mysqli_real_escape_string($connection, $id_forum)."'";
    $query = mysqli_query($connection, $sql) or die (mysqli_error());
    $row = mysqli_fetch_assoc($query);
    
    echo '<a href="index.php?side=profil&bruker='.$id_forum.'"><img src="'.$row['avatar'].'" style="width: 100px; height: auto; margin: 5px;"></a> ';
    
}

// Kategorier:
// Motor:           0, 4, 5, 9,  13, 14, 18, 22, 23, 27, 31, 32
// Suspension:      1, 2, 3, 10, 11, 12, 19, 20, 21, 28, 29, 30
// Dekk:            6, 7, 8, 15, 16, 17, 24, 25, 26, 33, 34, 35

/* Stjel bildeler fra bilopphøgger'n                      */
/* Bilopphøgger'n var ikke tilstede, du fikk med deg...   */
$thing[0] = "utslitte coils fra bilopphøgger";
$thing[1] = "knekt bremseskive fra bilopphøgger";
$thing[2] = "hengt caliper fra bilopphøgger";
$thing[3] = "nedslitte bremseklosser fra bilopphøgger";
$thing[4] = "girkasse med feil fra bilopphøgger";
$thing[5] = "eksospotte med hull fra bilopphøgger";
$thing[6] = "sprekte felger fra bilopphøgger";
$thing[7] = "Ødelagte sommerdekk fra bilopphøgger";
$thing[8] = "Ødelagte vinterdekk fra bilopphøgger";

/* Stjel bildeler fra biltema                             */
/* Du fant bildeler på biltema og fikk med deg...         */
$thing[9] = "coils fra biltema";
$thing[10] = "bremseskiver fra biltema";
$thing[11] = "calipere fra biltema";
$thing[12] = "bremseklosser fra biltema";
$thing[13] = "en girkasse fra en gammel bil";
$thing[14] = "eksospotte fra en gammel bil";
$thing[15] = "kantkjørte felger";
$thing[16] = "slitte sommerdekk";
$thing[17] = "slitte vinterdekk";

/* Stjel bildeler fra en bil på utstilling                */
/* Du fant en helt ny bil og fikk med deg...              */
$thing[18] = "nye kvalitets coils";
$thing[19] = "nye kvalitets bremseskiver";
$thing[20] = "nye kvalitets calipere";
$thing[21] = "nye kvalitets bremseklosser";
$thing[22] = "ny kvalitets girkasse";
$thing[23] = "Ny rustfri eksospotte";
$thing[24] = "helt nye MOMO felger";
$thing[25] = "helt nye MOMO sommerdekk";
$thing[26] = "helt nye MOMO vinterdekk";

/* Stjel en bil og ta fra hverandre alle bildeler.        */
/* Du stjal en bil, alle delene var ødelagte utennom ...  */
$thing[27] = "ubrukte coils";
$thing[28] = "ubrukte bremseskiver";
$thing[29] = "ubrukte calipere";
$thing[30] = "ubrukte bremseklosser";
$thing[31] = "ubrukt girkasse";
$thing[32] = "ubrukt eksospotte";
$thing[33] = "ubrukte felger";
$thing[34] = "ubrukte sommerdekk";
$thing[35] = "ubrukte vinterdekk";

include("mission.php");

?>
