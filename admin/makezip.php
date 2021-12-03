<pre>
<?php

session_start();
if (isset($_SESSION['isadmin'])) {
include('../settings.php');
echo "removing old zip file \n";
echo("rm $path/admin/data/*.zip");
$ret=system("rm $path/admin/data/*.zip");
echo $ret;

echo "\n\n making new zip\n\n";

//system("$path/admin/zipit.sh $path",$ret);
echo "cd $path && zip -r admin/data/data.zip subjects/\n";
$ret=exec("cd $path && zip -r admin/data/data.zip subjects/");
// splice output at three lines
$the_rest = array_splice($ret, 3);
// leaving the first three in the original array $lines
$first_three = $ret;
echo "$first_three\n[...]";

echo "\n\n</pre> <a href=\"data/data.zip\">Right-click to download</a><br>";
echo "<a href=\"admin.php?rmzip\">Remove zip file (do after download)</a>";
} else {
    echo "<div class=\"error\">Access only through admin page.</div> <a href=\"index.php\">Go back</a>";
}

