<?php
$file="../downloads/Dynamic_Farmer_Querying_System_Mobile.jar";
if (file_exists($file))
{
header('Content-Description: File Transfer');
header("Pragma: public");
header("Cache-Control: public");
header("Content-Type: application/java-archive");
header("Content-Disposition: attachment; filename=\"".$file."\"");
header("Content-Disposition: inline; filename=$file");
header("Content-Transfer-Encoding: binary");
header("Content-length: ".(string)(filesize($file)));
sleep(1);//sleeps for a second
readfile($file);
header("Connection: close");
exit;
}
?>