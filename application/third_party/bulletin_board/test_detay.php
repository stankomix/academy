<?PHP 
session_start();
ob_start();
include ("mysqlbaglanti/baglan.php");
include ("guvenlik.php");

$idne=intval($_REQUEST[id]);
$testinfo=mysql_fetch_array(mysql_query("SELECT * FROM tests WHERE id='$idne' and status='1' order by id asc"));
if($testinfo[id]==""){header("Location:tests.php");exit();}
$testcontrol=mysql_fetch_array(mysql_query("SELECT * FROM test_answers WHERE user_id='$uyene[id]' and test_id='$idne' and status='1' order by id asc"));
if($testcontrol[id]==""){header("Location:tests.php");exit();}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" id="vpne" content="width=device-width, initial-scale=1,maximum-scale=1">
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<script src="js/genel.js" type="text/javascript"></script>
<script src="js/test_detay.js" type="text/javascript"></script>
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
<a href="tests.php" class="scl" ><span><img src="images/ico2.png" /></span>Your Tests</a>
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

<div class="dtybslk fmbslk"><a href="tests.php">Your Test</a><img src="images/sagok.png" /><span><? echo "$testinfo[title]"; ?></span><div class="t"></div></div>
<div class="dtybbslk"><? echo "$testinfo[title]"; ?></div>

<div class="srsnrs">
<div class="questions">
<?
$questionkac=0;
$bb_data = "select * from test_questions where test_id='$testinfo[id]' order by id asc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$questionkac++;
$cvpne=mysql_fetch_array(mysql_query("SELECT * FROM test_answers WHERE user_id='$uyene[id]' and test_id='$testinfo[id]' and question_id='$bb[id]' and status='1' order by id asc"));

?>
<div class="srtk">
<div class="question"><div class="sy"><? echo "$questionkac"; ?></div><div class="sr"><? echo "$bb[question]"; ?></div><div class="t"></div></div>
<div class="cvplr">
<div class="cvptk"><div class="cvprdy"><img src="images/<? if($cvpne[correct_answer]=="A"){echo "radiodgr";}else{if($cvpne[answer]=="A"){echo "radioscl";}else{ echo "radionrml";}}?>.png" /></div><div class="cvpyz"><? echo "$bb[answera]"; ?></div><div class="t"></div></div>
<div class="cvptk"><div class="cvprdy"><img src="images/<? if($cvpne[correct_answer]=="B"){echo "radiodgr";}else{if($cvpne[answer]=="B"){echo "radioscl";}else{ echo "radionrml";}}?>.png" /></div><div class="cvpyz"><? echo "$bb[answerb]"; ?></div><div class="t"></div></div>
<div class="cvptk"><div class="cvprdy"><img src="images/<? if($cvpne[correct_answer]=="C"){echo "radiodgr";}else{if($cvpne[answer]=="C"){echo "radioscl";}else{ echo "radionrml";}}?>.png" /></div><div class="cvpyz"><? echo "$bb[answerc]"; ?></div><div class="t"></div></div>
<div class="cvptk"><div class="cvprdy"><img src="images/<? if($cvpne[correct_answer]=="D"){echo "radiodgr";}else{if($cvpne[answer]=="D"){echo "radioscl";}else{ echo "radionrml";}}?>.png" /></div><div class="cvpyz"><? echo "$bb[answerd]"; ?></div><div class="t"></div></div>
</div>
</div>
<?
}
?>
<div class="icnlrne"><div class="fl icn1"><img src="images/radioscl.png" /></div><div class="fl yz1">Your Selected</div><div class="fl icn2"><img src="images/radiodgr.png" /></div><div class="fl yz1">Correct Option</div><div class="t"></div></div>

</div>
</div>

</div>

<? include("footer.php"); ?>
</div>
</body>
</html>