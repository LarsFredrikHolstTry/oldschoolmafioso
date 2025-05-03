<?php 

ob_start();
include("db/db.php");
/*
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
*/
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
            <div style="height: 50px; width: 100%;"></div>
            <img src="img/header/text.png" style="width: 200px; height: auto;display: block; margin: 0 auto;"><br>
            
            <?php


        ob_start();
        include("db/db.php");
            
$cookie_name = "remember_forever";
if(!isset($_COOKIE[$cookie_name])) {

        $sql = "SELECT * FROM happy_hour ORDER BY end DESC";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row = mysqli_fetch_assoc($query);

        $happy_hour =       $row['happy_hour'];
        $start =            $row['start'];
        $end =              $row['end'];

        if(time() > $end){
            $result = "UPDATE happy_hour SET happy_hour = '0'";
            mysqli_query($con, $result) or die("Bad query: $result"); 
        }
            
        // If form submitted, insert values into the database.
        if(isset($_POST['submit'])){
            if(isset($_POST['username'])){

            $check_user = mysqli_query($con, "SELECT username FROM accounts WHERE username = '".$_POST['username']."'");

            if(mysqli_num_rows($check_user) > 0) {

    
                $sql = "SELECT * FROM accounts WHERE username = '".$_POST['username']."'";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row_dead = mysqli_fetch_assoc($query);

                if($row_dead['account_type'] == 69){
                    header("Location: logginn.php?dead");
                } elseif($row_dead['account_type'] == 68){
                    header("Location: logginn.php?deaktivert");
                } else {

                // removes backslashes
                $username = stripslashes($_REQUEST['username']);
                //escapes special characters in a string
                $username = mysqli_real_escape_string($con, $username);
                $password = stripslashes($_REQUEST['password']);
                $password = mysqli_real_escape_string($con, $password);
                $query = "SELECT * FROM accounts WHERE username='$username' and password='".md5($password)."'";
                $result = mysqli_query($con, $query) or die (mysql_error());
                $rows = mysqli_num_rows($result);

                $sql = "SELECT * FROM accounts WHERE username='". mysqli_real_escape_string($con, $_REQUEST['username'])."'";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row = mysqli_fetch_assoc($query);

                $account_type = $row['account_type'];
                $ID = $row['ID'];
                if ($rows==1) {
                    
                    setcookie(
                      "remember_forever",
                      $ID,
                      time() + (10 * 365 * 24 * 60 * 60)
                    );

                    $_SESSION['ID'] = $ID;
                    $ip = getenv('HTTP_CLIENT_IP')?:
                    getenv('HTTP_X_FORWARDED_FOR')?:
                    getenv('HTTP_X_FORWARDED')?:
                    getenv('HTTP_FORWARDED_FOR')?:
                    getenv('HTTP_FORWARDED')?:
                    getenv('REMOTE_ADDR');

                    $query = "UPDATE accounts SET ip = '$ip' WHERE username = '$username'";
                    $result = mysqli_query($con, $query);

                    ?>
                        <script type="text/javascript">
                            window.location.href = 'index.php';
                        </script>
                    <?php
                    } else {
                    echo '<div class="feedback feilmelding">
                        <span>Brukernavn / passord er feil!</span> 
                    </div>';
                }
                }
                } else {
                echo '<div class="feedback feilmelding">
                    <span>Brukernavn eksisterer ikke!</span> 
                </div>';
            }
            } else {
                echo '<div class="feedback feilmelding">
                    <span>Brukernavn / passord er feil!</span> 
                </div>';
            }
        }
            
        if(isset($_GET['dead'])){
            echo '<div class="feedback mislykket">
                <img src="img/action/dod.png" style="width: 100%; height: auto;">
            </div>';
        }
            
        if(isset($_GET['deaktivert'])){
            echo '<div class="feedback mislykket">
                <img src="img/action/deaktivert.png" style="width: 100%; height: auto;">
            </div>';
        }
            

            
            ?>
            
            <div class="content">
                <div class="header">
                    <span>Logg inn</span>
                </div>
                <form method="post">
                    <table>
                        <tr>
                            <th>Brukernavn</th>
                            <th>Passord</th>
                            <th></th>
                        </tr>
                        <tr style="background-color: #1b1b1b;">
                            <td><input type="text" name="username"></td>
                            <td><input type="password" name="password"></td>
                            <td><input type="submit" name="submit" value="Logg inn"></td>
                        </tr>
                    </table>
                </form>
                <table>
                    <tr>
                        <th style="width: 19.8%;">Har du ikke bruker »</th>
                        <th style="width: 60%;"><a href="registrer.php">Registrer</a></th>
                    </tr>
                </table>
            </div>
            
            <div style="margin-top: 5px;" class="content">
                <div class="header">
                    <span>Om mafioso</span>
                </div>
                <div class="pad_10">
                    Mafioso er et tekstbasert mafiaspill hvor man spiller et rollespill. Alt som er i spillet er fiktivt og skal på ingen måte bli inspirert til å brukes eller konstrueres i det virkelige liv. Mafioso skal i hovedtrekk brukes som et tidsfordriv og en samleplass for venner. Spillet anbefales for ungdom over 16 år.
                </div>
            </div>
<?php

} else {
    $cookie_name = "remember_forever";
    $_SESSION['ID'] = $_COOKIE[$cookie_name];
    header("Location: index.php");
}
    
    ?>
        </div>
    </body>
</html>

<?php/* } */?>