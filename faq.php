<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else { 

?>
<!-- CONTENT -->
<html>

<head>
    <style>
        a {
            text-decoration: none;
            color: grey;
            transition: .2s;
        }

        a:hover {
            color: #009fe3;
        }
    </style>

</head>

<body>
    <div class="breadcrumb">
        <span style="color: #3e3e3e;">Hjelp » </span><span style="color: #afafaf;">FAQ</span>
        <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
    </div>
    <div class="content">
        <div class="header">
            <span>FAQ</span>
        </div>
        <div style="padding: 10px; word-wrap: break-word; margin-top: -15px; white-space: pre-line;" class="textbox">
            <b>Her vil du finne den informasjonen du trenger å kunne for å spille mafioso.</b>
        </div>
        <div class="header">
            <span>Innholdsfortegnelse</span>
        </div>
        <div style="padding: 10px; height: 100px; margin-top: -15px; white-space: pre-line;" class="textbox">
            <div style="overflow: hidden; width: 33%; float:left;">
                <a href="#oppdrag">Oppdrag</a>

                <a href="#hurtig_oppdrag">Hurtig oppdrag</a>

                <a href="#heist">Heist</a>

            </div>
            <div style="width: 33%; float:left;"> <a href="#brekk">brekk</a>
                
                <a href="#stjel">stjel</a>
                
                <a href="#raceclub">Race club</a>
            </div><div style="width: 33%; float:left;"><a href="#film">Filmproduksjon</a>
                
                <a href="#bank">Banken</a>
                
                <a href="#bunker">Bunker</a>
            </div>
        </div>
        <div id="oppdrag" class="header">
            <span>Oppdrag</span>
        </div>
        <div style="padding: 10px; word-wrap: break-word; margin-top: -15px; white-space: pre-line;" class="textbox">
            Oppdrag kan gjøres hele tiden og er en god aktivitet for å få masse exp. Man får også penger fra noen utvalgte oppdrag. For å se hvilke oppdrag som skal gjøres i hvilke byer kan man sjekke oppdrags-oversikten inne på "oppdrag".
        </div>
        <div id="hurtig_oppdrag" class="header">
            <span>Hurtig oppdrag</span>
        </div>
        <div style="padding: 10px; word-wrap: break-word; margin-top: -15px; white-space: pre-line;" class="textbox">
            Hurtig oppdrag er en kjapp måte å skaffe ekstra exp på. Det er pr dags dato 2 forskjellige hurtige oppdrag; enkel og vanskelig. Hovedoppgaven er å klare den gitte oppgaven innen ett viss tidspunkt. Feiler du så får du ingenting.
        </div>
        <div id="heist" class="header">
            <span>Heist</span>
        </div>
        <div style="padding: 10px; word-wrap: break-word; margin-top: -15px; white-space: pre-line;" class="textbox">
            Heist kan gjøres i Oslo og er ett oppdrag fra Parque hvor han har noen erkefiender på vestkanten som skylder han penger. Ditt oppdrag er å samle ett team til å rane vestkant-klysen og selge verdiene. Jo bedre våpen dere har, desto større sjanse er det for å få godkjent.
        </div>
        <div id="brekk" class="header">
            <span>Brekk</span>
        </div>
        <div style="padding: 10px; word-wrap: break-word; margin-top: -15px; white-space: pre-line;" class="textbox">
            På brekk kan du stjele bildeler som du bruker i race club for å få en bedre bil. Jo mindre skadet delene er, desto bedre blir bilen.
        </div>
        <div id="stjel" class="header">
            <span>Stjel</span>
        </div>
        <div style="padding: 10px; word-wrap: break-word; margin-top: -15px; white-space: pre-line;" class="textbox">
            På stjel kan du stjele penger eller biler fra andre medspillere. Om medspilleren du prøver å rane fra har full sikkerhet i garasjen så er det ikke mulig å rane han.
        </div>
        <div id="raceclub" class="header">
            <span>Race club</span>
        </div>
        <div style="padding: 10px; word-wrap: break-word; margin-top: -15px; white-space: pre-line;" class="textbox">
            Race club er en funksjon hvor du tuner bilen din og racer mot andre. Når du vinner får du litt exp.
        </div>
        <div id="film" class="header">
            <span>Filmproduksjon</span>
        </div>
        <div style="padding: 10px; word-wrap: break-word; margin-top: -15px; white-space: pre-line;" class="textbox">
            På filmproduksjon kan du produsere filmer for å få penger. Pengene du går inn med kan tapes om filmen blir en flopp, da må du skaffe alt av utstyr på nytt før du kan produsere en ny film.
        </div>
        <div id="bank" class="header">
            <span>Banken</span>
        </div>
        <div style="padding: 10px; word-wrap: break-word; margin-top: -15px; white-space: pre-line;" class="textbox">
            Banken er der du har pengene dine. Ved midnatt får du 10% renter om du har 500 mill eller mindre på konto. Ved overførsel trekkes 10% som går til staten.
        </div>
        <div id="bunker" class="header">
            <span>Bunker</span>
        </div>
        <div style="padding: 10px; word-wrap: break-word; margin-top: -15px; white-space: pre-line;" class="textbox">
            Maks tid for å være i bunker er 1 døgn. Pris for å gå i bunker 10 000kr. Om du velger å gå ut av bunkeren får du en cooldown på 5 min
        </div>
        <div class="header">
            <span>Bolig</span>
        </div>
        <div style="padding: 10px; word-wrap: break-word; margin-top: -15px; white-space: pre-line;" class="textbox">
            Det finnes for tiden 4 forskjellige boliger; skur, enebolig, sveitservilla og villa. For å unngå å bli ranet for penger må du ha Sveitservilla eller villa. Sveitservilla og Villa er de 2 eneste boligene hvor du kan ha bunker. For å kunne bygge en bunker må du ha bunkertillatelse fra politiet.
        </div>
        <div class="header">
            <span>Kulefabrikk</span>
        </div>
        <div style="padding: 10px; word-wrap: break-word; margin-top: -15px; white-space: pre-line;" class="textbox">
            Det å opprette en kulefabrikk koster 100 000 000kr, man kan også kjøpe kulefabrikk fra andre spillere via fynn.no. Om man eier en kulefabrikk kan man produsere kuler og velge pris på kuler.
        </div>
        <div class="header">
            <span>Crypto farm</span>
        </div>
        <div style="padding: 10px; word-wrap: break-word; margin-top: -15px; white-space: pre-line;" class="textbox">
            Crypto farm er ett firma hvor man kan tjene penger hver time. Jo mer du oppgraderer desto mer penger får du hver time. Pengene må hentes ut rett over hel og du får pengene på hånden. Max rigg varierer for hvilken farm du har. Mattestykket for hvor mye penger du får ut pr time er: rigg * 500 * gpu_max. Har du 2gpu får du 2x, har du 4gpu får du 4x og 8gpu gir 8x.
            Eks. Har du Gård så har du en max rigg på 500, har du da 500 i riggen. Har du 4gpu så er mattestykket: 500 * 500 * 4 = 1 000 000. Da får du 1 000 000 pr time.
        </div>
        <div class="header">
            <span>Roller</span>
        </div>
        <div style="padding: 10px; word-wrap: break-word; margin-top: -15px; white-space: pre-line;" class="textbox">
            På spillet er det 3 forskjellige roller; Investor, Mafioso og Torpedo. Velger du Investor så får du 10% rabatt på alt som kan kjøpes i spillet. Velger du Mafioso så får du 10% mer exp på alt av handlinger. Velger du Torpedo så trengs det 10% mindre kuler ved drap. Tips: Bruk en torpedo til å drepe for deg, så sparer du penger, kuler og torpedoen får godt med exp.
        </div>
        <div class="header">
            <span>Ranker</span>
        </div>
        <div style="padding: 10px; word-wrap: break-word; margin-top: -15px; white-space: pre-line;" class="textbox"><br>Hold over rankbaren for å se antall EXP du har.
        </div>
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
        <div class="header">
            <span>Pengeranker</span>
        </div>
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
        <div class="header">
            <span>Biler</span>
        </div>
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

        <div class="header">
            <span>Drap</span>
        </div>
        <center>
            <p>Tallet er oppgitt i EXP pr kule. Torpedo trenger 10% mindre kuler.</p><br>
            F.eks: Har en bruker 100 000 exp og du har grenade launcher er mattestykket:<br>
            <b>100 000 / 750 = antall kuler</b> som kreves for å drepe spilleren.
        </center>
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
        </table>
        <?php
        /*
		'~\[center\](.*?)\[/center\]~s',
		'~\[b\](.*?)\[/b\]~s',
		'~\[i\](.*?)\[/i\]~s',
		'~\[u\](.*?)\[/u\]~s',
		'~\[quote\](.*?)\[/quote\]~s',
		'~\[size=(.*?)\](.*?)\[/size\]~s',
		'~\[color=(.*?)\](.*?)\[/color\]~s',
		'~\[url=((?:ftp|https?)://.*?)\](.*?)\[/url\]~s',
		'~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s',
        '~\[size1\](.*?)\[/size\]~s',
        '~\[size2\](.*?)\[/size\]~s',
        '~\[quote=(.*?)\](.*?)\[/quote\]~s'
        
        */
        ?>
        <div class="header">
            <span>BB-koder</span>
        </div>
        <center>
            <p>Disse bb-kodene funker på forum, profilen og familieprofilen.</p>
        </center>
        <table border="0" cellspacing="0" cellpadding="0">
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
        </table>

    </div>
    <br>
</body>

</html>
<?php 

}

?>