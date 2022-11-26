<?php

    $query = "SELECT tid, name FROM topic";

    $result = classList($query);


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
            <h2>Témakörök</h2>
            <table class="table">
            <form method="post">
            <thead>
                <tr>
                <th>Azonosító</th>
                <th>Téma</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($result as $row): ?>
                <tr>
                <td><?=$row['tid']?></td>
                <td><?=$row['name']?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
            </form>
            </table>
        </div>


    </body>


</html>


<?php endif; ?>