<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
if(isset ($_REQUEST['submit']))
{
    $flag=0;
	$_SESSION['fromACSSelect']['submit']=$_REQUEST['submit'];
    $_SESSION['fromACSSelect']['choice']=$_REQUEST['choice'];
    $_SESSION['fromACSSelect']['nextScreenSection']=$_REQUEST['nextScreenSection'];
    $_SESSION['fromACSSelect']['nextScreen']=$_REQUEST['nextScreen'];
    if(isset ($_REQUEST['addedChoices']))
    {
        $_SESSION['fromACSSelect']['addedChoices']=$_REQUEST['addedChoices'];
    }
    if($_REQUEST['choice']!="" && $_REQUEST['nextScreenSection']=="")//next section has not been specified
    {
        $flag=1;
        $_SESSION['nextScreenFlag']=1;
    }
    else if($_REQUEST['choice']!="" && $_REQUEST['nextScreen']=="")
    {
        $flag=1;
        $_SESSION['nextScreenFlag']=1;
    }
    else
    {
        $_SESSION['nextScreenFlag']=0;
    }
    if($_REQUEST['choice']=="" && $_REQUEST['nextScreenSection']!="")//choice text not entered
    {
        $flag=1;
        $_SESSION['choiceFlag']=1;
    }
    else
    {
        $_SESSION['choiceFlag']=0;
    }
    if($_REQUEST['choice']=="" && $_REQUEST['nextScreen']!="")//choice text not entered
    {
        $flag=1;
        $_SESSION['choiceFlag']=1;
    }
    else
    {
        $_SESSION['choiceFlag']=0;
    }
    if(ctype_digit($_REQUEST['nextScreenSection'])==false)//false if not integers only
    {
        $flag=1;
        $_SESSION['nextScreenFlag']=1;
    }
    else
    {
        $_SESSION['nextScreenFlag']=0;
    }
    if(ctype_digit($_REQUEST['nextScreen'])==false)
    {
        $flag=1;
        $_SESSION['nextScreenFlag']=1;
    }
    else
    {
        $_SESSION['nextScreenFlag']=0;
    }
    if($flag==0)
    {
        echo "<meta http-equiv=\"refresh\" content=\"0;URL=../phpScripts/addChoiceToSingleSelect.php\" />";
    }
}
else if(isset ($_REQUEST['clear']))
{
    $_SESSION['fromACSSelect']['clear']=$_REQUEST['clear'];
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=../phpScripts/addChoiceToSingleSelect.php\" />";
}
else
{
    $_SESSION['nextScreenFlag']=0;
    $_SESSION['choiceFlag']=0;
    unset ($_SESSION['fromACSSelect']['choice']);
    unset ($_SESSION['fromACSSelect']['nextScreenSection']);
    unset ($_SESSION['fromACSSelect']['nextScreen']);
    unset ($_SESSION['fromACSSelect']['addedChoices']);
    unset ($_SESSION['fromACSSelect']['clear']);
    unset ($_SESSION['fromACSSelect']['submit']);
}
?>
<title>Untitled Document</title>
</head>
<body>
    <form action="addChoiceSingleSelect.php" method="post">
    	<table width="739">
        	<tr>
            	<td width="92" height="45px">
                	<label for="choice">Add a Choice</label>
                </td>
                <td colspan="4">
                    <input type="text" name="choice" size="50" value="<?php
                    if(isset ($_SESSION['fromACSSelect']['choice']))
                    {
                        echo $_SESSION['fromACSSelect']['choice'];
                    }
                    ?>"/>
                        <?php
                            if(isset ($_SESSION['choiceFlag']) && $_SESSION['choiceFlag']==1)
                            {
                                echo "<font color=\"red\">Specify the Choice</font>";
                            }
                        ?>
                </td>
            </tr>
            <tr>
            	<td height="45px">
                	<label for="nextScreenSection">Next Screen</label>
                </td>
                <td width="59">
                    <input type="text" name="nextScreenSection" title="enter the section number for the next screen here" size="2" value="<?php
                    if(isset ($_SESSION['fromACSSelect']['nextScreenSection']))
                    {
                        echo $_SESSION['fromACSSelect']['nextScreenSection'];
                    }
                    ?>"/>
                    <label for="nextScreen">:</label>
                </td>
                <td width="383">
                    <input type="text" name="nextScreen" title="enter the screen number for the next screen here" size="2" value="<?php
                    if(isset ($_SESSION['fromACSSelect']['nextScreen']))
                    {
                        echo $_SESSION['fromACSSelect']['nextScreen'];
                    }
                    ?>"/>
                        <?php
                            if(isset ($_SESSION['nextScreenFlag']) && $_SESSION['nextScreenFlag']==1)
                            {
                                echo "<font color=\"red\">Specify next screen correctly</font>";
                            }
                        ?>
                </td>
                <td width="185">
                    <input type="submit" value="Add Choice" name="submit"/>
                </td>
            </tr>
            <tr>
            	<td colspan="5">
                	<fieldset>
                    	<legend>Choices Already added</legend>
                        <?php
                            if(isset ($_SESSION['ssChoiceArray']))
                            {
                                $size=count($_SESSION['ssChoiceArray']);
                                $count=0;
                                $checker=$_SESSION['applicationID']." - ";//checks if the option has been removed
                                while($count<$size)
                                {

                                    if($_SESSION['ssChoiceArray'][$count]!=$checker)
                                    {
                                        echo "<input type=\"checkbox\" name=\"addedChoices[]\" checked value=\"".$_SESSION['ssChoiceArray'][$count]."\">".$_SESSION['ssChoiceArray'][$count]."</input> <br/>";
                                    }
                                    $count=$count+1;
                                }
                            }
                        ?>
                    </fieldset>

                </td>
            </tr>
            <tr>
            	<td colspan="5" style="text-align:right; padding-right:100px" height="45px">
                	<input type="submit" value="Clear all Choices" name="clear"/>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>