	
<div class="ort edit-panel">
<div class="banner">
    <div class="panel panel-default">
		<div class="panel-heading">
			<h4>Add User</h4>
		</div>
        <div class="panel-body">

        	<form role="form" method="POST" enctype="multipart/form-data" onsubmit="matchPass();">

				<div class="form-group">
					<label for="name_surname">Fullname</label>
					<input type="text" class="form-control" name="name_surname" required>
				</div>

				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" class="form-control" name="email" required>
				</div>

				<div class="form-group">
					<label for="birthday">Birthday</label>
					<input type="date" class="form-control" name="birthday" style="width: 200px;" required>
				</div>

				<div class="form-group">
			    	<label for="status">Status</label>
				    <select class="form-control" name="status" style="width: 80%;">
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2">2</option>
					</select>
				</div>

				<div class="form-group">
					<label for="job">Job</label>
					<select class="form-control" name="employee_position_id" style="width: 80%;">
					<?php foreach($positions as $position): ?>
					
						<option value="<?php echo $position->id;?>">
						<?php echo $position->title;?>
						</option>
					
					<?php endforeach; ?>
					</select>
				</div>

				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" name="password" required>
				</div>

				<div class="edit-buttons">
				  	<button type="submit" class="btn btn-danger cfp-red">Add User</button>
				  	</a>
				</div>

			</form>
		<!-- End of Panel Body -->
		</div>
	</div>
<!-- End of Banner -->
</div>
</div>
<script type="text/javascript">

$(document).ready(function(){
    var count = 1;
    $("#add-photo").click(function(){
       $("#new-photos").append("<input type='file' class='file-up' name='pic"+(count++)+ "'>");
       $("#pics").val(count-1);
    });
});

</script>
