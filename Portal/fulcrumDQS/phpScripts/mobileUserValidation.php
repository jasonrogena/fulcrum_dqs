<?php
	if(file_exists("settings.ini"))
	{
    	$username=$_POST['username'];
    	$password=$_POST['password'];
    	$settings=array();
		$settings=parse_ini_file("settings.ini");
    	//$DADatabase=$_POST['DADatabase'];
    	$connect=mysql_connect($settings['DADatabase'],$username,$password) or die("invalidUser");//userInvalid echoed if user has not been validated
    	$select_db= mysql_select_db($settings['resourceDatabase']);
    	$query="SELECT password,`group_ID` FROM `field_user` WHERE username='$username'";
    	$result=mysql_query($query) or die ("serverError");
    	$dbpassword=mysql_fetch_array($result);
    	if(isset ($dbpassword['password']) && $dbpassword['password']==$password)
    	{
        	if($dbpassword['group_ID']==NULL)
        	{
            	echo 'noApplication';
        	}
        	else
        	{
            	$query="SELECT `application_ID` FROM `group`
            	INNER JOIN `field_user`
            	ON `group`.`group_ID` = `field_user`.`group_ID`
            	WHERE `field_user`.`username`='$username'";
            	$result=mysql_query($query) or die ("serverError");
            	$fetchedApplicationID=mysql_fetch_array($result);
            	if($fetchedApplicationID['application_ID']==NULL)//no application tied to user
            	{
                	echo 'noApplication';
            	}
            	else
            	{
                	include 'generateApplicationXML.php';
                	generateXML($fetchedApplicationID['application_ID']);
            	}
        	}
    	}
    	else
    	{
        	echo "invalidUser";
    	}
	}
	else
	{
		echo "serverError";
	}
?>
