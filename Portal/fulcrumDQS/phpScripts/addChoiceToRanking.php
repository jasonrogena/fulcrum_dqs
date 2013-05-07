<?php
//if(isset ($_POST['addedChoices']))
//{
    session_start();
    if(isset ($_REQUEST['add']))
    {
        $_SESSION['cChoiceArray']=array();
        if(isset ($_POST['addedChoices']))
        {
            $_SESSION['cChoiceArray']=$_POST['addedChoices'];
            $pointer=count($_SESSION['cChoiceArray']);
        }
        else
        {
            $pointer=0;
        }
        $_SESSION['cChoiceArray'][$pointer]=$_POST['choice'];
    }
    else if(isset ($_REQUEST['clear']))
    {
        if(isset ($_SESSION['cChoiceArray']))
        {
            unset ($_SESSION['cChoiceArray']);
        }
    }
//}
header("location:../pages/addChoiceRanking.php");
?>
