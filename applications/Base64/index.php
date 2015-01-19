<?php
if (isset($_POST['64']))
{
if ($_POST['do'] == 'Decode'){ $str = 'Decoded string:<br><pre>'.htmlentities(base64_decode(stripslashes($_POST['64']))).'</pre>'; }
if ($_POST['do'] == 'Encode'){ $str = 'Encoded string:<br><pre>'.htmlentities(base64_encode(stripslashes($_POST['64']))).'</pre>'; }
}
?>
<html>
<body>

<form method="POST">
<textarea name="64" cols="130" rows="20"><?php if (isset($_GET['ofile'])) { echo htmlentities(file_get_contents($_GET['ofile'])); } ?></textarea>
<br>
<input type="submit" name="do" value="Decode" /><input type="submit" name="do" value="Encode" />
</form>

<?php if (isset($str)){ echo $str; } ?>
</body>
</html>