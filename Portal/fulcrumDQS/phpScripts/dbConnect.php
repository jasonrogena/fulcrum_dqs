<?php
function dbConnect($username,$password)
{
    $connect=mysql_connect($_COOKIE['DADatabase'],$username,$password) or die(header('location:../pages/accessDenied.php'));//
    $select_db= mysql_select_db($_COOKIE['resourceDatabase']);
}
?>
