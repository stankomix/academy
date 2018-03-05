<?
session_start();
ob_start();
include ("../mysqlbaglanti/baglan.php");
include ("guvenlik.php");
header("Cache-Control: no-cache");
header("Content-Type:text/html;charset=utf-8");
function hcevir($sData) { $out = ""; for ($i = 0; $i<strlen($sData);$i++) { $ch1= ord($sData{$i}); if($ch1==195 OR $ch1==196 OR $ch1==197) { $ch2=ord($sData{$i+1}); $ch="$ch1$ch2"; $bak=1;
switch($ch) { case "196159": $out .= "ğ";break; case "196158": $out .= "Ğ";break; case "196177": $out .= "ı";break; case "196176": $out .= "İ";break; case "195167": $out .= "ç";break; case "195135": $out .= "Ç";break; case "195188": $out .= "ü"; break; case "195156": $out .= "Ü"; break; case "195182": $out .= "ö"; break; case "195150": $out .= "Ö"; break; case "197158": $out .= "Ş"; break; case "197159": $out .= "ş"; break; } continue; } else if($bak==1) { $bak=0; continue; } else $out .= chr($ch1); }
return $out; 
}
$test_id=intval($_REQUEST[id]);
$offlinetest=mysql_fetch_array(mysql_query("SELECT * FROM test_offline WHERE id='$test_id' order by id asc"));
$testne=mysql_fetch_array(mysql_query("SELECT * FROM tests WHERE id='$offlinetest[test_id]' order by id asc"));
?>
<script>
var ekranheight=$(window).height();
$(document).ready(function() {
$('select').selectric({disableOnMobile:false});

$(".tklmaln").css({width:$("body").width(),height:$("body").height()});
$(".tklmaln").click(function(){nwpstkpt();});
randevugore();

});

$(window).resize(randevugore);

function randevugore(){
ekranwidth=$(window).width();
if(ekranwidth<=520){
var testnerde = $(".mobil_tstler").position();
}else{
var testnerde = $(".nrml_tstler").position();
}
$(".bosdv,.tklmaln").css({width:"100%"});
$(".rndvds").css({left:($(window).width()-$(".rndvds").width())/2,top:testnerde.top});
}

function nwpstkpt(){$(".bosdv").html("");}

function npstgndr()
{
$.ajax({
type: 'POST',
url :'ajax-randevu-islem.php',
data: $('form#bbform').serialize(),
success: function(answer)
{
location.reload();
}
});
}
</script>
<div class="tklmaln"></div>
<div class="rndvds">
<div class="bslk">RESULT ENTRY</div>
<form method="post" name="bbform" id="bbform" action="javascript:npstgndr();" >
<input type="hidden" name="test_id" id="test_id" value="<? echo "$offlinetest[id]"; ?>" />
<div class="bbfmaln">

<div class="bbslk"><? echo "$testne[title]"; ?></div>

<div class="fl yzlr1">TEST RESULT</div>
<div class="fl yzlr2">FINISHED?</div>
<div class="t"></div>

<div class="fl slct1">
<select id="basic" name="score">
<?
$songun="101";
for($r=0; $r<$songun; $r=$r+1) {
?>
<option value="<? echo"$r"; ?>"><? echo "$r"; ?></option>
<?}?>
</select>
</div>
<div class="fl slct2">
<select id="basic" name="status">
<option value="0">NO</option>
<option value="1">YES</option>
</select>
</div>
<div class="t"></div>

<div class="frm4"><input type="submit" name="submit" id="submit" class="inptsbt" value="Send" action="javascript:npstgndr();" /><a href="javascript:nwpstkpt();" class="inptgri" >Cancel</a></div>

</div>
</form>

</div>
