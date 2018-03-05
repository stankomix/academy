<?PHP 
session_start();
ob_start();
include ("mysqlbaglanti/baglan.php");
include ("guvenlik.php");

$idne=intval($_REQUEST[id]);
$testinfo=mysql_fetch_array(mysql_query("SELECT * FROM tests WHERE id='$idne' and status='1' order by id asc"));
if($testinfo[id]==""){header("Location:tests.php");exit();}
$testcontrol=mysql_fetch_array(mysql_query("SELECT * FROM test_answers WHERE user_id='$uyene[id]' and test_id='$idne' and status='1' order by id asc"));
if($testcontrol[id]!=""){header("Location:tests.php");exit();}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" id="vpne" content="width=device-width, initial-scale=1,maximum-scale=1">
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<script src="js/genel.js" type="text/javascript"></script>
<script src="js/jquery.ezmark.min.js" type="text/javascript"></script>
<script src="js/test.js" type="text/javascript"></script>

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
<form method="post" name="bbform" id="bbform" action="javascript:testpost();" >
<input type="hidden" name="test_id" id="test_id" value="<? echo "$testinfo[id]"; ?>" />
<?
$questionkac=0;
$bb_data = "select * from test_questions where test_id='$testinfo[id]' order by id asc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$questionkac++;
?>
<div class="srtk">
<div class="soru"><div class="sy"><? echo "$sorukac"; ?></div><div class="sr"><? echo "$bb[question]"; ?></div><div class="t"></div></div>
<div class="cvplr">
<div class="cvptk"><label for="answer<? echo "$bb[id]"; ?>a"><div class="cvprdy"><input type="radio" name="answer<? echo "$bb[id]"; ?>" id="answer<? echo "$bb[id]"; ?>a" value="A" /></div><div class="cvpyz"><? echo "$bb[answera]"; ?></div><div class="t"></div></label></div>
<div class="cvptk"><label for="answer<? echo "$bb[id]"; ?>b"><div class="cvprdy"><input type="radio" name="answer<? echo "$bb[id]"; ?>" id="answer<? echo "$bb[id]"; ?>b" value="B" /></div><div class="cvpyz"><? echo "$bb[answerb]"; ?></div><div class="t"></div></label></div>
<div class="cvptk"><label for="answer<? echo "$bb[id]"; ?>c"><div class="cvprdy"><input type="radio" name="answer<? echo "$bb[id]"; ?>" id="answer<? echo "$bb[id]"; ?>c" value="C" /></div><div class="cvpyz"><? echo "$bb[answerc]"; ?></div><div class="t"></div></label></div>
<div class="cvptk"><label for="answer<? echo "$bb[id]"; ?>d"><div class="cvprdy"><input type="radio" name="answer<? echo "$bb[id]"; ?>" id="answer<? echo "$bb[id]"; ?>d" value="D" /></div><div class="cvpyz"><? echo "$bb[answerd]"; ?></div><div class="t"></div></label></div>
</div>
</div>
<?
}
?>
<a href="javascript:;" class="rnk srsend" onclick="testpost();" >SEND</a>
<div class="t"></div>
</form>
</div>
</div>

</div>

<? include("footer.php"); ?>
</div>
</body>
</html>