<?php session_start();
$_SESSION['devValidate']=0;
$_SESSION['adminValidate']=0;
if(file_exists("phpScripts/settings.ini"))
{
	$settings=array();
	$settings=parse_ini_file("phpScripts/settings.ini");// or die("error loading settings.ini");
	if(isset($settings['DADatabase']) && isset($settings['resourceDatabase']) && isset($settings['responseDatabase']))
	{
		setcookie('DADatabase',$settings['DADatabase'],0);
		setcookie('resourceDatabase',$settings['resourceDatabase'],0);
		setcookie('responseDatabase',$settings['responseDatabase'],0);
		//setcookie('website','http://www.kaymonneydesigns.com/jason',0);
		//setcookie('generalFieldUsername','kaymonne_root',0);
		//setcookie('generalFieldUserPassword','',0);
		//setcookie('generalDeveloperUsername','kaymonne_root',0);
		//setcookie('generalDeveloperPassword','',0);
		//setcookie('administratorUsername', '', time()-3600);//expires the username and password for the admin if logged in
		//setcookie('administratorPassword', '', time()-3600);
	}
	else
	{
		header("location:pages/installation.php");
	}
}
else
{
	die("An error has occured! 'settings.ini' does not exist in this installation.");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title><?php
    if(isset ($_REQUEST['enter']))
    {
        $flag=0;
        $_SESSION['fromLogin']['loginUserName']=$_REQUEST['loginUserName'];
        $_SESSION['fromLogin']['loginPassword']=$_REQUEST['loginPassword'];
        $_SESSION['fromLogin']['userType']=$_REQUEST['userType'];
        if($_REQUEST['loginUserName']=="" || !isset ($_REQUEST['loginUserName']))
        {
            $flag=1;
            $_SESSION['loginUsernameFlag']=1;
        }
        else
        {
            $_SESSION['loginUsernameFlag']=0;
        }
        if($_REQUEST['loginPassword']=="" || !isset ($_REQUEST['loginUserName']))
        {
            $flag=1;
            $_SESSION['loginPasswordFlag']=1;
        }
        else
        {
            $_SESSION['loginPasswordFlag']=0;
        }
        if($flag==0)//no problem
        {
            echo "<meta http-equiv=\"refresh\" content=\"0;URL=phpScripts/loginConfirmation.php\" />";
        }
    }
    else
    {
        $_SESSION['loginUsernameFlag']=0;
        $_SESSION['loginPasswordFlag']=0;
    }
?>
<style type="text/css">
#loginText {
	font-size: 26px;
	font-family: Verdana, Geneva, sans-serif;
	color: #333;
}
.names{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 16px;
	color: #333;
}
#userTypeID{
	width: 200pt;
}
.submitCell
{
	padding-left: 800px;
}
#enterButton
{
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	background-position: center center;
	height: 27px;
	width: 80px;
	background-attachment: scroll;
	background-image: url(images/Button.jpg);
	background-repeat: no-repeat;
	font-size: 14px;
	background-color: #FFF;
	color: #333;
}
#adminLink{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	color: #1885B4;
	font-weight: normal;
	text-decoration: none;
}
#adminCell{
	padding-left: 150px;
}
</style>
</head>
<body>
<table class="loginScreen" width="100%">
	<tr>
    	<td class="pageHead"><img src="images/Fulcrum.png" width="1332" height="64" align="left" /></td>
    </tr>
    <tr>
<td><!--body section-->
        	<form name="loginForm" class="loginForm" action="login.php" method="post" >
		    <table width="100%" height="428" class="loginFormTable" background="images/LoginBackgournd.jpg">
                    <tr><!--Login heading-->
                    	<td width="12%"></td><td height="86" colspan="2">
                        	<div id="loginText"><p>Login</p></div>
                        </td>
                    </tr>
                    <tr class="inputRows" ><!--username-->
                    	<td></td><td height="51" class="inputScreenInputLableCells" width="8%">
                        	<label for="loginUserName" class="names" >Username</label>
                        </td>
                        <td height="51">

                      <input name="loginUserName" type="text" size="60" class="textInput" value="<?php
                            if(isset ($_SESSION['fromLogin']['loginUserName']))
                            {
                                echo $_SESSION['fromLogin']['loginUserName'];
                            }
                            ?>"/>
                                <?php
                                    if(isset ($_SESSION['loginUsernameFlag']) && $_SESSION['loginUsernameFlag']==1)
                                    {
                                        echo "<font color=\"red\">The Username has to be Specified</font>";
                                    }
                                ?>
                      </td>
                  </tr>
                    <tr class="inputRows"><!--password-->
                    	<td ></td><td class="inputScreenInputLableCells" height="52">
                        	<label for="loginPassword" class="names">Password</label>
                        </td>
                        <td height="52">
                        	<input type="password" name="loginPassword" size="60"/>
                                <?php
                                    if(isset ($_SESSION['loginPasswordFlag']) && $_SESSION['loginPasswordFlag']==1)
                                    {
                                        echo "<font color=\"red\">The Password has to be Specified</font>";
                                    }
                                ?>
                        </td>
                    </tr>
                    <tr>
                        <td ></td><td height="58">
                            <label for="userType" class="names">User Type</label>
                        </td>
                        <td height="58">
                            <select name="userType" id="userTypeID">
                                <option>Researcher</option>
                                <option>Respondent</option>
                            </select>
                        </td>
                    </tr>
                    <tr><!--submit button area-->
                    	<td height="81" colspan="3" class="submitCell">
                            <input type="submit" class="names" value="Enter" name="enter" id="enterButton"/>
                        </td>
              </tr>
                    <tr><!--register user button row-->
                    	<td height="84" id="adminCell" colspan="3">
                        <table><tr><td>
                        	<a href="pages/administratorVerification.php" id="adminLink"><p>Administration</p></a>
                        </td></tr></table>
                        </td>
              </tr>
              </table>
            </form>
        </td>
    </tr>
</table>
</body>
</html>