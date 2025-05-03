<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else { 
    
    $title[0] = "Om spillet";
    $desc[0] = "Mafioso er et tekstbasert mafiaspill hvor man spiller et rollespill. Alt som er i spillet er fiktivt og skal på ingen måte bli inspirert til å brukes eller konstrueres i det virkelige liv. Mafioso skal i hovedtrekk brukes som et tidsfordriv og en samleplass for venner. Spillet anbefales for ungdom over 16 år.";
    $id[0] = "0";
    
    $title[1] = "BB-koder";
    $desc[1] = '<table border="0" cellspacing="0" cellpadding="0">
            <tr style="height: 30px;">
                <th style="padding-left: 10px;">BB-kode</th>
                <th>Beskrivelse</th>
                <th>Eksempel</th>
            </tr>
            <tr style="height: 25px;">
                <td style="padding-left: 10px;">[center][/center]</td>
                <td>Midstiller tekst</td>
                <td>
                    <center>Eksempel</center>
                </td>
            </tr>
            <tr style="height: 25px;">
                <td style="padding-left: 10px;">[b][/b]</td>
                <td>Feit tekst</td>
                <td><b>Eksempel</b></td>
            </tr>
            <tr style="height: 25px;">
                <td style="padding-left: 10px;">[i][/i]</td>
                <td>Italic tekst</td>
                <td><i>Eksempel</i></td>
            </tr>
            <tr style="height: 25px;">
                <td style="padding-left: 10px;">[u][/u]</td>
                <td>Understrek</td>
                <td><u>Eksempel</u></td>
            </tr>
            <tr style="height: 25px;">
                <td style="padding-left: 10px;">[size=15][/size]</td>
                <td>Gitt størrelse på tekst fra font-størrelse</td>
                <td><span style="font-size:15;">Eksempel</span></td>
            </tr>
            <tr style="height: 25px;">
                <td style="padding-left: 10px;">[color=red][/color]</td>
                <td>Gitt farge på tekst</td>
                <td><span style="color:red">Eksempel</span></td>
            </tr>
            <tr style="height: 25px;">
                <td style="padding-left: 10px;">[url=https://mafioso.no]https://mafioso.no[/url]</td>
                <td>Link</td>
                <td><a href="https://mafioso.no">https://mafioso.no</a></td>
            </tr>
            <tr style="height: 25px;">
                <td style="padding-left: 10px;">[img][/img]</td>
                <td>Bilde</td>
                <td>[Ingen eksempel]</td>
            </tr>
            <tr style="height: 25px;">
                <td style="padding-left:10px;">[quote=Skitzo]Hei[/quote]</td>
                <td>Quote, funker best på forum</td>
                <td>[Ingen eksempel]</td>
            </tr>
        </table>';
    $id[1] = "1";
    
    $title[2] = "Hurtig oppdrag";
    $desc[2] = "Hurtig oppdrag er en kjapp måte å skaffe ekstra exp på. Det er pr dags dato 2 forskjellige hurtige oppdrag; enkel og vanskelig. Hovedoppgaven er å klare den gitte oppgaven innen ett viss tidspunkt. Feiler du så får du ingenting.";
    $id[2] = "2";
    
    $title[3] = "Heist";
    $desc[3] = "Heist kan gjøres i Oslo og er ett oppdrag fra Parque hvor han har noen erkefiender på vestkanten som skylder han penger. Ditt oppdrag er å samle ett team til å rane vestkant-klysen og selge verdiene. Jo bedre våpen dere har, desto større sjanse er det for å få godkjent.";
    $id[3] = "3";
    
    $title[4] = "Brekk";
    $desc[4] = "På brekk kan du stjele bildeler som du bruker i race club for å få en bedre bil. Jo mindre skadet delene er, desto bedre blir bilen.";
    $id[4] = "4";

    $title[5] = "Stjel";
    $desc[5] = "På stjel kan du stjele penger eller biler fra andre medspillere. Om medspilleren du prøver å rane fra har full sikkerhet i garasjen så er det ikke mulig å rane han.";
    $id[5] = "5";
    
    $title[6] = "Race Club";
    $desc[6] = "Race club er en funksjon hvor du tuner bilen din og racer mot andre. Når du vinner får du litt exp.";
    $id[6] = "6";
    
    $title[7] = "Filmproduksjon";
    $desc[7] = "På filmproduksjon kan du produsere filmer for å få penger. Pengene du går inn med kan tapes om filmen blir en flopp. Utbetaling ser du på filmproduksjon siden.";
    $id[7] = "7";
    
    $title[8] = "Banken";
    $desc[8] = "Banken er der du har pengene dine. Ved midnatt får du 10% renter om du har 500 mill eller mindre på konto. Ved overførsel trekkes 10% som går til staten.";
    $id[8] = "8";
    
    $title[9] = "Bunker";
    $desc[9] = "Når du er i bunker så kan du ikke dø. Maks tid for å være i bunker er 1 døgn. Pris for å gå i bunker 10 000kr. Om du velger å gå ut av bunkeren får du en cooldown på 5 min.";
    $id[9] = "9";
    
    $title[10] = "Drap";
    $desc[10] = '
            Tallet er oppgitt i EXP pr kule. Torpedo trenger 10% mindre kuler.<br>
            F.eks: Har en bruker 100 000 exp og du har grenade launcher er mattestykket:<br>
            <b>100 000 / 750 = antall kuler</b> som kreves for å drepe spilleren.<br>
            Om den du skal drepe har livvakt må du ta høyde for det i utregningen.
            <table border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 30px;">
                    <th style="width: 16%; padding-left: 10px;">Glock</th>
                    <th style="width: 16%;">Uzi</th>
                    <th style="width: 16%;">M4A4</th>
                    <th style="width: 16%;">AK-47</th>
                    <th style="width: 16%;">RPG</th>
                    <th style="width: 16%;">Grenade Launcher</th>
                </tr>
                <tr style="height: 25px;">
                    <td style="padding-left: 10px;">250</td>
                    <td>350</td>
                    <td>450</td>
                    <td>550</td>
                    <td>650</td>
                    <td>750</td>
                </tr>
            </table>';
    $id[10] = "10";

?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Mafioso » </span><span style="color: #afafaf;">FAQ</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <div class="header">
                <span>FAQ</span>
            </div>
            <div class="pad_10">
                Her vil du finne den informasjonen du trenger å kunne for å spille mafioso.
            </div>
            <div class="header">
                <span>Innholdsfortegnelse</span>
            </div>
            <div style="width: 100%; height: 100px;">
                <div style="width: 29%; float: left; height: auto; padding: 5px 10px;">
                    <?php for($i = 0; $i < count($title); $i = $i + 3){ ?>
                        <a style="text-decoration: none; color: white;" href="#<?php echo $id[$i] ?>"><?php echo $title[$i]; ?></a><br>
                    <?php } ?>
                </div>
                <div style="width: 29%; float: left; height: auto; padding: 5px 10px;">
                    <?php for($i = 1; $i < count($title); $i = $i + 3){ ?>
                        <a style="text-decoration: none; color: white;" href="#<?php echo $id[$i] ?>"><?php echo $title[$i]; ?></a><br>
                    <?php } ?>
                </div>
                <div style="width: 29%; float: left; height: auto; padding: 5px 10px;">
                    <?php for($i = 2; $i < count($title); $i = $i + 3){ ?>
                        <a style="text-decoration: none; color: white;" href="#<?php echo $id[$i] ?>"><?php echo $title[$i]; ?></a><br>
                    <?php } ?>
                </div>
            </div>
            <?php for($i = 0; $i < count($title); $i++){ ?>
                <div id="<?php echo $id[$i] ?>" class="header header_mid">
                    <span><?php echo $title[$i]; ?></span>
                </div>
                <div class="pad_10">
                    <?php echo $desc[$i] ?>
                </div>
            <?php } ?>
                <div id="11" class="header header_mid">
                    <span>Rank</span>
                </div>
                <div class="pad_10">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr style="height: 30px;">
                            <th style="width: 10%;"></th>
                            <th style="width: 40%;">Ranknavn</th>
                            <th style="width: 25%;">EXP fra</th>
                            <th style="width: 25%;">EXP til</th>
                        </tr>
                        <?php for($i = 0; $i < 12; $i++){ ?>
                        <tr style="height: 25px;">
                            <td style="padding-left: 10px;"><?php echo $i + 1 ?>.</td>
                            <td><?php echo $rank_name[$i] ?></td>
                            <td><?php echo number($rank_exp_from[$i]) ?></td>
                            <td><?php echo number($rank_exp_to[$i]) ?></td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
                <div id="12" class="header header_mid">
                    <span>Biler</span>
                </div>
            <div class="pad_10">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr style="height: 30px;">
                <th style="width: 40%;padding-left: 10px;">Bil</th>
                <th style="width: 25%;">Alternativ</th>
                <th style="width: 25%;">Pris</th>
            </tr>
            <?php 

            for($i = 0; $i < 8; $i++){ ?>
            <tr style="height: 25px;">
                <td style="padding-left: 10px;"><?php echo $car[$i] ?></td>
                <td><?php if($i >= 0 && $i < 4){ echo '1'; } elseif($i >= 4 && $i < 8){ echo '2'; } ?></td>
                <td><?php echo number($car_price[$i]) ?></td>
            </tr>
            <?php } 
                
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
                
                ?>


            <tr style="height: 25px;">
                <td style="padding-left: 10px;"><?php echo $car[12]; ?></td>
                <td>3</td>
                <td><?php echo number($car_price[12]); ?></td>
            </tr>
            <tr style="height: 25px;">
                <td style="padding-left: 10px;"><?php echo $car[8]; ?></td>
                <td>3</td>
                <td><?php echo number($car_price[8]); ?></td>
            </tr>
            <tr style="height: 25px;">
                <td style="padding-left: 10px;"><?php echo $car[9]; ?></td>
                <td>3</td>
                <td><?php echo number($car_price[9]); ?></td>
            </tr>
            <tr style="height: 25px;">
                <td style="padding-left: 10px;"><?php echo $car[11]; ?></td>
                <td>3</td>
                <td><?php echo number($car_price[11]); ?></td>
            </tr>
            <tr style="height: 25px;">
                <td style="padding-left: 10px;"><?php echo $car[10]; ?></td>
                <td>3</td>
                <td><?php echo number($car_price[10]); ?></td>
            </tr>
        </table>

            </div>
                <div id="12" class="header header_mid">
                    <span>Pengestatuser</span>
                </div>
            <div class="pad_10">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr style="height: 30px;">
                <th style="width: 10%;"></th>
                <th style="width: 40%;">Pengerank navn</th>
                <th style="width: 25%;">Penger fra</th>
                <th style="width: 25%;">Penger til</th>
            </tr>
            <?php 

$money_amount_from[0] =     0;
$money_amount_to[0] =       10000;
$money_amount_from[1] =     $money_amount_to[0];
$money_amount_to[1] =       100000;
$money_amount_from[2] =     $money_amount_to[1];
$money_amount_to[2] =       1000000;
$money_amount_from[3] =     $money_amount_to[2];
$money_amount_to[3] =       10000000;
$money_amount_from[4] =     $money_amount_to[3];
$money_amount_to[4] =       100000000;
$money_amount_from[5] =     $money_amount_to[4];
$money_amount_to[5] =       1000000000;
$money_amount_from[6] =     $money_amount_to[5];
$money_amount_to[6] =       10000000000;
$money_amount_from[7] =     $money_amount_to[6];
$money_amount_to[7] =       25000000000;
$money_amount_from[8] =     $money_amount_to[7];
$money_amount_to[8] =       50000000000;
$money_amount_from[9] =     $money_amount_to[8];
$money_amount_to[9] =       INF;
        
$money_rank[0] = "NAVer";
$money_rank[1] = "Arbeider";
$money_rank[2] = "Langer";
$money_rank[3] = "Millionær";
$money_rank[4] = "Gambler";
$money_rank[5] = "Aksjonær";
$money_rank[6] = "Oljesjeik <i style='color: black;' class='fas fa-tint'></i>";
$money_rank[7] = "Hotell-investor <i style='color: silver;' class='fas fa-hotel'></i>";
$money_rank[8] = "Wolf of Wall St. <i style='color: green;' class='fas fa-dollar-sign'></i>";
$money_rank[9] = "Skrue McDuck <i style='color: gold;' class='fas fa-coins'></i>";

        for($i = 0; $i < 10; $i++){ ?>
            <tr style="height: 25px;">
                <td style="padding-left: 10px;"><?php echo $i + 1 ?>.</td>
                <td><?php echo $money_rank[$i] ?></td>
                <td><?php echo number($money_amount_from[$i]) ?></td>
                <td><?php echo number($money_amount_to[$i]) ?></td>

            </tr>
            <?php } ?>
        </table>
            
            </div>
        </div>
    </body>
</html>
<?php 

}

?>