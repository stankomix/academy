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

$random2=rand(100000,999999);
$rand =time();
$randomnumber="$random2$rand";

?>
<script type="text/javascript" src="js/jquery.uploadifive.min.js"></script>
<link rel="stylesheet" href="css/uploadifive.css" type="text/css" />
<script>
jQuery.browser = {};
(function () {
    jQuery.browser.msie = false;
    jQuery.browser.version = 0;
    if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
        jQuery.browser.msie = true;
        jQuery.browser.version = RegExp.$1;
    }
})();
$(document).ready(function() {
    $('#file_upload').uploadifive({
        'uploadScript' : 'upload_foto.php',
		'formData':{'aid': '<? echo "$randomnumber"; ?>'},
		'multi': true,
		'auto': true,
		'buttonText': 'Add File',
		'checkScript'  : 'check.php'
    });

$('select').selectric({disableOnMobile:false});

$(".tklmaln").css({width:$("body").width(),height:$("body").height()});
$(".tklmaln").click(function(){nwpstkpt();});

$("select[name='category']").change(function() {
var valne=$(this).val();

if(valne=="Event Photos"){
}else if(valne=="Handbooks"){
$(".bosdv").html("");
fmekle(1);
}else if(valne=="Videos"){
$(".bosdv").html("");
fmekle(2);
}else if(valne=="Guides"){
$(".bosdv").html("");
fmekle(3);
}else if(valne=="Manuals"){
$(".bosdv").html("");
fmpekle(5);
}else if(valne=="Other"){
$(".bosdv").html("");
fmekle(6);
}

});


fmpeklegore();

});

$(window).resize(fmpeklegore);

function fmpeklegore(){
$(".bosdv,.tklmaln").css({width:"100%"});
$(".fmds").css({left:($(window).width()-$(".fmds").width())/2});
}

function nwpstkpt(){$(".bosdv").html("");}

function npstgndr()
{
$.ajax({
type: 'POST',
url :'ajax-fmpekle-islem.php',
data: $('form#bbform').serialize(),
success: function(answer)
{
location.reload();
}
});
}
clearInterval(refreshId);
var refreshId = setInterval(function()
{
$('#firmafotolarigosterdiv').load('galerifotoajax.php?aid=<? echo "$randomnumber"; ?>');
}, 3000);
function kaldirgoster(gelen){
			if (document.getElementById('fotokaldirdiv'+gelen).style.display=="none") {
			document.getElementById('fotokaldirdiv'+gelen).style.display="";
			}
			else{
			document.getElementById('fotokaldirdiv'+gelen).style.display="none";	
			}
		}
</script>
<div class="tklmaln"></div>
<div class="fmds">
<div class="bslk">PHOTO ALBUM UPLOAD</div>
<form method="post" name="bbform" id="bbform" action="javascript:npstgndr();" enctype="multipart/form-data" >
<input type="hidden" name="randomnumber" id="randomnumber" value="<? echo "$randomnumber"; ?>" />
<div class="fmaln">
<div class="frm1"><input type="text" name="title" id="title" class="bbfrminpt" value="Album Name" onfocus="if (this.value=='Album Name'){ this.value = ''; }" onblur="if (this.value == ''){ this.value ='Album Name'; }" /></div>

<div class="frm5">
<div class="fl ajaxfmdudv" ><input id="file_upload" type="file" name="file_upload" /></div>
<div class="fr ajaxfmdgdv" id="firmafotolarigosterdiv">
<script>$('#firmafotolarigosterdiv').load('galerifotoajax.php?aid=<? echo "$randomnumber"; ?>');</script>
</div>
<div class="t"></div>
</div>


<div class="frm3">
<div class="fl slct1">
<select id="basic" name="category">
<option value="Handbooks" >Handbooks</option>
<option value="Videos" >Videos</option>
<option value="Guides" >Guides</option>
<option value="Event Photos" selected="selected" >Event Photos</option>
<option value="Manuals" >Manuals</option>
<option value="Other" >Other</option>
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
