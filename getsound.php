<?php
// handle form data
// 2013-11-15 store data temporarily as session variable so "last" response is remembered in case of error, 
//            plus some error checking with is_numeric() -jaakko

include_once('settings.php');
include_once('lib.php');

$userID=$_POST['userID'];
$p=$_POST['presentation'];

$out="";
$error=0;



$temp=$_POST["range1"];
//if($temp=="") $temp="0";
if(($temp!="") && (is_numeric($temp)) && (($temp + 0)>=0 || ($temp + 0)<=100) ) {
  $_SESSION['lastresp']["range1"]=$temp;
  $out.=$temp.";";
} else {
  $_SESSION['lastresp']["range1"]=-1;
  $error=$error+1;
}

$temp=$_POST["catnum"];
//if($temp=="") $temp="0";
if(($temp!="") && (is_numeric($temp)) && (($temp + 0)>0 || ($temp + 0)<=8) ) {
  $_SESSION['lastresp']["catnum"]=$temp;
  $out.=$temp.";";
} else {
  $_SESSION['lastresp']["catnum"]=-1;
  $error=$error+2;
}

$temp=$_POST["cattxt"];
//if($temp=="") $temp="0";
$_SESSION['lastresp']["cattxt"]=$temp;
$out.=$temp.";";

if($error>0)
{
	$url="soundannotate.php?perc=".$_POST['perc']."&userID=".$_POST['userID']."&presentation=".$_POST['presentation']."&error=$error";
	header("Location: $url");
}
else
{
$_SESSION['lastresp']=array("range1"=>-1,"catnum"=>-1,"cattxt"=>"");
$file="./subjects/$userID/$p".".csv";
$fh = fopen($file, 'w') or die("<h1 style=\"background:red;color:white;\">Error while saving the data. Please contact $adminemail</h1>");
fwrite($fh, $out);
fclose($fh);
$url="session.php?auto=1&userID=$userID"; 
header("Location: $url");
}
