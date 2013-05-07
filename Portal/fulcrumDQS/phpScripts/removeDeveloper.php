<?php
    include "dbConnect.php";
    $adminUsername=$_COOKIE['administratorUsername'];
    $adminPassword=$_COOKIE['administratorPassword'];
    dbConnect($adminUsername, $adminPassword);
    include "dbTableAccessRevoke.php";
    $developerUsername=mysql_real_escape_string($_REQUEST['selectedDeveloper']);
    if($developerUsername=="")
    {
        header("location:../pages/administration.php");
    }
    
    //delete user row from developer table
    $query="DELETE FROM developer WHERE username='".$developerUsername."'";
    $result=  mysql_query($query) or die(mysql_error());
    
    //REVOKE PREVILEGES FROM USER
    //dbTableAccessRevoke($developerUsername);

    //DELETE USER ACCOUNT IN DB
    $query="DROP USER ".
    "'".$developerUsername."'@'".$_COOKIE['DADatabase']."'";
    $result=  mysql_query($query) or die(mysql_error()); 

    header("location:../pages/administration.php");
?>
