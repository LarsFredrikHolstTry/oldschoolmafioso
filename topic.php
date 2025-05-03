
<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else { 
    
    if(isset($_GET['topic'])){
        $topic = $_GET['topic'];
        
        $check_topic = mysqli_query($con, "SELECT ID FROM forum WHERE ID = '$topic'");

        if(mysqli_num_rows($check_topic) > 0) {
            
        $sql = "SELECT * FROM forum WHERE ID='".$topic."'";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row = mysqli_fetch_assoc($query);

        $ID_forum =             $row['ID'];
        $status =               $row['status'];
        $cat =                  $row['cat'];
        $title_forum =          $row['title'];
        $content =              $row['content'];
        $date =                 $row['date'];
        $acc_id =               $row['acc_id'];

        $title[0] = "Arkiv";
        $title[1] = "Generelt";
        $title[2] = "Salg / Søknad";
        $title[3] = "Off-topic";
        $title[4] = "Konkurranser";
        
        if(isset($_POST['submit'])){
            $respons = $_POST['respons'];
            
            //We protect the variables
            $respons = addslashes($respons);

            if($oppdrag == 9 && $city == 1){
                $result = "UPDATE oppdrag SET value = ($value + 1) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }
            
            $respons = mysqli_real_escape_string($con, nl2br(htmlentities($respons, ENT_QUOTES, 'UTF-8')));
            $respons = preg_replace('#<br\s*/?>#', "", $respons);
            strip_tags($respons);
            
            $query = "INSERT into `forum` (topic_id, cat, title, content, date, acc_id)
            VALUES ('$ID_forum', '$cat', '$title_forum', '$respons', '".time()."', '$ID')";
            $result = mysqli_query($con, $query);
            
            $sql = "UPDATE forum SET last_reply ='".time()."' WHERE ID='".$ID_forum."' LIMIT 1";
            mysqli_query($con, $sql);
            
            header("Location: index.php?side=topic&topic=$ID_forum");
            
        }
        
        if(isset($_GET['delete'])){
            if($account_type > 0){
                $delete_id = $_GET['delete'];
                
                $del = mysqli_query($con, "DELETE FROM forum WHERE ID = '".$delete_id."'") or die(mysqli_error()); 
                
                
            } else {
                echo '<div class="feedback feilmelding">
                    <span><b>Feilmelding!</b> Ugyldig handling!</span> 
                </div>';
            }
        }
        
        if(isset($_GET['delete_topic'])){
            if($account_type > 0){
                $delete_topic = $_GET['delete_topic'];
                
                $del = mysqli_query($con, "DELETE FROM forum WHERE ID = '".$delete_topic."'") or die(mysqli_error()); 
                $del = mysqli_query($con, "DELETE FROM forum WHERE topic_ID = '".$delete_topic."'") or die(mysqli_error()); 

                header("Location: index.php?side=forum&cat=$cat");
                
            } else {
                echo '<div class="feedback feilmelding">
                    <span><b>Feilmelding!</b> Ugyldig handling!</span> 
                </div>';
            }
        }
            
?>

<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Forum » <?php echo $title[$cat] ?> » </span><span style="color: #afafaf;"><?php echo $truncated = (strlen($title_forum) > 20) ? substr($title_forum, 0, 25) . '...' : $title_forum ; ?></span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <div class="header">
                <span><?php if($status == 1){ echo "<t style='color: red;'>[STENGT] </t>"; } echo $title_forum ?></span>
            </div>
            
            <div style="padding: 5px 0px;" class="forum_post">
                <div class="forum_ts">
                    <div class="forum_name">
                        <?php fetch_nick($acc_id, $con); ?>
                    </div>
                    <div class="forum_name">
                        <?php echo forum_avatar($acc_id, $con); ?>
                    </div>
                </div>
                <div class="forum_content">
                    <span style="color: #3e3e3e;">                
                        Opprettet: 
                        <?php
                    echo " "; echo date('d', $date);
                    echo ". "; echo $month[date('n', $date)];
                    echo " - "; echo date('H:i', $date);
                        ?>
                    
                    </span>
                    <?php if($account_type > 0){ ?>
                    <span style="color: #3e3e3e; float:right; margin-right: 10px;"><a onclick="return confirm('Er du sikker på at du ønsker å slette hele topicen? Dette kan ikke angres!');" href="?side=topic&topic=<?php echo $topic ?>&delete_topic=<?php echo $ID_forum ?>"><i style="font-size: 14px;" class="fas fa-trash-alt" aria-hidden="true"></i></a></span>
                    <?php } ?>
                    <div style="word-wrap: break-word; margin-top: -15px; margin-bottom: 15px; white-space: pre-line;">
                    <p style="margin: 0; padding: 0 5px 0 0;">
                <?php 
        
                    $htmltext = showBBcodes($content);

                    echo $htmltext 
                    
                ?>
                        </p></div>
                </div>
            </div>
        </div>
        <?php
                        
        $check_topic = mysqli_query($con, "SELECT ID FROM forum WHERE ID = '$topic'");

        if(mysqli_num_rows($check_topic) > 0) {
                        
                if(isset($_GET['pageno'])) {
                    $pageno = $_GET['pageno'];
                } else {
                    $pageno = 1;
                }
            
                $no_of_records_per_page = 10;
                $offset = ($pageno-1) * $no_of_records_per_page; 

                $total_pages_sql = "SELECT COUNT(*) FROM forum WHERE topic_id='$ID_forum'";
                $result = mysqli_query($con, $total_pages_sql);
                $total_rows = mysqli_fetch_array($result)[0];
                $total_pages = ceil($total_rows / $no_of_records_per_page);

                $result_forum = mysqli_query($con, "SELECT * FROM forum WHERE topic_id=$ID_forum ORDER BY date ASC LIMIT $offset, $no_of_records_per_page");
            
                $check_this_topic = mysqli_query($con, "SELECT * FROM forum WHERE topic_id=$ID_forum");

            
            if(mysqli_num_rows($check_this_topic) > 0){
                while($row_forum = mysqli_fetch_assoc($result_forum)) {
                    
                    $id_forum =             $row_forum['ID'];
                    $cat_forum =            $row_forum['cat'];
                    $title_forum =          $row_forum['title'];
                    $content_forum =        $row_forum['content'];
                    $date_forum =           $row_forum['date'];
                    $acc_id_forum =         $row_forum['acc_id'];
        
        ?>
        <div class="content" style="border-top: 0; padding: 5px 0px;">
            <div class="forum_post">
                <div class="forum_ts">
                    <div class="forum_name">
                        <?php fetch_nick($acc_id_forum, $con); ?>
                    </div>
                    <div class="forum_name">
                        <?php echo forum_avatar($acc_id_forum, $con); ?>
                    </div>
                </div>
                <div class="forum_content" style="word-wrap: break-word;">
                    <span style="color: #3e3e3e;">     
                        Postet: 
                        <?php
                    echo " "; echo date('d', $date_forum);
                    echo ". "; echo $month[date('n', $date_forum)];
                    echo " - "; echo date('H:i', $date_forum);
                        ?>
                    </span>
                    <?php if($account_type > 0){ ?>
                    <span style="color: #3e3e3e; float:right; margin-right: 10px;"><a onclick="return confirm('Er du sikker på at du ønsker å slette dette svaret?');" href="?side=topic&topic=<?php echo $topic ?>&delete=<?php echo $id_forum ?>"><i style="font-size: 14px;" class="fa fa-trash" aria-hidden="true"></i></a></span>
                    <?php } ?>
                    
                    <p style="word-wrap: break-word; margin-top: -3px; white-space: pre-line; padding-right: 10px;">
                    <?php 

                        $htmltext = showBBcodes($content_forum);

                        echo $htmltext 

                    ?>
                    </p>
                </div>
            </div>
        </div>
        <?php } } }
        
        if($status == 0){ ?>
        <div style="margin-top: 4px" class="content">
            <form method="post">
                <div class="pad_10">
                    <textarea class="example-default-value" name="respons" rows="5" cols="67" id="txtarea" wrap="nowrap" required></textarea>
                    <input style="width: auto; margin: 0;" type="submit" name="submit" value="Svar"><span id="btn" style="float: right;">Hvordan sitere</span>
                </div>
            </form>
        </div>
        <?php } else { } 
            
        $check_topic = mysqli_query($con, "SELECT ID FROM forum WHERE ID = '$topic'");

        if(mysqli_num_rows($check_topic) > 0) {
        
        if($total_pages <= 1) { } else { ?>
        
<div style="margin-top: 4px" class="content">
    <div class="pad_5 pagination">
        <div style="width: 20%; float: left;">
            <span><a href="index.php?side=topic&topic=<?php echo $topic ?>&pageno=1">«« Første side</a></span>
        </div>
        <div style="width: 20%; float: left;">
        <span class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "index.php?side=topic&topic=".$topic."&pageno=".($pageno - 1); } ?>">« Forrige side</a>
        </span>
        </div>
        <div style="width: 20%; float: left;">
        <span style="text-align: center;">Side <?php echo $pageno ?></span>
        </div>
        <div style="width: 20%; float: left;">
        <span class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a style="float: right;" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "index.php?side=topic&topic=".$topic."&pageno=".($pageno + 1); } ?>">Neste side »</a>
        </span>
        </div>
        <div style="width: 20%; float: left;">
        <span><a style="float: right;" href="index.php?side=topic&topic=<?php echo $topic ?>&pageno=<?php echo $total_pages; ?>">Siste side »»</a></span>
        </div>
    </div>
</div>
        <?php } ?>
        <div style="margin-top: 4px; display:none;" id="wizard" class="content">
            <div class="pad_10">
                <p>For å sitere så bruker du denne BB-koden: <span class="crumb">[quote=NICK]TEKST[/quote]</span> Denne BB-koden vil vises slik:<br></p>
                <div class="quote pad_10 mar_5" style="margin-bottom: 10px">
                    <span style="color:#5e5e5e">Sitat av NICK</span><br><br>
                    <span>TEKST</span>
                </div>
                <span>Husk å endre NICK til den brukeren du vil sitere og TEKST til hva brukeren har sagt.</span>
                <p><span style="color: #009fe3;">! </span>Husk at retusjering av sitater vil bli slettet uten varsel!</p>

            </div>
        </div>
<br>
    </body>
</html>
<?php 
    } } else {
?>

    <div class="feedback feilmelding">
        <span><b>Feilmelding!</b> Har du tullet med linken nå?</span> 
    </div>

<?php
        
    }
    } else {
        
    }
}

?>

<script>

 $('#btn').click(function() {
     $('#wizard').toggle(); 
 });

</script>

<style>
    .forum_ts {
        float: left;
        width: 25%;
    }
    
    .forum_ts + .forum_content {
        height: auto;
    }
    
    .forum_content {
        float: right;
        width: 75%;
    }
    
    .forum_name {
        text-align: center;
    }
    
    .respond {
        margin: 0;
        padding: 3px;
    }
    
    .quote {
        background-color: #2b2b2b;
        width: 350px;
        border-radius: 2px;
        height: auto;
    }
    
    #btn:hover {
        text-decoration: underline;
        cursor:pointer;
    }
    
    .crumb {
        background-color: #2b2b2b;
        padding: 5px;
        border-radius: 2px;
    }
</style>

