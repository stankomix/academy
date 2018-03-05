<?
session_start();
ob_start();
include ("mysqlbaglanti/baglan.php");
include ("guvenlik.php");
header("Cache-Control: no-cache");
header("Content-Type:text/html;charset=utf-8");
function hcevir($sData) { $out = ""; for ($i = 0; $i<strlen($sData);$i++) { $ch1= ord($sData{$i}); if($ch1==195 OR $ch1==196 OR $ch1==197) { $ch2=ord($sData{$i+1}); $ch="$ch1$ch2"; $bak=1;
switch($ch) { case "196159": $out .= "ğ";break; case "196158": $out .= "Ğ";break; case "196177": $out .= "ı";break; case "196176": $out .= "İ";break; case "195167": $out .= "ç";break; case "195135": $out .= "Ç";break; case "195188": $out .= "ü"; break; case "195156": $out .= "Ü"; break; case "195182": $out .= "ö"; break; case "195150": $out .= "Ö"; break; case "197158": $out .= "Ş"; break; case "197159": $out .= "ş"; break; } continue; } else if($bak==1) { $bak=0; continue; } else $out .= chr($ch1); }
return $out; 
}
$test_id=intval($_REQUEST[id]);
$testinfo=mysql_fetch_array(mysql_query("SELECT * FROM tests WHERE id='$test_id' and status='1' and test_type='Offline' order by id asc"));
if($testinfo[id]==""){?><script>location.href = "tests.php";</script><?exit();}
$testcontrol=mysql_fetch_array(mysql_query("SELECT * FROM test_offline WHERE user_id='$uyene[id]' and test_id='$testinfo[id]' and status='0' order by id asc"));
if($testcontrol[id]!=""){?><script>location.href = "tests.php";</script><?exit();}
?>
<script>
$(document).ready(function() {
$('select').selectric();

$(".tklmaln").css({width:$("body").width(),height:$("body").height()});
$(".tklmaln").click(function(){nwpstkpt();});
embedegore();

});
$(window).resize(embedegore);

function embedegore(){
$(".bosdv,.tklmaln").css({width:"100%"});
$(".rndvds").css({left:($(window).width()-$(".rndvds").width())/2});
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
<div class="bslk">Appointment</div>
<form method="post" name="bbform" id="bbform" action="javascript:npstgndr();" >
<input type="hidden" name="test_id" id="test_id" value="<? echo "$testinfo[id]"; ?>" />
<div class="bbfmaln">

<div class="fl yzlr1">MONTH</div>
<div class="fl yzlr2">DAY</div>
<div class="fl yzlr3">YEAR</div>
<div class="t"></div>

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
$create_date=getdate();
$sonyil=$create_date['year'];
for($r=$sonyil; $r<$sonyil+4; $r=$r+1) {
?>
<option value="<? echo"$r"; ?>"><? echo "$r"; ?></option>
<?}
?>
</select>
</div>
<div class="t"></div>

<div class="yzlr4">TIME</div>
<div class="fl slct4">
<select id="basic" name="hour">
<?
$songun="13";
for($r=1; $r<$songun; $r=$r+1) {
if($r<10){ $r="0$r";}
?>
<option value="<? echo"$r"; ?>"><? echo "$r"; ?></option>
<?}?>
</select>
</div>
<div class="fl slct5">
<select id="basic" name="minute">
<?
$songun="60";
for($r=0; $r<$songun; $r=$r+1) {
if($r<10){ $r="0$r";}
?>
<option value="<? echo"$r"; ?>"><? echo "$r"; ?></option>
<?}?>
</select>
</div>
<div class="fl slct6">
<select id="basic" name="pmam">
<option value="PM">PM</option>
<option value="AM">AM</option>
</select>
</div>
<div class="bzngl t"></div>
<div class="fr frm4"><input type="submit" name="submit" id="submit" class="inptsbt" value="Send" action="javascript:npstgndr();" /><a href="javascript:nwpstkpt();" class="inptgri" >Cancel</a></div>

<div class="t"></div>

</div>
</form>

</div>
