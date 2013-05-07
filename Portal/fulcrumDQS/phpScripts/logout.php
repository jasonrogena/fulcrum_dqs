<?php
session_start();
setcookie('administratorUsername', '', time()-3600);
setcookie('administratorPassword', '', time()-3600);
setcookie('developerUsername', '', time()-3600);
setcookie('developerPassword', '', time()-3600);
setcookie('fieldUsername', '', time()-3600);
setcookie('fieldPassword', '', time()-3600);
$_SESSION['devValidate']=0;
$_SESSION['adminValidate']=0;
//also added to accessDenied.php for paranoia mode
header('location:../login.php');

?>
