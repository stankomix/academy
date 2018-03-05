<?PHP 
session_start();
ob_start();
include ("mysqlbaglanti/baglan.php");
include ("guvenlik.php");

$nowdate = date('Y-m-d H:i:s');
$idne=intval($_REQUEST[id]);
$bbne=mysql_fetch_array(mysql_query("SELECT * FROM bulletin_board WHERE id='$idne' and status='1' and create_date<='$nowdate' order by id asc"));
if($bbne[id]==""){header("Location:bulletin_board.php");exit();}

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
if($bbne[category]=="1"){$katne="News";}
elseif($bbne[category]=="2"){$katne="New Hires";}
elseif($bbne[category]=="3"){$katne="Birthday";}
elseif($bbne[category]=="4"){$katne="Event";}

$gallerycontrol=mysql_fetch_array(mysql_query("SELECT * FROM bb_photos WHERE bb_id='$bbne[id]' order by id asc LIMIT 0,1"));


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" id="vpne" content="width=device-width, initial-scale=1,maximum-scale=1">
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<script src="js/genel.js" type="text/javascript"></script>
<script src="js/bb_detay.js" type="text/javascript"></script>
<script src="js/isotope.pkgd.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="js/jquery.fancybox.pack.js"></script>
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
<a href="index.php" class="nrml" ><span><img src="images/ico1.png" /></span>Dashboard</a>
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

<div class="dtybslk"><a href="bulletin_board.php">Bulletin Board</a><img src="images/sagok.png" /><span><? echo "$bbne[title]"; ?></span><div class="t"></div></div>

<div class="fl dtysl">
<div class="fl icn"><img src="images/bbico<? echo "$bbne[category]"; ?>.png" class="ico<? echo "$bbne[category]"; ?>"/></div>
<div class="fl yzlr">
<div class="trh"><? echo "$katne"; ?> / <? echo dateconvert($bbne[create_date]); ?></div>
<div class="bslk"><? echo "$bbne[title]"; ?></div>
<div class="yz <? if($gallerycontrol[id]==""){ echo "bo0";} ?>">
<? echo htmlspecialchars_decode($bbne[content]); ?>
</div>
<?
if($gallerycontrol[id]!=""){
?>
<script>
$(window).load(function() {
$(".fancybox").fancybox();
});

</script>
<div class="rsmlr">
<?
$bb_data = "select * from bb_photos where bb_id='$bbne[id]' and status='1' order by id asc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
?>
<a href="<? echo "$bb[large_url]"; ?>" class="fancybox" rel="group" ><img src="<? echo "$bb[small_url]"; ?>" /></a>
<?
}
?>
</div>
<?
}
?>
</div>
<div class="t"></div>
</div>

<div class="fr dtysg">
<div class="dtysgubslk">BULLETIN BOARD</div>
<div class="dtysgabslk">RECENTLY ADDED POSTS</div>
<div class="dtysgpsts">
<?
$bb_data = "select * from bulletin_board where status='1' and id!='$bbne[id]' and create_date<='$nowdate' order by id desc LIMIT 0,4";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
if($bb[category]=="1"){$katne="News";}
elseif($bb[category]=="2"){$katne="New Hires";}
elseif($bb[category]=="3"){$katne="Birthday";}
elseif($bb[category]=="4"){$katne="Event";}
?>
<a href="bb_detay.php?id=<? echo "$bb[id]"; ?>"><div class="icnds"><div class="icn"><img src="images/bbico<? echo "$bb[category]";?>.png" class="ico<? echo "$bb[category]";?>" /></div></div><div class="yzlr"><? echo "$bb[title]"; ?><br /><span><? echo "$katne"; ?> / <? echo dateconvert($bbne[create_date]); ?></span></div></a>
<?
}
?>
</div>
</div>

<div class="t"></div>


</div>

<? include("footer.php"); ?>
</div>

</body>
</html>