<?php
    session_start();
    include 'dbConnect.php';
    $devUsername=$_COOKIE['developerUsername'];
    $devPassword=$_COOKIE['developerPassword'];
    dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
    $groupID=$_SESSION['groupID'];
    $groupName=mysql_real_escape_string($_SESSION['fromEditGroup']['groupName']);
    $applicationID=$_SESSION['fromEditGroup']['selectApp'];
    if($applicationID=="")
    {
        $query="UPDATE `group` ".
        "SET `group_name` = '$groupName',`application_ID`= NULL WHERE `group_ID`='$groupID'";
    }
    else
    {
        $query="UPDATE `group` ".
        "SET `group_name`='$groupName',`application_ID`='$applicationID' WHERE `group_ID`='$groupID'";
    }
    $result=mysql_query($query) or die (mysql_error()."error 1".$applicationID);
    $selectedFUsers=$_SESSION['fromEditGroup']['selectedUsers'];
    $query="UPDATE `field_user` ".
    "SET `group_ID`= NULL WHERE `group_ID`='$groupID'";
    $result=  mysql_query($query) or die (mysql_error()."2");
    $count=0;
    while ($count<count($selectedFUsers))
    {
    	$fieldUser=mysql_real_escape_string($selectedFUsers[$count]);
        $query="UPDATE `field_user` SET `group_ID`='$groupID' WHERE username='$fieldUser'";
        $result=mysql_query($query) or die (mysql_error().$_SESSION['groupID']);
        $count=$count+1;
    }
    header("location:../pages/userGroups.php");
?>