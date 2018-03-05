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

$t=htmlspecialchars(hcevir($_REQUEST[t]),ENT_QUOTES);
$fmid=intval($_REQUEST[fmid]);
$fminfo=mysql_fetch_array(mysql_query("SELECT * FROM files WHERE id='$fmid' order by id asc"));
if($fminfo[id]!=""){
if($t=="delete"){
$bbeditsql = "UPDATE files SET status='2' WHERE id='$fminfo[id]'";
mysql_query($bbeditsql);
}else{
if($fminfo[category]=="Handbooks"){$cat="1";}
elseif($fminfo[category]=="Videos"){$cat="2";}
elseif($fminfo[category]=="Guides"){$cat="3";}
elseif($fminfo[category]=="Event Photos"){$cat="4";}
elseif($fminfo[category]=="Manuals"){$cat="5";}
elseif($fminfo[category]=="Other"){$cat="6";}
?>
<script>
$(document).ready(function() {

$('select').selectric({disableOnMobile:false});

$(".tklmaln").css({width:$("body").width(),height:$("body").height()});
$(".tklmaln").click(function(){nwpstkpt();});

$("select[name='category']").change(function() {
var valne=$(this).val();
if(valne=="Videos"){
$(".frm4").css({display:"block"});
$(".slct1").css({display:"none"});
}else{
$(".slct1").css({display:"block"});
$(".frm4").css({display:"none"});
}
});

<?
if($cat=="2"){
?>
$(".frm4").css({display:"block"});
$(".slct1").css({display:"none"});
<?
}
?>

fmeditgore();

});

$(window).resize(fmeditgore);

function fmeditgore(){
$(".bosdv,.tklmaln").css({width:"100%"});
$(".fmds").css({left:($(window).width()-$(".fmds").width())/2});
}


function nwpstkpt(){$(".bosdv").html("");}

function npstgndr()
{
$.ajax({
type: 'POST',
url :'ajax-fmduzenle-islem.php',
data: $('form#bbform').serialize(),
success: function(answer)
{
location.reload();
}
});
}
</script>
<div class="tklmaln"></div>
<div class="fmds">
<div class="bslk">FILE EDIT</div>
<form method="post" name="bbform" id="bbform" action="javascript:npstgndr();" enctype="multipart/form-data" >
<input type="hidden" name="fmid" id="fmid" value="<? echo "$fminfo[id]"; ?>" />
<div class="fmaln">
<div class="frm1"><input type="text" name="title" id="title" class="bbfrminpt" value="<? echo "$fminfo[title]"; ?>" onfocus="if (this.value=='File Name'){ this.value = ''; }" onblur="if (this.value == ''){ this.value ='File Name'; }" /></div>

<div class="frm4"><textarea name="embed_code" id="embed_code" class="bbfrmtxtarea" onfocus="if (this.value=='Embed Code'){ this.value = ''; }" onblur="if (this.value == ''){ this.value ='Embed Code'; }"><? echo htmlspecialchars_decode($fminfo[embed_code]); ?></textarea></div>

<div class="frm3">
<div class="fl slct1">
<select id="basic" name="category">
<option value="Handbooks" <? if($cat=="1"){ echo "selected='selected'"; } ?> >Handbooks</option>
<option value="Guides" <? if($cat=="3"){ echo "selected='selected'"; } ?> >Guides</option>
<option value="Manuals" <? if($cat=="5"){ echo "selected='selected'"; } ?> >Manuals</option>
<option value="Other" <? if($cat=="6"){ echo "selected='selected'"; } ?> >Other</option>
</select>
</div>
<a href="javascript:;" onclick="delfile(<? echo "$fminfo[id]"; ?>);" class="inptgri" >DELETE</a>
<a href="javascript:nwpstkpt();" class="inptgri" >CANCEL</a>
<input type="submit" name="submit" id="submit" class="inptsbt" value="SAVE" action="javascript:npstgndr();" />
<div class="t"></div>
</div>

</div>
</form>

</div>

<?
}
}
?>
