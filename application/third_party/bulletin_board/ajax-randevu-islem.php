<?
session_start();
ob_start();
include ("mysqlbaglanti/baglan.php");
include ("guvenlik.php");
header("Cache-Control: no-cache");
header("Content-Type:text/html;charset=utf-8");
function hcevir($sData) { $out = ""; for ($i = 0; $i<strlen($sData);$i++) { $ch1= ord($sData{$i}); if($ch1==195 OR $ch1==196 OR $ch1==197) { $ch2=ord($sData{$i+1}); $ch="$ch1$ch2"; $bak=1;
switch($ch) { case "196159": $out .= "ğ";break; case "196158": $out .= "Ğ";break; case "196177": $out .= "ı";break; case "196176": $out .= "İ";break; case "195167": $out .= "ç";break; case "195135": $out .= "Ç";break; case "195188": $out .= "ü"; break; case "195156": $out .= "Ü"; break; case "195182": $out .= "ö"; break; case "195150": $out .= "Ö"; break; case "197158": $out .= "Ş"; break; case "197159": $out .= "ş"; break; } continue; } else if($bak==1) { $bak=0; continue; } else $out .= chr($ch1); }
return $out; 
}

$test_id=intval($_REQUEST[test_id]);
$testinfo=mysql_fetch_array(mysql_query("SELECT * FROM tests WHERE id='$test_id' and status='1' and test_type='Offline' order by id asc"));
if($testinfo[id]==""){?><script>location.href = "tests.php";</script><?exit();}
$testcontrol=mysql_fetch_array(mysql_query("SELECT * FROM test_offline WHERE user_id='$uyene[id]' and test_id='$testinfo[id]' and status='0' order by id asc"));
if($testcontrol[id]!=""){?><script>location.href = "tests.php";</script><?exit();}

$month=htmlspecialchars(hcevir($_REQUEST[month]),ENT_QUOTES);
$day=htmlspecialchars(hcevir($_REQUEST[day]),ENT_QUOTES);
$year=htmlspecialchars(hcevir($_REQUEST[year]),ENT_QUOTES);
$hour=htmlspecialchars(hcevir($_REQUEST[hour]),ENT_QUOTES);
$minute=htmlspecialchars(hcevir($_REQUEST[minute]),ENT_QUOTES);
$pmam=htmlspecialchars(hcevir($_REQUEST[pmam]),ENT_QUOTES);
$test_date="$year-$month-$day";
$create_date = date('Y-m-d H:i:s');

$secenekeklesql = "INSERT INTO test_offline VALUES (null, '$uyene[id]','$test_id','$test_date','$hour','$minute','$pmam','','$create_date','0')";
mysql_query($secenekeklesql);