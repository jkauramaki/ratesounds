<?php
include_once('settings.php');
include_once('lib.php');

$users=array();
$subjDir=opendir('./subjects/');

while (false !== ($f = readdir($subjDir))) {
    if($f == "." || $f == "..")
        continue;
    array_push($users,$f);
}
closedir($subjDir);



$userID=$_GET['userID'];
$error=0;
$found=0;
if($userID == "")
    $error =1;  // empty string


if($error >0 ) header("Location: index.php");

foreach($users as $user){
    if($userID == $user)
        $found = 1;
}

if($found==0)
    die('UserID "'.$userID.'" does not exist. <a href="index.php">go back</a>');

// WE HAVE THE SUBJECT, LET'S START THE SESSION

$outtext='';
if($found==1)
{
    if (!isset($_GET['auto']) && !isset($_GET['presentation'])) {
		// 2020-08-28 filter out minimal information (drop IP)
		$techdata_minimal=array();
		if (array_key_exists('UNIQUE_ID',$_SERVER)) $techdata_minimal['UNIQUE_ID']=$_SERVER['UNIQUE_ID'];
		if (array_key_exists('HTTP_REFERER',$_SERVER)) $techdata_minimal['HTTP_REFERER']=$_SERVER['HTTP_REFERER'];
		if (array_key_exists('HTTP_USER_AGENT',$_SERVER)) $techdata_minimal['HTTP_USER_AGENT']=$_SERVER['HTTP_USER_AGENT'];
		if (array_key_exists('REQUEST_TIME_FLOAT',$_SERVER)) $techdata_minimal['REQUEST_TIME_FLOAT']=$_SERVER['REQUEST_TIME_FLOAT'];

		// new style (minimal data):
		$techdata=var_export($techdata_minimal,TRUE);
		// old style:
		//$techdata=var_export($_SERVER,TRUE);
		//$techdata.=var_export($_SESSION,TRUE);
	  
      
		// find out next possible file name
		for ($i=0; $i<=100; $i++) {
			$file="subjects/$userID/techdata$i.txt";
			if (!file_exists($file)) $i=1000; // break out of loop if we find suitable number
		}

		$fh = fopen($file, 'w') or die("There was a disk error. Please email $adminemail");
		fwrite($fh, $techdata);
		fclose($fh);
	}

	
    
    // does it have a presentation file?
    $pfpath='./subjects/'.$userID.'/presentation.txt';
    $haspres = is_file($pfpath);
    // if the file is missing generate it
    
    if(!$haspres)
    {
        makePresentation($pfpath);
    }   
    // load the presentation 
    $presentation=loadTxt($pfpath,0);
    // see how much has been done
    $done=0;
    $annpath='./subjects/'.$userID.'/';
    foreach($presentation as $p)
    {
        if(is_file($annpath.trim($p).".csv"))
        {
            $done++;
        }
    }
    $amount=round($done/(count($presentation)),2); // round to two points after percent decimal
    //$amount=floor($amount*10000)/10000; // round to two points after percent decimal

	if($amount < 1) {
		// 2019-05-27 lisäys alkuun yläreunaan
		$outtext.= "<i>".$txt['register_info']."</i><br>";
    
		$outtext.= "<h1>".$txt['welcome']." <i><u>$userID</u></i>!</h1>";
	} else {
		$outtext.= "<h1>".$txt['thanks_for_participation']." <i><u>$userID</u></i>!</h1>";
	}



    if($amount == 1)
	{
        	$outtext.="<br><br>".$txt['100pcnt_complete'];
		if($_GET['sent']==1) 
			$outtext.="<br><br>".$txt['comment_stored'];
		else
			$outtext.="<form method=\"POST\" action=\"getcomment.php\"><input type=\"hidden\" name=\"userID\" value=\"$userID\"><textarea onclick=\"this.value=''\" name=\"comments\" rows=\"2\" cols=\"20\" style=\"padding:5px;font-size:12px;display:block;width:880px;margin:10px;height:50px;\">".$txt['commentq']."</textarea><input type=\"submit\" value=\"".$txt['comment_send']."\"></form>";
	}
    else
        $outtext.="<br><i>".$txt['completed1']." <span class=\"high\">".(100*$amount)."%</span> ".$txt['completed2'].".</i>";
    
    if($amount < 1)
    {
        //$next=explode('_',$presentation[$done]);
        //echo "<br>The next annotation will be for category <span class=\"high\">".$categories[$next[0]]."</span> and video <span class=\"high\">#".$next[1]."</span><br><br><br>";
	$welcome=loadTxt($welcomefile,0);
	foreach($welcome as $line)
               $outtext.=str_replace(array("<RESCODE>","<UID>"),array($rescode,$userID),$line);
         $outtext.="<h2>".$txt['instructions']."</h2>";
	if(isset($ohjeet))
	{
		$outtext.=$ohjeet;
	}
	else
	{	
		$instructions=loadTxt($instructionsfile,0);
		foreach($instructions as $line)
			$outtext.=$line;
	}
        $presentation=$presentation[$done];
	//echo "<br><br>".$generalText;
        switch($type){
            case 0:
                $link="form";
                break;
            case 1:
                $link="video";
                break;
            case 2:
                $link="paintwords";
                break;
            case 3:
                $link="paintimages";
                break;
            case 4:
                $link="paintaudio";
                break;
	    case 6:
			$link="radioform";
			break;
	    case 7:
			$link="radioform2";
			break;
	    case 8:
			$link="radioform2MP3";
			break;
	    case 9:
			$link="sound";
			break;
	    case 10:
			$link="vidclip";
			break;
	    case 11:
			$link="recaudio";
			break;
            default:
                die("variable $type missing from settings.php");

            }
	$perc=100*$amount;
        $goto=$link."annotate.php?perc=$perc&userID=$userID&presentation=$presentation";
        $outtext.="<br><br><a href=\"$goto\">".$txt['click_to_begin']."</a>";
    }
}

if($_GET['auto']==1 && $amount!=1){
    header("Location: $goto");
    //echo "auto";
}
else
{
    include('header.php');
    echo $outtext;
    include('footer.php');
}
?>
