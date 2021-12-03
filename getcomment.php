<?php
include_once('settings.php');
include_once('lib.php');

$userID=$_POST['userID'];

$out="";

$out.=$_POST['comments'];

$file="./subjects/$userID/comments.txt";
$fh = fopen($file, 'w') or die("<h1 style=\"background:red;color:white;\">Error while saving the data. Please contact enrico.glerean@aalto.fi</h1>");
fwrite($fh, $out);
fclose($fh);
$url="session.php?sent=1&userID=$userID"; 
header("Location: $url");
