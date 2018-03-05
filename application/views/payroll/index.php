<script src="/js/payroll.js" type="text/javascript"></script>

<div class="ort">

	<div id="test"></div>

	<div class="fl bbbslk">Pay Period</div>

	<?php
			
		if ( $hasPayrolls ):

	?>

		<div class="fr bbsaeds">

			<div class="timesheet_buttons">

				<button disabled class="payroll-num">
					# <?php echo $pay_period_number; ?>
				</button>

				<a href=<?php echo "/admin/payroll/export_timecards/".$pay_period_number; ?> class="rnk sae bbsae">
					Export Timecards
				</a>

				<a href=<?php echo "/admin/payroll/export/".$pay_period_number; ?> class="rnk sae bbsae">
					Export Payroll
				</a>

				<a href="/admin/drilldown" class="rnk sae bbsae">
					Timecard Drilldown
				</a>

			</div>
		</div>
		
		
		<div class="t"></div>

		<div class="usrstum">

			<table cellpadding="0" cellspacing="0" width="100%" border="0" id="tcid">
			<tr class="ilktd">
				<td class="yta">Name</td>
				<td class="ytb">Hours</td>
				<td class="ytb">OT Hours</td>
				<td class="ytb">Pay Period</td>
			</tr>
			<?php
			//if timecard does not have end time, highlight
			foreach ( $employees AS $employee ):
			?>

			 <tr>
				<td class="itd1 payt-name" ><?php echo $employee->employee; ?></td>
				<td class="itd2" ><?php echo $employee->hours_worked; ?></td>
				<td class="itd3" ><?php echo $employee->overtime_hours; ?></td>
				<td class="std"><?php echo $employee->pay_period_number; ?></td>
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

	<?php
	  else:
	?>
	
		<div class="t"></div>
			<div class="usrstum">
				<div class="no-payroll">
					<h2>No payroll data to display</h2>
					<hr>
					<a class="sae" href="/admin/payroll">View Current Payroll</a>
				</div>
			</div>
		</div>

	<?php
	  endif;
	?>


</div>
