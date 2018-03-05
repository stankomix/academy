
<div class="ort edit-panel">
<div class="banner">
    <div class="panel panel-default">
		<div class="panel-heading">
			<h4>Remove Admin Privileges</h4>
		</div>
        <div class="panel-body">
        <!--if ( in_array('bb', $user_tiles)-->
        	<form role="form" method="POST" enctype="multipart/form-data">

 				<div class="form-group">
			    	<label>Name</label>
				    <h4><?php echo $admin->name_surname; ?></h4>
				</div>

				<div class="form-group">
			    	<label>Status</label>
				    <p><?php echo $admin->status; ?></p>
				</div>

				<div class="form-group">
			    	<label>Email</label>
				    <p><?php echo $admin->email; ?></p>
				</div>

			  	<div class="edit-buttons">
			  		<h4>Are you sure you want to remove admin privileges for this user?</h4>
				  	<button type="submit" class="btn btn-danger">Remove</button>
				  	<a href="/admin/admins/<?php echo $admin->user_id; ?>/edit">	
				  		<button type="button" class="btn btn-primary">No, Back to edit</button>
				  	</a>
				</div>

			</form>
		<!-- End of Panel Body -->
		</div>
	</div>
<!-- End of Banner -->
</div>
</div>
