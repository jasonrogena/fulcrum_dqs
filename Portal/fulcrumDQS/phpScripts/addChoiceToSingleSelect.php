<?php
//if(isset ($_POST['addedChoices']))
//{
session_start();
if(isset ($_SESSION['fromACSSelect']['submit']))
{
    $_SESSION['ssChoiceArray']=array();
    if(isset ($_SESSION['fromACSSelect']['addedChoices']))
    {
        $_SESSION['ssChoiceArray']=$_SESSION['fromACSSelect']['addedChoices'];
        $pointer=count($_SESSION['ssChoiceArray']);
    }
    else
    {
        $pointer=0;
    }
    $_SESSION['ssChoiceArray'][$pointer]=$_SESSION['applicationID'].$_SESSION['fromACSSelect']['nextScreenSection'].$_SESSION['fromACSSelect']['nextScreen']." - ".$_SESSION['fromACSSelect']['choice'];
}
else if(isset ($_SESSION['fromACSSelect']['clear']))
{
    if(isset ($_SESSION['ssChoiceArray']))
    {
        unset ($_SESSION['ssChoiceArray']);
    }
}
//}
header("location:../pages/addChoiceSingleSelect.php");
?>
