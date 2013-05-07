<?php session_start();
	if(!isset($_SESSION['installErrors']['fileWrite']) || $_SESSION['installErrors']['fileWrite']==1)
	{	$myfile="../phpScripts/settings.ini";
 		$fo=fopen($myfile, 'w');
 		if($fo)//file is writable
 		{
 			$_SESSION['installErrors']['fileWrite']=0;
 		}
 		else
 		{
 			$_SESSION['installErrors']['fileWrite']=1;
 		}
		//fwrite($fo, "");
		fclose($fo);
	}
	if(isset($_REQUEST['usernameSubmit']))//username and host
	{
		$_SESSION['installation']=array();
		$connect=mysql_connect($_REQUEST['host'],$_REQUEST['username'],$_REQUEST['password']);
                if($connect)//is connected successfuly
                {
                    $username=mysql_real_escape_string($_REQUEST['username']);
                    $password=mysql_real_escape_string($_REQUEST['password']);
                    $host=mysql_real_escape_string($_REQUEST['host']);
                    $query="SHOW GRANTS FOR '$username'@'$host'";
                    $result=mysql_query($query) or die (mysql_error());
                    $_SESSION['installation']['userPrivileges']=mysql_fetch_array($result);
                    $_SESSION['installation']['host']=$host;
                    $_SESSION['installation']['username']=$username;
                    $_SESSION['installation']['password']=$password;
                    $connect=mysql_close();
                    $_SESSION['installation']['okUser']=1;
                    if(isset ($_SESSION['installErrors']['mysql']))
                    {
                        unset ($_SESSION['installErrors']['mysql']);
                    }
                }
                else
                {
                    $_SESSION['installErrors']['mysql']=mysql_error();
                    unset ($_SESSION['installation']['okUser']);
                }
	}
	elseif(isset($_REQUEST['dBSubmit']))//databases
	{
		if(isset($_SESSION['installation']) && $_SESSION['installErrors']['fileWrite']==0)//file is writable
		{
			$connect=mysql_connect($_SESSION['installation']['host'],$_SESSION['installation']['username'],$_SESSION['installation']['password']);
			$resourceDb=$_REQUEST['resourceDBName'];
			$responseDb=$_REQUEST['responseDBName'];
			$_SESSION['installation']['resourceDb']=$resourceDb;
			$_SESSION['installation']['responseDb']=$responseDb;
                        if(isset ($resourceDbExists))
                        {
                            unset ($resourceDbExists);
                        }
                        if(isset ($responseDbExists))
                        {
                            unset ($responseDbExists);
                        }
                        $resourceDbExists=mysql_select_db($resourceDb);
                        $responseDbExists=mysql_select_db($responseDb);
                    if(!$resourceDbExists && !$responseDbExists)
                    {
			$query="CREATE DATABASE IF NOT EXISTS $resourceDb
			COLLATE utf8_bin";
			$result=mysql_query($query) or die(mysql_error());
			mysql_select_db($resourceDb);
			
			$query="SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";\n
			
			CREATE TABLE IF NOT EXISTS `administrator` (
			`first_name` varchar(20) COLLATE utf8_bin NOT NULL,
  			`surname` varchar(20) COLLATE utf8_bin NOT NULL,
  			`username` varchar(40) COLLATE utf8_bin NOT NULL,
  			`password` varchar(20) COLLATE utf8_bin NOT NULL,
  			PRIMARY KEY (`username`)) 
  			ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;\n
  			
  			INSERT INTO `administrator` (`first_name`, `surname`, `username`, `password`) VALUES
			('Admin', 'Admin', '{$_SESSION['installation']['username']}', '{$_SESSION['installation']['password']}');\n
			
			CREATE TABLE IF NOT EXISTS `application` (
  			`name` varchar(100) COLLATE utf8_bin NOT NULL,
  			`application_ID` int(5) NOT NULL AUTO_INCREMENT,
  			`intro_text` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  			`developer_username` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  			`last_edited` datetime NOT NULL,
  			`language` varchar(20) COLLATE utf8_bin NOT NULL,
  			PRIMARY KEY (`application_ID`),
  			KEY `developer_usernamefk` (`developer_username`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=53 ;\n
			
			CREATE TABLE IF NOT EXISTS `choice` (
  			`choice_ID` int(13) NOT NULL,
  			`screen_ID` int(11) NOT NULL,
  			`next_screen_ID` int(11) DEFAULT NULL,
  			`text` varchar(50) COLLATE utf8_bin NOT NULL,
  			`rank` int(2) NOT NULL,
  			PRIMARY KEY (`choice_ID`),
  			KEY `screen_IDfk` (`screen_ID`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;\n
			
			CREATE TABLE IF NOT EXISTS `developer` (
  			`first_name` varchar(20) COLLATE utf8_bin NOT NULL,
  			`surname` varchar(20) COLLATE utf8_bin NOT NULL,
  			`username` varchar(40) COLLATE utf8_bin NOT NULL,
  			`password` varchar(20) COLLATE utf8_bin NOT NULL,
  			PRIMARY KEY (`username`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;\n
			
			CREATE TABLE IF NOT EXISTS `field_user` (
  			`username` varchar(40) COLLATE utf8_bin NOT NULL,
  			`first_name` varchar(20) COLLATE utf8_bin NOT NULL,
  			`surname` varchar(20) COLLATE utf8_bin NOT NULL,
  			`password` varchar(20) COLLATE utf8_bin NOT NULL,
  			`group_ID` int(10) DEFAULT NULL,
  			`developer_username` varchar(40) COLLATE utf8_bin NOT NULL,
  			PRIMARY KEY (`username`),
  			KEY `group_IDfk` (`group_ID`),
  			KEY `developer_username` (`developer_username`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;\n
			
			CREATE TABLE IF NOT EXISTS `group` (
  			`group_name` varchar(20) COLLATE utf8_bin NOT NULL,
  			`group_ID` int(10) NOT NULL AUTO_INCREMENT,
  			`application_ID` int(5) DEFAULT NULL,
  			`developer_username` varchar(40) COLLATE utf8_bin NOT NULL,
  			PRIMARY KEY (`group_ID`),
  			KEY `application_IDfk` (`application_ID`),
  			KEY `developer_username` (`developer_username`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=27 ;\n
			
			CREATE TABLE IF NOT EXISTS `screen` (
  			`screen_no` int(3) NOT NULL,
  			`screen_ID` int(11) NOT NULL,
  			`section_ID` int(8) NOT NULL,
  			`question_no` int(3) DEFAULT NULL,
  			`type` varchar(50) COLLATE utf8_bin NOT NULL,
  			`heading` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  			`text` varchar(255) COLLATE utf8_bin NOT NULL,
  			`next_screen_ID` int(11) DEFAULT NULL,
  			`with_os_choice` int(1) NOT NULL DEFAULT '0',
  			`with_os_choice_next_screen` int(11) DEFAULT '0',
  			`list_size` int(2) DEFAULT NULL,
  			`response_length` int(3) DEFAULT NULL,
  			`overall_screen_no` int(3) NOT NULL,
  			`date_time_format` int(1) DEFAULT '0',
  			PRIMARY KEY (`screen_ID`),
  			KEY `section_IDfk` (`section_ID`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;\n
			
			CREATE TABLE IF NOT EXISTS `section` (
  			`heading` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  			`section_no` int(3) NOT NULL,
  			`section_ID` int(8) NOT NULL,
  			`application_ID` int(5) NOT NULL,
  			`intro_text` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  			PRIMARY KEY (`section_ID`),
  			KEY `application_IDfk` (`application_ID`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;\n
			
			ALTER TABLE `application`
  			ADD CONSTRAINT `application_ibfk_1` FOREIGN KEY (`developer_username`) REFERENCES `developer` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;\n
  			
  			ALTER TABLE `choice`
  			ADD CONSTRAINT `choice_ibfk_1` FOREIGN KEY (`screen_ID`) REFERENCES `screen` (`screen_ID`) ON DELETE CASCADE ON UPDATE CASCADE;\n
  			
  			ALTER TABLE `field_user`
  			ADD CONSTRAINT `field_user_ibfk_2` FOREIGN KEY (`developer_username`) REFERENCES `developer` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  			ADD CONSTRAINT `field_user_ibfk_3` FOREIGN KEY (`group_ID`) REFERENCES `group` (`group_ID`) ON DELETE SET NULL ON UPDATE CASCADE;\n
  			
  			ALTER TABLE `group`
  			ADD CONSTRAINT `group_ibfk_1` FOREIGN KEY (`application_ID`) REFERENCES `application` (`application_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  			ADD CONSTRAINT `group_ibfk_2` FOREIGN KEY (`developer_username`) REFERENCES `developer` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;\n
  			
  			ALTER TABLE `screen`
  			ADD CONSTRAINT `screen_ibfk_1` FOREIGN KEY (`section_ID`) REFERENCES `section` (`section_ID`) ON DELETE CASCADE ON UPDATE CASCADE;\n
  			
  			ALTER TABLE `section`
  			ADD CONSTRAINT `section_ibfk_1` FOREIGN KEY (`application_ID`) REFERENCES `application` (`application_ID`) ON DELETE CASCADE ON UPDATE CASCADE";
			$queryArray=explode(";\n", $query);
			$count=0;
			while($count<count($queryArray))
			{
				$result=mysql_query($queryArray[$count]) or die(mysql_error());
				$count=$count+1;
			}
			$count=0;
			//$result=mysql_query($query) or die(mysql_error());
			
			$query="CREATE DATABASE IF NOT EXISTS $responseDb
			COLLATE utf8_bin;";
			$result=mysql_query($query) or die(mysql_error());
			mysql_select_db($responseDb);
			$query="SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";\n
			
			CREATE TABLE IF NOT EXISTS `answer` (
  			`text` varchar(255) COLLATE utf8_bin NOT NULL,
  			`answer_ID` varchar(70) COLLATE utf8_bin NOT NULL,
  			`query_ID` varchar(68) COLLATE utf8_bin NOT NULL,
  			`rank` int(2) NOT NULL,
  			PRIMARY KEY (`answer_ID`),
  			KEY `fkQueryID` (`query_ID`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;\n
			
			CREATE TABLE IF NOT EXISTS `application` (
  			`name` varchar(100) COLLATE utf8_bin NOT NULL,
  			`application_ID` int(5) NOT NULL,
  			`intro_text` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  			`developer_username` varchar(40) COLLATE utf8_bin NOT NULL,
  			`last_edited` datetime NOT NULL,
  			`language` varchar(20) COLLATE utf8_bin NOT NULL,
  			PRIMARY KEY (`application_ID`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;\n
			
			CREATE TABLE IF NOT EXISTS `query` (
  			`text` varchar(255) COLLATE utf8_bin NOT NULL,
  			`query_ID` varchar(68) COLLATE utf8_bin NOT NULL,
  			`response_ID` varchar(65) COLLATE utf8_bin NOT NULL,
  			`question_no` int(3) NOT NULL,
  			PRIMARY KEY (`query_ID`),
  			KEY `response_ID` (`response_ID`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;\n
			
			CREATE TABLE IF NOT EXISTS `response` (
  			`response_ID` varchar(65) COLLATE utf8_bin NOT NULL,
  			`date_added` datetime NOT NULL,
  			`field_user` varchar(40) COLLATE utf8_bin NOT NULL,
  			`application_ID` int(5) NOT NULL,
  			PRIMARY KEY (`response_ID`),
  			KEY `fkapplicationID` (`application_ID`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;\n
			
			ALTER TABLE `answer`
  			ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`query_ID`) REFERENCES `query` (`query_ID`) ON DELETE CASCADE ON UPDATE CASCADE;\n
  			
  			ALTER TABLE `query`
  			ADD CONSTRAINT `query_ibfk_1` FOREIGN KEY (`response_ID`) REFERENCES `response` (`response_ID`) ON DELETE CASCADE ON UPDATE CASCADE;\n
  			
  			ALTER TABLE `response`
  			ADD CONSTRAINT `response_ibfk_1` FOREIGN KEY (`application_ID`) REFERENCES `application` (`application_ID`) ON DELETE CASCADE ON UPDATE CASCADE";
			
			$queryArray=explode(";\n", $query);
			$count=0;
			while($count<count($queryArray))
			{
				$result=mysql_query($queryArray[$count]) or die(mysql_error());
				$count=$count+1;
			}
			$count=0;
			//$result=mysql_query($query) or die(mysql_error());
			$settings="DADatabase=\"{$_SESSION['installation']['host']}\"\nresourceDatabase=\"$resourceDb\"\nresponseDatabase=\"$responseDb\"";
                        $myfile="../phpScripts/settings.ini";
                        //chmod($myfile, 0777);
                        $fo=fopen($myfile, 'w') or die ("cannot edit settings.ini");
                        fwrite($fo, $settings);
                        fclose($fo);
                        $_SESSION['installErrors']['resourceDbExists']=0;
                        $_SESSION['installErrors']['responseDbExists']=0;
                        $_SESSION['installation']['okDb']=1;
                    }
                    else//one or all of the dbs already exists
                    {
                        if(isset ($_SESSION['installation']['okDb']))
                        {
                            unset ($_SESSION['installation']['okDb']);
                        }
                        if(isset ($resourceDbExists))
                        {
                            $_SESSION['installErrors']['resourceDbExists']=1;
                        }
                        if(isset ($responseDbExists))
                        {
                            $_SESSION['installErrors']['responseDbExists']=1;
                        }
                    }
	}
	else//file not readable
	{
            //die("you have not specified the mysql user and host");
	}
	}
	else if(isset($_REQUEST['doneButton']))
	{
		unset($_SESSION['installation']);
		unset($_SESSION['installErrors']);
		header("location:../");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Installation</title>
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
#firstStep{
	background-image: url(../images/1.png);
	background-repeat: no-repeat;
	background-position: center center;
	width: 45px;
}
#secondStep{
	background-image: url(../images/2.png);
	background-repeat: no-repeat;
	background-position: center center;
	width: 45px;
}
.okButtons{
	padding-left: 500px;
}
.dbSection{
	padding-top: 15px;
}
#doneCell{
	padding-left: 650px;
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
<?php 
	$_SESSION['toNewDeveloper']=0;//after this point if administration is pressed it will go to administartion.php instead of newDeveloper.php
?>
</head>

<body onload="loading();">
<table width="100%" class="mainTables" id="canvas" style="display:block">
<tr><td id="tableHeader" width="1333" height="64" colspan="5">
</td></tr>
<tr>
<td width="9%">
</td>
<td class="bodyDivision"><!--LINE DIV-->
</td>
<td width="80%" id="innerBodyCell"><!--inner body-->
<table width="784">
<tr><td width="776" class="rightTitleCell"><p>Installation</p></td></tr>
<tr>
<td>
<form name="usernameForm" action="installation.php" method="post">
<table>
<tr>
<td width="45" id="firstStep"></td>
<td width="581">
<table>
<tr>
<td width="241" height="38"><label for="username">Mysql username</label></td>
<td width="306"><input type="text" name="username" size="40" id="username" <?php if(isset ($_SESSION['installErrors']['fileWrite']) && $_SESSION['installErrors']['fileWrite']==1)
{
    echo "readonly=\"readonly\" ";
}
if (isset($_SESSION['installation']['username']))
{
	echo "value=\"{$_SESSION['installation']['username']}\" ";
}
    ?>/></td>
</tr>
<tr>
<td height="34"><label for="password">Username's password</label></td>
<td><input type="password" name="password" id="password" size="40" <?php if(isset ($_SESSION['installErrors']['fileWrite']) && $_SESSION['installErrors']['fileWrite']==1)
{
    echo "readonly=\"readonly\" ";
}
if(isset($_SESSION['installation']['password']))
{
	echo "value=\"{$_SESSION['installation']['password']}\" ";
}
    ?>></input></td>
</tr>
<tr>
<td height="34"><label for="host">Mysql server</label></td>
<td><input type="text" name="host" id="host" size="40" <?php if(isset ($_SESSION['installErrors']['fileWrite']) && $_SESSION['installErrors']['fileWrite']==1)
{
    echo "readonly=\"readonly\"";
}
if(isset($_SESSION['installation']['host']))
{
	echo "value=\"{$_SESSION['installation']['host']}\" ";
}
else
{
	echo "value=\"localhost\" ";
}
    ?>></input></td>
</tr>
    <tr><td height="42" colspan="2" class="okButtons"><input type="submit" name="usernameSubmit" id="usernameSubmit" value="Okay" <?php
    if(isset ($_SESSION['installation']['okUser']) && $_SESSION['installation']['okUser']==1)
    {
        echo "style=\"display:none\"";
    }
    else if(isset ($_SESSION['installErrors']['fileWrite']) && $_SESSION['installErrors']['fileWrite']==1)
    {
    	echo "style=\"display:none\"";
    }
    ?> ></input></td></tr>
</table>
</td>
<td width="80"><?php
if(isset ($_SESSION['installation']['okUser']) && $_SESSION['installation']['okUser']==1)
    echo "<img src=\"../images/ok.png\">";
?></td>
</tr>
</table>
</form>
<table><tr><td width="600"><img src="../images/smallLineDiv2.png"/></td></tr></table>
<form action="installation.php" name="dBForm" method="post">
<table>
<tr><td width="45" id="secondStep"></td>
<td width="582">
<table>
<tr >
<td width="240" height="36" class="dbSection"><label for="resourceDBName">Give the resource database a name</label></td>
<td width="306" class="dbSection"><input type="text" name="resourceDBName" size="40" id="resourceDBName" <?php
if(isset ($_SESSION['installErrors']['fileWrite']) && $_SESSION['installErrors']['fileWrite']==1)
{
    echo "readonly=\"readonly\" ";
}
else if(isset ($_SESSION['installErrors']['mysql']))
{
    echo "readonly=\"readonly\" ";
}
if(isset($_SESSION['installation']['resourceDb']))
{
	echo "value=\"{$_SESSION['installation']['resourceDb']}\" ";
}
    ?>></input></td>
</tr>
<tr>
<td height="37"><label for="responseDBName">Give the response database a name</label></td>
<td><input type="text" name="responseDBName" size="40" id="responseDBName" <?php
if(isset ($_SESSION['installErrors']['fileWrite']) && $_SESSION['installErrors']['fileWrite']==1)
{
    echo "readonly=\"readonly\" ";
}
else if(isset ($_SESSION['installErrors']['mysql']))
{
    echo "readonly=\"readonly\" ";
}
if(isset($_SESSION['installation']['responseDb']))
{
	echo "value=\"{$_SESSION['installation']['responseDb']}\" ";
}
    ?>></input></td>
</tr>
<tr>
    <td height="44" colspan="2" class="okButtons"><input type="submit" name="dBSubmit" id="dBSubmit" value="Okay" <?php
    if(isset ($_SESSION['installation']['okUser']) && $_SESSION['installation']['okUser']==1 && !isset ($_SESSION['installation']['okDb']))
    {
        echo "style=\"display:block\"";
    }
    else if(isset ($_SESSION['installation']['okDb']) && $_SESSION['installation']['okDb']==1)
    {
        echo "style=\"display:none\"";
    }
    else
    {
        echo "style=\"display:none\"";
    }
   ?>></input></td>

</tr>
</table>
</td>
<td width="80"><?php
if(isset ($_SESSION['installation']['okDb']) && $_SESSION['installation']['okDb']==1)
{
    echo "<img src=\"../images/ok.png\">";
}?></td>
</tr>
<tr>
    <td height="40" colspan="3" id="doneCell"><input type="submit" name="doneButton" id="doneButton" value="Done" <?php
    if(isset ($_SESSION['installation']['okDb']) && $_SESSION['installation']['okDb']==1)
    {
        echo "style=\"display:block\"";
    }
    else
    {
        echo "style=\"display:none\"";
    }
    ?>></input></td></tr>
</table>
</form>
<table><tr><td><p>Console</p>
<?php 
if(isset($_SESSION['installErrors']['fileWrite']) && $_SESSION['installErrors']['fileWrite']==1)
{
	echo "<p>>The installation is unable to edit 'phpScripts/settings.ini'.\n Try changing the write permissions for this files to fix this issue then reload this page</p>";
}
if(isset($_SESSION['installErrors']['mysql']))
{
	echo "<p>>The system is unable to connect to mysql using the credentials provided\n";
	echo $_SESSION['installErrors']['mysql']."</p>";
}
if(isset($_SESSION['installErrors']['resourceDbExists']) && $_SESSION['installErrors']['resourceDbExists']==1)
{
	echo "<p>>There is already another database with the name '{$_SESSION['installation']['resourceDb']}'.\n Try giving the resource database another name</p>";
}
if(isset($_SESSION['installErrors']['responseDbExists']) && $_SESSION['installErrors']['responseDbExists']==1)
{
	echo "<p>>There is already another database with the name '{$_SESSION['installation']['responseDb']}'.\n Try giving the response database another name</p>";
}
?>
</td></tr></table>
</td>
</tr>
</table>
</td>
<td class="bodyDivision"><!--LINE DIV-->
</td>
<td width="9%">
</td>
</tr>
</table>
</body>
</html>