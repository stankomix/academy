<?PHP 
session_start();
ob_start();
include ("mysqlbaglanti/baglan.php");
include ("guvenlik.php");
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
$nowdate = date('Y-m-d H:i:s');
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
<script src="js/bulletin_board.js" type="text/javascript"></script>


<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,600,300,300italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href="css/genel.css" rel="stylesheet" type="text/css" />
<link href="css/selectric.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="hps">
<div class="header">
<? include("header_ub.php"); ?>
<div class="ab">
<div class="ort">
<div class="lnklr">
<a href="index.php" class="nrml" ><span><img src="images/ico1.png" /></span>Dashboard</a>
<a href="timecard.php" class="nrml" ><span><img src="images/timeclockICO.png" /></span>TimeCard</a>
<a href="tests.php" class="nrml" ><span><img src="images/ico2.png" /></span>Your Tests</a>
<a href="bulletin_board.php" class="scl" ><span><img src="images/ico3.png" /></span>Bulletin Board</a>
<a href="filemanager.php" class="nrml" ><span><img src="images/ico4.png" /></span>File Manager</a>
<div class="t"></div>
</div>
</div>
</div>
<div class="logo"><a href="index.php"><img src="images/logo.png" /></a></div>
</div>
<? include("header_mobil.php"); ?>

<div class="ort">

<div class="fl bbbslk">BULLETIN BOARD</div>
<div class="fr slct">
<select id="basic" name="category">
<option value="*">All</option>
<option value=".ct1">News</option>
<option value=".ct2">New Hires</option>
<option value=".ct3">Birthday</option>
<option value=".ct4">Event</option>
</select>
</div>
<div class="t"></div>

<div class="bbtum">
<?
$bb_data = "select * from bulletin_board where status='1' and create_date<='$nowdate' order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
if($bb[category]=="1"){$katne="News";}
elseif($bb[category]=="2"){$katne="New Hires";}
elseif($bb[category]=="3"){$katne="Birthday";}
elseif($bb[category]=="4"){$katne="Event";}
$gallerycontrol=mysql_fetch_array(mysql_query("SELECT * FROM bb_photos WHERE bb_id='$bb[id]' order by id asc LIMIT 0,1"));
?>
<div class="bbtek ct<? echo "$bb[category]"; ?>" >
<a href="bb_detay.php?id=<? echo "$bb[id]"; ?>">
<? if($gallerycontrol[id]!=""){?><div class="rsm"><img src="<? echo "$gallerycontrol[small_url]"; ?>" /></div><?}?>
<div class="icn <? if($gallerycontrol[id]!=""){ echo "icnr";}?>"><img src="images/bbico<? echo "$bb[category]"; ?>.png" class="ico<? echo "$bb[category]"; ?>"/></div>
<div class="yz"><? echo "$bb[title]"; ?><br /><span><? echo "$katne"; ?> / <? echo dateconvert($bb[create_date]); ?></span></div>
</a>
</div>
<?
}
?>
<div class="t"></div>

</div>


</div>

<? include("footer.php"); ?>
</div>
</body>
</html>
