<?php
error_reporting(0);
if (!$updates = file('http://jyelewis.com/update/versions')) { echo '<span style="position:absolute;right:10px;top:10px;">There is no internet connection - unable to accses online reps</span>'; }
?>

<?php
//get the system version for applications that need a spesific version
$version = file_get_contents('../../system/version');
$version = base64_decode($version);

//get a list of apps for apps that need a spcific app to be installed
if ($handle = opendir('../../applications')) {
while (false !== ($file = readdir($handle))) {
if ($file != "." && $file != ".." && substr("$file", 0, 1) != '.') {
$appdir[] = $file;
}
}
closedir($handle);
}

$reps = file('reps.txt');
foreach($reps as $rep)
{
if ($avaapps = file(trim($rep)))
{
$repinfo = $avaapps[0];
$avaapps[0] = '';
foreach ($avaapps as $avaapp)
{
if ($avaapp != '')
{
$avaapp = explode('>>', $avaapp);
$repname = explode('>>', $repinfo);
$avaapp[] = $repname[0];
$repapps[] = $avaapp;
}
}
}
}

//print_r($repapps);

?>


<html>
<style type="text/css">
.icon {
position:relative;
float:left; /* optional */
padding:2px;
}

img
{  border-style: none;
}

.icon .label {
visibility:visable;
position:absolute;
bottom:10px; /* in conjunction with left property, decides the text position */
text-align:center;
left:0px;
background-color:#aaa;
opacity:0.7;
color:#000;
width:100%;
font-size: 12;
font-weight:100;
}

</style>
<body>
<?php
if (isset($_GET['download']) && isset($_GET['confirm']))
{
$download = file($_GET['download']);
$download[0] = trim($download[0]);
$type = end(explode('.', $download[2]));
if (trim($type) == 'plugin'){ $tnum = '2'; $types = 'plugin'; } else { $tnum = '1'; $types = 'application'; }
$infofile = "\n".$download[2]."".$download[1]."".$download[0]."\n".'index.php'."\n".$tnum."\n".'icon.png';
$code = file_get_contents($download[5]);
$image = file_get_contents(trim($download[3]));
mkdir('../'.$download[0]);
file_put_contents('../'.$download[0].'/info.data', $infofile);
file_put_contents('../'.$download[0].'/index.php', $code);
file_put_contents('../'.$download[0].'/icon.png', $image);
echo 'The '.$types.' '.$download[1].' has been installed  -  <a href="../../index.php" style="text-decoration:none;color:#000;" target="_top"><b>Home</b></a>';
}

if (isset($_GET['download']) && !isset($_GET['confirm']))
{
$download = file($_GET['download']);
$code = file_get_contents($download[5]);
?>
<b><span style="font-size: 25;">Code for your download: <i><?php echo $download[1] ?></i></b></span> - <?php echo $download[2]; ?></b><img src="<?php echo $download[3]; ?>" width="200" height="200" style="float:right;" />
<textarea rows="30" cols="150">
<?php echo htmlentities($code); ?>
</textarea>
<br>
<b>It is recomended that you check to see if the code does anything malisious. it will have the full<br>permitions of the user that is running the hosting server and could do quite a bit of damage.
<form>
<input type="hidden" name="download" value="<?php echo $_GET['download'] ?>" />
<input type="hidden" name="confirm" value="1" />
<input type="hidden" name="other" value="1" />
<input type="submit" value="Download" />
</form>
<?php
}
if (isset($_GET['view']))
{
foreach($repapps as $app)
{
if ($app[2] == $_GET['view'])
{
$apprepdata = $app;
}
}
$appdata = file($apprepdata[3]);

?>
<table>
<tr>
<td valign="top" width="100%"><h2><?php echo $appdata[1]; ?></h2><?php echo $appdata[4]; ?></td>
<td valign="top" style="padding:20px;"><img src="<?php echo $appdata[3]; ?>" width="300" height="300" style="float:right;" /></td>
</tr>
<tr>
<td><hr></td>
<td style="padding-left: 40px;"><img src="<?php echo $appdata[3]; ?>" width="30" height="30" style="padding-left:20px;" /><form><input type="hidden" name="download" value="<?php echo $apprepdata[3] ?>" /><input type="hidden" value="1" name="other" /><input type="submit" value="Download" /></form></td>
</tr>
</table>
<?php

//echo '<b>$apprepdata:</b><br>';
//print_r($apprepdata);
//echo '<br><br><b>$appdata:</b><br>';
//print_r($appdata);

}
?>
<?php
if (!isset($_GET['other']))
{
echo '<h2>Avalible applications</h2>';
foreach($repapps as $app)
{
echo '
<a style="text-decoration:none;" href="?view='.$app[2].'&other=1">
<span class="icon">

<img src="'.$app[4].'" width="80" height="80" class="icon"/>

<span class="label">
'.$app[0].'
</span>
</span>
</a>';
}
}
?>

</body>
</html>
