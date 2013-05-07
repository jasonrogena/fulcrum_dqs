<?php
    session_start();
    include 'dbConnect.php';
    $username=$_SESSION['fromAdmin']['adminUserName'];
    $password=$_SESSION['fromAdmin']['adminPassword'];
    dbConnect($username, $password);
    $username=mysql_real_escape_string($username);
    $password=mysql_real_escape_string($password);
    $query="SELECT password ".
    "FROM administrator ".
    "WHERE username ='$username'";
    $result=mysql_query($query) or die (mysql_error());
    $dbpassword=mysql_fetch_array($result);//stores password from query in array
    if($dbpassword[0]==$password)
    {
        $_SESSION['adminValidate']=1;//variable to confirm if developer is validated
        setcookie('administratorUsername', $username, 0, '/');//expires when the browser closes
        setcookie('administratorPassword', $password, 0, '/');
        header("location:../pages/administration.php");
    }
    else
    {
        $_SESSION['devValidate']=0;
        header("location:../pages/accessDenied.php");
    }
?>