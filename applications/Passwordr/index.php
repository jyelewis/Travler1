<?php
//startpasswordcode
session_start();
if (isset($_POST['pass'])) { $_SESSION['password'] = $_POST['pass']; }
$password1 = file('../../system/password.php');
$password = trim($password1[2]);
if (!isset($_SESSION['password'])) {
echo '<br>Please enter the password: <form method="post"><input type="password" name="pass" /><input type="submit" value="go" /></form>';
exit();
}
else
{
if ($_SESSION['password'] != $password)
{
echo 'Incorect password<br>Please enter the password: <form method="post"><input type="password" name="pass" /><input type="submit" value="go" /></form>';
exit();
}
}
//endpasswordcode
?>
<?php
error_reporting(0);

if (isset($_POST['newpass'])){
$passfile = "<?php
/*
{$_POST['newpass']}
*/
echo 'nice try, no hacking please :)';
exit();
?>";
file_put_contents('../../system/password.php', $passfile);
echo 'password has been set';
}

if (!file_get_contents('../../system/password.php')) { echo 'Please set a password, this will be a password that allows you any apps that you protect: '; ?>
<form method="post"><input type="password" name="newpass" /><input type="submit" value="Set password" /></form>
<?php
exit();
}

if (isset($_POST['newcode'])) { if(file_put_contents($_POST['url'], stripslashes($_POST['newcode']))){ echo 'Done! :)'; } }
if (isset($_GET['file']) && isset($_GET['addpass'])) {
if (!file_get_contents($_GET['file'])) { echo $_GET['file'].' doesnt exist<br>'; $_GET['fix'] = $_GET['file']; unset($_GET['file']); } else {
//start code here
$passwordcode = base64_decode('PD9waHANCi8vc3RhcnRwYXNzd29yZGNvZGUNCnNlc3Npb25fc3RhcnQoKTsNCmlmIChpc3NldCgkX1BPU1RbJ3Bhc3MnXSkpIHsgJF9TRVNTSU9OWydwYXNzd29yZCddID0gJF9QT1NUWydwYXNzJ107IH0NCiRwYXNzd29yZDEgPSBmaWxlKCcuLi8uLi9zeXN0ZW0vcGFzc3dvcmQucGhwJyk7DQokcGFzc3dvcmQgPSB0cmltKCRwYXNzd29yZDFbMl0pOw0KaWYgKCFpc3NldCgkX1NFU1NJT05bJ3Bhc3N3b3JkJ10pKSB7DQplY2hvICc8YnI+UGxlYXNlIGVudGVyIHRoZSBwYXNzd29yZDogPGZvcm0gbWV0aG9kPSJwb3N0Ij48aW5wdXQgdHlwZT0icGFzc3dvcmQiIG5hbWU9InBhc3MiIC8+PGlucHV0IHR5cGU9InN1Ym1pdCIgdmFsdWU9ImdvIiAvPjwvZm9ybT4nOw0KZXhpdCgpOw0KfQ0KZWxzZQ0Kew0KaWYgKCRfU0VTU0lPTlsncGFzc3dvcmQnXSAhPSAkcGFzc3dvcmQpDQp7DQplY2hvICdJbmNvcmVjdCBwYXNzd29yZDxicj5QbGVhc2UgZW50ZXIgdGhlIHBhc3N3b3JkOiA8Zm9ybSBtZXRob2Q9InBvc3QiPjxpbnB1dCB0eXBlPSJwYXNzd29yZCIgbmFtZT0icGFzcyIgLz48aW5wdXQgdHlwZT0ic3VibWl0IiB2YWx1ZT0iZ28iIC8+PC9mb3JtPic7DQpleGl0KCk7DQp9DQp9DQovL2VuZHBhc3N3b3JkY29kZQ0KPz4NCg==');
$code = htmlentities(file_get_contents($_GET['file']));
echo 'The code will be changed to be like this:<br><form method="post"><input type="hidden" value="'.$_GET['file'].'" name="url" /><textarea rows="30" cols="150" name="newcode">'.$passwordcode.$code.'</textarea><br><input type="submit" value="All good, save that code" /></form>';
//end code here
}
}

if (isset($_GET['file']) && isset($_GET['unpass'])) {
if (!file_get_contents($_GET['file'])) { echo $_GET['file'].' doesnt exist<br>'; $_GET['fix'] = $_GET['file']; unset($_GET['file']); } else {
$code = file_get_contents($_GET['file']);
$code = htmlentities(substr($code, 635));
echo 'The code will be changed to be like this:<br><form method="post"><input type="hidden" value="'.$_GET['file'].'" name="url" /><textarea rows="30" cols="150" name="newcode">'.$code.'</textarea><br><input type="submit" value="All good, save that code" /></form>';
}
} 

if (!isset($_GET['file']))
{
if (isset($_GET['fix'])) { $value = $_GET['fix']; } else { $value = '../passwordr/index.php'; echo '<br>'; }
if (!file_get_contents('../../system/password.php')) { echo 'Please set a password, this will be a password that allows you any apps that you protect: '; }
?>
<html>
<body>
Where is the file that you want to password/unpassword? - this url should be relative to the passworder app index file
<br><form><input type="text" size="100" name="file" value="<?php echo $value; ?>" /><input type="submit" value="Add password" name="addpass" /><input type="submit" value="Remove password" name="unpass" /></form>
<br><br><br><form method="post">New password<input type="password" name="newpass" /><input type="submit" value="Set passworsd" /></form>
</body>
</html>
<?php
}


?>