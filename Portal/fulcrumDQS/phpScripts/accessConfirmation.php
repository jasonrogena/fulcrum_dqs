<?php
    session_start();
    if($_SESSION['devValidate']!=1)
    {
        header("location:../pages/accessDenied.php");
    }
?>
