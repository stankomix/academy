<?PHP
ob_start();
session_start();

$uyene=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id='$_SESSION[nrmluser_id]' and status='1' "));
if($uyene[id]==""){header("Location:login.php");exit();}
if($_SESSION['nrmlkullanici']=="" && $_SESSION['nrmlstatus']=="")
{ header("Location:login.php");exit;}
ob_end_flush();
?>