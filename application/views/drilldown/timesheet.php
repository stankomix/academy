<div class="ort">

	<div id="test"></div>

	<div class="fl bbbslk">Time Sheet for <?php echo $employee; ?></div>

	<div class="fr bbsaeds">

		<div class="timesheet_buttons">
			<a href="/admin/drilldown" class="rnk sae bbsae">
				View all employees
			</a>
		</div>
	</div>

	<div class="t"></div>

	<div class="usrstum">

		<div class="nrml_users">
			<div class="hours-worked">
				Hours worked this pay period
				<div>
					<?php echo $hoursWorkedThisPayperiod; ?>
				</div>
			</div>
		</div>
		<table cellpadding="0" cellspacing="0" width="100%" border="0" id="tcid">
			<tr class="ilktd">
				<td class="yta">
					<a href="<?php echo $base_url . '?sort=workorder_id'; if ($sort === 'workorder_id') { echo '&direction='; echo ($ascending) ? 'descending' : 'ascending'; } ?>" style="text-decoration: none; cursor: pointer;">
						Work Order
						<?php
							if ($sort != 'workorder_id') {
								echo '&darr;';
							} else {
								echo ($ascending) ? '&darr;' : '&uarr;';
							}
						?>
					</a>
				</td>
				<td class="ytb">
					<a href="<?php echo $base_url . '?sort=submit_time'; if ($sort === 'submit_time') { echo '&direction='; echo ($ascending) ? 'descending' : 'ascending'; } ?>" style="text-decoration: none; cursor: pointer;">
						Date
						<?php
							if ($sort != 'submit_time') {
								echo '&darr;';
							} else {
								echo ($ascending) ? '&darr;' : '&uarr;';
							}
						?>
					</a>
				</td>
				<td class="ytb">
					Start Time
				</td>
				<td class="ytb">
					End Time
				</td>
				<td class="ytb">
					Hours Worked
				</td>
			</tr>
			<?php
			//if timecard does not have end time, highlight
			foreach ( $timesheets AS $timecard ):
			  if ( !$timecard->stop_hour ):
			?>
			    <tr class="hl_red" id="<?php echo $timecard->id; ?>">
			<?php
			  else:
			?>
			    <tr id="<?php echo $timecard->id; ?>">
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

						<?php echo hours_worked($timecard); ?>

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
