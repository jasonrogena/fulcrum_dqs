<?php
    session_start();
    include "dbConnect.php";
    $username=$_SESSION['fromLogin']['loginUserName'];
    $password=$_SESSION['fromLogin']['loginPassword'];
    $userType=$_SESSION['fromLogin']['userType'];
    dbConnect($username, $password);//connects to localhost using username and password and makes $_COOKIE['resourceDatabase'] default db
    mysql_select_db($_COOKIE['resourceDatabase']);
    if($userType=="Respondent")
    {
        $query="SELECT password ".
        "FROM `field_user` ".
        "WHERE username ='$username'";
        $result=mysql_query($query) or die(mysql_error());
        $dbpassword=mysql_fetch_array($result);
        if(isset ($dbpassword[0]) && $dbpassword[0]==$password)
        {
            $_SESSION['fieldUserValidate']=1;
            setcookie('fieldUsername', $username, 0, '/');//expires when the browser closes
            setcookie('fieldPassword', $password, 0, '/');
            header("location:../pages/fieldUserAccess.php");
        }
        else
        {
            $_SESSION['fieldUserValidate']=0;
            header("location:../pages/accessDenied.php");
        }
    }
    else if($userType=="Researcher")
    {
        $query="SELECT password ".
        "FROM developer ".
        "WHERE username ='$username'";
        $result=mysql_query($query) or die (mysql_error());
        $dbpassword=mysql_fetch_array($result);//stores password from query in array
        if(isset ($dbpassword[0]) && $dbpassword[0]==$password)
        {
            $_SESSION['devValidate']=1;//variable to confirm if developer is validated
            setcookie('developerUsername', $username, 0, '/');//expires when the browser closes
            setcookie('developerPassword', $password, 0, '/');
            header("location:../pages/applications.php");
        }
        else
        {
            $_SESSION['devValidate']=0;
            header("location:../pages/accessDenied.php");
        }
    }
    
?>