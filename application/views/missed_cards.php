<div class="ort">
	<div class="bbbslk">Users</div>
	<div class="row user-heading">
		<div class="col-md-1"></div>
		<div class="col-md-3 col-sm-4">Date</div>
		<div class="col-md-3 col-sm-4">Reason</div>
	</div>

	<form method="post" action="/timecard/add_missed_cards">

		<div class="row user-row" style="border-bottom: 2px #000 solid;">
			<div class="col-md-4 col-sm-4 large-text">
				If one reason throughout
			</div>
			<div class="col-md-3 col-sm-3">
			    <select class="form-control" id="binge-reason" style="width: 80%;">
					<option>Vacation</option>
					<option>Holiday</option>
					<option>Sick</option>
					<option>Paid Time Off</option>
					<option>No Work Assigned</option>
					<option>Weekend</option>
				</select>
			</div>
		</div>

		<hr>

		<?php foreach($days as $day): ?>

			<div class="row user-row">
				<div class="col-md-4 col-sm-4 large-text">
					<?php echo $day['of_the_week'].' '.$day['date'];?>					
				</div>
				<div class="col-md-3 col-sm-3">
				    <select class="form-control" name="<?php echo $day['date'];?>" style="width: 80%;">
						<option>Vacation</option>
						<option>Holiday</option>
						<option>Sick</option>
						<option>Paid Time Off</option>
						<option>No Work Assigned</option>
						<option>Weekend</option>
					</select>
				</div>
			</div>

		<?php endforeach; ?>

		<button type="submit" class="rnk sae">Submit</button>
	
	</form>

</div>
<script>

	$( "#binge-reason" ).change(function() {
		$( "#binge-reason option:selected" ).each(function() {
			
			// give all the missed time cards one reason
			reason = $( this ).val();
	     	$('select').val(reason);
     	
     	});
	});

</script>