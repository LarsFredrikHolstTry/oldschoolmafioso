<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else { 
?>
<html>

<head></head>

<body>
    <div class="breadcrumb">
        <span style="color: #3e3e3e;">Diverse » </span><span style="color: #afafaf;">Politistasjonen</span>
        <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
    </div>
    <div class="content">
        <?php
            
            $sql = "SELECT * FROM filmproduction WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
            $query = mysqli_query($con, $sql) or die (mysqli_error());
            $row_mp = mysqli_fetch_assoc($query);
            $sertificate =               $row_mp['sertificate'];
            
            if(isset($_POST['submit'])){
                if($money < 100000){
                    echo '<div class="feedback feilmelding">
                        <span><b>Feilmelding!</b> Du har ikke råd til sertifikat!</span> 
                    </div>';
                } else {
                    if($sertificate == 0){
                        $result = "UPDATE filmproduction SET sertificate = ($sertificate + 1) WHERE acc_id='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                        
                        $result = "UPDATE accounts SET money = ($money - 100000) WHERE ID='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        header("Location: index.php?side=politistasjonen&sertifikat=success");
                    } else {
                        echo '<div class="feedback feilmelding">
                            <span><b>Feilmelding!</b> Du har allerede sertifikat for filming!</span> 
                        </div>';
                    }
                }
            }
    
            $bunker_pris = 250000;
    
            if(isset($_POST['submit_bunker'])){
                if($money < $bunker_pris){
                    echo '<div class="feedback feilmelding">
                        <span><b>Feilmelding!</b> Du har ikke nok penger for bunkertillatelse!</span> 
                    </div>';
                } elseif($beskyttelse < 2){
                    echo '<div class="feedback feilmelding">
                        <span><b>Feilmelding!</b> Du har ikke en bolig som kan ha bunkertillatelse!</span> 
                    </div>';
                } elseif($bunker == 1) {
                    echo '<div class="feedback feilmelding">
                        <span><b>Feilmelding!</b> Du har allerede bunkertillatelse!</span> 
                    </div>';
                } else {
                    $result = "UPDATE accounts SET bunker = '1' WHERE ID='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    
                    echo '<div class="feedback velykket">
                        <span>Du har fått invilget bunkertillatelse og kan nå bygge bunker på bolig!</span> 
                    </div>';
                }
            }
            
            if(isset($_GET['sertifikat'])){
                echo '<div class="feedback velykket">
                    <span><b>Velykket!</b> Du har mottat sertifikat for filming!</span> 
                </div>';
            }
            
            ?>
        <form method="post">
            <div class="header">
                <span>Politistasjonen</span>
            </div>
            <img src="img/action/politistasjonen.png" style="width: 100%; height: auto;">
            <p class="pad_10">
                Velkommen til politistasjonen! Her kan du søke om forskjellige sertifikater, blant annet filmsertifikat. Når du skal bygge bunker så må du også hit for å søke istedenfor gjennom direktoratet for byggkvalitet.
            </p>
            <input style="width: 97.5%;" type="submit" name="submit" value="Søk om filmsertifikat (pris: 100 000kr)">
            <input style="width: 97%;" type="submit" name="submit_bunker" value="Søk om bunkertillatelse (pris: <?php echo number($bunker_pris); ?>kr)">

        </form>
    </div>
</body>

</html>
<?php } ?>
