<?PHP 
session_start();
ob_start();
include ("../mysqlbaglanti/baglan.php");
include ("guvenlik.php");

$t=htmlspecialchars($_REQUEST[t],ENT_QUOTES);
$idne=intval($_REQUEST[id]);
$testsql=mysql_fetch_array(mysql_query("SELECT * FROM tests WHERE id='$idne' and (status='1' or status='0') order by id asc"));
if($testsql[id]==""){
header("Location:tests.php");
exit();
}
if($t=="delete"){
$bbeditsql = "UPDATE tests SET status='2' WHERE id='$testsql[id]'";
mysql_query($bbeditsql);

$bb_data = "select * from test_answers where test_id='$testsql[id]' order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$delete = "DELETE from test_answers where id='$bb[id]'";
mysql_query($delete);
}

$bb_data = "select * from test_offline where test_id='$testsql[id]' order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$delete = "DELETE from test_offline where id='$bb[id]'";
mysql_query($delete);
}

header("Location:tests.php");
exit();
}

	function tarihiver($gelburayaveritabanindantarihigetir)
	{
		$tarihirakamlaracevir=strtotime($gelburayaveritabanindantarihigetir);
		$rakamlariistedigimtarihecevir=date("Y-n-j-H-i-s",$tarihirakamlaracevir);	
		$mesajtarihi = explode("-",$rakamlariistedigimtarihecevir);
        $mesajyil = $mesajtarihi[0];
        $dogumaynumara = $mesajtarihi[1];
        $mesajgun = $mesajtarihi[2];
		$ayisimleri = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		$mesajay = $ayisimleri[floor($dogumaynumara)];
		return "$mesajay $mesajgun, $mesajyil";
	}
	
$usercount=mysql_fetch_array(mysql_query("SELECT COUNT(id) as kd FROM users WHERE status='1' order by status asc"));
if($testsql[test_type]=="Online"){
$finishtest=mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT user_id) as kd FROM test_answers WHERE test_id='$testsql[id]' and status='1' "));
}elseif($testsql[test_type]=="Offline"){
$finishtest=mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT user_id) as kd FROM test_offline WHERE test_id='$testsql[id]' and status='1' "));
}
$percent=0;
$percent2=100/$usercount[kd];
$percent=round($percent2*$finishtest[kd]);
if($percent>97){$percent="100";}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" id="vpne" content="width=device-width, initial-scale=1,maximum-scale=1">
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<script src="js/genel.js" type="text/javascript"></script>
<script src="js/test_detay.js" type="text/javascript"></script>
<script src="js/jquery-asPieProgress.min.js" type="text/javascript"></script>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,600,300,300italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href="css/progress.css" rel="stylesheet" type="text/css" />
<link href="css/genel.css" rel="stylesheet" type="text/css" />
<script>
$(window).load(function() {
$('.pie_progress').asPieProgress('go',"<? echo "$percent"; ?>%");
});
</script>
</head>
<body>
<div class="hps">
<div class="header">
<? include("header_ub.php"); ?>
<div class="ab">
<div class="ort">
<div class="lnklr">
<a href="index.php" class="nrml" ><span><img src="images/ico1.png" /></span>Dashboard</a>
<a href="tests.php" class="scl" ><span><img src="images/ico2.png" /></span>Tests</a>
<a href="bulletin_board.php" class="nrml" ><span><img src="images/ico3.png" /></span>Bulletin Board</a>
<a href="filemanager.php" class="nrml" ><span><img src="images/ico4.png" /></span>File Manager</a>
<a href="users.php" class="nrml" ><span><img src="images/ico5.png" /></span>Users</a>
<a href="admins.php" class="nrml" ><span><img src="images/ico5.png" /></span>Admins</a>
<div class="t"></div>
</div>
</div>
</div>
<div class="logo"><a href="index.php"><img src="images/logo.png" /></a></div>
</div>
<? include("header_mobil.php"); ?>

<div class="ort">

<div class="dtybslk fmbslk"><a href="tests.php">Tests</a><img src="images/sagok.png" /><span><? echo "$testsql[title]"; ?></span><div class="t"></div></div>
<div class="fl dtybbslk"><? echo "$testsql[title]"; ?></div>
<?
if($testsql[status]=="1"){
?>
<div class="fr bbsaeds"><a href="test_edit.php?tid=<? echo "$testsql[id]"; ?>" class="rnk sae bbsae">Edit Test</a></div>
<?
}elseif($testsql[status]=="0"){
?>
<div class="fr bbsaeds"><a href="test_edit_p.php?tid=<? echo "$testsql[id]"; ?>" class="rnk sae bbsae">Edit Test</a></div>
<?
}
?>
<div class="t"></div>

<div class="tstdtyust">

<div class="blm1"><div class="pie_progress" role="progressbar" data-barcolor="#b11f24" data-trackcolor="#626262" data-barsize="25" ><div class="pie_progress__number">0%</div></div></div>
<div class="yz1"><? echo "$testsql[title]"; ?></div>
<div class="yz2"><span><? echo "$finishtest[kd]"; ?></span> members have taken this test.</div>

</div>

<div class="tstdtytum" id="tsttum1" >
<table cellpadding="0" cellspacing="0" width="100%" border="0" >

<?
if($testsql[test_type]=="Online"){
?>
<tr class="ilktd">
<td class="yta">USERS</td>
<td class="ytb">COMPLETED DATE</td>
<td class="ytb">SCORE</td>
<td class="ytb">ACTION</td>
</tr>
<?
$bb_data = "select * from test_answers where test_id='$testsql[id]' and status='1' group by user_id order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$usersql=mysql_fetch_array(mysql_query("SELECT id,name_surname FROM users WHERE id='$bb[user_id]' order by id desc"));
?>
<tr id="usrid<? echo "$bb[id]"; ?>" >
<td class="itd1" ><? echo "$usersql[name_surname]"; ?></td>
<td class="itd2" ><? echo tarihiver($bb[create_date]); ?></td>
<td class="itd3" ><? echo "$bb[score]"; ?></td>
<td class="std" ><a href="test_result.php?u=<? echo "$usersql[id]"; ?>&tid=<? echo "$testsql[id]"; ?>">Test Result</a></td>
<td class="downico"><a href="test_result.php?u=<? echo "$usersql[id]"; ?>&tid=<? echo "$testsql[id]"; ?>"><img src="images/downico.png" /></a></td>
</tr>
<?
}
}elseif($testsql[test_type]=="Offline"){
?>
<tr class="ilktd">
<td class="yta">USERS</td>
<td class="ytb">COMPLETED DATE</td>
<td class="ytb">SCORE</td>
</tr>
<?
$bb_data = "select * from test_offline where test_id='$testsql[id]' and status='1' group by user_id order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$usersql=mysql_fetch_array(mysql_query("SELECT name_surname FROM users WHERE id='$bb[user_id]' order by id desc"));
?>
<tr id="usrid<? echo "$bb[id]"; ?>" >
<td class="itd1" ><? echo "$usersql[name_surname]"; ?></td>
<td class="itd2" ><? echo tarihiver($bb[create_date]); ?></td>
<td class="itd3 std offstd" ><? echo "$bb[score]"; ?></td>
</tr>
<?
}
}
?>
</table>
</div>


</div>

<? include("footer.php"); ?>
</div>
<div class="bosdv"></div>
</body>
</html>