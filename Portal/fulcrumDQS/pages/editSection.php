<?php include"../phpScripts/accessConfirmation.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit a Section</title>
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
#editButtonCell{
	text-align: right;
	padding-right: 200px;
}
#deleteButtonCell{
	text-align: right;
	padding-right: 200px;
}
#createButtonCell{
	text-align: right;
	padding-right: 200px;
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
if(isset ($_REQUEST['sectionID']))
{
    include '../phpScripts/dbConnect.php';
    dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
    $sectionID=mysql_real_escape_string($_REQUEST['sectionID']);
    $query="SELECT * FROM section WHERE `section_ID`='$sectionID'";
    $result=mysql_query($query) or die (mysql_error());
    $fetchedSection=mysql_fetch_array($result);
    $_SESSION['sectionID']=$fetchedSection['section_ID'];
    $_SESSION['sectionNO']=$fetchedSection['section_no'];
    $_SESSION['applicationID']=$fetchedSection['application_ID'];
    $_SESSION['heading']=$fetchedSection['heading'];
    $_SESSION['introText']=$fetchedSection['intro_text'];
}
if(isset ($_REQUEST['create']) || isset ($_REQUEST['delete']) || isset ($_REQUEST['edit']))
{
    $flag=0;
    if(isset ($_REQUEST['edit']))
    {
        $_SESSION['fromEditSection']['sectionName']=$_REQUEST['sectionName'];
        $_SESSION['fromEditSection']['sectionIntro']=$_REQUEST['sectionIntro'];
        $_SESSION['fromEditSection']['edit']=$_REQUEST['edit'];
        if($_REQUEST['sectionName']=="")
        {
            $flag=1;
            $_SESSION['sectionNameNullFlag']=1;
        }
        else
        {
            $_SESSION['sectionNameNullFlag']=0;
        }
        if(strlen($_REQUEST['sectionName'])>95)
        {
            $flag=1;
            $_SESSION['sectionNameExcessFlag']=1;
        }
        else
        {
            $_SESSION['sectionNameExcessFlag']=0;
        }
        if($_REQUEST['sectionIntro']=="")
        {
            $_SESSION['fromEditSection']['sectionIntro']=" ";
        }
        if(strlen($_REQUEST['sectionIntro'])>250)
        {
            $flag=1;
            $_SESSION['sectionIntroExcessFlag']=1;
        }
        else
        {
            $_SESSION['sectionIntroExcessFlag']=0;
        }
    }
    if(isset ($_REQUEST['create']))
    {
        $_SESSION['fromEditSection']['where']=$_REQUEST['where'];
        $_SESSION['fromEditSection']['create']=$_REQUEST['create'];
    }
    if(isset ($_REQUEST['delete']))
    {
        $_SESSION['fromEditSection']['delete']=$_REQUEST['delete'];
    }
    if($flag==0)
    {
        echo "<meta http-equiv=\"refresh\" content=\"0;URL=../phpScripts/updateSection.php\" />";
    }
}
else
{
    unset ($_SESSION['fromEditSection']);
    $_SESSION['sectionNameNullFlag']=0;
    $_SESSION['sectionNameExcessFlag']=0;
    $_SESSION['sectionIntroExcessFlag']=0;
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
    <td height="104" class="rightTitleCell" colspan="2">
            <p>Edit Section <?php echo $_SESSION['sectionNO'];?></p>
    </td>
</tr>
<form action="editSection.php" method="post">
<tr>
    <td width="31%" class="subCatCells">
        <label for="sectionName">Section Name</label>
    </td>
    <td width="69%">
        <input type="text" style="width:400px" name="sectionName" value="<?php
        if(isset ($_SESSION['fromEditSection']['sectionName']))
        {
            echo $_SESSION['fromEditSection']['sectionName'];
        }
        else
        {
            echo $_SESSION['heading'];
        }?>" />
        <?php
        if(isset ($_SESSION['sectionNameNullFlag']) && $_SESSION['sectionNameNullFlag']==1)
        {
            echo "<font color=\"red\">Enter Section name</font>";
        }
        else if(isset ($_SESSION['sectionNameExcessFlag']) && $_SESSION['sectionNameExcessFlag']==1)
        {
            echo "<font color=\"red\">Name too long</font>";
        }
        ?>
    </td>
</tr>
<tr>
    <td class="subCatCells">
        <label for="sectionIntro">Section introduction</label>
    </td>
    <td colspan="3">
        <textarea rows="5"  cols="50"  name="sectionIntro"><?php
        if(isset ($_SESSION['fromEditSection']['sectionIntro']))
        {
            echo $_SESSION['fromEditSection']['sectionIntro'];
        }
        else
        {
            echo $_SESSION['introText'];
        }?></textarea>
        <?php
        if(isset ($_SESSION['sectionIntroExcessFlag']) && $_SESSION['sectionIntroExcessFlag']==1)
        {
            echo "<font color=\"red\">Text too long</font>";
        }
        ?>
    </td>
</tr>
<tr>
    <td height="45" colspan="2" class="subCatCells" id="editButtonCell">
        <input type="submit" name="edit" value="Finish Editing"/>
    </td>
</tr>
<tr>
    <td height="45" class="subCatCells" id="createButtonCell" colspan="2">
        <select name="where" style="width:300px">
            <option value="b">Create a new Section Before this Section</option>
            <option value="a">Create a new Section After this Section</option>
        </select>
        <input type="submit" name="create" value="Create" />
    </td>
</tr>
<tr>
    <td height="45" colspan="2" class="subCatCells" id="deleteButtonCell">
        <input type="submit" value="Delete Section" name="delete" />
    </td>
</tr>
</form>
</table>
</td>
</tr>
</table>
</body>
</html>