<?php

$txt=array();
switch ($lang) {
  case "en":
$emotions=array(
0=>"relief",
1=>"amusement",
2=>"surprise",
3=>"disgust",
4=>"pleasure",
5=>"fear",
6=>"sad",
7=>"contentment",
8=>"angry",
9=>"triumph"
);
$cat_title=array(1=> "1. lateral /r/",
2=>"2. fricative /r/",
3=>"3. dorsal /r/",
4=>"4. uvular /r/",
5=>"5. substitution",
6=>"6. lateroflexus /r/",
7=>"7. Finnish [r]",
8=>"8. other place of articulation or manner, describe?");

$cat_desc=array(1=>"right side of the tongue produces /r/ like sound, but this is effortful and weak",
2=>"tongue is in the right position but no trill is produced",
3=>"articulated with the back of the tongue, but no trill at the tip of the tongue",
4=>"/r/ is articulated with the back of the tongue at the uvula",
5=>"r/ is replaced by some other sound",
6=>"during pronunciation the tip of the tongue turns sideways",
7=>"",
8=>"");

    $txt['welcome']="Welcome subject";
    $txt['userid']="subject number";
    $txt['enter_userid']="Enter your personal subject number";
    $txt['register']="click here";
    $txt['no_userid']="If you don't have a number";
    $txt['select_lang']="Select language / vaihda kieli";
    $txt['eval_emotion']="Select emotion the person is feeling";
    $txt['click_to_begin']="Click here to begin";
    $txt['sex']="Gender";
    $txt['age']="Age";
    $txt['male']="Male";
    $txt['female']="Female";
    $txt['email_long']="Email <small>(not mandatory, only used once to send the subject code, address is not stored anywhere)</small>";
    $txt['register_info']="Participation is voluntary and you can abort the experiment at any time. The data collected during the experiment is only used by people of the research team. You cannot be identified based on your 
answers."; // Your email is not mandatory and is not stored anywhere on the server, if entered you will only receive one-time email with your subject code to allow resuming of the evaluation.";   
	$txt['register_title']='Register';
	$txt['register_email']="Your email (not mandatory and is not stored anywhere on the server, if entered you will only receive one-time email with your subject code to allow resuming of the evaluation, the code may be written on a piece of paper as well).";
	$txt['register_q1_hearing_head']='Hearing / degree of hearing loss';
	$txt['register_q1_hearing_lvl1']='Normal hearing';
	$txt['register_q1_hearing_lvl2']='Mild hearing loss';
	$txt['register_q1_hearing_lvl3']='Moderate hearing loss';
	$txt['register_q1_hearing_lvl4']='Severe hearing loss';
	$txt['register_q1_hearing_lvl5']='Profound hearing loss';    
	$txt['register_q2_slp_head']='My experience on speech-language pathologist work';
	$txt['register_q2_slp_lvl1']='Student';
	$txt['register_q2_slp_lvl2']='1-3 year experience';
	$txt['register_q2_slp_lvl3']='3-5 year experience';
	$txt['register_q2_slp_lvl4']='over 5 years of experience';
	$txt['register_q3_audio_head']='I am completing the evaluations';
	$txt['register_q3_audio_lvl1']='using headphones (recommendation)';
	$txt['register_q3_audio_lvl2']='using computer or mobile device speakers';
	$txt['register_missing_hearing']='Kuulo-tieto';
	$txt['register_missing_slp']='Kokemus-tieto';
	$txt['register_missing_audio']='Kuuntelutapa-tieto';
	$txt['missing']="missing";
    $txt['completed1']="You have completed";
    $txt['completed2']="of all ratings";
    $txt['comment_stored']="Comment sent!";
    $txt['commentq']="Comments?";
    $txt['comment_send']="Send comment";
    $txt['eval_emotion']="Select the emotion describing best how the person is feeling";
    $txt['eval_gender']="Select gender of the person";
    $txt['eval_scales']="Please answer the following questions";
    $txt['eval_scales1']="Does the video bring pleasent or unpleasent feelings?";
    $txt['eval_scales2']="How strong is this feeling?";
    $txt['eval_scales3']="How painful do the actions depicted in video look like?";
    $txt['eval_valence1']="very unpleasant";
    $txt['eval_valence2']="very pleasant";
    $txt['eval_arousal1']="very small";
    $txt['eval_arousal2']="very strong";
    $txt['eval_pain1']="no pain";
    $txt['eval_pain2']="worst imaginable pain";
    $txt['instructions']="Instructions";
    $txt['complete']="complete";
    $txt['continue']="Continue";
    $txt['email_subj']="Registration to <RESNAME> experiment";
  
	$txt['email_msg']='Hi,
  
You registered as an user to <RESNAME> experiment on <TIME>. 

Personal subject number that you can use to continue the experiment: 
  <UID> 

Please complete the evaluations in a quiet place. Your task is
to evaluate /r/ sound samples with various criteria.

When you close the page your responses are stored automatically. 
You may resume the evaluation by clicking link
  <SERVERNAME>/<RESCODE>/session.php?userID=<UID>
or by going to main page
  <SERVERNAME>/<RESCODE>/
and giving the subject number above.

This message is automatically created, please do not reply to it. Your 
email address has not been stored on the server, this is a one-time only 
message. If you have not registered personally, somebody may have 
registered for you using this email address.';
    $txt['error_default']='ERROR: Several fields missing';
    $txt['error_scales']='ERROR: Please fill in both scales';
    $txt['error_sex']='ERROR: Please choose gender';
    $txt['error_emotion']='ERROR: Please select at least one emotion';
    $txt['error_html5']='Your browser does not support videos :( Please update your browser to a newer one e.g. at ';
	$txt['error_quality']='ERROR: Missing quality';
	$txt['error_selection']='VIRHE: Missing selection';
    $txt['thanks']='Thank you';
    $txt['thanks_for_participation']='Thank you for your participation subject';
	$txt['100pcnt_complete']='You have completed 100% of the evaluations!<br><br>Thank you! You may leave free form comments below.';
	$txt['start_audio_button']='Audio begins by pressing the button';
	$txt['audio_button_title']='PLAY';
	$txt['audio_rating_title']='Estimate what does the sound sample correspond to';	 
	$txt['practice_phase']='PRACTICE PHASE';
	$txt['audio_rating_min']='other place of articulation';
	$txt['audio_rating_mid']='fricative /r/';
	$txt['audio_rating_max']='typical Finnish [r]';
	$txt['audio_category_title']='Select what category does the sound sample correspond to';
	$txt['audio_cat1_title']="1. lateraalinen /r/";
	$txt['audio_cat2_title']="2. frikatiivinen /r/";
	$txt['audio_cat3_title']="3. dorsaalinen /r/";
	$txt['audio_cat4_title']="4. uvulaarinen /r/";
	$txt['audio_cat5_title']="5. substituutio";
	$txt['audio_cat6_title']="6. lateroflexus /r/";
	$txt['audio_cat7_title']="7. suomen kielen mukainen /r/";
	$txt['audio_cat8_title']="8. muu ääntymäpaikka ja/tai -tapa, mikä?";
	$txt['audio_cat_freeform']="describe here";


     break;
  case "fi": default:
$emotions=array(
0=>"helpotus",
1=>"huvittuneisuus",
2=>"h&auml;mm&auml;stys",
3=>"inho",
4=>"mielihyv&auml;",
5=>"pelko",
6=>"suru",
7=>"tyytyv&auml;isyys",
8=>"viha",
9=>"voitonriemu"
);

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

    $txt['welcome']="Tervetuloa koehenkilö";
    $txt['userid']="k&auml;ytt&auml;j&auml;tunnus";
    $txt['enter_userid']="Anna k&auml;ytt&auml;j&auml;tunnuksesi";
    $txt['register']="paina t&auml;st&auml;";
    $txt['no_userid']="Jos olet uusi k&auml;ytt&auml;j&auml; eik&auml; sinulla ole k&auml;ytt&auml;j&auml;tunnusta;";
    $txt['select_lang']="Select language / vaihda kieli";
    $txt['eval_emotion']="Arvioi, miltä tästä henkilöstä tuntuu";
    $txt['click_to_begin']="Klikkaa t&auml;st&auml; kun olet valmis aloittamaan";
    $txt['sex']="Sukupuoli";
    $txt['age']="Ikä";
    $txt['male']="Mies";
    $txt['female']="Nainen";
    $txt['email_long']="Sähköposti <small>(ei pakollinen tieto, vain kertaluontoista käyttäjätunnuksen lähetystä varten, osoitetta ei tallenneta mihinkään)</small>";
    $txt['register_info']="Tutkimukseen osallistuminen on vapaaehtoista ja voit keskeyttää kokeen milloin tahansa. Kaikkea tutkimuksessa kerättyä tietoa käsitellään ainoastaan tutkimusryhmän jäsenten toimesta. Sinua ei voida tunnistaa vastaustesi perusteella";
	$txt['register_title']="Rekisteröidy";
	$txt['register_email']="Sähköposti (ei pakollinen, osoitetta ei tallenneta palvelimelle, kokeenjatkamislinkki ja tunnistenumero lähetetään kertaluontoisesti tähän, voit myös kirjoittaa kohta luotavan tunnisteen paperille)";
	$txt['register_q1_hearing_head']='Minulla on';
	$txt['register_q1_hearing_lvl1']='Normaali kuulo';
	$txt['register_q1_hearing_lvl2']='Lievä kuulovika';
	$txt['register_q1_hearing_lvl3']='Keskivaikea kuulovika';
	$txt['register_q1_hearing_lvl4']='Vaikea kuulovika';
	$txt['register_q1_hearing_lvl5']='Erittäin vaikea kuulovika';
	$txt['register_q2_slp_head']='Kokemukseni puheterapeutin työstä';
	$txt['register_q2_slp_lvl1']='Opiskelija';
	$txt['register_q2_slp_lvl2']='1-3 –vuoden työkokemus';
	$txt['register_q2_slp_lvl3']='3-5 –vuoden työkokemus';
	$txt['register_q2_slp_lvl4']='yli 5 vuoden työkokemus';
	$txt['register_q3_audio_head']='Teen arvioinnin';
	$txt['register_q3_audio_lvl1']='kuulokkeilla (suositus)';
	$txt['register_q3_audio_lvl2']='tietokoneen tai mobiililaitteen kaiuttimilla';
	$txt['register_missing_hearing']='Kuulo-tieto';
	$txt['register_missing_slp']='Kokemus-tieto';
	$txt['register_missing_audio']='Kuuntelutapa-tieto';
    $txt['missing']="puuttuu";
    $txt['completed1']="Olet suorittanut";
    $txt['completed2']="arvioinneista";
    $txt['comment_stored']="Kommentti lähetetty!";
    $txt['commentq']="Kommentteja?";
    $txt['comment_send']="L&auml;het&auml; kommentti";
	$txt['eval_text']="Kirjoita, mit&auml; puhuja sanoi";
    $txt['eval_emotion']="Arvioi, miltä tästä henkilöstä tuntuu";
    $txt['eval_gender']="Arvioi, kumpaa sukupuolta &auml;&auml;nen tuottaja oli";
    $txt['eval_scales']="Vastaa seuraaviin kysymyksiin";
    $txt['eval_scales1']="Herättääkö video sinussa miellyttäviä vai epämiellyttäviä tunteita?";
    $txt['eval_scales2']="Kuinka voimakas videon herättämä tunnereaktio on?";
    $txt['eval_scales3']="Kuinka kivuliailta videon tapahtumat mielestäsi näyttävät?";
    $txt['eval_valence1']="eritt&auml;in ep&auml;miellytt&auml;vi&auml;";
    $txt['eval_valence2']="eritt&auml;in miellytt&auml;vi&auml;";
    $txt['eval_arousal1']="eritt&auml;in pieni";
    $txt['eval_arousal2']="eritt&auml;in suuri";
    $txt['eval_pain1']="ei kipua";
    $txt['eval_pain2']="pahin kuviteltavissa oleva kipu";
    $txt['instructions']="Ohjeet";
    $txt['complete']="valmiina";
    $txt['continue']="Jatka";
  $txt['email_subj']="Rekisteröityminen käyttäjäksi <RESNAME>-tutkimukseen";
  
  $txt['email_msg']='Hei,
  
Rekisteröidyit käyttäjäksi <RESNAME>-tutkimukseen <TIME>. 

Henkilökohtainen tunniste, jolla voit jatkaa tutkimuksen täyttämistä: 
  <UID> 

Tee arviointi mahdollisimman rauhallisessa tilassa. Tehtäväsi on 
arvioida /r/ -ääniä eri kriteereillä.

Poistuessasi sivulta vastauksesi tallentuvat automaattisesti. Pääset 
jatkamaan kesken jäänyttä tutkimusta osoitteessa
  <SERVERNAME>/<RESCODE>/session.php?userID=<UID>
tai menemällä sivulle
  <SERVERNAME>/<RESCODE>/
ja antamalla ylläolevan tunnisteen

Tämä viesti on automaattisesti luotu, ethän vastaa tähän viestiin. 
Sähköpostiosoitettasi ei ole tallennettu palvelimelle, tämä viesti 
lähetetään vain kerran. Jos et ole rekisteröitynyt henkilökohtaisesti, joku 
toinen on voinut rekisteröityä puolestasi antaen tämän sähköpostiosoitteen. 
';
    $txt['error_default']='VIRHE: Useampia tietoja puuttui';
    $txt['error_scales']='VIRHE: T&auml;yt&auml;th&auml;n molemmat asteikot';
    $txt['error_sex']='VIRHE: Valitse sukupuoli';
    $txt['error_emotion']='VIRHE: Valitse ainakin yksi tunnetila';
    $txt['error_html5']='Selaimesi ei tue videoita :( P&auml;ivit&auml; uudempaan esimerkiksi osoitteessa';
	$txt['error_quality']='VIRHE: Laatu puuttuu';
	$txt['error_selection']='VIRHE: Valinta puuttuu';
    $txt['thanks']='Kiitos';
    $txt['thanks_for_participation']='Kiitos osallistumisesta koehenkilö';
	$txt['100pcnt_complete']='Olet suorittanut 100% arvioinneista!<br><br>Kiitos! Voit jättää alle vielä vapaaehtoisia kommentteja arvioinnista.';
	$txt['start_audio_button']='Ääninäyte alkaa alla olevasta napista';
	$txt['audio_button_title']='TOISTA';
	$txt['audio_rating_title']='Minkälaista äännettä näyte vastaa?';	 
	$txt['practice_phase']='HARJOITTELUVAIHE';
	$txt['audio_rating_min']='muu ääntymäpaikka';
	$txt['audio_rating_mid']='frikatiivinen /r/';
	$txt['audio_rating_max']='suomen kielen mukainen /r/';
	$txt['audio_category_title']='Minkälaista äännettä näyte vastaa?';	 
	$txt['audio_cat1_title']="1. lateraalinen /r/";
	$txt['audio_cat2_title']="2. frikatiivinen /r/";
	$txt['audio_cat3_title']="3. dorsaalinen /r/";
	$txt['audio_cat4_title']="4. uvulaarinen /r/";
	$txt['audio_cat5_title']="5. substituutio";
	$txt['audio_cat6_title']="6. lateroflexus /r/";
	$txt['audio_cat7_title']="7. suomen kielen mukainen /r/";
	$txt['audio_cat8_title']="8. muu ääntymäpaikka ja/tai -tapa, mikä?";
	$txt['audio_cat_freeform']="kuvaile tähän";
	 
	 
    
   break;
}
?>
