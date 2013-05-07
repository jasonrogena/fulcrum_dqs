<?php
    include "dbConnect.php";
    $devUsername=$_COOKIE['developerUsername'];
    $devPassword=$_COOKIE['developerPassword'];
    dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
    $fieldUser=mysql_real_escape_string($_REQUEST['selectedFUser']);//user name plus first name and surname
    if($fieldUser=="")
    {
        header('location:../pages/fieldUsers.php');
    }
    else
    {
                
        //revoke access
        //include 'dbFieldUserAccessRevoke.php';
        //dbFieldUserAccessRevoke($fieldUser);
        
        //delete user account
        $query="DROP USER ".
        "'".$fieldUser."'@'".$_COOKIE['DADatabase']."'";
        $result=  mysql_query($query) or die(mysql_error());
        
        //delete user from database
        $query="DELETE FROM field_user WHERE username='".$fieldUser."'";
        $result=  mysql_query($query) or die(mysql_error());
        header('location:../pages/fieldUsers.php');
    }
?>
