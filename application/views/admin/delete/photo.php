<div class="ort edit-panel">
<div class="banner">
    <div class="panel panel-default">
		<div class="panel-heading">
			<h4>Are sure you want to delete the image?</h4>
		</div>
        <div class="panel-body">
        	
        	<div class="bb-photos">
		    	<div class="delete-pic">
		    		<img src="/<?php echo $photo->large_url; ?>" style="width:100%;">
				</div>
			</div>

			<div class="edit-buttons">
			  <form method="POST">
			  	<input type="hidden" name="file_id" value="<?php echo $photo->file_id ?>">	
			  	<h4>Are you sure you want to delete this photo</h4>
			  	<button type="submit" class="btn btn-danger">Delete</button>
			  </form>
			  	<a href="/admin/files/<?php echo $photo->file_id ?>/edit">	
			  		<button type="button" class="btn btn-primary">Back to Bulletin</button>
			  	</a>
			</div>

        </div>
    </div>
</div>
</div>
