<?php include "../phpScripts/accessConfirmation.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Existing User Group</title>
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
#submitButtonID{
	text-align: right;
	height: 30px;
	padding-right: 200px;
	padding-top: 15px;
}
#fieldUserCellID{
	border-top-color: #FFF;
	border-top-width: 25px;
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
if(isset ($_REQUEST['selectedGroupID']))
{
    $userGroupID=$_REQUEST['selectedGroupID'];
    $_SESSION['groupID']=$userGroupID;
    if($userGroupID=="")
    {
        header("location:userGroups.php");
    }
    $query="SELECT * FROM `group` WHERE `group_ID`='$userGroupID'";
    $result=mysql_query($query) or die (mysql_error());
    $fetchedResult=mysql_fetch_array($result);
    $_SESSION['groupName']=$fetchedResult['group_name'];
    $_SESSION['groupID']=$userGroupID;
    $_SESSION['appID']=$fetchedResult['application_ID'];
}
if(isset ($_REQUEST['submit']))
{
    $query="SELECT `group_name` FROM `group` WHERE `group_ID`='{$_SESSION['groupID']}'";
    $result=mysql_query($query) or die (mysql_error());
    $fetchedGroup=mysql_fetch_array($result);
    $oldGroupName=$fetchedGroup['group_name'];
    $flag=0;
    $_SESSION['fromEditGroup']['groupName']=$_REQUEST['groupName'];
    if(isset ($_REQUEST['selectApp']))
    {
        $_SESSION['fromEditGroup']['selectApp']=$_REQUEST['selectApp'];
    }
    if(isset ($_REQUEST['selectedUsers']))
    {
        $_SESSION['fromEditGroup']['selectedUsers']=$_REQUEST['selectedUsers'];
    }
    if(strlen($_REQUEST['groupName'])>19)
    {
        $flag=1;
        $_SESSION['groupNameExcessFlag']=1;
    }
    else
    {
        $_SESSION['groupNameExcessFlag']=0;
    }
    if($_REQUEST['groupName']=="")
    {
        $flag=1;
        $_SESSION['groupNamenullFlag']=1;
    }
    else
    {
        $_SESSION['groupNamenullFlag']=0;
    }
    if($_REQUEST['groupName']!=$oldGroupName)//group name has been changed
    {
    	$newGroupName=mysql_real_escape_string($_REQUEST['groupName']);
        $query="SELECT count(`group_name`) FROM `group` WHERE `group_name`='$newGroupName'";//if groupname has changed then the new name should be unique
        $result=mysql_query($query) or die (mysql_error());
        $fetchedResult=mysql_fetch_array($result);
        $count=$fetchedResult[0];
        if($count>0)
        {
            $flag=1;
            $_SESSION['groupUniqueFlag']=1;
        }
        else
        {
            $_SESSION['groupUniqueFlag']=0;
        }
    }
    if($flag==0)
    {
        echo "<meta http-equiv=\"refresh\" content=\"0;URL=../phpScripts/updateUserGroup.php\" />";
    }
}
else
{
    unset ($_SESSION['fromEditGroup']);
    $_SESSION['groupNameExcessFlag']=0;
    $_SESSION['groupUniqueFlag']=0;
    $_SESSION['groupNamenullFlag']=0;

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
            <p>Edit an existing User Group</p>
    </td>
</tr>
<tr>
    <td class="subCatCells">
        <form action="editUserGroup.php" method="post">
            <table>
                <tr>
                    <td width="327" style="height:45px">
                        <label for="groupName">Group Name</label>
                    </td>
                    <td width="530">
                        <input type="text" name="groupName" style="width:280px" value="<?php
                        if(isset ($_SESSION['fromEditGroup']['groupName']))
                        {
                            echo $_SESSION['fromEditGroup']['groupName'];
                        }
                        else
                        {
                            echo $_SESSION['groupName'];
                        }?>" />
                        <?php
                        if(isset ($_SESSION['groupNameExcessFlag']) && $_SESSION['groupNameExcessFlag']==1)
                        {
                            echo "<font color=\"red\">Name too long</font>";
                        }
                        else if(isset ($_SESSION['groupNamenullFlag']) && $_SESSION['groupNamenullFlag']==1)
                        {
                            echo "<font color=\"red\">Enter Group name</font>";
                        }
                        else if(isset ($_SESSION['groupUniqueFlag']) && $_SESSION['groupUniqueFlag']==1)
                        {
                            echo "<font color=\"red\">Group name should be unique</font>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                  <td style="height:45px">
                    <label for="applicationSelect">Select a Questionnaire for the User Group</label>
                  </td>
                    <td>
                        <select name="selectApp" style="width:280px">
                            <option value="">Select a Questionnaire</option>
                            <option></option>
                                <?php
                                    $query="SELECT `application_ID`,`name` FROM `application` WHERE `developer_username`='$devUsername'";
                                    $result=mysql_query($query) or die(mysql_error());
                                    while ($queryContent=mysql_fetch_array($result))
                                    {
                                        if($queryContent['application_ID']==$_SESSION['appID'])
                                        {
                                            echo "<option selected value=\"{$queryContent['application_ID']}\">".$queryContent['application_ID']." - ".$queryContent['name']."</option>";//application ID before name to avoid errors
                                        }
                                        else
                                        {
                                            echo "<option value=\"{$queryContent['application_ID']}\">".$queryContent['application_ID']." - ".$queryContent['name']."</option>";
                                        }
                                    }
                                ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" id="fieldUserCellID">
                            <?php
                                $query="SELECT username,`first_name`,surname,`group_ID`
                                    FROM `field_user`
                                    WHERE `developer_username`='{$_COOKIE['developerUsername']}' AND `group_ID` IS NULL OR `group_ID`='{$_SESSION['groupID']}'";
                                $result=mysql_query($query) or die(mysql_error());
                                $fetchedFUsers=mysql_fetch_array($result);
                                if($fetchedFUsers)
                                {
                                    echo '<fieldset style="width:600px"><legend>Select Field Users to add to this Group</legend>';
                                    if($fetchedFUsers['group_ID']==$_SESSION['groupID'])
                                    {
                                        echo "<input type=\"checkbox\" checked name=\"selectedUsers[]\" value=\"{$fetchedFUsers['username']}\">{$fetchedFUsers['username']} - {$fetchedFUsers['first_name']} {$fetchedFUsers['surname']}</input><br/>";
                                    }
                                    else
                                    {
                                        echo "<input type=\"checkbox\" name=\"selectedUsers[]\" value=\"{$fetchedFUsers['username']}\">{$fetchedFUsers['username']} - {$fetchedFUsers['first_name']} {$fetchedFUsers['surname']}</input><br/>";
                                    }
                                    while($fetchedFUsers=mysql_fetch_array($result))
                                    {
                                        if($fetchedFUsers['group_ID']==$_SESSION['groupID'])
                                        {
                                            echo "<input type=\"checkbox\" checked name=\"selectedUsers[]\" value=\"{$fetchedFUsers['username']}\">{$fetchedFUsers['username']} - {$fetchedFUsers['first_name']} {$fetchedFUsers['surname']}</input><br/>";
                                        }
                                        else
                                        {
                                            echo "<input type=\"checkbox\" name=\"selectedUsers[]\" value=\"{$fetchedFUsers['username']}\">{$fetchedFUsers['username']} - {$fetchedFUsers['first_name']} {$fetchedFUsers['surname']}</input><br/>";
                                        }
                                    }
                                    echo '</fieldset>';
                                }
                            ?>
                    </td>
                </tr>
                <tr>
                        <td colspan="2" id="submitButtonID">
                            <input type="submit" value="Edit" name="submit"/>
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