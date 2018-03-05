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
$bb_id=intval($_REQUEST[bb_id]);
$usersql=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id='$bb_id' order by id asc"));
if($usersql[id]!=""){
if($t=="delete"){
$bbeditsql = "UPDATE users SET status='2' WHERE id='$usersql[id]'";
mysql_query($bbeditsql);
$bb_data = "select * from test_answers where user_id='$usersql[id]' order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$delete = "DELETE from test_answers where id='$bb[id]'";
mysql_query($delete);
}

$bb_data = "select * from test_offline where user_id='$usersql[id]' order by id desc";
$bb_sorgu = mysql_query($bb_data);
while ($bb = mysql_fetch_assoc($bb_sorgu)){
$delete = "DELETE from test_offline where id='$bb[id]'";
mysql_query($delete);
}

}elseif($t=="edit"){
$birthdayb = explode("-",$usersql[birthday]);
$birthyear="$birthdayb[0]";
$birthmonth="$birthdayb[1]";
$birth_day="$birthdayb[2]";
?>
<script>
$(document).ready(function() {
$('select').selectric();

$(".tklmaln").css({width:$("body").width(),height:$("body").height()});
$(".tklmaln").click(function(){nwpstkpt();});
userdzngore();

});

$(window).resize(userdzngore);

function userdzngore(){
$(".bosdv,.tklmaln").css({width:"100%"});
$(".usrds").css({left:($(window).width()-$(".usrds").width())/2});
}

function nwpstkpt(){$(".bosdv").html("");}

function npstgndr()
{
$.ajax({
type: 'POST',
url :'ajax-userduzenle-islem.php',
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
<div class="bslk">EDIT USER</div>
<form method="post" name="bbform" id="bbform" action="javascript:npstgndr();" >
<input type="hidden" name="bb_id" id="bb_id" value="<? echo "$bb_id"; ?>" />
<input type="hidden" name="category" id="category" value="1" />
<div class="bbfmaln">
<div class="yz">Full Name</Div>
<div class="frm1"><input type="text" name="name_surname" id="name_surname" class="bbfrminpt" value="<? echo "$usersql[name_surname]"; ?>" onfocus="if (this.value=='Your Full Name'){ this.value = ''; }" onblur="if (this.value == ''){ this.value ='Your Full Name'; }" /></div>
<div class="yz">E-mail Adress</Div>
<div class="frm1"><input type="text" name="email" id="email" class="bbfrminpt" value="<? echo "$usersql[email]"; ?>" onfocus="if (this.value=='E-Mail Address'){ this.value = ''; }" onblur="if (this.value == ''){ this.value ='E-Mail Address'; }" /></div>
<div class="yz">Password</Div>
<div class="frm1"><input type="text" name="password" id="password" class="bbfrminpt" value="<? echo "$usersql[password]"; ?>" onfocus="if (this.value=='Password'){ this.value = ''; }" onblur="if (this.value == ''){ this.value ='Password'; }" /></div>
<div class="yz">Job Title</Div>
<div class="frm1"><input type="text" name="job" id="job" class="bbfrminpt" value="<? echo "$usersql[job]"; ?>" onfocus="if (this.value=='Job Title'){ this.value = ''; }" onblur="if (this.value == ''){ this.value ='Job Title'; }" /></div>
<div class="frm2">Date of birth</div>
<div class="frm3">
<div class="fl slct1">
<select id="basic" name="month">
<option value="01" <? if($birthmonth=="01"){echo "selected='selected'";}?> >January</option>
<option value="02" <? if($birthmonth=="02"){echo "selected='selected'";}?> >February</option>
<option value="03" <? if($birthmonth=="03"){echo "selected='selected'";}?> >March</option>
<option value="04" <? if($birthmonth=="04"){echo "selected='selected'";}?> >April</option>
<option value="05" <? if($birthmonth=="05"){echo "selected='selected'";}?> >May</option>
<option value="06" <? if($birthmonth=="06"){echo "selected='selected'";}?> >June</option>
<option value="07" <? if($birthmonth=="07"){echo "selected='selected'";}?> >July</option>
<option value="08" <? if($birthmonth=="08"){echo "selected='selected'";}?> >August</option>
<option value="09" <? if($birthmonth=="09"){echo "selected='selected'";}?> >September</option>
<option value="10" <? if($birthmonth=="10"){echo "selected='selected'";}?> >October</option>
<option value="11" <? if($birthmonth=="11"){echo "selected='selected'";}?> >November</option>
<option value="12" <? if($birthmonth=="12"){echo "selected='selected'";}?> >December</option>
</select>
</div>
<div class="fl slct2">
<select id="basic" name="day">
<?
$songun="32";
for($r=1; $r<$songun; $r=$r+1) {
?>
<option value="<? echo"$r"; ?>"  <? if($birth_day=="$r"){echo "selected='selected'";}?> ><? echo "$r"; ?></option>
<?}?>
</select>
</div>
<div class="fl slct3">
<select id="basic" name="year">
<?
$create_date=getdate();
$sonyil=$create_date['year'];
for($r=$sonyil-7; $r>1949; $r=$r-1) {
?>
<option value="<? echo"$r"; ?>" <? if($birthyear=="$r"){echo "selected='selected'";}?> ><? echo "$r"; ?></option>
<?}
?>
</select>
</div>
<div class="t"></div>

</div>
<div class="frm4"><input type="submit" name="submit" id="submit" class="inptsbt" value="SAVE" action="javascript:npstgndr();" /><a href="javascript:nwpstkpt();" class="inptgri" >CANCEL</a><a href="javascript:bbdelete2('<? echo "$usersql[id]"; ?>');" class="inptgridlt" >DELETE USER</a></div>
</div>
</form>

</div>
<?
}
}
?>