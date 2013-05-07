<?php
    session_start();
    include 'dbConnect.php';
    $devUsername=$_COOKIE['developerUsername'];
    $devPassword=$_COOKIE['developerPassword'];
    dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
    $sectionID=$_SESSION['sectionID'];
    if(isset ($_SESSION['fromEditSection']['edit']))//done editing
    {
        $sectionHeading=mysql_real_escape_string($_SESSION['fromEditSection']['sectionName']);
        $introText=mysql_real_escape_string($_SESSION['fromEditSection']['sectionIntro']);
        $query="UPDATE section ".
        "SET heading='$sectionHeading',`intro_text`='$introText' ".
        "WHERE `section_ID`='$sectionID'";
        $result=  mysql_query($query) or die (mysql_error());
        $query="SELECT `application_ID` ".
        "FROM section WHERE `section_ID`='$sectionID'";
        $result=  mysql_query($query) or die (mysql_error());
        $fetchedApplicationID=  mysql_fetch_array($result);
        $_SESSION['applicationID']=$fetchedApplicationID['application_ID'];
        header("location:../pages/reviewApplication.php");
    }
    else if(isset ($_SESSION['fromEditSection']['delete']))//delete section
    {
        $query="SELECT `section_ID` FROM section WHERE `application_ID`='{$_SESSION['applicationID']}'";
        $result=mysql_query($query) or die (mysql_error());
        $count=0;
        $sections=array();
        while($fetchedSectionID=mysql_fetch_array($result))
        {
            $sections[$count]=$fetchedSectionID['section_ID'];
            $count++;
        }
        sort($sections);
        $sectionPointer=0;
        $flag=0;
        while($sectionPointer<count($sections) && $flag==0)
        {
            if($sections[$sectionPointer]==$sectionID)
            {
                $flag=1;
            }
            $sectionPointer++;
        }
        $query="SELECT `screen_ID` FROM screen WHERE `section_ID`='{$sections[$sectionPointer-1]}'";
        $result=mysql_query($query) or die (mysql_error());
        $screensToBeD=array();
        $count=0;
        while($std=mysql_fetch_array($result))
        {
            $screensToBeD[$count]=$std['screen_ID'];
            $count++;
        }
        $count=0;
        while ($count<count($screensToBeD))
        {
            $query="UPDATE screen SET `with_os_choice_next_screen`=NULL WHERE `with_os_choice_next_screen`='{$screensToBeD[$count]}'";
            $result=mysql_query($query) or die (mysql_error());
            $query="UPDATE choice SET `next_screen_ID`=NULL WHERE `next_screen_ID`='{$screensToBeD[$count]}'";
            $result=mysql_query($query) or die (mysql_error());
            $count++;
        }
        $query="DELETE FROM section WHERE `section_ID`='{$sections[$sectionPointer-1]}'";
        $result=mysql_query($query) or die (mysql_error());
        $screens=array();
        $screenPointer=0;
        while($sectionPointer<count($sections))
        {
            $query="UPDATE `section` ".
            "SET `section_no`=`section_no`-1 WHERE `section_ID`='{$sections[$sectionPointer]}'";
            $result=mysql_query($query) or die(mysql_error());
            $query="SELECT `section_no`,`application_ID` ".
            " FROM section WHERE `section_ID`='{$sections[$sectionPointer]}'";
            $result=mysql_query($query) or die (mysql_error());
            $fetchedSection=mysql_fetch_array($result);
            $newSectionID=$fetchedSection['application_ID'].$fetchedSection['section_no'];
            $query="UPDATE section ".
            "SET `section_ID`='$newSectionID' WHERE `section_ID`='{$sections[$sectionPointer]}'";
            $result=mysql_query($query) or die (mysql_error());
            $query="SELECT `screen_ID`,`screen_no` FROM screen WHERE `section_ID`='$newSectionID'";
            $result=mysql_query($query) or die (mysql_error());
            while($fetchedScreen=  mysql_fetch_array($result))
            {
                $screens[$screenPointer]['screenID']=$fetchedScreen['screen_ID'];
                $screens[$screenPointer]['screenNo']=$fetchedScreen['screen_no'];
                $screens[$screenPointer]['sectionID']=$newSectionID;
                $screenPointer++;
            }
            $sectionPointer++;
        }
        $query="SELECT `screen_ID`,`screen_no`,`section_ID` FROM screen";
        $result=mysql_query($query) or die (mysql_error());
        $count=0;
        $allScreens=array();
        while($fetchedScreen=mysql_fetch_array($result))
        {
            $allScreens[$count]['screenID']=$fetchedScreen['screen_ID'];
            $allScreens[$count]['screenNo']=$fetchedScreen['screen_no'];
            $allScreens[$count]['sectionID']=$fetchedScreen['section_ID'];
            $count++;
        }
        $count=0;
        while($count<count($allScreens))
        {
            $newScreenID=$allScreens[$count]['sectionID'].$allScreens[$count]['screenNo'];
            if($newScreenID!=$allScreens[$count]['screenID'])
            {
                $query="UPDATE screen SET `screen_ID`='$newScreenID' WHERE `screen_ID`='{$allScreens[$count]['screenID']}'";
                $result=mysql_query($query) or die (mysql_error());
            }
            $count++;
        }
        $query="SELECT `choice_ID`,`screen_ID`,rank FROM choice";
        $result=mysql_query($query) or die (mysql_error());
        $count=0;
        $allChoices=array();
        while($fetchedChoice=mysql_fetch_array($result))
        {
            $allChoices[$count]['choiceID']=$fetchedChoice['choice_ID'];
            $allChoices[$count]['rank']=$fetchedChoice['rank'];
            $allChoices[$count]['screenID']=$fetchedChoice['screen_ID'];
            $count++;
        }
        $count=0;
        while($count<count($allChoices))
        {
            $newChoiceID=$allChoices[$count]['screenID'].$allChoices[$count]['rank'];
            if($newChoiceID!=$allChoices[$count]['choiceID'])
            {
                $query="UPDATE choice SET `choice_ID`='$newChoiceID' WHERE `choice_ID`='{$allChoices[$count]['choiceID']}'";
                $result=mysql_query($query) or die (mysql_error());
            }
            $count++;
        }
        $count=0;
        while($count<count($screens))
        {
            $newScreenID=$screens[$count]['sectionID'].$screens[$count]['screenNo'];
            $query="UPDATE screen SET `with_os_choice_next_screen`='$newScreenID' WHERE `with_os_choice_next_screen`='{$screens[$count]['screenID']}'";
            $result=mysql_query($query) or die (mysql_error());
            $query="UPDATE choice SET `next_screen_ID`='$newScreenID' WHERE `next_screen_ID`='{$screens[$count]['screenID']}'";
            $result=mysql_query($query) or die (mysql_error());
            $count++;
        }
        $query="SELECT `application_ID` ".
        "FROM section WHERE `section_ID`='$sectionID'";
        $result=  mysql_query($query) or die (mysql_error());
        $fetchedApplicationID=  mysql_fetch_array($result);
        $_SESSION['applicationID']=$fetchedApplicationID['application_ID'];
        header("location:../pages/reviewApplication.php");
    }
    else if(isset ($_SESSION['fromEditSection']['create']))
    {
        if($_SESSION['fromEditSection']['where']=="a")//create new section after this section
        {
            $_SESSION['beforeFlag']=0;
        }
        else//before
        {
             $_SESSION['beforeFlag']=1;
        }
        include 'addSectionInTheMiddle.php';
        addSectionInTheMiddle($sectionID);
    }
?>
