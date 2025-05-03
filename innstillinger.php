<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else { 

?>
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Sosialt » </span><span style="color: #afafaf;">innstillinger</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
            
            <?php 
            
            if(isset($_POST['update_profile'])){
                $profile_text = $_POST['profile_text'];
                
                $profile_text = mysqli_real_escape_string($con, nl2br(htmlentities($profile_text, ENT_QUOTES, 'UTF-8')));
                
                $result = "UPDATE accounts SET profile = '".strip_tags($profile_text)."' WHERE ID='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
                
                header("Location: index.php?side=innstillinger&action=1");
            }

        if(isset($_POST['update_avatar'])){

            $name = $_FILES['file']['name'];
            $target_dir = "img/avatar/";
            $target_file = $target_dir . time() . "-" . basename($_FILES["file"]["name"]);

            // Select file type
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Valid file extensions
            $extensions_arr = array("jpg","jpeg","png","gif");

            // Check extension
            if( in_array($imageFileType,$extensions_arr) ){

                // Insert record
                $result = "UPDATE accounts SET avatar = '".$target_file."' WHERE ID='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");

                // Upload file
                move_uploaded_file($_FILES['file']['tmp_name'],$target_dir. time() . "-" .$name);

            }
        }
        
            if(isset($_GET['action'])){
                $action = $_GET['action'];

                if($action == 1){ 
                    echo '<div class="feedback velykket">
                        <span>Profilen ble oppdatert!</span> 
                    </div>';
                } elseif($action == 2){
                    echo '<div class="feedback velykket">
                        <span>Avataret ble oppdatert!</span> 
                    </div>';
                } elseif($action == 3){
                    echo '<div class="feedback velykket">
                        <span>Innstillingene ble lagret!</span> 
                    </div>';
                }
            }


            ?>

        <div class="content">
            <div class="tab">
              <button style="width: 33%;" class="tablinks pad_10" onclick="openTab(event, 'profile')"  id="defaultOpen">Rediger profil</button>
              <button style="width: 33%;" class="tablinks pad_10" onclick="openTab(event, 'avatar')">Rediger avatar</button>
              <button style="width: 34%;" class="tablinks pad_10" onclick="openTab(event, 'header')">Stil</button>

            </div>

            <div id="profile" class="tabcontent pad_10">
                <form action="" method="post">
                    <textarea name="profile_text" style="color: #e7e4de;" id="txtarea" rows="25" cols="67" ><?php echo $profile ?></textarea>
                    <input style="width: auto; margin: 0 auto;" type="submit" name="update_profile" value="Oppdater profil">
                </form>
            </div>

            <div id="avatar" class="tabcontent pad_10">
                <span>Anbefalt størrelse: 240x200px</span>
              <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="size" value="1000000">
                <div>
                  <input style="float:left;" type="file" name="file">
                </div>
                <div>
                    <input style="width: auto;" type="submit" name="update_avatar" value="last opp avatar">
                </div>
              </form>
            </div>
            
            <div id="header" class="tabcontent pad_10">
                <?php 
                
                $header_creator[0] = "Mafioso";
                $header_link[0] = '<img style="width: 100%;" src="img/community_header/mafioso_1.png">';
    
                $header_creator[1] = "Mafioso";
                $header_link[1] = '<img style="width: 100%;" src="img/community_header/mafioso_2.png">';

                $header_creator[2] = "Famous";
                $header_link[2] = '<img style="width: 100%;" src="img/community_header/savior.png">';
    
                $header_creator[3] = "Sleep";
                $header_link[3] = '<img style="width: 100%;" src="img/community_header/sleep.png">';
    
                $header_creator[4] = "Mafioso";
                $header_link[4] = '<img style="width: 100%;" src="img/community_header/mafioso_3.png">';

                if(isset($_GET['change_header'])){
                    $legal = array(0, 1, 2, 3, 4);
                    if(in_array($_GET['change_header'], $legal)){
                        $result = "UPDATE accounts SET header = '".$_GET['change_header']."' WHERE ID='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        header("Location: index.php?side=innstillinger");
                    } else {
                        echo '<div class="feedback mislykket">
                            <span>Ugyldig verdi</span> 
                        </div>';
                    }
                }

                ?>
                <p>Her kan du velge hvilken header du ønsker på din stil. Trykk på headeren du ønsker å endre til.</p>
                
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th style="width: 10%; padding-left: 15px;"></th>
                        <th style="width: 90%;"></th>
                    </tr>
                    <?php for($i = 0; $i < count($header_creator); $i++){ ?>
                        <tr style="height: 25px;">
                            <td style="padding-left: 15px;"><?php echo $header_creator[$i] ?></td>
                            <td><a href="index.php?side=innstillinger&change_header=<?php echo $i ?>"><?php echo $header_link[$i] ?></a></td>
                        </tr>
                    <?php } ?>
                </table>
                
                <?php 
                
                if(isset($_POST['design'])){
                    $legal = array(0, 1, 2, 3, 4, 5, 6);
                    if(in_array($_POST['design'], $legal)){
                        $result = "UPDATE accounts SET design = '".$_POST['design']."' WHERE ID='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        header("Location: index.php?side=innstillinger");
                    } else {
                        echo '<div class="feedback mislykket">
                            <span>Ugyldig verdi</span> 
                        </div>';
                    }
                }
                
                ?>
                
            <div class="pad_10">Velg stil
                <form method="post">
                    <select style="width: 20%;" name="design" onchange="this.form.submit()">
                        <option >Velg</option>
                        <option value="0">Original</option>
                        <option value="1">Simplicity</option>
                        <option value="2">Blue</option>
                        <option value="3">Red</option>
                        <option value="4">Ingen bilder</option>
                        <option value="5">Lightmode BETA</option>
                        <option value="6">Superdarkmode with blue</option>

                    </select>
                </form>
                </div>
                <?php 
                
                if(isset($_POST['act_bar_change'])){
                    $legal = array(0, 1);
                    if(in_array($_POST['act_bar_change'], $legal)){

                        $result = "UPDATE accounts SET action_bar = '".$_POST['act_bar_change']."' WHERE ID='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        header("Location: index.php?side=innstillinger");
                        
                    } else {
                        echo '<div class="feedback mislykket">
                            <span>Ugyldig verdi</span> 
                        </div>';                    
                    }
                }
                
                ?>
                
            <div class="pad_10">Velg handling meny
                <form method="post">
                    <select style="width: 20%;" name="act_bar_change" onchange="this.form.submit()">
                        <option >Velg</option>
                        <option value="0">Topp</option>
                        <option value="1">Venstre</option>
                    </select>
                </form>
                </div>
                <!--
                <div class="pad_10">Velg bakgrunn (legg til en link med bilde du vil ha som bakgrunn, linken må slutte på .png, .jpg eller .gif)</div>
                <form method="post">
                    <input type="text" name="background_image" style="width: 70%;"><input name="update_background" type="submit" style="width: 20%;">
                </form>
            -->
            </div>
            
        </div>
    </body>
</html>
<?php } ?>
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
