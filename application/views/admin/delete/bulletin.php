
<div class="ort edit-panel">
<div class="banner">
    <div class="panel panel-default">
		<div class="panel-heading">
			<h4>Confirm delete of Bulletin #<?php echo $bb_id; ?></h4>
		</div>
        <div class="panel-body">

        	<form role="form" method="POST" enctype="multipart/form-data">

				<div class="form-group">
				<label for="title">Title</label>
				<p> <?php echo $bulletin->title; ?> </p>
				</div>

				<div class="form-group">
			    	<label for="category">Category</label>
			    	<p>
			    	<?php 
				    	switch ($bulletin->category) {
				    		case '1':
				    			echo 'News';
				    		break;

				    		case '2':
				    			echo 'New Hires';
				    		break;

				    		case '3':
				    			echo 'Birthday';
				    		break;

				    		case '4':
				    			echo 'Draft';
				    		break;
				    		
				    		default:
				    			# code...
				    		break;
				    	}
				    ?>
				    </p>
				</div>

				<div class="form-group">
			    	<label for="status">Status</label>
				    <p> <?php echo $bulletin->status; ?> </p>
				</div>

				<div class="form-group">
			    	<label for="content">Content</label>
			    	<div> <?php echo htmlspecialchars_decode($bulletin->content); ?> </div>
			    </div>

				<div class="form-group">
			    	<label for="photos">Photos</label>
			    	<div class="bb-photos photo-delete">
			    <?php foreach ($bulletin_photos as $bulletin_photo): ?>
					<img src="/<?php echo $bulletin_photo->small_url; ?>">
				<?php endforeach; ?>
					</div>
				</div>
				
			  	<div class="edit-buttons">
			  		<h4>Are you sure you want to delete this bulletin</h4>
			  		<button type="submit" value="DELETE" class="btn btn-danger">Delete Permanently</button>
				  	<a href="/admin/bb/<?php echo $bb_id; ?>/edit">
				  	  <button type="button" class="btn btn-primary">NO!, back to editing</button>
				</div>
				<input type="hidden" id="bb_id" name="bb_id" value="<?php $bb_id ?>">

			</form>
		<!-- End of Panel Body -->
		</div>
	</div>
<!-- End of Banner -->
</div>
</div>
