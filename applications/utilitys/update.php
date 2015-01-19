<?php
error_reporting(0);
echo '<html>
<body>';
if (!$updates = file('http://jyelewis.com/update/versions')) { echo '<span style="position:absolute;right:10px;top:10px;">There is no internet connection - not able to check for updates</span>'; }
?>
<?php
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

foreach($appdir as $apploc)
{
	if (file_exists('../'.$apploc.'/info.data'))
		{
			$appdatastr = file_get_contents('../'.$apploc.'/info.data');
			$appdata = explode("\n", $appdatastr);
			$appdata[0] = $apploc;
			$apps[] = $appdata;
		}
		
}
	
	$exclude[] = '';
	function read_my_dir($dir)
	{    global $efiles, $edirs, $exclude;
global $tfile,$tdir;$i=0;$j=0;$myfiles;
$myfiles[][] = array();
if (is_dir($dir))
{
if ($dh = opendir($dir))
{
while (($file=readdir($dh)) !== false)
{
if (!is_dir($dir.'/'.$file))
{
$tfile[$i]=$file;
$i++;
//echo $dir.'/'.$file.'<br>';
$efiles[] = $dir.'/'.$file;
}
else
{

if (($file != '.') && ($file != '..') && !in_array($dir.'/'.$file, $exclude))
{
$tdir[$j]=$file;
//echo $dir.'/'.$file.'<br>';
$edirs[] = $dir.'/'.$file;
//$sep = “\\';
read_my_dir($dir.'/'.$file);
$j++;
}
}
}
closedir($dh);
}
}

}

if (isset($_GET['delapp']) && isset($_GET['delconf'])){
		$scandir = $_GET['delapp'];
		$edirs = '';
		$efiles = '';
read_my_dir('../'.$scandir);

foreach($efiles as $file)
{
unlink($file);
//echo 'removed '.$file;
}
$edirs = array_reverse($edirs);
foreach($edirs as $dir)
{
rmdir($dir);
//echo 'removed '.$dir;
}

rmdir('../'.$scandir);

unset($appdir);
	if ($handle = opendir('../../applications')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && substr("$file", 0, 1) != '.') {
            $appdir[] = $file;
        }
    }
    closedir($handle);
	}
}

if (isset($_GET['delapp']) && !isset($_GET['delconf'])){
$infofile = file('../'.$_GET['delapp'].'/info.data');

echo '<b><span style="text-decoration:underline;">Are you sure that you want to delete '.$infofile[2].'? - <a href="?delapp='.$_GET['delapp'].'&delconf=1" style="text-decoration:none;color:#000">Yup</a> - <a href="?a=1" style="text-decoration:none;color:#000">Nope</a></span></b>';
} else { echo '<br>'; }



//stop here stop here stop here stop here stop here stop here stop here 


$version = file_get_contents('../../system/version');
$version = base64_decode($version);
$updates = file('http://jyelewis.com/update/versions');
if (!isset($_GET['update']))
{
	foreach($updates as $update)
	{
		$update = explode(">>", $update);
		if ($update[0] == $version)
		{
			if ($update[1] == 'latest')
			{
			$toecho = 'This is the latest version avalible';
			} else {
			$toecho = 'There is an update avalible for your system <form method="get"><input type="submit" value="Update now" name="update" /></form>';
			}
		}
	}
echo "<h3>Updates:</h3>You are currently running version: $version<br>$toecho";
echo '<br><br>';
echo '<table border="0"><tr><td valign="top" width="300px;">';
echo '<h3>Hidden Applications:</h3>';
	foreach($apps as $app)
	{
		if ($app[5] == 0)
		{
		$runnd = '1';
			echo '<a style="text-decoration:none;color:#000" href="../../index.php?appid='.$app[1].'" target="_top">
					<img src="../'.$app[0].'/'.$app[6].'" width="20" height="20" border="0"/>
					'.$app[3].'
				
		</a><br>';
		}
		

	}
		if (!isset($runnd)){ echo 'You have no hidden applications'; }
		
		echo '<br><br><br><h3 >Plugins:</h3>';
		foreach($apps as $app)
		{

			if ($app[5] == 2)
			{
				$runndp = '1';
				echo '<a style="text-decoration:none;color:#000" href="../../index.php?appid='.$app[1].'" target="_top">
				<img src="../'.$app[0].'/'.$app[6].'" width="20" height="20" border="0"/>
				'.$app[3].'	- <a style="text-decoration:none;color:#000;" target="plugin" href="../'.$app[0].'/'.$app[4].'?repare=1">Repare</a>
				</a><br>';
			}
		
		}

	if (!isset($runndp)){ echo 'You have no plugins'; }
		else { echo '<iframe src="#" width="0" height="0" style="border:none;" name="plugin"></iframe>'; }
	
echo '</td><td>';	
	echo '<h3>All applications and plugins:</h3>';
		foreach($apps as $app)
		{


				$runndp = '1';
				echo '
				<a style="text-decoration:none;color:#000" href="../../index.php?appid='.$app[1].'" target="_top">
				<img src="../'.$app[0].'/'.$app[6].'" width="20" height="20" border="0"/>
				'.$app[3].'</a>	- 
				<a style="color:#000" href="?delapp='.$app[0].'">Delete</a><br>';
		
		}

	if (!isset($runndp)){ echo 'You have no applications or plugins'; }
	echo '</td></tr></table>';
	
	//stop here stop here stop here stop here stop here stop here stop here stop here stop here stop here 
	
} else {

	if ($_GET['update'] == 'Update now'){
		foreach($updates as $update)
		{
			$update = explode(">>", $update);
			if ($update[0] == $version)
			{
				echo '<b>'.$update[2].'</b><br>'.$update[3];
				echo '<form method="get"><input type="submit" value="Download and install" name="update" /></form>';
				//$updatescpt = file_get_contents($update[1]);
				//$updatescpt = base64_decode($updatescpt);
			
			}
		}
	}
	
	if ($_GET['update'] == 'Download and install'){ echo 'Downloading update<br>Please wait....'; echo '<meta http-equiv="refresh" content="2;url=?update=download">'; }
	
	if ($_GET['update'] == 'download'){
		foreach($updates as $update)
		{
			$update = explode(">>", $update);
			if ($update[0] == $version)
			{
				$updatescpt = file_get_contents($update[1]);
				$updatescpt64 = $updatescpt;
				$updatescpt = base64_decode($updatescpt);
				file_put_contents('../../system/updates/'.$update[4], $updatescpt64);
				file_put_contents('../../system/update.php', $updatescpt);
				echo 'The update has been downloaded and will be installed when you go to the home screen';
			}
		}
	}
	
}
?>

<span style="position:absolute;bottom:10px;right:10px;">Vist the Travlr blog: <a href="http://travlrapp.tumblr.com" style="color:#000;" target="_blank">http://travlrapp.tumblr.com</a></span>

</body>
</html>