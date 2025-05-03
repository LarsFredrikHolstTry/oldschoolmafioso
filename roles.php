<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Intro » </span><span style="color: #afafaf;">Velkommen</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <?php
        
        if(isset($_POST['torpedo'])){
            $result = mysqli_query($con, "UPDATE accounts SET role ='2' WHERE ID='$ID'") or die (mysqli_error($con));
            header("Location: index.php?role=2");
            
        } elseif(isset($_POST['mafioso'])){
            $result = mysqli_query($con, "UPDATE accounts SET role ='3' WHERE ID='$ID'") or die (mysqli_error($con));
            header("Location: index.php?role=3");

        } elseif(isset($_POST['investor'])){
            $result = mysqli_query($con, "UPDATE accounts SET role ='1' WHERE ID='$ID'") or die (mysqli_error($con));
            header("Location: index.php?role=1");

        }
        
$role_benefit[1] = "10% avslag på alt";
$role_benefit[2] = "10% mindre kuler ved drap";
$role_benefit[3] = "10% mer exp";
        
        ?>
        <div class="content">
            <div class="header">
                <span>Velkommen til Mafioso!</span>
            </div>
            <p style="padding: 0px 10px;">Før du kaster deg inn i oppgavene til en ordentlig mafioso så må du velge hvilken rolle du skal ha i spillet. Dette er en handling som ikke kan angres, så tenk gjennom hva du vil spesialisere deg innen.</p>
            <form method="post">  
                <div class="role_container">
                    <button name="investor" type="submit"> 
                    <div class="role_0">
                        <div class="header">
                            <span>Investor</span>
                        </div>
                        <div class="role_footer">
                            <span style="color: green;">+</span>10% avslag på alt<br>
                        </div>
                    </div>
                    </button>
                    <button name="torpedo" type="submit"> 
                    <div class="role_1">
                        <div class="header">
                            <span>Torpedo</span>
                        </div>
                        <div class="role_footer">
                            <span style="color: green;">+</span>10% mindre kuler ved drap
                        </div>
                    </div>
                    </button>
                    <button name="mafioso" type="submit"> 
                    <div class="role_2">
                        <div class="header">
                            <span>Mafioso</span>
                        </div>
                        <div class="role_footer">
                            <span style="color: green;">+</span>10% mer exp
                        </div>
                    </div>
                    </button>
                </div>
            </form>
        </div>
    </body>
</html>
