<html>
<body>
<?php
if (isset($_GET['img'])){
if ($_GET['img'] == 'image')
{
//	echo '<img src="'.$_GET['ofile'].'" />';
	
	$file = $_GET['ofile'];
if($fp = fopen($file,"rb", 0))
{
   $picture = fread($fp,filesize($file));
   fclose($fp);
   // base64 encode the binary data, then break it
   // into chunks according to RFC 2045 semantics
   $base64 = chunk_split(base64_encode($picture));
   $tag = '<img ' . "" .
          'src="data:image/gif;base64,' . $base64 .
          '" />';
   echo $tag;
}

} else {
	$ofile = $_GET['ofile'];
	$file = file_get_contents($ofile);
	echo '<textarea name="64" cols="130" rows="20">'.$file.'</textarea>';
}
exit();
}

if (isset($_GET['ofile']) && file_exists($_GET['ofile']) && !is_dir($_GET['ofile']) && !isset($_GET['img']))
{
echo '<form>
<input type="hidden" value="'.$_GET['ofile'].'" name="ofile" />
view as: 
<input type="submit" value="text" name="img" />
<input type="submit" value="image" name="img" />
</form>';

}

if (isset($_GET['ofile']) && @!file_exists($_GET['ofile']) || @is_dir($_GET['ofile'])) { echo 'File doesnt exist'; }

if (!isset($_GET['ofile']) && !isset($_GET['img']))
{

?>
<form>
File location:<input type="text" name="ofile" />
<input type="submit" value="view file" />
</form>
<?php
exit();
}
?>
</body>
</html>