<?PHP 
session_start();
ob_start();
include ("mysqlbaglanti/baglan.php");
include ("guvenlik.php");

	function convertdate($gelburayaveritabanindantarihigetir)
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
<script src="js/jquery.selectric.min.js" type="text/javascript"></script>
<script src="js/genel.js" type="text/javascript"></script>
<script src="js/isotope.pkgd.min.js" type="text/javascript"></script>
<script src="js/timecard.js" type="text/javascript"></script>


<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,600,300,300italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href="css/genel.css" rel="stylesheet" type="text/css" />
<link href="css/selectric.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">(function() {var walkme = document.createElement('script'); walkme.type = 'text/javascript'; walkme.async = true; walkme.src = 'https://cdn.walkme.com/users/cfd32f3e794c43c2850e39dd70428743/test/walkme_cfd32f3e794c43c2850e39dd70428743_https.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(walkme, s); window._walkmeConfig = {smartLoad:true}; })();</script>

</head>
<body>
<div class="hps">
<div class="header">
<? include("header_ub.php"); ?>
<div class="ab">
<div class="ort">
<div class="lnklr">
<a href="index.php" class="nrml" ><span><img src="images/ico1.png" /></span>Dashboard</a>
<a href="timecard.php" class="scl" ><span><img src="images/timeclockICO.png" /></span>TimeCard</a>
<a href="tests.php" class="nrml" ><span><img src="images/ico2.png" /></span>Your Tests</a>
<a href="bulletin_board.php" class="nrml" ><span><img src="images/ico3.png" /></span>Bulletin Board</a>
<a href="filemanager.php" class="nrml" ><span><img src="images/ico4.png" /></span>File Manager</a>
<div class="t"></div>
</div>
</div>
</div>
<div class="logo"><a href="index.php"><img src="images/logo.png" /></a></div>
</div>
<? include("header_mobil.php"); ?>

<div class="ort">

<div class="fl bbbslk">Time Sheet</div>
<div class="fr bbsaeds"><a href="javascript:;" onclick="timeentry();" class="rnk sae bbsae">Add New Time</a></div>
<div class="t"></div>

<div class="usrstum">

<div class="nrml_users">

<table cellpadding="0" cellspacing="0" width="100%" border="0" >
<tr class="ilktd">
<td class="yta">Work Order</td>
<td class="ytb">Date</td>
<td class="ytb">Start Time</td>
<td class="ytb">End Time</td>
</tr>
<?
$bb_data = "select * from timesheets where user_id='$uyene[id]' order by date desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
?>
<tr id="usrid<? echo "$bb[id]"; ?>" >
<td class="itd1" ><? echo "$bb[workorder_id]"; ?></td>
<td class="itd2" ><? echo convertdate($bb[date]); ?></td>
<td class="itd3" ><? echo "$bb[start_hour]:$bb[start_min] $bb[start_pmam]"; ?></td>
<td class="std" ><? echo "$bb[stop_hour]:$bb[stop_min] $bb[stop_pmam]"; ?></td>
</tr>
<?
}
?>
</table>

</div>

</div>


</div>

<? include("footer.php"); ?>
</div>
<div class="bosdv"></div>
</body>
</html>
