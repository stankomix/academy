<?PHP 
session_start();
ob_start();
include ("../mysqlbaglanti/baglan.php");
include ("guvenlik.php");

$t=htmlspecialchars($_REQUEST[t],ENT_QUOTES);

$totaltest=mysql_fetch_array(mysql_query("SELECT COUNT(id) as kd FROM tests WHERE status='1' order by status asc"));
$onlinetest=mysql_fetch_array(mysql_query("SELECT COUNT(id) as kd FROM tests WHERE test_type='Online' and status='1' order by status asc"));
$offlinetest=mysql_fetch_array(mysql_query("SELECT COUNT(id) as kd FROM tests WHERE test_type='Offline' and status='1' order by status asc"));
$waittest=mysql_fetch_array(mysql_query("SELECT COUNT(id) as kd FROM test_offline WHERE status='0' order by status asc"));

$users=mysql_fetch_array(mysql_query("SELECT COUNT(id) as kd FROM users WHERE status='1' order by status asc"));

	function convertdate2($gelburayaveritabanindantarihigetir)
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
		 
$finish_online=mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT test_id,user_id) as kd FROM test_answers WHERE status='1' "));
$finish_offline=mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT test_id,user_id) as kd FROM test_offline WHERE status='1' "));

$percent=0;
$sayi=$users[kd]*$onlinetest[kd];
if($sayi==0){$tekoran=0;}else{$tekoran=100/$sayi;}

$percent=round($tekoran*$finish_online[kd]);

if($percent>97){$percent="100";}

$percent_offline=0;
$sayib=$users[kd]*$offlinetest[kd];
if($sayib==0){$tekoranb=0;}else{$tekoranb=100/$sayib;}
$percent_offline=round($tekoranb*$finish_offline[kd]);

if($percent_offline>97){$percent_offline="100";}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" id="vpne" content="width=device-width, initial-scale=1,maximum-scale=1">
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<script src="js/genel.js" type="text/javascript"></script>
<script src="js/tests.js" type="text/javascript"></script>
<script src="js/jquery.selectric.min.js" type="text/javascript"></script>
<script src="js/jquery-asPieProgress.min.js" type="text/javascript"></script>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,600,300,300italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href="css/genel.css" rel="stylesheet" type="text/css" />
<link href="css/progress.css" rel="stylesheet" type="text/css" />
<link href="css/selectric.css" rel="stylesheet" type="text/css" />
<script>
$(window).load(function() {
$('.pie_progress').asPieProgress('go',"<? echo "$percent"; ?>%");
$('.pie_progress2').asPieProgress('go',"<? echo "$percent_offline"; ?>%");
<?
if($t=="a"){?>tstblm(4);<?}
?>
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

<div class="fl bbbslk">TESTS</div>
<div class="fr bbsaeds"><a href="test_new.php" class="rnk sae bbsae">Add New Test</a></div>
<div class="t"></div>

<div class="tstust">

<div class="fl blm1"><div class="pie_progress" role="progressbar" data-barcolor="#b11f24" data-trackcolor="#626262" data-barsize="25" ><div class="pie_progress__number">0%</div></div><div class="yzlr">ONLINE TEST<br />AVERAGE</div></div>
<div class="fl blm2"><div class="pie_progress2" role="progressbar2" data-barcolor="#b11f24" data-trackcolor="#626262" data-barsize="25" ><div class="pie_progress__number">0%</div></div><div class="yzlr">OFFLINE TEST<br />AVERAGE</div></div>
<div class="fl blm3"><div class="icn"><img src="images/dbico1.png" /></div><div class="yzlr">APPOINTMENTS<br /><span>(<? echo "$waittest[kd]"; ?>)</span></div></div>
<div class="t"></div>

</div>

<div class="tsts nrml_tsts">
<a href="javascript:;" onclick="tstblm(1);" class="slovl scl" id="blmlnk1" >ALL TESTS (<? echo "$totaltest[kd]"; ?>)</a>
<a href="javascript:;" onclick="tstblm(2);" class="nrml" id="blmlnk2" >ONLINE TESTS (<? echo "$onlinetest[kd]"; ?>)</a>
<a href="javascript:;" onclick="tstblm(3);" class="nrml" id="blmlnk3" >OFFLINE TESTS (<? echo "$offlinetest[kd]"; ?>)</a>
<a href="javascript:;" onclick="tstblm(4);" class="nrml sgovl" id="blmlnk4" >APPOINTMENTS (<? echo "$waittest[kd]"; ?>)</a>
<div class="t"></div>
</div>

<div class="tsts mbl_tsts">
<a href="javascript:;" onclick="tstblm(1);" class="slovl scl" id="mblmlnk1" >ALL TESTS (<? echo "$totaltest[kd]"; ?>)</a>
<a href="javascript:;" onclick="tstblm(2);" class="sgovl nrml " id="mblmlnk2" >ONLINE TESTS (<? echo "$onlinetest[kd]"; ?>)</a>
<div class="t"></div>
<a href="javascript:;" onclick="tstblm(3);" class="slovl nrml" id="mblmlnk3" >OFFLINE TESTS (<? echo "$offlinetest[kd]"; ?>)</a>
<a href="javascript:;" onclick="tstblm(4);" class="sgovl nrml" id="mblmlnk4" >APPOINTMENTS (<? echo "$waittest[kd]"; ?>)</a>
<div class="t"></div>
</div>

<div class="t"></div>

<div class="nrml_tstler">
<div class="tsttum" id="tsttum1" >
<table cellpadding="0" cellspacing="0" width="100%" border="0" >
<tr class="ilktd">
<td class="yta">NAME</td>
<td class="ytb">LAST COMPLETED</td>
<td class="ytb">TYPE</td>
<td class="ytb">STATUS</td>
<td class="ytb">ACTION</td>
</tr>
<?
$bb_data = "select * from tests where status='1' or status='0' order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
if($bb[test_type]=="Online"){
$cozulentest=mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT user_id) as kd FROM test_answers WHERE test_id='$bb[id]' and status='1' "));
$soncozen=mysql_fetch_array(mysql_query("SELECT user_id FROM test_answers WHERE test_id='$bb[id]' and status='1' order by id desc"));
$uyekim=mysql_fetch_array(mysql_query("SELECT name_surname FROM users WHERE id='$soncozen[user_id]' order by id desc"));
}elseif($bb[test_type]=="Offline"){
$cozulentest=mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT user_id) as kd FROM test_offline WHERE test_id='$bb[id]' and status='1' "));
$soncozen=mysql_fetch_array(mysql_query("SELECT user_id FROM test_offline WHERE test_id='$bb[id]' and status='1' order by id desc"));
$uyekim=mysql_fetch_array(mysql_query("SELECT name_surname FROM users WHERE id='$soncozen[user_id]' order by id desc"));
}

?>
<tr id="usrid<? echo "$bb[id]"; ?>" >
<td class="itd1" ><div class="<? if($bb[status]=="0"){ echo "krmztprlk";}elseif($bb[status]=="1"){ echo "ysltprlk";}?>"></div><? echo "$bb[title]"; ?></td>
<td class="itd2" ><? echo "$uyekim[name_surname]"; ?></td>
<td class="itd2" ><? echo "$bb[test_type]"; ?></td>
<td class="itd2" ><? echo "$cozulentest[kd]"; ?>/<? echo "$users[kd]";?></td>
<td class="std" ><a href="test_detay.php?id=<? echo "$bb[id]"; ?>">See Detail</a></td>
</tr>
<?
}
?>
</table>
</div>

<div class="tsttum" id="tsttum2" >
<table cellpadding="0" cellspacing="0" width="100%" border="0" >
<tr class="ilktd">
<td class="yta">NAME</td>
<td class="ytb">LAST COMPLETED</td>
<td class="ytb">TYPE</td>
<td class="ytb">STATUS</td>
<td class="ytb">ACTION</td>
</tr>
<?
$bb_data = "select * from tests where test_type='Online' and (status='1' or status='0') order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
if($bb[test_type]=="Online"){
$cozulentest=mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT user_id) as kd FROM test_answers WHERE test_id='$bb[id]' and status='1' "));
$soncozen=mysql_fetch_array(mysql_query("SELECT user_id FROM test_answers WHERE test_id='$bb[id]' and status='1' order by id desc"));
$uyekim=mysql_fetch_array(mysql_query("SELECT name_surname FROM users WHERE id='$soncozen[user_id]' order by id desc"));
}elseif($bb[test_type]=="Offline"){
$cozulentest=mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT user_id) as kd FROM test_offline WHERE test_id='$bb[id]' and status='1' "));
$soncozen=mysql_fetch_array(mysql_query("SELECT user_id FROM test_offline WHERE test_id='$bb[id]' and status='1' order by id desc"));
$uyekim=mysql_fetch_array(mysql_query("SELECT name_surname FROM users WHERE id='$soncozen[user_id]' order by id desc"));
}
?>
<tr id="usrid<? echo "$bb[id]"; ?>" >
<td class="itd1" ><div class="<? if($bb[status]=="0"){ echo "krmztprlk";}elseif($bb[status]=="1"){ echo "ysltprlk";}?>"></div><? echo "$bb[title]"; ?></td>
<td class="itd2" ><? echo "$uyekim[name_surname]"; ?></td>
<td class="itd2" ><? echo "$bb[test_type]"; ?></td>
<td class="itd2" ><? echo "$cozulentest[kd]"; ?>/<? echo "$users[kd]";?></td>
<td class="std" ><a href="test_detay.php?id=<? echo "$bb[id]"; ?>">See Detail</a></td>
</tr>
<?
}
?>
</table>
</div>

<div class="tsttum" id="tsttum3" >
<table cellpadding="0" cellspacing="0" width="100%" border="0" >
<tr class="ilktd">
<td class="yta">NAME</td>
<td class="ytb">LAST COMPLETED</td>
<td class="ytb">TYPE</td>
<td class="ytb">STATUS</td>
<td class="ytb">ACTION</td>
</tr>
<?
$bb_data = "select * from tests where test_type='Offline' and (status='1' or status='0') order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
if($bb[test_type]=="Online"){
$cozulentest=mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT user_id) as kd FROM test_answers WHERE test_id='$bb[id]' and status='1' "));
$soncozen=mysql_fetch_array(mysql_query("SELECT user_id FROM test_answers WHERE test_id='$bb[id]' and status='1' order by id desc"));
$uyekim=mysql_fetch_array(mysql_query("SELECT name_surname FROM users WHERE id='$soncozen[user_id]' order by id desc"));
}elseif($bb[test_type]=="Offline"){
$cozulentest=mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT user_id) as kd FROM test_offline WHERE test_id='$bb[id]' and status='1' "));
$soncozen=mysql_fetch_array(mysql_query("SELECT user_id FROM test_offline WHERE test_id='$bb[id]' and status='1' order by id desc"));
$uyekim=mysql_fetch_array(mysql_query("SELECT name_surname FROM users WHERE id='$soncozen[user_id]' order by id desc"));
}
?>
<tr id="usrid<? echo "$bb[id]"; ?>" >
<td class="itd1" ><div class="<? if($bb[status]=="0"){ echo "krmztprlk";}elseif($bb[status]=="1"){ echo "ysltprlk";}?>"></div><? echo "$bb[title]"; ?></td>
<td class="itd2" ><? echo "$uyekim[name_surname]"; ?></td>
<td class="itd2" ><? echo "$bb[test_type]"; ?></td>
<td class="itd2" ><? echo "$cozulentest[kd]"; ?>/<? echo "$users[kd]";?></td>
<td class="std" ><a href="test_detay.php?id=<? echo "$bb[id]"; ?>">See Detail</a></td>
</tr>
<?
}
?>
</table>
</div>

<div class="tsttum" id="tsttum4" >
<table cellpadding="0" cellspacing="0" width="100%" border="0" >
<tr class="ilktd">
<td class="yta">NAME</td>
<td class="ytb">TEST NAME</td>
<td class="ytb">DATE</td>
<td class="ytb">TIME</td>
<td class="ytb">ACTION</td>
</tr>
<?
$bb_data = "select * from test_offline where status='0' order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$testne=mysql_fetch_array(mysql_query("SELECT title FROM tests WHERE id='$bb[test_id]' order by id desc"));
$uyekim=mysql_fetch_array(mysql_query("SELECT name_surname FROM users WHERE id='$bb[user_id]' order by id desc"));
?>
<tr id="usrid<? echo "$bb[id]"; ?>" >
<td class="itd1" ><? echo "$uyekim[name_surname]"; ?></td>
<td class="itd2" ><? echo "$testne[title]"; ?></td>
<td class="itd2" ><? echo convertdate2($bb[test_date]); ?></td>
<td class="itd2" ><? echo "$bb[hour]:$bb[minute] $bb[pmam]"; ?></td>
<td class="std" ><a href="javascript:;" onclick="rndval('<? echo "$bb[id]"; ?>');">Result Entry</a></td>
</tr>
<?
}
?>
</table>
</div>
</div>

<div class="mobil_tstler">
<div class="mtstler" id="mtstler1">
<div class="mtst_bslk"><div class="fl sl">TEST</div><div class="fl sg">STATUS</div><div class="t"></div></div>
<?
$bb_data = "select * from tests where (status='1' or status='0') order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
if($bb[test_type]=="Online"){
$cozulentest=mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT user_id) as kd FROM test_answers WHERE test_id='$bb[id]' and status='1' "));
$soncozen=mysql_fetch_array(mysql_query("SELECT user_id FROM test_answers WHERE test_id='$bb[id]' and status='1' order by id desc"));
$uyekim=mysql_fetch_array(mysql_query("SELECT name_surname FROM users WHERE id='$soncozen[user_id]' order by id desc"));
}elseif($bb[test_type]=="Offline"){
$cozulentest=mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT user_id) as kd FROM test_offline WHERE test_id='$bb[id]' and status='1' "));
$soncozen=mysql_fetch_array(mysql_query("SELECT user_id FROM test_offline WHERE test_id='$bb[id]' and status='1' order by id desc"));
$uyekim=mysql_fetch_array(mysql_query("SELECT name_surname FROM users WHERE id='$soncozen[user_id]' order by id desc"));
}
?>
<div class="mtst_byztk" onclick="takpt('gri_1_<? echo "$bb[id]"; ?>');" ><div class="sl"><div class="<? if($bb[status]=="0"){ echo "krmztprlk";}elseif($bb[status]=="1"){ echo "ysltprlk";}?>"></div><? echo "$bb[title]"; ?></div><div class="sg"><? echo "$cozulentest[kd]"; ?>/<? echo "$users[kd]";?></div></div>
<div class="mtst_gritk" id="gri_1_<? echo "$bb[id]"; ?>"><div class="b1">LAST COMPLETED<br /><span><? echo "$uyekim[name_surname]"; ?></span></div><div class="b2">TYPE<br /><span><? echo "$bb[test_type]"; ?></span></div><div class="b4"><a href="test_detay.php?id=<? echo "$bb[id]"; ?>">See Detail</a></div></div>
<?
}
?>
</div>

<div class="mtstler" id="mtstler2">
<div class="mtst_bslk"><div class="fl sl">TEST</div><div class="fl sg">STATUS</div><div class="t"></div></div>
<?
$bb_data = "select * from tests where test_type='Online' and (status='1' or status='0') order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
if($bb[test_type]=="Online"){
$cozulentest=mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT user_id) as kd FROM test_answers WHERE test_id='$bb[id]' and status='1' "));
$soncozen=mysql_fetch_array(mysql_query("SELECT user_id FROM test_answers WHERE test_id='$bb[id]' and status='1' order by id desc"));
$uyekim=mysql_fetch_array(mysql_query("SELECT name_surname FROM users WHERE id='$soncozen[user_id]' order by id desc"));
}elseif($bb[test_type]=="Offline"){
$cozulentest=mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT user_id) as kd FROM test_offline WHERE test_id='$bb[id]' and status='1' "));
$soncozen=mysql_fetch_array(mysql_query("SELECT user_id FROM test_offline WHERE test_id='$bb[id]' and status='1' order by id desc"));
$uyekim=mysql_fetch_array(mysql_query("SELECT name_surname FROM users WHERE id='$soncozen[user_id]' order by id desc"));
}
?>
<div class="mtst_byztk" onclick="takpt('gri_2_<? echo "$bb[id]"; ?>');" ><div class="sl"><div class="<? if($bb[status]=="0"){ echo "krmztprlk";}elseif($bb[status]=="1"){ echo "ysltprlk";}?>"></div><? echo "$bb[title]"; ?></div><div class="sg"><? echo "$cozulentest[kd]"; ?>/<? echo "$users[kd]";?></div></div>
<div class="mtst_gritk" id="gri_2_<? echo "$bb[id]"; ?>"><div class="b1">LAST COMPLETED<br /><span><? echo "$uyekim[name_surname]"; ?></span></div><div class="b2">TYPE<br /><span><? echo "$bb[test_type]"; ?></span></div><div class="b4"><a href="test_detay.php?id=<? echo "$bb[id]"; ?>">See Detail</a></div></div>
<?
}
?>
</div>

<div class="mtstler" id="mtstler3">
<div class="mtst_bslk"><div class="fl sl">TEST</div><div class="fl sg">STATUS</div><div class="t"></div></div>
<?
$bb_data = "select * from tests where test_type='Offline' and (status='1' or status='0') order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
if($bb[test_type]=="Online"){
$cozulentest=mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT user_id) as kd FROM test_answers WHERE test_id='$bb[id]' and status='1' "));
$soncozen=mysql_fetch_array(mysql_query("SELECT user_id FROM test_answers WHERE test_id='$bb[id]' and status='1' order by id desc"));
$uyekim=mysql_fetch_array(mysql_query("SELECT name_surname FROM users WHERE id='$soncozen[user_id]' order by id desc"));
}elseif($bb[test_type]=="Offline"){
$cozulentest=mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT user_id) as kd FROM test_offline WHERE test_id='$bb[id]' and status='1' "));
$soncozen=mysql_fetch_array(mysql_query("SELECT user_id FROM test_offline WHERE test_id='$bb[id]' and status='1' order by id desc"));
$uyekim=mysql_fetch_array(mysql_query("SELECT name_surname FROM users WHERE id='$soncozen[user_id]' order by id desc"));
}
?>
<div class="mtst_byztk" onclick="takpt('gri_3_<? echo "$bb[id]"; ?>');" ><div class="sl"><div class="<? if($bb[status]=="0"){ echo "krmztprlk";}elseif($bb[status]=="1"){ echo "ysltprlk";}?>"></div><? echo "$bb[title]"; ?></div><div class="sg"><? echo "$cozulentest[kd]"; ?>/<? echo "$users[kd]";?></div></div>
<div class="mtst_gritk" id="gri_3_<? echo "$bb[id]"; ?>"><div class="b1">LAST COMPLETED<br /><span><? echo "$uyekim[name_surname]"; ?></span></div><div class="b2">TYPE<br /><span><? echo "$bb[test_type]"; ?></span></div><div class="b4"><a href="test_detay.php?id=<? echo "$bb[id]"; ?>">See Detail</a></div></div>
<?
}
?>
</div>

<div class="mtstler" id="mtstler4">
<div class="mtst_bslk"><div class="fl sl">TEST</div><div class="fl sg">NAME</div><div class="t"></div></div>
<?
$bb_data = "select * from test_offline where status='0' order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$testne=mysql_fetch_array(mysql_query("SELECT title FROM tests WHERE id='$bb[test_id]' order by id desc"));
$uyekim=mysql_fetch_array(mysql_query("SELECT name_surname FROM users WHERE id='$bb[user_id]' order by id desc"));
?>
<div class="mtst_byztk" onclick="takpt('gri_4_<? echo "$bb[id]"; ?>');" ><div class="sl"><? echo "$testne[title]"; ?></div><div class="sg"><? echo "$uyekim[name_surname]";?></div></div>
<div class="mtst_gritk" id="gri_4_<? echo "$bb[id]"; ?>"><div class="b1">DATE<br /><span><? echo convertdate2($bb[test_date]); ?></span></div><div class="b2">TIME<br /><span><? echo "$bb[hour]:$bb[minute] $bb[pmam]"; ?></span></div><div class="b4"><a href="javascript:;" onclick="rndval('<? echo "$bb[id]"; ?>');">Result Entry</a></div></div>
<?
}
?>
</div>

</div>

</div>

<? include("footer.php"); ?>
</div>
<div class="bosdv"></div>
</body>
</html>