
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
            <span style="color: #afafaf;">Vervekonk</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <div class="header">
                <span>Vervekonk</span>
            </div>
            <div class="pad_10" style="padding-top: 0;">
                <p>Vervekonken sparker i gang NÅ. Du får 2 poeng pr bruker du verver og 1 poeng pr rank spilleren ranker når du har vervet spilleren. Oppdages det juks blir dette trekt fra din poengsum, multi er strengt ulovlig. For at registreringspoengene skal telles så må brukeren være i minst ranken Soldier</p>
                <p>F.eks: Verver du en spiller og han ranker til El Capitan så får du totalt 2 + 4 = 6 poeng<br>Den med mest poeng vinner!</p>
                <p>Om du skulle dø på din bruker, så kan du ta med deg dine poeng over til din nye bruker ved å ta kontakt med Skitzo.</p>
                
                <div style="background-color: #121212; padding: 10px; border-radius: 5px;">Vervekonken varer til 1. Mars kl 18:00</div>
                <p><b>Premieliste:</b><br></p>
            <table border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 30px;">
                    <th style="width: 25%; padding-left: 15px;">Plassering</th>
                    <th style="width: 35%;">Penger</th>
                    <th style="width: 20%;">EXP</th>
                    <th style="width: 20%;">Kuler</th>
                </tr>
                <tr style="height: 25px;">
                    <td style="padding-left: 15px;">1. plass</td>
                    <td>1 000 000 000</td>
                    <td>20 250</td>
                    <td>750</td>
                </tr>
                <tr style="height: 25px;">
                    <td style="padding-left: 15px;">2. plass</td>
                    <td>650 000 000</td>
                    <td>15 850</td>
                    <td>545</td>
                </tr>
                <tr style="height: 25px;">
                    <td style="padding-left: 15px;">3. plass</td>
                    <td>350 000 000</td>
                    <td>10 750</td>
                    <td>235</td>
                </tr>
                </table>

                <p>Når du verver en spiller så får du 10 mill pr spiller, spilleren du verver får også 10 mill. Vi minner om at det kun er lov å ha 1 bruker pr IP-adresse. Hvis verving brukes for å jukse så blir det utgitt utestenging fra spillet.</p>
                <span> Din vervelink:</span>
                <div style="background-color: #121212; padding: 10px; border-radius: 5px;">https://mafioso.no/registrer.php?verv=<?php echo $ID ?></div>
                <br>
                <span> Du har:</span>
                <div style="background-color: #121212; padding: 10px; width: 50%; border-radius: 5px;">
                    <?php
        
                $result = mysqli_query($con, 'SELECT SUM(rank) AS value_sum FROM verv_konk WHERE vervet_av = "'.$ID.'"'); 
                $row = mysqli_fetch_assoc($result); 
                $sum = $row['value_sum'];
                    if($sum == null){
                        echo '0';
                    } else {
                        echo $sum;
                    }
                     ?> 
                    poeng</div>

            </div>
            
            <div class="header" style="border-top: 1px solid #2c2c2c">
                <span>Topp 10</span>
            </div>
            <table border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 30px;">
                    <th style="width: 33%; padding-left: 15px;">Plassering</th>
                    <th style="width: 33%;">ID</th>
                    <th style="width: 33%;">Poeng</th>
                </tr>
                <?php   
    
            $result_verve_konk = mysqli_query($con, "SELECT * FROM verv_konk GROUP BY vervet_av ORDER BY SUM(rank) DESC LIMIT 10");
    
            $i = 0;
            while($row_verve_konk = mysqli_fetch_assoc($result_verve_konk)) {
    
                $result = mysqli_query($con, 'SELECT SUM(rank) AS value_sum FROM verv_konk WHERE vervet_av = "'.$row_verve_konk['vervet_av'].'"'); 
                $row = mysqli_fetch_assoc($result); 
                $sum = $row['value_sum'];
                
                $i++;
                
            ?>
                <tr style="height: 25px;">
                    <td style="padding-left: 15px;"><?php echo $i; ?>. plass</td>
                    <td><?php if($account_type < 1){ ?> #HEMMELIG# <?php } else { ?> <a href="index.php?side=profil&bruker=<?php echo $row_verve_konk['vervet_av']; ?>"><?php echo $row_verve_konk['vervet_av']; ?></a> <?php } ?></td>
                    <td><?php echo number($sum); ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </body>
</html>
<?php 

}

?>