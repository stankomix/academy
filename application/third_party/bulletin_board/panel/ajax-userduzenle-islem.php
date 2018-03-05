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
$bb_id=intval($_REQUEST[bb_id]);
$bbne=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id='$bb_id' order by id asc"));
if($bbne[id]!=""){
$name_surname=htmlspecialchars(hcevir($_REQUEST[name_surname]),ENT_QUOTES);
$email=htmlspecialchars(hcevir($_REQUEST[email]),ENT_QUOTES);
$password=htmlspecialchars(hcevir($_REQUEST[password]),ENT_QUOTES);
$job=htmlspecialchars(hcevir($_REQUEST[job]),ENT_QUOTES);
$month=htmlspecialchars(hcevir($_REQUEST[month]),ENT_QUOTES);
$day=htmlspecialchars(hcevir($_REQUEST[day]),ENT_QUOTES);
$year=htmlspecialchars(hcevir($_REQUEST[year]),ENT_QUOTES);
$birthday="$year-$month-$day";

$bbeditsql = "UPDATE users SET name_surname='$name_surname',email='$email',password='$password',job='$job',birthday='$birthday' WHERE id='$bbne[id]'";
mysql_query($bbeditsql);
}