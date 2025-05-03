
<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else { 
    
$sql = "SELECT * FROM livvakt WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row_livvakt = mysqli_fetch_assoc($query);
    
$livvakt_lvl = $row_livvakt['lvl'];
    
    $livvakt_price[0] = 100000000; // 100 000 000
    $livvakt_price[1] = 150000000; // 150 000 000
    $livvakt_price[2] = 300000000; // 200 000 000
    
    $livvakt_effekt[0] = 10;        // 10%
    $livvakt_effekt[1] = 15;        // 15%
    $livvakt_effekt[2] = 30;        // 30%
    
    
    
    
?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Drap » </span><span style="color: #afafaf;">Livvakt</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <?php
    
        if(isset($_POST['upgrade_livvakt'])){
            if($livvakt_lvl == 0){
                if($livvakt_price[0] > $money){
                    echo '<div class="feedback feilmelding">
                        <span>Du har ikke nok penger for å kjøpe valgt livvakt type.</span>
                    </div>';
                } else {
                    $result = "UPDATE livvakt SET lvl = 1 WHERE acc_id='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    
                    $result = "UPDATE accounts SET money = (money - $livvakt_price[0]) WHERE ID='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    
                    header("Location: index.php?side=livvakt&oppgrader");
                }
            } elseif($livvakt_lvl == 1){
                if($livvakt_price[1] > $money){
                    echo '<div class="feedback feilmelding">
                        <span>Du har ikke nok penger for å kjøpe valgt livvakt type.</span>
                    </div>';
                } else {
                    $result = "UPDATE livvakt SET lvl = 2 WHERE acc_id='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    
                    $result = "UPDATE accounts SET money = (money - $livvakt_price[1]) WHERE ID='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    
                    header("Location: index.php?side=livvakt&oppgrader");
                }
            } elseif($livvakt_lvl == 2){
                if($livvakt_price[2] > $money){
                    echo '<div class="feedback feilmelding">
                        <span>Du har ikke nok penger for å kjøpe valgt livvakt type.</span>
                    </div>';
                } else {
                    $result = "UPDATE livvakt SET lvl = 3 WHERE acc_id='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    
                    $result = "UPDATE accounts SET money = (money - $livvakt_price[2]) WHERE ID='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    
                    header("Location: index.php?side=livvakt&oppgrader");
                }
            }
        }
    
    if(isset($_GET['oppgrader'])){
        echo '<div class="feedback velykket">
            <span>Valgt livvakt tjeneste ble kjøpt.</span>
        </div>';
    }
    
    ?>
        <div class="content">
            <div class="header">
                <span>Livvakt</span>
            </div>
        <div class="pad_10">
            <p>
                <center>Livvakt er en funksjon hvor du kan få ekstra beskyttelse, <br>dette hjelper deg mot angrep fra andre spillere.<br>
                <span style="color: #4e4e4e;">NB! livvakt-tjenesten går ut ved midnatt.</span></center>
            </p>
        </div>
        <form method="post">
            <div style="width: 33%; height: auto; float:left; border-right: 1px solid #2c2c2c;">
                <center>
                    <img src="img/action/livvakt_0.png" style="margin-bottom: 8px;">
                    <b>Pitbull</b><br>
                    <span style="color: #4e4e4e;"><?php echo $livvakt_effekt[0]; ?>% ekstra beskyttelse<br>
                        Pris: <?php echo number($livvakt_price[0]); ?></span><br>
                    <?php if($livvakt_lvl == 0){ ?>
                    <span style="color: orange;">Ikke aktivert</span>
                    <?php } elseif($livvakt_lvl >= 1){ ?>
                    <span style="color: green;">Aktivert</span>
                    <?php } ?>
                    <?php if($livvakt_lvl == 0){ ?>
                    <input type="submit" style="width: auto;" name="upgrade_livvakt" value="Aktiver">
                    <?php } ?>
                </center>
            </div>
            <div style="width: 33%; height: auto; float:left; border-right: 1px solid #2c2c2c;">
                <center>
                    <img src="img/action/livvakt_1.png" style="margin-bottom: 8px;">
                    <b>Personlig livvakt</b><br>
                    <span style="color: #4e4e4e;"><?php echo $livvakt_effekt[1]; ?>% ekstra beskyttelse<br>
                        Pris: <?php echo number($livvakt_price[1]); ?></span><br>
                    <?php if($livvakt_lvl <= 1){ ?>
                    <span style="color: orange;">Ikke aktivert</span>
                    <?php } elseif($livvakt_lvl >= 2){ ?>
                    <span style="color: green;">Aktivert</span>
                    <?php } ?>
                    <?php if($livvakt_lvl == 1){ ?>
                    <input type="submit" style="width: auto;" name="upgrade_livvakt" value="Aktiver">
                    <?php } ?>
                </center>
            </div>
            <div style="width: 33%; height: auto; float:left;">
                <center>
                    <img src="img/action/livvakt_2.png" style="margin-bottom: 8px;">
                    <b>Mafioso beskyttelse</b><br>
                    <span style="color: #4e4e4e;"><?php echo $livvakt_effekt[2]; ?>% ekstra beskyttelse<br>
                        Pris: <?php echo number($livvakt_price[2]); ?></span><br>
                    <?php if($livvakt_lvl <= 2){ ?>
                    <span style="color: orange;">Ikke aktivert</span>
                    <?php } elseif($livvakt_lvl >= 3){ ?>
                    <span style="color: green;">Aktivert</span>
                    <?php } ?>
                    <?php if($livvakt_lvl == 2){ ?>
                    <input type="submit" style="width: auto;" name="upgrade_livvakt" value="Aktiver">
                    <?php } ?>
                </center>
            </div>
        </form>
        </div>
    </body>
</html>
<?php 

}

?>