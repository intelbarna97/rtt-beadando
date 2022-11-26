
<HTMl>
    <HEAD>
        <link rel="stylesheet" href="<?php echo PUBLIC_DIR."login_register.css";?>">
        <link rel="stylesheet" href="../../public/style.css">
        
        <style>
            .oDiv .oForm
            {
                padding-top: 130px;
                color: #F0F0F0;
            }
            #alertText
{
  text-align: center;
}
        </style>
    </HEAD>
    <BODY>
        
            <div class="simple-container">
            <form method = "POST">
        <h2>Bejelentkezés</h2>
        <span id = "alertText"></span>
        <div class="row">
            <div class="col-md-12 form-group">
                <input type="text" class="form-control" placeholder="Fehasználónév" name = "log_username">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <input type="password" placeholder="Jelszó" class="form-control" name = "log_password">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group link">
                Még nincs felhasználód? <a href = "index.php?P=register"><span>Kattints ide!</span><a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <input type="submit" class="btn btn-block btn-login" name = "loginBtn" value = "Belépés">
            </div>
        </div>
        </form>
        </div>
        
    </BODY>
</HTML>
<?php

if(isset($_POST["loginBtn"]))
{
    if($_POST["log_username"] == "") echo "<script>alertText('alertText','Írja be a felhasználónevet!','error')</script>";
    else if($_POST["log_password"] == "") echo "<script>alertText('alertText','Írja be a jelszót!','error')</script>";
    else
    {
        $uname = $_POST["log_username"];
        
        $checkQuery = "SELECT * FROM users WHERE username = '".$uname."'";
        $actualUser = classList($checkQuery);
        if($actualUser === NULL || empty($actualUser))
        {
            echo "<script>alertText('alertText','Nincs ilyen felhasználónév!','error')</script>";
        }
        else
        {
            $passwd = sha1($_POST["log_password"]);
            $loginQuery = "SELECT uid,username,password,email,permission FROM users WHERE username = '".$uname."' AND password = '".$passwd."'";
            $successLogin = classList($loginQuery);
            if(empty($successLogin))
            {
                echo "<script>alertText('alertText','Hibás jelszó!','error')</script>";
            }
            else
            {
                echo "<script>alertText('alertText','Sikeres bejelentkezés!','success')</script>";
                
                foreach($successLogin as $row)
                {
                    $_SESSION["uid"] = $row["uid"];
                    $_SESSION["felhasznalonev"] = $row["username"];
                    $_SESSION["jelszo"] = $row["password"];
                    $_SESSION["email"] = $row["email"];
                    $_SESSION["permission"] = $row["permission"];
                }
                echo "<script>alert('".$_SESSION['uid']." Bejelentkezett felhasználónév: ".$_SESSION['felhasznalonev']." Jelszava: ".$_SESSION['jelszo']." Email: ".$_SESSION['email']." Joga: ".$_SESSION['jog']."')</script>";
                header("location: index.php?P=home");
            }
        }
    }
}
?>