<?php
    session_start();
    include 'dbConnect.php';
    //include 'dbTableAccessRevoke.php';
    $username=$_COOKIE['developerUsername'];
    //$genDevUsername=$_COOKIE['generalDeveloperUsername'];
    //$genDevPassword=$_COOKIE['generalDeveloperPassword'];
    dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
    
    //delete user from database
    $query="DELETE FROM developer WHERE username='".$username."'";
    $result=  mysql_query($query) or die(mysql_error());
    
    //dbTableAccessRevoke($username);/*not sure if dropping the user will automatically revoke previleges*/
    $query="DROP USER ".
    "'".$username."'@'".$_COOKIE['DADatabase']."'";
    $result=  mysql_query($query) or die(mysql_error());
    
    header("location:logout.php");
?>
