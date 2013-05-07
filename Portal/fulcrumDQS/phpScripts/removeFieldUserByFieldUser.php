<?php
    session_start();
    include 'dbConnect.php';
    //$genFieldUserName=$_COOKIE['generalFieldUsername'];
    //$genFieldPassword=$_COOKIE['generalFieldUserPassword'];
    dbConnect($_COOKIE['fieldUsername'], $_COOKIE['fieldPassword']);
    $fieldUser=$_SESSION['username'];

    //delete user from database
    $query="DELETE FROM field_user WHERE username='".$fieldUser."'";
    $result=  mysql_query($query) or die(mysql_error());
    
    //include 'dbFieldUserAccessRevoke.php';
    //dbFieldUserAccessRevoke($fieldUser);
    //delete user account
    $query="DROP USER ".
    "'".$fieldUser."'@'".$_COOKIE['DADatabase']."'";
    $result=  mysql_query($query) or die(mysql_error()); 
        
    header("location:logout.php");
?>
