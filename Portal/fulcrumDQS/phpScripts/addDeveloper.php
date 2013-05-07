<?php
    session_start();
    include 'dbConnect.php';
    include 'dbTableAccessDeveloperRestrictions.php';
    $adminUsername=$_COOKIE['administratorUsername'];
    $adminPassword=$_COOKIE['administratorPassword'];
    dbConnect($adminUsername, $adminPassword);
    
    $query="FLUSH PRIVILEGES";
    $result=mysql_query($query) or die(mysql_error());
    
    $developerFname=mysql_real_escape_string($_SESSION['fromeditDProfile']['developerFname']);
    $developerSname=mysql_real_escape_string($_SESSION['fromeditDProfile']['developerSname']);
    $developerUsername=mysql_real_escape_string($_SESSION['fromeditDProfile']['developerUsername']);
    $developerPassword=mysql_real_escape_string($_SESSION['fromeditDProfile']['password']);
    
    //add database user for the developer
    $query="CREATE USER '".$developerUsername."'@'".$_COOKIE['DADatabase']."' ".//creating user in the local host server
    "IDENTIFIED BY '".$developerPassword."'";
    $result=  mysql_query($query) or die(mysql_error());

    //permissions
    dbTableAccessRestrictions($developerUsername);

    //add developer to the database
    $query="INSERT INTO developer (`first_name`,surname,username,password) ".
    "VALUES ('$developerFname','$developerSname','$developerUsername','$developerPassword')";
    $result=  mysql_query($query) or die(mysql_error());
    header("location:../pages/administration.php");
?>