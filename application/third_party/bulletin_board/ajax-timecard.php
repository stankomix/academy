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

$curTimeofday = date('A', $_SERVER['REQUEST_TIME']);
$curHour = date('h', $_SERVER['REQUEST_TIME']);

//must be called inside html select tags
//returns cur month selected
function echosMonth($curSelected = true)
{
  $thismonth = date("m");

  $i = 1;
  //start month jan
  $month = date("m", strtotime("january"));
  $month_name = date('F', strtotime("january"));
  $strmonth = strtotime("january");
  while($i <= 12)
  {
      if ( $month == $thismonth )    
        echo '<option value="'. $month . '" selected>'. $month_name .'</option>';
      else
        echo '<option value="'. $month . '">'.$month_name.'</option>';

      $strmonth = strtotime('+1 month', $strmonth);
      $month = date("m", $strmonth);
      $month_name = date('F', $strmonth);
      $i++;
  }
}

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
  if ( isNumeric($("#workorder_id").val()) == false )
  {
    alert('work order must be a number');
    return;
  }

$.ajax({
type: 'POST',
url :'ajax-timecard-process.php',
data: $('form#bbform').serialize(),
success: function(answer)
{
location.reload();
}
});
}

function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
</script>
<div class="tklmaln"></div>
<div class="rndvds trndvds">
<div class="bslk">Time Card</div>
<form method="post" name="bbform" id="bbform" action="javascript:npstgndr();" >
<div class="bbfmaln">

<div class="frm1"><input type="text" name="workorder_id" id="workorder_id" class="bbfrminpt" value="Work Order" onfocus="if (this.value=='Work Order'){ this.value = ''; }" onblur="if (this.value == ''){ this.value ='Work Order'; }" /></div>

<div class="fl yzlr1">MONTH</div>
<div class="fl yzlr2">DAY</div>
<div class="fl yzlr3">YEAR</div>
<div class="t"></div>

<div class="fl slct1">
<select id="basic" name="ay">

<?php echosMonth(); ?>

</select>
</div>
<div class="fl slct2">
<select id="basic" name="gun">
<?
$songun="32";
$today = date ("d");
for($r=1; $r<$songun; $r=$r+1) {
  if ( $r == $today ):
?>
    <option value="<? echo"$r"; ?>" selected><? echo "$r"; ?></option>
<?php
  else:
?>
    <option value="<? echo"$r"; ?>"><? echo "$r"; ?></option>
<?php
  endif;
}
?>
</select>
</div>
<div class="fl slct3">
<select id="basic" name="yil">
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
<div class="yzlr4">START TIME</div>
<div class="fl slct4">
<select id="basic" name="start_hour">
<?
$songun="13";
for($r=1; $r<$songun; $r=$r+1):
 if($r<10) $r="0$r";

 if ( $curHour == $r ):
?>
    <option value="<? echo"$r"; ?>" selected><? echo "$r"; ?></option>
<?php
 else:
?>
    <option value="<? echo"$r"; ?>"><? echo "$r"; ?></option>
<?php
 endif;
endfor;
?>

</select>
</div>
<div class="fl slct5">
<select id="basic" name="start_min">
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
<select id="basic" name="start_pmam">

<?php
 if ( $curTimeofday == 'PM' ):
?>
   <option value="PM" selected>PM</option>
   <option value="AM">AM</option>
<?php
 else:
?>
   <option value="PM">PM</option>
   <option value="AM" selected>AM</option>
<?php
 endif;
?>

</select>
</div>
<div class="t"></div>
<div class="yzlr4">END TIME</div>
<div class="fl slct4">
<select id="basic" name="stop_hour">
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
<select id="basic" name="stop_min">
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
<select id="basic" name="stop_pmam">
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
