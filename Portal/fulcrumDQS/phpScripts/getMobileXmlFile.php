<?php
    $xml=$_REQUEST['xml'];
    $myfile="../xml/onlineTest.xml";
    $fo=fopen($myfile, 'w') or die ("cantOpenFile");
    fwrite($fo, $xml);
    fclose($fo);
    if(file_exists("settings.ini"))
    {
    	$settings=array();
		$settings=parse_ini_file("settings.ini");
    	$password=$_REQUEST['password'];
    	$response=  simplexml_load_string($xml);
    	$dateAdded=  date('Y-m-d H:i:s');
    	$fieldUser=mysql_real_escape_string($response->fieldUser);
    	$applicationID=$response->applicationID;
    	$responseID=$applicationID.$fieldUser.$dateAdded;
    	$connect=mysql_connect($settings['DADatabase'],$fieldUser,$password) or die("invalidUser");
    	$select_db= mysql_select_db($settings['responseDatabase']);

    	$query="INSERT INTO response (`response_ID`,`date_added`,`field_user`,`application_ID`) ".
    	"VALUES ('$responseID','$dateAdded','$fieldUser','$applicationID')";
    	$result=  mysql_query($query) or die("serverError");

    	$questions=$response->queries;
    	foreach ($questions->query as $question)
    	{
        	$questionID=$responseID.$question->questionNo;
        	$questionText=mysql_real_escape_string($question->text);
        	$query="INSERT INTO query (text,`query_ID`,`response_ID`,`question_no`) ".
        	"VALUES ('$questionText','$questionID','$responseID','$question->questionNo')";
        	$result=mysql_query($query) or die ("serverError");

        	$answers=$question->answers;
            foreach ($answers->answer as $answer)
            {
                $answerID=$questionID.$answer->rank;
                $answerText=mysql_real_escape_string($answer->text);
                $query="INSERT INTO answer (text,`answer_ID`,`query_ID`,rank) ".
                "VALUES ('$answerText','$answerID','$questionID','$answer->rank')";
                $result=mysql_query($query) or die ("serverError");
            }
    	}
    	echo "success";
    }
    else
    {
    	echo "serverError";
    }
?>
