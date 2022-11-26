<?php

if (isset($_POST["themeCreateButton"]) && isset($_POST["topicName"]) && !($_POST["topicName"] === null) && $_POST["topicName"] != "") {
    $sql = 'INSERT INTO topic(name) VALUES ("';
    $sqlend = '");';
    $topicName = $_POST["topicName"];
    $ask = "select * from topic where name like \"" . $topicName . "\"";
    $result = classList($ask);
    if ($result === NULL || empty($result)) {
        echo "Téma sikeresen hozzáadva: " . $topicName . "<br>";
        executeQuery($sql . $topicName . $sqlend);
    } else
        echo "Téma létrehozása sikertelen, már van ilyen.";
} elseif (isset($_POST["surveyCreateButton"])) {
    if (isset($_POST["selectedTopic"]) && ($_POST["selectedTopic"] !== null) && $_POST["selectedTopic"] != "") {
        if (isset($_POST["surveyName"]) && !($_POST["surveyName"] === null) && $_POST["surveyName"] != "") {
            $ask = "select * from survey where sname like \"" . $_POST["surveyName"] . "\"";
            $result = classList($ask);
            if ($result === NULL || empty($result)) {
                executeQuery('INSERT INTO survey( sname, topic) VALUES ("' . $_POST["surveyName"] . '","' . $_POST["selectedTopic"] . '")');
                echo "Kérdőív sikeresen hozzáadva: " . $_POST["surveyName"] . "<br>";
            } else
                echo "Kérdőív létrehozása sikertelen, már van ilyen nevű kérdőív..";
        } else echo "Nincs név megadva!";
    } else echo "Nincs téma megadva!";
} elseif (isset($_POST["questionsToAdd"])) {
    if (isset($_POST["selectedSurvey"]) && ($_POST["selectedSurvey"] !== null) && $_POST["selectedSurvey"] != "") {
        if (isset($_POST["questionsToAdd"]) && !($_POST["questionsToAdd"] === null) && $_POST["questionsToAdd"] != "") {
            $questions = explode(";", $_POST["questionsToAdd"]);
            $toEcho = "<br>";
            for ($i = 0; $i < count($questions) - 1; $i++) {
                $ask = "select * from survey_question where sid = " . $_POST['selectedSurvey'] . " and qid = " . $questions[$i];
                $result = classList($ask);
                if ($result === NULL || empty($result)) {
                    $toExecute = 'iNSERT INTO survey_question(sid, qid) VALUES (' . $_POST["selectedSurvey"] . ',' . $questions[$i] . ')';
                    executeQuery($toExecute);
                    $toEcho .= "" . $questions[$i] . ". kérdés sikeresen hozzáadva ehhez: " . $_POST["selectedSurvey"] . "-es kérdőív<br>";
                } else {
                    $toEcho .=  "Nem adtam hozzá a " . $questions[$i] . ". kérdést, mert már hozzá van adva a " .  $_POST["selectedSurvey"] . "-es kérdőívhez..<br>";
                }
            }
            echo $toEcho;
        } else echo "Nem pipáltál be semmit.";
    } else echo "Nincs kérdőív kiválasztva!";
}
?>
<html>

<head>
    <link rel="stylesheet" href="<?php echo PUBLIC_DIR . "style.css"; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        function markQuestion(questionid) {
            if (!document.getElementById("checkbox" + questionid).checked) {
                document.getElementById("questions").value = document.getElementById("questions").value.replaceAll((questionid + ";"), "");
                var orders = document.querySelectorAll(".order");
                for (let i = 0; i <= document.querySelectorAll(".order").length - 1; i++) {
                    console.log(i);
                    if (orders[i].innerText > document.getElementById("order" + questionid).innerText && orders[i].innerText != "") {
                        console.log("Megváltoztatom: " + i);
                        orders[i].innerText = orders[i].innerText - 1;
                    }
                }
                console.log("Leveszem:" + questionid);
                document.getElementById("order" + questionid).innerText = "";
            } else {
                document.getElementById("questions").value += questionid + ";";
                document.getElementById("order" + questionid).innerText = document.getElementById("questions").value.length / 2;
                console.log("Hozzáadom: " + questionid);
            }
        }

        function hideOrNot(divId) {
            document.getElementById("theme").hidden = true;
            document.getElementById("survey").hidden = true;
            document.getElementById("questionsDiv").hidden = true;
            document.getElementById(divId).hidden = false;
        }
    </script>
</head>

<body>
    <?php
    $listQuestionsResult = classList("sELECT * FROM `questions` WHERE 1");
    ?>
    <form method="post" action="">
        <div class="usersDiv" class="container">
            <h2>Mit szeretnél tenni?</h2>
            <table class="table">
                <tr>
                    <th scope="col">Téma hozzáadása</th>
                    <th scope="col">Kérdőív létrehozása</th>
                    <th scope="col">Kérdéseket kérdőívhez adni</th>
                </tr>
                <tr>
                    <td> <input name='toDo' onchange='hideOrNot("theme")' type='radio' /> </td>
                    <td> <input name='toDo' checked onchange='hideOrNot("survey")' type='radio' /> </td>
                    <td> <input name='toDo' onchange='hideOrNot("questionsDiv")' type='radio' /> </td>
                </tr>
            </table>
        </div>

        <div class="usersDiv" hidden id='theme' class="container">
            <h2>Téma hozzáadása</h2>
            <table class="table">
                <tr>
                    <th scope="col">Téma neve</th>
                </tr>
                <tr>
                    <td> <input placeholder="Téma neve" name="topicName" type="text" /> </td>
                </tr>
                <tr>
                    <td>
                        <input type='submit' name="themeCreateButton" value='Téma Létrehozás'>
                    </td>
                </tr>
            </table>
        </div>
        <div class="usersDiv" id='survey' class="container">
            <h2>Kérdőív létrehozása</h2>
            <?php $listTopicResult = classList("sELECT * FROM `topic` WHERE 1"); ?>
            <?php if ($listTopicResult === NULL || empty($listTopicResult)) : ?>
                <h2> Nincs megjeleníthető téma, így nem lehet kérdőívet létrehozni.</h2>
                <h3 style="text-align: center;"> Hozz létre egy témát először!</h3>
            <?php else : ?>
                <table class="table">
                    <tr>
                        <th scope="col">Kérdőív neve</th>
                        <th></th>
                        <th scope="col">Kérdőív témája</th>
                    </tr>
                    <tr>
                        <td style="width: 40%;">
                            <input placeholder="Kérdőív neve" name="surveyName" type="text" />
                        </td>
                        <td> </td>
                        <td style="width: 40%;">
                            <select name="selectedTopic">
                                <option disabled selected value=""> Kérlek válassz</option><!-- <optgroup label="Kérdőív téma"> -->
                                <?php foreach ($listTopicResult as $row) : ?>
                                    <option value="<?= $row["tid"] ?>"><?= $row["name"] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type='submit' name="surveyCreateButton" value='Kérdőív Létrehozás'>
                        </td>
                        <td></td>
                    </tr>
                </table>
            <?php endif; ?>
        </div>
        <div class="usersDiv" hidden id='questionsDiv' class="container">
            <?php if ($listQuestionsResult === NULL || empty($listQuestionsResult)) : ?>
                <h2>Nincs egyetlen kérdés sem!</h2>
            <?php else : ?>
                <?php $listSurveyResult = classList("sELECT * FROM `survey` WHERE 1"); ?>
                <?php if ($listSurveyResult === NULL || empty($listSurveyResult)) : ?>
                    <h2> Nincs megjeleníthető kérdőív, így nem tudod mihez hozzá adni a kérdéseket.</h2>
                <?php else : ?>
                    <table class="table" style="border:transparent">
                        <tr style="border: transparent">
                            <th style="border:transparent">
                                Kérdőív kiválasztása:
                            </th>
                        </tr>
                        <tr style="border: transparent">
                            <td>
                                <select name="selectedSurvey">
                                    <option disabled selected value=""> Kérlek válassz</option>
                                    <?php foreach ($listSurveyResult as $row) : ?>
                                        <option value='<?= $row["sid"] ?>'><?= $row["sname"] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>

                        <h2>Kérdések listája</h2>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Kérdés</th>
                                    <th scope="col">Válasz 1</th>
                                    <th scope="col">Válasz 2</th>
                                    <th scope="col">Válasz 3</th>
                                    <th scope="col">Hozzáadás</th>
                                    <th scope="col">Hozzáadási Sorrend</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listQuestionsResult as $row) : ?>
                                    <tr scope="row" class="list">
                                        <td scope="row"><?= $row['qid'] ?></td>
                                        <td scope="row"><?= $row['question'] ?></td>
                                        <td scope="row"><?= $row['answer1'] ?></td>
                                        <td scope="row"><?= $row['answer2'] ?></td>
                                        <td scope="row"><?= $row['answer3'] ?></td>
                                        <td> <input type="checkbox" onclick="markQuestion('<?= $row['qid'] ?>')" id='checkbox<?= $row['qid'] ?>' value="<?= $row['qid'] ?>"></input> </td>
                                        <td class='order' id='<?= "order" . $row['qid'] ?>'> </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <table class="table" style="border:transparent;">
                            <tr>
                                <td>
                                    <input type="submit" name="questionsAddButton" value="Kérdések hozzáadása">
                                </td>
                            </tr>
                        </table>
                        <input id='questions' name='questionsToAdd' value="" hidden placeholder="Hidden lesz"></input>
                    <?php endif; ?>
                <?php endif; ?>
        </div>

    </form>
</body>

</html>