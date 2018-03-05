<?PHP 
session_start();
ob_start();
include ("mysqlbaglanti/baglan.php");

$idne=intval($_REQUEST[id]);
$fileinfo=mysql_fetch_array(mysql_query("SELECT * FROM files WHERE id='$idne' and status='1' order by id asc"));
if($fileinfo[id]==""){header("Location:filemanager.php");exit();}

$clickadd = "UPDATE files SET clicks=clicks + 1 WHERE id='$fileinfo[id]'";
mysql_query($clickadd);

$file = "uploads/$fileinfo[file_name]";

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    readfile($file);
    exit;
}