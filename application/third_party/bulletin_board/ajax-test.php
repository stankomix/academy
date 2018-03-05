<?
session_start();
ob_start();
header("Cache-Control: no-cache");
header("Content-Type:text/html;charset=utf-8");
include ("mysqlbaglanti/baglan.php");
include ("guvenlik.php");
function hcevir($sData) { $out = ""; for ($i = 0; $i<strlen($sData);$i++) { $ch1= ord($sData{$i}); if($ch1==195 OR $ch1==196 OR $ch1==197) { $ch2=ord($sData{$i+1}); $ch="$ch1$ch2"; $bak=1;
switch($ch) { case "196159": $out .= "ğ";break; case "196158": $out .= "Ğ";break; case "196177": $out .= "ı";break; case "196176": $out .= "İ";break; case "195167": $out .= "ç";break; case "195135": $out .= "Ç";break; case "195188": $out .= "ü"; break; case "195156": $out .= "Ü"; break; case "195182": $out .= "ö"; break; case "195150": $out .= "Ö"; break; case "197158": $out .= "Ş"; break; case "197159": $out .= "ş"; break; } continue; } else if($bak==1) { $bak=0; continue; } else $out .= chr($ch1); }
return $out; 
}

$test_id=intval($_REQUEST[test_id]);
$testinfo=mysql_fetch_array(mysql_query("SELECT * FROM tests WHERE id='$test_id' and status='1' order by id asc"));
if($testinfo[id]==""){?><script>location.href = "tests.php";</script><?exit();}
$testcontrol=mysql_fetch_array(mysql_query("SELECT * FROM test_answers WHERE user_id='$uyene[id]' and test_id='$test_id' and status='1' order by id asc"));
if($testcontrol[id]!=""){?><script>location.href = "tests.php";</script><?exit();}

$toplamquestion=mysql_fetch_array(mysql_query("SELECT COUNT(id) as ks FROM test_questions WHERE test_id='$test_id' and status='1' order by id asc"));
$hercorrect_answer=round(100/$toplamquestion[ks]);
$toplamscore=0;

$cvpkelime="answer";
$create_date = date('Y-m-d H:i:s');

$bb_data = "select * from test_questions where test_id='$test_id' order by id asc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$idne="$cvpkelime$bb[id]";
$requestbu=$_REQUEST[$idne];
if($bb[correct_answer]=="$requestbu"){$toplamscore=$toplamscore+$hercorrect_answer;}
$uyeuyeligieklesql = "INSERT INTO test_answers VALUES ('','$uyene[id]','$testinfo[id]','$bb[id]','$requestbu','$bb[correct_answer]','$hercorrect_answer','$create_date','1')";
mysql_query($uyeuyeligieklesql);
}

if($toplamscore>97){$toplamscore="100";}
$pd_data = "select id from test_answers where user_id='$uyene[id]' and test_id='$testinfo[id]' order by id asc";
$pd_sorgu = mysql_query($pd_data);
while ($pd = mysql_fetch_assoc($pd_sorgu)){
$scoresql = "UPDATE test_answers SET score='$toplamscore' WHERE id='$pd[id]'";
mysql_query($scoresql);
}
?>
<div class="thnks">
<div class="icn"><img src="images/testok.png" /></div>
<div class="yz1">Thank You</div>
<div class="yz2">Thank you for taking the test. Your score is <span><? echo "$toplamscore"; ?>/100</span></div>
<a href="tests.php" class="sae maa">See All tests</a>
</div>