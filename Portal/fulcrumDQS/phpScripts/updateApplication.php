<?php
    session_start();
    include 'dbConnect.php';
    $devUsername=$_COOKIE['developerUsername'];
    $devPassword=$_COOKIE['developerPassword'];
    dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
    $appName=mysql_real_escape_string($_SESSION['fromEditApplication']['applicationName']);
    $appIntroText=mysql_real_escape_string($_SESSION['fromEditApplication']['applicationIntro']);
    $dateEdited=  date('Y-m-d H:i:s');//time is in gmt
    $language=mysql_real_escape_string($_SESSION['fromEditApplication']['language']);
    $query="UPDATE application ".
    "SET `name`='$appName',`intro_text`='$appIntroText',`last_edited`='$dateEdited',`language`='$language' ".
    "WHERE `application_ID`='{$_SESSION['applicationID']}'";
    $result=mysql_query($query) or die(mysql_error());
    header("location:../pages/reviewApplication.php");
?>
