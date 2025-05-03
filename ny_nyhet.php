<?php if($account_type >= 2){ ?>
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Admin » </span><span style="color: #afafaf;">Opprett nyhet</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <?php 
    
            if(isset($_POST['submit'])){
                $title =    $_POST['title'];
                $text =     $_POST['text'];
                
                $text =     addslashes($text);
                $title =    addslashes($title);

                $query = "INSERT into `news` (title, description, date)
                VALUES ('$title', '$text', '".time()."')";
                $result = mysqli_query($con, $query);
                
                header("Location: index.php");

            }
    
            ?>
            <div class="header">
                <span>Opprett ny nyhet</span>
            </div>
            <form method="post">
                <div class="pad_10">
                    <span><span style="color: #009fe3;">* </span>Tittel</span><br>
                    <textarea name="title" rows="1" cols="67" wrap="nowrap" required></textarea>
                    <br><br>
                    <span><span style="color: #009fe3;">* </span>Tekst</span><br>
                    <textarea name="text" rows="10" cols="67" required></textarea>
                    <p><span style="color: #009fe3;">* </span> Obligatoriske felt</p>
                    <input style="margin: 0; width: auto;" type="submit" name="submit" value="Publiser nyhet">
                </div>
            </form>
        </div>
    </body>
</html>
<?php 

} else { 
    include("nyheter.php");
}

?>
