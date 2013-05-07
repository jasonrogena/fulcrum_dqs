<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
if(isset ($_SESSION['selectedCApplication']))
{
    include '../phpScripts/dbConnect.php';
    dbConnect($_COOKIE['developerUsername'],$_COOKIE['developerPassword']);
    $select_db= mysql_select_db($_COOKIE['responseDatabase']);
    $query="SELECT count(`response_ID`) FROM response ".
    "WHERE `application_ID`='{$_SESSION['selectedCApplication']}'";
    $result=mysql_query($query) or die (mysql_error());
    $fetchedData=mysql_fetch_array($result);
    if(isset ($_SESSION['responseComparison']))
    {
        if($fetchedData[0]>$_SESSION['responseComparison'])
        {
            $_SESSION['comparisonFlag']=1;
        }
        else
        {
            $_SESSION['comparisonFlag']=0;
            echo "<meta http-equiv=\"refresh\" content=\"3;URL=responseChecker.php\" />";
        }
    }
    else
    {
        $_SESSION['responseComparison']=$fetchedData[0];
        echo "<meta http-equiv=\"refresh\" content=\"0;URL=responseChecker.php\" />";
    }
}
?>
<style type="tetext/css">
.links
{
	text-decoration:none;
	color: #1885B4;
	font-family: Verdana, Geneva, sans-serif;
}
</style>
<title>Untitled Document</title>
</head>
<body>
<?php
    if(isset ($_SESSION['comparisonFlag']) && $_SESSION['comparisonFlag']==1)
    {
        $query="SELECT `response_ID`,`date_added`,`field_user` ".
        "FROM  response ".
        "WHERE `application_ID`='{$_SESSION['selectedCApplication']}' ".
        "ORDER BY `date_added` DESC LIMIT 1";
        $result=mysql_query($query) or die(mysql_error());
        $fetchedData=mysql_fetch_array($result);
        if($fetchedData['field_user']!="")
        {
            echo "<a class=\"links\" href=\"addedResponse.php?responseID={$fetchedData['response_ID']}\"  target=\"_blank\">You have just received a new response from {$fetchedData['field_user']} ({$fetchedData['date_added']} GMT)</a>";
        }
    }
    else
    {
        echo "<center><h2>Waiting .....</h2></center>";
    }
?>
</body>
</html>