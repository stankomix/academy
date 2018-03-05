
<div class="ort edit-panel">
<div class="banner">
    <div class="panel panel-default">
		<div class="panel-heading">
			<h4>
				Give admin privileges to User #<?php echo $user->id; ?>
				&nbsp&nbsp - <a href="/admin/users">Back to Users</a>
			</h4>
		</div>
        <div class="panel-body">

        	<form role="form" method="POST" enctype="multipart/form-data" onsubmit="matchPass();">

				<div class="form-group">
					<label for="name_surname">Fullname</label>
					<p><?php echo $user->name_surname; ?></p>
				</div>

				<div class="form-group">
					<label for="email">Email</label>
					<p><?php echo $user->email; ?></p>
				</div>

				<div class="form-group">
					<label for="birthday">Birthday</label>
					<p><?php echo $user->birthday; ?></p>
				</div>

				<div class="form-group">
			    	<label for="status">Status</label>
				    <p><?php echo $user->status; ?></p>
				</div>

				<div class="form-group">
					<label for="job">Job</label>
					<p><?php echo $user->job; ?></p>
				</div>

				<div class="edit-buttons">
					<h4>Are you sure you want grant admin permissions to this user</h4>
				  	<button type="submit" class="btn btn-success">Make Admin</button>
				  	<a href="/admin/users/add">	
				  		<button type="button" class="btn btn-primary">No, Back to users</button>
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
