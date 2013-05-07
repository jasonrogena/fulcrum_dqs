<?php include "../phpScripts/accessConfirmation.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Questionnaire Review</title>
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
.sectionDivs
{
    margin-left: 2.4em;
    width: 95%;
}
.choiceTable
{
    font-size: small;
    text-decoration: none;
    height: 30px;
    margin-left: 6.2em;
}
.screenDivs
{
    width: 90%;
    margin-left: 4em;
}
.editLinks
{
    text-decoration: none;
    color: black;
    font-size: small;
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
function mouseIn()
{
    element=getElementById("application");
    element.style.backgroundColor="blue";
}
function mouseOut(elementID)
{
    element=getElementById(elementID);
    element.style.backgroundColor="white";
}
</script>
<?php
    unset ($_SESSION['sFlag']);
    unset ($_SESSION['mFlag']);
    unset ($_SESSION['rFlag']);
    include '../phpScripts/dbConnect.php';
    $flag=0;
    if(isset ($_REQUEST['selectedApplication']))
    {
        $selectedApplication=$_REQUEST['selectedApplication'];
        $_SESSION['applicationID']=$_REQUEST['selectedApplication'];
    }
    else if(isset ($_SESSION['applicationID']))
    {
        $selectedApplication=$_SESSION['applicationID'];
        $flag=1;
    }
    if($selectedApplication=="" && $flag==0)
    {
        header("location:applications.php");
    }
    dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
    $query="SELECT * FROM application WHERE `application_ID`='$selectedApplication'";
    $result=mysql_query($query) or die (mysql_error());
    $fetchedResults=mysql_fetch_array($result);
    $_SESSION['application']['name']=$fetchedResults['name'];
    $_SESSION['application']['ID']=$fetchedResults['application_ID'];
    $_SESSION['application']['introText']=$fetchedResults['intro_text'];
    $_SESSION['application']['language']=$fetchedResults['language'];
    $query="SELECT `screen_ID` FROM `screen`
        INNER JOIN `section`
        ON `section`.`section_ID` = `screen`.`section_ID`
        WHERE `section`.`application_ID`='{$_SESSION['applicationID']}'";
        $result=mysql_query($query) or die (mysql_error());
        $screens=array();
        $count=0;
        while($fetchedScreen=  mysql_fetch_array($result))
        {
            $screens[$count]=$fetchedScreen['screen_ID'];
            $count++;
        }
        sort($screens);
        $count=0;
        $questionCount=0;
        while($count<count($screens))
        {
            $query="SELECT type FROM screen WHERE `screen_ID`='$screens[$count]'";
            $result=mysql_query($query) or die (mysql_error());
            $fetchedType=mysql_fetch_array($result);
            if($fetchedType['type']=="Information Screen")
            {
                $query="UPDATE screen SET `overall_screen_no`='$count' WHERE `screen_ID`='$screens[$count]'";
                $result=mysql_query($query) or die (mysql_error());
            }
            else
            {
                $query="UPDATE screen SET `overall_screen_no`='$count',`question_no`='$questionCount' WHERE `screen_ID`='$screens[$count]'";
                $result=mysql_query($query) or die (mysql_error());
                $questionCount=$questionCount+1;
            }
            $count++;
        }
        if(!isset ($_SESSION['applicationOK']) || $_SESSION['applicationOK']!=1)
        {
            echo "<meta http-equiv=\"refresh\" content=\"0;URL=debugger.php?applicationID=$selectedApplication\" />";
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
<table id="innerBodyTable" width="85%" class="mainTables">
<tr>
    <td height="104" class="rightTitleCell">
            <p>Questionnaire Review</p>
    </td>
</tr>
<tr>
    <td class="subCatCells">
        <div onmouseover="JavaScript:this.style.backgroundColor='#BDEDFF';" onmouseout="JavaScript:this.style.backgroundColor='#FFFFFF';">
        <a class="editLinks" href="editApplication.php?applicationID=<?php echo $_SESSION['application']['ID'];?>">
            Name : <?php echo $_SESSION['application']['name'];?><br/>
            Introduction text : <?php echo $_SESSION['application']['introText']?><br/>
            Language : <?php echo $_SESSION['application']['language'];?><br/><br/>
        </a>
        </div>
        <?php
            $query="SELECT `section_ID` ".
            "FROM `section` WHERE `application_ID`='{$_SESSION['application']['ID']}'";
            $result=mysql_query($query) or die (mysql_error());
            $count=0;
            $sections=array ();
            while($fetchedResults=mysql_fetch_array($result))
            {
                $sections[$count]=$fetchedResults['section_ID'];
                $count=$count+1;
            }
            sort($sections);
            $sectionCount=0;
            while($sectionCount<count($sections))
            {
                $query="SELECT * FROM section WHERE `section_ID`='$sections[$sectionCount]'";
                $result=mysql_query($query) or die (mysql_error());
                $sectionData=mysql_fetch_array($result);
                echo "<div class=\"sectionDivs\" onmouseover=\"JavaScript:this.style.backgroundColor='#BDEDFF';\" onmouseout=\"JavaScript:this.style.backgroundColor='#FFFFFF';\">";
                echo "<a class=\"editLinks\" href=\"editSection.php?sectionID={$sectionData['section_ID']}\">";
                echo "Section {$sectionData['section_no']} : {$sectionData['heading']}<br/>";
                echo "Introduction text : {$sectionData['intro_text']}<br/><br/>";
                echo "</a></div>";
                $query="SELECT `screen_ID` FROM screen WHERE `section_ID`='{$sectionData['section_ID']}'";
                $result=mysql_query($query) or die(mysql_error());
                $count=0;
                $screens=array ();
                while($fetchedScreens=mysql_fetch_array($result))
                {
                    $screens[$count]=$fetchedScreens['screen_ID'];
                    $count=$count+1;
                }
                sort($screens);
                $screenCount=0;
                while($screenCount<count($screens))
                {
                    $query="SELECT * FROM screen WHERE `screen_ID`='{$screens[$screenCount]}'";
                    $result=mysql_query($query) or die (mysql_error());
                    $screenData=mysql_fetch_array($result);
                    if($screenData['type']=="Information Screen")
                    {
                        echo "<div class=\"screenDivs\" onmouseover=\"JavaScript:this.style.backgroundColor='#BDEDFF';\" onmouseout=\"JavaScript:this.style.backgroundColor='#FFFFFF';\">";
                        echo "<a class=\"editLinks\" href=\"editScreen.php?screenID={$screenData['screen_ID']}\">";
                        echo "Screen Number : {$screenData['screen_no']}<br/>";
                        echo "Type : {$screenData['type']}<br/>";
                        echo "Heading : {$screenData['heading']}<br/>";
                        echo "Text : {$screenData['text']}<br/><br/>";
                        echo "</a></div>";
                    }
                    else if($screenData['type']=="Single selection, multiple choice Query")
                    {
                        echo "<div class=\"screenDivs\" onmouseover=\"JavaScript:this.style.backgroundColor='#BDEDFF';\" onmouseout=\"JavaScript:this.style.backgroundColor='#FFFFFF';\">";
                        echo "<a class=\"editLinks\" href=\"editScreen.php?screenID={$screenData['screen_ID']}\">";
                        echo "Screen Number : {$screenData['screen_no']}<br/>";
                        echo "Type : {$screenData['type']}<br/>";
                        echo "Question : {$screenData['text']}<br/><br/>";
                        //
                        $query="SELECT `choice_ID` FROM choice WHERE `screen_ID`='{$screenData['screen_ID']}'";
                        $result=mysql_query($query) or die (mysql_error());
                        $count=0;
                        $choices=array ();
                        while($fetchedChoices=mysql_fetch_array($result))
                        {
                            $choices[$count]=$fetchedChoices['choice_ID'];
                            $count=$count+1;
                        }
                        sort($choices);
                        $choiceCount=0;
                        echo "<table class=\"choiceTable\">";
                        echo "<tr><th>Choice</th><th>Next Screen</th></tr>";
                        while($choiceCount<count($choices))
                        {
                            $query="SELECT * FROM choice WHERE `choice_ID`='$choices[$choiceCount]'";
                            $result=mysql_query($query) or die (mysql_error());
                            $choiceData=mysql_fetch_array($result);
                            echo "<tr>";
                            echo "<td>";
                            echo $choiceData['text'];
                            echo "</td>";
                            $query="SELECT `screen_no`,`section_ID` FROM screen WHERE `screen_ID`='{$choiceData['next_screen_ID']}'";
                            $result=mysql_query($query) or die (mysql_error());
                            $nextScreen=mysql_fetch_array($result);
                            $query="SELECT `section_no` FROM section WHERE `section_ID`='{$nextScreen['section_ID']}'";
                            $result=mysql_query($query) or die (mysql_error());
                            $nextSection=mysql_fetch_array($result);
                            $nextScreenDetails=$nextSection['section_no'].":".$nextScreen['screen_no'];
                            echo "<td>";
                            echo "<a class=\"editLinks\" href=\"editScreen.php?screenID={$nextScreen['section_ID']}\">";
                            echo $nextScreenDetails;
                            echo "</a></td></tr>";
                            $choiceCount=$choiceCount+1;
                        }
                        if($screenData['with_os_choice']==1)
                        {
                            echo "<tr><td>Other</td><td>";
                            $query="SELECT `screen_no`,`section_ID` FROM screen WHERE `screen_ID`='{$screenData['with_os_choice_next_screen']}'";
                            $result=mysql_query($query) or die (mysql_error());
                            $nextScreen=mysql_fetch_array($result);
                            $query="SELECT `section_no` FROM section WHERE `section_ID`='{$nextScreen['section_ID']}'";
                            $result=mysql_query($query) or die (mysql_error());
                            $nextSection=mysql_fetch_array($result);
                            $nextScreenDetails=$nextSection['section_no'].":".$nextScreen['screen_no'];
                            echo "<a class=\"editLinks\" href=\"editScreen.php?screenID={$nextScreen['section_ID']}\">";
                            echo $nextScreenDetails;
                            echo "</a></td></tr>";
                        }
                        echo "</table>";
                        echo "</a></div><br/>";
                    }
                    else if($screenData['type']=="Multiple selection, multiple choice Query")
                    {
                        echo "<div class=\"screenDivs\" onmouseover=\"JavaScript:this.style.backgroundColor='#BDEDFF';\" onmouseout=\"JavaScript:this.style.backgroundColor='#FFFFFF';\">";
                        echo "<a class=\"editLinks\" href=\"editScreen.php?screenID={$screenData['screen_ID']}\">";
                        echo "Screen Number : {$screenData['screen_no']}<br/>";
                        echo "Type : {$screenData['type']}<br/>";
                        echo "Question : {$screenData['text']}<br/><br/>";
                        //
                        $query="SELECT `choice_ID` FROM choice WHERE `screen_ID`='{$screenData['screen_ID']}'";
                        $result=mysql_query($query) or die (mysql_error());
                        $count=0;
                        $choices=array ();
                        while($fetchedChoices=mysql_fetch_array($result))
                        {
                            $choices[$count]=$fetchedChoices['choice_ID'];
                            $count=$count+1;
                        }
                        sort($choices);
                        $choiceCount=0;
                        echo "<table class=\"choiceTable\">";
                        echo "<tr><th>Choice</th></tr>";
                        while($choiceCount<count($choices))
                        {
                            $query="SELECT * FROM choice WHERE `choice_ID`='$choices[$choiceCount]'";
                            $result=mysql_query($query) or die (mysql_error());
                            $choiceData=mysql_fetch_array($result);
                            echo "<tr>";
                            echo "<td>";
                            echo $choiceData['text'];
                            echo "</td></tr>";
                            $choiceCount=$choiceCount+1;
                        }
                        if($screenData['with_os_choice']==1)
                        {
                            echo "<tr><td>Other<td/><tr/>";
                        }
                        echo "</table>";
                        echo "</a></div><br/>";
                    }
                    else if($screenData['type']=="List response Query")
                    {
                        echo "<div class=\"screenDivs\" onmouseover=\"JavaScript:this.style.backgroundColor='#BDEDFF';\" onmouseout=\"JavaScript:this.style.backgroundColor='#FFFFFF';\">";
                        echo "<a class=\"editLinks\" href=\"editScreen.php?screenID={$screenData['screen_ID']}\">";
                        echo "Screen Number : {$screenData['screen_no']}<br/>";
                        echo "Type : {$screenData['type']}<br/>";
                        echo "Question : {$screenData['text']}<br/>";
                        echo "Size of the answer list : {$screenData['list_size']}<br/>";
                        echo "Length of each answer (in characters) : {$screenData['response_length']}<br/><br/>";
                        echo "</a></div>";
                    }
                    else if($screenData['type']=="Open ended Question")
                    {
                        echo "<div class=\"screenDivs\" onmouseover=\"JavaScript:this.style.backgroundColor='#BDEDFF';\" onmouseout=\"JavaScript:this.style.backgroundColor='#FFFFFF';\">";
                        echo "<a class=\"editLinks\" href=\"editScreen.php?screenID={$screenData['screen_ID']}\">";
                        echo "Screen Number : {$screenData['screen_no']}<br/>";
                        echo "Type : {$screenData['type']}<br/>";
                        echo "Question : {$screenData['text']}<br/>";
                        echo "Length of the answer (in characters) : {$screenData['response_length']}<br/><br/>";
                        echo "</a></div>";
                    }
                    else if($screenData['type']=="Ranking Query")
                    {
                        echo "<div class=\"screenDivs\" onmouseover=\"JavaScript:this.style.backgroundColor='#BDEDFF';\" onmouseout=\"JavaScript:this.style.backgroundColor='#FFFFFF';\">";
                        echo "<a class=\"editLinks\" href=\"editScreen.php?screenID={$screenData['screen_ID']}\">";
                        echo "Screen Number : {$screenData['screen_no']}<br/>";
                        echo "Type : {$screenData['type']}<br/>";
                        echo "Question : {$screenData['text']}<br/>";
                        echo "Number of ranks : {$screenData['list_size']}<br/><br/>";
                        //
                        $query="SELECT `choice_ID` FROM choice WHERE `screen_ID`='{$screenData['screen_ID']}'";
                        $result=mysql_query($query) or die (mysql_error());
                        $count=0;
                        $choices=array ();
                        while($fetchedChoices=mysql_fetch_array($result))
                        {
                            $choices[$count]=$fetchedChoices['choice_ID'];
                            $count=$count+1;
                        }
                        sort($choices);
                        $choiceCount=0;
                        echo "<table class=\"choiceTable\">";
                        echo "<tr><th>Options</th></tr>";
                        while($choiceCount<count($choices))
                        {
                            $query="SELECT * FROM choice WHERE `choice_ID`='$choices[$choiceCount]'";
                            $result=mysql_query($query) or die (mysql_error());
                            $choiceData=mysql_fetch_array($result);
                            echo "<tr>";
                            echo "<td>";
                            echo $choiceData['text'];
                            echo "</td></tr>";
                            $choiceCount=$choiceCount+1;
                        }
                        echo "</table>";
                        echo "</a></div><br/>";
                    }
                    else if($screenData['type']=="DateTime Query")
                    {
                        echo "<div class=\"screenDivs\" onmouseover=\"JavaScript:this.style.backgroundColor='#BDEDFF';\" onmouseout=\"JavaScript:this.style.backgroundColor='#FFFFFF';\">";
                        echo "<a class=\"editLinks\" href=\"editScreen.php?screenID={$screenData['screen_ID']}\">";
                        echo "Screen Number : {$screenData['screen_no']}<br/>";
                        echo "Type : {$screenData['type']}<br/>";
                        echo "Question : {$screenData['text']}<br/>";
                        if($screenData['date_time_format']==0)
                        {
                            echo "Format for the answer : Date<br/><br/>";
                        }
                        else if($screenData['date_time_format']==1)
                        {
                            echo "Format for the answer : Time<br/><br/>";
                        }
                        else if($screenData['date_time_format']==2)
                        {
                            echo "Format for the answer : Date and Time<br/><br/>";
                        }
                        echo "</a></div>";
                    }
                    $screenCount=$screenCount+1;
                }
                echo "<br/>";
                $sectionCount=$sectionCount+1;
            }
        ?>
    </td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>