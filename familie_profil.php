
<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else { 
    
    if(!isset($_GET['id'])){
        header("Location: index.php");
    } else {
        
        $sql = "SELECT * FROM family WHERE ID='".$_GET['id']."'";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row_fam = mysqli_fetch_assoc($query);
        
        $name =             $row_fam['name'];
        $stat =             $row_fam['status'];
        $avatar =           $row_fam['avatar'];
        $war_won =          $row_fam['war_won'];
        $fam_profil =       $row_fam['fam_profil'];

        $sql = "SELECT * FROM family_member WHERE family_id='".$_GET['id']."' AND role = 1";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row_fam_godfather = mysqli_fetch_assoc($query);
        
        $acc_id =         $row_fam_godfather['acc_id'];
        

        $sql = "SELECT * FROM family_member WHERE family_id='".$_GET['id']."' AND role = 2";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row_fam_godfather = mysqli_fetch_assoc($query);
        
        $acc_id_oko =         $row_fam_godfather['acc_id'];
        
        $i = 0;
    $result_members = mysqli_query($con, "SELECT * FROM family_member WHERE family_id='".$_GET['id']."'");
    while($row_members = mysqli_fetch_assoc($result_members)) {
        $i++;
    }


?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Familieprofil » </span><span style="color: #afafaf;"><?php echo $name ?></span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <div style="width: 100%; height: 220px;">
                <div class="profile_left pad_10">
                    <img src="<?php echo $avatar ?>">
                </div>
                <div class="profile_right pad_5">
                    <div style="width: 100%; height: 25px;"></div>
                    <table>
                        <tr style="background-color: #1b1b1b">
                            <td style="text-align: right;">Familienavn:</td>
                            <td><?php echo $name; ?></td>
                        </tr>
                        <tr style="background-color: #1b1b1b">
                            <td style="text-align: right;">Status:</td>
                            <td><?php echo $status[$stat] ?></td>
                        </tr>
                        <tr style="background-color: #1b1b1b">
                            <td style="text-align: right;">Gudfar:</td>
                            <td><?php echo fetch_nick($acc_id, $con); ?></td>
                        </tr>
                        <tr style="background-color: #1b1b1b">
                            <td style="text-align: right;">Økonom:</td>
                            <td><?php if($acc_id_oko == null){ echo 'Ingen'; } else { echo fetch_nick($acc_id_oko, $con); } ?></td>
                        </tr>
                        <tr style="background-color: #1b1b1b">
                            <td style="text-align: right;">Medlemmer: </td>
                            <td><a href="index.php?side=familie_medlemmer&id=<?php echo $_GET['id'] ?>"><?php echo $i; ?></a></td>
                        </tr>
                        <tr style="background-color: #1b1b1b">
                            <td style="text-align: right;">Kriger vunnet: </td>
                            <td><?php echo $war_won; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
                <div class="header header_mid">
                    <span>Familieprofil</span>
                </div>
            <div class="profiltekst pad_5">
                <div class="output" style=" word-wrap: break-word; margin-top: -15px; white-space: pre-line;">
                    <?php 

                    $htmltext = showBBcodes($fam_profil);

                    echo $htmltext 

                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
<?php 
        
    }
}

?>