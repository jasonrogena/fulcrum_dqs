<?php
    session_start();
    if($_SESSION['adminValidate']!=1)
    {
        header("location:../pages/accessDenied.php");
    }
?>
