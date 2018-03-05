<?PHP 
session_start();
ob_start();
include ("mysqlbaglanti/baglan.php");
include ("guvenlik.php");

$manyfiles1=mysql_fetch_array(mysql_query("SELECT COUNT(id) as kd FROM files WHERE category='Handbooks' and status='1' order by status asc"));
$manyfiles2=mysql_fetch_array(mysql_query("SELECT COUNT(id) as kd FROM files WHERE category='Videos' and status='1' order by status asc"));
$manyfiles3=mysql_fetch_array(mysql_query("SELECT COUNT(id) as kd FROM files WHERE category='Guides' and status='1' order by status asc"));
$manyfiles4=mysql_fetch_array(mysql_query("SELECT COUNT(id) as kd FROM files WHERE category='Event Photos' and status='1' order by status asc"));
$manyfiles5=mysql_fetch_array(mysql_query("SELECT COUNT(id) as kd FROM files WHERE category='Manuals' and status='1' order by status asc"));
$manyfiles6=mysql_fetch_array(mysql_query("SELECT COUNT(id) as kd FROM files WHERE category='Other' and status='1' order by status asc"));

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" id="vpne" content="width=device-width, initial-scale=1,maximum-scale=1">
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<script src="js/genel.js" type="text/javascript"></script>
<script src="js/filemanager.js" type="text/javascript"></script>
<script src="js/isotope.pkgd.min.js" type="text/javascript"></script>
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

<div class="bbbslk">FILE MANAGER</div>

<div class="fmtum">

<div class="fmtek">
<a href="fm_cat.php?id=1">
<div class="icn"><img src="images/fmbico1.png" class="ico1"/></div>
<div class="yz">Handbooks<br /><span><strong><? echo "$manyfiles1[kd]"; ?></strong> Files</span></div>
</a>
</div>
<div class="fmtek">
<a href="fm_cat.php?id=2">
<div class="icn"><img src="images/fmbico2.png" class="ico2"/></div>
<div class="yz">Videos<br /><span><strong><? echo "$manyfiles2[kd]"; ?></strong> Files</span></div>
</a>
</div>
<div class="fmtek">
<a href="fm_cat.php?id=3">
<div class="icn"><img src="images/fmbico3.png" class="ico3"/></div>
<div class="yz">Guides<br /><span><strong><? echo "$manyfiles3[kd]"; ?></strong> Files</span></div>
</a>
</div>

<div class="fmtek">
<a href="fm_cat.php?id=4">
<div class="icn"><img src="images/fmbico4.png" class="ico4"/></div>
<div class="yz">Event Photos<br /><span><strong><? echo "$manyfiles4[kd]"; ?></strong> Files</span></div>
</a>
</div>
<div class="fmtek">
<a href="fm_cat.php?id=5">
<div class="icn"><img src="images/fmbico5.png" class="ico5"/></div>
<div class="yz">Manuals<br /><span><strong><? echo "$manyfiles5[kd]"; ?></strong> Files</span></div>
</a>
</div>
<div class="fmtek">
<a href="fm_cat.php?id=6">
<div class="icn"><img src="images/fmbico6.png" class="ico6"/></div>
<div class="yz">Other<br /><span><strong><? echo "$manyfiles6[kd]"; ?></strong> Files</span></div>
</a>
</div>
<div class="t"></div>


</div>


</div>

<? include("footer.php"); ?>
</div>
</body>
</html>