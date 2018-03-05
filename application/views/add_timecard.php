<?php
$curTimeofday = date('A', $_SERVER['REQUEST_TIME']);
$curMin = date('i', $_SERVER['REQUEST_TIME']);
$curHour = date('h', $_SERVER['REQUEST_TIME']);

?>
<script src="/js/add_timecard.js"></script>

<div class="tklmaln"></div>
<div class="rndvds trndvds">
	<div class="bslk">Time Card</div>

	<form method="post" name="bbform" id="bbform" action="javascript:;" onsubmit="npstgndr()" >
		<div class="bbfmaln">
			<div class="frm1">
				<input type="text" name="workorder_id" id="workorder_id" class="bbfrminpt" value="Work Order" onfocus="if (this.value=='Work Order'){ this.value = ''; }" onblur="if (this.value == ''){ this.value ='Work Order'; }" />
			</div>

			<div class="frm1" id="overtimeReasonForm" style="display:none">
				<!-- <input type="text" name="overtime_reason" id="overtime_reason" class="bbfrminpt" value="Overtime Reason" onfocus="if (this.value=='Overtime Reason'){ this.value = ''; }" onblur="if (this.value == ''){ this.value ='Overtime Reason'; }"> -->
				<input type="text" name="overtime_reason" id="overtime_reason" class="bbfrminpt" value="" placeholder="Overtime Reason">
				<input type="hidden" name="add_driving_time" id="add_driving_time" value="" />
				<input type="hidden" name="add_lunch_time" id="add_lunch_time" value="" />
			</div>

			<div class="fl yzlr1">MONTH</div>
			<div class="fl yzlr2">DAY</div>
			<div class="fl yzlr3">YEAR</div>
			<div class="t"></div>

			<div class="fl slct1">
				<input type="hidden" value="<?php echo date("m"); ?>" name="ay">
				<?php echo date("F"); ?>
			</div>

			<div class="fl slct2">
				<input type="hidden" value="<?php echo date("d"); ?>" name="gun">
				<?php echo date("d"); ?>
			</div>

			<div class="fl slct3">
				<input type="hidden" value="<?php echo date("Y"); ?>" name="yil">
				<?php echo date("Y"); ?>
			</div>

			<div class="t"></div>
			<div class="yzlr4">START TIME</div>
			<div class="fl slct4">
				<input type="hidden" value="" name="timecard_hour" id="timecard_hour">
				<span id="timecard_hour_label"></span>
			</div>

			<div class="fl slct5">
				<input type="hidden" value="" name="timecard_min" id="timecard_min">
				<span id="timecard_min_label"></span>
			</div>

			<div class="fl slct6">
				<input type="hidden" value="" name="timecard_pmam" id="timecard_pmam">
				<span id="timecard_pmam_label"></span>
			</div>

			<div class="bzngl t"></div>
			<?php if ( $missed_reason ) :
			?>
			<div>
				<input type="hidden" value="<?php echo $missed_reason; ?>" name="missed_reason">
				Missed last timecard reason:	<?php echo $missed_reason; ?>
			</div>
			<?php endif;
			?>

			<div class="fr frm4">

				<input type="submit" name="submit" id="submit" class="inptsbt wait-on-submit" value="Submit" />
				<a href="javascript:nwpstkpt();" class="inptgri" >
					Cancel
				</a>
			</div>

			<div class="t"></div>
		</div>
	</form>
</div>
