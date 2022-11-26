<br>
    <div class="page-hero d-flex align-items-center justify-content-center">
            <form action="" method="POST" accept-charset="UTF-8">
                <span id = "alertText"></span>
                <h1>Kérdés hozzáadása</h1>
                <br>
                <div class="form-group">
                    <label for="nev">Kérdés: </label>
                    <input type="text" class="form-control" name="nev" id="nev" maxlength="45"/> <br/>
                </div>
                <div class="form-group">
                    <label for="answ1">Válasz érték 1 : </label>
                    <input type="text" class="form-control" name="answ1" id="answ1"/> <br/>
                </div>
                <div class="form-group">
                    <label for="answ2">Válasz érték 2 : </label>
                    <input type="text" class="form-control" name="answ2" id="answ2"/> <br/>
                </div>
                <div class="form-group">
                    <label for="answ3">Válasz érték 3 : </label>
                    <input type="text" class="form-control" name="answ3" id="answ3"/> <br/>
                </div>
                <button id="submit" type="submit" name="submit" class="btn btn-primary btn-lg btn-block">Mentés </button>
            </form>
        </div>

        <?php 


if(isset($_POST["submit"]))
{
    if($_POST["nev"] == null) {
        ?>
        <script>
                Swal.fire(
                    'Hiba!',
                    'Nem gépelte be a kérdést!',
                    'warning'
                )
            </script>
        <?php
    }
    else if(is_numeric($_POST["nev"])) {
        ?>
        <script>
            Swal.fire(
                'Hiba!',
                'A kérdés egy szöveg!',
                'warning'
            )
        </script>
        <?php
    }
    else if(strlen($_POST["nev"]) > 45){
        ?>
        <script>
                Swal.fire(
                    'Hiba!',
                    'A beírt kérdés több mint 45 karakter!',
                    'warning'
                )
            </script>
        <?php
    }
    else if($_POST["answ1"] == null) {
        ?>
        <script>
                Swal.fire(
                    'Hiba!',
                    'Nem adott értéket az egyes számú opciónak!',
                    'warning'
                )
            </script>
        <?php
        
    }
    else if(!is_numeric($_POST["answ1"]) or strpos($_POST["answ1"],".")) {
        ?>
        <script>
                Swal.fire(
                    'Hiba!',
                    'Az egyes számú opció egy egész szám!',
                    'warning'
                )
            </script>
        <?php
        
    }
    
    else if($_POST["answ2"] == null) {
        ?>
        <script>
                Swal.fire(
                    'Hiba!',
                    'Nem adott értéket a kettes számú opciónak!',
                    'warning'
                )
            </script>
        <?php
        
    }

    else if(!is_numeric($_POST["answ2"]) or strpos($_POST["answ2"],".")) {
        ?>
        <script>
                Swal.fire(
                    'Hiba!',
                    'A kettes számú opció egy egész szám!',
                    'warning'
                )
            </script>
        <?php
        
    }

    else if($_POST["answ3"] == null) {
        ?>
        <script>
                Swal.fire(
                    'Hiba!',
                    'Nem adott értéket a hármas számú opciónak!',
                    'warning'
                )
            </script>
        <?php
        
    }

    else if(!is_numeric($_POST["answ3"]) or strpos($_POST["answ3"],".")) {
        ?>
        <script>
                Swal.fire(
                    'Hiba!',
                    'A hármas számú opció egy egész szám!',
                    'warning'
                )
            </script>
        <?php
        
    }

    else{
        $question = $_POST["nev"];
        $answer1 = $_POST["answ1"];
        $answer2 = $_POST["answ2"];
        $answer3 = $_POST["answ3"];

        $add_question_query = "INSERT INTO questions(question, answer1, answer2, answer3) 
            VALUES('".$question."','".$answer1."','".$answer2."','".$answer3."')";
        executeQuery($add_question_query);
        ?>
        <script>
                    Swal.fire({
                    icon: 'success',
                    title: 'Kérdés sikeresen hozzáadva a rendszerhez!',
                    showConfirmButton: false,
                    timer: 1500
                    })
                    window.setTimeout(function() {
                    window.location.href = 'index.php?P=addNewQuestion';
                    }, 1500);
                </script>
                <?php
    }
}
?>       