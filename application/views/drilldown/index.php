<script src="/js/drilldown.js" type="text/javascript"></script>

<div class="ort">

	<div id="test"></div>

	<div class="fl bbbslk">Employees</div>

	<?php
			
		if ( count($employees) ):

	?>

		<div class="usrstum">

			<table cellpadding="0" cellspacing="0" width="100%" border="0" id="tcid">
			<tr class="ilktd">
				<td class="yta">
					<a href="/admin/drilldown/all/?sort=name_surname<?php if ($sort == 'name_surname') { echo '&direction='; echo ($ascending) ? 'descending' : 'ascending'; } ?>" style="text-decoration: none; cursor: pointer;">
						Name
						<?php
							if ($sort != 'name_surname') {
								echo '&darr;';
							} else {
								echo ($ascending) ? '&darr;' : '&uarr;';
							}
						?>
					</a>
				</td>
				<td class="ytb">
					<a href="/admin/drilldown/all/?sort=job<?php if ($sort == 'job') { echo '&direction='; echo ($ascending) ? 'descending' : 'ascending'; } ?>" style="text-decoration: none; cursor: pointer;">
						Job
						<?php
							if ($sort != 'job') {
								echo '&darr;';
							} else {
								echo ($ascending) ? '&darr;' : '&uarr;';
							}
						?>
					</a>
				</td>
				<td class="ytb">Email</td>
				<td class="ytb">&nbsp;</td>
			</tr>
			<?php

			foreach ( $employees AS $employee ):
			?>

			 <tr onclick="showEmployee(<?php echo $employee->id; ?>)" style="cursor: pointer;">
				<td class="itd1 payt-name" ><?php echo $employee->name_surname; ?></td>
				<td class="itd2"><?php echo $employee->job; ?></td>
				<td class="itd3"><?php echo $employee->email; ?></td>
				<td class="std"></td>
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
					<h2>No drilldown to display</h2>
					<hr>
					<a class="sae" href="/admin/drilldown">View Current Drilldown</a>
				</div>
			</div>
		</div>

	<?php
	  endif;
	?>


</div>
