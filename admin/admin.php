<?php
include('../lib.php');

// 2020-08-04 added support for file download, specific to .opus -jaakko
// 2019-05-09 incorporated file browser to main admin page
// 2019-05-08 simple file browser in php, jaakko.kauramaki@helsinki.fi

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


// https://stackoverflow.com/questions/15188033/human-readable-file-size
function human_filesize($bytes, $dec = 2) 
{
    $size   = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $factor = floor((strlen($bytes) - 1) / 3);

    return sprintf("%.{$dec}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}


// https://stackoverflow.com/questions/478121/how-to-get-directory-size-in-php
function GetDirectorySize($path){
    $bytestotal = 0;
    $path = realpath($path);
    if($path!==false && $path!='' && file_exists($path)){
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
            $bytestotal += $object->getSize();
        }
    }
    return $bytestotal;
}



$subj=trim($_GET['s']);
$fil=trim($_GET['f']);

if (isset($_GET['rmtar'])) {
	$ret=system("rm $path/admin/data/*.tar");
}

if (isset($_GET['rmzip'])) {
	$ret=system("rm $path/admin/data/*.zip");
}

if (!empty($subj)) {
	if (is_numeric($subj)) {
			$dir="../subjects/$subj/";
	} else {
			$dir="../subjects/";
	}
}
if (!empty($fil)) {
	if (strpos($fil, '/') !== false) {
			$fil=""; // disable any file browsing with directory separator
	}
}

$key=trim($_POST['key']);



session_start();
if(($key==$fixedpassword) || isset($_SESSION['isadmin']))
{
	$_SESSION['isadmin']=1;
	
	if (empty($fil) && empty($subj)) {
		include('header.php');
		?>
		<h1>Admin page</h1>

		<h2>Server disk usage (100&percnt; =&gt; full)</h2>
		<br>
		<div>
		<pre>
Filesystem               Size  Used Avail Use% Mounted on
<?php
$ret=system("df -h|grep -i root");
			//echo $ret;
		?>
		</pre>
		</div>
		<h2>Summary of data collected so far</h2>
		<br>
		<div style="top:0px;right:0px;position:absolute;color:#ccc"><a href="../index.php">Home page</a></div>

		<?php
		include("data.php");
	} else {
		// skip . and .. directories
		if (empty($fil)) {
			// no file, show directory listing
			include('header.php');
			echo "<pre>\n";
			echo "<pre><a href=\"?\">Back</a></pre>\n";
			echo "<h1>Subj $subj files</h1>\n";
			$scanned_directory = array_diff(scandir($dir), array('..', '.'));
			foreach($scanned_directory as $f)
			{
					$timestamp=filemtime($dir.$f);
					echo "<a href=\"?s=$subj&f=$f\">".sprintf("%-20s",$f)."</a>\t".date(DATE_RFC822,$timestamp)."\n";
			}
		} else {

			if (preg_match('/^[^.][-a-z0-9_.]+[a-z]$/i', $fil) && (strpos($fil, ".opus") !== false)) {
				// trigger file download
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename="'.basename($fil).'"');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($dir.$fil));
				flush(); // Flush system output buffer
				readfile($dir.$fil);
				die();
			} else {
				include('header.php');
				echo "<pre><a href=\"?s=$subj\">Back</a></pre>\n";
				echo "<h1>Subj $subj / file $fil contents</h1>\n";
				$cont=file_get_contents($dir.$fil);
				if (is_utf8($cont)) {
						echo $cont;
				} else {
						echo utf8_encode($cont);
				}
			}
		}
		echo "</pre>\n";
	}
} else {
	include('header.php');
    echo "<div class=\"error\">Wrong key.</div> <a href=\"index.php\">Go back</a>";
}

include('footer.php');
