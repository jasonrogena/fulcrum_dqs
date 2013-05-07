<?php
function dbTableAccessRevoke($developerUsername)
{
    $query="REVOKE INSERT,UPDATE,DELETE,SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.application ".
    "FROM '".$developerUsername."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());

    $query="REVOKE INSERT,UPDATE,DELETE,SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.field_user ".
    "FROM '".$developerUsername."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());

    $query="REVOKE INSERT,UPDATE,DELETE,SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.group ".
    "FROM '".$developerUsername."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());

    $query="REVOKE INSERT,UPDATE,DELETE,SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.section ".
    "FROM '".$developerUsername."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());

    $query="REVOKE INSERT,UPDATE,DELETE,SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.screen ".
    "FROM '".$developerUsername."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());

    $query="REVOKE INSERT,UPDATE,DELETE,SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.choice ".
    "FROM '".$developerUsername."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());

    /*$query="REVOKE INSERT,UPDATE,DELETE,SELECT ".
     "ON {$_COOKIE['resourceDatabase']}.rating ".
    "FROM '".$developerUsername."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());*/

    $query="REVOKE SELECT,UPDATE,DELETE ".
     "ON {$_COOKIE['resourceDatabase']}.developer ".
    "FROM '".$developerUsername."'@'".$_COOKIE['DADatabase']."'";
    $result=mysql_query($query) or die(mysql_error());

    $query="REVOKE RELOAD ,DELETE, GRANT OPTION ". // delete privilege added most recently and not tested
    "ON *.* ".
    "FROM '$developerUsername'@'".$_COOKIE['DADatabase']."' ";
    $result=mysql_query($query) or die (mysql_error());
    
    /*$query="REVOKE SELECT,UPDATE ".
    "ON mysql.user ".
    "FROM '$developerUsername'@'{$_COOKIE['DADatabase']}'";
    $result=mysql_query($query) or die(mysql_error());*/


    ///////////////////////////////////////////////////////////////////////
    //$_COOKIE['responseDatabase'] database previleges
    $select_db= mysql_select_db($_COOKIE['responseDatabase']);

    $query="REVOKE INSERT,UPDATE,DELETE,SELECT ".
     "ON {$_COOKIE['responseDatabase']}.answer ".
    "FROM '$developerUsername'@'{$_COOKIE['DADatabase']}'";
    $result=mysql_query($query) or die(mysql_error());

    $query="REVOKE INSERT,UPDATE,DELETE,SELECT ".
     "ON {$_COOKIE['responseDatabase']}.application ".
    "FROM '$developerUsername'@'{$_COOKIE['DADatabase']}'";
    $result=mysql_query($query) or die(mysql_error());

    $query="REVOKE INSERT,UPDATE,DELETE,SELECT ".
     "ON {$_COOKIE['responseDatabase']}.query ".
    "FROM '$developerUsername'@'{$_COOKIE['DADatabase']}'";
    $result=mysql_query($query) or die(mysql_error());

    $query="REVOKE INSERT,UPDATE,DELETE,SELECT ".
     "ON {$_COOKIE['responseDatabase']}.response ".
    "FROM '$developerUsername'@'{$_COOKIE['DADatabase']}'";
    $result=mysql_query($query) or die(mysql_error());



    $query="FLUSH PRIVILEGES";
    $result=mysql_query($query) or die(mysql_error());

    $select_db= mysql_select_db($_COOKIE['resourceDatabase']);
}

?>
