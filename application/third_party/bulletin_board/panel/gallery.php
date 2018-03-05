<?PHP 
session_start();
ob_start();
include ("../mysqlbaglanti/baglan.php");
include ("guvenlik.php");

$idne=intval($_REQUEST[id]);
$gallerysql=mysql_fetch_array(mysql_query("SELECT * FROM files WHERE id='$idne' and status='1' order by id asc"));
if($gallerysql[id]==""){header("Location:filemanager.php");exit();}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" id="vpne" content="width=device-width, initial-scale=1,maximum-scale=1">
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<script src="js/genel.js" type="text/javascript"></script>
<script src="js/isotope.pkgd.min.js" type="text/javascript"></script>
<script src="js/gallery.js" type="text/javascript"></script>
<link rel="stylesheet" href="../css/jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="../js/jquery.fancybox.pack.js"></script>
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
<a href="filemanager.php" class="scl" ><span><img src="images/ico4.png" /></span>File Manager</a>
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

<div class="dtybslk fmbslk"><a href="filemanager.php">File Manager</a><img src="images/sagok.png" /><a href="fm_cat.php?id=4">Event Photos</a><img src="images/sagok.png" /><span><? echo "$gallerysql[title]"; ?></span><div class="t"></div></div>
<div class="dtybbslk"><? echo "$gallerysql[title]"; ?></div>


<div class="gltum">
<?
$bb_data = "select * from photos where file_id='$gallerysql[id]' and status='1' order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
?>
<div class="gltek ct<? echo "$bb[category]"; ?>" >
<a href="../<? echo "$bb[large_url]"; ?>" class="fancybox" rel="group" ><img src="../<? echo "$bb[small_url]"; ?>" /></a>
</div>
<?
}
?>
<div class="t"></div>

</div>


</div>

<? include("footer.php"); ?>
</div>
<div class="bosdv"></div>
</body>
</html>