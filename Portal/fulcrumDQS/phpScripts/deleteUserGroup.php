<?php
    include 'dbConnect.php';
    $devUsername=$_COOKIE['developerUsername'];
    $devPassword=$_COOKIE['developerPassword'];
    dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
    $groupToDelete=$_REQUEST['groupToDelete'];
    if($groupToDelete=="")
    {
        echo header('location:../pages/userGroups.php');
    }
    else
    {
        $query="DELETE FROM `group` WHERE `group_ID`='$groupToDelete'";
        $result=mysql_query($query) or die(mysql_error());
        echo header('location:../pages/userGroups.php');
    }            
?>