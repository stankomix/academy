<?PHP 
session_start();
ob_start();
include ("../mysqlbaglanti/baglan.php");
include ("guvenlik.php");
$admin=mysql_fetch_array(mysql_query("SELECT * FROM admins WHERE email='$_SESSION[yonkullanici]' order by id desc"));

$waitingtest=mysql_fetch_array(mysql_query("SELECT COUNT(id) as kd FROM test_offline WHERE status='0' order by status asc"));
$finish_online=mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT test_id,user_id) as kd FROM test_answers WHERE create_date>'$admin[last_login]' and status='1' "));
$finish_offline=mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT test_id,user_id) as kd FROM test_offline WHERE create_date>'$admin[last_login]' "));

$finishtests=$finish_online[kd]+$finish_offline[kd];

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
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" id="vpne" content="width=device-width, initial-scale=1,maximum-scale=1">
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<script src="js/genel.js" type="text/javascript"></script>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,600,300,300italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href="css/genel.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="hps">
<div class="header">
<? include("header_ub.php"); ?>
<div class="ab">
<div class="ort">
<div class="lnklr">
<a href="index.php" class="scl" ><span><img src="images/ico1.png" /></span>Dashboard</a>
<a href="tests.php" class="nrml" ><span><img src="images/ico2.png" /></span>Tests</a>
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

<div class="dbust">
<a href="tests.php?t=a">
<div class="fl dbustsl">
<div class="icn"><img src="images/dbico1.png" class="ico1" /></div><div class="yz">You have <strong><? echo "$waitingtest[kd]"; ?></strong> unreviewed appointment request<? if($waitingtest[kd]>1){ echo "s";} ?>.</div><div class="t"></div>
</div>
</a>
<a href="tests.php">
<div class="fl dbustsg">
<div class="icn"><img src="images/dbico2.png" class="ico2" /></div><div class="yz"><strong><? echo "$finishtests"; ?></strong> test<? if($finishtests>1){ echo "s";} ?> is taken<br/>since your last login.</div><div class="t"></div>
</div>
</a>
<div class="t"></div>
</div>

<div class="fl slblm">
<div class="krmczg"></div>
<div class="blmubslk">APPOINTMENTS</div>
<div class="blmabslk">RECENT APPOINTMENTS</div>
<div class="rndvlr">
<?
$bb_data = "select * from test_offline where status='0' order by id desc LIMIT 0,5";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$usersql=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id='$bb[user_id]' order by id desc"));
?>
<div class="rndvtk"><div class="rndsl"><? echo "$usersql[name_surname]"; ?><br /><span><? echo "$usersql[job]"; ?></span></div><div class="rndsg">Appointment Date : <span><? echo convertdate2($bb[test_date]); ?> - <? echo "$bb[hour]:$bb[minute] $bb[pmam]"; ?></span></div></div>
<?
}
?>
</div>
<a href="tests.php" class="sae rnk wbys" >See All Appointments</a>
</div>

<div class="fl sgblm">
<div class="krmczg"></div>
<div class="blmubslk">TESTS</div>
<div class="blmabslk">RECENTLY TAKEN ONLINE TESTS</div>
<div class="tstler">
<?
$bb_data = "select * from test_answers where status='1' group by user_id,test_id order by create_date desc LIMIT 0,5";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$testsql=mysql_fetch_array(mysql_query("SELECT * FROM tests WHERE id='$bb[test_id]' order by id desc"));
$usersql=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id='$bb[user_id]' order by id desc"));
?>
<div class="tstlertk"><div class="yzlr"><? echo "$usersql[name_surname]"; ?><br /><span><? echo "$testsql[title]"; ?></span></div></div>
<?
}
?>
</div>
<a href="tests.php" class="sae rnk" >See All Entries</a>
</div>
<div class="t"></div>

</div>

<? include("footer.php"); ?>
</div>

</body>
</html>
