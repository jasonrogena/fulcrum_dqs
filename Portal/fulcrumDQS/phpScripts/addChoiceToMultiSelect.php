<?php
session_start();
if(isset ($_REQUEST['add']))
{
    $_SESSION['msChoiceArray']=array();
    if(isset ($_POST['addedChoices']))
    {
        $_SESSION['msChoiceArray']=$_POST['addedChoices'];
        $pointer=count($_SESSION['msChoiceArray']);
    }
    else
    {
        $pointer=0;
    }
    $_SESSION['msChoiceArray'][$pointer]=$_POST['choice'];
}
else if(isset ($_REQUEST['clearAll']))
{
    if(isset ($_SESSION['msChoiceArray']))
    {
        unset ($_SESSION['msChoiceArray']);
    }
}
header("location:../pages/addChoiceMultiSelect.php");
?>
