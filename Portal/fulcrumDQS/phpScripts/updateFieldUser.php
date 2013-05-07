<?php
session_start();
    include 'dbConnect.php';
    $fieldUserName=$_COOKIE['fieldUsername'];
    $fieldPassword=$_COOKIE['fieldPassword'];
    dbConnect($fieldUserName, $fieldPassword);
    $fName=mysql_real_escape_string($_SESSION['fromFUserAccess']['fieldUserFname']);
    $surname=mysql_real_escape_string($_SESSION['fromFUserAccess']['fielsUserSname']);
    $newUsername=mysql_real_escape_string($_SESSION['fromFUserAccess']['fielsUserUsername']);
    $newPassword=mysql_real_escape_string($_SESSION['fromFUserAccess']['password']);
    $oldUsername=mysql_real_escape_string($_COOKIE['fieldUsername']);
    $oldPassword=mysql_real_escape_string($_COOKIE['fieldPassword']);
    
    $query="FLUSH PRIVILEGES";//solves mysql bug where if user is deleted then immediately created, the system crashes
    $result=mysql_query($query) or die(mysql_error());
    
    if($oldUsername!=$newUsername)
    {
    	$query="CREATE USER '".$newUsername."'@'".$_COOKIE['DADatabase']."' ".//creating user in the local host server
    	"IDENTIFIED BY '".$newPassword."'";
    	$result=  mysql_query($query) or die(mysql_error());
    	
    	include 'dbFieldUserAccessGrant.php';
    	dbFieldUserAccessGrant($newUsername);
    	
    	$query="DROP user '$oldUsername'@'{$_COOKIE['DADatabase']}'";
    	$result=mysql_query($query) or die(mysql_error());
    }
    else
    {
    	$query="SET PASSWORD FOR '$oldUsername'@'{$_COOKIE['DADatabase']}' = PASSWORD('$newPassword')";
    	$result=mysql_query($query) or die(mysql_error());
    }
    mysql_close();//old mysql user may have been deleted so new connection has to be made under new user
    
    //include 'dbFieldUserAccessRevoke.php';
    //dbFieldUserAccessRevoke($_COOKIE['fieldUsername']);
    /*$query="DROP USER ".
        "'".$_COOKIE['fieldUsername']."'@'".$_COOKIE['DADatabase']."'";
    $result=  mysql_query($query) or die(mysql_error());
    $query="CREATE USER '$newUsername'@'".$_COOKIE['DADatabase']."' ".
    "IDENTIFIED BY '$newPassword'";//in previous screen set old password to new password if no new password is defined
    $result=mysql_query($query) or die (mysql_error());
    include 'dbFieldUserAccessGrant.php';
    dbFieldUserAccessGrant($newUsername);*/

    dbConnect($newUsername, $newPassword);
    $query="UPDATE `field_user` ".
    "SET username='$newUsername',`first_name`='$fName',surname='$surname',password='$newPassword' ".
    "WHERE username='$oldUsername'";
    $result=  mysql_query($query) or die(mysql_error());
    header("location:logout.php");
?>
