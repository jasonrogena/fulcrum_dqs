<?php
session_start();
    include 'dbConnect.php';
    //$genDevUsername=$_COOKIE['generalDeveloperUsername'];
    //$genDevPassword=$_COOKIE['generalDeveloperPassword'];
    dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
    $fname=mysql_real_escape_string($_SESSION['fromeditDProfile']['developerFname']);
    $surname=mysql_real_escape_string($_SESSION['fromeditDProfile']['developerSname']);
    $newUsername=mysql_real_escape_string($_SESSION['fromeditDProfile']['developerUsername']);
    $newPassword=mysql_real_escape_string($_SESSION['fromeditDProfile']['password']);
    $oldUsername=mysql_real_escape_string($_COOKIE['developerUsername']);
    $oldPassword=mysql_real_escape_string($_COOKIE['developerPassword']);
    
    $query="FLUSH PRIVILEGES";//solves mysql bug where if user is deleted then immediately created, the system crashes
    $result=mysql_query($query) or die(mysql_error());
    
    //do you have to remove the create user in mysql?
    if($newUsername!=$oldUsername)
    {
    	$query="CREATE USER '".$newUsername."'@'".$_COOKIE['DADatabase']."' ".//creating user in the local host server
    	"IDENTIFIED BY '".$newPassword."'";
    	$result=  mysql_query($query) or die(mysql_error());
    	include 'dbTableAccessDeveloperRestrictions.php';
    	
    	dbTableAccessRestrictions($newUsername);
    	
    	$query="DROP user '$oldUsername'@'{$_COOKIE['DADatabase']}'";
    	$result=mysql_query($query) or die(mysql_error());
    }
    else
    {
    	$query="SET PASSWORD FOR '$oldUsername'@'{$_COOKIE['DADatabase']}' = PASSWORD('$newPassword')";
    	$result=mysql_query($query) or die(mysql_error());
    }
    
    mysql_close();
    
    dbConnect($newUsername, $newPassword);
    $query="UPDATE `developer` ".
    "SET username='$newUsername',`first_name`='$fname',surname='$surname',password='$newPassword' ".
    "WHERE username='$oldUsername'";
    $result=  mysql_query($query) or die(mysql_error());
        
    /*include 'dbTableAccessRevoke.php';
    dbTableAccessRevoke($oldUsername);
    $query="DROP USER ".
        "'".$oldUsername."'@'".$_COOKIE['DADatabase']."'";
    $result=  mysql_query($query) or die(mysql_error());

    $query="CREATE USER '$newUsername'@'".$_COOKIE['DADatabase']."' ".
    "IDENTIFIED BY '$newPassword'";//in previous screen set old password to new password if no new password is defined
    $result=mysql_query($query) or die (mysql_error());
    include 'dbTableAccessDeveloperRestrictions.php';
    dbTableAccessRestrictions($newUsername);*/
    header("location:logout.php");
?>
