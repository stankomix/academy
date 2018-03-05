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
<script src="js/jquery.ezmark.min.js" type="text/javascript"></script>
<script src="js/jquery.selectric.min.js" type="text/javascript"></script>
<script src="js/test_edit_p.js" type="text/javascript"></script>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,600,300,300italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href="css/selectric2.css" rel="stylesheet" type="text/css" />
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

<div class="dtybslk fmbslk"><a href="tests.php">Tests</a><img src="images/sagok.png" /><span>Add New Test</span><div class="t"></div></div>
<div class="fl dtybbslk">Add New Test</div>
<div class="fr bbsaeds"><a href="javascript:;" onclick="publishtest();" class="rnk sae bbsae">Publish</a></div>
<div class="fr bbsaeds"><a href="javascript:;" onclick="savetest();" class="rnk sae bbsae">Save</a></div>
<div class="t"></div>


<div class="yntstds">

<form method="post" name="newtest" id="newtest" action="javascript:publishtest();" >
<input type="hidden" name="tid" id="tid" value="<? echo "$testsql[id]"; ?>" />
<div class="bslk1">TEST TITLE</div>
<div class="frm1"><input type="text" name="title" id="title" class="bbfrminpt" value="<? echo "$testsql[title]"; ?>" placeholder="Type Here" /></div>
<div class="bslk1">TYPE</div>
<div class="fl cvptk"><label for="test_type1a"><div class="fl cvprdy"><input type="radio" name="test_type" id="test_type1a" value="Online" <? if($testsql[test_type]=="Online"){ echo "checked='checked'";}?> /></div><div class="fl cvpyz">Online</div><div class="t"></div></label></div>
<div class="fl cvptk"><label for="test_type1b"><div class="fl cvprdy"><input type="radio" name="test_type" id="test_type1b" value="Offline" <? if($testsql[test_type]=="Offline"){ echo "checked='checked'";}?> /></div><div class="fl cvpyz">Offline</div><div class="t"></div></label></div>
<div class="t"></div>
<div class="bslk1">MANDATORY?</div>
<div class="fl cvptk"><label for="mandatory1a"><div class="fl cvprdy"><input type="radio" name="mandatory" id="mandatory1a" value="1" <? if($testsql[mandatory]=="1"){ echo "checked='checked'";}?> /></div><div class="fl cvpyz">Yes</div><div class="t"></div></label></div>
<div class="fl cvptk"><label for="mandatory1b"><div class="fl cvprdy"><input type="radio" name="mandatory" id="mandatory1b" value="0" <? if($testsql[mandatory]=="0"){ echo "checked='checked'";}?> /></div><div class="fl cvpyz">No</div><div class="t"></div></label></div>
<div class="t"></div>
<div class="srlr">
<div class="bslk2">QUESTIONS</div>
<?
$question_count=0;
$bb_data = "select * from test_questions where test_id='$testsql[id]' order by id asc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$question_count++;
?>
<div class="srtk" id="srtk<? echo "$question_count"; ?>">
<div class="fl bslk">QUESTION <? echo "$question_count"; ?></div>
<div class="fr "><a href="javascript:;" onclick="delquestion('<? echo "$question_count"; ?>');" class="sae saesr">Delete Question</a></div>
<div class="fr slct">
<select id="basic" name="correct_answer[]">
<option value="A" <?if($bb[correct_answer]=="A"){ echo "selected='selected'";}?> >A</option>
<option value="B" <?if($bb[correct_answer]=="B"){ echo "selected='selected'";}?> >B</option>
<option value="C" <?if($bb[correct_answer]=="C"){ echo "selected='selected'";}?> >C</option>
<option value="D" <?if($bb[correct_answer]=="D"){ echo "selected='selected'";}?> >D</option>
</select>
</div>
<div class="fr ca">Correct Answer :</div>
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
<script>var question_id=<? echo "$question_count"; ?>;</script>
</div>

<div class="frm4"><a href="javascript:questionekle();" class="inptgri" >Add Question</a><div class="gzlbr" ></div><a href="javascript:savetest();" style="margin-right:10px;" class="inptsbt" >Save</a><input type="submit" name="submit" id="submit" class="inptsbt" value="Publish" action="javascript:publishtest();" /><div class="t"></div></div>


</form>

</div>


</div>

<? include("footer.php"); ?>
</div>
<div class="bosdv"></div>
</body>
</html>