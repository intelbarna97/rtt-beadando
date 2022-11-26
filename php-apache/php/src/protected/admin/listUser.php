<html>
    <head>
    <link rel="stylesheet" href="<?php echo PUBLIC_DIR."style.css";?>"><meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <?php 
        $query = "SELECT * FROM users";

        $listUserResult = classList($query);

        ?>
        <div class = "usersDiv" class = "container">
            <?php  if($listUserResult === NULL || empty($listUserResult)): ?>
                <h2>Nincs egyetlen felhasználó sem!</h2>
            <?php else: ?>
            <h2>Felhasználók listája</h2>
            <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Permission</th>
                <th scope="col">User changes</th>
                </tr>
            </thead>
            <tbody>
            <form method = "post">
            <?php foreach($listUserResult as $row): ?>
                <tr scope="row" class = "list">
                            <td scope="row"><?=$row['uid']?></td>
                            <td scope="row"><?=$row['username']?></td>
                            <td scope="row"><?=$row['email']?></td>
                            <?php  if($row['permission'] == 1): ?>
                            <td class = "adminStyle">Admin</td>
                            <?php elseif($row['permission'] == 2): ?>
                                <td class = "ownerStyle" scope="row">Owner</td>
                            <?php else: ?>
                                <td class = "userStyle" scope="row">User</td>
                            <?php endif; ?>
                            <td scope="row">
                            <?php  if($row['uid'] != $_SESSION["uid"]): ?>
                                <?php if($row['permission'] < 2 && $row["permission"] == 1 && $_SESSION["permission"] == 2): ?>
                                    <button class="btn btn-dark" name = "revokeAdmin" value =<?= $row['uid']?>>Revoke</button>
                                <?php  if($_SESSION["permission"] == 2): ?>
                                    <button class="btn btn-dark" name = "deleteUser" value =<?= $row['uid']?>>Delete</button>
                                <?php  if($row['permission'] == 1 && $_SESSION["permission"] != 2): ?>
                                    <button class="btn btn-dark" name = "deleteUser" value =<?= $row['uid']?>>Delete</button>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php else: ?>
                                    <?php  if($row['permission'] < 1 ): ?>
                                        <button class="btn btn-dark" name = "promoteAdmin" value =<?= $row['uid']?>>Promote to Admin</button>
                                        <button class="btn btn-dark" name = "deleteUser" value =<?= $row['uid']?>>Delete</button>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php  if($row["permission"] == 0 || $_SESSION["permission"] > 1 && $row["permission"] != 2): ?>
                                    <button class="btn btn-dark" name = "modifyUserData" value =<?= $row['uid']?>>Modify</button>
                                <?php elseif($row["permission"] == 2): ?>
                                    <span style = "font-size: 16px;">You can't modify the owner!<span>
                                <?php elseif($_SESSION["permission"] != 2): ?>
                                    <span style = "font-size: 16px;">Owner permission is required to edit an admin!<span>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php  if($row['permission'] != 2): ?>
                                    <button class="btn btn-dark" name = "revokeAdmin" value =<?= $row['uid']?>>Revoke</button>
                                <?php else: ?>
                                    <span style = "font-size: 16px;">You are the owner, why do you want to do anything with yourself?<span>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php  if($row['permission'] != 2 && $_SESSION["permission"] == 2): ?>
                                    <button class="btn btn-dark" name = "promoteToOwner" value =<?= $row['uid']?>>Promote new owner</button>
                            <?php endif; ?>
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
<?php

if(isset($_POST["revokeAdmin"]))
{
    $getUID = $_POST["revokeAdmin"];
    $revokeAdminQuery = "UPDATE users SET permission = 0 WHERE uid = ".$getUID."";
            
    if($getUID == $_SESSION["uid"]):
        $_SESSION["permission"] = 0;
        header("location: index.php");
    else:
        header("location: index.php?P=listUser");
    endif;
    executeQuery($revokeAdminQuery);
}
if(isset($_POST["promoteAdmin"]))
{
    $getUID = $_POST["promoteAdmin"];
    $promoteAdminQuery = "UPDATE users SET permission = 1 WHERE uid = ".$getUID."";
    executeQuery($promoteAdminQuery);
    header("location: index.php?P=listUser");
}
if(isset($_POST["deleteUser"]))
{
    $getUID = $_POST["deleteUser"];
    $deleteUserQuery = "DELETE FROM users WHERE uid = ".$getUID."";
    executeQuery($deleteUserQuery);
    header("location: index.php?P=listUser");
}
if(isset($_POST["modifyUserData"]))
{
    $getUID = $_POST["modifyUserData"];
    header("location: index.php?P=modifyUserAdmin&I=".$getUID."");
}
if(isset($_POST["promoteToOwner"]))
{
    $getUID = $_POST["promoteToOwner"];
    $promoteOwnerQuery = "UPDATE users SET permission = 2 WHERE uid = ".$getUID."";
    $removeOldOwnerQuery = "UPDATE users SET permission = 1 WHERE uid = ".$_SESSION['uid']."";
    $_SESSION["permission"] = 1;
    executeQuery($promoteOwnerQuery);
    executeQuery($removeOldOwnerQuery);
    header("location: index.php?P=listUser");
}
?>