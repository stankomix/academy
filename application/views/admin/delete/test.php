
<div class="ort edit-panel">
<div class="banner">
    <div class="panel panel-default">
		<div class="panel-heading">
			<h4>Delete test #<?php echo $test->id; ?></h4>
		</div>
        <div class="panel-body">

        	<form role="form" method="POST" enctype="multipart/form-data">

				<div class="form-group">
					<label for="title">Title</label>
					<p><?php echo $test->title; ?></p>
				</div>

				<div class="form-group">
			    	<label for="mandatory">mandatory</label>
				    <p><?php echo $test->mandatory; ?></p>
				</div>

				<div class="form-group">
			    	<label for="status">Status</label>
				    <p><?php echo $test->status; ?></p>
				</div>

			  	<div class="edit-buttons">
			  		<h4>Are you sure you want to delete this test</h4>
			  		<button type="submit" value="DELETE" class="btn btn-danger">Delete</button>
				  	<a href="/admin/tests/<?php echo $test->id; ?>/edit">
				  	  <button type="button" class="btn btn-primary">NO!, back to editing</button>
				</div>

			</form>
		<!-- End of Panel Body -->
		</div>
	</div>
<!-- End of Banner -->
</div>
</div>
