<?PHP
session_start();
ob_start();
include ("../mysqlbaglanti/baglan.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9"/>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1254"/>
</head>
</html>
<?

$email=mysql_real_escape_string($_REQUEST[email]);
$password=mysql_real_escape_string($_REQUEST[password]);
$password=md5($password);

$sorgu=mysql_fetch_array(mysql_query("SELECT * FROM admins WHERE email='$email' and status='1'"));

if ($password!="" && $email!="" && $email==$sorgu['email'] && $password==$sorgu['password']) {
$_SESSION['yonstatus']="Girildi";
$_SESSION['yonkullanici']="$email";
$_SESSION['yonuser_id']="$sorgu[id]";
$last_login = date('Y-m-d H:i:s');
$editsql = "UPDATE admins SET last_login='$last_login' WHERE id='$sorgu[id]'";
mysql_query($editsql);
header("Location:index.php");
}else{
header("Location:login.php");
}
ob_end_flush();
?>