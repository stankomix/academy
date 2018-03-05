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

$workorder_id=htmlspecialchars(hcevir($_REQUEST[workorder_id]),ENT_QUOTES);
$ay=htmlspecialchars(hcevir($_REQUEST[ay]),ENT_QUOTES);
$gun=htmlspecialchars(hcevir($_REQUEST[gun]),ENT_QUOTES);
$yil=htmlspecialchars(hcevir($_REQUEST[yil]),ENT_QUOTES);
$start_hour=htmlspecialchars(hcevir($_REQUEST[start_hour]),ENT_QUOTES);
$start_min=htmlspecialchars(hcevir($_REQUEST[start_min]),ENT_QUOTES);
$start_pmam=htmlspecialchars(hcevir($_REQUEST[start_pmam]),ENT_QUOTES);
$stop_hour=htmlspecialchars(hcevir($_REQUEST[stop_hour]),ENT_QUOTES);
$stop_min=htmlspecialchars(hcevir($_REQUEST[stop_min]),ENT_QUOTES);
$stop_pmam=htmlspecialchars(hcevir($_REQUEST[stop_pmam]),ENT_QUOTES);
$test_date="$yil-$ay-$gun";

//first we need to make sure there is no more than 2 entries for same WO,per user, per date
$strSQL = "SELECT count(workorder_id) FROM timesheets WHERE workorder_id LIKE '$workorder_id' AND date = '$test_date' AND user_id = $uyene[id]";
$hRes = mysql_query($strSQL);
//error_log($strSQL . "\n", 3, 'errlog');
if ( $hRes )
{
  list($count) = mysql_fetch_row($hRes);
  //error_log($count . "\n", 3, 'errlog');
  
  if ( $count >= 2 )
   return false;  
}

$secenekeklesql = "INSERT INTO timesheets VALUES (null, '$uyene[id]','$workorder_id','$start_hour','$start_min','$start_pmam','$stop_hour','$stop_min','$stop_pmam','$test_date')";
mysql_query($secenekeklesql);

