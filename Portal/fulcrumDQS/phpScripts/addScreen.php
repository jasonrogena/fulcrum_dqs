<?php
    session_start();
    include 'dbConnect.php';
    $devUsername=$_COOKIE['developerUsername'];
    $devPassword=$_COOKIE['developerPassword'];
    dbConnect($_COOKIE['developerUsername'], $_COOKIE['developerPassword']);
    $screenType=$_SESSION['fromEditScreen']['screenType'];
    if(!isset ($_SESSION['overallScreenNO']))
    {
        $_SESSION['overallScreenNO']=0;//the first screen in the application is going to be 0
    }

    if($screenType==1)
    {
        $screenT="Information Screen";
        $heading=mysql_real_escape_string($_SESSION['fromEditScreen']['infoHeading']);
        $text=mysql_real_escape_string($_SESSION['fromEditScreen']['infoText']);
        $screenNO=$_SESSION['screenNO'];
        $oScreenNO=$_SESSION['overallScreenNO'];
        $screenID=$_SESSION['sectionID'].$screenNO;
        $_SESSION['screenID']=$screenID;
        $query="INSERT INTO screen(`screen_ID`,`screen_no`,`section_ID`,type,`overall_screen_no`,heading,text) ".
        "VALUES('$screenID','$screenNO','{$_SESSION['sectionID']}','$screenT','$oScreenNO','$heading','$text')";
        $result=mysql_query($query) or die (mysql_error());
    }


    else if ($screenType==2)
    {
        $screenT="Single selection, multiple choice Query";
        $text=mysql_real_escape_string($_SESSION['fromEditScreen']['singleSelectQuestion']);
        $screenNO=$_SESSION['screenNO'];
        $oScreenNO=$_SESSION['overallScreenNO'];
        $screenID=$_SESSION['sectionID'].$screenNO;
        $_SESSION['screenID']=$screenID;
        if(!isset ($_SESSION['questionNO']))
        {
            $_SESSION['questionNO']=0;
        }
        $questionNO=$_SESSION['questionNO'];
        $_SESSION['questionNO']=$_SESSION['questionNO']+1;
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
        
        $query="INSERT INTO screen(`screen_ID`,`screen_no`,`overall_screen_no`,`section_ID`,`question_no`,type,text,`with_os_choice`,`with_os_choice_next_screen`) ".
        "VALUES('$screenID','$screenNO','$oScreenNO','{$_SESSION['sectionID']}','$questionNO','$screenT','$text','$withOtherSpecify','$oSpecifyNextScreen')";
        $result=mysql_query($query) or die (mysql_error());
        //add choices to the database
        include 'addSingleSelectChoices.php';
        $choiceArray=$_SESSION['ssChoiceArray'];
        addSingleSelectChoices($choiceArray, $screenID);
        unset ($_SESSION['ssChoiceArray']);
    }


    else if($screenType==3)
    {
        $screenT="Multiple selection, multiple choice Query";
        $text=mysql_real_escape_string($_SESSION['fromEditScreen']['multiSelectQuestion']);
        $screenNO=$_SESSION['screenNO'];
        $oScreenNO=$_SESSION['overallScreenNO'];
        $screenID=$_SESSION['sectionID'].$screenNO;
        $_SESSION['screenID']=$screenID;
        if(!isset ($_SESSION['questionNO']))
        {
            $_SESSION['questionNO']=0;//the first question in the application should have the number 0
        }
        $questionNO=$_SESSION['questionNO'];
        $_SESSION['questionNO']=$_SESSION['questionNO']+1;
        if(isset ($_SESSION['fromEditScreen']['msWithOSpecify']))
        {
            $withOtherSpecify=1;
        }
        else
        {
            $withOtherSpecify=0;
        }
        $query="INSERT INTO screen(`screen_ID`,`screen_no`,`overall_screen_no`,`section_ID`,`question_no`,type,text,`with_os_choice`) ".
        "VALUES('$screenID','$screenNO','$oScreenNO','{$_SESSION['sectionID']}','$questionNO','$screenT','$text','$withOtherSpecify')";
        $result=mysql_query($query) or die (mysql_error());
        //add choices to database
        include 'addMultiSelectChoices.php';
        $choiceArray=$_SESSION['msChoiceArray'];
        addMultiSelectChoices($choiceArray, $screenID);
        unset ($_SESSION['msChoiceArray']);
    }

    else if($screenType==4)
    {
        $screenT="List response Query";
        $text=mysql_real_escape_string($_SESSION['fromEditScreen']['listQuestion']);
        $screenNO=$_SESSION['screenNO'];
        $oScreenNO=$_SESSION['overallScreenNO'];
        $screenID=$_SESSION['sectionID'].$screenNO;
        $_SESSION['screenID']=$screenID;
        $listSize=mysql_real_escape_string($_SESSION['fromEditScreen']['listSize']);
        $responseLength=mysql_real_escape_string($_SESSION['fromEditScreen']['listResponseLength']);
        if(!isset ($_SESSION['questionNO']))
        {
            $_SESSION['questionNO']=0;
        }
        $questionNO=$_SESSION['questionNO'];
        $_SESSION['questionNO']=$_SESSION['questionNO']+1;
        $query="INSERT INTO screen(`screen_ID`,`screen_no`,`overall_screen_no`,`section_ID`,`question_no`,type,text,`list_size`,`response_length`) ".
        "VALUES('$screenID','$screenNO','$oScreenNO','{$_SESSION['sectionID']}','$questionNO','$screenT','$text','$listSize','$responseLength')";
        $result=mysql_query($query) or die (mysql_error());
    }
    else if($screenType==5)
    {
        $screenT="Open ended Question";
        $text=mysql_real_escape_string($_SESSION['fromEditScreen']['openEndedQuestion']);
        $screenNO=$_SESSION['screenNO'];
        $oScreenNO=$_SESSION['overallScreenNO'];
        $screenID=$_SESSION['sectionID'].$screenNO;
        $_SESSION['screenID']=$screenID;
        $responseLength=mysql_real_escape_string($_SESSION['fromEditScreen']['openEndedResponseLength']);
        if(!isset ($_SESSION['questionNO']))
        {
            $_SESSION['questionNO']=0;
        }
        $questionNO=$_SESSION['questionNO'];
        $_SESSION['questionNO']=$_SESSION['questionNO']+1;
        $query="INSERT INTO screen(`screen_ID`,`screen_no`,`overall_screen_no`,`section_ID`,`question_no`,type,text,`response_length`) ".
        "VALUES('$screenID','$screenNO','$oScreenNO','{$_SESSION['sectionID']}','$questionNO','$screenT','$text','$responseLength')";
        $result=mysql_query($query) or die (mysql_error());
    }
    else if($screenType==6)
    {
        $screenT="Ranking Query";
        $text=mysql_real_escape_string($_SESSION['fromEditScreen']['rankingQuestion']);
        $screenNO=$_SESSION['screenNO'];
        $oScreenNO=$_SESSION['overallScreenNO'];
        $screenID=$_SESSION['sectionID'].$screenNO;
        $_SESSION['screenID']=$screenID;
        $listSize=mysql_real_escape_string($_SESSION['fromEditScreen']['rankingSizeOfList']);
        if(!isset ($_SESSION['questionNO']))
        {
            $_SESSION['questionNO']=0;
        }
        $questionNO=$_SESSION['questionNO'];
        $_SESSION['questionNO']=$_SESSION['questionNO']+1;
        $query="INSERT INTO screen(`screen_ID`,`screen_no`,`overall_screen_no`,`section_ID`,`question_no`,type,text,`list_size`) ".
        "VALUES('$screenID','$screenNO','$oScreenNO','{$_SESSION['sectionID']}','$questionNO','$screenT','$text','$listSize')";
        $result=mysql_query($query) or die(mysql_error());
        //add options to be ranked
        $optionArray=$_SESSION['cChoiceArray'];
        include 'addRankingOptions.php';
        addRankingOptions($optionArray, $screenID);
        unset ($_SESSION['cChoiceArray']);
    }
    else if($screenType==7)
    {
        $screenT="DateTime Query";
        $text=mysql_real_escape_string($_SESSION['fromEditScreen']['dateTimeQuestion']);
        $screenNO=$_SESSION['screenNO'];
        $oScreenNO=$_SESSION['overallScreenNO'];
        $screenID=$_SESSION['sectionID'].$screenNO;
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
        if(!isset ($_SESSION['questionNO']))
        {
            $_SESSION['questionNO']=0;
        }
        $questionNO=$_SESSION['questionNO'];
        $_SESSION['questionNO']=$_SESSION['questionNO']+1;
         $query="INSERT INTO screen(`screen_ID`,`screen_no`,`overall_screen_no`,`section_ID`,`question_no`,type,text,`date_time_format`) ".
        "VALUES('$screenID','$screenNO','$oScreenNO','{$_SESSION['sectionID']}','$questionNO','$screenT','$text','$dtType')";
        $result=mysql_query($query) or die (mysql_error());
    }

    $_SESSION['overallScreenNO']=$_SESSION['overallScreenNO']+1;
    $_SESSION['screenNO']=$_SESSION['screenNO']+1;
    $_SESSION['theScreenHE']=0;
    if($_SESSION['fromEditScreen']['submitForm']=="Create another Screen")
    {
        unset ($_SESSION['screenID']);
        header("location:../pages/newScreen.php");
    }
    else if($_SESSION['fromEditScreen']['submitForm']=="Create another Section")
    {
        $_SESSION['sectionNO']=$_SESSION['sectionNO']+1;
        unset ($_SESSION['screenID']);
        unset ($_SESSION['sectionID']);
        header("location:../pages/newSection.php");
    }
    else if($_SESSION['fromEditScreen']['submitForm']=="Am done creating the Questionnaire")
    {
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
