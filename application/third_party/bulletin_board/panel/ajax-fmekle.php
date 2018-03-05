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
$cat=intval($_REQUEST[cat]);

?>
<script src="js/dropzone.js" type="text/javascript"></script>
<link href="css/dropzone.css" rel="stylesheet" type="text/css" />

<script>
$(document).ready(function() {
$("#dsyupld").dropzone({url:"upload.php",sending:function(){$(".upldonce").css({display:"none"});},success:function(file,callback){$(".upldsnr").css({display:"table-cell"});$("#cllbckicn").html(callback);}});

$('select').selectric({disableOnMobile:false});

$(".tklmaln").css({width:$("body").width(),height:$("body").height()});
$(".tklmaln").click(function(){nwpstkpt();});

$("select[name='category']").change(function() {
var valne=$(this).val();
if(valne=="Videos"){
$(".frm2").css({display:"none"});
$(".frm4").css({display:"block"});
$("#embed_code").val("Embed Code");
}else if(valne=="Event Photos"){
$(".bosdv").html("");
fmpekle();
}else{
$(".frm2").css({display:"table"});
$(".frm4").css({display:"none"});
$("#embed_code").val("");
}
});

<?
if($cat=="2"){
?>
$(".frm2").css({display:"none"});
$(".frm4").css({display:"block"});
$("#embed_code").val("Embed Code");
<?
}elseif($cat=="4"){
?>
$(".bosdv").html("");
fmpekle();
<?
}
?>

fmeklegore();

});

$(window).resize(fmeklegore);

function fmeklegore(){
$(".bosdv,.tklmaln").css({width:"100%"});
$(".fmds").css({left:($(window).width()-$(".fmds").width())/2});
}

function nwpstkpt(){$(".bosdv").html("");}

function npstgndr()
{
$.ajax({
type: 'POST',
url :'ajax-fmekle-islem.php',
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
<div class="bslk">FILE UPLOAD</div>
<form method="post" name="bbform" id="bbform" action="javascript:npstgndr();" enctype="multipart/form-data" >
<input type="hidden" name="file_name" id="file_name" value="" />
<input type="hidden" name="file_type" id="file_type" value="" />
<input type="hidden" name="file_size" id="file_size" value="" />
<div class="fmaln">
<div class="frm1"><input type="text" name="title" id="title" class="bbfrminpt" value="File Name" onfocus="if (this.value=='File Name'){ this.value = ''; }" onblur="if (this.value == ''){ this.value ='File Name'; }" /></div>

<div class="frm2">
<div class="upldonce">
<div class="fmgriico1"><img src="images/fmgriico1.png" /></div>
<div class="yz1">Drag & Drop</div>
<div class="yz2">your files to Assets, or browse.</div>
<div class="yz3">BROWSE</div>
</div>
<div class="dropzone dsyupld" id="dsyupld" style="border:0px;"  ></div>
<div class="upldsnr">
<div class="testok"><img src="images/testok.png" /></div>
<div class="yz1">File Uploaded</div>
</div>
</div>

<div class="frm4"><textarea name="embed_code" id="embed_code" class="bbfrmtxtarea" onfocus="if (this.value=='Embed Code'){ this.value = ''; }" onblur="if (this.value == ''){ this.value ='Embed Code'; }"></textarea></div>


<div class="frm3">
<div class="fl slct1">
<select id="basic" name="category">
<option value="Handbooks" <? if($cat=="1"){ echo "selected='selected'"; } ?> >Handbooks</option>
<option value="Videos" <? if($cat=="2"){ echo "selected='selected'"; } ?> >Videos</option>
<option value="Guides" <? if($cat=="3"){ echo "selected='selected'"; } ?> >Guides</option>
<option value="Event Photos" <? if($cat=="4"){ echo "selected='selected'"; } ?> >Event Photos</option>
<option value="Manuals" <? if($cat=="5"){ echo "selected='selected'"; } ?> >Manuals</option>
<option value="Other" <? if($cat=="6"){ echo "selected='selected'"; } ?> >Other</option>
</select>
</div>
<a href="javascript:nwpstkpt();" class="inptgri" >CANCEL</a>
<input type="submit" name="submit" id="submit" class="inptsbt" value="SAVE" action="javascript:npstgndr();" />
<div class="t"></div>
</div>

</div>
</form>

</div>
<div id="cllbckicn"></div>
