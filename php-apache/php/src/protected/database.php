<?php 
function getConnection(){
    $host = 'db'; 
    $username = 'root';
    $password = 'root';
    $database = 'afp1_big';
    $connection = mysqli_connect($host,$username,$password, $database);
    return $connection;
}

/*function executeQuery($query)
{
    $connection = getConnection();
    if(mysqli_query($connection,$query))
    {
        echo "Sikeres művelet";
    } else {
        echo "Hiba";
    }
    mysqli_close($connection);
}*/

function executeQuery($query)
{
    $connection = getConnection();
    $statement = mysqli_prepare($connection,$query);
    $success = mysqli_stmt_execute($statement);
    //
    //if($success)
    //{
    //    echo "siker";
    //}
    //else{
    //
    //   echo "fail: ".$query;
    //}
    mysqli_stmt_close($statement);
    mysqli_close($connection);
}

function classList($query)
{
    $connection = getConnection();
    $statement = mysqli_prepare($connection,$query);
    $success = mysqli_stmt_execute($statement);
    $result = [];
    if($success === TRUE)
    {
        $idk = $statement->get_result();
        while($temp = $idk->fetch_assoc())
        {
            $result[]=$temp;
        }
    }
    else{
        echo $query;
        die('Sikertelen végrehajtás');
    }
    
    mysqli_stmt_close($statement);

    mysqli_close($connection);

    return $result;

}
function isUserLoggedIn() 
{
	return $_SESSION  != null && array_key_exists('uid', $_SESSION) && is_numeric($_SESSION['uid']);
}
function userLogout() {
	session_unset();
	session_destroy();
	header('Location: index.php?P=home');
}
?>