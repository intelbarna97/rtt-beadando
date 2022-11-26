
<HTMl>
    <HEAD>
        <link rel="stylesheet" href="<?php echo PUBLIC_DIR."login_register.css";?>">
        <link rel="stylesheet" href="../../public/style.css">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
            function alertText(id,msg,alertType)
            {
                if(alertType == "success")
                {
                document.getElementById(id).style.color = "#66CD00";
                }
                else
                {
                    document.getElementById(id).style.color = "crimson";
                }
                document.getElementById (id). innerHTML = msg;
            }
        </script>
    </HEAD>
    <BODY>
        <form method = "POST">
            <div class="simple-container">
        <h2>Regisztráció</h2>
        <span id = "alertText"></span>
        <div class="row">
            <div class="col-md-12 form-group">
                <input type="text" class="form-control" placeholder="Fehasználónév" name = "reg_username">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <input type="password" placeholder="Jelszó" class="form-control" name = "reg_password">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <input type="password" placeholder="Jelszó újra" class="form-control" name = "reg_password_again">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <input type="email" placeholder="Email" class="form-control" name = "reg_email">
            </div>
        </div>
        <div class="g-recaptcha" data-sitekey="6Ldn7pwfAAAAACw2iKHx8m9Z44PmGvO0WMI0jOSv"></div>
        <br>
        <div class="row">
            <div class="col-md-12 form-group link">
                Már van felhasználód? <a href = "index.php?P=login"><span>Kattints ide!</span><a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <input type="submit" class="btn btn-block btn-login" name = "registerBtn" value = "Regisztrálás">
            </div>
        </div>
        </div>
        </form>
    </BODY>
</HTML>
<?php

if(isset($_POST["registerBtn"]))
{
    if($_POST['g-recaptcha-response'] != "") {
        if($_POST["reg_username"] == "") {
            ?>
                <script>
                    Swal.fire(
                        'Hiba!!',
                        'A felhasználónév nem lehet üres!',
                        'warning'
                    )
                </script>
            <?php
        }
        else if($_POST["reg_password"] == "") {
            ?>
                <script>
                    Swal.fire(
                        'Hiba!!',
                        'A jelszó nem lehet üres!',
                        'warning'
                    )
                </script>
            <?php
        }
        else if($_POST["reg_password"] != $_POST["reg_password_again"]) {
            ?>
                <script>
                    Swal.fire(
                        'Hiba!!',
                        'A jelszavak nem egyeznek!',
                        'warning'
                    )
                </script>
            <?php
        }
        else if($_POST["reg_email"] == "") {
            ?>
                <script>
                    Swal.fire(
                        'Hiba!!',
                        'Az email nem lehet üres!',
                        'warning'
                    )
                </script>
            <?php
        }
        else if(strlen($_POST["reg_password"]) < 7) {
            ?>
                <script>
                    Swal.fire(
                        'Hiba!!',
                        'A jelszó legyen legalább 8 karakter!',
                        'warning'
                    )
                </script>
            <?php
        }
        else
        {
            $secret = "6Ldn7pwfAAAAACRw3JETEHv49XHprFK4_nePnRy8";
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
            $responseData = json_decode($verifyResponse);
            if ($responseData->success) {
                $uname = $_POST["reg_username"];
                $checkQuery = "SELECT * FROM users WHERE username = '".$uname."'";
                $ifNotExists = classList($checkQuery);
                if($ifNotExists === NULL || empty($ifNotExists))
                {
                    echo "<script>alertText('alertText','Sikeres regisztráció!','success')</script>";
                
                $passwd = sha1($_POST["reg_password"]);
                $email = $_POST["reg_email"];
                $registerQuery = "INSERT INTO users(username,password,email,permission) VALUES('". $uname. "', '". $passwd ."', '". $email ."', 0)";
                executeQuery($registerQuery);
                }
                else
                {
                    echo "<script>alertText('alertText','Már van ilyen felhasználónév!','error')</script>";
                }
            }
            else {
                ?>
                <script>
                    Swal.fire(
                        'Hiba!!',
                        'Hibásan oldotta meg a reCAPTCHA-t!',
                        'warning'
                    )
                </script>
    
                <?php 
            }
            
        }
    }
    else {
        ?>
        <script>
            Swal.fire(
                'Hiba!!',
                'Oldja meg a reCAPTCHA-t!',
                'warning'
            )
        </script>

        <?php 
    }
    
}
?>