<?php
    function  addRankingOptions($optionArray,$screenID)
    {
        $size=count($optionArray);
        $count=0;
        while($count<$size)
        {
            $rank=$count+1;
            $optionID=$screenID.$rank;
            $optionText=mysql_real_escape_string($optionArray[$count]);
            $query="INSERT INTO choice(`choice_ID`,`screen_ID`,text,rank) ".
            "VALUES('$optionID','$screenID','$optionText','$rank')";
            $result=mysql_query($query) or die (mysql_error());
            $count=$count+1;
        }
    }
?>
