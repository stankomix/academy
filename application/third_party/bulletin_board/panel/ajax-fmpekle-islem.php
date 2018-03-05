<?
session_start();
ob_start();
include ("../mysqlbaglanti/baglan.php");
include ("guvenlik.php");
header("Cache-Control: no-cache");
header("Content-Type:text/html;charset=utf-8");
function hcevir($sData) { $out = ""; for ($i = 0; $i<strlen($sData);$i++) { $ch1= ord($sData{$i}); if($ch1==195 OR $ch1==196 OR $ch1==197) { $ch2=ord($sData{$i+1}); $ch="$ch1$ch2"; $bak=1;
switch($ch) { case "196159": $out .= "ğ";break; case "196158": $out .= "Ğ";break; case "196177": $out .= "ı";break; case "196176": $out .= "İ";break; case "195167": $out .= "ç";break; case "195135": $out .= "Ç";break; case "195188": $out .= "ü"; break; case "195156": $out .= "Ü"; break; case "195182": $out .= "ö"; break; case "195150": $out .= "Ö"; break; case "197158": $out .= "Ş"; break; case "197159": $out .= "ş"; break; } continue; } else if($bak==1) { $bak=0; continue; } else $out .= chr($ch1); }
return $out; 
}

$title=htmlspecialchars(hcevir($_REQUEST[title]),ENT_QUOTES);
$file_name=htmlspecialchars(hcevir($_REQUEST[file_name]),ENT_QUOTES);
$file_type=htmlspecialchars(hcevir($_REQUEST[file_type]),ENT_QUOTES);
$file_size=htmlspecialchars(hcevir($_REQUEST[file_size]),ENT_QUOTES);
$category=htmlspecialchars(hcevir($_REQUEST[category]),ENT_QUOTES);
$embed_code=htmlspecialchars(hcevir($_REQUEST[embed_code]),ENT_QUOTES);
$randomnumber=htmlspecialchars(hcevir($_REQUEST[randomnumber]),ENT_QUOTES);
$create_date = date('Y-m-d H:i:s');

$secenekeklesql = "INSERT INTO files VALUES (null, '$title','$file_name','$file_type','$file_size','$embed_code','$category','0','$create_date','1')";
mysql_query($secenekeklesql);
$sonid = mysql_insert_id();

$pd_data = "select id from photos where file_id='$randomnumber' order by id desc";
$pd_sorgu = mysql_query($pd_data);
while ($pd = mysql_fetch_assoc($pd_sorgu)){
$bbeditsql = "UPDATE photos SET file_id='$sonid' WHERE id='$pd[id]'";
mysql_query($bbeditsql);
}

