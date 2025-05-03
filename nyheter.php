<html>
    <head>
    </head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Diverse » </span><span style="color: #afafaf;">Nyheter</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <div style="float: left; width: 50%;">
                <div class="header">
                    <span>Nyheter <?php if($account_type == 2){ ?>(<a href="?adminside=nyhet">Ny post</a>)<?php } ?></span>
                </div>
                <div style=" overflow: auto; height: 400px;">
            <?php
                $result_news = mysqli_query($con, "SELECT * FROM news ORDER BY date DESC LIMIT 10");
                while($row_news = mysqli_fetch_assoc($result_news)) {
                    
                    $title = $row_news['title'];
                    $description = $row_news['description'];
                    $date = $row_news['date'];
                                            
                ?>
            
                <div style="padding: 10px; word-wrap: break-word; margin-top: -15px; white-space: pre-line;" class="textbox">
                    <b><?php echo $title ?></b>
                    <p style="padding-bottom: 0; margin-bottom: 0;"><?php echo showBBcodes($description); ?></p>
                    <t style="color: #3e3e3e;"><?php 
                    echo $days[date('N', $date)]; 
                    echo " "; echo date('d', $date);
                    echo ". "; echo $month[date('n', $date)];
                    echo " - kl "; echo date('H:i', $date);
                        ?></t>
                </div>
                <?php  } ?>
                </div>
            </div>
            
            <div style="float: left; width: 50%;">
            <div class="header">
                <span>Siste hendelser</span>
            </div>
            <div style=" overflow: auto; height: 400px;">

            <?php
                $result_news = mysqli_query($con, "SELECT * FROM last_events ORDER BY time DESC LIMIT 20");
                while($row_news = mysqli_fetch_assoc($result_news)) {
                    
                    $acc_id = $row_news['acc_id'];
                    $event = $row_news['event'];
                    $time = $row_news['time'];

                    $word_kill = "drept";       
                    $word_rank = "ranket";
                    $word_fami = "Familien";
                    
                ?>
            
                <div style="padding: 10px; word-wrap: break-word;" class="textbox">
                    <span>
                    <?php if(strpos($event, $word_kill) !== false){ ?>
                        <i style="color: #882425;" class="fas fa-user-alt-slash"></i>
                    <?php } elseif(strpos($event, $word_rank) !== false){ ?>
                        <i style="color: #8bce8c;" class="fas fa-arrow-up"></i>
                    <?php } elseif(strpos($event, $word_fami) !== false){ ?>
                        <i style="color: #3851d0;" class="fas fa-users"></i>
                    <?php } ?>

                        <?php if($acc_id != null){ echo fetch_nick_quote($acc_id, $con); } ?> <?php echo $event; ?></span><br>
                    <t style="color: #3e3e3e;"><?php 
                    echo " "; echo date('d', $time);
                    echo ". "; echo $month[date('n', $time)];
                    echo " - kl "; echo date('H:i', $time);
                    ?></t>
                </div>
                <?php  } ?>
                </div>
            </div>
            
        </div>
    </body>
</html>