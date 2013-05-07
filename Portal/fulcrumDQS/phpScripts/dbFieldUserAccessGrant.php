<?php
function dbFieldUserAccessGrant($username)
{
    $query="GRANT SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.application ".
    "TO '".$username."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());

    $query="GRANT SELECT,UPDATE,DELETE ".
     "ON {$_COOKIE['resourceDatabase']}.field_user ".
    "TO '".$username."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());

    $query="GRANT SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.group ".
    "TO '".$username."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());

    $query="GRANT SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.section ".
    "TO '".$username."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());

    $query="GRANT SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.screen ".
    "TO '".$username."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());

    $query="GRANT SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.choice ".
    "TO '".$username."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());
    
    $query="GRANT SELECT ".
    "ON {$_COOKIE['resourceDatabase']}.developer ".
    "TO '$username'@'{$_COOKIE['DADatabase']}'";
    $result=mysql_query($query) or die(mysql_error());
    
    $query="GRANT RELOAD ,CREATE USER ".
    "ON *.* ".
    "TO '$username'@'".$_COOKIE['DADatabase']."' ".
    "WITH GRANT OPTION";
    $result=mysql_query($query) or die (mysql_error());

    /*$query="GRANT SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.rating ".
    "TO '".$username."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());*/

    //////////////////////////////////////////////////////////////////
    //$_COOKIE['responseDatabase'] database previleges
    $select_db= mysql_select_db($_COOKIE['responseDatabase']);

    $query="GRANT INSERT ".
    "ON {$_COOKIE['responseDatabase']}.answer ".
    "TO '$username'@'{$_COOKIE['DADatabase']}'";
    $result=mysql_query($query) or die(mysql_error());

    $query="GRANT INSERT ".
    "ON {$_COOKIE['responseDatabase']}.query ".
    "TO '$username'@'{$_COOKIE['DADatabase']}'";
    $result=mysql_query($query) or die(mysql_error());

    $query="GRANT INSERT ".
    "ON {$_COOKIE['responseDatabase']}.response ".
    "TO '$username'@'{$_COOKIE['DADatabase']}'";
    $result=mysql_query($query) or die(mysql_error());

    $query="GRANT SELECT ".
    "ON {$_COOKIE['responseDatabase']}.application ".
    "TO '$username'@'{$_COOKIE['DADatabase']}'";
    $result=mysql_query($query) or die(mysql_error());



    $query="FLUSH PRIVILEGES";
    $result=mysql_query($query) or die(mysql_error());

    $select_db= mysql_select_db($_COOKIE['resourceDatabase']);
    
}
?>
