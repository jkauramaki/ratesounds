<?php
// 2019-05-08 simple file browser in php, jaakko.kauramaki@helsinki.fi
include('header.php');
include('../lib.php');

// https://www.php.net/manual/en/function.mb-detect-encoding.php
// Returns true if $string is valid UTF-8 and false otherwise.
function is_utf8($string) {
    
    // From http://w3.org/International/questions/qa-forms-utf-8.html
    return preg_match('%^(?:
          [\x09\x0A\x0D\x20-\x7E]            # ASCII
        | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
        |  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
        | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
        |  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
        |  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
        | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
        |  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
    )*$%xs', $string);
    
} // function is_utf8

$subj=trim($_GET['s']);
$fil=trim($_GET['f']);

if (strpos($fil, '/') !== false) {
	$fil=""; // disable any file browsing with directory separator
}

if (is_numeric($subj)) {
	$dir="../subjects/$subj/";
} else {
	$dir="../subjects/";
}

echo "<pre>\n";

// skip . and .. directories
if (empty($fil)) {
	echo "<h1>Subj $subj files</h1>\n";
	$scanned_directory = array_diff(scandir($dir), array('..', '.'));
	foreach($scanned_directory as $f) 
	{
		$timestamp=filemtime($dir.$f);
		echo "<a href=\"?s=$subj&f=$f\">".sprintf("%-20s",$f)."</a>\t".date(DATE_RFC822,$timestamp)."\n";
	}


} else {
	echo "<h1>Subj $subj / file $fil contents</h1>\n";
	$cont=file_get_contents($dir.$fil);
	if (is_utf8($cont)) {
		echo $cont;
	} else {
		echo utf8_encode($cont);
	}
}
echo "</pre>\n";

include('footer.php');
?>

