<?php
    session_start();
    include 'dbConnect.php';
    $devUsername=$_COOKIE['developerUsername'];
    $devPassword=$_COOKIE['developerPassword'];
    dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
    $screenType=mysql_real_escape_string($_SESSION['fromEditScreen']['screenType']);
    $screenID=mysql_real_escape_string($_SESSION['editScreen']['screenID']);
    if(!isset ($_SESSION['overallScreenNO']))
    {
        $_SESSION['overallScreenNO']=0;//the first screen in the application is going to be 0
    }

    if($screenType==1)
    {
        $screenT="Information Screen";
        $heading=mysql_real_escape_string($_SESSION['fromEditScreen']['infoHeading']);
        $text=mysql_real_escape_string($_SESSION['fromEditScreen']['infoText']);
        $_SESSION['screenID']=$screenID;
        $query="UPDATE screen ".
        "SET `heading`='$heading',`text`='$text',`type`='$screenT',`with_os_choice`='0',`with_os_choice_next_screen`='0',`list_size`=NULL,`response_length`=NULL,`date_time_format`='0'".
        "WHERE `screen_ID`='$screenID'";
        $result=mysql_query($query) or die (mysql_error());
        $query="DELETE FROM choice WHERE `screen_ID`='$screenID'";
        $result=mysql_query($query) or die (mysql_error());
    }


    else if ($screenType==2)
    {
        $screenT="Single selection, multiple choice Query";
        $text=mysql_real_escape_string($_SESSION['fromEditScreen']['singleSelectQuestion']);
        $_SESSION['screenID']=$screenID;
        if(isset ($_SESSION['fromEditScreen']['ssWithOSpecify']))
        {
            $withOtherSpecify=1;
            $oSpecifyNextScreen=$_SESSION['applicationID'].$_SESSION['fromEditScreen']['wOSNextScreenSection'].$_SESSION['fromEditScreen']['wOSNextScreen'];//unique key for the next screen
        }
        else
        {
            $withOtherSpecify=0;
            $oSpecifyNextScreen=0;
        }
        $query="UPDATE screen ".
        "SET `heading`=NULL,`text`='$text',`type`='$screenT',`with_os_choice`='$withOtherSpecify',`with_os_choice_next_screen`='$oSpecifyNextScreen',`list_size`=NULL,`response_length`=NULL,`date_time_format`='0'".
        "WHERE `screen_ID`='$screenID'";
        $result=mysql_query($query) or die (mysql_error());
        //add choices to the database
        $query="DELETE FROM choice WHERE `screen_ID`='$screenID'";
        $result=mysql_query($query) or die (mysql_error());
        include 'addSingleSelectChoices.php';
        $choiceArray=$_SESSION['ssChoiceArray'];
        addSingleSelectChoices($choiceArray, $screenID);
        unset ($_SESSION['ssChoiceArray']);
    }


    else if($screenType==3)
    {
        $screenT="Multiple selection, multiple choice Query";
        $text=mysql_real_escape_string($_SESSION['fromEditScreen']['multiSelectQuestion']);
        $_SESSION['screenID']=$screenID;
        if(isset ($_SESSION['fromEditScreen']['msWithOSpecify']))
        {
            $withOtherSpecify=1;
        }
        else
        {
            $withOtherSpecify=0;
        }
        $query="UPDATE screen ".
        "SET `heading`=NULL,`text`='$text',`type`='$screenT',`with_os_choice`='$withOtherSpecify',`with_os_choice_next_screen`='0',`list_size`=NULL,`response_length`=NULL,`date_time_format`='0'".
        "WHERE `screen_ID`='$screenID'";
        $result=mysql_query($query) or die (mysql_error());
        //add choices to database
        $query="DELETE FROM choice WHERE `screen_ID`='$screenID'";
        $result=mysql_query($query) or die (mysql_error());
        include 'addMultiSelectChoices.php';
        $choiceArray=$_SESSION['msChoiceArray'];
        addMultiSelectChoices($choiceArray, $screenID);
        unset ($_SESSION['msChoiceArray']);
    }

    else if($screenType==4)
    {
        $screenT="List response Query";
        $text=mysql_real_escape_string($_SESSION['fromEditScreen']['listQuestion']);
        $_SESSION['screenID']=$screenID;
        $listSize=mysql_real_escape_string($_SESSION['fromEditScreen']['listSize']);
        $responseLength=mysql_real_escape_string($_SESSION['fromEditScreen']['listResponseLength']);
        $query="UPDATE screen ".
        "SET `heading`=NULL,`text`='$text',`type`='$screenT',`with_os_choice`='0',`with_os_choice_next_screen`='0',`list_size`='$listSize',`response_length`='$responseLength',`date_time_format`='0'".
        "WHERE `screen_ID`='$screenID'";
        $result=mysql_query($query) or die (mysql_error());
        $query="DELETE FROM choice WHERE `screen_ID`='$screenID'";
        $result=mysql_query($query) or die (mysql_error());
    }
    else if($screenType==5)
    {
        $screenT="Open ended Question";
        $text=mysql_real_escape_string($_SESSION['fromEditScreen']['openEndedQuestion']);
        $_SESSION['screenID']=$screenID;
        $responseLength=mysql_real_escape_string($_SESSION['fromEditScreen']['openEndedResponseLength']);
        $query="UPDATE screen ".
        "SET `heading`=NULL,`text`='$text',`type`='$screenT',`with_os_choice`='0',`with_os_choice_next_screen`='0',`list_size`=NULL,`response_length`='$responseLength',`date_time_format`='0'".
        "WHERE `screen_ID`='$screenID'";
        $result=mysql_query($query) or die (mysql_error());
        $query="DELETE FROM choice WHERE `screen_ID`='$screenID'";
        $result=mysql_query($query) or die (mysql_error());
    }
    else if($screenType==6)
    {
        $screenT="Ranking Query";
        $text=mysql_real_escape_string($_SESSION['fromEditScreen']['rankingQuestion']);
        $_SESSION['screenID']=$screenID;
        $listSize=mysql_real_escape_string($_SESSION['fromEditScreen']['rankingSizeOfList']);
        $query="UPDATE screen ".
        "SET `heading`=NULL,`text`='$text',`type`='$screenT',`with_os_choice`='0',`with_os_choice_next_screen`='0',`list_size`='$listSize',`response_length`=NULL,`date_time_format`='0'".
        "WHERE `screen_ID`='$screenID'";
        $result=mysql_query($query) or die(mysql_error());
        //add options to be ranked
        $query="DELETE FROM choice WHERE `screen_ID`='$screenID'";
        $result=mysql_query($query) or die (mysql_error());
        $optionArray=$_SESSION['cChoiceArray'];
        include 'addRankingOptions.php';
        addRankingOptions($optionArray, $screenID);
        unset ($_SESSION['cChoiceArray']);
    }
    else if($screenType==7)
    {
        $screenT="DateTime Query";
        $text=mysql_real_escape_string($_SESSION['fromEditScreen']['dateTimeQuestion']);
        $_SESSION['screenID']=$screenID;
        $datetimetype=$_SESSION['fromEditScreen']['datetimetype'];
        if($datetimetype=="date")
        {
            $dtType=0;
        }
        else if($datetimetype=="time")
        {
            $dtType=1;
        }
        else if($datetimetype=="dateTime")
        {
            $dtType=2;
        }
        $query="UPDATE screen ".
        "SET `heading`=NULL,`text`='$text',`type`='$screenT',`with_os_choice`='0',`with_os_choice_next_screen`='0',`list_size`=NULL,`response_length`=NULL,`date_time_format`='$dtType'".
        "WHERE `screen_ID`='$screenID'";
        $result=mysql_query($query) or die (mysql_error());
        $query="DELETE FROM choice WHERE `screen_ID`='$screenID'";
        $result=mysql_query($query) or die (mysql_error());
    }
    if($_SESSION['fromEditScreen']['submitForm']=="--")
    {
        unset ($_SESSION['screenID']);
        unset ($_SESSION['mFlag']);
        unset ($_SESSION['sFlag']);
        unset ($_SESSION['rFlag']);
        header("location:../pages/newScreen.php");
    }
    else if($_SESSION['fromEditScreen']['submitForm']=="--")
    {
        $_SESSION['sectionNO']=$_SESSION['sectionNO']+1;
        unset ($_SESSION['screenID']);
        unset ($_SESSION['mFlag']);
        unset ($_SESSION['sFlag']);
        unset ($_SESSION['rFlag']);
        unset ($_SESSION['screenID']);
        unset ($_SESSION['sectionID']);
        header("location:../pages/newSection.php");
    }
    else if($_SESSION['fromEditScreen']['submitForm']=="I am done editing the Screen")
    {
        unset ($_SESSION['screenID']);
        unset ($_SESSION['mFlag']);
        unset ($_SESSION['sFlag']);
        unset ($_SESSION['rFlag']);
        unset ($_SESSION['screenNO']);
        unset ($_SESSION['screenID']);
        unset ($_SESSION['sectionNO']);
        unset ($_SESSION['sectionID']);
        unset ($_SESSION['overallScreenNO']);
        unset ($_SESSION['ssChoiceArray']);
        unset ($_SESSION['msChoiceArray']);
        unset ($_SESSION['cChoiceArray']);
        unset ($_SESSION['questionNO']);
        unset ($_SESSION['applicationOK']);
        header("location:../pages/reviewApplication.php?selectedApplication={$_SESSION['applicationID']}");
    }
?>
