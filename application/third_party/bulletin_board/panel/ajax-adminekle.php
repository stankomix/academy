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
?>
<script>
$(document).ready(function() {
$('select').selectric();

$(".tklmaln").css({width:$("body").width(),height:$("body").height()});
$(".tklmaln").click(function(){nwpstkpt();});
usereklegore();

});

$(window).resize(usereklegore);

function usereklegore(){
$(".bosdv,.tklmaln").css({width:"100%"});
$(".usrds").css({left:($(window).width()-$(".usrds").width())/2});
}

function nwpstkpt(){$(".bosdv").html("");}

function npstgndr()
{
$.ajax({
type: 'POST',
url :'ajax-adminekle-islem.php',
data: $('form#bbform').serialize(),
success: function(answer)
{
location.reload();
}
});
}
</script>
<div class="tklmaln"></div>
<div class="adminds">
<div class="bslk">NEW ADMIN</div>
<form method="post" name="bbform" id="bbform" action="javascript:npstgndr();" >
<input type="hidden" name="category" id="category" value="1" />
<div class="bbfmaln">
<div class="yz">E-mail Adress</Div>
<div class="frm1"><input type="email" name="email" id="email" class="bbfrminpt" value="E-Mail Address" onfocus="if (this.value=='E-Mail Address'){ this.value = ''; }" onblur="if (this.value == ''){ this.value ='E-Mail Address'; }" /></div>
<div class="yz">Password</Div>
<div class="frm1"><input type="text" name="password" id="password" class="bbfrminpt" value="Password" onfocus="if (this.value=='Password'){ this.value = ''; }" onblur="if (this.value == ''){ this.value ='Password'; }" /></div>

<div class="frm4"><input type="submit" name="submit" id="submit" class="inptsbt" value="SAVE" action="javascript:npstgndr();" /><a href="javascript:nwpstkpt();" class="inptgri" >CANCEL</a></div>

</div>
</form>

</div>
