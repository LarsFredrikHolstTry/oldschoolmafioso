<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else { 

    $false = '<div class="feedback feilmelding"><span>Du oppfyller ikke kravene.</span></div>';
    
    $belonnelse_cash[0] =       1000000;
    $belonnelse_exp[0] =        2750;
    
    $belonnelse_cash[1] =       1000000;
    $belonnelse_exp[1] =        2750;
    
    $belonnelse_cash[2] =       1000000;
    $belonnelse_exp[2] =        2750;
    
    $belonnelse_cash[3] =       2500000;
    $belonnelse_exp[3] =        2775;
    
    $belonnelse_cash[4] =       2500000;
    $belonnelse_exp[4] =        2775;
    
    $belonnelse_cash[5] =       2700000;
    $belonnelse_exp[5] =        2800;
    
    $belonnelse_cash[6] =       2700000;
    $belonnelse_exp[6] =        2800;
    
    $belonnelse_cash[7] =       2700000;
    $belonnelse_exp[7] =        2800;
    
    $belonnelse_cash[8] =       2700000;
    $belonnelse_exp[8] =        2800;
    
    $belonnelse_cash[9] =       2700000;
    $belonnelse_exp[9] =        2800;
    
    $belonnelse_cash[10] =      2700000;
    $belonnelse_exp[10] =       2800;
    
    $belonnelse_cash[11] =      3000000;
    $belonnelse_exp[11] =       3850;
    
    $belonnelse_cash[12] =      3000000;
    $belonnelse_exp[12] =       3850;
    
    $belonnelse_cash[13] =      3000000;
    $belonnelse_exp[13] =       3850;
    
    $belonnelse_cash[13] =      50000000;
    $belonnelse_exp[13] =       3850;
    
    $belonnelse_cash[14] =      5000000;
    $belonnelse_exp[14] =       3850;
    
    $belonnelse_cash[15] =      5000000;
    $belonnelse_exp[15] =       3800;
    
    $belonnelse_cash[16] =      5000000;
    $belonnelse_exp[16] =       3875;
    
    $belonnelse_cash[17] =      2000000;
    $belonnelse_exp[17] =       3815;
    
    $belonnelse_cash[18] =      55000000;
    $belonnelse_exp[18] =       3815;
    
    $belonnelse_cash[19] =      20000000;
    $belonnelse_exp[19] =       4115;
    
    $belonnelse_cash[20] =      20000000;
    $belonnelse_exp[20] =       4815;
    
    $belonnelse_cash[21] =      0;
    $belonnelse_exp[21] =       4815;
    
    $belonnelse_cash[22] =      0;
    $belonnelse_exp[22] =       5915;
    
    $belonnelse_cash[23] =      50000000;
    $belonnelse_exp[23] =       5815;
    
    $belonnelse_cash[24] =      155550;
    $belonnelse_exp[24] =       5915;
    
    $belonnelse_cash[25] =      10055550;
    $belonnelse_exp[25] =       5515;
    
    $belonnelse_cash[26] =      10000000;
    $belonnelse_exp[26] =       7800;
    
    $belonnelse_cash[27] =      10000000;
    $belonnelse_exp[27] =       5800;
    
    $belonnelse_cash[28] =      10000000;
    $belonnelse_exp[28] =       5800;
    
    $belonnelse_cash[29] =      100000000;
    $belonnelse_exp[29] =       1800;
    
    $belonnelse_cash[30] =      200000000;
    $belonnelse_exp[30] =       3800;
    
    $belonnelse_cash[31] =      400000000;
    $belonnelse_exp[31] =       2800;
    
    $belonnelse_cash[32] =      375000000;
    $belonnelse_exp[32] =       1800;
    
    $belonnelse_cash[33] =      150000000;
    $belonnelse_exp[33] =       5800;
    
    $belonnelse_cash[34] =      150000000;
    $belonnelse_exp[34] =       2800;
    
    $belonnelse_cash[35] =      1200000000;
    $belonnelse_exp[35] =       15800;
    
    // Oppdrag 1 - 10 (OSLO ID 1)
    $oppdrag_desc[0] = "Utfør 10 velykkede krim";
    $oppdrag_desc[1] = "Utfør 5 velykkede biltyveri";
    $oppdrag_desc[2] = "Utfør 10 velykkede brekk";
    $oppdrag_desc[3] = "Oppnå 10 000 000 i banken";
    $oppdrag_desc[4] = "Kjøp våpen";
    $oppdrag_desc[5] = "Kjøp bolig";
    $oppdrag_desc[6] = "Skaff fire 2013 Nissan Leaf med under 40 000km i Oslo";
    $oppdrag_desc[7] = "Eksporter fire 2013 Nissan Leaf med under 40 000km fra Oslo til Kristiansand";
    $oppdrag_desc[8] = "Stjel en 2019 Tesla Model 3 med under 5000km i Oslo";
    $oppdrag_desc[9] = "Post en kommentar i forumet";
    
    // Kriterium for fullførelse av oppdrag 1 - 10 (OSLO ID 1)
    $kriterium[0] = 10;             // 10 krim
    $kriterium[1] = 5;              // 5 biltyveri
    $kriterium[2] = 10;             // 10 brekk
    $kriterium[3] = 10000000;       // 10 000 000 i banken
    $kriterium[4] = 1;              // 1 våpen
    $kriterium[5] = 1;              // 1 beskyttelse
    $kriterium[6] = 4;              // 4 2013 Nissan Leaf med under 20 000km
    $kriterium[7] = 4;              // Eksporter fire 2013 Nissan Leaf med under 20 000km fra Oslo til Kristiansand
    $kriterium[8] = 1;              // 1 2019 Tesla Model S med under 2000km
    $kriterium[9] = 1;              // Post en kommentar i forumet

    // Oppdrag 11 - 20 (KRISTIANSAND ID 0)
    $oppdrag_desc[10] = "Utfør 25 krim";
    $oppdrag_desc[11] = "Utfør 15 biltyveri";
    $oppdrag_desc[12] = "Utfør 30 brekk";
    $oppdrag_desc[13] = "Oppnå 50 000 000 i banken";
    $oppdrag_desc[14] = "Kjøp det beste våpenet";
    $oppdrag_desc[15] = "Kjøp den beste boligen";
    $oppdrag_desc[16] = "Stjel tre 2019 Aston Martin Vanquish i Kristiansand";
    $oppdrag_desc[17] = "Lag 25 filmer med Filmutstyr set 1";
    $oppdrag_desc[18] = "Oppnå ranken El Capitan";
    $oppdrag_desc[19] = "Lag 5 filmer med Filmutstyr set 3";
    
    // Kriterium for fullførelse av oppdrag 11 - 20 (KRISTIANSAND ID 0)
    $kriterium[10] = 25;             // 25 krim
    $kriterium[11] = 15;             // 15 biltyveri
    $kriterium[12] = 30;             // 30 brekk
    $kriterium[13] = 50000000;       // 50 000 000 i banken
    $kriterium[14] = 1;              // beste våpen
    $kriterium[15] = 1;              // beste beskyttelse
    $kriterium[16] = 3;              // tre 2019 Aston Martin Vanquish i Kristiansand
    $kriterium[17] = 25;             // Lag 25 filmer med Filmutstyr set 1
    $kriterium[18] = 1;              // Oppnå ranken El Capitan
    $kriterium[19] = 5;              // Lag 5 filmer med Filmutstyr set 3
    
    // Oppdrag 21 - 30 (TROMSØ ID 4)
    $oppdrag_desc[20] = "Utfør 55 krim";
    $oppdrag_desc[21] = "Utfør 35 biltyveri";
    $oppdrag_desc[22] = "Utfør 50 brekk";
    $oppdrag_desc[23] = "Oppnå 100 000 000 i banken";
    $oppdrag_desc[24] = "Stjel 20 biler";
    $oppdrag_desc[25] = "Selg biler for 100 000 000";
    $oppdrag_desc[26] = "Utfør 2 vanskelige hurtig oppdrag";
    $oppdrag_desc[27] = "Vinn 50 ganger på race club";
    $oppdrag_desc[28] = "Selg 100 biler";
    $oppdrag_desc[29] = "Vinn 100 000 000 i gambling, går du i minus så resettes telleren.";

    // Kriterium for fullførelse av oppdrag 21 - 30 (TROMSØ ID 4)
    $kriterium[20] = 55;             // 55 krim
    $kriterium[21] = 35;             // 35 biltyveri
    $kriterium[22] = 50;             // 50 brekk
    $kriterium[23] = 100000000;      // 100 000 000 i banken
    $kriterium[24] = 20;             // stjel 20 biler
    $kriterium[25] = 100000000;      // selg biler for 100 000 000
    $kriterium[26] = 2;              // Utfør 2 hurtige oppdrag
    $kriterium[27] = 50;             // Vinn 50 ganger på race club
    $kriterium[28] = 50;             // Selg 50 biler
    $kriterium[29] = 100000000;      // Vinn 100 000 000 i gambling
    
    // Oppdrag 31 - 36 (Bergen ID 4)
    $oppdrag_desc[30] = "Utfør 150 krim";
    $oppdrag_desc[31] = "Utfør 150 brekk";
    $oppdrag_desc[32] = "Produser 25 filmer med filmutstyr 3";
    $oppdrag_desc[33] = "Selg biler for 500 000 000 kr";
    $oppdrag_desc[34] = "Oppnå 225 rigg på crypto";
    $oppdrag_desc[35] = "Ta ut av crypto 50 ganger";

    // Kriterium for fullførelse av oppdrag 31 - 36 (BERGEN ID 2)
    $kriterium[30] = 150;            // 150 krim
    $kriterium[31] = 150;            // 150 brekk
    $kriterium[32] = 25;             // 25 filmer med filmutstyr 3
    $kriterium[33] = 500000000;      // Selg biler for 500 mill
    $kriterium[34] = 225;            // Oppnå 225 rigg på crypto
    $kriterium[35] = 50;             // Ta ut av crypto 50 ganger

    
    


?>
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Oppdrag » <?php echo $city_name[$city]; ?> » </span><span style="color: #afafaf;">Oppdrag <?php echo ($oppdrag + 1) ?></span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <?php
    
////////////////////////////////////////////////

if(isset($_POST['next_mission'])){
    if($value >= $kriterium[$oppdrag]){
        $result = "UPDATE oppdrag SET oppdrag = ($oppdrag + 1), value = 0 WHERE acc_id='".$_SESSION['ID']."'";
        mysqli_query($con, $result) or die("Bad query: $result");

        $result = "UPDATE accounts SET money = (money + $belonnelse_cash[$oppdrag]), exp = (exp + $belonnelse_exp[$oppdrag]) WHERE ID='".$_SESSION['ID']."'";
        
        /*
        $query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
        VALUES ('$ID', '".$_GET['side']."', 'OPPDRAG NESTE - nr. $oppdrag', '$money', '$bank_money', '".time()."')";
        $result = mysqli_query($con, $query);

        
        $result = "UPDATE daily_exp SET exp = (exp + $belonnelse_exp[$oppdrag]) WHERE acc_id='".$ID."'";
        mysqli_query($con, $result) or die("Bad query: $result");
        */
        
        header("Location: index.php?side=oppdrag&cash=$belonnelse_cash[$oppdrag]&exp=$belonnelse_exp[$oppdrag]");

        mysqli_query($con, $result) or die("Bad query: $result");
    } else {
        echo '<div class="feedback mislykket">
            <span>Du oppfyller ikke kravene</span> 
        </div>';
    }
}

////////////////////////////////////////////////

    
if(isset($_GET['cash'])){
    echo '<div class="feedback velykket">
        <span>Oppdraget ble vellykket utført og du fikk '.number($_GET['cash']).'kr og '.number($_GET['exp']).' exp.</span> 
    </div>';
}
    
    ?>
            <div class="tab">
              <button style="width: 50%;" class="tablinks pad_10" onclick="openTab(event, 'my_mission')" id="defaultOpen">Oppdrag</button>
              <button style="width: 50%;" class="tablinks pad_10" onclick="openTab(event, 'missions')">Oppdragsoversikt</button>
            </div>
            
            <div id="my_mission" class="tabcontent">
                <form method="POST" action="" style="padding: 0; margin: 0;">
                <img src="img/action/oppdrag.png" style="width: 100%; height: auto;">
                <div style="padding: 10px; word-wrap: break-word; margin-top: -15px; white-space: pre-line;" class="textbox">
                    <p style="padding-bottom: 0; margin-bottom: 0;"><?php 
    
    
                    if($city == 1){
                        if($oppdrag >= 0 && $oppdrag <= 9){
                            echo 'Oppdrag: ';
                            echo $oppdrag_desc[$oppdrag];
                            echo "<br>Du har: "; echo number($value);
                            echo " (av: ";
                            echo number($kriterium[$oppdrag]);
                            echo ")";
                            echo '<br><br><input style="margin-bottom: -15px; width: 47.5%;" type="submit" name="next_mission" value="Gjennomfør oppdrag">';
                        } else {
                            echo 'Du må gjøre oppdragene som kreves i andre byer først for å gjøre oppdrag i denne byen. Sjekk oppdragsoversikten.';
                        }
                    } elseif($city == 0){
                        if($oppdrag >= 10 && $oppdrag <= 19){
                            echo 'Oppdrag: ';
                            echo $oppdrag_desc[$oppdrag];
                            echo "<br>Du har: "; echo number($value);
                            echo " (av: ";
                            echo number($kriterium[$oppdrag]);
                            echo ")";
                            echo '<br><br><input style="margin-bottom: -15px; width: 47.5%;" type="submit" name="next_mission" value="Gjennomfør oppdrag">';
                        } else {
                            echo 'Du må gjøre oppdragene som kreves i andre byer først for å gjøre oppdrag i denne byen. Sjekk oppdragsoversikten.';
                        }
                    } elseif($city == 4){
                        if($oppdrag >= 20 && $oppdrag <= 29){
                            echo 'Oppdrag: ';
                            echo $oppdrag_desc[$oppdrag];
                            echo "<br>Du har: "; echo number($value);
                            echo " (av: ";
                            echo number($kriterium[$oppdrag]);
                            echo ")";
                            echo '<br><br><input style="margin-bottom: -15px; width: 47.5%;" type="submit" name="next_mission" value="Gjennomfør oppdrag">';
                        } else {
                            echo 'Du må gjøre oppdragene som kreves i andre byer først for å gjøre oppdrag i denne byen. Sjekk oppdragsoversikten.';
                        }
                    } elseif($city == 2){
                        if($oppdrag >= 30 && $oppdrag <= 35){
                            echo 'Velkommen til Bergen, her stiller vi harde krav for erfarne mafiaer og oppdragene vil være mer krevende enn de forrige, men utbetalingen er betraktelig bedre.<br><br>';
                            echo 'Oppdrag: ';
                            echo $oppdrag_desc[$oppdrag];
                            echo "<br>Du har: "; echo number($value);
                            echo " (av: ";
                            echo number($kriterium[$oppdrag]);
                            echo ")";
                            echo '<br><br><input style="margin-bottom: -15px; width: 47.5%;" type="submit" name="next_mission" value="Gjennomfør oppdrag">';
                        } elseif($oppdrag == 36){
                            echo 'Du har gjort alle oppdrag på spillet! Flere oppdrag kommer..';
                        } else {
                            echo 'Du må gjøre oppdragene som kreves i andre byer først for å gjøre oppdrag i denne byen. Sjekk oppdragsoversikten.';
                        }
                    } else {
                        echo 'Du må gjøre oppdragene som kreves i andre byer først for å gjøre oppdrag i denne byen. Sjekk oppdragsoversikten.';
                    }


                        ?></p>
                </div>
                </form>
            </div>
            
            <div id="missions" class="tabcontent">
                <div style="word-wrap: break-word; margin-top: -15px; white-space: pre-line;" class="textbox">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr style="height: 30px;">
                        <th style="padding-left: 15px; width: 10%;">Nr</th>
                        <th style="width: 70%;">Beskrivelse</th>
                        <th style="width: 20%;">By</th>
                    </tr>
                    <?php for($i = 0; $i < 36; $i++){  ?>
                    <tr style="height: 25px;">
                        <td
                            <?php if($i == $oppdrag){ ?> 
                            style="padding-left: 15px; color: orange;" 
                            <?php } if($i > $oppdrag){ ?>
                            style="padding-left: 15px; color: red;"
                            <?php } if($i < $oppdrag){ ?>
                            style="padding-left: 15px; color: green;"
                            <?php } ?>
                            style="padding: 5px;"><?php echo $i + 1 ?>.</td>
                        <td
                            <?php if($i == $oppdrag){ ?> 
                            style="color: orange;" 
                            <?php } if($i > $oppdrag){ ?>
                            style="color: red;"
                            <?php } if($i < $oppdrag){ ?>
                            style="color: green;"
                            <?php } ?>
                            ><?php echo $oppdrag_desc[$i] ?></td>
                        <td
                            <?php if($i == $oppdrag){ ?> 
                            style="color: orange;" 
                            <?php } if($i > $oppdrag){ ?>
                            style="color: red;"
                            <?php } if($i < $oppdrag){ ?>
                            style="color: green;"
                            <?php } ?>
                            ><?php if($i >= 0 && $i <= 9) { echo 'Oslo'; } elseif($i >= 10 && $i <= 19){ echo 'Kristiansand'; } elseif($i >= 20 && $i <= 29){ echo 'Tromsø'; } elseif($i >= 30 && $i <= 34){ echo 'Bergen'; } 
                            elseif($i == 35){ echo 'Valgfritt'; } ?></td>
                    </tr>
                    <?php } ?>
                </table>
                </div>
            </div>
        </div>
    </body>
</html>
<?php 
       
}

?>

<script>

function openTab(evt, tabPage) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabPage).style.display = "block";
    evt.currentTarget.className += " active";
}
    
document.getElementById("defaultOpen").click();

</script>