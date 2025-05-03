<?php

// ▲ ▼

?>
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Diverse » </span><span style="color: #afafaf;">Daytrading</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <div class="header">
                <span>Daytrading</span>
            </div>
                <marquee>
                    <?php for($i = 0; $i < 20; $i++){ ?>
                    <span style="margin-right: 3em">BLTFQ <span style="color:green">552 ▲</span></span>
                    <span style="margin-right: 3em">MVPRD <span style="color:red">352 ▼</span></span>
                    <span style="margin-right: 3em">DLXCAR <span style="color:red">452 ▼</span></span>
                    <span style="margin-right: 3em">MAFPD <span style="color:green">652 ▲</span></span>
                    <?php } ?>
                </marquee>
            <img src="img/action/daytrading.png" style="width: 100%; height: auto;">
        </div>
    </body>
</html>
