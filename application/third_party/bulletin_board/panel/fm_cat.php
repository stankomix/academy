<?PHP 
session_start();
ob_start();
include ("../mysqlbaglanti/baglan.php");
include ("guvenlik.php");

$idne=intval($_REQUEST[id]);
if($idne=="1"){$cat="Handbooks";$addne="Add File";}
elseif($idne=="2"){$cat="Videos";$addne="Add File";}
elseif($idne=="3"){$cat="Guides";$addne="Add File";}
elseif($idne=="4"){$cat="Event Photos";$addne="Add Album";}
elseif($idne=="5"){$cat="Manuals";$addne="Add File";}
elseif($idne=="6"){$cat="Other";$addne="Add File";}
else{
header("Location:filemanager.php");
exit();
}
$manyfiles=mysql_fetch_array(mysql_query("SELECT COUNT(id) as kd FROM files WHERE category='$cat' and status='1' order by status asc"));
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" id="vpne" content="width=device-width, initial-scale=1,maximum-scale=1">
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<script src="js/genel.js" type="text/javascript"></script>
<script src="js/jquery.selectric.min.js" type="text/javascript"></script>
<script src="js/fm_cat.js" type="text/javascript"></script>
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

<div class="dtybslk fmbslk"><a href="filemanager.php">File Manager</a><img src="images/sagok.png" /><span><? echo "$cat"; ?></span><div class="t"></div></div>
<div class="fl dtybbslk"><? echo "$cat"; ?> (<? echo "$manyfiles[kd]"; ?>)</div>
<div class="fr bbsaeds" ><a href="javascript:;" onclick="fmekle(<? echo "$idne"; ?>);" class="rnk sae bbsae" ><? echo "$addne"; ?></a></div>
<div class="t"></div>


<div class="fmcttum">

<table cellpadding="0" cellspacing="0" width="100%" border="0" >

<?
$bb_data = "select * from files where status='1' and category='$cat' order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
if($bb[category]=="Handbooks"){$icone="images/fmsico1.png";}
elseif($bb[category]=="Videos"){$icone="images/fmsico2.png";}
elseif($bb[category]=="Guides"){$icone="images/fmsico3.png";}
elseif($bb[category]=="Event Photos"){$icone="images/fmsico4.png";}
elseif($bb[category]=="Manuals"){$icone="images/fmsico5.png";}
elseif($bb[category]=="Other"){$icone="images/fmsico6.png";}
$editlink="editfile($bb[id]);";
if($bb[embed_code]!=""){$word="Watch";$link=" href='javascript:;' onclick='embdac($bb[id]);' ";}else{$link=" href='../download.php?id=$bb[id]' ";$word="Download";}
if($idne=="4"){$link=" href='gallery.php?id=$bb[id]' ";$word="View";$editlink="editpfile($bb[id]);";}
?>
<tr id="fmtrid<? echo "$bb[id]"; ?>" >
<td class="itd1" ><img src="../<? echo "$icone"; ?>" /></td>
<td class="itd2" ><? echo "$bb[title]"; ?></td>
<td class="itd3" ><span><? echo "$bb[clicks]"; ?></span> Downloaded</td>
<td class="itd3" ><? echo "$bb[file_size]"; ?></td>
<td class="std" ><a <? echo "$link"; ?> ><? echo "$word"; ?></a><a href="javascript:;" onclick="<? echo "$editlink"; ?>">Edit</a><div class="t"></div></td>
<td class="delico"><a href="javascript:;" onclick="<? echo "$editlink"; ?>"><img src="images/delico.png" /></a></td>
<td class="downico"><a <? echo "$link"; ?> ><img src="images/downico.png" /></a></td>
</tr>
<?
}
?>
</table>

</div>


</div>

<? include("footer.php"); ?>
</div>
<div class="bosdv"></div>
</body>
</html>