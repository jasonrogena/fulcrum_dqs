<?php include"../phpScripts/accessConfirmation.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit a Questionnaire</title>
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
#submitButtonCell{
	text-align: right;
	padding-right: 250px;
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
    if(isset ($_GET['applicationID']))
    {
        $applicationID=$_GET['applicationID'];
        $_SESSION['applicationID']=$applicationID;
    }
    else if(isset ($_SESSION['applicationID']))
    {
        $applicationID=$_SESSION['applicationID'];
    }
    dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
    $applicationID=mysql_real_escape_string($applicationID);
    $query="SELECT * FROM `application` WHERE `application_ID`='$applicationID'";
    $result=mysql_query($query) or die(mysql_error());
    $fetchedApplication=mysql_fetch_array($result);
    $_SESSION['name']=$fetchedApplication['name'];
    $_SESSION['applicationID']=$fetchedApplication['application_ID'];
    $_SESSION['introText']=$fetchedApplication['intro_text'];
    $_SESSION['language']=$fetchedApplication['language'];
    if(isset ($_REQUEST['submit']))
    {
        $flag=0;
        $_SESSION['fromEditApplication']['language']=$_REQUEST['language'];
        $_SESSION['fromEditApplication']['applicationName']=$_REQUEST['applicationName'];
        $_SESSION['fromEditApplication']['applicationIntro']=$_REQUEST['applicationIntro'];
        if(strlen($_REQUEST['applicationName'])>97)
        {
            $flag=1;
            $_SESSION['appNameLengthFlag']=1;
        }
        else
        {
            $_SESSION['appNameLengthFlag']=0;
        }
        if($_SESSION['name']!=$_REQUEST['applicationName'])//new name is specified
        {
        	$applicationName=mysql_real_escape_string($_REQUEST['applicationName']);
            $query="SELECT count(name) FROM application WHERE name='$applicationName'";
            $result=mysql_query($query) or die (mysql_error());
            $fetchedResult=mysql_fetch_array($result);
            $count=$fetchedResult[0];
            if($count>0)
            {
                $flag=1;
                $_SESSION['uniqueApplicationFlag']=1;
            }
            else
            {
                $_SESSION['uniqueApplicationFlag']=0;
            }
        }
        if(strlen($_REQUEST['applicationIntro'])>250)
        {
            $flag=1;
            $_SESSION['appIntroLengthFlag']=1;
        }
        else
        {
            $_SESSION['appIntroLengthFlag']=0;
        }
        if($_REQUEST['applicationName']=="")
        {
            $flag=1;
            $_SESSION['appNameEmptyFlag']=1;
        }
        else
        {
            $_SESSION['appNameEmptyFlag']=0;
        }
        if($_REQUEST['applicationIntro']=="")//empty introduction
        {
            $_SESSION['fromEditApplication']['applicationIntro']="";
        }
        if($flag==0)
        {
            echo "<meta http-equiv=\"refresh\" content=\"0;URL=../phpScripts/updateApplication.php\" />";
        }
    }
    else
    {
        $_SESSION['appNameLengthFlag']=0;
        $_SESSION['appIntroLengthFlag']=0;
        $_SESSION['appNameEmptyFlag']=0;
        $_SESSION['uniqueApplicationFlag']=0;
        unset ($_SESSION['fromEditApplication']);
        unset ($_SESSION['fromEditApplication']['language']);
        unset ($_SESSION['fromEditApplication']['applicationName']);
        unset ($_SESSION['fromEditApplication']['applicationIntro']);
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
            <p>Edit A Questionnaire</p>
    </td>
</tr>
<form action="editApplication.php" method="post">
<tr>
    <td width="32%" height="45" class="subCatCells">
        <label for="language">Language</label>
    </td>
    <td width="68%" class="subCatCells">

        <select name="language" style="width:250pt">
            <option value="English" <?php
                if(isset ($_SESSION['fromEditApplication']['language']) && $_SESSION['fromEditApplication']['language']=="English")
                {
                    echo "selected";
                }
                else if($_SESSION['language']=="English")
                {
                    echo "selected";
                }
            ?>>English</option>
            <option value="Kiswahili" <?php
                if(isset ($_SESSION['fromEditApplication']['language']) && $_SESSION['fromEditApplication']['language']=="Kiswahili")
                {
                    echo "selected";
                }
                else if($_SESSION['language']=="Kiswahili")
                {
                    echo "selected";
                }
            ?>>Kiswahili</option>
        </select>
    </td>
</tr>
<tr>
    <td height="45" class="subCatCells">
            <label for="applicationName">Name of the Questionnaire</label>
    </td>
    <td class="subCatCells">
        <input type="text" style="width:250pt" name="applicationName" value="<?php
        if(isset ($_SESSION['fromEditApplication']['applicationName']))
        {
            echo $_SESSION['fromEditApplication']['applicationName'];
        }
        else
        {
            echo $_SESSION['name'];
        }?>"/>
        <?php
        if($_SESSION['appNameLengthFlag']==1)
        {
            echo "<font color=\"red\">The name is too long, reduce it</font>";
        }
        else if($_SESSION['appNameEmptyFlag']==1)
        {
            echo "<font color=\"red\">Name cannot be blank</font>";
        }
        else if($_SESSION['uniqueApplicationFlag']==1)
        {
            echo "<font color=\"red\">Name is not Unique</font>";
        }
        ?>
    </td>
</tr>
<tr>
    <td height="90" class="subCatCells">
            <label for="applicationIntro"><p>Introduction text to the Questionnaire</p></label>
    </td>
    <td class="subCatCells">
        <textarea cols="45" rows="4" name="applicationIntro"><?php
        if(isset ($_SESSION['fromEditApplication']['applicationIntro']))
        {
            echo $_SESSION['fromEditApplication']['applicationIntro'];
        }
        else
        {
            echo $_SESSION['introText'];
        }?></textarea>
        <?php
        if($_SESSION['appIntroLengthFlag']==1)
        {
            echo "<font color=\"red\">The introduction is too long</font>";
        }
        ?>
    </td>
</tr>
<!--insert hidden fields for developer and date edited-->
<tr>
    <td height="67" colspan="2" class="subCatCells" id="submitButtonCell">
        <input type="submit" value="Done Editing" name="submit" />
    </td>
</tr>
</form>
</table>
</td>
</tr>
</table>
</body>
</html>