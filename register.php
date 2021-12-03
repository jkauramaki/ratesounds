<?php
include_once('lib.php');
include_once('settings.php');
include('header.php');

$err=$_GET['err'];

if(isset($err))
{
    switch($err){    
        case 0:
            $msg=$txt['register_missing_hearing'];
            break;
        case 1:
            $msg=$txt['register_missing_slp'];
            break;
		case 2:
            $msg=$txt['register_missing_audio'];
            break;
    }
    $errormsg="<br><div class=\"error\">$msg ".$txt['missing']."</div><br><br>";
}

?>

<style>
td{
    padding:10px;
    }
input{
    margin-right:3px;
    }
</style>
<h1><?php echo $txt['register_title'];?></h1>
<br>
<i><?php echo $txt['register_info'];?></i>
<br>
<?php if(isset($errormsg)) echo $errormsg; ?>
<form method="POST" action="addme.php">
<table>
    <tr style="background:#ccc">
        <td style="width:300px"><?php echo $txt['register_q1_hearing_head'];?></td>
        <td>
	    <select name="hearing">
            <option value="0"><?php echo $txt['register_q1_hearing_lvl1'];?></option>
            <option value="1"><?php echo $txt['register_q1_hearing_lvl2'];?></option>
            <option value="2"><?php echo $txt['register_q1_hearing_lvl3'];?></option>
            <option value="3"><?php echo $txt['register_q1_hearing_lvl4'];?></option>
            <option value="4"><?php echo $txt['register_q1_hearing_lvl5'];?></option>
	    </select>
        </td>
    </tr>
    <tr style="background:#eee">
        <td style="width:300px"><?php echo $txt['register_q2_slp_head'];?></td>
        <td>
	    <select name="edu">
            <option value="0"><?php echo $txt['register_q2_slp_lvl1'];?></option>
            <option value="1"><?php echo $txt['register_q2_slp_lvl2'];?></option>
            <option value="2"><?php echo $txt['register_q2_slp_lvl3'];?></option>
            <option value="3"><?php echo $txt['register_q2_slp_lvl4'];?></option>
	    </select>
        </td>
    </tr>
    <tr style="background:#ccc">
        <td style="width:300px"><?php echo $txt['register_q3_audio_head'];?></td>
        <td>
	    <select name="playback">
            <option value="0"><?php echo $txt['register_q3_audio_lvl1'];?></option>
            <option value="1"><?php echo $txt['register_q3_audio_lvl2'];?></option>
	    </select>
        </td>
    </tr>
	<tr style="background:#eee">
        <td style="width:300px"><?php echo $txt['register_email'];?></td>
        <td>
			<textarea name="email" rows="1" cols="40" value="" style="padding:5px;font-size:12px;display:block;margin:0px;"></textarea>

        </td>
    </tr>


</table>
<input type="submit" value="<?php echo $txt['register_title'];?>" style="margin-top:10px;width:220px;font-size:20px;">
</form>
<?php
include('footer.php');
?>
