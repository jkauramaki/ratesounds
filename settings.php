<?php
$a = session_id();
if(empty($a)) session_start();
include_once('lib.php');
$type=9;      // 0 is a form, 1 is a video annotator, 2 is the painting with words, 3 painting with images, 4 painting with audiofile; ... 9 is short audio evaluation
$rescode="ratesounds"; // what is used in url, server_name.com/$rescode/
$path="/var/www/html/$rescode/"; // full path to server
$fromemail="no-reply@helsinki.fi"; // from address for the one-time email
$adminemail="jaakko.kauramaki@helsinki.fi"; // admin email contact in case of server-side issues
$servername="https://servername.invalid"; // server address for the one-time email
$n_long_samples=5;
$n_practice_samples=5;

// Parse language selection, can be set online by adding GET parameter lang=en, e.g. index.php?lang=en or index.php?lang=fi. Or the langauge can be fixed here
if (isset($_GET['lang']) && (in_array($_GET['lang'],array('fi','en')))) {
    $_SESSION['lang']=$lang=$_GET['lang'];
} elseif (isset($_SESSION['lang']) && (in_array($_SESSION['lang'],array('fi','en')))) {
    $lang=$_SESSION['lang'];
} else {
   // default language; can be set e.g. to fi (Finnish) or en (English) 
    $_SESSION['lang']=$lang="en";
}
include_once('texts.php'); // localized texs


switch($type){
	// other cases described in embody code base, https://version.aalto.fi/gitlab/eglerean/embody => not included here
    case 9:
        // short sounds
		$fixedpassword="SetPass8bvF8e4MIELC"; // for the optional admin interface
        switch ($lang) {
			  case "en":
				$title="Rating of speech sounds";
				setlocale(LC_ALL,'en_US.UTF-8',"en_US","en","English"); // set English locale for date formatting etc
				date_default_timezone_set('Europe/Helsinki');
				$stimulusfile=$path.'ratesounds_list.txt'; // basenames for .mp3/.wav/.ogg files
				$welcomefile=$path.'ratesounds_welcome_en.txt';
				$instructionsfile=$path.'ratesounds_instructions_en.txt';
				$Nstimuli=count(loadTxt($stimulusfile,0)); // number of stimuli
			  break;
			  case "fi": default:
				$title="Puheäänien luokittelu";
				setlocale(LC_ALL,'fi_FI.UTF-8',"fi_FI","fi","Finnish"); // set Finnish locale for date formatting etc
				date_default_timezone_set('Europe/Helsinki');
				$stimulusfile=$path.'ratesounds_list.txt'; // basenames for .mp3/.wav/.ogg files
				$welcomefile=$path.'ratesounds_welcome_fi.txt';
				$instructionsfile=$path.'ratesounds_instructions_fi.txt';
				$Nstimuli=count(loadTxt($stimulusfile,0)); // number of stimuli
			  break;
        }
        break;

}

?>
