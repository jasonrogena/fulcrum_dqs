<?php include"../phpScripts/accessConfirmation.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
if(isset ($_REQUEST['screenID']))
{
    $screenID=$_REQUEST['screenID'];
    include '../phpScripts/dbConnect.php';
    dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
    $screenID=mysql_real_escape_string($screenID);
    $query="SELECT * FROM screen WHERE `screen_ID`='$screenID'";
    $result=mysql_query($query) or die (mysql_error());
    $fetchedSecreen=mysql_fetch_array($result);
    $_SESSION['editScreen']['screenID']=$fetchedSecreen['screen_ID'];
    $_SESSION['editScreen']['screenNo']=$fetchedSecreen['screen_no'];
    $_SESSION['editScreen']['type']=$fetchedSecreen['type'];
    $_SESSION['editScreen']['heading']=$fetchedSecreen['heading'];
    $_SESSION['editScreen']['text']=$fetchedSecreen['text'];
    $_SESSION['editScreen']['nextScreen']=$fetchedSecreen['next_screen_ID'];
    $_SESSION['editScreen']['wOS']=$fetchedSecreen['with_os_choice'];
    $_SESSION['editScreen']['wOSNextScreen']=$fetchedSecreen['with_os_choice_next_screen'];
    $_SESSION['editScreen']['listSize']=$fetchedSecreen['list_size'];
    $_SESSION['editScreen']['responseLength']=$fetchedSecreen['response_length'];
    $_SESSION['editScreen']['dTFormat']=$fetchedSecreen['date_time_format'];
    $_SESSION['editScreen']['sectionID']=$fetchedSecreen['section_ID'];
    $query="SELECT `section_no` FROM section WHERE `section_ID`={$_SESSION['editScreen']['sectionID']}";
    $result=mysql_query($query) or die (mysql_error());
    $fetchedSectionNo=mysql_fetch_array($result);
    $_SESSION['editScreen']['sectionNo']=$fetchedSectionNo['section_no'];
    $query="SELECT `screen_no`,`section_ID` from screen WHERE `screen_ID`='{$fetchedSecreen['with_os_choice_next_screen']}'";
    $result=mysql_query($query) or die (mysql_error());
    $fetchedNextScreen=mysql_fetch_array($result);
    $_SESSION['editScreen']['nextScreenNo']=$fetchedNextScreen['screen_no'];
    $query="SELECT `section_no` FROM section WHERE `section_ID`='{$fetchedNextScreen['section_ID']}'";
    $result=mysql_query($query) or die (mysql_error());
    $fetchedNextSection=mysql_fetch_array($result);
    $_SESSION['editScreen']['nextSectionNo']=$fetchedNextSection['section_no'];
}
    if(isset ($_REQUEST['submitForm']))
    {
        $flag=0;
        $_SESSION['fromEditScreen']['screenType']=$_REQUEST['screenType'];
        $_SESSION['fromEditScreen']['submitForm']=$_REQUEST['submitForm'];
        if($_REQUEST['screenType']==1)//information screen
        {
            $_SESSION['fromEditScreen']['infoHeading']=$_REQUEST['infoHeading'];
            $_SESSION['fromEditScreen']['infoText']=$_REQUEST['infoText'];
            if($_REQUEST['infoHeading']=="")
            {
                $_SESSION['fromEditScreen']['infoHeading']=" ";
            }
            if($_REQUEST['infoText']=="")
            {
                $flag=1;
                $_SESSION['infoTextNullFlag']=1;
            }
            else
            {
                $_SESSION['infoTextNullFlag']=0;
            }
            if(strlen($_REQUEST['infoHeading'])>97)
            {
                $flag=1;
                $_SESSION['infoHeadinExcessFlag']=1;
            }
            else
            {
                $_SESSION['infoHeadinExcessFlag']=0;
            }
            if(strlen($_REQUEST['infoText'])>250)
            {
                $flag=1;
                $_SESSION['infoTextExcessFlag']=1;
            }
            else
            {
                $_SESSION['infoTextExcessFlag']=0;
            }
        }
        else if($_REQUEST['screenType']==2)//single select question
        {
            $_SESSION['fromEditScreen']['singleSelectQuestion']=$_REQUEST['singleSelectQuestion'];
            if(isset ($_REQUEST['ssWithOSpecify']))
            {
                $_SESSION['fromEditScreen']['ssWithOSpecify']=$_REQUEST['ssWithOSpecify'];
                $_SESSION['fromEditScreen']['wOSNextScreenSection']=$_REQUEST['wOSNextScreenSection'];
                $_SESSION['fromEditScreen']['wOSNextScreen']=$_REQUEST['wOSNextScreen'];
            }
            if($_REQUEST['singleSelectQuestion']=="")
            {
                $flag=1;
                $_SESSION['sSQuestionNullFlag']=1;
            }
            else
            {
                $_SESSION['sSQuestionNullFlag']=0;
            }
            if(strlen($_REQUEST['singleSelectQuestion'])>250)
            {
                $flag=1;
                $_SESSION['sSQuestionExcessFlag']=1;
            }
            else
            {
                $_SESSION['sSQuestionExcessFlag']=0;
            }
            if(ctype_digit($_REQUEST['wOSNextScreenSection'])==false && isset ($_REQUEST['ssWithOSpecify']))
            {
                $flag=1;
                $_SESSION['nextSectionTypeFlag']=1;
            }
            else
            {
                $_SESSION['nextSectionTypeFlag']=0;
            }
            if(ctype_digit($_REQUEST['wOSNextScreen'])==false && isset ($_REQUEST['ssWithOSpecify']))
            {
                $flag=1;
                $_SESSION['nextSectionTypeFlag']=1;
            }
            else
            {
                $_SESSION['nextSectionTypeFlag']=0;
            }
        }
        else if($_REQUEST['screenType']==3)//multi select
        {
            $_SESSION['fromEditScreen']['multiSelectQuestion']=$_REQUEST['multiSelectQuestion'];
            if(isset ($_REQUEST['msWithOSpecify']))
            {
                $_SESSION['fromEditScreen']['msWithOSpecify']=$_REQUEST['msWithOSpecify'];
            }
            if(strlen($_REQUEST['multiSelectQuestion'])>250)
            {
                $flag=1;
                $_SESSION['mSQuestionExcessFlag']=1;
            }
            else
            {
                $_SESSION['mSQuestionExcessFlag']=0;
            }
            if($_REQUEST['multiSelectQuestion']=="")
            {
                $flag=1;
                $_SESSION['mSQuestionNullFlag']=1;
            }
            else
            {
                $_SESSION['mSQuestionNullFlag']=0;
            }
        }
        else if($_REQUEST['screenType']==4)//list
        {
            $_SESSION['fromEditScreen']['listQuestion']=$_REQUEST['listQuestion'];
            $_SESSION['fromEditScreen']['listSize']=$_REQUEST['listSize'];
            $_SESSION['fromEditScreen']['listResponseLength']=$_REQUEST['listResponseLength'];
            if($_REQUEST['listQuestion']=="")
            {
                $flag=1;
                $_SESSION['listQuestionNullFlag']=1;
            }
            else
            {
                $_SESSION['listQuestionNullFlag']=0;
            }
            if(strlen($_REQUEST['listQuestion'])>250)
            {
                $flag=1;
                $_SESSION['listQuestionExcessFlag']=1;
            }
            else
            {
                $_SESSION['listQuestionExcessFlag']=0;
            }
            if(ctype_digit($_REQUEST['listSize'])==false)
            {
                $flag=1;
                $_SESSION['listSizeTypeFlag']=1;
            }
            else
            {
                $_SESSION['listSizeTypeFlag']=0;
            }
            if($_REQUEST['listSize']>10 || $_REQUEST['listSize']<2)
            {
                $flag=1;
                $_SESSION['listSizeMaxFlag']=1;
            }
            else
            {
                $_SESSION['listSizeMaxFlag']=0;
            }
            if(ctype_digit($_REQUEST['listResponseLength'])==false)
            {
                $flag=1;
                $_SESSION['listResponseLengthFlag']=1;
            }
            else
            {
                $_SESSION['listResponseLengthFlag']=0;
            }
            if($_REQUEST['listResponseLength']>240)
            {
                $flag=1;
                $_SESSION['listRLengthExcessFlag']=1;
            }
            else
            {
                $_SESSION['listRLengthExcessFlag']=0;
            }
            if($_REQUEST['listResponseLength']==0)
            {
                $flag=1;
                $_SESSION['listRLengthExcessFlag']=1;
            }
            else
            {
                $_SESSION['listRLengthExcessFlag']=0;
            }
        }
        else if($_REQUEST['screenType']==5)
        {
            $_SESSION['fromEditScreen']['openEndedQuestion']=$_REQUEST['openEndedQuestion'];
            $_SESSION['fromEditScreen']['openEndedResponseLength']=$_REQUEST['openEndedResponseLength'];
            if(strlen($_REQUEST['openEndedQuestion'])>250)
            {
                $flag=1;
                $_SESSION['oEQuestionExcessFlag']=1;
            }
            else
            {
                $_SESSION['oEQuestionExcessFlag']=0;
            }
            if($_REQUEST['openEndedQuestion']=="")
            {
                $flag=1;
                $_SESSION['oEQuestionNullFlag']=1;
            }
            else
            {
                $_SESSION['oEQuestionNullFlag']=0;
            }
            if(ctype_digit($_REQUEST['openEndedResponseLength'])==false)
            {
                $flag=1;
                $_SESSION['oEQResponseTypeFlag']=1;
            }
            else
            {
                $_SESSION['oEQResponseTypeFlag']=0;
            }
            if($_REQUEST['openEndedResponseLength']>250)
            {
                $flag=1;
                $_SESSION['oEQResponseExcessFlag']=1;
            }
            else
            {
                $_SESSION['oEQResponseExcessFlag']=0;
            }
            if($_REQUEST['openEndedResponseLength']==0)
            {
                $flag=1;
                $_SESSION['oEQResponseExcessFlag']=1;
            }
            else
            {
                $_SESSION['oEQResponseExcessFlag']=0;
            }
        }
        else if($_REQUEST['screenType']==6)
        {
            $_SESSION['fromEditScreen']['rankingQuestion']=$_REQUEST['rankingQuestion'];
            $_SESSION['fromEditScreen']['rankingSizeOfList']=$_REQUEST['rankingSizeOfList'];
            if(strlen($_REQUEST['rankingQuestion'])>250)
            {
                $flag=1;
                $_SESSION['rankingQExcessFlag']=1;
            }
            else
            {
                $_SESSION['rankingQExcessFlag']=0;
            }
            if($_REQUEST['rankingQuestion']=="")
            {
                $flag=1;
                $_SESSION['rankingQNullFlag']=1;
            }
            else
            {
                $_SESSION['rankingQNullFlag']=0;
            }
            if(ctype_digit($_REQUEST['rankingSizeOfList'])==false)
            {
                $flag=1;
                $_SESSION['rankingQTypeFlag']=1;
            }
            else
            {
                $_SESSION['rankingQTypeFlag']=0;
            }
        }
        else if($_REQUEST['screenType']==7)
        {
            $_SESSION['fromEditScreen']['dateTimeQuestion']=$_REQUEST['dateTimeQuestion'];
            $_SESSION['fromEditScreen']['datetimetype']=$_REQUEST['datetimetype'];
            if($_REQUEST['dateTimeQuestion']=="")
            {
                $flag=1;
                $_SESSION['dateTimeQNullFlag']=1;
            }
            else
            {
                $_SESSION['dateTimeQNullFlag']=0;
            }
            if(strlen($_REQUEST['dateTimeQuestion'])>250)
            {
                $flag=1;
                $_SESSION['dateTimeQuestionExcessFlag']=1;
            }
            else
            {
                $_SESSION['dateTimeQuestionExcessFlag']=0;
            }
        }
        if($flag==0)
        {
            echo "<meta http-equiv=\"refresh\" content=\"0;URL=../phpScripts/updateScreen.php\" />";
        }
    }
    else
    {
        unset ($_SESSION['fromEditScreen']['screenType']);//
        unset ($_SESSION['fromEditScreen']['infoHeading']);//
        unset ($_SESSION['fromEditScreen']['infoText']);//
        unset ($_SESSION['fromEditScreen']['singleSelectQuestion']);//
        unset ($_SESSION['fromEditScreen']['ssWithOSpecify']);//
        unset ($_SESSION['fromEditScreen']['wOSNextScreenSection']);//
        unset ($_SESSION['fromEditScreen']['wOSNextScreen']);//
        unset ($_SESSION['fromEditScreen']['multiSelectQuestion']);//
        unset ($_SESSION['fromEditScreen']['msWithOSpecify']);//
        unset ($_SESSION['fromEditScreen']['listQuestion']);//
        unset ($_SESSION['fromEditScreen']['listSize']);//
        unset ($_SESSION['fromEditScreen']['listResponseLength']);//
        unset ($_SESSION['fromEditScreen']['openEndedQuestion']);//
        unset ($_SESSION['fromEditScreen']['openEndedResponseLength']);//
        unset ($_SESSION['fromEditScreen']['rankingQuestion']);//
        unset ($_SESSION['fromEditScreen']['rankingSizeOfList']);//
        unset ($_SESSION['fromEditScreen']['dateTimeQuestion']);//
        unset ($_SESSION['fromEditScreen']['datetimetype']);
        $_SESSION['infoTextNullFlag']=0;
        $_SESSION['infoHeadinExcessFlag']=0;
        $_SESSION['infoTextExcessFlag']=0;
        $_SESSION['sSQuestionNullFlag']=0;
        $_SESSION['sSQuestionExcessFlag']=0;
        $_SESSION['nextSectionTypeFlag']=0;
        $_SESSION['nextSectionTypeFlag']=0;
        $_SESSION['mSQuestionExcessFlag']=0;
        $_SESSION['mSQuestionNullFlag']=0;
        $_SESSION['listQuestionNullFlag']=0;
        $_SESSION['listQuestionExcessFlag']=0;
        $_SESSION['listSizeTypeFlag']=0;
        $_SESSION['listResponseLengthFlag']=0;
        $_SESSION['oEQuestionExcessFlag']=0;
        $_SESSION['oEQuestionNullFlag']=0;
        $_SESSION['oEQResponseTypeFlag']=0;
        $_SESSION['rankingQExcessFlag']=0;
        $_SESSION['rankingQNullFlag']=0;
        $_SESSION['rankingQTypeFlag']=0;
        $_SESSION['dateTimeQNullFlag']=0;
        $_SESSION['dateTimeQuestionExcessFlag']=0;
        $_SESSION['oEQResponseExcessFlag']=0;
        $_SESSION['listRLengthExcessFlag']=0;
        $_SESSION['listSizeMaxFlag']=0;
    }
?>
<script language="javascript" type="text/javascript">
    function screenChooser()
    {
        info=document.getElementById('infoScreen');
        single=document.getElementById('singleSelect');
        multi=document.getElementById('multiSelect');
        list=document.getElementById('listQuery');
        openEnded=document.getElementById('openEndedQuery');
        ranker=document.getElementById('ranking');
        typeField=document.getElementById('sT');
        dateTime=document.getElementById('dateTime');
        if(typeField.value==3)//multi select
        {
            info.style.display="none";
            single.style.display="none";
            multi.style.display="block";
            list.style.display="none";
            openEnded.style.display="none";
            ranker.style.display="none";
            dateTime.style.display="none";
        }
        else if(typeField.value==1)//information
        {
            info.style.display="block";
            single.style.display="none";
            multi.style.display="none";
            list.style.display="none";
            openEnded.style.display="none";
            ranker.style.display="none";
            dateTime.style.display="none";
        }
        else if(typeField.value==2)//single select
        {
            info.style.display="none";
            single.style.display="block";
            multi.style.display="none";
            list.style.display="none";
            openEnded.style.display="none";
            ranker.style.display="none";
            dateTime.style.display="none";
        }
        else if(typeField.value==4)//list
        {
            info.style.display="none";
            single.style.display="none";
            multi.style.display="none";
            list.style.display="block";
            openEnded.style.display="none";
            ranker.style.display="none";
            dateTime.style.display="none";
        }
        else if(typeField.value==5)//open ended
        {
            info.style.display="none";
            single.style.display="none";
            multi.style.display="none";
            list.style.display="none";
            openEnded.style.display="block";
            ranker.style.display="none";
            dateTime.style.display="none";
        }
        else if(typeField.value==6)//ranking
        {
            info.style.display="none";
            single.style.display="none";
            multi.style.display="none";
            list.style.display="none";
            openEnded.style.display="none";
            ranker.style.display="block";
            dateTime.style.display="none";
        }

        else if(typeField.value==7)
        {
            info.style.display="none";
            single.style.display="none";
            multi.style.display="none";
            list.style.display="none";
            openEnded.style.display="none";
            ranker.style.display="none";
            dateTime.style.display="block";
        }
    }
</script>
<title>Edit a Screen</title>
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
.questionTables{
	width:100%
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
            <p>Edit Screen <?php echo $_SESSION['editScreen']['screenNo'];?> in Section <?php echo $_SESSION['editScreen']['sectionNo'];?></p>
    </td>
</tr>
<form action="editScreen.php" method="post">
<tr>
    <td class="subCatCells">
         <div style="height:45px">
            <label for="screenType">Type of Screen</label>
            <select name="screenType" id="sT" onchange="JavaScript:screenChooser();">
                <option value="1" <?php
                if(isset ($_SESSION['fromEditScreen']['screenType']) && $_SESSION['fromEditScreen']['screenType']==1)
                {
                    echo "selected";
                }
                else if($_SESSION['editScreen']['type']=="Information Screen")
                {
                    echo "selected";
                }
                    ?>>Information Screen</option>
                <option value="2" <?php
                if(isset ($_SESSION['fromEditScreen']['screenType']) && $_SESSION['fromEditScreen']['screenType']==2)
                {
                    echo "selected";
                }
                else if($_SESSION['editScreen']['type']=="Single selection, multiple choice Query")
                {
                    echo "selected";
                }
                    ?>>Single selection, multiple choice Query</option>
                <option value="3" <?php
                if(isset ($_SESSION['fromEditScreen']['screenType']) && $_SESSION['fromEditScreen']['screenType']==3)
                {
                    echo "selected";
                }
                else if($_SESSION['editScreen']['type']=="Multiple selection, multiple choice Query")
                {
                    echo "selected";
                }
                    ?>>Multiple selection, multiple choice Query</option>
                <option value="4" <?php
                if(isset ($_SESSION['fromEditScreen']['screenType']) && $_SESSION['fromEditScreen']['screenType']==4)
                {
                    echo "selected";
                }
                else if($_SESSION['editScreen']['type']=="List response Query")
                {
                    echo "selected";
                }
                    ?>>List response Query</option>
                <option value="5" <?php
                if(isset ($_SESSION['fromEditScreen']['screenType']) && $_SESSION['fromEditScreen']['screenType']==5)
                {
                    echo "selected";
                }
                else if($_SESSION['editScreen']['type']=="Open ended Question")
                {
                    echo "selected";
                }
                    ?>>Open ended Question</option>
                <option value="6" <?php
                if(isset ($_SESSION['fromEditScreen']['screenType']) && $_SESSION['fromEditScreen']['screenType']==6)
                {
                    echo "selected";
                }
                else if($_SESSION['editScreen']['type']=="Ranking Query")
                {
                    echo "selected";
                }
                    ?>>Ranking Query</option>
                <option value="7" <?php
                if(isset ($_SESSION['fromEditScreen']['screenType']) && $_SESSION['fromEditScreen']['screenType']==7)
                {
                    echo "selected";
                }
                else if($_SESSION['editScreen']['type']=="DateTime Query")
                {
                    echo "selected";
                }
                    ?>>DateTime Query</option>
            </select>
        </div>
        <div id="infoScreen" style = "display:block;">
            <table class="questionTables">
                <tr><td width="13%" height="45px">
                <label for="infoHeading">Heading</label>
                    </td>
                    <td width="87%">
                <input type="text" name="infoHeading" size="58" value="<?php
                if(isset ($_SESSION['fromEditScreen']['infoHeading']))
                {
                    echo $_SESSION['fromEditScreen']['infoHeading'];
                }
                else
                {
                    echo $_SESSION['editScreen']['heading'];
                }?>"></input>
                <?php
                if(isset ($_SESSION['infoHeadinExcessFlag']) && $_SESSION['infoHeadinExcessFlag']==1)
                {
                    echo "<font color=\"red\">Heading too long</font>";
                }
                ?>
                    </td>
                </tr>
            <tr><td height="45px">
                <label for="infoText">Text</label>
                </td>
                <td>
                <textarea cols="45" rows="2" name="infoText"><?php
                if(isset ($_SESSION['fromEditScreen']['infoText']))
                {
                    echo $_SESSION['fromEditScreen']['infoText'];
                }
                else
                {
                    echo $_SESSION['editScreen']['text'];
                }?></textarea>
                <?php
                if(isset ($_SESSION['infoTextNullFlag']) && $_SESSION['infoTextNullFlag']==1)
                {
                    echo "<font color=\"red\">Enter the text</font>";
                }
                else if(isset ($_SESSION['infoTextExcessFlag']) && $_SESSION['infoTextExcessFlag']==1)
                {
                    echo "<font color=\"red\">Text too long</font>";
                }
                ?>
                </td>
            </tr>
            </table>
        </div>
        <div id="singleSelect" style="display: none">
            <table class="questionTables">
            <tr><td width="13%">
                <label for="singleSelectQuestion">Question</label>
                </td><td width="87%">
                <textarea cols="45" rows="2" name="singleSelectQuestion"><?php
                if(isset ($_SESSION['fromEditScreen']['singleSelectQuestion']))
                {
                    echo $_SESSION['fromEditScreen']['singleSelectQuestion'];
                }
                else
                {
                    echo $_SESSION['editScreen']['text'];
                }?></textarea>
                <?php
                if(isset ($_SESSION['sSQuestionNullFlag']) && $_SESSION['sSQuestionNullFlag']==1)
                {
                    echo "<font color=\"red\">Enter Question</font>";
                }
                else if(isset ($_SESSION['sSQuestionExcessFlag']) && $_SESSION['sSQuestionExcessFlag']==1)
                {
                    echo "<font color=\"red\">Question too long</font>";
                }
                ?>
                </td>
            </tr>
            <tr><td colspan="2">
            <table width="100%">
                <tr>
                    <td height="220px">
                        <iframe src="editChoiceSingleSelect.php" scrolling="yes" width="100%" frameborder="0" height="100%"></iframe>
                    </td>
                </tr>
            </table>
                </td>
            </tr>
            <tr><td colspan="2">
            <table width="100%">
            	<tr><td width="36%" style="height:45px">
                <label for="ssWithOSpecify">With 'Other, Specify ______' choice </label>
                <input type="checkbox" name="ssWithOSpecify" <?php
                if(isset ($_SESSION['fromEditScreen']['ssWithOSpecify']))
                {
                    echo "checked";
                }
                else if($_SESSION['editScreen']['wOS']==1)
                {
                    echo "checked";
                }
                    ?>></input>
                </td>
                <td width="64%">
                <label for="wOSNextScreenSection">Next screen</label>
                <input type="text" name="wOSNextScreenSection" title="enter the section number for the next screen here" size="2" value="<?php
                if(isset ($_SESSION['fromEditScreen']['wOSNextScreenSection']))
                {
                    echo $_SESSION['fromEditScreen']['wOSNextScreenSection'];
                }
                else if($_SESSION['editScreen']['wOS']==1)
                {
                    echo $_SESSION['editScreen']['nextSectionNo'];
                }
                ?>"></input>
                <label for="wOSNextScreen"> : </label>
                <input type="text" name="wOSNextScreen" title="enter the screen number for the next screen here" size="2" value="<?php
                if(isset ($_SESSION['fromEditScreen']['wOSNextScreen']))
                {
                    echo $_SESSION['fromEditScreen']['wOSNextScreen'];
                }
                else if($_SESSION['editScreen']['wOS']==1)
                {
                    echo $_SESSION['editScreen']['nextScreenNo'];
                }
                ?>"></input>
                <?php
                if(isset ($_SESSION['nextSectionTypeFlag']) && $_SESSION['nextSectionTypeFlag']==1)
                {
                    echo "<font color=\"red\">Digits only</font>";
                }
                ?>
                </td></tr>
                </table>
                </td>
            </tr>
            </table>
        </div>
        <div id="multiSelect" style="display: none">
            <table class="questionTables">
            <tr><td width="13%">
                <label for="multiSelectQuestion">Question</label>
                </td>
                <td width="87%">
                <textarea cols="45" rows="2" name="multiSelectQuestion"><?php
                if(isset ($_SESSION['fromEditScreen']['multiSelectQuestion']))
                {
                    echo $_SESSION['fromEditScreen']['multiSelectQuestion'];
                }
                else
                {
                    echo $_SESSION['editScreen']['text'];
                }?></textarea>
                <?php
                if(isset ($_SESSION['mSQuestionExcessFlag']) && $_SESSION['mSQuestionExcessFlag']==1)
                {
                    echo "<font color=\"red\">Question too long</font>";
                }
                else if(isset ($_SESSION['mSQuestionNullFlag']) && $_SESSION['mSQuestionNullFlag']==1)
                {
                    echo "<font color=\"red\">Enter question</font>";
                }
                ?>
                </td>
            </tr>
            <tr><td colspan="2">
            <table width="100%">
                <tr>
                    <td>
                        <iframe src="editChoiceMultiSelect.php" scrolling="yes" width="100%" frameborder="0" height="100%"></iframe>
                    </td>
                </tr>
            </table>
                </td>
            </tr>
            <tr><td colspan="2">
            <table width="100%">
            <tr><td width="32%" style="height:45px">
                <label for="msWithOSpecify">With 'Other, Specify ______' choice </label>
                </td>
                <td width="68%">
            <input type="checkbox" name="msWithOSpecify" <?php
            if(isset ($_SESSION['fromEditScreen']['msWithOSpecify']))
            {
                echo "checked";
            }
            else if($_SESSION['editScreen']['wOS']==1)
            {
                echo "checked";
            }
            ?>></input>
            </td></tr></table>
                </td>
            </tr>
            </table>
        </div>
    <div id="listQuery" style="display: none">
        <table class="questionTables">
            <tr><td width="20%">
            <label for="listQuestion">Question</label>
                </td>
                <td width="80%">
            <textarea cols="45" rows="2" name="listQuestion"><?php
            if(isset ($_SESSION['fromEditScreen']['listQuestion']))
            {
                echo $_SESSION['fromEditScreen']['listQuestion'];
            }
            else
            {
                echo $_SESSION['editScreen']['text'];
            }?></textarea>
            <?php
            if(isset ($_SESSION['listQuestionNullFlag']) && $_SESSION['listQuestionNullFlag']==1)
            {
                echo "<font color=\"red\">Enter question</font>";
            }
            else if(isset ($_SESSION['listQuestionExcessFlag']) && $_SESSION['listQuestionExcessFlag']==1)
            {
                echo "<font color=\"red\">Question too long</font>";
            }
            ?>
                </td>
            </tr>
        <tr><td height="45px">
            <label for="listSize">Size of the list</label>
            </td>
            <td>
            <input type="text" name="listSize" size="2" value="<?php
            if(isset ($_SESSION['fromEditScreen']['listSize']))
            {
                echo $_SESSION['fromEditScreen']['listSize'];
            }
            else
            {
                echo $_SESSION['editScreen']['listSize'];
            }?>"></input>
            <?php
            if(isset ($_SESSION['listSizeTypeFlag']) && $_SESSION['listSizeTypeFlag']==1)
            {
                echo "<font color=\"red\">Enter digits only</font>";
            }
            else if(isset ($_SESSION['listSizeMaxFlag']) && $_SESSION['listSizeMaxFlag']==1)
            {
                echo "<font color=\"red\">Can only be between 2 and 10</font>";
            }
            ?>
            </td>
        </tr>
        <tr><td height="45px">
            <label for="listResponseLength">Length of a Response</label>
            </td>
            <td>
            <input type="text" name="listResponseLength" size="2" value="<?php
            if(isset ($_SESSION['fromEditScreen']['listResponseLength']))
            {
                echo $_SESSION['fromEditScreen']['listResponseLength'];
            }
            else
            {
                echo $_SESSION['editScreen']['responseLength'];
            }?>"></input>
            <?php
            if(isset ($_SESSION['listResponseLengthFlag']) && $_SESSION['listResponseLengthFlag']==1)
            {
                echo "<font color=\"red\">Enter digits only</font>";
            }
            else if(isset ($_SESSION['listRLengthExcessFlag']) && $_SESSION['listRLengthExcessFlag']==1)
            {
                echo "<font color=\"red\">Can only be between 1 and 250</font>";
            }
            ?>
            </td>
        </tr>
        </table>
    </div>
    <div id="openEndedQuery" style="display: none">
        <table class="questionTables">
        <tr><td width="34%">
            <label for="openEndedQuestion">Question</label>
            </td>
            <td width="66%">
            <textarea cols="45" rows="2" name="openEndedQuestion"><?php
            if(isset ($_SESSION['fromEditScreen']['openEndedQuestion']))
            {
                echo $_SESSION['fromEditScreen']['openEndedQuestion'];
            }
            else
            {
                echo $_SESSION['editScreen']['text'];
            }?></textarea>
            <?php
            if(isset ($_SESSION['oEQuestionExcessFlag']) && $_SESSION['oEQuestionExcessFlag']==1)
            {
                echo "<font color=\"red\">Question too long</font>";
            }
            else if(isset ($_SESSION['oEQuestionNullFlag']) && $_SESSION['oEQuestionNullFlag']==1)
            {
                echo "<font color=\"red\">Enter Question</font>";
            }
            ?>
            </td>
        </tr>
        <tr><td height="45px">
            <label for="openEndedResponseLength">Length of the Response (in characters)</label>
            </td>
            <td>
            <input type="text" name="openEndedResponseLength" size="2" value="<?php
            if(isset ($_SESSION['fromEditScreen']['openEndedResponseLength']))
            {
                echo $_SESSION['fromEditScreen']['openEndedResponseLength'];
            }
            else
            {
                echo $_SESSION['editScreen']['responseLength'];
            }?>"></input>
            <?php
            if(isset ($_SESSION['oEQResponseTypeFlag']) && $_SESSION['oEQResponseTypeFlag']==1)
            {
                echo "<font color=\"red\">Enter digits only</font>";
            }
            else if(isset ($_SESSION['oEQResponseExcessFlag']) && $_SESSION['oEQResponseExcessFlag']==1)
            {
                echo "<font color=\"red\">Can only be between 1 and 250</font>";
            }
            ?>
            </td>
        </tr>
    </table>
    </div>
    <div id="ranking" style="display: none">
        <table class="questionTables">
            <tr><td width="18%">
            <label for="rankingQuestion">Question</label>
                </td>
                <td width="82%">
            <textarea cols="45" rows="2" name="rankingQuestion"><?php
            if(isset ($_SESSION['fromEditScreen']['rankingQuestion']))
            {
                echo $_SESSION['fromEditScreen']['rankingQuestion'];
            }
            else
            {
                echo $_SESSION['editScreen']['text'];
            }?></textarea>
            <?php
            if(isset ($_SESSION['rankingQExcessFlag']) && $_SESSION['rankingQExcessFlag']==1)
            {
                echo "<font color=\"red\">Question too long</font>";
            }
            else if(isset ($_SESSION['rankingQNullFlag']) && $_SESSION['rankingQNullFlag']==1)
            {
                echo "<font color=\"red\">Enter Question</font>";
            }
            ?>
                </td>
            </tr>
            <tr><td colspan="2">
        <table width="100%">
            <tr>
                <td>
                    <iframe src="editChoiceRanking.php" scrolling="yes" width="100%" frameborder="0" height="100%"></iframe>
                </td>
            </tr>
        </table>
                </td>
            </tr>
        <tr><td height="45px">
            <label for="rankingSizeOfList">Number of Ranks</label>
            </td>
            <td>
            <input type="text" name="rankingSizeOfList" size="2" value="<?php
            if(isset ($_SESSION['fromEditScreen']['rankingSizeOfList']))
            {
                echo $_SESSION['fromEditScreen']['rankingSizeOfList'];
            }
            else
            {
                echo $_SESSION['editScreen']['listSize'];
            }?>"></input>
            <?php
            if(isset ($_SESSION['rankingQTypeFlag']) && $_SESSION['rankingQTypeFlag']==1)
            {
                echo "<font color=\"red\">Enter digits only</font>";
            }
            ?>
            </td>
        </tr>
        </table>
    </div>
    <div id="dateTime" style="display: none">
        <table class="questionTables">
            <tr><td width="15%">
            <label for="dateTimeQuestion">Question</label>
                </td>
                <td width="85%">
            <textarea cols="45" rows="2" name="dateTimeQuestion"><?php
            if(isset ($_SESSION['fromEditScreen']['dateTimeQuestion']))
            {
                echo $_SESSION['fromEditScreen']['dateTimeQuestion'];
            }
            else
            {
                echo $_SESSION['editScreen']['text'];
            }?></textarea>
            <?php
            if(isset ($_SESSION['dateTimeQNullFlag']) && $_SESSION['dateTimeQNullFlag']==1)
            {
                echo "<font color=\"red\">Enter Question</font>";
            }
            else if(isset ($_SESSION['dateTimeQuestionExcessFlag']) && $_SESSION['dateTimeQuestionExcessFlag']==1)
            {
                echo "<font color=\"red\">Question too long</font>";
            }
            ?>
                </td>
            </tr>
        <tr><td colspan="2" height="45px">
            <label for="datetimetype">Format for the response</label>
            </td>
        </tr>
        <tr><td height="30px">
            <input type="radio" name="datetimetype" value="date" <?php
            if(isset ($_SESSION['fromEditScreen']['datetimetype']) && $_SESSION['fromEditScreen']['datetimetype']=="date")
            {
                echo "checked";
            }
            else if($_SESSION['editScreen']['dTFormat']==0)
            {
                echo "checked";
            }
            ?>>Date</input><br/>
            </td>
        </tr>
        <tr><td height="30px">
            <input type="radio" name="datetimetype" value="time" <?php
            if(isset ($_SESSION['fromEditScreen']['datetimetype']) && $_SESSION['fromEditScreen']['datetimetype']=="time")
            {
                echo "checked";
            }
            else if($_SESSION['editScreen']['dTFormat']==1)
            {
                echo "checked";
            }
            ?>>Time</input><br/>
            </td>
        </tr>
        <tr><td height="30px">
            <input type="radio" name="datetimetype" value="dateTime" <?php
            if(isset ($_SESSION['fromEditScreen']['datetimetype']) && $_SESSION['fromEditScreen']['datetimetype']=="dateTime")
            {
                echo "checked";
            }
            else if($_SESSION['editScreen']['dTFormat']==2)
            {
                echo "checked";
            }
            ?>>Date and Time</input><br/>
            </td>
        </tr>
        </table>
    </div>
    <table width="100%">
        <tr><td height="45px" style="text-align:right; padding-right:200px">
        <input type="submit" value="I am done editing the Screen" name="submitForm"/>
            </td>
        </tr>
    </table>
    <!--<div>
        <select>
            <option>Create a new Screen before this Screen</option>
            <option>Create a new Screen after this Screen</option>
        </select>
            <input type="submit" value="Create" name="submitForm"/>
    </div>
    <div>
            <input type="submit" value="Delete this Screen" name="submitForm"/>
    </div>--><script language="javascript" type="text/javascript">screenChooser()</script>
    </td>
</tr>
</form>
</table>
</td>
</tr>
</table>
</body>
</html>