<?php
if (isset($_GET['say'])) 
{
	exec('say '.$_GET['say']);
}
?>
<html>
<form>
<input type="text" value="hello world" name="say" />
<input type="submit" value="Say" />
</form>
</html>