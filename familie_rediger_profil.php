
<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else {
    
$sql = "SELECT * FROM family_member WHERE family_id = '".$_GET['id']."' AND acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."' AND role = 1";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row_leader = mysqli_fetch_assoc($query);
    
$sql = "SELECT * FROM family WHERE ID='".$_GET['id']."'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row_fam = mysqli_fetch_assoc($query);
    
if($row_leader['acc_id'] == $ID){
    
    if(isset($_POST['update_profile'])){
        $profile = $_POST['profile_text'];
        
        $profile = mysqli_real_escape_string($con, nl2br(htmlentities($profile, ENT_QUOTES, 'UTF-8')));
        
        $result = "UPDATE family SET fam_profil = '".strip_tags($profile)."' WHERE ID='".$_GET['id']."'";
        mysqli_query($con, $result) or die("Bad query: $result");
        
        header("Location: index.php?side=familie_rediger_profil&id=".$_GET['id']."&new_profile");
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
        if(in_array($imageFileType,$extensions_arr) ){

            // Insert record
            $result = "UPDATE family SET avatar = '".$target_file."' WHERE ID='".$_GET['id']."'";
            mysqli_query($con, $result) or die("Bad query: $result");

            // Upload file
            move_uploaded_file($_FILES['file']['tmp_name'],$target_dir. time() . "-" .$name);

            header("Location: index.php?side=familie_rediger_profil&id=".$_GET['id']."&new_image");

        }
    }
    
    if(isset($_GET['new_image'])){
        echo '<div class="feedback velykket">
            <span>Familiebildet ble oppdatert.</span> 
        </div>';
    }
    
    if(isset($_GET['new_profile'])){
        echo '<div class="feedback velykket">
            <span>Profilen ble oppdatert.</span> 
        </div>';
    }
    
?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Diverse » Familie » </span><span style="color: #afafaf;">Rediger profil</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <div class="header">
                <span>Rediger familiebilde</span>
            </div>
            <div class="pad_10">
            <span>Anbefalt størrelse: 240x200px</span>
              <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="size" value="1000000">
                <div>
                  <input style="float:left; width: 250px;" type="file" name="file">
                </div>
                <div>
                    <input style="width: auto; margin-top: 4px;" type="submit" name="update_avatar" value="last opp avatar">
                </div>
              </form>
            </div>
        </div>
        <div class="content" style="border-top: none;"> 
            <div class="header">
                <span>Rediger familieprofil</span>
            </div>
            <div class="pad_10">
            <form action="" method="post">
                <textarea name="profile_text" style="color: #e7e4de;" id="txtarea" rows="15" cols="67"><?php echo $row_fam['fam_profil']; ?></textarea>
                <input style="width: auto; margin: 0 auto;" type="submit" name="update_profile" value="Oppdater profil">
            </form>
            </div>
        </div>
    </body>
</html>
<?php 

    } else {
        echo '<div class="feedback mislykket">
            <span>Det er kun familie-lederen som har tilgang til å redigere familieprofilen.</span> 
        </div>';
    }
}

?>