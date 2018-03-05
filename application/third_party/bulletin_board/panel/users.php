<?PHP 
session_start();
ob_start();
include ("../mysqlbaglanti/baglan.php");
include ("guvenlik.php");

$offlinetest=mysql_fetch_array(mysql_query("SELECT COUNT(id) as kd FROM tests WHERE test_type='Offline' and status='1' order by status asc"));
$onlinetest=mysql_fetch_array(mysql_query("SELECT COUNT(id) as kd FROM tests WHERE test_type='Online' and status='1' order by status asc"));

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" id="vpne" content="width=device-width, initial-scale=1,maximum-scale=1">
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<script src="js/genel.js" type="text/javascript"></script>
<script src="js/users.js" type="text/javascript"></script>
<script src="js/jquery.selectric.min.js" type="text/javascript"></script>
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
<a href="filemanager.php" class="nrml" ><span><img src="images/ico4.png" /></span>File Manager</a>
<a href="users.php" class="scl" ><span><img src="images/ico5.png" /></span>Users</a>
<a href="admins.php" class="nrml" ><span><img src="images/ico5.png" /></span>Admins</a>
<div class="t"></div>
</div>
</div>
</div>
<div class="logo"><a href="index.php"><img src="images/logo.png" /></a></div>
</div>
<? include("header_mobil.php"); ?>

<div class="ort">

<div class="fl bbbslk">USERS</div>
<div class="fr bbsaeds"><a href="javascript:;" onclick="uekle();" class="rnk sae bbsae">New User</a></div>
<div class="t"></div>

<div class="usrstum">

<div class="nrml_users">

<table cellpadding="0" cellspacing="0" width="100%" border="0" >
<tr class="ilktd">
<td class="yta">NAME</td>
<td class="ytb">TITLE</td>
<td class="ytb">OFFLINE TESTS</td>
<td class="ytb">ONLINE TESTS</td>
<td class="ytb">ACTION</td>
</tr>
<?
$bb_data = "select * from users where status='1' order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$finish_online=mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT test_id) as kd FROM test_answers WHERE user_id='$bb[id]' and status='1' "));
$finish_offline=mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT test_id) as kd FROM test_offline WHERE user_id='$bb[id]' and status='1' "));
?>
<tr id="usrid<? echo "$bb[id]"; ?>" >
<td class="itd1" ><? echo "$bb[name_surname]"; ?></td>
<td class="itd2" ><? echo "$bb[job]"; ?></td>
<td class="itd3" ><? echo "$finish_offline[kd]"; ?>/<? echo "$offlinetest[kd]"; ?></td>
<td class="itd3" ><? echo "$finish_online[kd]"; ?>/<? echo "$onlinetest[kd]"; ?></td>
<td class="std" ><a href="javascript:;" onclick="edituser(<? echo "$bb[id]"; ?>);">Edit User</a></td>
</tr>
<?
}
?>
</table>

</div>

<div class="mobil_users">
<div class="musers">
<div class="mtst_bslk"><div class="fl sl">TEST</div><div class="fl or">ONLINE TEST</div><div class="fl sg">OFFLINE TEST</div><div class="t"></div></div>
<?
$bb_data = "select * from users where status='1' order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$finish_online=mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT test_id) as kd FROM test_answers WHERE user_id='$bb[id]' and status='1' "));
$finish_offline=mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT test_id) as kd FROM test_offline WHERE user_id='$bb[id]' and status='1' "));
?>
<div class="mtst_byztk" onclick="takpt('gri_<? echo "$bb[id]"; ?>');" ><div class="sl"><? echo "$bb[name_surname]"; ?></div><div class="or"><? echo "$finish_online[kd]"; ?>/<? echo "$onlinetest[kd]"; ?></div><div class="sg"><? echo "$finish_offline[kd]"; ?>/<? echo "$offlinetest[kd]"; ?></div></div>
<div class="mtst_gritk" id="gri_<? echo "$bb[id]"; ?>"><div class="b1">TITLE<br /><span><? echo "$bb[job]"; ?></span></div><div class="b4"><a href="javascript:;" onclick="edituser(<? echo "$bb[id]"; ?>);">Edit User</a></div></div>
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