<?php
include('lib.php');
$data="";
// check that we have all variables
//$keys=array('sex','age','hearing','sight','edu','learning','hearingdefage');
$keys=array('hearing','edu','playback');

$err=-1;
for($k=0;$k<count($keys);$k++){
    if(!isset($_POST[$keys[$k]]) || $_POST[$keys[$k]]=="")
    {
        $err=$k;
        break;
    }
    else
    {
        $data.=$_POST[$keys[$k]].",";
    }
}

// sanity check for variables
if(isset($_POST['hearing'])) {
	if (!is_numeric($_POST['hearing'])) {
		$err=0; 
	}
	if (is_numeric($_POST['hearing']) && (($_POST['hearing'] + 0)<0 || ($_POST['hearing'] + 0)>7)) {
		$err=0; 
	}
}

if(isset($_POST['edu'])) {
	if (!is_numeric($_POST['edu'])) {
		$err=1; 
	}
	if (is_numeric($_POST['edu']) && (($_POST['edu'] + 0)<0 || ($_POST['edu'] + 0)>7)) {
		$err=1; 
	}
}

if(isset($_POST['playback'])) {
	if (!is_numeric($_POST['playback'])) {
		$err=2; 
	}
	if (is_numeric($_POST['playback']) && (($_POST['playback'] + 0)<0 || ($_POST['playback'] + 0)>2)) {
		$err=2; 
	}
}

if(($err>=0) && ($err<=6))
{
        header("Location: register.php?err=$err");
}
else
{
$ok=0;
while($ok==0)
{
    $random = (rand()%1000000);
    if(is_dir("subjects/$random/"))
        $ok=0;
    else
    {
        $ok=1;
        system("mkdir subjects/$random/",$ret);
        if($ret==0)
        {               
            system("chmod 777 subjects/$random/",$ret);
            if($ret!=0)
                die("There was a disk error. Please email $adminemail");
        }
    }
}

$techdata_minimal=array();
if (array_key_exists('UNIQUE_ID',$_SERVER)) $techdata_minimal['UNIQUE_ID']=$_SERVER['UNIQUE_ID'];
if (array_key_exists('HTTP_REFERER',$_SERVER)) $techdata_minimal['HTTP_REFERER']=$_SERVER['HTTP_REFERER'];
if (array_key_exists('HTTP_USER_AGENT',$_SERVER)) $techdata_minimal['HTTP_USER_AGENT']=$_SERVER['HTTP_USER_AGENT'];
if (array_key_exists('REQUEST_TIME_FLOAT',$_SERVER)) $techdata_minimal['REQUEST_TIME_FLOAT']=$_SERVER['REQUEST_TIME_FLOAT'];

// old style:
// $techdata=var_export($_SERVER,TRUE);
//
// new style (minimal data):
$techdata=var_export($techdata_minimal,TRUE);

$file="subjects/$random/data.txt";
$fh = fopen($file, 'w') or die("There was a disk error. Please email $adminemail");
fwrite($fh, $data);
fclose($fh);

$file="subjects/$random/techdata.txt";
$fh = fopen($file, 'w') or die("There was a disk error. Please email $adminemail");
fwrite($fh, $techdata);
fclose($fh);

$email=trim($_POST['email']);
// send registration link only if email is given and it seems valid
if (filter_var($email, FILTER_VALIDATE_EMAIL) && (strlen($email)<50) && (strpos($email,"'")===false)) sendLink($random,$email);
//if (filter_var($email, FILTER_VALIDATE_EMAIL) && (strlen($email)<50) && (strpos($email,"'")===false)) echo "valid email"; else echo "invalid email"; // DEBUG
header("Location: session.php?userID=$random");
}


function sendLink($uid,$email) {
  global $title,$rescode,$txt,$servername,$fromemail;
/* // now in texts.php
  $msg['email_subj']="Rekisteröityminen käyttäjäksi <RESNAME>-tutkimukseen";
  
  $msg['email_msg']='Hei,
  
Rekisteröidyit käyttäjäksi <RESNAME>-tutkimukseen <TIME>. 

Henkilökohtainen tunniste, jolla voit jatkaa tutkimuksen täyttämistä: 
  <UID> 

Tee arviointi mahdollisimman rauhallisessa tilassa. Kaikki vastaukset käsitellään 
luottamuksellisesti. Poistuessasi sivulta vastauksesi tallentuvat automaattisesti. 
Pääset jatkamaan kesken jäänyttä tutkimusta osoitteessa
  <SERVERNAME>/<RESCODE>/session.php?userID=<UID>
tai menemällä sivulle
  <SERVERNAME>/<RESCODE>/
ja antamalla ylläolevan tunnisteen

Kaikista lauseita, myös kesken jääneistä, on hyötyä tutkimukselle!

Tämä viesti on automaattisesti luotu, ethän vastaa tähän viestiin. Jos et ole 
rekisteröitynyt henkilökohtaisesti, joku toinen on voinut rekisteröityä 
puolestasi antaen tämän sähköpostiosoitteen.';
*/
  // localized date, locale & time zone set in settings.php
  $tim = strftime('%c',time()); 

  // email subject
  $sub = '=?UTF-8?B?'.base64_encode(str_replace(array('<RESNAME>'),array($title),$txt['email_subj'])).'?='; // use base64-encoding so scandinavian characters are ok

  // sender information
  $headers = "From: <".$fromemail.">\r\nContent-Type: text/plain; charset=\"UTF-8\";\n\n";

  // actual mail body, no word wrap because UTF-8 aware word-wrap requires hacks in PHP..
  $mail = str_replace(array('<UID>','<EMAIL>', '<TIME>','<RESNAME>','<RESCODE>','<SERVERNAME>'),
  array($uid,$email,$tim,$title,$rescode,$servername), str_replace("\\r\\n","\r\n", $txt['email_msg']));

  // send mail using sendmail/postfix
  mail($email, $sub, $mail, $headers);

}

?>
