<?php
if (isset($_GET['downloadfiles']))
{
if ($_GET['downloadfiles'] == 'Ignore') { $_SESSION['ignorefiles'] = TRUE; } else {

	$iconcode = file_get_contents('http://jyelewis.com/travlrrep/applications/Apploader/serverinstall.txt');
	file_put_contents('files.php', $iconcode);
	echo '<iframe src="files.php" width="0" height="0" style="border:none;" name="plugin"></iframe>';
	echo 'server files have been downloaded';

}
}

if (!file_exists('server/auto.php') && !isset($_SESSION['ignorefiles']))
{
echo '<span style="position:absolute;bottom:25px;right:25px;"><h3>server files not found, download them?</h3> ';
echo '<form><input type="submit" value="Yes" name="downloadfiles"> <input type="submit" value="Ignore" name="downloadfiles"></form></span>';
}


if (isset($_POST['form']))
{
?>
<form method="post" action="<?php echo htmlentities($_POST['server']); ?>">
<input type="hidden" value="<?php echo htmlentities($_POST['password']); ?>" name="password" />
<input type="hidden" value="<?php echo htmlentities($_POST['shortname']); ?>" name="shortname" />
<input type="hidden" value="<?php echo htmlentities($_POST['shortname']); ?>" name="dirname" />
<input type="hidden" value="<?php echo htmlentities($_POST['version']); ?>" name="version" />
<input type="hidden" value="<?php echo htmlentities($_POST['longname']); ?>" name="longname" />
<input type="hidden" value="<?php echo htmlentities($_POST['repid']); ?>" name="repid" />
<input type="hidden" value="<?php echo htmlentities($_POST['appid']); ?>" name="appid" />
<input type="hidden" value="<?php echo htmlentities($_POST['imgsrc']); ?>" name="imgsrc" />
<input type="hidden" value="<?php echo htmlentities(stripslashes($_POST['code'])); ?>" name="code" />
<input type="hidden" value="<?php echo htmlentities($_POST['discription']); ?>" name="discription" />

<input type="submit" value="Send update!" />

<table>
<tr>
<td>Server:</td> 
<td><?php echo $_POST['server']; ?></td></tr>
<td>Short name:</td>
<td><?php echo $_POST['shortname']; ?></td></tr>
<td>Long name:</td>
<td><?php echo $_POST['longname']; ?></td></tr>
<td>Version:</td>
<td><?php echo $_POST['version']; ?></td></tr>
<td>repid:</td>
<td><?php echo $_POST['repid']; ?></td></tr>
<td>appid:</td>
<td><?php echo $_POST['appid']; ?></td></tr>
<td>image:</td>
<td><img src="<?php echo $_POST['imgsrc']; ?>" width="20" height="20" /></td></tr>
<td>Description:</td>
<td><?php echo $_POST['discription']; ?></td></tr>
</table>
<br><br>
Update code:<br><b>
<?php echo htmlentities(stripslashes($_POST['code'])); ?>
</b>
<?php
} else {
?>

<html>
<body>
<table>
<form method="post">
<input type="hidden" value="1" name="form" />
<tr>
<td>Server:</td> 
<td><input type="text" value="" name="server" size="40" /></td></tr>
<td>Server password:</td>
<td><input type="password" value="" name="password" size="40" /></td></tr>
<td>Short name:</td>
<td><input type="text" value="" name="shortname" size="40" /></td></tr>
<td>Long name:</td>
<td><input type="text" value="" name="longname" size="40" /></td></tr>
<td>Version:</td>
<td><input type="text" value="" name="version" size="40" /></td></tr>
<td>repid:</td>
<td><input type="text" value="" name="repid" size="40" /></td></tr>
<td>appid:</td>
<td><input type="text" value="" name="appid" size="40" /></td></tr>
<td>Image src:</td>
<td><input type="text" value="" name="imgsrc" size="40" /></td></tr>
<td>Description:</td>
<td><input type="text" value="" name="discription" size="60" /></td></tr>
</table>
<br><br>
Update code:<br>
<textarea rows="20" cols="100" name="code"></textarea>
<br><input type="submit" value="prepare for upload" />
</form>
</body>
</html>
<?php
}
?>