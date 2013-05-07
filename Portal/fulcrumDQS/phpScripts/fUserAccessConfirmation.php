<?php
    session_start();
    if($_SESSION['fieldUserValidate']!=1)
    {
        header("location:../pages/accessDenied.php");
    }
?>
