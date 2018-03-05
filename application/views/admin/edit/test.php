
<div class="ort edit-panel">
<div class="banner">
    <div class="panel panel-default">
		<div class="panel-heading">
			<h4>Edit test #<?php echo $test->id; ?></h4>
		</div>
        <div class="panel-body">

        	<form role="form" method="POST" enctype="multipart/form-data">

				<div class="form-group">
					<label for="title">Title</label>
					<input type="text" class="form-control" name="title" placeholder="Title"
					value="<?php echo $test->title; ?>">
				</div>

				<div class="form-group">
			    	<label for="mandatory">mandatory</label>
				    <select class="form-control" name="mandatory" style="width: 80%;">
						<option value="0"
							<?php if ($test->mandatory == 0){ echo 'selected';} ?>
							>0
						</option>
						<option value="1"
							<?php if ($test->mandatory == 1){ echo 'selected';} ?>
							>1
						</option>
					</select>
				</div>

				<div class="form-group">
			    	<label for="status">Status</label>
				    <select class="form-control" name="status" style="width: 80%;">
						<option value="0"
							<?php if ($test->status == 0){ echo 'selected';} ?>
							>0
						</option>
						<option value="1"
							<?php if ($test->status == 1){ echo 'selected';} ?>
							>1
						</option>
						<option value="2"
							<?php if ($test->status == 2){ echo 'selected';} ?>
							>2
						</option>
					</select>
				</div>

			  	<div class="edit-buttons">
				  	<button type="submit" class="btn btn-primary">Update</button>
				  	<a href="/admin/tests/<?php echo $test->id; ?>/delete">	
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
