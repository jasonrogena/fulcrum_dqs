<?php
    function  addSingleSelectChoices($choiceArray,$screenID)
    {
        $size=count($choiceArray);
        $count=0;
        while($count<$size)
        {

            $rank=$count+1;
            $choiceID=$screenID.$rank;
            $choice=explode(" - ", $choiceArray[$count]);
            $nextScreenID=$choice[0];
            $choiceText=mysql_real_escape_string($choice[1]);
            $query="INSERT INTO choice(`choice_ID`,`screen_ID`,`next_screen_ID`,text,rank) ".
            "VALUES('$choiceID','$screenID','$nextScreenID','$choiceText','$rank')";
            $result=mysql_query($query) or die (mysql_error());
            $count=$count+1;
        }
    }
?>
