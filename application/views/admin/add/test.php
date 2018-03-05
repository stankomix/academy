
<div class="ort edit-panel">
<div class="banner">
    <div class="panel panel-default">
		<div class="panel-heading">
			<h4>New Test</h4>
		</div>
        <div class="panel-body">

        	<form role="form" method="POST" enctype="multipart/form-data">

				<div class="form-group">
				<label for="title">Title</label>
				<input type="text" class="form-control" name="title" placeholder="Title">
				</div>

				<div class="form-group">
			    	<label for="mandatory">Mandatory</label>
				    <select class="form-control" name="mandatory" style="width: 80%;">
						<option>0</option>
						<option selected>1</option>
					</select>
				</div>

				<div class="form-group">
			    	<label for="status">Status</label>
				    <select class="form-control" name="status" style="width: 80%;">
						<option>0</option>
						<option selected>1</option>
						<option>2</option>
					</select>
				</div>

			  	<div class="edit-buttons">
				  	<button type="submit" class="btn btn-danger cfp-red">Add Test</button>
				</div>

			</form>
		<!-- End of Panel Body -->
		</div>
	</div>
<!-- End of Banner -->
</div>
</div>
