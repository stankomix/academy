<div class="ort">
	<div class="bbbslk">Choose User to give admin privileges</div>
	<div class="row user-heading">
		<div class="col-md-1"></div>
		<div class="col-md-3 col-sm-4">Name</div>
		<div class="col-md-3 col-sm-3">Email</div>
		<div class="col-md-3 col-sm-3">Job</div>
		<div class="col-md-2 col-sm-2">Birthday</div>
	</div>

<?php foreach($users as $user): ?>

	<div id="<?php echo $user->id; ?>" class="row user-row"
	style="<?php
				if ($user->status == 0) {
					echo 'background-color: #ddd;';
				} elseif ($user->status == 2){
					echo 'background-color: rgb(178, 31, 36);';
				}
			?>cursor: pointer;">
		<div class="col-md-4 col-sm-4 large-text"><?php echo $user->name_surname; ?></div>
		<div class="col-md-3 col-sm-3"><?php echo $user->email; ?></div>
		<div class="col-md-3 col-sm-3"><?php echo $user->job; ?></div>
		<div class="col-md-2 col-sm-2"><?php echo $user->birthday; ?></div>
	</div>

<?php endforeach; ?>

</div>
<script>
	$( ".user-row" ).click(function(){
		var id = $( this ).attr('id');
		window.location.href = "/admin/admins/add/"+id;
	});
</script>
