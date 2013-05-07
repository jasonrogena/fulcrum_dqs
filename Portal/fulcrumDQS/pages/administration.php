<?php include"../phpScripts/adminAccessConfirmation.php";//check if the user is authorised to view page?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administration</title>
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
<div style="height:25px"><a class="links" style="color:#333"><?php echo $_COOKIE['administratorUsername'];?></a></div>
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
<a class="links" href="fieldUsers.php">Respondents</a>
</td></tr>
<tr><td class="optionCells" id="adminOpt" onmouseover="JavaScript:optionOn(this);" onmouseout="JavaScript:optionOff(this);">
<a class="links" href="administration.php" style="color:#333">Administration</a>
</td></tr>
</table>
</td>
<td id="bodyDivision"><!--LINE DIV-->
</td>
<td width="81%" id="innerBodyCell"><!--inner body-->
<table id="innerBodyTable" width="100%" class="mainTables">
                    <tr>
    <td height="104" class="rightTitleCell">
            <p>Administration</p>
    </td>
</tr>
<tr>
    <td class="subCatCells">
        <a href="newDeveloper.php" class="links">
        <p>Register a Researcher</p>
        </a>
    </td>
</tr>
<tr><td><img src="../images/smallLineDiv.jpg"/></td></tr>
<tr>
	<td class="subCatCells">
    <p>View Researcher's Profile</p>
    <form action="developerProfile.php"  method="post">
        <table>
            <tr>
                <td width="964" height="41">
                    <select name="selectedDeveloper" style="width:300px">
                        <option value="">Select a Researcher</option>
                        <option></option>
                        <?php
                        include "../phpScripts/dbConnect.php";
                        $adminUsername=$_COOKIE['administratorUsername'];
                        $adminPassword=$_COOKIE['administratorPassword'];
                        dbConnect($adminUsername,$adminPassword);
                        $query="SELECT username,`first_name`,`surname` ".
                        "FROM developer";
                        $result=mysql_query($query) or die(mysql_error());
                        //fetch and display each row at a time
                        while($developers=mysql_fetch_array($result))
                        {
                            echo "<option value=\"{$developers['username']}\">{$developers['username']} - {$developers['first_name']} {$developers['surname']}</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" value="View" />
                </td>
            </tr>
        </table>
    </form>
</td></tr>
<tr><td><img src="../images/smallLineDiv.jpg"/></td></tr>
<tr><td class="subCatCells">
        <p>Remove a Researcher</p>
        <form action="../phpScripts/removeDeveloper.php"  method="post">
            <table>
                <tr>
                    <td width="963" height="42">
                        <select name="selectedDeveloper" style="width:300px">
                            <option value="">Select a Researcher</option>
                            <option></option>
                            <?php
                            $query="SELECT username,`first_name`,`surname` ".
                            "FROM developer";
                            $result=mysql_query($query) or die(mysql_error());
                            //fetch and display each row at a time
                            while($developers=mysql_fetch_array($result))
                            {
                                echo "<option value=\"{$developers['username']}\">{$developers['username']} - {$developers['first_name']} {$developers['surname']}</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="Remove" />
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