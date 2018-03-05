<?PHP 
session_start();
ob_start();
include ("../mysqlbaglanti/baglan.php");
include ("guvenlik.php");

		function convertdate($gelburayaveritabanindantarihigetir)
		{
		$tarihirakamlaracevir=strtotime($gelburayaveritabanindantarihigetir);
		$rakamlariistedigimtarihecevir=date("Y-n-j-h-i-s-A",$tarihirakamlaracevir);	
		$mesajtarihi = explode("-",$rakamlariistedigimtarihecevir);
        $mesajyil = $mesajtarihi[0];
        $dogumaynumara = $mesajtarihi[1];
        $mesajgun = $mesajtarihi[2];
        $mesajhour = $mesajtarihi[3];
        $mesajminute = $mesajtarihi[4];
        $ampm = $mesajtarihi[6];
		$ayisimleri = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		$mesajay = $ayisimleri[floor($dogumaynumara)];
		return "$mesajay $mesajgun, $mesajyil $mesajhour:$mesajminute $ampm";
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
<script src="js/admins.js" type="text/javascript"></script>
<script src="js/jquery.selectric.min.js" type="text/javascript"></script>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,600,300,300italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href="css/selectric.css" rel="stylesheet" type="text/css" />
<link href="css/genel.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="hps">

<div class="header">
<? include("header_ub.php"); ?>
<div class="ab">
<div class="ort">
<div class="lnklr">
<a href="index.php" class="nrml" ><span><img src="images/ico1.png" /></span>Dashboard</a>
<a href="tests.php" class="nrml" ><span><img src="images/ico2.png" /></span>Tests</a>
<a href="bulletin_board.php" class="nrml" ><span><img src="images/ico3.png" /></span>Bulletin Board</a>
<a href="filemanager.php" class="nrml" ><span><img src="images/ico4.png" /></span>File Manager</a>
<a href="users.php" class="nrml" ><span><img src="images/ico5.png" /></span>Users</a>
<a href="admins.php" class="scl" ><span><img src="images/ico5.png" /></span>Admins</a>
<div class="t"></div>
</div>
</div>
</div>
<div class="logo"><a href="index.php"><img src="images/logo.png" /></a></div>
</div>
<? include("header_mobil.php"); ?>

<div class="ort">

<div class="fl bbbslk">ADMINS</div>
<div class="fr bbsaeds"><a href="javascript:;" onclick="uekle();" class="rnk sae bbsae">New Admin</a></div>
<div class="t"></div>

<div class="admnstum">

<table cellpadding="0" cellspacing="0" width="100%" border="0" >
<tr class="ilktd">
<td class="yta">MAIL</td>
<td class="ytb ytbcc">LAST LOGIN</td>
<td class="ytb">ACTION</td>
</tr>
<?
$bb_data = "select * from admins where status='1' order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
?>
<tr id="usrid<? echo "$bb[id]"; ?>" >
<td class="itd1" ><? echo "$bb[email]"; ?></td>
<td class="itd2" ><? echo convertdate($bb[last_login]); ?></td>
<td class="std" ><a href="javascript:;" onclick="editadmin(<? echo "$bb[id]"; ?>);">Edit Admin</a></td>
</tr>
<?
}
?>
</table>

</div>

<? include("footer.php"); ?>
</div>
<div class="bosdv"></div>
</body>
</html>