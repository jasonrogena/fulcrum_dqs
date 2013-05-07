<?php include "../phpScripts/fUserAccessConfirmation.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Respondent Portal</title>
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
.bodyDivision
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
.userAgreement{
	width: 87%;
}
.submitButtonCell{
	text-align: right;
}
#passwordButton{
	text-align: right;
	padding-right: 200px;
}
.finalSubmitButton{
	padding-right: 200px;
	text-align: right;
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
    $fielUsername=$_COOKIE['fieldUsername'];
    $fieldUserPassword=$_COOKIE['fieldPassword'];
    dbConnect($_COOKIE['fieldUsername'],$_COOKIE['fieldPassword']);
    $query="SELECT * FROM `field_user` WHERE username='$fielUsername'";
    $result=mysql_query($query) or die(mysql_error());
    $fieldUser=mysql_fetch_array($result);
    $_SESSION['username']=$fieldUser['username'];
    $_SESSION['first_name']=$fieldUser['first_name'];
    $_SESSION['surname']=$fieldUser['surname'];
    $_SESSION['group_ID']=$fieldUser['group_ID'];
    if(isset ($_REQUEST['submit']))
    {
        $flag=0;
        $_SESSION['fromFUserAccess']['fieldUserFname']=$_REQUEST['fieldUserFname'];
        $_SESSION['fromFUserAccess']['fielsUserSname']=$_REQUEST['fielsUserSname'];
        $_SESSION['fromFUserAccess']['fielsUserUsername']=$_REQUEST['fielsUserUsername'];
        $_SESSION['fromFUserAccess']['oldPassword']=$_REQUEST['oldPassword'];
        $_SESSION['flag2']=0;
        if(isset ($_REQUEST['password']))
        {
            $_SESSION['fromFUserAccess']['password']=$_REQUEST['password'];
            $_SESSION['fromFUserAccess']['rPassword']=$_REQUEST['rPassword'];
            $_SESSION['flag2']=1;
        }
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
        if($_SESSION['username']!=$_REQUEST['fielsUserUsername'])
        {
        	$newUsername=mysql_real_escape_string($_REQUEST['fielsUserUsername']);
            $query="SELECT count(`username`) FROM `field_user` WHERE `username`='$newUsername'";
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
                $query="SELECT count(`username`) FROM developer WHERE `username`='$newUsername'";
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
        }
        if($_REQUEST['oldPassword']=="")
        {
            $flag=1;
            $_SESSION['oldPasswordBlankFlag']=1;
        }
        else
        {
            $_SESSION['oldPasswordBlankFlag']=0;
        }
        if($_REQUEST['oldPassword']!=$_COOKIE['fieldPassword'])
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
            $_SESSION['fromFUserAccess']['password']=$_SESSION['fromFUserAccess']['oldPassword'];
        }
        if($flag==0)
        {
            echo "<meta http-equiv=\"refresh\" content=\"0;URL=../phpScripts/updateFieldUser.php\" />";
        }
        $_SESSION['flag1']=$flag;
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
    }
?>
<script language="javascript" type="text/javascript">
    function editProfile()
    {
        editButton=document.getElementById('editButton');
        editSection=document.getElementById('editSection');
        editButton.style.display="none";
        editSection.style.display="block";
    }
    function editPassword()
    {
        passwordButton=document.getElementById('passwordButton');
        passwordSection=document.getElementById('passwordSection');
        passwordSection2=document.getElementById('passwordSection2');
        passwordButton.style.display="none";
        passwordSection.style.display="block";
	passwordSection2.style.display="block";
        passwordSection.style.height="45px";
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
</head>

<body onload="loading();">
<table width="100%" class="mainTables" id="canvas" style="display:none">
<tr><td id="tableHeader" width="1333" height="64" colspan="5">
<div style="height:25px"><a href="" class="links" style="color:#333"><?php echo "{$_COOKIE['fieldUsername']}";?></a></div>
<div><a href="../phpScripts/logout.php" class="links">logout</a></div>
</td></tr>
<tr>
<td width="9%"><!--the menu-->
</td>
<td class="bodyDivision"><!--LINE DIV-->
</td>
<td width="80%" id="innerBodyCell"><!--inner body-->
<table id="innerBodyTable" width="100%" class="mainTables">
<tr>
    <td height="104" class="rightTitleCell">
        <center>Welcome!</center>
    </td>
</tr>
<tr>
    <td class="subCatCells">
     	<p style="font-size: large">End User License Agreement</p>
        <div class="userAgreement">
        	You are not buying this mobile application, it is offered free to you.<br />
            By downloading and using this application you agree that:<br />
            1. You will not redistribute this application to any other person in any way.<br />
            2. You will not tamper with this application in any way.<br />
            3. You will only use this application with the Fulcrum DQS<sub>&reg;</sub> system and not any other system.<br /><br />
            If you break any of the agreements mentioned above you will be prosecutabe by law. Do not download this application if you intend in breaking any of the agreements mentiond above or any of your state's laws. You, not Fulcrum DQS<sub>&reg;</sub>, will be liable to prosecution by your state.<br /><br />
        </div>
        <p style="font-size: large">Mobile Phone Requirements</p>
        <div class="userAgreement">
        You can download and install this application to you mobile phone if it meets the following minimum requirements:<br />
        1. Java ME 1.1 mobile platform.<br />
        2. S40 mobile device.<br /><br />
        Do not install this application on your mobile phone if you are not sure of it's specifications, conctact the system administrator on +254 715 023 805 and you will be directed on what to do next.<br /><br />
        Fulcrum DQS<sub>&reg;</sub> will not compensate for any damage after you download this mobile application. Otherwise, contact the system administrator on +254 715 023 805 if this application causes your mobile phone to mulfunction. 
        
        </div>
    </td>
</tr>
<tr>
    <td height="73" class="subCatCells">
        <a href="../phpScripts/downloadApplication.php" class="links">
            <center>Download the latest version of the mobile Application</center>
        </a>
    </td>
</tr>
<tr>
    <td class="subCatCells">
        <div style="width: 80%" align="right" id="editButton">
            <input type="button" onclick="JavaScript:editProfile();" value="Edit Your profile"/>
        </div>
        <div id="editSection" style="display:none">
            <form action="fieldUserAccess.php" method="post">
                <table width="100%">
                    <tr>
                        <td width="30%" style="height:45px">
                            <label for="fieldUserFname">First Name</label>
                        </td>
                        <td width="70%">
                            <input type="text" style="width:290px" name="fieldUserFname" value="<?php
                            if(isset ($_SESSION['fromFUserAccess']['fieldUserFname']))
                            {
                                echo $_SESSION['fromFUserAccess']['fieldUserFname'];
                            }
                            else
                            {
                                echo $_SESSION['first_name'];
                            }?>"/>
                            <?php
                            if(isset ($_SESSION['exceedFNameFlag']) && $_SESSION['exceedFNameFlag']==1)
                            {
                                echo "<font color=\"red\">First Name is too long</font>";
                            }
                            else if(isset ($_SESSION['fNameEmptyFlag']) && $_SESSION['fNameEmptyFlag']==1)
                            {
                                echo "<font color=\"red\">Enter First Name</font>";
                            }
                            else if(isset ($_SESSION['fNameTypeFlag']) && $_SESSION['fNameTypeFlag']==1)
                            {
                                echo "<font color=\"red\">Only Alphabetic letters allowed</font>";
                            }
                            ?>
                        </td></tr>
                    <tr>
                    	<td style="height:45px">
                            <label for="fielsUserSname">Surname</label>
                        </td>
                        <td>
                            <input type="text" style="width:290px" name="fielsUserSname" value="<?php
                            if(isset ($_SESSION['fromFUserAccess']['fielsUserSname']))
                            {
                                echo $_SESSION['fromFUserAccess']['fielsUserSname'];
                            }
                            else
                            {
                                echo $_SESSION['surname'];
                            }?>"/>
                            <?php
                            if(isset ($_SESSION['exceedSNameFlag']) && $_SESSION['exceedSNameFlag']==1)
                            {
                                echo "<font color=\"red\">Surname is too long</font>";
                            }
                            else if(isset ($_SESSION['sNameEmptyFlag']) && $_SESSION['sNameEmptyFlag']==1)
                            {
                                echo "<font color=\"red\">Enter Surname</font>";
                            }
                            else if(isset ($_SESSION['sNameTypeFlag']) && $_SESSION['sNameTypeFlag']==1)
                            {
                                echo "<font color=\"red\">Only Alphabetic letters allowed</font>";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="height:45px">
                            <label for="fielsUserUsername">Preferred Username</label>
                        </td>
                        <td>
                            <input type="text" style="width:290px" name="fielsUserUsername" value="<?php
                            if(isset ($_SESSION['fromFUserAccess']['fielsUserUsername']))
                            {
                                echo $_SESSION['fromFUserAccess']['fielsUserUsername'];
                            }
                            else
                            {
                                echo $_SESSION['username'];
                            }?>"/>
                            <?php
                            if(isset ($_SESSION['usernameNullFlag']) && $_SESSION['usernameNullFlag']==1)
                            {
                                echo "<font color=\"red\">Enter Username</font>";
                            }
                            else if(isset ($_SESSION['usernameExcessFlag']) && $_SESSION['usernameExcessFlag']==1)
                            {
                                echo "<font color=\"red\">Username too long</font>";
                            }
                            else if(isset ($_SESSION['usernameDuplicateFlag']) && $_SESSION['usernameDuplicateFlag']==1)
                            {
                                echo "<font color=\"red\">Username is not unique</font>";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="height:45px">
                            <label for="oldPassword">Your Current Password</label>
                         </td>
                         <td>
                            <input type="password" style="width:290px" name="oldPassword"></input>
                            <?php
                            if(isset ($_SESSION['oldPasswordBlankFlag']) && $_SESSION['oldPasswordBlankFlag']==1)
                            {
                                echo "<font color=\"red\">Enter current password</font>";
                            }
                            else if(isset ($_SESSION['oldPasswordWrongFlag']) && $_SESSION['oldPasswordWrongFlag']==1)
                            {
                                echo "<font color=\"red\">Wrong Password</font>";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="passwordButton" onclick="JavaScript:editPassword()">
                                <input type="button" value="Edit your Password"></input>
                            </div>
                            <div id="passwordSection" style="display:none">
                                <label for="password">New Password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                <input type="password" style="width:290px" name="password" />
                            </div>
                            <div id="passwordSection2" style="display:none">
                                <label for="rPassword">Retype Password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                <input type="password" style="width:290px" name="rPassword" />
                                <?php
                                if(isset ($_SESSION['passwordExceed']) && $_SESSION['passwordExceed']==1)
                                {
                                    echo "<font color=\"red\">New password too long</font>";
                                }
                                else if(isset ($_SESSION['passwordNotMatchFlag']) && $_SESSION['passwordNotMatchFlag']==1)
                                {
                                    echo "<font color=\"red\">New passwords do not match</font>";
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="height:45px" class="finalSubmitButton">
                            <input type="submit" value="Finish Editing Your Profile" name="submit"/>
                        </td>
                  </tr>
                </table>
            </form>
        </div>
    </td>
</tr>
<tr>
    <td class="subCatCells">
        <div id="deleteButton" class="finalSubmitButton">
            <input type="button" value="Delete your Account" onclick="JavaScript:deleteUser();"/>
        </div>
        <div id="deleteSection" style = "display:none;">
            <p style="color:#F00">Are you sure you want to delete your User Account?<br/>
            You will no longer be allowed to access this system if you delete your account!</p>
            <form action="../phpScripts/removeFieldUserByFieldUser.php" method="post">
                <input type="button" value="No" onclick="JavaScript:unDeleteUser();"/>
                <input type="submit" value="Yes"/>
            </form>
        </div>
    </td>
</tr>
</table>
</td>
<?php
if(isset ($_SESSION['flag1']) && $_SESSION['flag1']==1)
{
    echo "<script language=\"javascript\" type=\"text/javascript\">editProfile()</script>";
    if(isset ($_SESSION['flag2']) && $_SESSION['flag2']==1)
    {
        echo "<script language=\"javascript\" type=\"text/javascript\">editPassword()</script>";
    }
}
?>
<td class="bodyDivision"><!--LINE DIV-->
</td>
<td width="9%"><!--the menu-->
</td>
</tr>
</table>
</body>
</html>