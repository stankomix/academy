<?PHP
ob_start();
session_start();
if($_SESSION['yonkullanici']=="" && $_SESSION['yonstatus']=="")
{ header("Location:login.php");exit;
}
ob_end_flush();
?>