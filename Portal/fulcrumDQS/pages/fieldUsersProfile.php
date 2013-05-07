<?php include"../phpScripts/accessConfirmation.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Respondent's Profile</title>
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
<script language="javascript" type="text/javascript">
    function editGroup()
    {
        groupDiv=document.getElementById('groupDiv');
        editGroup=document.getElementById('editGroup');
        groupDiv.style.display="none";
        editGroup.style.display="block";
    }
</script>
<?php
    include '../phpScripts/dbConnect.php';
    dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
    if(isset ($_REQUEST['selectedFUser']))
    {
        $fieldUsername=$_REQUEST['selectedFUser'];
    }
    else if(isset ($_SESSION['fieldUsername']))
    {
        $fieldUsername=$_SESSION['fieldUsername'];
    }
    if($fieldUsername=="")
    {
        header("location:fieldUsers.php");
    }
    $fieldUsername=mysql_real_escape_string($fieldUsername);
    $query="SELECT * ".
    "FROM `field_user` ".
    "WHERE username='$fieldUsername'";
    $result=mysql_query($query) or die (mysql_error());
    $fieldUser=mysql_fetch_array($result);
    $_SESSION['fieldUsername']=$fieldUser['username'];
    $_SESSION['fName']=$fieldUser['first_name'];
    $_SESSION['surname']=$fieldUser['surname'];
    $_SESSION['groupID']=$fieldUser['group_ID'];
    $query="SELECT `group_name` FROM `group` WHERE `group_ID`='{$_SESSION['groupID']}'";
    $result=mysql_query($query) or die (mysql_error());
    $fetchedName=mysql_fetch_array($result);
    $_SESSION['groupName']=$fetchedName['group_name'];
    $regDev=$fieldUser['developer_username'];
    $query="SELECT `first_name`,surname FROM `developer` WHERE username='$regDev'";
    $result=mysql_query($query) or die (mysql_error());
    $fetchedName=mysql_fetch_array($result);
    $_SESSION['regDev']=$fetchedName['first_name']." ".$fetchedName['surname'];
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
    <td height="104" class="rightTitleCell">
            <p><?php
            echo $_SESSION['fName']." ".$_SESSION['surname'];
            if($_SESSION['surname'][strlen($_SESSION['surname'])-1]=="s")
            {
                echo "' Profile";
            }
            else
            {
                echo "'s Profile";
            }
            ?></p>
    </td>
</tr>
<tr>
    <td class="subCatCells">
        <p>First Name : <?php echo $_SESSION['fName'];?></p>
    </td>
</tr>
<tr>
    <td class="subCatCells">
        <p>Surname : <?php echo $_SESSION['surname'];?></p>
    </td>
</tr>
<tr>
    <td class="subCatCells">
        <p>Username : <?php echo $_SESSION['fieldUsername'];?></p>
    </td>
</tr>
<tr>
    <td class="subCatCells">
        <div id="groupDiv">
            <p>Group name: <?php echo $_SESSION['groupName'];?></p>
            <p>Group ID: <?php echo $_SESSION['groupID']."  ";?><input type="button" value="Edit Group" onclick="JavaScript:editGroup()"/></p>
        </div>
        <div id="editGroup" style="display:none;">
            <p>Reselect the User Group</p>
            <form action="../phpScripts/updateFieldUserGroup.php" method="post">
                <select name="usergroup">
                    <option value="">Select a User Group</option>
                    <option></option><!--blank option-->
                    <?php
                        $query="SELECT `group_ID`,`group_name` ".
                            "FROM `group` WHERE `developer_username`='$devUsername'";
                        $result=mysql_query($query) or die (mysql_error());
                        while($queryContent=mysql_fetch_array($result))
                        {
                            if($queryContent['group_ID']==$_SESSION['groupID'])
                            {
                                echo "<option selected value=\"{$queryContent['group_ID']}\">{$queryContent['group_ID']} - {$queryContent['group_name']}</option>";
                            }
                            else
                            {
                                echo "<option value=\"{$queryContent['group_ID']}\">{$queryContent['group_ID']} - {$queryContent['group_name']}</option>";
                            }
                        }
                    ?>
                </select>
                <input type="submit" value="Edit Group"/>
            </form>
        </div>
    </td>
</tr>
<tr>
    <td>
        <p>Registered by (Researcher) : <?php echo $_SESSION['regDev'];?></p>
    </td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>