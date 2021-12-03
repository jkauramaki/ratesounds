<?php
// 2020-09-09 added white overlay div for sounds to prevent rating them before sound playback has ended -jaakko

include_once('settings.php');
include_once('lib.php');

include('headerform.php');

$stimuli=loadTxt($stimulusfile,0);

$userID=$_GET['userID'];
$p=$_GET['presentation'];


// extra: check out progress on each annotation
$pfpath='./subjects/'.$userID.'/presentation.txt';
// load the presentation 
$presentation=loadTxt($pfpath,0);
// see how much has been done
$done=0;
$annpath='./subjects/'.$userID.'/';
foreach($presentation as $presline)
{
	if(is_file($annpath.trim($presline).".csv"))
	{
		$done++;
	}
}

// $p is the ID of the word to show
$outfile="./subjects/$userID/$p.csv";
$width=900;	// we use the width for pagination
$perc=$_GET['perc'];

$error=$_GET['error'];
if($error=="")
	$error=0;

// error styles
$error_style="border:solid 2px #ff0000;";
$error_msg="";
$error1="";
$error2="";
$error3="";
$error4="";

$deferr=$txt['error_default'];//border:4px solid red;padding:2px;";

switch($error)
{
	case 1:
		$error_msg=(($error_msg=="") ? $txt['error_quality']  : $deferr);
		break;
	case 2:
		$error_msg=(($error_msg=="") ? $txt['error_selection'] : $deferr);
		break;
	case 4:
		$error_msg=(($error_msg=="") ? $txt['error_emotion'] : $deferr);
		break;
	default: // in case of multiple errors
		$error_msg=$deferr;
		break;
}

// set error style using binary logic
if ($error & 1) $error1=$error_style;
if ($error & 2) $error2=$error_style;
if ($error & 4) $error3=$error_style;



if($error>0)
	echo "<div style=\"color:red;font-size:36px\">$error_msg</div>";

?>




<div style="text-align:justify;margin-top:0px;">

<form id="formi" method="POST" action="getsound.php" >
<input type="hidden" name="perc" value="<?php echo $perc;?>">
<input type="hidden" name="userID" value="<?php echo $userID;?>">
<input type="hidden" name="presentation" value="<?php echo $p;?>">
<input type="hidden" name="catnum" id="catnum" value="0">
<audio id="stimaudio">
  <source src="clips/<?php echo $stimuli[$p];?>.mp3" type="audio/mpeg">
  <source src="clips/<?php echo $stimuli[$p];?>.wav" type="audio/wav">
<?php echo $txt['error_html5']; ?> <a href="http://www.mozilla.org/">www.mozilla.org</a>.
</audio> 

<div id="headline"><?php echo $txt['start_audio_button']; ?></div>
<div id="buttons">
	<button id="start" type="button"><?php echo $txt['audio_button_title'];?></button>
</div>

<div id="ratecontainer" style="display:none;">
<br clear=all>
<?php
if ($done>=$n_long_samples && $done<$n_long_samples+$n_practice_samples) echo "<h3>".$txt['practice_phase']."</h3>";
?>
<h4><?php echo $txt['audio_rating_title'];?></h4>
<div style="width:900px;<?php echo($error1); ?>">

<br clear="all">
<div class="slidecontainer">
  <p class="slidermin"><?php echo $txt['audio_rating_min'];?></p><p class="slidermid"><?php echo $txt['audio_rating_mid'];?></p><p class="slidermax"><?php echo $txt['audio_rating_max'];?></p>
  <input type="range" min="1" max="100" value="50" class="slider" id="range1" name="range1">
</div>	

</div>
</div>

<div id="catcontainer" style="display:none;">
<br clear=all>
<h4><?php echo $txt['audio_category_title'];?></h4>
<div style="width:900px;<?php echo($error1); ?>">

<br clear="all">

<?php

// $cat_title and $cat_desc now under texts.php for multiple language support
/*
$cat_title=array(1=> "1. lateraalinen /r/",
2=>"2. frikatiivinen /r/",
3=>"3. dorsaalinen /r/",
4=>"4. uvulaarinen /r/",
5=>"5. substituutio",
6=>"6. lateroflexus /r/",
7=>"7. suomen kielen mukainen /r/",
8=>"8. muu ääntymäpaikka ja/tai -tapa, mikä?");
$cat_desc=array(1=>"kielen oikea tai vasen laide muodostaa /r/:ää muistuttavan äänteen, täry on voimaton ja työläs",
2=>"kieli on oikeassa ääntymispaikassa, mutta kieli ei tärise",
3=>"kielen selkä nousee ylös kitalakeen ja tärisee ylähammasvallin keskiosaa vasten, kielen kärki ei tärise",
4=>"uvula tärisee kielen takaselkää vasten",
5=>"/r/ korvautuu toisella äänteellä",
6=>"äännön aikana kielen kärki kääntyy sivulle",
7=>"",
8=>"");
*/

foreach($cat_title as $idx => $title) {
	if ($idx<8) {
		echo "<button type=\"button\" class=\"cat\" id=\"cat$idx\" onclick=\"changeCat($idx);\"><b>".$title."</b><br><i>".$cat_desc[$idx]."</i></button>\n<br clear=\"all\">";
	} else {
		echo "<button type=\"button\" class=\"cat\" id=\"cat$idx\" onclick=\"changeCat($idx);\"><b>".$title."</b><br>";
		echo "<input type=\"text\" name=\"cattxt\" id=\"cattxt\" placeholder=\"".$txt['audio_cat_freeform']."\" size=\"80\"/>";
		echo "</button>";
	}
}

?>
</div>
</div>
<br clear="all">



<div style="background-color: rgba(255,255,255,0.7); color: rgba(255,255,255,0.7);z-index: 200; display: block;   position: fixed; width: 900px; height: 100%; top: 0;  left: 0;  right: 0;  bottom: 0;     margin-left:auto; margin-right:auto; margin-top:170px; margin-bottom:100px;" id="overlay">
</div>
<script type="text/javascript" src="js/audiojs_<?php echo ($lang);?>.js"></script>

<script>
var slider1 = document.getElementById("range1");

var catElement = document.getElementById("catnum");
var catTxtElement = document.getElementById("cattxt");

slider1.onchange = function() {
  document.getElementById("formi").submit();
}
	

var audioElement = document.getElementById("stimaudio");

audioElement.addEventListener('ended', function() {
    document.getElementById("overlay").style.display = "none";
},false);

<?php
if ($done<$n_long_samples) {
//	echo "document.getElementById(\"submitcontainer\").style.display = \"block\";\n";
	echo "document.getElementById(\"catcontainer\").style.display = \"block\";\n";
} else {
	echo "document.getElementById(\"ratecontainer\").style.display = \"block\";\n";
}
?>


function changeCat(respno) {
	catElement.value=respno;
	for(var i=1; i<=8; i++) {
		if (i==respno) {
			document.getElementById("cat"+i).className = "cat catsel";
		} else {
			document.getElementById("cat"+i).className = "cat";
		}
	}
	
}

</script>
<br clear="all">


<div id="submitcontainer" style="display:block;"><input type="submit" value="<?php echo $txt['continue']; ?> &gt;&gt;" style="margin-top:0px;font-size:20px;font-weight:bold;width:900px;" /></div>
</form>
<br>
<br>
<div style="float:right"><a href="help.php" target="_blank"><?php echo $txt['instructions']; ?></a></div>
<b style="font-size:16px;color:#390"><?php echo $perc;?> % <?php echo $txt['complete']; ?></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $txt['userid'];?>: <b><?php echo $userID; ?></b> 


</div>



<?php
// print_r($_SESSION); // for debug..
include('footer.php');
?>

