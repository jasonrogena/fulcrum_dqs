<?php include"../phpScripts/accessConfirmation.php";
$_SESSION['adminValidate']=0;?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Applications</title>
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
	$_SESSION['toNewDeveloper']=0;//after this point if administration is pressed it will go to administartion.php instead of newDeveloper.php
?>
</head>

<body onload="loading();">
<table class="mainTables" id="canvas" style="display:none">
<tr><td id="tableHeader" width="1333" height="50" colspan="3">
<div><?php
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
<a class="links" href="applications.php" style="color:#333">Applications</a>
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
            <p>Applications</p>
    </td>
</tr>
<tr>
    <td class="subCatCells">
        <a href="newApplication.php" class="links">
            <p class="subHeading">Create a new Application</p>
        </a>
    </td>
</tr>
<tr><td><img src="../images/smallLineDiv.jpg"/></td></tr>
<tr>
    <td class="subCatCells">
        <p class="subHeading">Review an existing Application</p>
        <form action="reviewApplication.php" method="post">
        <table>
                <tr>
                <td>
                    <select name="selectedApplication">
                        <option value="">Select an Application</option>//blank option
                        <option></option>
                        <?php
                            include "../phpScripts/dbConnect.php";
                            $devUsername=$_COOKIE['developerUsername'];
                            $devPassword=$_COOKIE['developerPassword'];
                            dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
                            $query="SELECT `application_ID`,name ".
                                "FROM application ".
                                "WHERE `developer_username`='$devUsername'";
                            $result=mysql_query($query) or die (mysql_error());
                            while($resultArray=mysql_fetch_array($result))
                            {
                                echo "<option value=\"$resultArray[0]\">".$resultArray[0]." - ".$resultArray[1]."</option>";
                            }
                            if(isset ($_SESSION['applicationID']))
                            {
                                unset ($_SESSION['applicationID']);
                            }
                            if(isset ($_SESSION['screenNO']))
                            {
                                unset ($_SESSION['screenNO']);
                            }
                            if(isset ($_SESSION['screenID']))
                            {
                                unset ($_SESSION['screenID']);
                            }
                            if(isset ($_SESSION['sectionNO']))
                            {
                                unset ($_SESSION['sectionNO']);
                            }
                            if(isset ($_SESSION['sectionID']))
                            {
                                unset ($_SESSION['sectionID']);
                            }
                            if(isset ($_SESSION['overallScreenNO']))
                            {
                                unset ($_SESSION['overallScreenNO']);
                            }
                            if(isset ($_SESSION['ssChoiceArray']))
                            {
                                unset ($_SESSION['ssChoiceArray']);
                            }
                            if(isset ($_SESSION['msChoiceArray']))
                            {
                                unset ($_SESSION['msChoiceArray']);
                            }
                            if(isset ($_SESSION['cChoiceArray']))
                            {
                                unset ($_SESSION['cChoiceArray']);
                            }
                            if(isset ($_SESSION['questionNO']))
                            {
                                unset ($_SESSION['questionNO']);
                            }
                            if(isset ($_SESSION['applicationOK']))
                            {
                                unset ($_SESSION['applicationOK']);
                            }
                        ?>
                    </select>
                </td>
        </tr>
                <td>
                        <input type="submit" value="Review" />
                </td>
        <tr>
        </tr>
        </table>
        </form>
    </td>
</tr>
<tr><td><img src="../images/smallLineDiv.jpg"/></td></tr>
<tr>
    <td class="subCatCells">
            <p class="subHeading">Delete an Application</p>
            <form  action="../phpScripts/deleteApplication.php" method="post">
            <table>
                    <tr>
                    <td>
                        <select name="selectedApplication">
                            <option value="">Select an Application</option>//blank option
                            <option></option>
                            <?php
                                $query="SELECT `application_ID`,name ".
                                    "FROM application ".
                                    "WHERE `developer_username`='{$_COOKIE['developerUsername']}'";
                                $result=mysql_query($query) or die (mysql_error());
                                while($resultArray=mysql_fetch_array($result))
                                {
                                    echo "<option value=\"$resultArray[0]\">".$resultArray[0]." - ".$resultArray[1]."</option>";
                                }

                            ?>
                    </select>
                    </td>
            </tr>
            <tr>
                    <td>
                            <input type="submit" value="Delete" />
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