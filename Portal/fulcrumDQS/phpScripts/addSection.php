<?php
session_start();
    include 'dbConnect.php';
    $devUsername=$_COOKIE['developerUsername'];
    $devPassword=$_COOKIE['developerPassword'];
    dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
    $sectionHeading=mysql_real_escape_string($_SESSION['fromEditSection']['sectionName']);
    $introText=mysql_real_escape_string($_SESSION['fromEditSection']['sectionIntro']);
    $sectionNO=$_SESSION['sectionNO'];
    $sectionID=$_SESSION['applicationID'].$sectionNO;
    $_SESSION['sectionID']=$sectionID;
    $applicationID=$_SESSION['applicationID'];
    $query="INSERT INTO section(heading,`section_ID`,`section_NO`,`application_ID`,`intro_text`) ".
        "VALUES('$sectionHeading','$sectionID','$sectionNO','$applicationID','$introText')";
    $result=  mysql_query($query) or die (mysql_error());
    header('location:../pages/newScreen.php');
?>
