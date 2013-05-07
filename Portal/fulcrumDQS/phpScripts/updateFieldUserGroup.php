<?php
    session_start();
    $newGroupID=$_REQUEST['usergroup'];
    $fieldUser=$_SESSION['fieldUsername'];
    include 'dbConnect.php';
    dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
    $fieldUser=mysql_real_escape_string($fieldUser);
    if($newGroupID=="")
    {
        $query="UPDATE `field_user` ".
        "SET `group_ID`=NULL WHERE username='$fieldUser'";
    }
    else
    {
        $query="UPDATE `field_user` ".
        "SET `group_ID`='$newGroupID' WHERE username='$fieldUser'";
    }
    $result=  mysql_query($query) or die (mysql_error());
    header("location:../pages/fieldUsersProfile.php");
?>
