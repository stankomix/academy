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
$tid=intval($_REQUEST[tid]);
$testinfo=mysql_fetch_array(mysql_query("SELECT * FROM tests WHERE id='$tid' order by id asc"));
if($testinfo[id]!=""){
$title=htmlspecialchars(hcevir($_REQUEST[title]),ENT_QUOTES);

$srtitle=$_POST[srtitle];
$optiona=$_POST[optiona];
$optionb=$_POST[optionb];
$optionc=$_POST[optionc];
$optiond=$_POST[optiond];

$bbeditsql = "UPDATE tests SET title='$title' WHERE id='$testinfo[id]'";
mysql_query($bbeditsql);

$questions=-1;
$bb_data = "select * from test_questions where test_id='$testinfo[id]' order by id asc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$questions++;

$bbeditsql = "UPDATE test_questions SET question='$srtitle[$questions]',answera='$optiona[$questions]',answerb='$optionb[$questions]',answerc='$optionc[$questions]',answerd='$optiond[$questions]' WHERE id='$bb[id]'";
mysql_query($bbeditsql);

}

}