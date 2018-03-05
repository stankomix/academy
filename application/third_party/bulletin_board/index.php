<?PHP 
session_start();
ob_start();
include ("mysqlbaglanti/baglan.php");
// include ("guvenlik.php");

$percent2=0;
$mandatorysay=0;
$nowdate = date('Y-m-d H:i:s');

$totalmandatory=mysql_fetch_array(mysql_query("SELECT COUNT(id) as kd FROM tests WHERE mandatory='1' and status='1' order by status asc"));
$percent1=round(100/$totalmandatory[kd]);
$bb_data = "select * from tests where status='1' order by id asc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$testcontrol=mysql_fetch_array(mysql_query("SELECT id FROM test_answers WHERE user_id='$uyene[id]' and test_id='$bb[id]' and status='1' order by id asc"));
if($testcontrol[id]!=""){$mandatorysay++;$percent2=$percent2+$percent1;}
}
if($percent2>97){$percent2="100";}

	function dateconvert($gelburayaveritabanindantarihigetir)
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
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<script src="js/genel.js" type="text/javascript"></script>
<script src="js/dashboard.js" type="text/javascript"></script>
<script src="js/jquery-asPieProgress.min.js" type="text/javascript"></script>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,600,300,300italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href="css/progress.css" rel="stylesheet" type="text/css" />
<link href="css/genel.css" rel="stylesheet" type="text/css" />
<script>
$(window).load(function() {
$('.pie_progress').asPieProgress("go","<? echo "$percent2"; ?>%");
});

</script>
<script type="text/javascript">(function() {var walkme = document.createElement('script'); walkme.type = 'text/javascript'; walkme.async = true; walkme.src = 'https://cdn.walkme.com/users/cfd32f3e794c43c2850e39dd70428743/test/walkme_cfd32f3e794c43c2850e39dd70428743_https.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(walkme, s); window._walkmeConfig = {smartLoad:true}; })();</script>

</head>
<body>
<div class="hps">
<div class="header">
<? include("header_ub.php"); ?>
<div class="ab">
<div class="ort">
<div class="lnklr">
<a href="index.php" class="scl" ><span><img src="images/ico1.png" /></span>Dashboard</a>
<a href="timecard.php" class="nrml" ><span><img src="images/timeclockICO.png" /></span>TimeCard</a>
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

<div class="tstblm">
<div class="mbyzb">Hello <? echo "$adine"; ?>!</div>
<div class="fl stats">
<div class="pie_progress" role="progressbar" data-barcolor="#b11f24" data-trackcolor="#626262" data-barsize="25" ><div class="pie_progress__number">0%</div></div>
</div>
<div class="fl yzlr">
<div class="yzb">Hello <? echo "$adine"; ?>!</div>
<div class="yzi">You’ve completed <strong><? echo "$mandatorysay"; ?></strong> of your <strong><? echo "$totalmandatory[kd]"; ?></strong> mandatory classes!<br /><? if($mandatorysay!="0"){?>You have <strong><? echo $totalmandatory[kd]-$mandatorysay; ?></strong> more to take.<?}?> You’d better start signing up!</div>
<a href="tests.php" class="rnk" >See Your Tests</a>
</div>
<div class="t"></div>
</div>

<div class="fl slblm">
<div class="krmczg"></div>
<div class="blmubslk">BULLETIN BOARD</div>
<div class="blmabslk">RECENTLY ADDED POSTS</div>
<div class="bbpost">
<?
$bb_data = "select * from bulletin_board where status='1' and create_date<='$nowdate' order by id desc LIMIT 0,3";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
if($bb[category]=="1"){$katne="News";}
elseif($bb[category]=="2"){$katne="New Hires";}
elseif($bb[category]=="3"){$katne="Birthday";}
elseif($bb[category]=="4"){$katne="Event";}
?>
<a href="bb_detay.php?id=<? echo "$bb[id]"; ?>"><div class="icnds"><div class="icn"><img src="images/bbico<? echo "$bb[category]"; ?>.png" class="ico<? echo "$bb[category]"; ?>" /></div></div><div class="yzlr"><? echo "$bb[title]"; ?><br /><span><? echo "$katne"; ?> / <? echo dateconvert($bb[create_date]); ?></span></div></a>
<?
}
?>
</div>
<a href="bulletin_board.php" class="sae rnk" >See All Entries</a>
</div>

<div class="fl sgblm">
<div class="krmczg"></div>
<div class="blmubslk">FILE MANAGER</div>
<div class="blmabslk">RECENTLY ADDED FILES</div>
<div class="fmpost">
<?
$bb_data = "select * from files where status='1' order by id desc LIMIT 0,4";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
if($bb[category]=="Handbooks"){$icone="images/fmsico1.png";}
elseif($bb[category]=="Videos"){$icone="images/fmsico2.png";}
elseif($bb[category]=="Guides"){$icone="images/fmsico3.png";}
elseif($bb[category]=="Event Photos"){$icone="images/fmsico4.png";}
elseif($bb[category]=="Manuals"){$icone="images/fmsico5.png";}
elseif($bb[category]=="Other"){$icone="images/fmsico6.png";}
if($bb[embed_code]!=""){$link=" href='javascript:;' onclick='embdac($bb[id]);' ";}else{$link=" href='download.php?id=$bb[id]' ";}
if($bb[category]=="Event Photos"){$link=" href='gallery.php?id=$bb[id]' ";$kelimene="View";}

?>
<a <? echo "$link"; ?> ><div class="icn"><img src="<? echo "$icone"; ?>" /></div><div class="yzlr"><? echo "$bb[title]"; ?></div></a>
<?
}
?>
</div>
<a href="filemanager.php" class="sae rnk" >See All Files</a>
</div>
<div class="t">&nbsp;</div>
<div class="krmczg"></div>
<div class="blmubslk">Performance Bonus</div>
<div class="blmabslk">recent completed work oders</div>
<div class="fmpost">
<?php

//$strSQL = "select * from performance_bonus where user_id = $uyene[id]";
$strSQL = "select * from performance_bonus where user_id = 51";
$rtpb_result = mysql_query($strSQL);
while ($pbs = mysql_fetch_assoc($rtpb_result)){
  //echo $pbs['billed'];
  //get total time worked on WO by all techs via timesheets
  //$strTimesheets = "select start_hour, stop_hour where user_id = $uyene[id]";
  //$strTimesheets = "select start_hour, stop_hour where user_id = 51";

}

?>
</div>
</div>

<? include("footer.php"); ?>
</div>
<div class="bosdv"></div>

</body>
</html>
