<?php include "../phpScripts/accessConfirmation.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Your Profile</title>
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
    function editPassword()
    {
        passwordButton=document.getElementById('passwordButton');
        passwordSection=document.getElementById('passwordSection');
		passwordSection2=document.getElementById('passwordSection2');
        passwordButton.style.display="none";
        passwordSection.style.display="block";
		passwordSection.style.height="45px";
		passwordSection2.style.display="block";
		passwordSection2.style.height="45px";
    }
    function deleteUser()
    {
        deleteButton=document.getElementById('deleteButton');
        deleteSection=document.getElementById('deleteSection');
        deleteButton.style.display="none";
        deleteSection.style.display="block";
    }
    function unDeleteUser()
    {
        deleteButton=document.getElementById('deleteButton');
        deleteSection=document.getElementById('deleteSection');
        deleteButton.style.display="block";
        deleteSection.style.display="none";
    }
</script>
<?php
    include '../phpScripts/dbConnect.php';
    $username=$_COOKIE['developerUsername'];
    $password=$_COOKIE['developerPassword'];
    dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
    $query="SELECT * FROM developer WHERE username='$username'";
    $result=mysql_query($query) or die (mysql_error());
    $fetchedResults=mysql_fetch_array($result);
    $_SESSION['devUsername']=$fetchedResults['username'];
    $_SESSION['devFName']=$fetchedResults['first_name'];
    $_SESSION['devSurname']=$fetchedResults['surname'];
    if(isset ($_REQUEST['submit']))
    {
        $flag=0;
        $_SESSION['fromeditDProfile']['developerFname']=$_REQUEST['developerFname'];
        $_SESSION['fromeditDProfile']['developerSname']=$_REQUEST['developerSname'];
        $_SESSION['fromeditDProfile']['developerUsername']=$_REQUEST['developerUsername'];
        $_SESSION['fromeditDProfile']['currentPassword']=$_REQUEST['currentPassword'];
        if(isset ($_REQUEST['password']))
        {
            $_SESSION['fromeditDProfile']['password']=$_REQUEST['password'];
            $_SESSION['fromeditDProfile']['rPassword']=$_REQUEST['rPassword'];
        }
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
        if($_REQUEST['developerUsername']!=$_COOKIE['developerUsername'])
        {
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

        }
        if($_REQUEST['currentPassword']=="")
        {
            $flag=1;
            $_SESSION['currentPasswordBlankFlag']=1;
        }
        else
        {
            $_SESSION['currentPasswordBlankFlag']=0;
        }
        if($_REQUEST['currentPassword']!=$_COOKIE['developerPassword'])
        {
            $flag=1;
            $_SESSION['oldPasswordWrongFlag']=1;
        }
        else
        {
            $_SESSION['oldPasswordWrongFlag']=0;
        }
        if(strlen($_REQUEST['password'])>19)
        {
            $flag=1;
            $_SESSION['passwordExceed']=1;
            $_SESSION['displayNewPasswordsFlag']=1;
        }
        else
        {
            $_SESSION['passwordExceed']=0;
        }
        if($_REQUEST['password']!=$_REQUEST['rPassword'])
        {
            $flag=1;
            $_SESSION['passwordNotMatchFlag']=1;
            $_SESSION['displayNewPasswordsFlag']=1;
        }
        else
        {
            $_SESSION['passwordNotMatchFlag']=0;
        }
        if($_SESSION['fromeditDProfile']['password']=="" && $_SESSION['fromeditDProfile']['rPassword']=="")//if no new password is specified
        {
            $_SESSION['fromeditDProfile']['password']=$_SESSION['fromeditDProfile']['currentPassword'];
        }
        if($flag==0)
        {
            echo "<meta http-equiv=\"refresh\" content=\"0;URL=../phpScripts/updateDeveloper.php\" />";
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
        $_SESSION['currentPasswordBlankFlag']=0;
        $_SESSION['passwordExceed']=0;
        $_SESSION['passwordNotMatchFlag']=0;
        $_SESSION['devUsernameUniqueFlag']=0;
        $_SESSION['usernameNullFlag']=0;
        $_SESSION['displayNewPasswordsFlag']=0;
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
            <p><?php
                    echo $_SESSION['devFName']." ".$_SESSION['devSurname'];
                    if($_SESSION['devSurname'][strlen($_SESSION['devSurname'])-1]=="s")
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
        <form action="editDeveloperProfile.php" method="post">
            <table>
            <tr>
                <td width="190" style="height:45px">
                        <label for="developerFname">First Name</label>
                </td>
                <td width="719">
                        <input type="text" style="width:290px" name="developerFname" value="<?php
                        if(isset ($_SESSION['fromeditDProfile']['developerFname']))
                        {
                            echo $_SESSION['fromeditDProfile']['developerFname'];
                        }
                        else
                        {
                            echo $_SESSION['devFName'];
                        }?>"/>
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
                    <tr><td style="height:45px"><label for="developerSname">Surname</label></td>
                        <td><input type="text" name="developerSname" style="width:290px" value="<?php
                        if(isset ($_SESSION['fromeditDProfile']['developerSname']))
                        {
                            echo $_SESSION['fromeditDProfile']['developerSname'];
                        }
                        else
                        {
                            echo $_SESSION['devSurname'];
                        }?>"/>
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
            <tr><td style="height:45px">
                    <label for="developerUsername">Prefered Username</label></td>
                    <td><input type="text" name="developerUsername" style="width:290px" value="<?php
                    if(isset ($_SESSION['fromeditDProfile']['developerUsername']))
                    {
                        echo $_SESSION['fromeditDProfile']['developerUsername'];
                    }
                    else
                    {
                        echo $_SESSION['devUsername'];
                    }?>" />
                    <?php
                    if(isset ($_SESSION['devUsernameUniqueFlag']) && $_SESSION['devUsernameUniqueFlag']==1)
                    {
                        echo "<font color=\"red\">Username is not unique</font>";
                    }
                    else if(isset ($_SESSION['usernameNullFlag']) && $_SESSION['usernameNullFlag']==1)
                    {
                        echo  "<font color=\"red\">Enter Username</font>";
                    }
                    else if(isset ($_SESSION['usernameExcessFlag']) && $_SESSION['usernameExcessFlag']==1)
                    {
                        echo "<font color=\"red\">Username too long</font>";
                    }
                    ?>
                </td>
            </tr>
            <tr><td style="height:45px">
                    <label for="currentPassword">Current Password</label></td>
                    <td><input type="password" style="width:290px" name="currentPassword" />
                    <?php
                    if(isset ($_SESSION['currentPasswordBlankFlag']) && $_SESSION['currentPasswordBlankFlag']==1)
                    {
                        echo "<font color=\"red\">Enter your Password</font>";
                    }
                    else if(isset ($_SESSION['oldPasswordWrongFlag']) && $_SESSION['oldPasswordWrongFlag']==1)
                    {
                        echo "<font color=\"red\">Wrong Password</font>";
                    }
                    ?>
                </td>
            </tr>
        </table>
        <div id="passwordButton" onclick="JavaScript:editPassword()" style="height:35px">
            <input type="button" value="Edit your Password"></input>
        </div>
        <div id="passwordSection" style="display:none">
            <label for="password">New Password &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="password" name="password" style="width:290px" />
        </div>
        <div id="passwordSection2" style="display:none">
            <label for="rPassword">Retype Password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="password" name="rPassword" style="width:290px" />
            <?php
            if(isset ($_SESSION['passwordExceed']) && $_SESSION['passwordExceed']==1)
            {
                echo "<font color=\"red\">The new Password is too long</font>";
            }
            else if(isset ($_SESSION['passwordNotMatchFlag']) && $_SESSION['passwordNotMatchFlag']==1)
            {
                echo "<font color=\"red\">The new Passwords do not match</font>";
            }
            ?>
        </div>

    <div style="height:30px">
            <input type="submit" value="Finish Editing" name="submit"/>
        </div>
</form>
        <div id="deleteButton">
            <input type="button" value="Delete your User Account" onclick="JavaScript:deleteUser();"/>
        </div>
        <div id="deleteSection" style = "display:none" style="height:30px">
            <p style="color:#F00">Are you sure you want to delete your User Account?<br/>
            You will no longer be allowed to access this system if you delete your account!</p>
            <form action="../phpScripts/removeDeveloperByDeveloper.php" method="post">
                <input type="button" value="No" onclick="JavaScript:unDeleteUser();"/>
                <input type="submit" value="Yes"/>
            </form>
        </div>
    </td>
</tr>
</table>
    <?php
    if(isset ($_SESSION['displayNewPasswordsFlag']) && $_SESSION['displayNewPasswordsFlag']==1)
    {
        echo "<script language=\"javascript\" type=\"text/javascript\">editPassword()</script>";
    }
    ?>
</td>
</tr>
</table>
</body>
</html>