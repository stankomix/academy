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
$bbne=mysql_fetch_array(mysql_query("SELECT * FROM bulletin_board WHERE id='$bb_id' order by id asc"));
if($bbne[id]!=""){
$title=htmlspecialchars(hcevir($_REQUEST[title]),ENT_QUOTES);
$content=htmlspecialchars(hcevir($_REQUEST[content]),ENT_QUOTES);
$category=htmlspecialchars(hcevir($_REQUEST[category]),ENT_QUOTES);
$month=htmlspecialchars(hcevir($_REQUEST[month]),ENT_QUOTES);
$day=htmlspecialchars(hcevir($_REQUEST[day]),ENT_QUOTES);
$year=htmlspecialchars(hcevir($_REQUEST[year]),ENT_QUOTES);
$pmam=htmlspecialchars(hcevir($_REQUEST[pmam]),ENT_QUOTES);
$minute=htmlspecialchars(hcevir($_REQUEST[minute]),ENT_QUOTES);
$hour=htmlspecialchars(hcevir($_REQUEST[hour]),ENT_QUOTES);

if($pmam=="AM"){
if($hour=="01"){$hour="01";}
elseif($hour=="12"){$hour="00";}
}elseif($pmam=="PM"){
if($hour=="01"){$hour="13";}
elseif($hour=="02"){$hour="14";}
elseif($hour=="03"){$hour="15";}
elseif($hour=="04"){$hour="16";}
elseif($hour=="05"){$hour="17";}
elseif($hour=="06"){$hour="18";}
elseif($hour=="07"){$hour="19";}
elseif($hour=="08"){$hour="20";}
elseif($hour=="09"){$hour="21";}
elseif($hour=="10"){$hour="22";}
elseif($hour=="11"){$hour="23";}
elseif($hour=="12"){$hour="12";}
}
$create_date = "$year-$month-$day $hour:$minute:00";

$bbeditsql = "UPDATE bulletin_board SET title='$title',content='$content',create_date='$create_date',category='$category' WHERE id='$bbne[id]'";
mysql_query($bbeditsql);
}