<div class="ort">
	<div class="bbbslk">Choose user's timecards to view</div>
	<div class="row user-heading">
		<div class="col-md-1"></div>
		<div class="col-md-4 col-sm-4">Name</div>
		<div class="col-md-3 col-sm-3">Email</div>
		<div class="col-md-3 col-sm-3">Job</div>
	</div>

<?php foreach($users as $user): ?>

	<div id="<?php echo $user->id; ?>"
	class="row user-row"
	style="<?php
				if (in_array($user->id, $open_users) ){
					echo 'background-color: #b21f24;';
				}
			?>cursor: pointer;">
		<div class="col-md-4 col-sm-4 large-text"><?php echo $user->id;?><?php echo $user->name_surname; ?></div>
		<div class="col-md-4 col-sm-3"><?php echo $user->email; ?></div>
		<div class="col-md-4 col-sm-3"><?php echo $user->job; ?></div>
	</div>

<?php endforeach; ?>

</div>
<script>
	$( ".user-row" ).click(function(){
		var id = $( this ).attr('id');
		window.location.href = "/admin/timecards/"+id	;
	});
</script>
