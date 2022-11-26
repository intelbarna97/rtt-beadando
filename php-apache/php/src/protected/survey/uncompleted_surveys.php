<?php

    if($_SESSION!=NULL || isset($_POST["submited"]))
    {
        $query = "SELECT * FROM user_survey u WHERE u.uid=" . $_SESSION["uid"];
    $result=classList($query);
    
    if($result === NULL || empty($result))
    {
        $query = "SELECT * FROM survey, topic WHERE survey.topic=topic.tid";
        $result=classList($query);
        $newsurveys = [];
    foreach($result as $temp)
    {
        array_push($newsurveys,$temp["sid"]);
    }
    //var_dump($newsurveys);
    }
    else
    {

    $query = "SELECT
                    surv.sname,
                    top.name,
                    surv.sid
                FROM
                    survey surv,
                    topic top
                WHERE NOT
                    EXISTS(
                    SELECT
                        s.sname,
                        t.name,
                        s.sid
                    FROM
                        survey s,
                        topic t,
                        (
                        SELECT
                            t.sid,
                            t.uid
                        FROM
                            (
                            SELECT
                                us.sid,
                                us.uid,
                                COUNT(us.questionid) q_db
                            FROM
                                user_survey us
                            GROUP BY
                                us.sid,
                                us.uid
                        ) t
                    WHERE
                        q_db =(
                        SELECT
                            COUNT(sq.qid)
                        FROM
                            survey_question sq
                        WHERE
                            sq.sid = t.sid
                    )
                    ) mok
                WHERE
                    mok.uid = " . $_SESSION["uid"] . " AND s.sid = mok.sid AND s.topic = t.tid AND s.sid = surv.sid
                ) AND surv.topic = top.tid;";

    $result = classList($query);

    $query="SELECT s.sid FROM survey s
    WHERE s.sid NOT IN 
    (SELECT u.sid FROM user_survey u
    WHERE u.uid = " . $_SESSION["uid"] . "
    )";
    

    $surveys = classList($query);
    $newsurveys = [];
    foreach($surveys as $temp)
    {
        array_push($newsurveys,$temp["sid"]);
    }
    //var_dump($newsurveys);
    //var_dump($result);
    }
    }
/*
    else
        $query="SELECT s.sid, s.sname, t.name FROM survey s, topic t
        WHERE s.topic=t.tid";

        $result = classList($query);
*/

    if (isset($_POST["names"]))
   {
    $names = explode(";", $_POST["names"]);
    
    foreach ($names as $name) {
        $num = "qid_" . $name;
        $ans =  @$_POST["$num"];
        if ($ans != "") {
            if ($name != "") {
                if (isUserLoggedIn()) {
                    $userId = $_SESSION["uid"];
                    $uploadans = "";
                } else {
                    $userId = -1;
                    $uploadans = "";
                }
                $sid = $_POST["sid"];
                $sql = "INSERT INTO user_survey(sid, uid, answer, questionid) VALUES ($sid,$userId,$ans,$name)";
                executeQuery($sql);
            }
        }
    }
    header("Refresh:0");
   }

   if (isset($_POST["selected"])): 
   
    $surveyID=$_POST["selected"];
    $query = "SELECT
    *
FROM
    questions,
    survey_question,
    survey
WHERE
    questions.qid NOT IN(SELECT
        questionid
    FROM
        user_survey
    WHERE
        user_survey.sid = $surveyID
) AND questions.qid=survey_question.qid AND survey_question.sid=$surveyID AND survey.sid=survey_question.sid;";
    $questions=classList($query);
    //var_dump($questions);
   ?>
   <div class = "usersDiv">
            <h2><?=$questions[0]["sname"]?></h2>
            <table class="table">
            <form method="post">
            <thead>
                <tr>
                <th>Kérdés</th>
                <th>1. Válasz</th>
                <th>2. Válasz</th>
                <th>3. Válasz</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $names = "";
            foreach($questions as $row): ?>
                <tr>
                <td><?=$row['question']?></td>
                <td>
                    <input name="qid_<?=$row['qid']?>" value =<?= $row['answer1']?> type='radio'><?=$row['answer1']?></td>
                <td>
                    <input name="qid_<?=$row['qid']?>" value =<?= $row['answer2']?> type='radio'><?=$row['answer2']?></td>                
                <td>
                    <input name="qid_<?=$row['qid']?>" value =<?= $row['answer3']?> type='radio'><?=$row['answer3']?></td>
                </tr>
            <?php 
            $names .= $row['qid'] . ";";
        endforeach;
        $names = rtrim($names,";");?>
        <input type = 'text' value = '<?=$names?>' name = 'names' hidden>
        <input type = 'text' hidden value = '<?=$row['sid']?>' name ='sid'>
            </th>
        <th>  </th>
        <th> <div> <input type = 'submit' name = 'submited' value = 'Válaszok beküldése'></div> </th>
        <th>  </th>
        </tr>
            </tbody>
            </form>
            </table>
        </div>   
                    <?php endif; ?>
    <?php

   ?>
   <?php
 if($result === NULL || empty($result)): ?>
    <p>Nincs rekord</p>
    <?php else: ?>
<html>
    <head>
    <link rel="stylesheet" href="<?php echo PUBLIC_DIR."style.css";?>">
    </head>
    <body>
        <div class = "usersDiv">
            <h2>Kérdőívek kitöltése</h2>
            <table class="table">
            <form method="post">
            <thead>
                <tr>
                <th>Azonosító</th>
                <th>Kérdőív</th>
                <th>Téma</th>
                <?php if($_SESSION!=NULL): ?>
                <th>Kitöltés állapota</th>
                <?php endif; ?>
                <th>Művelet</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            foreach($result as $row): ?>
                <tr>
                <td><?=$row['sid']?></td>
                <td><?=$row['sname']?></td>
                <td><?=$row['name']?></td>
                <?php if($newsurveys!=NULL && isset($newsurveys) && in_array($row['sid'],$newsurveys)):?>
                <td>Nincs elkezdve</td>
                <?php elseif(true): ?>
                <td>El van kezdve</td>
                <?php endif; ?>
                <td>
                    <?php if($newsurveys!=NULL && $_SESSION!=NULL && !in_array($row['sid'],$newsurveys)): ?>
                    <button name="selected" value =<?= $row['sid']?>>Folyatás</button>
                    <?php elseif(true): ?>                        
                    <button name="selected" value =<?= $row['sid']?>>Kitöltés</button>
                    <?php endif; ?>
                </td>
                </tr>
            <?php endforeach;?>
            </tbody>
            </form>
            </table>
        </div>
    </body>
</html>
<?php endif; ?>