<?php
error_reporting(0);
$version = file_get_contents('system/version');
$version = base64_decode($version);
if (!$updates = file('http://jyelewis.com/update/versions')) { echo '<span style="position:absolute;right:10px;top:10px;">Warning: there is no internet connection - <b>Travlr '.$version.'</b> By Jye Lewis (<a href="http://twitter.com/#!/jye265" style="color:#333333;text-decoration:none;">@jye265</a>)</span>'; }
else { echo '<span style="position:absolute;right:10px;top:10px;"><b>Travlr '.$version.'</b> By Jye Lewis (<a href="http://twitter.com/#!/jye265" style="color:#333333;text-decoration:none;" target="_blank">@jye265</a>)</span>'; }
?>

<?php
if (file_exists('system/update.php')){
echo '<meta http-equiv="refresh" content="4;url=system/update.php"><h2>Update is about to be installed<br></h2><h3>Please wait...</h3>';
exit();
}
?>
<html>
<head>
<title>Travlr</title>
<style type="text/css">
body { background-color: #aaa; }

img
{
border-style: none;
}

.icon {
position:relative;
float:left; /* optional */
padding:2px;
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
font-weight:900;
}

</style>
</head>
<body>
<?php
//this gets a list of the files in the applications directory
if ($handle = opendir('applications')) {
while (false !== ($file = readdir($handle))) {
if ($file != "." && $file != ".." && substr("$file", 0, 1) != '.') {
$appdir[] = $file;
}
}
closedir($handle);
}

//this checks if there is the info.data file in the directory and gets
//the infomation out of it to store in the apps array
foreach($appdir as $apploc)
{
if (file_exists('applications/'.$apploc.'/info.data'))
{
$appdatastr = file_get_contents('applications/'.$apploc.'/info.data');
$appdata = explode("\n", $appdatastr);
$appdata[0] = $apploc;
$apps[] = $appdata;
}

}

//this makes a list of the install apps and creates a link to them if there are no other parameters form GET
if (!isset($_GET['appid']))
{
echo '<br>';
foreach($apps as $app)
{
if ($app[5] == 1){
echo '
<a style="text-decoration:none;" href="?appid='.$app[1].'">
<span class="icon">
<img src="applications/'.$app[0].'/'.$app[6].'" width="100" height="100" class="icon"/>
<span class="label">
'.$app[3].'
</span>
</span>
</a>';
}
}
}

if (isset($_GET['appid']))
{
foreach($apps as $app)
{
if($app[1] == $_GET['appid'])
{
echo '
'.$app[2].'
<iframe src="applications/'.$app[0].'/'.$app[4].'" width="100%" height="90%" style="border:none;">
<p>Your browser does not support iframes.</p>
</iframe>
<a href="index.php" style="text-decoration:none;color:#000;"><b>Home</b></a>
';
}
}
}
?>
</body>
</html>
