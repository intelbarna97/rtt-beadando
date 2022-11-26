<?php

    $query = "SELECT s.sname, t.name, s.sid FROM survey s, topic t, 
    (SELECT t.sid, t.uid FROM 
    (
    SELECT us.sid,us.uid,COUNT(us.questionid) q_db FROM 
    user_survey us 
    GROUP BY us.sid,us.uid
    ) t 
    WHERE q_db = 
    (
    SELECT COUNT(sq.qid) FROM 
    survey_question sq 
    WHERE sq.sid = t.sid)
    ) mok 
    WHERE mok.uid=" . $_SESSION["uid"] . "
    AND s.sid=mok.sid 
    AND s.topic=t.tid;";

    $result = classList($query);


    if (isset($_POST["del"]))
   {
       $query = "DELETE FROM user_survey WHERE sid = " . $_POST["del"] . " AND uid = " . $_SESSION["uid"];
       
       executeQuery($query);

       header("Refresh:0");      
   }

   if (isset($_POST["re"]))
   {
       $query = "DELETE FROM user_survey WHERE sid = " . $_POST["re"] . " AND uid = " . $_SESSION["uid"];
       
       executeQuery($query);
       
       header("Refresh:0");   //most még csak kitörli az eddigi válaszok, nem irányít át a kitöltő oldalra, ha meg akarjuk őrizni az eddigi kitöltéseket akkor másképp kell majd megoldani
   }
?>
<?php if($result === NULL || empty($result)): ?>
    <p>Nincs rekord</p>
    <?php else: ?>
<html>
    <head>
    <link rel="stylesheet" href="<?php echo PUBLIC_DIR."style.css";?>">
    </head>
    <body>
        <div class = "usersDiv">
            <h2>Kitöltött kérdőívek</h2>
            <table class="table">
            <form method="post">
            <thead>
                <tr>
                <th>Azonosító</th>
                <th>Kérdőív</th>
                <th>Téma</th>
                <th>Kérdőív módosításai</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($result as $row): ?>
                <tr>
                <td><?=$row['sid']?></td>
                <td><?=$row['sname']?></td>
                <td><?=$row['name']?></td>
                <td>
                    <button name="del" value =<?= $row['sid']?>>Összes válasz törlése</button>
                    <button name="re" value =<?= $row['sid']?>>Újra kitöltés</button>
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