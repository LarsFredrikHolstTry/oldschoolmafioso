<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else { 
    
$sql = "SELECT * FROM paskeegg WHERE acc_id='".$_SESSION['ID']."'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row_egg = mysqli_fetch_assoc($query);
    
$team = $row_egg['team'];
$antall_egg = $row_egg['egg'];
    
    if($antall_egg == null){
        $antall_egg = 0;
    } else {
        $antall_egg = $antall_egg;
    }
    
$money_pr_egg = 5000000;
$renter = 1.0523152;
    
$value = ($antall_egg * $money_pr_egg) * $renter;
    
    $unique_id = uniqid();

    if(isset($_POST['make_group'])){
        if($team == null){
            $result = "UPDATE paskeegg SET team = '$unique_id' WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            header("Location: index.php?side=paaskespesial");
        } else {
            echo '<div class="feedback mislykket">
                <span>Du er allerede med i ett lag.</span> 
            </div>';
        }
    }
    
    if(isset($_POST['quit_team'])){
        if($team != null){
            $result = "UPDATE paskeegg SET team = '' WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            header("Location: index.php?side=paaskespesial");
        } else {
            echo '<div class="feedback mislykket">
                <span>Du er ikke med i noe lag.</span> 
            </div>';
        }
    }
    
    if(isset($_POST['sell_all'])){
        if($team != null){
            $total_egg_team = 0;
            $total_contestant = 0;
            $result_egg = mysqli_query($con, "SELECT * FROM paskeegg WHERE team = '".$team."'");
            while($row_egg = mysqli_fetch_assoc($result_egg)) {
                if($row_egg['egg'] == null){
                    $row_egg['egg'] = 0;
                } else {
                    $row_egg['egg'] = $row_egg['egg'];
                }

                $total_egg_team = $total_egg_team + $row_egg['egg'];
                $total_value_team = ($total_egg_team * $money_pr_egg) * $renter;
                $total_contestant = $total_contestant + 1;
            }
            
            if($total_egg_team == 0){
                echo '<div class="feedback mislykket">
                    <span>Det er ingen egg å selge.</span> 
                </div>';
            } else {
                $pr_egg_utbetaling = $total_value_team / $total_egg_team;

                $result_egg_utbetaling = mysqli_query($con, "SELECT * FROM paskeegg WHERE team = '".$team."'");
                while($row_egg_utbetaling = mysqli_fetch_assoc($result_egg_utbetaling)) {
                    if($row_egg_utbetaling['egg'] == null){
                        $row_egg_utbetaling['egg'] = 0;
                    } else {
                        $row_egg_utbetaling['egg'] = $row_egg_utbetaling['egg'];
                    }

                    $give_egg_money_total = $row_egg_utbetaling['egg'] * $pr_egg_utbetaling;

                    $query = "INSERT into `varsel` (acc_id, text, date)
                    VALUES ('".$row_egg_utbetaling['acc_id']."', 'Alle eggene i gruppen ble solgt og du fikk ".number($give_egg_money_total)." kr', '".time()."')";
                    $result = mysqli_query($con, $query);

                    $result = "UPDATE paskeegg SET egg = '' WHERE acc_id='".$row_egg_utbetaling['acc_id']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $result = "UPDATE accounts SET money = (money + $give_egg_money_total) WHERE ID='".$row_egg_utbetaling['acc_id']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                }

                echo '<div class="feedback velykket">
                    <span>Alle egg ble solgt.</span> 
                </div>';
            }
        } else {
            echo '<div class="feedback mislykket">
                <span>Du er ikke med i noe lag.</span> 
            </div>';
        }
    }
    
    if(isset($_POST['steal_egg'])){
        if($team != null){
            $total_egg_team = 0;
            
            $result_egg = mysqli_query($con, "SELECT * FROM paskeegg WHERE team = '".$team."'");
            while($row_egg = mysqli_fetch_assoc($result_egg)) {
                if($row_egg['egg'] == null){
                    $row_egg['egg'] = 0;
                } else {
                    $row_egg['egg'] = $row_egg['egg'];
                }
                
                $total_egg_team = $total_egg_team + $row_egg['egg'];
                
                $total_value_team = ($total_egg_team * $money_pr_egg) * $renter;
                
                $query = "INSERT into `varsel` (acc_id, text, date)
                VALUES ('".$row_egg['acc_id']."', 'Noen har stjelt eggene i teamet du var med i. Teamet oppløses.', '".time()."')";
                $result = mysqli_query($con, $query);
            }
            
            $result = "UPDATE accounts SET money = (money + $total_value_team) WHERE ID = '".$ID."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $result = "UPDATE paskeegg SET team = '', egg = '' WHERE team = '".$team."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            header("Location: index.php?side=paaskespesial");
        } else {
            echo '<div class="feedback mislykket">
                <span>Du er ikke med i noe lag.</span> 
            </div>';
        }
    }
    
    if(isset($_POST['invite'])){
        
        // sjekk om brukeren er invitert fra før
        $username_inv = $_POST['username_invite'];
        
        $sql = "SELECT * FROM accounts WHERE username='".$username_inv."'";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row_invited = mysqli_fetch_assoc($query);
        
        $check_if_exc = mysqli_query($con, "SELECT * FROM accounts WHERE username = '".$username_inv."'");

        if(mysqli_num_rows($check_if_exc) != 1) {
            echo '<div class="feedback mislykket">
                <span>Brukeren eksisterer ikke.</span> 
            </div>';
        } else {
        
        $is_in_group = false;
        $is_invited = false;
        
        $check_in_group = mysqli_query($con, "SELECT * FROM paskeegg WHERE acc_id = '".$row_invited['ID']."' AND team = ''");
        if(mysqli_num_rows($check_in_group) != 1) {
            $is_in_group = true;
        }
        
        $check_invited = mysqli_query($con, "SELECT * FROM paskeegg_inv WHERE acc_id = '".$row_invited['ID']."' AND team_id = '".$team."'");
        if(mysqli_num_rows($check_invited) > 0) {
            $is_invited = true;
        }
        
        
        if($is_in_group == true){
            echo '<div class="feedback mislykket">
                <span>Brukeren er allerede i et team</span> 
            </div>';
        } else {
            if($is_invited == true){
            echo '<div class="feedback mislykket">
                <span>Brukeren er allerede invitert til ditt team</span> 
            </div>';
            } else {
                echo '<div class="feedback velykket">
                    <span>Brukeren ble invitert</span> 
                </div>';
                
                $query = "INSERT into `paskeegg_inv` (acc_id, acc_id_from, team_id)
                VALUES ('".$row_invited['ID']."', '".$ID."', '".$team."')";
                $result = mysqli_query($con, $query);
            }
        }
        }
    }

    
    if(isset($_GET['aksept'])){
        $check_invite = mysqli_query($con, "SELECT * FROM paskeegg_inv WHERE acc_id = '".$ID."' AND team_id = '".$_GET['aksept']."'");
        $check_in_group = mysqli_query($con, "SELECT * FROM paskeegg WHERE acc_id = '".$ID."' AND team = '".$_GET['aksept']."'");

        if(mysqli_num_rows($check_invite) != 1) {
            echo '<div class="feedback mislykket">
                    <span>Du har ikke fått noe invitasjon fra denne gruppen.</span> 
                </div>';
        } elseif(mysqli_num_rows($check_in_group) > 0) {
            echo '<div class="feedback mislykket">
                    <span>Du er allerede med i denne gruppen.</span> 
                </div>';
        } else {
            $del = mysqli_query($con, "DELETE FROM paskeegg_inv WHERE acc_id = '".$_SESSION['ID']."'") or die(mysqli_error()); 

            $result = "UPDATE paskeegg SET team = '".$_GET['aksept']."' WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            header("Location: index.php?side=paaskespesial");
        }
    }
    
    if(isset($_GET['slett'])){
        $check_invite = mysqli_query($con, "SELECT * FROM paskeegg_inv WHERE acc_id = '".$ID."' AND team_id = '".$_GET['slett']."'");

        if(mysqli_num_rows($check_invite) != 1) {
            echo '<div class="feedback mislykket">
                    <span>Du har ikke fått noe invitasjon fra denne gruppen.</span> 
                </div>';
        } else {
            $del = mysqli_query($con, "DELETE FROM paskeegg_inv WHERE team_id = '".$_GET['slett']."'") or die(mysqli_error()); 

            header("Location: index.php?side=paaskespesial");
        }
    }
    
?>
<!-- CONTENT -->
<html>
    <head>
    <style>
        
        .link_paske {
            text-decoration: none;
            color: white;
        }
        
        .link_paske:hover {
            text-decoration: underline;
        }
        
    </style>
    
    </head>
    <body>
        <div class="breadcrumb">
            <span style="color: #afafaf;">Påskespesial</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <img src="img/action/paske.png">
            <div class="pad_10">
                Påske-event er ett event hvor du kan samle opp påskeegg for å tjene penger. Du kan enten skaffe påskeegg alene eller via ett team. <br>Påskeegg kan du få gjennom vellykkede <a class="link_paske" href="index.php?side=kriminalitet">kriminalitet</a>, <a class="link_paske" href="index.php?side=biltyveri">biltyveri</a>, <a class="link_paske" href="index.php?side=brekk">brekk</a> og <a class="link_paske" href="index.php?side=raceclub&home">race club</a>.
            </div>
            <div class="pad_10">Eventet varer til <span style="background-color: #111111; padding: 3px; border-radius: 3px;">12. April. Kl: 18:00</span>, egg som ikke er solgt innen denne tiden blir fjernet.</div>
            <div class="pad_10">
                <?php if($team == null){ ?>
                <center>
                    Du har: <span style="color: #afafaf;"><?php echo number($antall_egg); ?></span> påskeegg<br>
                    Verdi: <span style="color: #afafaf;"><?php echo number(($antall_egg * $money_pr_egg) * $renter); ?></span> kr
                </center>
                <?php } else { ?>
                <center>
                    Ditt team har: <span style="color: #afafaf;"><?php 
                              
            $total_egg_team = 0;
                              
            $result_egg = mysqli_query($con, "SELECT * FROM paskeegg WHERE team = '".$team."'");
            while($row_egg = mysqli_fetch_assoc($result_egg)) {
                if($row_egg['egg'] == null){
                    $row_egg['egg'] = 0;
                } else {
                    $row_egg['egg'] = $row_egg['egg'];
                }
                
                $total_egg_team = $total_egg_team + $row_egg['egg'];
            }
                              
                              
                              echo number($total_egg_team); ?></span> påskeegg<br>
                    Total verdi: <span style="color: #afafaf;"><?php echo number(($total_egg_team * $money_pr_egg) * $renter); ?></span> kr
                </center>
                <?php } ?>
            </div>
            <?php if($team == null){ ?>
            <div class="pad_10">
                <form method="post">
                    <center>
                        Når du oppretter ett team så kan du invitere brukere til ditt team<br>
                        <input type="submit" name="make_group" value="opprett lag" style="width: auto;">
                    </center>
                </form>
            </div>
            <?php 
            
        $check_invite_exist = mysqli_query($con, "SELECT * FROM paskeegg_inv WHERE acc_id = '".$ID."'");

        if(mysqli_num_rows($check_invite_exist) != 0) {
            
            ?>
            <div class="header header_mid">
                <span>Invitasjoner</span>
            </div>
            <table border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 30px;">
                    <th style="width: 50%; padding-left: 15px;">Invitasjon fra</th>
                    <th style="width: 20%"></th>
                    <th style="width: 20%"></th>
                </tr>
                <?php
    
            $result_egg_inv = mysqli_query($con, "SELECT * FROM paskeegg_inv WHERE acc_id = '".$ID."'");
    
            $i = 0;
            while($row_egg_inv = mysqli_fetch_assoc($result_egg_inv)) {
                $i++;
                
            ?>
                <tr style="height: 30px;">
                    <td style="padding-left: 15px;"><?php echo fetch_nick($row_egg_inv['acc_id_from'], $con); ?></td>
                    <td style="text-align: right;"><a style="color: green; text-decoration: none;" href="index.php?side=paaskespesial&aksept=<?php echo $row_egg_inv['team_id'] ?>">Aksepter</a></td>
                    <td style="text-align: right;"><a style=" color: orange; text-decoration: none;" href="index.php?side=paaskespesial&slett=<?php echo $row_egg_inv['team_id'] ?>">Avslå</a></td>
                </tr>
                <?php } ?>
            </table>
            <?php } ?>
            <?php } else { ?>
                <div class="header header_mid">
                    <span>Mitt team</span>
                </div>
            <table border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 30px;">
                    <th style="width: 50%; padding-left: 15px;">Medlem</th>
                    <th style="width: 40%">Egg</th>
                </tr>
                <?php
    
            $result_egg = mysqli_query($con, "SELECT * FROM paskeegg WHERE team = '".$team."'");
    
            $i = 0;
            while($row_egg = mysqli_fetch_assoc($result_egg)) {


                $i++;

            ?>
                <tr style="height: 30px;">
                    <td style="padding-left: 15px;"><?php fetch_nick($row_egg['acc_id'], $con); ?>
                    </td>
                    <td><?php if($row_egg['egg'] == null) { echo 0; } else { echo number($row_egg['egg']); } ?> stk.</td>
                    
                </tr>
                <?php } ?>
            </table>
            
                <div style="width: 49%; float: left; height: 120px; box-shadow: -1px 0px #2c2c2c inset;">
                    <div class="header header_mid" style="box-shadow: -1px 0px #2c2c2c inset;">
                        <span>Inviter bruker til team</span>
                    </div>
                    <div class="pad_10">
                        Husk at brukere som er med i ditt team kan stjele alle egg.<br><br>
                        <form method="post">
                            <input type="text" style="width: 50%; float: left;" name="username_invite" placeholder="Brukernavn.." required>
                            <input type="submit" style=" width: 40%" name="invite" value="inviter">
                        </form>
                    </div>
                </div>

                <div style="width: 50.81%; float: left; height: 120px;">
                    <div class="header header_mid">
                        <span>Stjel egg</span>
                    </div>
                    <div class="pad_10">
                        Velger du å stjele alle eggene så får du hele verdien og gruppen oppløses.<br><br>
                        <form method="post">
                            <input type="submit" style="margin: 0;" name="steal_egg" value="Stjel egg">
                        </form>
                    </div>
                </div>

                <div style="width: 49%; float: left; height: 120px; box-shadow: -1px 0px #2c2c2c inset;">
                    <div class="header header_mid" style="box-shadow: -1px 0px #2c2c2c inset;">
                        <span>Selg alle egg</span>
                    </div>
                    <div class="pad_10">
                        Velger du å selge alle egg så blir verdien delt ut på antall egg pr bruker.<br><br>
                        <form method="post">
                            <input type="submit" style="margin: 0;" name="sell_all" value="Selg egg">
                        </form>
                    </div>
                </div>

                <div style="width: 50.81%; float: left; height: 120px;">
                    <div class="header header_mid">
                        <span>Forlat lag</span>
                    </div>
                    <div class="pad_10">
                        Om du velger å forlate ett lag så tar du med deg dine egg.<br><br>
                        <form method="post">
                            <input type="submit" style="margin: 0;" name="quit_team" value="Forlat lag">
                        </form>
                    </div>
                </div>

            <?php } ?>
        </div>
    </body>
</html>
<?php 

}

?>