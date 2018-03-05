
<div class="ort edit-panel">
<div class="banner">
    <div class="panel panel-default">
		<div class="panel-heading">
			<h4>
				Edit User #<?php echo $user->id; ?>
				&nbsp&nbsp - <a href="/admin/users">Back to Users</a>
			</h4>
		</div>
        <div class="panel-body">

        	<form role="form" method="POST">

				<div class="form-group">
					<label for="name_surname">Fullname</label>
					<input type="text" class="form-control" name="name_surname"
					value="<?php echo $user->name_surname; ?>" required>
				</div>

				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" class="form-control" name="email"
					value="<?php echo $user->email; ?>" required>
				</div>

				<div class="form-group">
					<label for="birthday">Birthday</label>
					<input type="date" class="form-control" name="birthday" style="width: 200px;"
					value="<?php echo $user->birthday; ?>" required>
				</div>

				<div class="form-group">
			    	<label for="status">Status</label>
				    <select class="form-control" name="status" style="width: 80%;">
						<option value="0"
							<?php if ($user->status == 0){ echo 'selected';} ?>
							>0
						</option>
						<option value="1"
							<?php if ($user->status == 1){ echo 'selected';} ?>
							>1
						</option>
						<option value="2"
							<?php if ($user->status == 2){ echo 'selected';} ?>
							>2
						</option>
					</select>
				</div>

				<div class="form-group">
					<label for="job">Job</label>
					<select class="form-control" name="employee_position_id" style="width: 80%;">
					<?php foreach($positions as $position): ?>
					
						<option value="<?php echo $position->id;?>"
						<?php
							if ($position->id == $user->employee_position_id)
							{ 
								echo 'selected';
							}
						?>>
						<?php echo $position->title;?>
						</option>
					
					<?php endforeach; ?>
					</select>
				</div>

				<div class="form-group">
					<label for="password">Change Password</label>
					<input type="password" class="form-control" name="password" id="pwd1">
				</div>

				<div class="edit-buttons">
				  	<button type="submit" class="btn btn-primary">Update</button>
				  	<a href="/admin/users/<?php echo $user->id; ?>/delete">	
				  		<button type="button" class="btn btn-danger">Delete</button>
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
