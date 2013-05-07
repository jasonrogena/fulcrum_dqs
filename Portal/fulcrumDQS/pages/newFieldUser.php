<?php include"../phpScripts/accessConfirmation.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Register a Respondent</title>
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
include '../phpScripts/dbConnect.php';
dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
if(isset ($_REQUEST['submit']))
{
    $flag=0;
    $_SESSION['fromFUserAccess']['fieldUserFname']=$_REQUEST['fieldUserFname'];
    $_SESSION['fromFUserAccess']['fielsUserSname']=$_REQUEST['fielsUserSname'];
    $_SESSION['fromFUserAccess']['fielsUserUsername']=$_REQUEST['fielsUserUsername'];
    $_SESSION['fromFUserAccess']['usergroup']=$_REQUEST['usergroup'];
    $_SESSION['fromFUserAccess']['password']=$_REQUEST['password'];
    $_SESSION['fromFUserAccess']['rPassword']=$_REQUEST['rPassword'];
    if(ctype_alpha($_REQUEST['fieldUserFname'])==false)//digits included
    {
        $flag=1;
        $_SESSION['fNameTypeFlag']=1;
    }
    else
    {
        $_SESSION['fNameTypeFlag']=0;
    }
    if(ctype_alpha($_REQUEST['fielsUserSname'])==false)
    {
        $flag=1;
        $_SESSION['sNameTypeFlag']=1;
    }
    else
    {
        $_SESSION['sNameTypeFlag']=0;
    }
    if(strlen($_REQUEST['fieldUserFname'])>19)
    {
        $flag=1;
        $_SESSION['exceedFNameFlag']=1;
    }
    else
    {
        $_SESSION['exceedFNameFlag']=0;
    }
    if(strlen($_REQUEST['fielsUserSname'])>19)
    {
        $flag=1;
        $_SESSION['exceedSNameFlag']=1;
    }
    else
    {
        $_SESSION['exceedSNameFlag']=0;
    }
    if($_REQUEST['fieldUserFname']=="")
    {
        $flag=1;
        $_SESSION['fNameEmptyFlag']=1;
    }
    else
    {
        $_SESSION['fNameEmptyFlag']=0;
    }
    if($_REQUEST['fielsUserSname']=="")
    {
        $flag=1;
        $_SESSION['sNameEmptyFlag']=1;
    }
    else
    {
        $_SESSION['sNameEmptyFlag']=0;
    }
    if($_REQUEST['fielsUserUsername']=="")
    {
        $flag=1;
        $_SESSION['usernameNullFlag']=1;
    }
    else
    {
        $_SESSION['usernameNullFlag']=0;
    }
    if(strlen($_REQUEST['fielsUserUsername'])>39)
    {
        $flag=1;
        $_SESSION['usernameExcessFlag']=1;
    }
    else
    {
        $_SESSION['usernameExcessFlag']=0;
    }
    $fieldUsername=mysql_real_escape_string($_REQUEST['fielsUserUsername']);
    $query="SELECT count(`username`) FROM `field_user` WHERE `username`='$fieldUsername'";
    $result=mysql_query($query) or die (mysql_error());
    $fetchedResult=mysql_fetch_array($result);
    $count=$fetchedResult[0];
    if($count>0)
    {
        $flag=1;
        $_SESSION['usernameDuplicateFlag']=1;
    }
    else
    {
        $query="SELECT count(`username`) FROM developer WHERE `username`='$fieldUsername'";
        $result=mysql_query($query) or die (mysql_error());
        $fetchedResult=mysql_fetch_array($result);
        $count=$fetchedResult[0];
        if($count>0)
        {
            $flag=1;
            $_SESSION['usernameDuplicateFlag']=1;
        }
        else
        {
            $_SESSION['usernameDuplicateFlag']=0;
        }
    }
    if(strlen($_REQUEST['password'])>19)
    {
        $flag=1;
        $_SESSION['passwordExceed']=1;
    }
    else
    {
        $_SESSION['passwordExceed']=0;
    }
    if($_REQUEST['password']!=$_REQUEST['rPassword'])
    {
        $flag=1;
        $_SESSION['passwordNotMatchFlag']=1;
    }
    else
    {
        $_SESSION['passwordNotMatchFlag']=0;
    }
    if($_SESSION['fromFUserAccess']['password']=="" && $_SESSION['fromFUserAccess']['rPassword']=="")//if no new password is specified
    {
        $flag=1;
        $_SESSION['passwordNullFlag']=1;
    }
    else
    {
        $_SESSION['passwordNullFlag']=0;
    }
    if($flag==0)
    {
        echo "<meta http-equiv=\"refresh\" content=\"0;URL=../phpScripts/addFieldUser.php\" />";
    }
}
else
{
    unset ($_SESSION['fromFUserAccess']);
    $_SESSION['fNameTypeFlag']=0;
    $_SESSION['sNameTypeFlag']=0;
    $_SESSION['exceedFNameFlag']=0;
    $_SESSION['exceedSNameFlag']=0;
    $_SESSION['fNameEmptyFlag']=0;
    $_SESSION['sNameEmptyFlag']=0;
    $_SESSION['usernameNullFlag']=0;
    $_SESSION['usernameExcessFlag']=0;
    $_SESSION['usernameDuplicateFlag']=0;
    $_SESSION['oldPasswordBlankFlag']=0;
    $_SESSION['passwordExceed']=0;
    $_SESSION['passwordNotMatchFlag']=0;
    $_SESSION['passwordNullFlag']=0;
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
<a class="links" href="applications.php">Questionnaires</a>
</td></tr>
<tr><td class="optionCells" id="uGroupsOpt" onmouseover="JavaScript:optionOn(this);" onmouseout="JavaScript:optionOff(this);">
<a class="links" href="userGroups.php">Groups</a>
</td></tr>
<tr><td class="optionCells" id="respondentOpt" onmouseover="JavaScript:optionOn(this);" onmouseout="JavaScript:optionOff(this);">
<a class="links" href="fieldUsers.php" style="color:#333">Respondents</a>
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
    <td height="104" class="rightTitleCell" colspan="2">
            <p>Register a Respondent</p>
    </td>
</tr>
<form action="newFieldUser.php" method="post">
<tr>
    <td width="25%" height="45" class="subCatCells">
        <label for="fieldUserFname">First Name</label>
    </td>
    <td width="75%">
        <input type="text" name="fieldUserFname" style="width:200pt" value="<?php
        if(isset ($_SESSION['fromFUserAccess']['fieldUserFname']))
        {
            echo $_SESSION['fromFUserAccess']['fieldUserFname'];
        }
        ?>"/>
        <?php
        if(isset ($_SESSION['fNameTypeFlag']) && $_SESSION['fNameTypeFlag']==1)
        {
            echo "<font color=\"red\">Only Alphabetic letters allowed</font>";
        }
        else if(isset ($_SESSION['exceedFNameFlag']) && $_SESSION['exceedFNameFlag']==1)
        {
            echo "<font color=\"red\">First Name is too long</font>";
        }
        else if(isset ($_SESSION['fNameEmptyFlag']) && $_SESSION['fNameEmptyFlag']==1)
        {
            echo "<font color=\"red\">Enter First Name</font>";
        }
        ?>
    </td>
</tr>
<tr>
    <td class="subCatCells" height="45">
        <label for="fielsUserSname">Surname</label>
    </td>
    <td>
        <input type="text" name="fielsUserSname" style="width:200pt" value="<?php
        if(isset ($_SESSION['fromFUserAccess']['fielsUserSname']))
        {
            echo $_SESSION['fromFUserAccess']['fielsUserSname'];
        }
        ?>"/>
        <?php
        if(isset ($_SESSION['sNameTypeFlag']) && $_SESSION['sNameTypeFlag']==1)
        {
            echo "<font color=\"red\">Only Alphabetic letters allowed</font>";
        }
        else if(isset ($_SESSION['exceedSNameFlag']) && $_SESSION['exceedSNameFlag']==1)
        {
            echo "<font color=\"red\">Surname is too long</font>";
        }
        else if(isset ($_SESSION['sNameEmptyFlag']) && $_SESSION['sNameEmptyFlag']==1)
        {
            echo "<font color=\"red\">Enter Surname</font>";
        }
        ?>
    </td>
</tr>
<tr>
    <td class="subCatCells" height="45">
        <label for="fielsUserUsername">Preferred Username</label>
    </td>
    <td colspan="3">
        <input type="text" name="fielsUserUsername" style="width:200pt" value="<?php
        if(isset ($_SESSION['fromFUserAccess']['fielsUserUsername']))
        {
            echo $_SESSION['fromFUserAccess']['fielsUserUsername'];
        }
        ?>"/>
        <?php
        if(isset ($_SESSION['usernameDuplicateFlag']) && $_SESSION['usernameDuplicateFlag']==1)
        {
            echo "<font color=\"red\">Username is not unique</font>";
        }
        else if(isset ($_SESSION['usernameNullFlag']) && $_SESSION['usernameNullFlag']==1)
        {
            echo "<font color=\"red\">Enter Username</font>";
        }
        else if(isset ($_SESSION['usernameExcessFlag']) && $_SESSION['usernameExcessFlag']==1)
        {
            echo "<font color=\"red\">Username too long</font>";
        }
        ?>
    </td>
</tr>
<tr>
    <td class="subCatCells" height="45">
        <label for="password">Password</label>
    </td>
    <td>
        <input type="password" name="password" style="width:200pt"/>
    </td>
</tr>
<tr>
    <td class="subCatCells" height="45">
        <label for="rPassword">Retype Password</label>
    </td>
    <td>
        <input type="password" name="rPassword" style="width:200pt"/>
        <?php
        if(isset ($_SESSION['passwordExceed']) && $_SESSION['passwordExceed']==1)
        {
            echo "<font color=\"red\">New password too long</font>";
        }
        else if(isset ($_SESSION['passwordNotMatchFlag']) && $_SESSION['passwordNotMatchFlag']==1)
        {
            echo "<font color=\"red\">New passwords do not match</font>";
        }
        else if(isset ($_SESSION['passwordNullFlag']) && $_SESSION['passwordNullFlag']==1)
        {
            echo "<font color=\"red\">Enter Password</font>";
        }
        ?>
    </td>
</tr>
<tr>
    <td class="subCatCells" height="45">
        <label for="userGroup">Select User group</label>
    </td>
    <td>
        <select name="usergroup" style="width:200pt">
            <option value="">Select a User Group</option>
            <option></option><!--blank option-->
            <?php
                $query="SELECT `group_ID`,`group_name` ".
                    "FROM `group` WHERE `developer_username`='$devUsername'";
                $result=mysql_query($query) or die (mysql_error());
                while($queryContent=mysql_fetch_array($result))
                {
                    echo "<option value=\"{$queryContent['group_ID']}\">{$queryContent['group_ID']} - {$queryContent['group_name']}</option>";
                }
            ?>
        </select>
    </td>
</tr>
<tr>
    <td height="58" colspan="4" style="text-align:right;padding-right:400px">
        <input type="submit" value="Register" name="submit"/>
    </td>
</tr>
</form>
</table>
</td>
</tr>
</table>
</body>
</html>