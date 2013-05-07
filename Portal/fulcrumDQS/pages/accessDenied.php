<?php session_start();
    setcookie('administratorUsername', '', time()-3600);//takes portal to paranoia mode by deleting all usernames and passwords
    setcookie('administratorPassword', '', time()-3600);
    setcookie('developerUsername', '', time()-3600);
    setcookie('developerPassword', '', time()-3600);
    $_SESSION['devValidate']=0;
    $_SESSION['adminValidate']=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="5;URL=../login.php" />
<title>Access Denied</title>
</head>
<body>
	<h1>Access Denied</h1>
    <p>
    	You are not allowed to view this page!
        You will be redirected to the login page in 5 seconds
    </p>
</body>
</html>