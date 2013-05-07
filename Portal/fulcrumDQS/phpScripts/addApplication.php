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
    $query="INSERT INTO application (name,`intro_text`,`developer_username`,`last_edited`,language) ".
        "VALUES ('$appName','$appIntroText','$devUsername','$dateEdited','$language')";
    $result=  mysql_query($query) or die (mysql_error());
    $query="SELECT `application_ID` FROM application WHERE name='$appName' AND `intro_text`='$appIntroText'";
    $result=mysql_query($query) or die (mysql_error());
    $resultArray=mysql_fetch_array($result);
    $_SESSION['applicationID']=$resultArray['application_ID'];
    
    $select_db= mysql_select_db($_COOKIE['responseDatabase']);
    $query="INSERT INTO application (`application_ID`,name,`intro_text`,`developer_username`,`last_edited`,language) ".
        "VALUES ('{$_SESSION['applicationID']}','$appName','$appIntroText','$devUsername','$dateEdited','$language')";
    $result=  mysql_query($query) or die (mysql_error());
    header('location:../pages/newSection.php');
?>
