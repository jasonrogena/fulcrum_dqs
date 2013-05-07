<?php include "../phpScripts/accessConfirmation.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Groups</title>
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
<a class="links" href="userGroups.php" style="color:#333">Groups</a>
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
            <p>User Groups</p>
    </td>
</tr>
<tr>
    <td class="subCatCells">
        <a href="newUserGroup.php" class="links">
                <p>Create a new User Group</p>
        </a>
    </td>
</tr>
<tr><td><img src="../images/smallLineDiv.jpg"/></td></tr>
<tr>
    <td class="subCatCells">
        <p>Edit an existing User Group</p>
        <form action="editUserGroup.php" method="post">
            <table width="100%">
                <tr>
                    <td height="43">
                        <select name="selectedGroupID" style="width:300px">
                                    <option value="">Select a User Group</option>
                                    <option></option>
                                        <?php
                                            include "../phpScripts/dbConnect.php";
                                            $devUserName=$_COOKIE['developerUsername'];
                                            $devPassword=$_COOKIE['developerPassword'];
                                            dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
                                            $query="SELECT `group_name`, `group_ID`,`application_ID` ".
                                                "FROM `group` WHERE `developer_username`='$devUserName'";
                                            $result=mysql_query($query) or die(mysql_error());
                                            $flag=0;
                                            while($queryContent=mysql_fetch_array($result))
                                            {
                                                if($flag==0 && $queryContent)
                                                {
                                                    echo "<optgroup label=\"User Group&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;::&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Application\" />";
                                                    $flag=1;
                                                }
                                                $query="SELECT name FROM application WHERE `application_ID`='{$queryContent['application_ID']}'";
                                                $res2=mysql_query($query) or die (mysql_error());
                                                $aftRes2=mysql_fetch_array($res2);
                                                echo "<option value=\"{$queryContent['group_ID']}\">{$queryContent['group_ID']} - {$queryContent['group_name']}&nbsp;::&nbsp;{$aftRes2['name']}</option>";
                                            }
                                        ?>
                                </select>
                        </td>
                </tr>
                <tr>
                        <td>
                        <input type="submit" value="Edit"/>
                    </td>
                </tr>
            </table>
        </form>
    </td>
</tr>
<tr><td><img src="../images/smallLineDiv.jpg"/></td></tr>
<tr>
    <td class="subCatCells">
        <p>Delete an existing User Group</p>
        <form action="../phpScripts/deleteUserGroup.php" method="post">
            <table width="100%">
                <tr>
                        <td height="46">
                            <select name="groupToDelete" style="width:300px">
                                <option value="">Select a User Group</option>
                                <option></option>
                                        <?php
                                            $devUserName=$_COOKIE['developerUsername'];
                                            $devPassword=$_COOKIE['developerPassword'];
                                            dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
                                            $query="SELECT `group_name`, `group_ID`,`application_ID` ".
                                                "FROM `group` WHERE `developer_username`='$devUserName'";
                                            $result=mysql_query($query) or die(mysql_error());
                                            $flag=0;
                                            while($queryContent=mysql_fetch_array($result))
                                            {
                                                if($flag==0 && $queryContent)
                                                {
                                                    echo "<optgroup label=\"User Group&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;::&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Questionnaire\" />";
                                                    $flag=1;
                                                }
                                                $query="SELECT name FROM application WHERE `application_ID`='{$queryContent['application_ID']}'";
                                                $res2=mysql_query($query) or die (mysql_error());
                                                $aftRes2=mysql_fetch_array($res2);
                                                echo "<option value=\"{$queryContent['group_ID']}\">{$queryContent['group_ID']} - {$queryContent['group_name']}&nbsp;::&nbsp;{$aftRes2['name']}</option>";
                                            }
                                        ?>
                                </select>
                        </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="Delete"/>
                    </td>
                </tr>
            </table>
        </form>
    </td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>