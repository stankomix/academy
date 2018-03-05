<!-- EDIT FILE PAGE -->
<div class="ort edit-panel">
<div class="banner">
    <div class="panel panel-default">
		<div class="panel-heading">
			<h4>Edit File #<?php echo $file->id; ?>: <?php echo $file->file_name; ?></h4>
				<a class="btn btn-danger cfp-red"
				href="/admin/files/category/<?php echo $category; ?>">
				Back to Category
				</a>
		</div>
        <div class="panel-body">

        	<form role="form" method="POST" enctype="multipart/form-data">

				<div class="form-group">
					<label for="title">Title</label>
					<input type="text" class="form-control" name="title"
					value="<?php echo $file->title; ?>">
				</div>
			<?php 
			if ($file->category == 'Event Photos'):
			?>

				<input type="hidden" name="category" value="Event Photos">

			<?php else: ?>
				<div class="form-group">
			    	<label for="category">Category</label>
				    <select class="form-control" name="category" style="width: 80%;">
						<option value="Other"
							<?php if ($file->category == 'Other'){ echo 'selected';} ?>
							>Other
						</option>
						<option value="Handbooks"
							<?php if ($file->category == 'Handbooks'){ echo 'selected';} ?>
							>Handbooks
						</option>
						<option value="Videos"
							<?php if ($file->category == 'Videos'){ echo 'selected';} ?>
							>Videos
						</option>
						<option value="Training Videos"
							<?php if ($file->category == 'Training Videos'){ echo 'selected';} ?>
							>Training Videos
						</option>
						<option value="Guides"
							<?php if ($file->category == 'Guides'){ echo 'selected';} ?>
							>Guides
						</option>
						<option value="Manuals"
							<?php if ($file->category == 'Manuals'){ echo 'selected';} ?>
							>Manuals
						</option>
					</select>
				</div>
			<?php endif; ?>

				<div class="form-group">
			    	<label for="status">Status</label>
				    <select class="form-control" name="status" style="width: 80%;">
						<option value="0"
							<?php if ($file->status == 0){ echo 'selected';} ?>
							>0
						</option>
						<option value="1"
							<?php if ($file->status == 1){ echo 'selected';} ?>
							>1
						</option>
						<option value="2"
							<?php if ($file->status == 2){ echo 'selected';} ?>
							>2
						</option>
					</select>
				</div>

			<?php 
			if ($file->category == 'Event Photos'):
			?>
					<div class="form-group">
			    	<label for="photos">Current Photos</label>
			    		<div class="bb-photos">
			    		<?php 
				          if ( count($photos) > 0 ):
				        ?>
				            <h4>Click image to delete</h4>
				       
				        <?php else: ?>

				            <h4>No images</h4>

				        <?php
				          endif;
				        ?>

						<?php foreach ($photos as $photo): ?>

							<a href="/admin/delete/photo/<?php echo $photo->id; ?>">
								<img src="<?php echo '/' . $photo->small_url; ?>" />
							</a>

						<?php endforeach; ?>
						</div>
					</div>

					<div class="form-group">
				    	<label for="content">Add new photos</label>
				    	<div class="bb-photos">
					    	<div id="new-photos">
					    	</div>
				    		<div class="add-photo">
								<button id="add-photo" type="button" class="btn btn-warning">Add Photo</button>
								<button id="remove-photo" type="button" class="btn btn-warning">Remove Photo</button>
							</div>
						</div>
					</div>

				<input type="hidden" id="pics" name="pics" value="0">

			<?php endif; ?>

			<?php 
			if ($file->category == 'Videos'):
			?>

				<div id="video" style="display:none;">
					<?php echo htmlspecialchars_decode($file->embed_code); ?>
				</div>

				<div class="form-group">
					<label for="embed_code">Video Embed Url</label>
					<input id="video_url" type="text" class="form-control" name="embed_code">
				</div>

			<?php endif; ?>

				<div class="edit-buttons">
				  	<button type="submit" class="btn btn-primary">Update</button>
				  	<a href="/admin/files/<?php echo $file->id; ?>/delete">	
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

    $("#remove-photo").click(function(){
	    	
    	if ( (count) > 1 ){
	    
	    	$("#new-photos input:last").remove();
	    	count--;
	        $("#pics").val(count-1);
	    
	    }
    });

    var vid = $( "iframe" ).attr("src");
    $( "#video_url" ).val(vid);
});

</script>
