<pre>
<?php

session_start();
if (isset($_SESSION['isadmin'])) {
include('../settings.php');
echo "removing old tar file \n";
echo("rm $path/admin/data/*.tar");
$ret=system("rm $path/admin/data/*.tar");
echo $ret;

echo "\n\n making new tar\n\n";

//system("$path/admin/tarit.sh $path",$ret);
echo "tar cvf $path/admin/data/data.tar -C $path subjects/\n";
$ret=exec("tar cvf $path/admin/data/data.tar -C $path subjects/");
// splice output at three lines
$the_rest = array_splice($ret, 3);
// leaving the first three in the original array $lines
$first_three = $ret;
echo "$first_three\n[...]";

echo "\n\n</pre> <a href=\"data/data.tar\">Right-click to download</a><br>";
echo "<a href=\"admin.php?rmtar\">Remove tar file (do after download)</a>";
} else {
    echo "<div class=\"error\">Access only through admin page.</div> <a href=\"index.php\">Go back</a>";
}

