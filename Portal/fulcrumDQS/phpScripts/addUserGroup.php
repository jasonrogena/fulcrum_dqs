<?php
session_start();
    include 'dbConnect.php';
    $devUsername=$_COOKIE['developerUsername'];
    $devPassword=$_COOKIE['developerPassword'];
    dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
    $groupName=mysql_real_escape_string($_SESSION['fromEditGroup']['groupName']);
    $applicationSelect=mysql_real_escape_string($_SESSION['fromEditGroup']['selectApp']);
    if($_SESSION['fromEditGroup']['selectApp']=="")//if application has not been set
    {
        $query="INSERT INTO `group`(`group_name`,`developer_username`) ".
        "VALUES ('$groupName','$devUsername')";
    }
    else// if application has been chosen
    {
        $query="INSERT INTO `group`(`group_name`,`application_ID`,`developer_username`) ".
        "VALUES ('$groupName','$applicationSelect','$devUsername')";
    }
    $result=mysql_query($query) or die (mysql_error());
    $query="SELECT `group_ID` FROM `group` WHERE `group_name`='$groupName'";
    $result=mysql_query($query) or die (mysql_error());
    $groupID=mysql_fetch_array($result);
    $selectedFUsers=$_SESSION['fromEditGroup']['selectedUsers'];
    $count=0;
    while ($count<count($selectedFUsers))
    {
    	$fieldUser=mysql_real_escape_string($selectedFUsers[$count]);
        $query="UPDATE `field_user` SET `group_ID`='{$groupID['group_ID']}' WHERE username='$fieldUser'";
        $result=mysql_query($query) or die (mysql_error());
        $count=$count+1;
    }
    header("location:../pages/userGroups.php");
?>