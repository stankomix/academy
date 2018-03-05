
<div class="ort edit-panel">
<div class="banner">
    <div class="panel panel-default">
		<div class="panel-heading">
			<h4>Confirm delete of File #<?php echo $file->id; ?></h4>
		</div>
        <div class="panel-body">

        	<form role="form" method="POST" enctype="multipart/form-data">

				<div class="form-group">
				<label for="title">Title</label>
				<p> <?php echo $file->title; ?> </p>
				</div>

				<div class="form-group">
			    	<label for="category">Category</label>
			    	<p>
			    	<?php echo $file->category ?>
				    </p>
				</div>

				<div class="form-group">
			    	<label for="name">File Name</label>
				    <p> <?php echo $file->file_name; ?> </p>
				</div>

				<div class="form-group">
			    	<label for="size">Size</label>
				    <p> <?php echo $file->file_size; ?> </p>
				</div>

				<div class="form-group">
			    	<label for="date">Created at</label>
				    <p> <?php echo $file->create_date; ?> </p>
				</div>
			
			<?php 
			if ($file->category == 'Event Photos'):
			?>
				<div class="form-group">
		    	<label for="photos">Current Photos</label>
		    		<div class="bb-photos photo-delete">
					<?php foreach ($photos as $photo): ?>
						<img src="<?php echo '/' . $photo->small_url; ?>" />
					<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
				
			  	<div class="edit-buttons">
			  		<h4>Are you sure you want to delete this file</h4>
			  		<button type="submit" value="DELETE" class="btn btn-danger">Delete</button>
				  	<a href="/admin/files/<?php echo $file->id; ?>/edit">
				  	  <button type="button" class="btn btn-primary">NO!, back to editing</button>
				</div>
				<input type="hidden" id="file_id" name="file_id" value="<?php echo $file->id ?>">

			</form>
		<!-- End of Panel Body -->
		</div>
	</div>
<!-- End of Banner -->
</div>
</div>
