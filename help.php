<?php
include('header.php');
include_once('settings.php');
echo "<h1>{$txt['instructions']}</h1>";
if(isset($ohjeet))
	echo $ohjeet;
else{
	


	$INS=loadTxt($instructionsfile,0);
	$outtext="";
	foreach($INS as $line)
                $outtext.=$line;
	
	echo($outtext);
}
include('footer.php');
