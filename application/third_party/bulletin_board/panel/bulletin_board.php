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
<a href="tests.php" class="nrml" ><span><img src="images/ico2.png" /></span>Tests</a>
<a href="bulletin_board.php" class="scl" ><span><img src="images/ico3.png" /></span>Bulletin Board</a>
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

<div class="fl bbbslk">BULLETIN BOARD</div>
<div class="fr bbsaeds"><a href="javascript:;" onclick="bbekle();" class="rnk sae bbsae">Add New Post</a></div>
<div class="t"></div>

<div class="bbtum">

<?
$bb_data = "select * from bulletin_board where status='1' order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
if($bb[category]=="1"){$katne="News";}
elseif($bb[category]=="2"){$katne="New Hires";}
elseif($bb[category]=="3"){$katne="Birthday";}
elseif($bb[category]=="4"){$katne="Event";}
$gallerysql=mysql_fetch_array(mysql_query("SELECT * FROM bb_photos WHERE bb_id='$bb[id]' order by id asc LIMIT 0,1"));
?>
<div class="bbtek" id="bbtek<? echo "$bb[id]"; ?>">
<? if($gallerysql[id]!=""){?><div class="rsm"><img src="../<? echo "$gallerysql[small_url]"; ?>" /></div><?}?>
<div class="bbicnlr">
<a href="javascript:;" onclick="bbedit('<? echo "$bb[id]"; ?>');" ><div class="fl eicn <? if($gallerysql[id]!=""){ echo "icnrk";}?>"><img src="images/edit.png" /></div></a><div class="fl icn <? if($gallerysql[id]!=""){ echo "icnr";}?>"><img src="images/bbico<? echo "$bb[category]"; ?>.png" class="ico<? echo "$bb[category]"; ?>"/></div><a href="javascript:;" onclick="bbdelete1('<? echo "$bb[id]"; ?>');" id="bdelete<? echo "$bb[id]"; ?>"><div class="fl dicn <? if($gallerysql[id]!=""){ echo "icnrk";}?>" id="dicn<? echo "$bb[id]"; ?>"><img src="images/delete.png" /></div></a><div class="t"></div>
</div>
<div class="yz"><? echo "$bb[title]"; ?><br /><span><? echo "$katne"; ?> / <? echo convertdate("$bb[create_date]"); ?></span></div>
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
