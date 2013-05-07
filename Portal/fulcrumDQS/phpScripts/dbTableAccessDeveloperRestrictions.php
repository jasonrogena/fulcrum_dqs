<?php
function dbTableAccessRestrictions($developerUsername)
{
    $query="GRANT INSERT,UPDATE,DELETE,SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.application ".
    "TO '".$developerUsername."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());

    $query="GRANT INSERT,UPDATE,DELETE,SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.field_user ".
    "TO '".$developerUsername."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());

    $query="GRANT INSERT,UPDATE,DELETE,SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.group ".
    "TO '".$developerUsername."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());

    $query="GRANT INSERT,UPDATE,DELETE,SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.section ".
    "TO '".$developerUsername."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());

    $query="GRANT INSERT,UPDATE,DELETE,SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.screen ".
    "TO '".$developerUsername."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());

    $query="GRANT INSERT,UPDATE,DELETE,SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.choice ".
    "TO '".$developerUsername."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());

    /*$query="GRANT INSERT,UPDATE,DELETE,SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.rating ".
    "TO '".$developerUsername."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());*/

    $query="GRANT SELECT,UPDATE,DELETE ".
     "ON {$_COOKIE['resourceDatabase']}.developer ".
    "TO '".$developerUsername."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());

    $query="GRANT RELOAD ,CREATE USER ".
    "ON *.* ".
    "TO '$developerUsername'@'".$_COOKIE['DADatabase']."' ".
    "WITH GRANT OPTION";
    $result=mysql_query($query) or die (mysql_error());
    
    /*$query="GRANT SELECT,UPDATE ".
    "ON mysql.user ".
    "TO '$developerUsername'@'{$_COOKIE['DADatabase']}'";
    $result=mysql_query($query) or die(mysql_error());*/

    ///////////////////////////////////////////////////////////////////////
    //$_COOKIE['responseDatabase'] database previleges
    $select_db= mysql_select_db($_COOKIE['responseDatabase']);
    
    $query="GRANT INSERT,UPDATE,DELETE,SELECT ".
     "ON {$_COOKIE['responseDatabase']}.answer ".
    "TO '$developerUsername'@'{$_COOKIE['DADatabase']}'";
    $result=mysql_query($query) or die(mysql_error());

    $query="GRANT INSERT,UPDATE,DELETE,SELECT ".
     "ON {$_COOKIE['responseDatabase']}.application ".
    "TO '$developerUsername'@'{$_COOKIE['DADatabase']}'";
    $result=mysql_query($query) or die(mysql_error());

    $query="GRANT INSERT,UPDATE,DELETE,SELECT ".
     "ON {$_COOKIE['responseDatabase']}.query ".
    "TO '$developerUsername'@'{$_COOKIE['DADatabase']}'";
    $result=mysql_query($query) or die(mysql_error());

    $query="GRANT INSERT,UPDATE,DELETE,SELECT ".
     "ON {$_COOKIE['responseDatabase']}.response ".
    "TO '$developerUsername'@'{$_COOKIE['DADatabase']}'";
    $result=mysql_query($query) or die(mysql_error());


    $query="FLUSH PRIVILEGES";
    $result=mysql_query($query) or die(mysql_error());

    $select_db= mysql_select_db($_COOKIE['resourceDatabase']);
}
?>
