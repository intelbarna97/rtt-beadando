<?php
    
    echo '<div class="usersDiv" id=\'myprofileDiv\' class="container">';
    echo "<h1>Saját profilom: </h1>";
    
        $sql = "select xp from users where uid =".$_SESSION["uid"];
        $topicNameNow = $topicName[$couter];
        echo "<h2>$topicNameNow</h2>";
        $result2 = classList($sql);
        $xp = $result2[0]["xp"];
        echo  "Kitöltéspontok száma: ".$xp;
        $lvl = 1+$xp/130.50;
        $nextlvl = $xp%130.50;
        if($lvl == 1)
        {
            $nextlvl = 131;
        }
         
        echo "<br>Szintem: ".floor($lvl) ;
        echo "<br>További kitöltéspont szükséges a következő szinthez: ".$nextlvl;
        echo "<table class = 'table'>";
        
        
        echo "</table>";
    
    echo "</div>";







?>
<html>

<head>

</head>

<body>



</body>

</html>