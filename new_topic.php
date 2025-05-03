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

$breadcrumb[0] = '<span style="color: #3e3e3e;">Forum » </span><span style="color: #3e3e3e;">Arkiv » </span><span style="color: #afafaf;">Ny post</span>';
$breadcrumb[1] = '<span style="color: #3e3e3e;">Forum » </span><span style="color: #3e3e3e;">Generelt » </span><span style="color: #afafaf;">Ny post</span>';
$breadcrumb[2] = '<span style="color: #3e3e3e;">Forum » </span><span style="color: #3e3e3e;">Salg / Søknad » </span><span style="color: #afafaf;">Ny post</span>';
$breadcrumb[3] = '<span style="color: #3e3e3e;">Forum » </span><span style="color: #3e3e3e;">Off-topic » </span><span style="color: #afafaf;">Ny post</span>';
$breadcrumb[4] = '<span style="color: #3e3e3e;">Forum » </span><span style="color: #3e3e3e;">Konkurranser » </span><span style="color: #afafaf;">Ny post</span>';

?>
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <?php echo $breadcrumb[$cat] ?>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <?php
        
        if(isset($_POST['submit'])){
            $subject = $_POST['subject'];
            $text = $_POST['text'];
            
            $text = addslashes($text);

            $query = "INSERT into `forum` (cat, title, content, date, acc_id, last_reply)
            VALUES ('$cat', '$subject', '$text', '".time()."', '$ID', '".time()."')";
            $result = mysqli_query($con, $query);

            header("Location: index.php?side=forum&cat=$cat");
        }
        
        ?>
        <div class="content">
            <div class="header">
                <span>Ny post</span>
            </div>
            <form method="post">
                <div class="pad_10">
                    <span><span style="color: #009fe3;">* </span>Tittel</span><br>
                    <textarea name="subject" rows="1" cols="67" required></textarea>
                    <br><br>
                    <span><span style="color: #009fe3;">* </span>Innhold</span><br>
                    <textarea name="text" rows="10" cols="67" id="txtarea" wrap="nowrap" required></textarea>
                    <p><span style="color: #009fe3;">* </span>Obligatoriske felt.</p>
                    <p><span style="color: #009fe3;">! </span>Husk å sjekk i navigasjonen at du er i riktig kategori</p>
                    <input style="width: auto; margin: 0;" type="submit" name="submit" value="Lag post">
                </div>
            </form>
        </div>
    </body>
</html>
<?php 

}

?>

<script>

$("#submit-code").click(function() {
  $("div.output").html($("#txtarea").val().replace(/\n/g, "<br>"));
});

</script>