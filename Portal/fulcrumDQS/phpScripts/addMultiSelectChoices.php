<?php
    function  addMultiSelectChoices($choiceArray,$screenID)
    {
        $size=count($choiceArray);
        $count=0;
        while($count<$size)
        {

            $rank=$count+1;
            $choiceID=$screenID.$rank;
            $choiceText=mysql_real_escape_string($choiceArray[$count]);
            $query="INSERT INTO choice(`choice_ID`,`screen_ID`,text,rank) ".
            "VALUES('$choiceID','$screenID','$choiceText','$rank')";
            $result=mysql_query($query) or die (mysql_error());
            $count=$count+1;
        }
    }
?>