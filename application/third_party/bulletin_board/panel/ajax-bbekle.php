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

$create_date = date('Y-m-d h:i:s A');

		$tarihirakamlaracevir=strtotime($create_date);
		$rakamlariistedigimtarihecevir=date("Y-n-j-h-i-s-A",$tarihirakamlaracevir);	
		$mesajtarihi = explode("-",$rakamlariistedigimtarihecevir);
        $messageyear = $mesajtarihi[0];
        $dogumaynumara = $mesajtarihi[1];
        $messageday = $mesajtarihi[2];
        $mesajhour = $mesajtarihi[3];
        $mesajminute = $mesajtarihi[4];
        $ampm = $mesajtarihi[6];
		$ayisimleri = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		$messagemonth = $ayisimleri[floor($dogumaynumara)];

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
$('select').selectric();
$(function() {
    $('#file_upload').uploadifive({
        'uploadScript' : 'upload_foto_bb.php',
		'formData':{'aid': '<? echo "$randomnumber"; ?>'},
		'multi': true,
		'auto': true,
		'buttonText': 'Add File',
		'checkScript'  : 'check.php'
    });
});
$(".tklmaln").css({width:$("body").width(),height:$("body").height()});
$(".tklmaln").click(function(){nwpstkpt();});

$('.bbfrmtxtarea').trumbowyg({
    btns: ['viewHTML','bold', 'italic', '|', 'link','|','btnGrp-justify'],
	fullscreenable: false
});

bbeklegore();

});

$(window).resize(bbeklegore);

function bbeklegore(){
$(".bosdv,.tklmaln").css({width:"100%"});
$(".bbeds").css({left:($(window).width()-$(".bbeds").width())/2});
}

function katdegistir(idne){
$("#category").val(idne);
if(idne==1){$(".frm3 .yz").text("News");}
else if(idne==2){$(".frm3 .yz").text("New Hires");}
else if(idne==3){$(".frm3 .yz").text("Birthday");}
else if(idne==4){$(".frm3 .yz").text("Event");}
$(".frm3 .scl").removeClass("scl").addClass("nrml");
$("#kt"+idne).removeClass("nrml").addClass("scl");
}
function nwpstkpt(){$(".bosdv").html("");}

function npstgndr()
{
$.ajax({
type: 'POST',
url :'ajax-bbekle-islem.php',
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
$('#firmafotolarigosterdiv').load('bb_fotoajax.php?aid=<? echo "$randomnumber"; ?>');
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
<div class="bbeds">
<div class="bslk">NEW POST</div>
<form method="post" name="bbform" id="bbform" action="javascript:npstgndr();" >
<input type="hidden" name="category" id="category" value="1" />
<input type="hidden" name="randomnumber" id="randomnumber" value="<? echo "$randomnumber"; ?>" />
<div class="bbfmaln">
<div class="frm1"><input type="text" name="title" id="title" class="bbfrminpt" value="Title" onfocus="if (this.value=='Title'){ this.value = ''; }" onblur="if (this.value == ''){ this.value ='Title'; }" /></div>
<div class="frm2"><textarea name="content" id="content" class="bbfrmtxtarea" onfocus="if (this.value=='Details...'){ this.value = ''; }" onblur="if (this.value == ''){ this.value ='Details...'; }">Details...</textarea></div>
<div class="frm6">
<div class="frm5">Photo Album</div>
<div class="fl ajaxbbdudv" ><input id="file_upload" type="file" name="file_upload" /></div>
<div class="fr ajaxbbdgdv" id="firmafotolarigosterdiv">
<script>$('#firmafotolarigosterdiv').load('bb_fotoajax.php?aid=<? echo "$randomnumber"; ?>');</script>
</div>
<div class="t"></div>
</div>
<div class="frm5">Date / Time:</div>
<div class="frm8">

<div class="fl slct1">
<select id="basic" name="month">
<option value="01" <? if($messagemonth=="01"){ echo "selected='selected'";}?>>January</option>
<option value="02" <? if($messagemonth=="02"){ echo "selected='selected'";}?>>February</option>
<option value="03" <? if($messagemonth=="03"){ echo "selected='selected'";}?>>March</option>
<option value="04" <? if($messagemonth=="04"){ echo "selected='selected'";}?>>April</option>
<option value="05" <? if($messagemonth=="05"){ echo "selected='selected'";}?>>May</option>
<option value="06" <? if($messagemonth=="06"){ echo "selected='selected'";}?>>June</option>
<option value="07" <? if($messagemonth=="07"){ echo "selected='selected'";}?>>July</option>
<option value="08" <? if($messagemonth=="08"){ echo "selected='selected'";}?>>August</option>
<option value="09" <? if($messagemonth=="09"){ echo "selected='selected'";}?>>September</option>
<option value="10" <? if($messagemonth=="10"){ echo "selected='selected'";}?>>October</option>
<option value="11" <? if($messagemonth=="11"){ echo "selected='selected'";}?>>November</option>
<option value="12" <? if($messagemonth=="12"){ echo "selected='selected'";}?>>December</option>
</select>
</div>
<div class="fl slct2">
<select id="basic" name="day">
<?
$songun="32";
for($r=1; $r<$songun; $r=$r+1) {
?>
<option value="<? echo"$r"; ?>" <? if($messageday=="$r"){ echo "selected='selected'";}?> ><? echo "$r"; ?></option>
<?}?>
</select>
</div>
<div class="fl slct3">
<select id="basic" name="year">
<?
$create_date=getdate();
$sonyil=$create_date['year'];
for($r=$sonyil; $r<$sonyil+4; $r=$r+1) {
?>
<option value="<? echo"$r"; ?>" <? if($messageyear=="$r"){ echo "selected='selected'";}?> ><? echo "$r"; ?></option>
<?}
?>
</select>
</div>

<div class="fr slct6">
<select id="basic" name="pmam">
<option value="PM" <? if($ampm=="PM"){ echo "selected='selected'";}?> >PM</option>
<option value="AM" <? if($ampm=="AM"){ echo "selected='selected'";}?> >AM</option>
</select>
</div>

<div class="fr slct5">
<select id="basic" name="minute">
<?
$songun="60";
for($r=0; $r<$songun; $r=$r+1) {
if($r<10){ $r="0$r";}
?>
<option value="<? echo"$r"; ?>" <? if($mesajminute=="$r"){ echo "selected='selected'";}?> ><? echo "$r"; ?></option>
<?}?>
</select>
</div>

<div class="fr slct4">
<select id="basic" name="hour">
<?
$songun="13";
for($r=1; $r<$songun; $r=$r+1) {
if($r<10){ $r="0$r";}
?>
<option value="<? echo"$r"; ?>" <? if($mesajhour=="$r"){ echo "selected='selected'";}?> ><? echo "$r"; ?></option>
<?}?>
</select>
</div>

<div class="t"></div>
</div>

<div class="frm5">Select Post Type:</div>
<div class="frm3"><div class="fl yz">News</div><a href="javascript:;" class="nrml icnlr" id="kt4" onclick="katdegistir('4');"><img src="images/bbico4.png" class="ico4" /></a><a href="javascript:;" class="nrml icnlr" id="kt3" onclick="katdegistir('3');"><img src="images/bbico3.png" class="ico3" /></a><a href="javascript:;" class="nrml icnlr" id="kt2" onclick="katdegistir('2');"><img src="images/bbico2.png" class="ico2" /></a><a href="javascript:;" class="scl icnlr" id="kt1" onclick="katdegistir('1');"><img src="images/bbico1.png" class="ico1" /></a></div>

<div class="frm4"><input type="submit" name="submit" id="submit" class="inptsbt" value="SEND" action="javascript:npstgndr();" /><a href="javascript:nwpstkpt();" class="inptgri" >CANCEL</a></div>

</div>
</form>

</div>
