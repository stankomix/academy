<?PHP 
session_start();
ob_start();
include ("../mysqlbaglanti/baglan.php");
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
<script src="js/trumbowyg.min.js" type="text/javascript"></script>
<script src="js/genel.js" type="text/javascript"></script>
<script src="js/isotope.pkgd.min.js" type="text/javascript"></script>
<script src="js/bulletin_board.js" type="text/javascript"></script>
<script src="js/jquery.selectric.min.js" type="text/javascript"></script>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,600,300,300italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href="css/trumbowyg.css" rel="stylesheet" type="text/css" />
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
<a href="timecard.php" class="scl" ><span><img src="images/timeclockICO.png" /></span>TimeCard</a>
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

<div class="fl bbbslk">Time Sheet</div>
<div class="fr bbsaeds"><a href="javascript:;" onclick="timeentry();" class="rnk sae bbsae">Add New Time</a></div>
<div class="t"></div>

<div class="bbtum">

<?php
/*
//upcoming bdays
//$bb_birthdates = "SELECT name_surname, birthday FROM `users` WHERE `status`=1 AND month(birthday) = month(NOW()) order by name_surname ASC";
$bb_birthdates = "SELECT name_surname, concat(monthname(birthday), '-', day(birthday)) as bdate FROM `users` WHERE `status`=1 AND month(birthday) = month(NOW()) order by day(birthday) ASC";
$bb_res = mysql_query($bb_birthdates);
while ( $bdays = mysql_fetch_assoc($bb_res) )
{
?>	
<div class="bbtek">
<div class="bbicnlr">
</div>
<div class="yz"><? echo $bdays['name_surname']; ?><br /><span>on <? echo $bdays['bdate']; ?></span></div>
</div>
<?php
}

$bb_data = "select * from bulletin_board where status='1' order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
if($bb[category]=="1"){$katne="News";}
elseif($bb[category]=="2"){$katne="New Hires";}
elseif($bb[category]=="3"){$katne="Birthday";}
elseif($bb[category]=="4"){$katne="Event";}
$galerivarmi=mysql_fetch_array(mysql_query("SELECT * FROM bb_photos WHERE bb_id='$bb[id]' order by id asc LIMIT 0,1"));
?>
<div class="bbtek" id="bbtek<? echo "$bb[id]"; ?>">
<? if($galerivarmi[id]!=""){?><div class="rsm"><img src="../<? echo "$galerivarmi[small_url]"; ?>" /></div><?}?>
<div class="bbicnlr">
<a href="javascript:;" onclick="bbedit('<? echo "$bb[id]"; ?>');" ><div class="fl eicn <? if($galerivarmi[id]!=""){ echo "icnrk";}?>"><img src="images/edit.png" /></div></a><div class="fl icn <? if($galerivarmi[id]!=""){ echo "icnr";}?>"><img src="images/bbico<? echo "$bb[category]"; ?>.png" class="ico<? echo "$bb[category]"; ?>"/></div><a href="javascript:;" onclick="bbdelete1('<? echo "$bb[id]"; ?>');" id="bdelete<? echo "$bb[id]"; ?>"><div class="fl dicn <? if($galerivarmi[id]!=""){ echo "icnrk";}?>" id="dicn<? echo "$bb[id]"; ?>"><img src="images/delete.png" /></div></a><div class="t"></div>
</div>
<div class="yz"><? echo "$bb[title]"; ?><br /><span><? echo "$katne"; ?> / <? echo convertdate("$bb[create_date]"); ?></span></div>
</div>
<?php
}
*/
?>
<div class="t"></div>

</div>


</div>

<? include("footer.php"); ?>
</div>
<div class="bosdv"></div>
</body>
</html>
