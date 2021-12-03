<?php
include_once('settings.php');
include_once('lib.php');

include('header.php');
?>

<form id="intro" method="GET" action="session.php">
<h1><?php echo $title; ?></h1>
    <br><br>
    <input style="font-size:12px;" name="userID" type="text" onclick="this.value=''" value="<?php echo $txt['enter_userid']; ?>"> 
    <?php
		//<br><br>Jos sinulla ei ole sit&auml;, <a href="register.php">rekister&ouml;idy!</a>
	?>
		<br><br><?php echo $txt['no_userid']; ?>, <a href="register.php"><?php echo $txt['register']; ?>!</a>
<?php 
		//<br><br><?php echo $txt['select_lang']; ? >: <a href="?lang=en">English</a> | <a href="?lang=fi">suomi</a></a>
//<div style="top:0px;right:0px;position:absolute;color:#ccc"><a href="admin/index.php">Admin</a></div>
?>		
</form>


<?php
include('footer.php');
?>
