<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php
if(!isset ($_SESSION['mFlag']) || $_SESSION['mFlag']!=1)
{
    include '../phpScripts/dbConnect.php';
    dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
    $query="SELECT text FROM choice WHERE `screen_ID`='{$_SESSION['editScreen']['screenID']}'";
    $result=mysql_query($query) or die (mysql_error());
    $count=0;
    while($fetchedChoice=mysql_fetch_array($result))
    {
        $_SESSION['msChoiceArray'][$count]=$fetchedChoice['text'];
        $count++;
    }
    $query="SELECT `application_ID` FROM section WHERE `section_ID`='{$_SESSION['editScreen']['sectionID']}'";
    $result=mysql_query($query) or die (mysql_error());
    $fetchedApplication=mysql_fetch_array($result);
    $_SESSION['editScreen']['applicationID']=$fetchedApplication['application_ID'];
    $_SESSION['mFlag']=1;
}
?>
</head>
<body>
	<form action="../phpScripts/addChoiceToMultiSelect.php" method="post">
    	<table width="739">
        	<tr>
            	<td width="129" height="45px">
                	<label for="choice">Add a Choice</label>
                </td>
                <td colspan="3">
                	<input type="text" size="50" name="choice" />
                </td>
                <td width="190">
                	<input type="submit" value="Add Choice" />
                </td>
            </tr>
            <tr>
            	<td colspan="5">
                	<fieldset>
                    	<legend>Choices Already added</legend>
                        <?php
                            if(isset ($_SESSION['msChoiceArray']))
                            {
                                $size=count($_SESSION['msChoiceArray']);
                                $count=0;
                                $checker="";//checks if the option has been removed
                                while($count<$size)
                                {

                                    if($_SESSION['msChoiceArray'][$count]!=$checker)
                                    {
                                        echo "<input type=\"checkbox\" name=\"addedChoices[]\" checked value=\"".$_SESSION['msChoiceArray'][$count]."\">".$_SESSION['msChoiceArray'][$count]."</input> <br/>";
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
                    <input type="submit" name="clearAll" value="Clear all Choices"/>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>