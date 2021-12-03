<?php
$yes=$_POST["yes"];


if($yes==1)
{

	$random = (rand()%1000000);
	echo "Setting up user id <span style=\"font-size:20px;font-weight:bold\">$random</span><br><br>";
        if(is_dir("subjects/$random/"))
		die("Error. Try again");
	system("mkdir subjects/$random/",$ret);
	if($ret==0)
	{
		
		system("chmod 777 subjects/$random/",$ret);
		if($ret==0)
			echo "User id <span style=\"font-size:20px;font-weight:bold\">$random</span> ready to annotate!";
			echo "<br><a href=\"/$rescode/\">SAVE THE ID AND CONTINUE HERE</a>";
	}
	else
		echo "There was an error. Email $adminemail";
}
else
{
?>

<form action="makesubj.php" method="POST">
	<input type="hidden" name="yes" value="1">
	<input type="submit" name="submit" value="generate id" />
</form>
<?php
}
?>
