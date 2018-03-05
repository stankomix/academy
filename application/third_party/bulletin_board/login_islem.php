<?PHP
session_start();
ob_start();
include ("mysqlbaglanti/baglan.php");
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

$res = mysql_query("SELECT * FROM users WHERE email='$email' and status='1' ");
$sorgu=mysql_fetch_array($res);
if ($password!="" && $email!="" && $email==$sorgu['email'] && $password==$sorgu['password']) {
$_SESSION['nrmlstatus']="Girildi";
$_SESSION['nrmlkullanici']="$email";
$_SESSION['nrmluser_id']="$sorgu[id]";

header("Location:index.php");
}else{
header("Location:login.php");
}

ob_end_flush();
?>
