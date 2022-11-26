<html>
    <head>
    <link rel="stylesheet" href="<?php echo PUBLIC_DIR."style.css";?>"><meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <?php 
        $query = "SELECT * FROM survey";

        $listSurveyResult = classList($query);

        ?>
        <div class = "usersDiv" class = "container">
            <?php  if($listSurveyResult === NULL || empty($listSurveyResult)): ?>
                <h2>Nincs egyetlen kérdőív sem!</h2>
            <?php else: ?>
            <h2>Kérdőívek listája</h2>
            <table class="table">
            <thead>
                <tr>
                <th scope="col">Kérdőív neve</th>
                <th scope="col">Kérdőív témája</th>
                <th scope="col">Megtekintés</th>
                </tr>
            </thead>
            <tbody>
            <form method = "post">
            <?php foreach($listSurveyResult as $row): ?>
                <tr scope="row" class = "list">
                            <td scope="row"><?=$row['sname']?></td>
                            <td scope="row"><?=$row['topic']?></td>
                            <td scope="row">
                            <a href="<?=BASE_URL?>?P=averagesspecific&G=<?=$row['sid']?>">Megtekint</a>
                            </td>
                        </tr>
            <?php endforeach;?>
            </tbody>
            </table>
            <?php endif; ?>
            </form>
        </div>
    </body>
</html>