<?php
function addSectionInTheMiddle($sectionID)
{
    $query="SELECT `section_ID`,`section_no` FROM section WHERE `application_ID`='{$_SESSION['applicationID']}'";
    $result=mysql_query($query) or die (mysql_error());
    $count=0;
    $sections=array();
    $sectionNos=array();
    while($fetchedSectionID=mysql_fetch_array($result))
    {
        $sections[$count]=$fetchedSectionID['section_ID'];
        $sectionNos[$count]=$fetchedSectionID['section_no'];
        $count++;
    }
    sort($sections);
    sort($sectionNos);
    $sectionPointer=0;
    $flag=0;
    $position=0;
    while($sectionPointer<count($sections) && $flag==0)
    {
        if($sections[$sectionPointer]==$sectionID)
        {
            $position=$sectionPointer;
            $flag=1;
        }
        $sectionPointer++;
    }
    $screens=array();
    $screenPointer=0;
    if($_SESSION['beforeFlag']==1)//true if the new section is to be added before the current section
    {
        $_SESSION['toBeAddedSection']=$sectionID;
        $_SESSION['toBeAddedSectionNo']=$sectionNos[$position];
        $position=$position-1;
    }
    else
    {
        $_SESSION['toBeAddedSection']=$sectionID+1;
        $_SESSION['toBeAddedSectionNo']=$sectionNos[$position]+1;
    }
    $sectionPointer=count($sections)-1;
    while($sectionPointer > $position)
    {
        $query="UPDATE `section` ".
        "SET `section_no`=`section_no`+1 WHERE `section_ID`='{$sections[$sectionPointer]}'";
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
        $sectionPointer=$sectionPointer-1;
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
    $count=count($allScreens)-1;
    while($count>=0)
    {
        $newScreenID=$allScreens[$count]['sectionID'].$allScreens[$count]['screenNo'];
        if($newScreenID!=$allScreens[$count]['screenID'])
        {
            $query="UPDATE screen SET `screen_ID`='$newScreenID' WHERE `screen_ID`='{$allScreens[$count]['screenID']}'";
            $result=mysql_query($query) or die (mysql_error());
        }
        $count=$count-1;
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
    $count=count($allChoices)-1;
    while($count>=0)
    {
        $newChoiceID=$allChoices[$count]['screenID'].$allChoices[$count]['rank'];
        if($newChoiceID!=$allChoices[$count]['choiceID'])
        {
            $query="UPDATE choice SET `choice_ID`='$newChoiceID' WHERE `choice_ID`='{$allChoices[$count]['choiceID']}'";
            $result=mysql_query($query) or die (mysql_error());
        }
        $count=$count-1;
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
    header("location:../pages/newSectionAft.php");
}
?>
