<?PHP 
session_start();
ob_start();
include ("mysqlbaglanti/baglan.php");
include ("guvenlik.php");

$name_surnamene = explode(" ",$uyene[name_surname]);
$onlyname="$name_surnamene[0]";
?>
<div class="ub">
<div class="ort">
<div class="fl logoyz"><a href="index.php"><img src="images/logoyz.png" /></a></div>
<div class="fr logout"><a href="logout.php"><img src="images/logout.png" /></a></div>
<div class="fr hll">Hello <? echo "$onlyname"; ?></div>
<div class="t"></div>
</div>
</div>