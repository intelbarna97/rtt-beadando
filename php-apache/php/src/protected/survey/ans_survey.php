<?php
if (isset($_POST["names"])) {
    $names = explode(";", $_POST["names"]);
    $values = array();
    $counter = 0;
    foreach ($names as $name) {
        $num = "qid_" . $name;
        $ans =  $_POST["$num"];
        if ($ans != "") {
            if ($name != "") {
                if (isUserLoggedIn()) {
                    $userId = isUserLoggedIn();
                    $uploadans = "";
                } else {
                    $userId = -1;
                    $uploadans = "";
                }
                $sid = $_POST["sid"];
                $sql = "INSERT INTO user_survey(sid, uid, answer, questionid) VALUES ($sid,$userId,$ans,$name)"; //át tudom írni úgy, hogy csak akkor rögzítse az adatokat ha minden rádiógomb esetében választott
                //viszont így meg majd "lehet folytatni" a félbehagyott survey-t
                //TODO: Az oldal "alap megjelenéséhez" az sql parancsot kijavítani, jelenleg nem szűr rendesen.
                //A cél az, hogy a szűrése csak azokat a kérdőíveket mutassa amikhez még nincs a felhasználónak válasza.
                //TODO: A feltöltés ellenőrizhetné azt, hogy nincs-e már véletlen válasza a felhasználónak ehhez a kérdéshez ugyanebben a kérdőívben.
                executeQuery($sql);

                //5 xp-t kapsz minden megválaszolt kérdésért:
                $xpsql = "UPDATE users 
                SET xp=xp+5 
                WHERE uid = ".$_SESSION["uid"];
                executeQuery($xpsql);
            }
        }

        $counter++;
    }
    echo "<br>Válaszaidat sikeresen rögzítettük.<br>";
}

if (isset($_POST["selectedSurvey"])) {
    $surveyID =  $_POST["selectedSurvey"];
    $sql = "select * from questions, survey_question, survey where survey_question.qid = questions.qid and survey_question.sid = $surveyID and survey.sid = survey_question.sid";
    //echo $sql;
    $questions = classList($sql);
    if ($questions === NULL || empty($questions)) {
        echo "Nincs kérdés";
    } else {
        echo '<form method="post" action=""> <div class="usersDiv" id=\'surveyDiv\' class="container"> <table class="table">';
        $surveyName = $questions[0]["sname"];
        echo "<h1>$surveyName</h1>";
        echo "<tr><th>
        Kérdés:
        </th>
        <th> Válasz1</th>
        <th> Válasz2</th>
        <th> Válasz3</th>
        </tr>
        ";
        $names = "";
        foreach ($questions as $questionsRow) {
            $sid = $questionsRow["sid"];
            echo "<input type = 'text' hidden value = '$sid' name ='sid'>";
            $oneQuestion = $questionsRow["question"];
            $a1 = $questionsRow["answer1"];
            $a2 = $questionsRow["answer2"];
            $a3 = $questionsRow["answer3"];
            $qid = $questionsRow["qid"];
            echo "<tr>";
            echo "<td>";
            echo $oneQuestion;
            echo "</td>";
            echo "<td>";
            echo "<input type = 'radio' name = 'qid_$qid' value = '$a1'> $a1 ";
            echo "</td>";
            echo "<td>";
            echo "<input type = 'radio' name = 'qid_$qid' value = '$a2'> $a2";
            echo "</td>";
            echo "<td>";
            echo "<input type = 'radio' name = 'qid_$qid' value = '$a3'> $a3 ";
            echo "</td>";
            echo "</tr>";
            $names .= $qid . ";";
        }
        echo "<input type = 'text' value = '$names' name = 'names' hidden>";
        echo "
        </th>
        <th>  </th>
        <th> <div> <input type = 'submit' name = 'submited' value = 'Válaszok beküldése'></div> </th>
        <th>  </th>
        </tr>
        ";
        echo "</table></div></form>";
    }
} else {
    if (isUserLoggedIn()) {
        $userId = isUserLoggedIn();
        $topics = "select * from topic, (SELECT * FROM survey s WHERE s.sid NOT IN (SELECT u.sid FROM user_survey u WHERE u.sid = $userId )) need where topic = topic.tid ";
        //$topics = "select * from survey,topic this where sid not in (select survey_question.sid FROM survey_question LEFT JOIN user_survey USING (sid) WHERE user_survey.uid = 1 Group by survey_question.sid) group by sid";
    } else {
        $userId = -1;
        $topics = "select * from topic where 1";
    }
    $result = classList($topics);
    echo "<div hidden>Lekérdezem a témákat: " . $topics . "<br><br></div>";
    $topics = array();
    $topicName = array();
    $couter = 0;
    foreach ($result as $row) {
        if (!in_array($row["tid"], $topics)) {
            $topics[$couter] = $row["tid"];
            if (count($topicName) == 0) {
                $topicName[$couter] = $row["name"];
            } else {
                $topicName[count($topicName) + 1] = $row["name"];
            }
        }
        $couter++;
    }
    $couter = 0;
    echo '<div class="usersDiv" id=\'questionsDiv\' class="container">';
    echo "<h1>Témák és kérdőívei: </h1>";
    foreach ($topics as $topicsrow) {
        $sql = "select sid, sname from topic, (SELECT * FROM survey s WHERE s.sid NOT IN (SELECT u.sid FROM user_survey u WHERE u.sid = $userId )) need where topic =" . $topicsrow . " and topic = tid";
        $topicNameNow = $topicName[$couter];
        echo "<h2>$topicNameNow</h2>";
        $result2 = classList($sql);
        echo "<table class = 'table'>";
        foreach ($result2 as $result2row) {
            $id = $result2row["sid"];
            $name = $result2row["sname"];
            echo "<tr>  <td> <form method='post' action=''> <input type = 'submit' value = 'Kitöltés: $name'> <input name = 'selectedSurvey' hidden type = 'text' value = '$id'> </form></td> </tr>";
            $couter++;
        }
        echo "</table>";
    }
    echo "</div>";
}







?>
<html>

<head>

</head>

<body>



</body>

</html>