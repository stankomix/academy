<?PHP 
session_start();
ob_start();
include ("mysqlbaglanti/baglan.php");
include ("guvenlik.php");

$idne=intval($_REQUEST[id]);
if($idne=="1"){$katne="Handbooks";$icone="images/fmsico1.png";}
elseif($idne=="2"){$katne="Videos";$icone="images/fmsico2.png";}
elseif($idne=="3"){$katne="Guides";$icone="images/fmsico3.png";}
elseif($idne=="4"){$katne="Event Photos";$icone="images/fmsico4.png";}
elseif($idne=="5"){$katne="Manuals";$icone="images/fmsico5.png";}
elseif($idne=="6"){$katne="Other";$icone="images/fmsico6.png";}
else{
header("Location:filemanager.php");
exit();
}
$manyfiles=mysql_fetch_array(mysql_query("SELECT COUNT(id) as kd FROM files WHERE category='$katne' and status='1' order by status asc"));
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" id="vpne" content="width=device-width, initial-scale=1,maximum-scale=1">
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<script src="js/genel.js" type="text/javascript"></script>
<script src="js/fm_cat.js" type="text/javascript"></script>

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
<a href="bulletin_board.php" class="nrml" ><span><img src="images/ico3.png" /></span>Bulletin Board</a>
<a href="filemanager.php" class="scl" ><span><img src="images/ico4.png" /></span>File Manager</a>
<div class="t"></div>
</div>
</div>
</div>
<div class="logo"><a href="index.php"><img src="images/logo.png" /></a></div>
</div>
<? include("header_mobil.php"); ?>

<div class="ort">

<div class="dtybslk fmbslk"><a href="filemanager.php">File Manager</a><img src="images/sagok.png" /><span><? echo "$katne"; ?></span><div class="t"></div></div>
<div class="dtybbslk"><? echo "$katne"; ?> (<? echo "$manyfiles[kd]"; ?>)</div>

<div class="dsylr">
<?
$bb_data = "select * from files where category='$katne' and status='1' order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
if($bb[embed_code]!=""){$word="Watch";$linkne=" href='javascript:;' onclick='embdac($bb[id]);' ";}else{$linkne=" href='download.php?id=$bb[id]' ";$word="Download";}
if($idne=="4"){$linkne=" href='gallery.php?id=$bb[id]' ";$word="View";}
?>
<div class="dsytk"><div class="icnds"><div class="icn"><img src="<? echo "$icone"; ?>" /></div></div><div class="di"><? echo "$bb[title]"; ?></div><div class="db"><? echo "$bb[file_size]"; ?></div><a <? echo "$linkne"; ?> ><div class="dwn"><? echo "$word"; ?></div><div class="downico"><img src="images/downico.png" /></div></a></div>
<?
}
?>
</div>

</div>

<? include("footer.php"); ?>
</div>
<div class="bosdv"></div>

</body>
</html>