<?PHP 
session_start();
ob_start();
include ("mysqlbaglanti/baglan.php");
include ("guvenlik.php");

$totaltest=mysql_fetch_array(mysql_query("SELECT COUNT(id) as kd FROM tests WHERE status='1' order by status asc"));
$onlinetest=mysql_fetch_array(mysql_query("SELECT COUNT(id) as kd FROM tests WHERE test_type='Online' and status='1' order by status asc"));
$offlinetest=mysql_fetch_array(mysql_query("SELECT COUNT(id) as kd FROM tests WHERE test_type='Offline' and status='1' order by status asc"));

$percent2=0;
$mandatorysay=0;
$totalmandatory=mysql_fetch_array(mysql_query("SELECT COUNT(id) as kd FROM tests WHERE mandatory='1' and status='1' order by status asc"));
$percent1=round(100/$totalmandatory[kd]);
$bb_data = "select * from tests where status='1' order by id asc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$testcontrol=mysql_fetch_array(mysql_query("SELECT id FROM test_answers WHERE user_id='$uyene[id]' and test_id='$bb[id]' and status='1' order by id asc"));
if($testcontrol[id]!=""){$mandatorysay++;$percent2=$percent2+$percent1;}
}
if($percent2>97){$percent2="100";}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" id="vpne" content="width=device-width, initial-scale=1,maximum-scale=1">
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<script src="js/genel.js" type="text/javascript"></script>
<script src="js/tests.js" type="text/javascript"></script>
<script src="js/jquery.selectric.min.js" type="text/javascript"></script>
<script src="js/jquery-asPieProgress.min.js" type="text/javascript"></script>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,600,300,300italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href="css/progress.css" rel="stylesheet" type="text/css" />
<link href="css/selectric2.css" rel="stylesheet" type="text/css" />
<link href="css/genel.css" rel="stylesheet" type="text/css" />
<script>
$(window).load(function() {
$('.pie_progress').asPieProgress('go',"<? echo "$percent2"; ?>%");
});
</script>

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

<div class="tstust">
<div class="stats"><div class="pie_progress" role="progressbar" data-barcolor="#b11f24" data-trackcolor="#626262" data-barsize="25" ><div class="pie_progress__number">0%</div></div></div>
<div class="altyz">You’ve completed <strong><? echo "$mandatorysay"; ?></strong> of your <strong><? echo "$totalmandatory[kd]"; ?></strong> mandatory classes!<br />You have <strong><? echo $totalmandatory[kd]-$mandatorysay; ?></strong> more to take. You’d better start signing up!</div>
</div>

<div class="tsts">
<a href="javascript:;" onclick="tstblm(1);" class="slovl scl" id="blmlnk1" >ALL TESTS (<? echo "$totaltest[kd]"; ?>)</a>
<a href="javascript:;" onclick="tstblm(2);" class="nrml" id="blmlnk2" >ONLINE TESTS (<? echo "$onlinetest[kd]"; ?>)</a>
<a href="javascript:;" onclick="tstblm(3);" class="sgovl nrml" id="blmlnk3" >OFFLINE TESTS (<? echo "$offlinetest[kd]"; ?>)</a>
</div>

<div class="nrml_tstler">
<div class="tstler" id="tstler1">
<table cellpadding="0" cellspacing="0" width="100%" border="0" >
<tr class="ilktd">
<td class="yta">YOUR TESTS</td>
<td class="ytb">MANDATORY?</td>
<td class="ytb">SCORE</td>
<td class="ytb">TYPE</td>
<td class="ytb">STATUS</td>
<td class="ytb">ACTION</td>
</tr>
<?
$bb_data = "select * from tests where status='1' order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$mandatory="";
$link="";
if($bb[mandatory]=="1"){$mandatory="Yes";}else{$mandatory="No";}
$scoret="";
$answerinfo=mysql_fetch_array(mysql_query("SELECT score FROM test_answers WHERE user_id='$uyene[id]' and test_id='$bb[id]' and status='1' "));
$scoret=$answerinfo[score];
if($answerinfo[score]!=""){$text2="FINISHED";$text1="See Details";}else{$text2="<span>WAITING</span>";$text1="Start";}
if($bb[test_type]=="Online"){if($answerinfo[score]!=""){$link="href='test_detay.php?id=$bb[id]'";}else{$link="href='test.php?id=$bb[id]'";}}else{
$link="href='javascript:;' onclick='rndval($bb[id]);'";
$text1="Sign Up";
$offlinebak=mysql_fetch_array(mysql_query("SELECT status,score FROM test_offline WHERE user_id='$uyene[id]' and test_id='$bb[id]' "));
if($offlinebak[status]=="0"){$text2="<span>SIGNED UP</span>";$link="href='javascript:;'";$text1="Appointment";}
elseif($offlinebak[status]=="1"){$text2="FINISHED";$link="href='javascript:;'";$text1="See Details";}else{
$link="href='javascript:;' onclick='rndval($bb[id]);'";
}
$scoret="$offlinebak[score]";
}
$classne="";
if($text1=="See Details"){$classne="class='sd'";}else{$classne="class='nrml'";}

?>
<tr>
<td class="itd" ><? echo "$bb[title]"; ?></td>
<td><? echo "$mandatory"; ?></td>
<td><? echo "$scoret"; ?></td>
<td><? echo "$bb[test_type]"; ?></td>
<td><? echo "$text2"; ?></td>
<td class="std" ><a <? echo "$link $classne"; ?> ><? echo "$text1"; ?></a></td>
</tr>
<?
}
?>
</table>
</div>

<div class="tstler" id="tstler2">
<table cellpadding="0" cellspacing="0" width="100%" border="0" >
<tr class="ilktd">
<td class="yta">YOUR TESTS</td>
<td class="ytb">MANDATORY?</td>
<td class="ytb">SCORE</td>
<td class="ytb">TYPE</td>
<td class="ytb">STATUS</td>
<td class="ytb">ACTION</td>
</tr>
<?
$bb_data = "select * from tests where test_type='Online' and status='1' order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$mandatory="";
$link="";
if($bb[mandatory]=="1"){$mandatory="Yes";}else{$mandatory="No";}
$scoret="";
$answerinfo=mysql_fetch_array(mysql_query("SELECT score FROM test_answers WHERE user_id='$uyene[id]' and test_id='$bb[id]' and status='1' "));
$scoret=$answerinfo[score];
if($answerinfo[score]!=""){$text2="FINISHED";$text1="See Details";}else{$text2="<span>WAITING</span>";$text1="Start";}
if($bb[test_type]=="Online"){$link="href='test.php?id=$bb[id]'";}else{
$link="href='javascript:;' onclick='rndval($bb[id]);'";
$text1="Sign Up";
$offlinebak=mysql_fetch_array(mysql_query("SELECT status,score FROM test_offline WHERE user_id='$uyene[id]' and test_id='$bb[id]' "));
if($offlinebak[status]=="0"){$text2="<span>SIGNED UP</span>";$link="href='javascript:;'";$text1="Appointment";}
elseif($offlinebak[status]=="1"){$text2="FINISHED";$link="href='javascript:;'";$text1="See Details";}else{
$link="href='javascript:;' onclick='rndval($bb[id]);'";
}
$scoret="$offlinebak[score]";
}
$classne="";
if($text1=="See Details"){$classne="class='sd'";}else{$classne="class='nrml'";}

?>
<tr>
<td class="itd" ><? echo "$bb[title]"; ?></td>
<td><? echo "$mandatory"; ?></td>
<td><? echo "$scoret"; ?></td>
<td><? echo "$bb[test_type]"; ?></td>
<td><? echo "$text2"; ?></td>
<td class="std" ><a <? echo "$link $classne"; ?> ><? echo "$text1"; ?></a></td>
</tr>
<?
}
?>
</table>
</div>

<div class="tstler" id="tstler3">
<table cellpadding="0" cellspacing="0" width="100%" border="0" >
<tr class="ilktd">
<td class="yta">YOUR TESTS</td>
<td class="ytb">MANDATORY?</td>
<td class="ytb">SCORE</td>
<td class="ytb">TYPE</td>
<td class="ytb">STATUS</td>
<td class="ytb">ACTION</td>
</tr>
<?
$bb_data = "select * from tests where test_type='Offline' and status='1' order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$mandatory="";
$link="";
if($bb[mandatory]=="1"){$mandatory="Yes";}else{$mandatory="No";}
$scoret="";
$answerinfo=mysql_fetch_array(mysql_query("SELECT score FROM test_answers WHERE user_id='$uyene[id]' and test_id='$bb[id]' and status='1' "));
$scoret=$answerinfo[score];
if($answerinfo[score]!=""){$text2="FINISHED";$text1="See Details";}else{$text2="<span>WAITING</span>";$text1="Start";}
if($bb[test_type]=="Online"){$link="href='test.php?id=$bb[id]'";}else{
$link="href='javascript:;' onclick='rndval($bb[id]);'";
$text1="Sign Up";
$offlinebak=mysql_fetch_array(mysql_query("SELECT status,score FROM test_offline WHERE user_id='$uyene[id]' and test_id='$bb[id]' "));
if($offlinebak[status]=="0"){$text2="<span>SIGNED UP</span>";$link="href='javascript:;'";$text1="Appointment";}
elseif($offlinebak[status]=="1"){$text2="FINISHED";$link="href='javascript:;'";$text1="See Details";}else{
$link="href='javascript:;' onclick='rndval($bb[id]);'";
}
$scoret="$offlinebak[score]";
}
$classne="";
if($text1=="See Details"){$classne="class='sd'";}else{$classne="class='nrml'";}

?>
<tr>
<td class="itd" ><? echo "$bb[title]"; ?></td>
<td><? echo "$mandatory"; ?></td>
<td><? echo "$scoret"; ?></td>
<td><? echo "$bb[test_type]"; ?></td>
<td><? echo "$text2"; ?></td>
<td class="std" ><a <? echo "$link $classne"; ?> ><? echo "$text1"; ?></a></td>
</tr>
<?
}
?>
</table>
</div>
</div>

<div class="mobil_tstler">
<div class="mtstler" id="mtstler1">
<div class="mtst_bslk"><div class="fl sl">TEST</div><div class="fl sg">STATUS</div><div class="t"></div></div>
<?
$bb_data = "select * from tests where status='1' order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$mandatory="";
$link="";
if($bb[mandatory]=="1"){$mandatory="Yes";}else{$mandatory="No";}
$scoret="";
$answerinfo=mysql_fetch_array(mysql_query("SELECT score FROM test_answers WHERE user_id='$uyene[id]' and test_id='$bb[id]' and status='1' "));
$scoret=$answerinfo[score];
if($answerinfo[score]!=""){$text2="FINISHED";$text1="See Details";}else{$text2="<span>WAITING</span>";$text1="Start";}
if($bb[test_type]=="Online"){if($answerinfo[score]!=""){$link="href='test_detay.php?id=$bb[id]'";}else{$link="href='test.php?id=$bb[id]'";}}else{
$link="href='javascript:;' onclick='rndval($bb[id]);'";
$text1="Sign Up";
$offlinebak=mysql_fetch_array(mysql_query("SELECT status,score FROM test_offline WHERE user_id='$uyene[id]' and test_id='$bb[id]' "));
if($offlinebak[status]=="0"){$text2="<span>SIGNED UP</span>";$link="href='javascript:;'";$text1="Appointment";}
elseif($offlinebak[status]=="1"){$text2="FINISHED";$link="href='javascript:;'";$text1="See Details";}else{
$link="href='javascript:;' onclick='rndval($bb[id]);'";
}
$scoret="$offlinebak[score]";
}
if($scoret==""){$scoret="-";}
$classne="";
if($text1=="See Details"){$classne="class='sd'";}else{$classne="class='nrml'";}
?>
<div class="mtst_byztk" onclick="takpt('gri_1_<? echo "$bb[id]"; ?>');" ><div class="sl"><? echo "$bb[title]"; ?></div><div class="sg"><? echo "$text2"; ?></div></div>
<div class="mtst_gritk" id="gri_1_<? echo "$bb[id]"; ?>"><div class="b1">SCORE<br /><span><? echo "$scoret"; ?></span></div><div class="b2">MANDATORY?<br /><span><? echo "$mandatory"; ?></span></div><div class="b3">TYPE?<br /><span><? echo "$bb[test_type]"; ?></span></div><div class="b4"><a <? echo "$link $classne"; ?> ><? echo "$text1"; ?></a></div></div>
<?
}
?>
</div>

<div class="mtstler" id="mtstler2">
<div class="mtst_bslk"><div class="fl sl">TEST</div><div class="fl sg">STATUS</div><div class="t"></div></div>
<?
$bb_data = "select * from tests where test_type='Online' and status='1' order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$mandatory="";
$link="";
if($bb[mandatory]=="1"){$mandatory="Yes";}else{$mandatory="No";}
$scoret="";
$answerinfo=mysql_fetch_array(mysql_query("SELECT score FROM test_answers WHERE user_id='$uyene[id]' and test_id='$bb[id]' and status='1' "));
$scoret=$answerinfo[score];
if($answerinfo[score]!=""){$text2="FINISHED";$text1="See Details";}else{$text2="<span>WAITING</span>";$text1="Start";}
if($bb[test_type]=="Online"){if($answerinfo[score]!=""){$link="href='test_detay.php?id=$bb[id]'";}else{$link="href='test.php?id=$bb[id]'";}}else{
$link="href='javascript:;' onclick='rndval($bb[id]);'";
$text1="Sign Up";
$offlinebak=mysql_fetch_array(mysql_query("SELECT status,score FROM test_offline WHERE user_id='$uyene[id]' and test_id='$bb[id]' "));
if($offlinebak[status]=="0"){$text2="<span>SIGNED UP</span>";$link="href='javascript:;'";$text1="Appointment";}
elseif($offlinebak[status]=="1"){$text2="FINISHED";$link="href='javascript:;'";$text1="See Details";}else{
$link="href='javascript:;' onclick='rndval($bb[id]);'";
}
$scoret="$offlinebak[score]";
}
if($scoret==""){$scoret="-";}
$classne="";
if($text1=="See Details"){$classne="class='sd'";}else{$classne="class='nrml'";}
?>
<div class="mtst_byztk" onclick="takpt('gri_2_<? echo "$bb[id]"; ?>');" ><div class="sl"><? echo "$bb[title]"; ?></div><div class="sg"><? echo "$text2"; ?></div></div>
<div class="mtst_gritk" id="gri_2_<? echo "$bb[id]"; ?>"><div class="b1">SCORE<br /><span><? echo "$scoret"; ?></span></div><div class="b2">MANDATORY?<br /><span><? echo "$mandatory"; ?></span></div><div class="b3">TYPE?<br /><span><? echo "$bb[test_type]"; ?></span></div><div class="b4"><a <? echo "$link $classne"; ?> ><? echo "$text1"; ?></a></div></div>
<?
}
?>
</div>

<div class="mtstler" id="mtstler3">
<div class="mtst_bslk"><div class="fl sl">TEST</div><div class="fl sg">STATUS</div><div class="t"></div></div>
<?
$bb_data = "select * from tests where test_type='Offline' and status='1' order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$mandatory="";
$link="";
if($bb[mandatory]=="1"){$mandatory="Yes";}else{$mandatory="No";}
$scoret="";
$answerinfo=mysql_fetch_array(mysql_query("SELECT score FROM test_answers WHERE user_id='$uyene[id]' and test_id='$bb[id]' and status='1' "));
$scoret=$answerinfo[score];
if($answerinfo[score]!=""){$text2="FINISHED";$text1="See Details";}else{$text2="<span>WAITING</span>";$text1="Start";}
if($bb[test_type]=="Online"){if($answerinfo[score]!=""){$link="href='test_detay.php?id=$bb[id]'";}else{$link="href='test.php?id=$bb[id]'";}}else{
$link="href='javascript:;' onclick='rndval($bb[id]);'";
$text1="Sign Up";
$offlinebak=mysql_fetch_array(mysql_query("SELECT status,score FROM test_offline WHERE user_id='$uyene[id]' and test_id='$bb[id]' "));
if($offlinebak[status]=="0"){$text2="<span>SIGNED UP</span>";$link="href='javascript:;'";$text1="Appointment";}
elseif($offlinebak[status]=="1"){$text2="FINISHED";$link="href='javascript:;'";$text1="See Details";}else{
$link="href='javascript:;' onclick='rndval($bb[id]);'";
}
$scoret="$offlinebak[score]";
}
if($scoret==""){$scoret="-";}
$classne="";
if($text1=="See Details"){$classne="class='sd'";}else{$classne="class='nrml'";}
?>
<div class="mtst_byztk" onclick="takpt('gri_3_<? echo "$bb[id]"; ?>');" ><div class="sl"><? echo "$bb[title]"; ?></div><div class="sg"><? echo "$text2"; ?></div></div>
<div class="mtst_gritk" id="gri_3_<? echo "$bb[id]"; ?>"><div class="b1">SCORE<br /><span><? echo "$scoret"; ?></span></div><div class="b2">MANDATORY?<br /><span><? echo "$mandatory"; ?></span></div><div class="b3">TYPE?<br /><span><? echo "$bb[test_type]"; ?></span></div><div class="b4"><a <? echo "$link $classne"; ?> ><? echo "$text1"; ?></a></div></div>
<?
}
?>
</div>

</div>

</div>

<? include("footer.php"); ?>
</div>
<div class="bosdv"></div>
</body>
</html>