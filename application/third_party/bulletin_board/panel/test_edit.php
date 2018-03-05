<?PHP 
session_start();
ob_start();
include ("../mysqlbaglanti/baglan.php");
include ("guvenlik.php");

$tid=intval($_REQUEST[tid]);
$testsql=mysql_fetch_array(mysql_query("SELECT * FROM tests WHERE id='$tid' order by id asc"));
if($testsql[id]==""){header("Location:tests.php");exit();}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" id="vpne" content="width=device-width, initial-scale=1,maximum-scale=1">
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<script src="js/genel.js" type="text/javascript"></script>
<script src="js/test_edit.js" type="text/javascript"></script>
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
<a href="tests.php" class="scl" ><span><img src="images/ico2.png" /></span>Tests</a>
<a href="bulletin_board.php" class="nrml" ><span><img src="images/ico3.png" /></span>Bulletin Board</a>
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

<div class="fl dtybslk fmbslk"><a href="tests.php">Tests</a><img src="images/sagok.png" /><span>Edit Test</span><div class="t"></div></div>
<div class="t"></div>
<div class="dtybbslk">Edit Test</div>


<div class="yntstds">

<form method="post" name="newtest" id="newtest" action="javascript:edittest();" >
<input type="hidden" name="tid" id="tid" value="<? echo "$testsql[id]"; ?>" />
<div class="bslk1">TEST TITLE</div>
<div class="frm1"><input type="text" name="title" id="title" class="bbfrminpt" value="<? echo "$testsql[title]"; ?>" placeholder="Type Here" /></div>

<div class="srlr">
<div class="bslk2">QUESTIONS</div>
<?
$questionkac=0;
$bb_data = "select * from test_questions where test_id='$testsql[id]' order by id asc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$questionkac++;
?>
<div class="srtk" id="srtk<? echo "$questionkac"; ?>">
<div class="fl bslk">QUESTION <? echo "$questionkac"; ?></div>
<div class="t"></div>
<div class="frm2"><input type="text" name="srtitle[]" class="bbfrminpt" value="<? echo "$bb[question]"; ?>" placeholder="Type Here" /></div>
<div class="opbslk">OPTIONS</div>
<div class="frm3"><input type="text" name="optiona[]" class="bbfrminpt" value="<? echo "$bb[answera]"; ?>" placeholder="Option A" /></div>
<div class="frm3"><input type="text" name="optionb[]" class="bbfrminpt" value="<? echo "$bb[answerb]"; ?>" placeholder="Option B" /></div>
<div class="frm3"><input type="text" name="optionc[]" class="bbfrminpt" value="<? echo "$bb[answerc]"; ?>" placeholder="Option C" /></div>
<div class="frm3"><input type="text" name="optiond[]" class="bbfrminpt" value="<? echo "$bb[answerd]"; ?>" placeholder="Option D" /></div>
</div>
<?
}
?>

</div>

<div class="frm4"><input type="submit" name="submit" id="submit" class="inptsbt" value="Save" action="javascript:edittest();" /><a href="test_detay.php?id=<? echo "$testsql[id]"; ?>&t=delete" class="inptgri inptgridel" >Delete Test</a><div class="t"></div></div>
</div>


</form>

</div>


</div>

<? include("footer.php"); ?>
</div>
<div class="bosdv"></div>
</body>
</html>