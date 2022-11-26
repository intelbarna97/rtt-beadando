<?php
function get_g()
{
    if (!filter_has_var(INPUT_GET, 'G')) {
        die('Helytelen paraméter!');
    }
    $id = filter_input(INPUT_GET, 'G', FILTER_VALIDATE_INT);
    if ($id === false) {
        die('Helytelen paraméter!');
    }
    if ($id <= 0) {
        die('Az id legalább 1!');
    }
    return $id;
}
$id = get_g();
?>
<?php
$query = "SELECT * FROM questions INNER JOIN survey_question ON survey_question.qid = questions.qid AND survey_question.sid = $id";
$listQuestionResults = classList($query);
$answerCountQuery = "SELECT COUNT(answer1), COUNT(answer2), COUNT(answer3) FROM questions";
$answerCountQueryResult = classList($answerCountQuery);

?>
<div class="usersDiv">
<div class="page-hero d-flex align-items-center justify-content-center">
    <div class="text-center">
    <?php if ($listQuestionResults === NULL || empty($listQuestionResults)) : ?>
        <h2>Nincs egyetlen kérdés sem a kérdőívben!</h2>
    <?php else : ?>
        
        <h1>Az <?= $id ?>. azonosítójú kérdőívhez tartozó kérdések</h1>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Kérdés</th>
                    <th></th>
                    <th scope="col">Átlag válaszok értéke</th>
                </tr>
            </thead>
            <tbody>
                <form method="post">
                    <?php foreach ($listQuestionResults as $row) : ?>
                        <tr scope="row" class="list">
                            <td scope="row"><?= $row['question'] ?></td>
                            <td scope="row">
                                <?php
                                $asd = "SELECT COUNT(answer), answer FROM user_survey WHERE questionid= " . $row['qid'] . " GROUP BY user_survey.answer ORDER BY COUNT(answer) DESC LIMIT 1";
                                $asdResult = classList($asd);
                                ?>
                            <td scope="row"><?= $asdResult[0]['answer'] ?></td>

                            </td>
                        </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    </form>
    </div>
    </div>
</div>