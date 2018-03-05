<?
session_start();
ob_start();
include ("../mysqlbaglanti/baglan.php");
include ("guvenlik.php");
header("Content-Type:text/html;charset=iso-8859-9");
function ConvertAjaxChars($sData) { $out = ""; for ($i = 0; $i<strlen($sData);$i++) { $ch1= ord($sData{$i}); if($ch1==195 OR $ch1==196 OR $ch1==197) { $ch2=ord($sData{$i+1}); $ch="$ch1$ch2"; $bak=1;
switch($ch) { case "196159": $out .= "ð";break; case "196158": $out .= "Ð";break; case "196177": $out .= "ý";break; case "196176": $out .= "Ý";break; case "195167": $out .= "ç";break; case "195135": $out .= "Ç";break; case "195188": $out .= "ü"; break; case "195156": $out .= "Ü"; break; case "195182": $out .= "ö"; break; case "195150": $out .= "Ö"; break; case "197158": $out .= "Þ"; break; case "197159": $out .= "þ"; break; } continue; } else if($bak==1) { $bak=0; continue; } else $out .= chr($ch1); }
return $out; 
}
$aid=$_REQUEST[aid];
$photoid=$_REQUEST[photoid];

if($photoid!=""){
$sqlcontrol=mysql_fetch_array(mysql_query("SELECT * FROM photos WHERE id='$photoid' "));

$deletesql = "UPDATE photos SET status = '2' WHERE id='$sqlcontrol[id]'";
mysql_query($deletesql);
}
?>
<script>
function takibikaldir(id){
$.post( "galerifotoajax.php", {photoid:id} );
$("#tkbne"+id).remove();
}
</script>
<?
$tablosaydir=0;
$photos_data = "select * from photos where file_id='$aid' and status='1' order by id desc";
$photos_sorgu = mysql_query($photos_data);
while ($photos = mysql_fetch_assoc($photos_sorgu)){
$tablosaydir++;
?>
<div class="ftajaxdiv" id="tkbne<? echo "$photos[id]"; ?>" >
<a href="javascript:;" onclick="takibikaldir('<? echo "$photos[id]"; ?>');"><div class="ftajaxtkldr" id="fotokaldirdiv<? echo "$photos[id]"; ?>"><img src="images/kaldir1.png" /></div></a>
<img src="../<? echo "$photos[small_url]"; ?>" class="ftajaxrsm" >
</div>
<?
}
ob_end_flush();
?>