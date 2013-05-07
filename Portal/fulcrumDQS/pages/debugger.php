<?php include "../phpScripts/accessConfirmation.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Debugger</title>
<style type="text/css">
#tableHeader{
	background-image: url(../images/Fulcrum.jpg);
	background-color:#FFF;
	background-repeat: no-repeat;
	background-attachment: scroll;
	background-position: bottom;
	text-align: right;
	padding-right: 30px;
	padding-bottom: 5px;
}
.mainTables{
	margin: 0px;
	padding: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
}
#menuTitCell{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 22px;
	color: #333;
	height: 33px;
	text-align: right;
	padding-top: 0px;
	padding-right: 50px;
}
#menuTable{
	padding-top: 0px;
	margin-top: 0px;
}
#menuMainCell{
	vertical-align: top;
        min-width: 235px;
}
.optionCells{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 16px;
	text-align: right;
	padding-right: 60px;
	height: 30px;
	padding-top: 12px;
	background-attachment: scroll;
	background-repeat: no-repeat;
	background-position: bottom;
	background-image: url(../images/options.jpg);
}
.links
{
	text-decoration:none;
	color: #1885B4;
	font-family: Verdana, Geneva, sans-serif;
}
#bodyDivision
{
	background-attachment: scroll;
	background-image: url(../images/lineDiv.jpg);
	background-repeat: repeat-y;
	background-position: center center;
	height:555px;
}
.rightTitleCell{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 22px;
	color: #333;
	height: 33px;
}
#innerBodyTable{
	margin-left: 50px;
	font-family: Verdana, Geneva, sans-serif;
}
.subCatCells{
	border-top-color: #FFF;
	border-right-color: #FFF;
	border-bottom-color: #FFF;
	border-left-color: #FFF;
	border-top-width: 15px;
	border-bottom-width: 15px;
	font-family: Verdana, Geneva, sans-serif;
}
#innerBodyCell{
	vertical-align: top;
}
</style>
<script language="javascript" type="text/javascript">
function optionOn(option)
{
	option.style.backgroundImage="url(../images/optionSelect.jpg)";
	option.style.paddingRight = '50px';
}
function optionOff(option)
{
	option.style.backgroundImage="url(../images/options.jpg)";
	option.style.paddingRight = '60px';
}
function loading()
{
	page=document.getElementById("canvas");
	page.style.display="block";
}
</script>
<?php
    $applicationID=$_REQUEST['applicationID'];
    include '../phpScripts/dbConnect.php';
    dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
    $query="SELECT screen.`screen_ID`,screen.text,screen.`screen_no`,screen.`with_os_choice`,screen.`with_os_choice_next_screen`,section.`section_no` ".
    "FROM screen ".
    "INNER JOIN section ".
    "ON screen.`section_ID`=section.`section_ID` ".
    "WHERE section.`application_ID`='$applicationID' AND screen.type='Single selection, multiple choice Query'";
    $result=mysql_query($query) or die (mysql_error());
    $count=0;
    $data=  array();
    while($fetchedData=mysql_fetch_array($result))
    {
        $data[$count]=$fetchedData;
        $count++;
    }
    $count=0;
    $errorCounter=0;
    $screensWithErrorsCounter=0;
    unset ($_SESSION['errors']);
    while($count<count($data))
    {
        $smallFlag=0;
        $errorCounter=0;
        if($data[$count]['with_os_choice']==1)
        {
            $query="SELECT count(`screen_ID`) FROM screen WHERE `screen_ID`='{$data[$count]['with_os_choice_next_screen']}'";
            $result=mysql_query($query) or die(mysql_error());
            $fetchedCount=mysql_fetch_array($result);
            if($fetchedCount[0]<1)
            {
                $_SESSION['errors'][$count]=$data[$count];
                //$_SESSION['errors'][$count]['choices'][$errorCounter]['text']="*other_specify*";
                $choicesWithErrors[$errorCounter]['text']="*other_specify*";
                $smallFlag=1;
                $errorCounter++;
            }
            else if($data[$count]['with_os_choice_next_screen']==$data[$count]['screen_ID'])
            {
                $_SESSION['errors'][$count]=$data[$count];
                //$_SESSION['errors'][$count]['choices'][$errorCounter]['text']="*other_specify*";
                $choicesWithErrors[$errorCounter]['text']="*other_specify*";
                $smallFlag=1;
                $errorCounter++;
            }
        }
        $query="SELECT text,rank,`next_screen_ID` FROM choice WHERE `screen_ID`='{$data[$count]['screen_ID']}'";
        $result=mysql_query($query) or die (mysql_error());
        $choices=array ();
        $c=0;
        while($fetchedChoice=mysql_fetch_array($result))
        {
            $choices[$c]=$fetchedChoice;
            $c++;
        }
        $c=0;
        while($c<count($choices))
        {
            $query="SELECT count(`screen_ID`) FROM screen WHERE `screen_ID`='{$choices[$c]['next_screen_ID']}'";
            $result=mysql_query($query) or die(mysql_error());
            $fetchedCount=mysql_fetch_array($result);
            if($fetchedCount[0]<1)
            {
                 $_SESSION['errors'][$count]=$data[$count];
                 //$_SESSION['errors'][$count]['choices'][$errorCounter]['text']=$choices[$c]['text'];
                 //$_SESSION['errors'][$count]['choices'][$errorCounter]['rank']=$choices[$c]['rank'];
                 $choicesWithErrors[$errorCounter]['text']=$choices[$c]['text'];
                 $choicesWithErrors[$errorCounter]['rank']=$choices[$c]['rank'];
                 $smallFlag=1;
                 $errorCounter++;
            }
            else if($choices[$c]['next_screen_ID']==$data[$count]['screen_ID'])
            {
                $_SESSION['errors'][$count]=$data[$count];
                 //$_SESSION['errors'][$count]['choices'][$errorCounter]['text']=$choices[$c]['text'];
                 //$_SESSION['errors'][$count]['choices'][$errorCounter]['rank']=$choices[$c]['rank'];
                 $choicesWithErrors[$errorCounter]['text']=$choices[$c]['text'];
                 $choicesWithErrors[$errorCounter]['rank']=$choices[$c]['rank'];
                 $smallFlag=1;
                 $errorCounter++;
            }
            $c++;
        }
        if($smallFlag==1)
        {
            $_SESSION['errors'][$count]['choices']=$choicesWithErrors;
        }
        $count++;
    }
    if(!isset ($_SESSION['errors']))
    {
        $_SESSION['applicationOK']=1;
        echo "<meta http-equiv=\"refresh\" content=\"0;URL=reviewApplication.php\" />";
    }
    else
    {
        $_SESSION['applicationOK']=0;
    }
?>
</head>

<body onload="loading();">
<table width="100%" class="mainTables" id="canvas" style="display:none">
<tr><td id="tableHeader" width="1333" height="64" colspan="3">
<div style="height:25px"><?php
    $devUsername=$_COOKIE['developerUsername'];
    echo "<a class=\"links\" href=\"editDeveloperProfile.php\"><p>$devUsername</p></a>";
?></div>
<div><a href="../phpScripts/logout.php" class="links">logout</a></div>
</td></tr>
<tr>
<td width="18%" id="menuMainCell"><!--the menu-->
<table width="100%" class="mainTables" id="menuTable">
<tr><td id="menuTitCell"><p>Menu</p></td></tr>
<tr><td class="optionCells" id="applicationOpt" onmouseover="JavaScript:optionOn(this);" onmouseout="JavaScript:optionOff(this);">
<a class="links" href="applications.php" style="color:#333">Questionnaires</a>
</td></tr>
<tr><td class="optionCells" id="uGroupsOpt" onmouseover="JavaScript:optionOn(this);" onmouseout="JavaScript:optionOff(this);">
<a class="links" href="userGroups.php">Groups</a>
</td></tr>
<tr><td class="optionCells" id="respondentOpt" onmouseover="JavaScript:optionOn(this);" onmouseout="JavaScript:optionOff(this);">
<a class="links" href="fieldUsers.php">Respondents</a>
</td></tr>
<tr><td class="optionCells" id="adminOpt" onmouseover="JavaScript:optionOn(this);" onmouseout="JavaScript:optionOff(this);">
<a class="links" href="administratorVerification.php">Administration</a>
</td></tr>
</table>
</td>
<td id="bodyDivision"><!--LINE DIV-->
</td>
<td width="81%" id="innerBodyCell"><!--inner body-->
<table id="innerBodyTable" width="100%" class="mainTables">
<tr>
    <td height="104" class="rightTitleCell">
            <p>Results</p>
    </td>
</tr>
<tr>
    <td class="subCatCells">
        <?php
        $count=0;
        if(isset ($_SESSION['errors']))
        {
            echo "<div><p>You have logical errors in your Questionnaire</p></div><div>";
        while($count<count($_SESSION['errors']))
        {
            if(isset ($_SESSION['errors'][$count]['screen_ID']))
            {
                echo "<div>";
                echo "<a href=\"editScreen.php?screenID={$_SESSION['errors'][$count]['screen_ID']}\">";
                echo "On screen {$_SESSION['errors'][$count]['screen_no']}, located in section {$_SESSION['errors'][$count]['section_no']} :</br>";
                $c=0;
                if(isset ($_SESSION['errors'][$count]['choices']))
                {
                    while($c<count($_SESSION['errors'][$count]['choices']))
                    {
                        if($_SESSION['errors'][$count]['choices'][$c]['text']=="*other_specify*")
                        {
                            echo "    - The 'Other, specify' choice is pointing to nothing or to this question</br>";
                        }
                        else
                        {
                            $choiceNumber=$_SESSION['errors'][$count]['choices'][$c]['rank']+1;
                            echo "    - Choice number $choiceNumber ({$_SESSION['errors'][$count]['choices'][$c]['text']}) is pointing to nothing or to this question</br>" ;
                        }
                        $c++;
                    }
                }
                echo"</a>";
                echo "</div>";
            }
            $count++;
        }
        echo "</div>";
        }
        ?>
    </td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>