<?php
    function generateXML($applicationID)
    {
        $query="SELECT * FROM application WHERE `application_ID`='$applicationID'";
        $result=mysql_query($query) or die("serverError");
        $applicationContent=mysql_fetch_array($result);
        $xml="<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
        $xml=$xml."<application>".
        "<name>{$applicationContent['name']}</name>".
        "<applicationID>{$applicationContent['application_ID']}</applicationID>".
        "<developerUsername>{$applicationContent['developer_username']}</developerUsername>".
        "<lastEdited>{$applicationContent['last_edited']}</lastEdited>".
        "<language>{$applicationContent['language']}</language>";//screens to be addedd
        $query="SELECT count(*) FROM screen
            INNER JOIN section
            INNER JOIN application
            ON screen.`section_ID` = section.`section_ID` AND section.`application_ID` = application.`application_ID`
            WHERE application.`application_ID` = '$applicationID'";//get the number of screens in the application
        $result=mysql_query($query) or die("serverError");
        $preNoOfScreensArray=mysql_fetch_array($result);
        $preNoOfScreens=0;//try to force php to recogise this var as an int
        $preNoOfScreens=(int) $preNoOfScreensArray[0];//convert to integer
        $query="SELECT count(*)
        FROM section
        WHERE `application_ID`='$applicationID'";
        $result=mysql_query($query) or die ("serverError");
        $noOfSectionsArray=mysql_fetch_array($result);
        $noOfSections=(int) $noOfSectionsArray[0];
        $postNoOFScreens=$preNoOfScreens+$noOfSections+1;//total number of screens in the mobile application
        $xml=$xml."<screens size=\"$postNoOFScreens\">";//
        $screenCount=0;//the first screen in this application has to have 0 as its screenNo
        $screenDisplacement=0;//since the heading and start of sections have been added as screens
        $xml=$xml."<screen type=\"header\">".
        "<screenType>Header</screenType>".
        "<screenNo>$screenCount</screenNo>".
        "<heading>{$applicationContent['name']}</heading>".
        "<introText>{$applicationContent['intro_text']}</introText>".
        "<language>{$applicationContent['language']}</language>".
        "</screen>";
        $screenCount=$screenCount+1;
        $screenDisplacement=$screenDisplacement+1;
        $query="SELECT `section_ID`
            FROM section
            WHERE `application_ID`='$applicationID'";
        $result=mysql_query($query) or die ("serverError");
        $sections=array();
        $count=0;
        while($fetchedSections=mysql_fetch_array($result))
        {
            $sections[$count]=(int)$fetchedSections['section_ID'];
            $count=$count+1;
        }
        $count=0;
        sort($sections);//sort the sections from smallest number to largest therefore from first to last
        $sectionPointer=0;
        while($sectionPointer<count($sections))
        {
            $query="SELECT *
                FROM section
                WHERE `section_ID`='$sections[$sectionPointer]'";
            $result=mysql_query($query) or die("serverError");
            $sectionContent=mysql_fetch_array($result);
            $xml=$xml."<screen type=\"infoScreen\">".
            "<screenType>Information Screen</screenType>".
            "<screenNo>$screenCount</screenNo>".
            "<text>SECTION: {$sectionContent['heading']}\n".
            "{$sectionContent['intro_text']}</text>".
            "<language>{$applicationContent['language']}</language>".
            "</screen>";
            $screenCount=$screenCount+1;
            $screenDisplacement=$screenDisplacement+1;
            $query="SELECT `screen_ID`
                FROM screen
                WHERE `section_ID`='$sections[$sectionPointer]'";
            $result=mysql_query($query) or die ("serverError");
            $screens=array();
            $count=0;
            while($fetchedScreens=  mysql_fetch_array($result))
            {
                $screens[$count]=(int)$fetchedScreens['screen_ID'];
                $count=$count+1;
            }
            $count=0;
            sort($screens);
            $screenPointer=0;
            while($screenPointer < count($screens))
            {
                $query="SELECT *
                    FROM screen
                    WHERE `screen_ID`='$screens[$screenPointer]'";
                $result=mysql_query($query) or die ("serverError");
                $screenContent=mysql_fetch_array($result);
                if($screenContent['type']=="Information Screen")
                {
                    $xml=$xml."<screen type=\"infoScreen\">".
                    "<screenType>{$screenContent['type']}</screenType>".
                    "<screenNo>$screenCount</screenNo>".
                    "<text>{$screenContent['heading']}\n".
                    "{$screenContent['text']}</text>".
                    "<language>{$applicationContent['language']}</language>".
                    "</screen>";
                    $screenCount=$screenCount+1;
                }
                else if($screenContent['type']=="List response Query")
                {
                    $xml=$xml."<screen type=\"list\">".
                    "<screenType>{$screenContent['type']}</screenType>".
                    "<screenNo>$screenCount</screenNo>".
                    "<question>{$screenContent['text']}</question>".
                    "<questionNo>{$screenContent['question_no']}</questionNo>".
                    "<listSize>{$screenContent['list_size']}</listSize>".
                    "<responseLength>{$screenContent['response_length']}</responseLength>".
                    "<language>{$applicationContent['language']}</language>".
                    "</screen>";
                     $screenCount=$screenCount+1;
                }
                else if($screenContent['type']=="Open ended Question")
                {
                    $xml=$xml."<screen type=\"openEnded\">".
                    "<screenType>{$screenContent['type']}</screenType>".
                    "<screenNo>$screenCount</screenNo>".
                    "<question>{$screenContent['text']}</question>".
                    "<questionNo>{$screenContent['question_no']}</questionNo>".
                    "<responseLength>{$screenContent['response_length']}</responseLength>".
                    "<language>{$applicationContent['language']}</language>".
                    "</screen>";
                    $screenCount=$screenCount+1;
                }
                else if($screenContent['type']=="DateTime Query")
                {
                    $xml=$xml."<screen type=\"dateTime\">".
                    "<screenType>{$screenContent['type']}</screenType>".
                    "<screenNo>$screenCount</screenNo>".
                    "<question>{$screenContent['text']}</question>".
                    "<questionNo>{$screenContent['question_no']}</questionNo>".
                    "<language>{$applicationContent['language']}</language>".
                    "<dateTime>{$screenContent['date_time_format']}</dateTime>".
                    "</screen>";
                     
                    $screenCount=$screenCount+1;
                }
                else if($screenContent['type']=="Ranking Query")
                {
                    $xml=$xml."<screen type=\"ranking\">".
                    "<screenType>{$screenContent['type']}</screenType>".
                    "<screenNo>$screenCount</screenNo>".
                    "<question>{$screenContent['text']}</question>".
                    "<questionNo>{$screenContent['question_no']}</questionNo>".
                    "<listSize>{$screenContent['list_size']}</listSize>".
                    "<language>{$applicationContent['language']}</language>";//screen tag has not yet been closed
                    $query="SELECT `choice_ID`
                         FROM choice
                         WHERE `screen_ID`='$screens[$screenPointer]'";//get the number of choices
                     $result=mysql_query($query) or die ("serverError");
                     $count=0;
                     $choices=0;
                     $choices=array();
                     while ($fetchedChoices=mysql_fetch_array($result))//fetch the choices
                     {
                         $choices[$count]=(int)$fetchedChoices['choice_ID'];
                         $count=$count+1;
                     }
                     $count=0;
                     sort($choices);
                     $choiceCount=count($choices);
                     $xml=$xml."<choices size=\"$choiceCount\">";//choice tag not closed
                     $choicePointer=0;
                     while($choicePointer<count($choices))
                     {
                         $query="SELECT text
                             FROM choice
                             WHERE `choice_ID`='$choices[$choicePointer]'";
                         $result=mysql_query($query) or die ("serverError");
                         $choiceContent=mysql_fetch_array($result);
                         $xml=$xml."<choice>{$choiceContent['text']}</choice>";
                         $choicePointer=$choicePointer+1;
                     }
                     $xml=$xml."</choices>".
                         "</screen>";
                    $screenCount=$screenCount+1;
                }
                else if($screenContent['type']=="Multiple selection, multiple choice Query")
                {
                    $xml=$xml."<screen type=\"multiSelect\">".
                    "<screenType>{$screenContent['type']}</screenType>".
                    "<screenNo>$screenCount</screenNo>".
                    "<question>{$screenContent['text']}</question>".
                    "<questionNo>{$screenContent['question_no']}</questionNo>".
                    "<language>{$applicationContent['language']}</language>";
                    $query="SELECT `choice_ID`
                         FROM choice
                         WHERE `screen_ID`='$screens[$screenPointer]'";//get the number of choices
                     $result=mysql_query($query) or die ("serverError");
                     $count=0;
                     $choices=0;
                     $choices=array();
                     while ($fetchedChoices=mysql_fetch_array($result))//fetch the choices
                     {
                         $choices[$count]=(int)$fetchedChoices['choice_ID'];
                         $count=$count+1;
                     }
                     $count=0;
                     sort($choices);
                     $choiceCount=count($choices);
                     $xml=$xml."<choices size=\"$choiceCount\" wOS=\"{$screenContent['with_os_choice']}\">";//choice tag not closed
                     $choicePointer=0;
                     while($choicePointer<count($choices))
                     {
                         $query="SELECT text
                             FROM choice
                             WHERE `choice_ID`='$choices[$choicePointer]'";
                         $result=mysql_query($query) or die ("serverError");
                         $choiceContent=mysql_fetch_array($result);
                         $xml=$xml."<choice>{$choiceContent['text']}</choice>";
                         $choicePointer=$choicePointer+1;
                     }
                     $xml=$xml."</choices>".
                         "</screen>";
                    $screenCount=$screenCount+1;
                }
                else if($screenContent['type']=="Single selection, multiple choice Query")
                {
                    $xml=$xml."<screen type=\"singleSelect\">".
                    "<screenType>{$screenContent['type']}</screenType>".
                    "<screenNo>$screenCount</screenNo>".
                    "<question>{$screenContent['text']}</question>".
                    "<questionNo>{$screenContent['question_no']}</questionNo>".
                    "<language>{$applicationContent['language']}</language>";
                    $query="SELECT `choice_ID`
                         FROM choice
                         WHERE `screen_ID`='$screens[$screenPointer]'";//get the number of choices
                     $result=mysql_query($query) or die ("serverError");
                     $count=0;
                     $choices=0;
                     $choices=array();
                     while ($fetchedChoices=mysql_fetch_array($result))//fetch the choices
                     {
                         $choices[$count]=(int)$fetchedChoices['choice_ID'];
                         $count=$count+1;
                     }
                     $count=0;
                     sort($choices);
                     $choiceCount=count($choices);
                     $xml=$xml."<choices size=\"$choiceCount\" wOS=\"{$screenContent['with_os_choice']}\">";//choice tag not closed
                     $choicePointer=0;
                     while($choicePointer<count($choices))
                     {
                         $query="SELECT text,`next_screen_ID`
                             FROM choice
                             WHERE `choice_ID`='$choices[$choicePointer]'";
                         $result=mysql_query($query) or die ("serverError");
                         $choiceContent=mysql_fetch_array($result);
                         $query="SELECT `overall_screen_no`,`section_ID`
                             FROM screen
                             WHERE `screen_ID`={$choiceContent['next_screen_ID']}";
                         $result=mysql_query($query) or die ("serverError");
                         $fetchedNextScreen=mysql_fetch_array($result);
                         $preNextScreenNo=(int)$fetchedNextScreen['overall_screen_no'];
                         $nextScreenNo=$preNextScreenNo+$screenDisplacement+((int)$fetchedNextScreen['section_ID']-(int)$screenContent['section_ID']);//screen displacement plus the displacement of the sections that have not yet been traversed
                         $xml=$xml."<choice nextScreen=\"$nextScreenNo\">{$choiceContent['text']}</choice>";
                         $choicePointer=$choicePointer+1;
                     }
                     if($screenContent['with_os_choice']==1)
                     {
                         $query="SELECT `overall_screen_no`
                             FROM screen
                             WHERE `screen_ID`={$screenContent['with_os_choice_next_screen']}";
                         $result=mysql_query($query) or die ("serverError");
                         $fetchedNextScreen=mysql_fetch_array($result);
                         $preNextScreenNo=(int)$fetchedNextScreen['overall_screen_no'];
                         $nextScreenNo=$preNextScreenNo+$screenDisplacement;
                         $xml=$xml."<wOS>$nextScreenNo</wOS>";
                     }
                     $xml=$xml."</choices>".
                         "</screen>";
                    $screenCount=$screenCount+1;
                }
                $screenPointer=$screenPointer+1;
            }
            $sectionPointer=$sectionPointer+1;
        }
        $xml=$xml."</screens>".
            "</application>";
        
        $myfile="../xml/".$applicationID.".xml";
        $fo=fopen($myfile, 'w') or die ("cantOpenFile");
        fwrite($fo, $xml);
        fclose($fo);
        echo "$applicationID.xml";
    }
?>
