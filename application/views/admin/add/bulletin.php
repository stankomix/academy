
<div class="ort edit-panel">
<div class="banner">
    <div class="panel panel-default">
		<div class="panel-heading">
			<h4>New Bulletin</h4>
		</div>
        <div class="panel-body">

        	<form role="form" method="POST" enctype="multipart/form-data">

				<div class="form-group">
				<label for="title">Title</label>
				<input type="text" class="form-control" name="title" placeholder="Title">
				</div>

				<div class="form-group">
			    	<label for="category">Category</label>
				    <select class="form-control" name="category" style="width: 80%;">
						<option value="1">News</option>
						<option value="2">New Hires</option>
						<option value="3">Birthday</option>
						<option value="4" selected>Draft</option>
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

				<div class="form-group">
			    	<label for="content">Content</label>
			    	<textarea name="content" class="form-control" rows="20"></textarea>
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
				  	<button type="submit" class="btn btn-danger cfp-red">Add Bulletin</button>
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
})

</script>
