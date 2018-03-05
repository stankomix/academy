<?
session_start();
ob_start();
include ("mysqlbaglanti/baglan.php");
header("Cache-Control: no-cache");
header("Content-Type:text/html;charset=utf-8");
function hcevir($sData) { $out = ""; for ($i = 0; $i<strlen($sData);$i++) { $ch1= ord($sData{$i}); if($ch1==195 OR $ch1==196 OR $ch1==197) { $ch2=ord($sData{$i+1}); $ch="$ch1$ch2"; $bak=1;
switch($ch) { case "196159": $out .= "ğ";break; case "196158": $out .= "Ğ";break; case "196177": $out .= "ı";break; case "196176": $out .= "İ";break; case "195167": $out .= "ç";break; case "195135": $out .= "Ç";break; case "195188": $out .= "ü"; break; case "195156": $out .= "Ü"; break; case "195182": $out .= "ö"; break; case "195150": $out .= "Ö"; break; case "197158": $out .= "Ş"; break; case "197159": $out .= "ş"; break; } continue; } else if($bak==1) { $bak=0; continue; } else $out .= chr($ch1); }
return $out; 
}
$id=intval($_REQUEST[id]);
$file_embed=mysql_fetch_array(mysql_query("SELECT * FROM files WHERE id='$id' and status='1' order by id asc"));

$clickadd = "UPDATE files SET clicks=clicks + 1 WHERE id='$file_embed[id]'";
mysql_query($clickadd);

?>
<script>
var iframeheight=$(".bbfmaln iframe").attr("height");
var iframewidth=$(".bbfmaln iframe").attr("width");
var embedwidth=$(".embdds").width();
var heightne=0;
$(document).ready(function() {

$(".tklmaln").css({width:$("body").width(),height:$("body").height()});
$(".tklmaln").click(function(){nwpstkpt();});

embedegore();

});
$(window).resize(embedegore);
function embedegore(){
$(".bosdv,.tklmaln").css({width:"100%"});
$(".embdds").css({left:($(window).width()-$(".embdds").width())/2});

iframeheight=$(".bbfmaln iframe").attr("height");
iframewidth=$(".bbfmaln iframe").attr("width");
embedwidth=$(".embdds").width();

heightne=(embedwidth*iframeheight)/iframewidth;
$(".bbfmaln iframe").css({width:"100%",height:heightne});
}

function nwpstkpt(){$(".bosdv").css({width:"auto"});$(".bosdv").html("");}

</script>
<div class="tklmaln"></div>
<div class="embdds">
<div class="bslk"><? echo "$file_embed[title]"; ?></div>
<div class="bbfmaln"><? echo htmlspecialchars_decode($file_embed[embed_code]); ?></div>
</div>
