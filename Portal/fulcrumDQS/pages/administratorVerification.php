<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title><?php
    if(isset ($_REQUEST['submit']))
    {
        $flag=0;
        $_SESSION['fromAdmin']['adminUserName']=$_REQUEST['adminUserName'];
        $_SESSION['fromAdmin']['adminPassword']=$_REQUEST['adminPassword'];
        if($_REQUEST['adminUserName']=="")
        {
            $flag=1;
            $_SESSION['adminUsernameFlag']=1;
        }
        else
        {
            $_SESSION['adminUsernameFlag']=0;
        }
        if($_REQUEST['adminPassword']=="")
        {
            $flag=1;
            $_SESSION['adminPasswordFlag']=1;
        }
        else
        {
            $_SESSION['adminPasswordFlag']=0;
        }
        if($flag==0)
        {
            echo "<meta http-equiv=\"refresh\" content=\"0;URL=../phpScripts/adminConfirmation.php\" />";
        }
    }
    else
    {
        $_SESSION['adminUsernameFlag']=0;
        $_SESSION['adminPasswordFlag']=0;
        unset ($_SESSION['fromAdmin']['adminUserName']);
        unset ($_SESSION['fromAdmin']['adminPassword']);
}?>
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
	padding-top: 47px;
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
	background-image: url(../images/Button.jpg);
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
    	<td class="pageHead"><!--head section-->
        <img src="../images/Fulcrum.png" width="1332" height="64" align="left">
      </td>
    </tr>
    <tr>
    	<td><!--body section-->
            <form name="loginForm" class="loginForm" action="administratorVerification.php" method="post" >
            	<table width="100%" height="319" class="loginFormTable" background="../images/LoginBackgournd.jpg">
                    <tr><!--Login heading-->
                    	<td width="12%"></td><td height="72" colspan="2">
                        	<div id="loginText"><p>Administrator Login</p></div>
                        </td>
                    </tr>
                    <tr class="inputRows"><!--username-->
                    	<td></td><td height="51" class="inputScreenInputLableCells" width="8%">
                        	<label for="adminUserName" class="names">Username</label>
                        </td>
                        <td width="80%" height="51">
                            <input name="adminUserName" type="text" size="60" class="textInput" value="<?php
                            if(isset ($_SESSION['fromAdmin']['adminUserName']))
                            {
                                echo $_SESSION['fromAdmin']['adminUserName'];
                            }
                            ?>"/>
                        <?php
                        if(isset ($_SESSION['adminUsernameFlag']) && $_SESSION['adminUsernameFlag']==1)
                        {
                            echo "<font color=\"red\">The Username has to be Specified</font>";
                        }
                        ?>
                        </td>
                    </tr>
                    <tr class="inputRows"><!--password-->
                    	<td></td><td class="inputScreenInputLableCells" height="52">
                        	<label for="adminPassword" class="names">Password</label>
                        </td>
                        <td height="52">
                        	<input type="password" name="adminPassword" size="60"/>
                                <?php
                                if(isset ($_SESSION['adminPasswordFlag']) && $_SESSION['adminPasswordFlag']==1)
                                {
                                    echo "<font color=\"red\">The Password has to be Specified</font>";
                                }
                                ?>
                        </td>
                    </tr>
                    <tr><!--submit button area-->
                    	<td height="118" colspan="3" class="submitCell">
                            <input type="submit" class="names" value="Enter" name="submit" id="enterButton"/>
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>
</body>
</html>