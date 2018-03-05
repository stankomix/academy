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
url :'ajax-userekle-islem.php',
data: $('form#bbform').serialize(),
success: function(answer)
{
location.reload();
}
});
}
</script>
<div class="tklmaln"></div>
<div class="usrds">
<div class="bslk">NEW USER</div>
<form method="post" name="bbform" id="bbform" action="javascript:npstgndr();" >
<input type="hidden" name="category" id="category" value="1" />
<div class="bbfmaln">
<div class="yz">Full Name</Div>
<div class="frm1"><input type="text" name="name_surname" id="name_surname" class="bbfrminpt" value="Your Full Name" onfocus="if (this.value=='Your Full Name'){ this.value = ''; }" onblur="if (this.value == ''){ this.value ='Your Full Name'; }" /></div>
<div class="yz">E-mail Adress</Div>
<div class="frm1"><input type="text" name="email" id="email" class="bbfrminpt" value="E-Mail Address" onfocus="if (this.value=='E-Mail Address'){ this.value = ''; }" onblur="if (this.value == ''){ this.value ='E-Mail Address'; }" /></div>
<div class="yz">Password</Div>
<div class="frm1"><input type="text" name="password" id="password" class="bbfrminpt" value="Password" onfocus="if (this.value=='Password'){ this.value = ''; }" onblur="if (this.value == ''){ this.value ='Password'; }" /></div>
<div class="yz">Job Title</Div>
<div class="frm1"><input type="text" name="job" id="job" class="bbfrminpt" value="Job Title" onfocus="if (this.value=='Job Title'){ this.value = ''; }" onblur="if (this.value == ''){ this.value ='Job Title'; }" /></div>
<div class="frm2">Date of birth</div>
<div class="frm3">

<div class="fl slct1">
<select id="basic" name="month">
<option value="01">January</option>
<option value="02">February</option>
<option value="03">March</option>
<option value="04">April</option>
<option value="05">May</option>
<option value="06">June</option>
<option value="07">July</option>
<option value="08">August</option>
<option value="09">September</option>
<option value="10">October</option>
<option value="11">November</option>
<option value="12">December</option>
</select>
</div>
<div class="fl slct2">
<select id="basic" name="day">
<?
$songun="32";
for($r=1; $r<$songun; $r=$r+1) {
?>
<option value="<? echo"$r"; ?>"><? echo "$r"; ?></option>
<?}?>
</select>
</div>
<div class="fl slct3">
<select id="basic" name="year">
<?
$tarih=getdate();
$sonyil=$tarih['year'];
for($r=$sonyil-15; $r>1919; $r=$r-1) {
?>
<option value="<? echo"$r"; ?>"><? echo "$r"; ?></option>
<?}
?>
</select>
</div>
<div class="t"></div>

</div>
<div class="frm4"><input type="submit" name="submit" id="submit" class="inptsbt" value="SAVE" action="javascript:npstgndr();" /><a href="javascript:nwpstkpt();" class="inptgri" >CANCEL</a></div>

</div>
</form>

</div>
