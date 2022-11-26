<?php

    $query = "SELECT count(tid) FROM topic";

    $topics = classList($query);
    
    $query = "SELECT count(qid) FROM questions";

    $questions = classList($query);

    $query = "SELECT count(uid) FROM users";

    $users = classList($query);

    $query = "SELECT count(sid) FROM survey";

    $surveys = classList($query);

    $query = "SELECT count(usid) FROM user_survey";

    $answeredquestions = classList($query);



?>
<html>


    <head>

    <link rel="stylesheet" href="<?php echo PUBLIC_DIR."style.css";?>">

    </head>


    <body>


        <div class = "usersDiv">
            <h2>Kérdőív statisztika</h2>
            <table class="table">
            <form method="post">
            <thead>
                <tr>
                <th>Témakörök</th>

                <th>Kérdések</th>
                
                <th>Felhasználók</th>
                
                <th>Kérdőívek</th>
                
                <th>Megválaszolt kérdések</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td><?=$topics[0]['count(tid)']?></td>
                <td><?=$questions[0]['count(qid)']?></td>
                <td><?=$users[0]['count(uid)']?></td>
                <td><?=$surveys[0]['count(sid)']?></td>
                <td><?=$answeredquestions[0]['count(usid)']?></td>
                </tr>
            </tbody>
            </form>
            </table>
        </div>


    </body>


</html>
