<?php include"../phpScripts/adminAccessConfirmation.php";//a session has already been started in adminAccessConfirmation?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Register a Researcher</title>
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
#submitbuttonCell{
	
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
    dbConnect($_COOKIE['administratorUsername'],$_COOKIE['administratorPassword']);
    if(isset ($_REQUEST['submit']))
    {
        $flag=0;
        $_SESSION['fromeditDProfile']['developerFname']=$_REQUEST['developerFname'];
        $_SESSION['fromeditDProfile']['developerSname']=$_REQUEST['developerSname'];
        $_SESSION['fromeditDProfile']['developerUsername']=$_REQUEST['developerUsername'];
        $_SESSION['fromeditDProfile']['password']=$_REQUEST['password'];
        $_SESSION['fromeditDProfile']['rPassword']=$_REQUEST['rPassword'];
        if(ctype_alpha($_REQUEST['developerFname'])==false)//digits included
        {
            $flag=1;
            $_SESSION['fNameTypeFlag']=1;
        }
        else
        {
            $_SESSION['fNameTypeFlag']=0;
        }
        if(ctype_alpha($_REQUEST['developerSname'])==false)
        {
            $flag=1;
            $_SESSION['sNameTypeFlag']=1;
        }
        else
        {
            $_SESSION['sNameTypeFlag']=0;
        }
        if(strlen($_REQUEST['developerFname'])>19)
        {
            $flag=1;
            $_SESSION['exceedFNameFlag']=1;
        }
        else
        {
            $_SESSION['exceedFNameFlag']=0;
        }
        if(strlen($_REQUEST['developerSname'])>19)
        {
            $flag=1;
            $_SESSION['exceedSNameFlag']=1;
        }
        else
        {
            $_SESSION['exceedSNameFlag']=0;
        }
        if($_REQUEST['developerFname']=="")
        {
            $flag=1;
            $_SESSION['fNameEmptyFlag']=1;
        }
        else
        {
            $_SESSION['fNameEmptyFlag']=0;
        }
        if($_REQUEST['developerSname']=="")
        {
            $flag=1;
            $_SESSION['sNameEmptyFlag']=1;
        }
        else
        {
            $_SESSION['sNameEmptyFlag']=0;
        }
        if($_REQUEST['developerUsername']=="")
        {
            $flag=1;
            $_SESSION['usernameNullFlag']=1;
        }
        else
        {
            $_SESSION['usernameNullFlag']=0;
        }
        if(strlen($_REQUEST['developerUsername'])>39)
        {
            $flag=1;
            $_SESSION['usernameExcessFlag']=1;
        }
        else
        {
            $_SESSION['usernameExcessFlag']=0;
        }
        $developerUsername=mysql_real_escape_string($_REQUEST['developerUsername']);
        $query="SELECT count(`username`) FROM developer WHERE `username`='$developerUsername'";
        $result=mysql_query($query) or die (mysql_error());
        $fetchedResults=mysql_fetch_array($result);
        $count=$fetchedResults[0];
        if($count>0)
        {
            $flag=1;
            $_SESSION['devUsernameUniqueFlag']=1;
        }
        else
        {
            $query="SELECT count(`username`) FROM `field_user` WHERE username='$developerUsername'";
            $result=mysql_query($query) or die (mysql_error());
            $fetchedResults=mysql_fetch_array($result);
            $count=$fetchedResults[0];
            if($count>0)
            {
                $flag=1;
                $_SESSION['devUsernameUniqueFlag']=1;
            }
            else
            {
                $_SESSION['devUsernameUniqueFlag']=0;
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
        if($_SESSION['fromeditDProfile']['password']=="" && $_SESSION['fromeditDProfile']['rPassword']=="")//if no new password is specified
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
            echo "<meta http-equiv=\"refresh\" content=\"0;URL=../phpScripts/addDeveloper.php\" />";
        }
    }
    else
    {
        unset ($_SESSION['fromeditDProfile']);/*['developerFname']);
        unset ($_SESSION['fromeditDProfile']['developerSname']);
        unset ($_SESSION['fromeditDProfile']['developerUsername']);
        unset ($_SESSION['fromeditDProfile']['currentPassword']);
        unset ($_SESSION['fromeditDProfile']['password']);
        unset ($_SESSION['fromeditDProfile']['rPassword']);*/
        $_SESSION['fNameTypeFlag']=0;
        $_SESSION['sNameTypeFlag']=0;
        $_SESSION['exceedFNameFlag']=0;
        $_SESSION['exceedSNameFlag']=0;
        $_SESSION['fNameEmptyFlag']=0;
        $_SESSION['sNameEmptyFlag']=0;
        $_SESSION['passwordExceed']=0;
        $_SESSION['passwordNotMatchFlag']=0;
        $_SESSION['devUsernameUniqueFlag']=0;
        $_SESSION['usernameNullFlag']=0;
        $_SESSION['passwordNullFlag']=0;
    }
?>
</head>

<body onload="loading();">
<table width="100%" class="mainTables" id="canvas" style="display:none">
<tr><td id="tableHeader" width="1333" height="64" colspan="3">
<div style="height:25px"><a href="" class="links" style="color:#333"><?php echo $_COOKIE['administratorUsername'];?></a></div>
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
            <p>Register a Researcher</p>
    </td>
</tr>

<tr>
    <td class="subCatCells">
        <form action="newDeveloper.php" method="post">
            <table>
                <tr>
                    <td width="191" height="45">
                        <label for="developerFname">First Name</label>
                    </td>
                    <td width="767">
            <input type="text" name="developerFname" style="width:200pt" value="<?php
                        if(isset ($_SESSION['fromeditDProfile']['developerFname']))
                        {
                            echo $_SESSION['fromeditDProfile']['developerFname'];
                        }
                        ?>"/>
                        <?php
                            if(isset ($_SESSION['fNameEmptyFlag']) && $_SESSION['fNameEmptyFlag']==1)
                            {
                                echo "<font color=\"red\">Enter your First Name</font>";
                            }
                            else if(isset ($_SESSION['exceedFNameFlag']) && $_SESSION['exceedFNameFlag']==1)
                            {
                                echo "<font color=\"red\">The first name is too long</font>";
                            }
							else if(isset ($_SESSION['fNameTypeFlag']) && $_SESSION['fNameTypeFlag']==1)
                            {
                                echo "<font color=\"red\">Only Alphabetic letters allowed</font>";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td height="42">
                        <label for="developerSname">Surname</label>
                    </td>
                    <td>
                  <input type="text" name="developerSname" style="width:200pt" value="<?php
                        if(isset ($_SESSION['fromeditDProfile']['developerSname']))
                        {
                            echo $_SESSION['fromeditDProfile']['developerSname'];
                        }
                        ?>"/>
                        <?php
                            if(isset ($_SESSION['sNameEmptyFlag']) && $_SESSION['sNameEmptyFlag']==1)
                            {
                                echo "<font color=\"red\">Enter your Surname</font>";
                            }
                            else if(isset ($_SESSION['exceedSNameFlag']) && $_SESSION['exceedSNameFlag']==1)
                            {
                                echo "<font color=\"red\">The Surname is too long</font>";
                            }
							else if(isset ($_SESSION['sNameTypeFlag']) && $_SESSION['sNameTypeFlag']==1)
                            {
                                echo "<font color=\"red\">Only Alphabetic letters allowed</font>";
                            }
                            ?>
                    </td>
                </tr>
                <tr>
                        <td height="46">
                        <label for="developerUsername">Prefered username</label>
                    </td>
                    <td colspan="3">
                  <input type="text" name="developerUsername" style="width:200pt" value="<?php
                        if(isset ($_SESSION['fromeditDProfile']['developerUsername']))
                        {
                            echo $_SESSION['fromeditDProfile']['developerUsername'];
                        }
                        ?>"/>
                        <?php
                            if(isset ($_SESSION['usernameNullFlag']) && $_SESSION['usernameNullFlag']==1)
                            {
                                echo  "<font color=\"red\">Enter Username</font>";
                            }
                            else if(isset ($_SESSION['usernameExcessFlag']) && $_SESSION['usernameExcessFlag']==1)
                            {
                                echo "<font color=\"red\">Username too long</font>";
                            }
							else if(isset ($_SESSION['devUsernameUniqueFlag']) && $_SESSION['devUsernameUniqueFlag']==1)
                            {
                                echo "<font color=\"red\">Username is not unique</font>";
                            }
                            ?>
                    </td>
                </tr>
                <tr>
                        <td height="44">
                        <label for="password">Password</label>
                    </td>
                    <td>
                        <input type="password" style="width:200pt" name="password" />
                    </td>
                </tr>
                <tr>
                    <td width="191" height="48">
                        <label for="rPassword">Retype Password</label>
                    </td>
                    <td width="767">
                <input type="password" style="width:200pt" name="rPassword" />
                        <?php
							if(isset ($_SESSION['passwordNullFlag']) && $_SESSION['passwordNullFlag']==1)
                            {
                                echo "<font color=\"red\">Enter a Password</font>";
                            }
                            else if(isset ($_SESSION['passwordExceed']) && $_SESSION['passwordExceed']==1)
                            {
                                echo "<font color=\"red\">The new Password is too long</font>";
                            }
                            else if(isset ($_SESSION['passwordNotMatchFlag']) && $_SESSION['passwordNotMatchFlag']==1)
                            {
                                echo "<font color=\"red\">The new Passwords do not match</font>";
                            }
                            ?>
                    </td>
                </tr>
                <tr>
                    <td height="52" colspan="4" id="submitButtonCell" style="text-align:right;padding-right:400px" >
                        <input type="submit" value="Register" name="submit"/>
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