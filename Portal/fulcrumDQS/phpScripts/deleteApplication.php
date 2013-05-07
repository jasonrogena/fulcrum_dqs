<?php
    include 'dbConnect.php';
    $devUsername=$_COOKIE['developerUsername'];
    $devPassword=$_COOKIE['developerPassword'];
    dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
    $selectedApp=$_REQUEST['selectedApplication'];
    if($selectedApp=="")
    {
        header(header('location:../pages/applications.php'));
    }
    else
    {
        $query="DELETE FROM `application` WHERE `application_ID`='$selectedApp'";
        $result=mysql_query($query) or die (mysql_error());
        header(header('location:../pages/applications.php'));
    }
?>
