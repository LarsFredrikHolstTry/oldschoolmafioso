<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else {
    
$cat = $_GET['cat'];
    
$title[0] = "Arkiv";
$title[1] = "Generelt";
$title[2] = "Salg / Søknad";
$title[3] = "Off-topic";
$title[4] = "Konkurranser";

$breadcrumb[0] = '<span style="color: #3e3e3e;">Forum » </span><span style="color: #afafaf;">Arkiv</span>';
$breadcrumb[1] = '<span style="color: #3e3e3e;">Forum » </span><span style="color: #afafaf;">Generelt</span>';
$breadcrumb[2] = '<span style="color: #3e3e3e;">Forum » </span><span style="color: #afafaf;">Salg / Søknad</span>';
$breadcrumb[3] = '<span style="color: #3e3e3e;">Forum » </span><span style="color: #afafaf;">Off-topic</span>';
$breadcrumb[4] = '<span style="color: #3e3e3e;">Forum » </span><span style="color: #afafaf;">Konkurranser</span>';

?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <?php echo $breadcrumb[$cat] ?>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content" style="padding-bottom: 0px;">
            <div class="header">
                <span><?php echo $title[$cat] ?> (<a href="?side=new_topic&cat=<?php echo $cat ?>">Ny post</a>)</span>
            </div>
                <?php
                
                $i = 0;

                if (isset($_GET['pageno'])) {
                    $pageno = $_GET['pageno'];
                } else {
                    $pageno = 1;
                }

                $no_of_records_per_page = 10;
                $offset = ($pageno-1) * $no_of_records_per_page; 

                $total_pages_sql = "SELECT COUNT(*) FROM forum WHERE cat='".$_GET['cat']."' AND topic_id = 0";
                $result = mysqli_query($con, $total_pages_sql);
                $total_rows = mysqli_fetch_array($result)[0];
                $total_pages = ceil($total_rows / $no_of_records_per_page);

                $result_forum = mysqli_query($con, "SELECT * FROM forum WHERE cat='".$_GET['cat']."' AND topic_id = 0 
                ORDER BY last_reply DESC LIMIT $offset, $no_of_records_per_page");
                while($row_forum = mysqli_fetch_assoc($result_forum)) {
                    
                    $id_forum =             $row_forum['ID'];
                    $cat_forum =            $row_forum['cat'];
                    $title_forum =          $row_forum['title'];
                    $content_forum =        $row_forum['content'];
                    $date_forum =           $row_forum['date'];
                    $acc_id_forum =         $row_forum['acc_id'];
                    $last_reply_forum =     $row_forum['last_reply'];
                    
                    $sql = "SELECT * FROM forum WHERE date='".$last_reply_forum."'";
                    $query = mysqli_query($con, $sql) or die (mysqli_error());
                    $row = mysqli_fetch_assoc($query);

                    $last_reply_id = $row['acc_id'];
                    
                $no_of_records_per_page_topic = 10;
                $total_pages_sql_topic = "SELECT COUNT(*) FROM forum WHERE topic_id = $id_forum";
                $result_topic = mysqli_query($con, $total_pages_sql_topic);
                $total_rows_topic = mysqli_fetch_array($result_topic)[0];
                $total_pages_topic = ceil($total_rows_topic / $no_of_records_per_page_topic);


                    $i++;
    
                    
                ?>
            <div class="forum_post pad_5" style="color: #4e4e4e; font-size: 10px !important;">
                <a style="font-size:12px" class="forum_title" href="?side=topic&topic=<?php echo $id_forum ?>&pageno=<?php echo $total_pages_topic; ?>"><?php echo $title_forum ?></a><br>
                <span style="font-size: 10px;">Av: <a href="index.php?side=profil&bruker=<?php echo $acc_id_forum ?>"><?php echo fetch_nick($acc_id_forum, $con) ?></a> - 
                <?php
                    echo " "; echo date('d', $date_forum);
                    echo ". "; echo $month_short[date('n', $date_forum)];
                    echo ". kl "; echo date('H:i', $date_forum);
                        ?>
                </span>
                <?php 
                    if($last_reply_forum == $date_forum) {
                        echo ' - Ingen svar'; 
                    } else { echo " - Sist svar: ";
                        echo fetch_nick($last_reply_id, $con);
                        echo " - "; echo date('d', $last_reply_forum);
                        echo ". "; echo $month_short[date('n', $last_reply_forum)];
                        echo ". kl "; echo date('H:i', $last_reply_forum);
                    }?>
            </div>
                <?php 
                    
                }
            ?>
            
        </div>
    <?php
    
    if($total_pages <= 0) { } else { ?>
    <div style="margin-top: 4px; border-bottom: 1px solid #2c2c2c;" class="content">
        <div class="pad_5 pagination">
            <div style="width: 20%; float: left;">
                <span><a href="index.php?side=forum&cat=<?php echo $_GET['cat'] ?>">«« Første side</a></span>
            </div>
            <div style="width: 20%; float: left;">
                <span class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                    <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "index.php?side=forum&cat=".$_GET['cat']."&pageno=".($pageno - 1); } ?>">« Forrige side</a>
                </span>
            </div>
            <div style="width: 20%; float: left;">
                <span style="text-align: center;">Side <?php echo $pageno ?></span>
            </div>
            <div style="width: 20%; float: left;">
                <span class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                    <a style="float: right;" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "index.php?side=forum&cat=".$_GET['cat']."&pageno=".($pageno + 1); } ?>">Neste side »</a>
                </span>
            </div>
            <div style="width: 20%; float: left;">
                <span><a style="float: right;" href="index.php?side=forum&cat=<?php echo $_GET['cat'] ?>&pageno=<?php echo $total_pages; ?>">Siste side »»</a></span>
            </div>
        </div>
    </div>
    <?php } ?>
    </body>
</html>
<?php 

}

?>

<style>
    .forum_post {
        border-bottom: 1px solid #2c2c2c;
    }
    
    .content {
        border-bottom: 0px;
    }

.forum_title {
    color: #afafaf;
    text-decoration: none;
    font-size: 13px;
}
    
    .forum_title:hover {
        color: #009fe3;
    }
</style>