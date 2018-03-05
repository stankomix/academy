
<div class="ort edit-panel">
<div class="banner">
    <div class="panel panel-default">
		<div class="panel-heading">
			<h4>
				Edit Privileges - <?php echo $admin->name_surname; ?>
				- <a href="/admin/admins">Back to admins</a>
			</h4>
		</div>
        <div class="panel-body medium-text">
        <!--if ( in_array('bb', $user_tiles)-->
        	<form role="form" method="POST" enctype="multipart/form-data">

        		<div class="form-group">
			    	<label for="status">Status</label>
				    <select class="form-control" name="status" style="width: 80%;">
						<option value="1"
							<?php if ($admin->status == 1){ echo 'selected';} ?>
							>Active
						</option>
						<option value="2"
							<?php if ($admin->status == 2){ echo 'selected';} ?>
							>Inative
						</option>
						<option value="0"
							<?php if ($admin->status == 0){ echo 'selected';} ?>
							>Deleted
						</option>
					</select>
				</div>

        		<div class="form-group">
			    	<label for="heading">
						<h4>Priviledges</h4>
					</label>
				</div>

				<div class="form-group">
			    	<label for="admins">Change other admin user privileges</label>
			    	<select class="form-control" name="admins" style="width: 80%;">
			    		<option value="0">No</option>
			    		<option value="1"
			    		<?php if ( strrpos($admin->tiles, 'admins') )
			    			{ echo ' selected';}	
			    		?>> Yes</option>
			    	</select>
			    </div>
				
			    <?php foreach($privileges as $privilege): ?>
				
				<div class="form-group">
			    	<label for="<?php echo $privilege['name']; ?>">
			    		<?php echo $privilege['label']; ?>
			    	</label>
			    	<select class="form-control" name="<?php echo $privilege['name']; ?>" style="width: 80%;">

			    		<option value="0"> No </option>
			    		<option value="1"
				    	<?php if ( strrpos($admin->tiles, $privilege['name']) ){
				    		echo ' selected';}
				    	?>> Yes </option>

				    </select>
				 </div>

				<?php endforeach; ?>

			  	<div class="edit-buttons">
				  	<button type="submit" class="btn btn-primary">Update</button>
				  	<a href="/admin/admins/<?php echo $admin->user_id; ?>/delete">	
				  		<button type="button" class="btn btn-danger">Remove</button>
				  	</a>
				</div>

			</form>
		<!-- End of Panel Body -->
		</div>
	</div>
<!-- End of Banner -->
</div>
</div>
