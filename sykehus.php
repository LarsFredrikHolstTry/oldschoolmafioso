
<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else { 
    
$check_half_hp = mysqli_query($con, "SELECT * FROM half_hp WHERE acc_id = '".$_SESSION['ID']."'");
if(mysqli_num_rows($check_half_hp) > 0) {
    
$sql = "SELECT * FROM half_hp WHERE acc_id='".$_SESSION['ID']."'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row_half_hp = mysqli_fetch_assoc($query);
    
$timeout = $row_half_hp['timeout'];
    
?>

<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span><span style="color: #3e3e3e;">Drap » </span><span style="color: #afafaf;">Sykehus</span></span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <div class="header">
                <span>Ingen adgang</span>
            </div>
            <img src="img/action/ingen_adgang.png">
            <div class="pad_10">
                Du gjorde nylig ett angrep mot en person, dersom du legger deg inn på sykehus vil du bli tatt av politiet. Du har dermed ingen adgang til sykehuset før 12 timer etter angrepet tok sted. Du kan legge deg inn på sykehus <?php 
                
                    echo " "; echo date('d', $timeout);
                    echo ". "; echo $month[date('n', $timeout)];
                    echo " - kl "; echo date('H:i', $timeout);
                
                ?>
            </div>
        </div>
    </body>
</html>

<?php
} else {
                
?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span><span style="color: #3e3e3e;">Drap » </span><span style="color: #afafaf;">Sykehus</span></span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <?php
    
        if(isset($_POST['submit'])){
            $check_half_hp = mysqli_query($con, "SELECT * FROM half_hp WHERE acc_id = '".$_SESSION['ID']."'");
            if(mysqli_num_rows($check_half_hp) > 0) {
                echo '<div class="feedback mislykket">
                    <span>Du har halvt liv på grunn av angrep, du kan derfor ikke legges inn på sykehus.</span>
                </div>';
            } else {

                $helse_resterende = (100 - $helse);
                $pris_for_innleggelse = ($helse_resterende * 1233000);

                if($money < $pris_for_innleggelse){
                    echo '<div class="feedback mislykket">
                        <span>Du har for lite penger til å legges inn på sykehus.</span>
                    </div>';
                } else {
                    $result = "UPDATE accounts SET helse = '100', money = ($money - $pris_for_innleggelse) WHERE ID='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    header("Location: index.php?side=sykehus&frisk");
                }
            }
        }

        if(isset($_GET['frisk'])){
            echo '<div class="feedback velykket">
                <span>Du har nå full helse.</span>
            </div>';
        }
    
        ?>
        <div class="content">
            <div class="header">
                <span>Sykehus</span>
            </div>
            <img src="img/action/sykehus.png">
            <form method="post">
                <p class="pad_10">
                    Velkommen til sykehuset i <?php echo $city_name[$city]; ?>! Her kan du innlegges for å få helsen opp i tipp topp form! Prisen varierer for hvor skadet du er. <br><br>
                    <b>Estimert pris for innleggelse: </b><?php 

                    $helse_resterende = (100 - $helse);
                    $pris_for_innleggelse = ($helse_resterende * 1233000);

                    echo number($pris_for_innleggelse); ?>kr

                </p>
                <input style="width: 97.5%;" type="submit" name="submit" value="Legg meg inn">
            </form>
        </div>
    </body>
</html>
<?php 
            }
}

?>