<?php 


        ob_start();
        include("db/db.php");

$ip = getenv('HTTP_CLIENT_IP')?:
        getenv('HTTP_X_FORWARDED_FOR')?:
        getenv('HTTP_X_FORWARDED')?:
        getenv('HTTP_FORWARDED_FOR')?:
        getenv('HTTP_FORWARDED')?:
        getenv('REMOTE_ADDR');

        $check_ip_ban = mysqli_query($con, "SELECT * FROM ip_ban WHERE ip_ban = '$ip'");

        if(mysqli_num_rows($check_ip_ban) > 0) {
            echo 'Din IP adresse er ikke tillatt på dette domenet. Dette kan skyldes flere forsøk på juks eller dårlig oppførsel. Mener du dette er feil så ta kontakt på post@mafioso.no';
        } else {

?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <title>Mafioso</title>
        <meta charset="utf-8"/>
        <meta name="description" content="Mafioso er ett norsk tekstbasert mafiaspill hvor det handler om å bygge opp makt og jobbe strategisk for å nå toppen."/>
        <meta name="keywords" content="Mafiaspill, Tekstbasert spill"/>
        <meta name="author" content="Mafioso" />
        <meta name="robots" content="follow"/>
        <script src="jquery-3.4.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
        <link rel="shortcut icon" href="img/favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="viewport" content="width=device-width, initial-scale=0.86, maximum-scale=3.0, minimum-scale=0.86">
    </head>
    <body>
        <div class="container">
            <div style="height: 150px; width: 100%;"></div>
            <img src="img/header/text.png"style="margin: -280px 0px 0px -280px; width: 280px; height: auto;display: block; margin: 0 auto;"><br>
            
            <?php
            
        ob_start();
        include("db/db.php");

        if(isset($_POST['submit'])){
            $username = stripslashes($_REQUEST['username']);
            $username = mysqli_real_escape_string($con, $username);
            $email = stripslashes($_REQUEST['email']);
            $email = mysqli_real_escape_string($con, $email);
            $password = stripslashes($_REQUEST['password']);
            $password = mysqli_real_escape_string($con, $password);

            $check_nick = mysqli_query($con, "SELECT username FROM accounts WHERE username = '$username'");
            $check_mail = mysqli_query($con, "SELECT email FROM accounts WHERE email = '$email' AND account_type = 0");
            
            if(preg_match('/[^a-z_\-0-9]/i', $username)){
                $letter = true;
            } else {
                $letter = false;
            }

            if(mysqli_num_rows($check_nick) > 0 || $username == "staten") {
                echo '<div class="feedback mislykket">
                        <span><b>Mislykket!</b> Brukernavnet er allerede i bruk.</span> 
                    </div>';
            } elseif(mysqli_num_rows($check_mail) > 0) {
                echo '<div class="feedback mislykket">
                        <span><b>Mislykket!</b> Emailen er allerede i bruk.</span> 
                    </div>';            
            } elseif(strlen($username) > 20 || strlen($username) < 3 ){
                echo '<div class="feedback mislykket">
                    <span>Brukernavnet må være lengre enn 3 tegn og kortere enn 20 tegn.</span> 
                </div>';
            } elseif($letter == true){
                echo '<div class="feedback mislykket">
                    <span>Brukernavnet kan kun inneholde tekst fra A til Z og tall 1 til 9, ingen mellomrom.</span> 
                </div>';
            } else {
                
                $konto_nr = rand(0, 9999999);
                        
                $check_konto = mysqli_query($con, "SELECT bank_nr FROM accounts WHERE bank_nr = '$konto_nr'");
                
                do { 
                    $konto_nr = rand(0, 9999999);
                }
                while(mysqli_num_rows($check_nick) > 0);

                $ip = getenv('HTTP_CLIENT_IP')?:
                getenv('HTTP_X_FORWARDED_FOR')?:
                getenv('HTTP_X_FORWARDED')?:
                getenv('HTTP_FORWARDED_FOR')?:
                getenv('HTTP_FORWARDED')?:
                getenv('REMOTE_ADDR');
                
                $verv = false;
                
                if(isset($_GET['verv'])){
                    $verv = true;
                    $verv_belonnelse = 10000000; // 10 000 000
                    $result = "UPDATE accounts SET money = (money + $verv_belonnelse) WHERE ID='".$_GET['verv']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    
                    $query = "INSERT into `varsel` (acc_id, text, date)
                    VALUES ('".$_GET['verv']."', '".$username." har registrert seg på din vervelink og du mottar derfor 10 000 000 kr', '".time()."')";
                    $result = mysqli_query($con, $query);
                }

                $check_nyhetsbrev = mysqli_query($con, "SELECT email FROM nyhetsbrev WHERE email = '$email'");

                if(mysqli_num_rows($check_nyhetsbrev) > 0) {
                    if($verv == true){
                        $query = "INSERT into `verv_konk` (username, vervet_av, rank, dato)
                        VALUES ('$username', '".$_GET['verv']."', '2', '".time()."')";
                        $result = mysqli_query($con, $query);
                        
                        $query = "INSERT into `accounts` (username, password, email, ip, reg_ip, register_date, money, city, bank_nr, bank_money, exp)
                        VALUES ('$username', '".md5($password)."', '$email', '$ip', '$ip', '".time()."', '10050000', '1','$konto_nr', '25000000', '1')";
                        $result = mysqli_query($con, $query);
                    } else {
                        $query = "INSERT into `accounts` (username, password, email, ip, reg_ip, register_date, money, city, bank_nr, bank_money, exp)
                        VALUES ('$username', '".md5($password)."', '$email', '$ip', '$ip', '".time()."', '50000', '1','$konto_nr', '25000000', '1')";
                        $result = mysqli_query($con, $query);
                    }

                    
                    $nyhetsbrev = 1;
                } else {
                    if($verv == true){
                        $query = "INSERT into `verv_konk` (username, vervet_av, rank, dato)
                        VALUES ('$username', '".$_GET['verv']."', '0', '".time()."')";
                        $result = mysqli_query($con, $query);
                        
                        $query = "INSERT into `accounts` (username, password, email, ip, reg_ip, register_date, money, city, bank_nr, bank_money, exp)
                        VALUES ('$username', '".md5($password)."', '$email', '$ip', '$ip', '".time()."', '10050000', '1','$konto_nr', '0', '1')";
                        $result = mysqli_query($con, $query);
                    } else {
                        $query = "INSERT into `accounts` (username, password, email, ip, reg_ip, register_date, money, city, bank_nr, bank_money, exp)
                        VALUES ('$username', '".md5($password)."', '$email', '$ip', '$ip', '".time()."', '50000', '1','$konto_nr', '0', '1')";
                        $result = mysqli_query($con, $query);
                    }

                    $nyhetsbrev = 0;
                }

                if($nyhetsbrev == 1){
                    echo '<div class="feedback velykket">
                    <span><b>Velkommen!</b> Du ble registrert, klikk her for å logge deg inn: <a style="text-decoration: none; color: white;" href="logginn.php">Logg inn</a>, som takk for at du tidligere var meldt deg på vårt nyhetsbrev så ligger det en liten godbit i banken til deg.</span> 
                    </div>';
                } else {
                    echo '<div class="feedback velykket">
                    <span><b>Velkommen!</b> Du ble registrert, klikk her for å logge deg inn: <a style="text-decoration: none; color: white;" href="logginn.php">Logg inn</a></span> 
                    </div>';
                }
            }
        }

        ?>
            
            <form method="post">
            <div class="content">
            <table>
                <tr>
                    <th style="width: 38%;"><span style="color: #009fe3;">* </span>Brukernavn</th>
                    <th style="width: 38%;"><span style="color: #009fe3;">* </span>Passord</th>
                </tr>
                <tr style="background-color: #1b1b1b;">
                    <td style="width: 38%;"><input type="text" name="username" required></td>
                    <td style="width: 38%;"><input type="password" id="passord" name="password" required></td>
                    <td style="padding-bottom: 7px;"><label class="radio_container">
                        <input type="checkbox" onclick="showPass()" name='radioBtn' name="radio">
                        <span class="checkmark"></span>
                        </label><t style="display: absolute; padding-left: 30px;">Vis passord</t>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <th style="width: 65%;">E-mail <span style="color: #009fe3;">* </span></th>
                    <th style="width: 35%;"></th>
                </tr>
                <tr style="background-color: #1b1b1b;">
                    <td><input type="email" name="email" required></td>
                    <td><input type="submit" name="submit" value="Registrer"></td>
                </tr>
            </table>
                <p style="padding-left: 7px;"><span style="color: #009fe3;">* </span> Obligatoriske felt</p>
                <p style="padding-left: 7px;">Ved å registrere deg så godtar du vilkårene. <a href="terms.php" target="_blank">(les vilkår)</a></p>
            <table>
                <tr>
                    <th style="width: 14.8%;">Har du bruker »</th>
                    <th style="width: 60%;"><a href="logginn.php">Logg inn</a></th>
                </tr>
            </table>
            </div>
            </form>
        </div>
        
    </body>
</html>


<script>
    
function showPass() {
  var x = document.getElementById("passord");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
    
</script>

<?php
        }
            ?>