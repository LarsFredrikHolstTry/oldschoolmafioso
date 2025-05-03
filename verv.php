
<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else { 
    
?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Diverse » </span><span style="color: #afafaf;">Verv spiller</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <div class="pad_10">
                <p>Når du verver en spiller så får du 10 mill pr spiller, spilleren du verver får også 10 mill. Vi minner om at det kun er lov å ha <br>1 bruker pr IP-adresse. Hvis verving brukes for å jukse så blir det utgitt ban.</p><br>
                <p>Din vervelink:</p>

                <div style="background-color: black; padding: 10px; border-radius: 5px;">https://mafioso.no/registrer.php?verv=<?php echo $ID ?></div>

            </div>
        </div>
    </body>
</html>
<?php 

}

?>