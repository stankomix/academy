
<script src="/js/isotope.pkgd.min.js" type="text/javascript"></script>
<script src="/js/timecard.js" type="text/javascript"></script>
<script src="/js/bower/jquery-selectric/public/jquery.selectric.min.js" type="text/javascript"></script>
<link href="/css/selectric.css" rel="stylesheet" type="text/css" />

<div class="ort">

<div id="test"></div>

<div class="fl bbbslk">Time Sheet
	<?php
		if ( $is_admin_timecard )
		{
			echo '<br> For: '.$tc_user_name.'('.$tc_user_job.')';
		}
	?>			
</div>
	<div class="fr bbsaeds">

		<div class="timesheet_buttons">

			<?php

				if ( $canTurnInTimecard ):
			
			?>	

				<button href="javascript:;" onclick="showTurnInForm();" id="btnTurnInTimecard" class="rnk sae bbsae turnin_active wait-on-submit">
					Turn in Timecard
				</button>

			<?php
			  else:
			?>

				<button disabled class="rnk sae bbsae turnin_disabled" title="Cannot turn in timecard at this date">
					Turn in Timecard
				</button>

			<?php
			  endif;
			?>
		
			<a href="javascript:;" onclick="timeentry(<?php echo $missed; ?>);" class="rnk sae bbsae wait-on-submit">
				Add New Time
			</a>
		</div>
	</div>
<div class="t"></div>

<div class="usrstum">

<div class="nrml_users">
	<div class="hours-worked">
		Hours worked this pay period
		<div>
			<?php echo $hoursWorkedThisPayperiod ?>
		</div>
	</div>
</div>
<table cellpadding="0" cellspacing="0" width="100%" border="0" id="tcid">
<tr class="ilktd">
<td class="yta">Work Order</td>
<td class="ytb">Date</td>
<td class="ytb">Start Time</td>
<td class="ytb">End Time</td>
<td class="ytb">Updated</td>
</tr>

<?php

// Show any admin timecards the user has to approve

foreach ($admin_timecards AS $timecard ):?>
   	<tr>
		<td class="itd1" ><?php echo $timecard->workorder_id; ?></td>
		<td class="itd2" ><?php echo $timecard->date; ?></td>
		<td class="itd3" ><?php echo "{$timecard->start_hour}:{$timecard->start_min} {$timecard->start_pmam}"; ?></td>
		<td class="std"><?php echo "{$timecard->stop_hour}:{$timecard->stop_min} {$timecard->stop_pmam}"; ?></td>
		<td class="admin-timecard" data-request="<?php echo $timecard->id; ?>">
			Approve Time
		</td>
	</tr>
<?php endforeach; ?>

<?php
//if timecard does not have end time, highlight
foreach ( $timesheets AS $timecard ):
  if ( !$timecard->stop_hour ):
?>
    <tr class="hl_red" id="<?php echo $timecard->id; ?>" style="cursor:pointer;" >
<?php
  else:
?>
	<?php
	  // Timecards for same day and complete, highlight
	  if ($timecard->date == date('Y-m-d') && $timecard->stop_hour != NULL ):
	?>

    	<tr id="<?php echo $timecard->id; ?>" style="cursor:pointer;background-color:#76ca7c;" >

    <?php
	  // Timecards for same day and complete, highlight
	  elseif ($timecard->for != NULL ):
	?>

		<tr id="<?php echo $timecard->id; ?>" style="cursor:pointer;background-color:#ccc;" >

    <?php
	  else:
	?>
    
    	<tr id="<?php echo $timecard->id; ?>" style="cursor:pointer;" >

    <?php
	  endif;
	?>

<?php
  endif;
?>
<td class="itd1" ><?php echo $timecard->workorder_id; ?></td>
<td class="itd2" ><?php echo $timecard->date; ?></td>
<td class="itd3" ><?php echo "{$timecard->start_hour}:{$timecard->start_min} {$timecard->start_pmam}"; ?></td>
<td class="std"><?php echo "{$timecard->stop_hour}:{$timecard->stop_min} {$timecard->stop_pmam}"; ?></td>
<td style="font-size: -2em;" >
	<?php if ($timecard->driving_time): ?>

		<img src="/public/images/driving_wheel_icon.png" />

	<?php elseif ($timecard->lunch_time): ?>

		<img src="/public/images/lunch_icon.svg" />

	<?php else: ?>

		<?php echo date('H:i m.d.y' , strtotime($timecard->submit_time)); ?>
			
		<?php if ($timecard->overtime_reason != NULL): ?>

			<img src="/public/images/admin_overtime.png" />

		<?php endif; ?>

	<?php endif; ?>
</td>
</tr>
<?php endforeach;
?>
</table>
	<div class="pagi">
		<div id="pg-small">
			<h4>Pages</h4>
			<?php echo $pagination; ?>
		</div>
		<div id="pagination" class="pagination">
			<?php echo $pagination; ?>
		</div>
	</div>
</div>

</div>


</div>

