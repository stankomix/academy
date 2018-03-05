
<div class="ort edit-panel">
<div class="banner">
    <div class="panel panel-default">
		<div class="panel-heading">
			<h4>
				Edit Bulletin #<?php echo $bb_id; ?> &nbsp&nbsp
				- <a href="/admin/bb/details/<?php echo $bb_id; ?>">Back to Bulletin</a>
			</h4>
		</div>
        <div class="panel-body">

        	<form role="form" method="POST" enctype="multipart/form-data">

				<div class="form-group">
				<label for="title">Title</label>
				<input type="text" class="form-control" name="title"
				value="<?php echo $bulletin->title; ?>">
				</div>

				<div class="form-group">
			    	<label for="category">Category</label>
				    <select class="form-control" name="category" style="width: 80%;">
						<option value="1"
							<?php if ($bulletin->category == 1){ echo 'selected';} ?>
							>News
						</option>
						<option value="2"
							<?php if ($bulletin->category == 2){ echo 'selected';} ?>
							>New Hires
						</option>
						<option value="3"
							<?php if ($bulletin->category == 3){ echo 'selected';} ?>
							>Birthday</option>
						<option value="4"
							<?php if ($bulletin->category == 4){ echo 'selected';} ?>
							>Draft</option>
					</select>
				</div>

				<div class="form-group">
			    	<label for="status">Status</label>
				    <select class="form-control" name="status" style="width: 80%;">
						<option value="1"
							<?php if ($bulletin->status == 1){ echo 'selected';} ?>
							>Active
						</option>
						<option value="2"
							<?php if ($bulletin->status == 2){ echo 'selected';} ?>
							>Pending
						</option>
						<option value="0"
							<?php if ($bulletin->status == 0){ echo 'selected';} ?>
							>Deleted
						</option>
					</select>
				</div>

				<div class="form-group">
			    	<label for="content">Content</label>
			    	<textarea name="content" class="form-control" rows="20"><?php echo $bulletin->content; ?></textarea>
			    </div>

				<div class="form-group">
			    	<label for="photos">Current Photos</label>
			    	<div class="bb-photos">
			    	<?php 
			          if ( count($bulletin_photos) > 0 ):
			        ?>
			            <h4>Click image to delete</h4>
			       
			        <?php else: ?>

			            <h4>No images</h4>

			        <?php
			          endif;
			        ?>

				    <?php foreach ($bulletin_photos as $bulletin_photo): ?>
				    	<div>
							<a href="/admin/delete/bb_photo/<?php echo $bulletin_photo->id; ?>">
								<img src="/<?php echo $bulletin_photo->small_url; ?>">
							</a>
						</div>
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

			  	<div class="edit-buttons">
				  	<button type="submit" class="btn btn-primary">Update</button>
				  	<a href="/admin/bb/<?php echo $bb_id ?>/delete">	
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
});

</script>
