<?php
function dbFieldUserAccessRevoke($username)
{
    $query="REVOKE SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.application ".
    "FROM '".$username."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());

    $query="REVOKE SELECT,UPDATE,DELETE ".
     "ON {$_COOKIE['resourceDatabase']}.field_user ".
    "FROM '".$username."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());

    $query="REVOKE SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.group ".
    "FROM '".$username."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());

    $query="REVOKE SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.section ".
    "FROM '".$username."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());

    $query="REVOKE SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.screen ".
    "FROM '".$username."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());

    $query="REVOKE SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.choice ".
    "FROM '".$username."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());
    
    $query="REVOKE SELECT ".
    "ON {$_COOKIE['resourceDatabase']}.developer ".
    "FROM '$username'@'{$_COOKIE['DADatabase']}'";
    $result=mysql_query($query) or die(mysql_error());

    $query="REVOKE RELOAD ,CREATE USER ".
    "ON *.* ".
    "FROM '$username'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die (mysql_error());
    
    /*$query="REVOKE SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.rating ".
    "FROM '".$username."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());*/


    //////////////////////////////////////////////////////////////////
    //$_COOKIE['responseDatabase'] database previleges
    $select_db= mysql_select_db($_COOKIE['responseDatabase']);

    $query="REVOKE INSERT ".
    "ON {$_COOKIE['responseDatabase']}.answer ".
    "FROM '$username'@'{$_COOKIE['DADatabase']}'";
    $result=mysql_query($query) or die(mysql_error());

    $query="REVOKE INSERT ".
    "ON {$_COOKIE['responseDatabase']}.query ".
    "FROM '$username'@'{$_COOKIE['DADatabase']}'";
    $result=mysql_query($query) or die(mysql_error());

    $query="REVOKE INSERT ".
    "ON {$_COOKIE['responseDatabase']}.response ".
    "FROM '$username'@'{$_COOKIE['DADatabase']}'";
    $result=mysql_query($query) or die(mysql_error());

    $query="REVOKE SELECT ".
    "ON {$_COOKIE['responseDatabase']}.application ".
    "FROM '$username'@'{$_COOKIE['DADatabase']}'";
    $result=mysql_query($query) or die(mysql_error());



    $query="FLUSH PRIVILEGES";
    $result=mysql_query($query) or die(mysql_error());

    $select_db= mysql_select_db($_COOKIE['resourceDatabase']);
}
?>
