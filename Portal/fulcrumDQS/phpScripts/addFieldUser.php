<?php
session_start();
    include('dbConnect.php');
    $devUsername=$_COOKIE['developerUsername'];
    $devPassword=$_COOKIE['developerPassword'];
    dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
    $query="FLUSH PRIVILEGES";
    $result=mysql_query($query) or die(mysql_error());
    $fName=mysql_real_escape_string($_SESSION['fromFUserAccess']['fieldUserFname']);
    $surname=mysql_real_escape_string($_SESSION['fromFUserAccess']['fielsUserSname']);
    $username=mysql_real_escape_string($_SESSION['fromFUserAccess']['fielsUserUsername']);
    $password=mysql_real_escape_string($_SESSION['fromFUserAccess']['password']);
    if(isset ($_SESSION['fromFUserAccess']['usergroup']))
    {
        $userGroup=$_SESSION['fromFUserAccess']['usergroup'];
    }
    //add field user as a database user
    $query="CREATE USER '$username'@'".$_COOKIE['DADatabase']."' ".
    "IDENTIFIED BY '$password'";
    $result=mysql_query($query) or die (mysql_error());
    include 'dbFieldUserAccessGrant.php';
    dbFieldUserAccessGrant($username);

    //add field user to database
    if($userGroup=="")//no user group is chosen
    {
        $query="INSERT INTO `field_user`(`first_name`,surname,username,password,`developer_username`) ".
        "VALUES ('$fName','$surname','$username','$password','$devUsername')";
        $result=  mysql_query($query) or die (mysql_error());
    }
    else
    {
        $query="INSERT INTO `field_user`(`first_name`,surname,username,password,`group_ID`,`developer_username`) ".
        "VALUES ('$fName','$surname','$username','$password','$userGroup','$devUsername')";
        $result= mysql_query($query) or die (mysql_error());
    }
    
    header('location:../pages/fieldUsers.php');
?>
