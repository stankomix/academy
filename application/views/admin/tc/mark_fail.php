<div class="ort edit-panel">
<div class="banner">
    <div class="panel panel-default">
		<div class="panel-heading">
			<h4>
				Mark timecard as overtime <?php echo $timecard->id; ?>
				&nbsp&nbsp - <a href="/admin/timecard">Back to Timecards</a>
			</h4>
		</div>
        <div class="panel-body">
        	
        	<form role="form" method="POST">

        		<div class="alert alert-danger">
        			Timecard is already marked as overtime
        		</div>

				<div class="form-group">
					<label>Workorder Id</label>
					<p><?php echo $timecard->workorder_id; ?></p>
				</div>

				<div class="form-group">
					<label>Date</label>
					<p><?php echo $timecard->date; ?></p>
				</div>

				<div class="form-group">
					<label>Start time</label>
					<p><?php echo "{$timecard->start_hour}:{$timecard->start_min} {$timecard->start_pmam}"; ?></p>
				</div>
				
				<div class="form-group">
					<label>End time</label>
					<p><?php echo "{$timecard->stop_hour}:{$timecard->stop_min} {$timecard->stop_pmam}"; ?></p>
				</div>

				<div class="form-group">
					<label>Updated at</label>
				<?php if ($timecard->driving_time): ?>

					<p><img src="/public/images/driving_wheel_icon.png" /></p>

				<?php elseif ($timecard->lunch_time): ?>

					<p><img src="/public/images/lunch_icon.svg" /></p>

				<?php else: ?>

					<p><?php echo date('H:i m.d.y' , strtotime($timecard->submit_time)); ?></p>

				<?php endif; ?>
				</div>

				<div class="form-group">
					<label>Overtime Reason</label>
					<p><?php echo $timecard->overtime_reason; ?></p>
				</div>

			</form>
		<!-- End of Panel Body -->
		</div>
	</div>
<!-- End of Banner -->
</div>
</div>