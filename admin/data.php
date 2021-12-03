<?php


echo "<pre>";
echo "USERID\t|\tSTATUS                                          |\tSTARTING DATE         |\tSIZE\n";
echo "-----------------------------------------------------------------------------------------------------\n";
$d = opendir("../subjects/");
while (false !== ($entry = readdir($d))) {
	if(substr($entry,0,1)==".")
		continue;
	echo "<a href=\"?s=$entry\">$entry</a>\t|\t";
	$userID=$entry;
	$pfpath='../subjects/'.$userID.'/presentation.txt';
	$timestamp=filemtime($pfpath);
	$haspres = is_file($pfpath);
	if(!$haspres)
	{
		echo "HAS NEVER LOGGED IN\n";
	}
	else
	{
		$annpath='../subjects/'.$userID.'/';
		$presentation=array();
		//$pfh=fopen($pfpath,'r');
		//while (!feof($pfh)) {
		//	$line = fgets($pfh, 4096);
		//		array_push($presentation,$line);
		//}
		$presentation=loadTxt($pfpath,0);
		$done=0;
		foreach($presentation as $p)
		{
			if(is_file($annpath.trim($p).".csv"))
			{
			    $done++;
			}
		}
		$amount=$done/(count($presentation));
		$amount=floor($amount*10000)/10000; // round to two points after percent decimal
		echo 100*$amount;
		$hutime=date(DATE_RFC822,$timestamp);
		$dirsize=GetDirectorySize('../subjects/'.$userID);
		echo "\t% completed ($done ratings out of ".count($presentation).")\t|$hutime|\t$dirsize \n";
	}

}

echo "\n\n\n\n";
echo "</pre>";
echo "<h2>Other</h2>";
echo "- <a href=\"makezip.php\">Merge all files for download</a>"; 
echo "<br>";
//echo "- <a href=\"../../matlabfiles/\">Matlab script for reading ratings</a>";
