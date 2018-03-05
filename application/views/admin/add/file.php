<!-- ADD FILE PAGE -->
<div class="ort edit-panel">
<div class="banner">
    <div class="panel panel-default">
		<div class="panel-heading">
			<h4>New File</h4>
		</div>
        <div class="panel-body">

        	<form role="form" method="POST" enctype="multipart/form-data">

				<div class="form-group">
					<label for="title">Title</label>
					<input type="text" class="form-control" name="title">
				</div>

				<div class="form-group">
			    	<label for="category">Category</label>
				    <select class="form-control categ" id="categ" name="category" style="width: 80%;">
						<option value="Other">Other</option>
						<option value="Handbooks">Handbook</option>
						<!--option value="Training Videos">Training Video</option>
						<option value="Training Videos(online)">Training Videos (online)</option-->
						<option value="Videos">Videos</option>
						<option value="Video(online)">Video (online)</option>
						<option value="Guides">Guides</option>
						<option value="Event Photos">Event Photos</option>
						<option value="Manuals">Manuals</option>
					</select>
				</div>

				<div class="form-group">
			    	<label for="status">Status</label>
				    <select class="form-control" name="status" style="width: 80%;">
						<option value="0">0</option>
						<option value="1" selected>1</option>
						<option value="2">2</option>
					</select>
				</div>

				<div id="upload" class="upload">
					<div class="form-group">
				    	<label for="file">Add File</label>
				    	<div class="bb-photos">
					    		<input type="file" name="myFile" style="margin-left: 20px;">
						</div>
					</div>
				</div>


				<div class="edit-buttons">
				  	<button type="submit" class="btn btn-danger cfp-red">Add File</button>
				</div>

			</form>
				
		<!-- End of Panel Body -->
		</div>
	</div>
<!-- End of Banner -->
</div>
</div>
<script type="text/javascript">

var photosElement = '<div class="form-group">'+
				    	'<label for="content">Add new photos</label>'+
				    	'<div class="bb-photos">'+
					    	'<div id="new-photos">'+
					    	'</div>'+
				    		'<div class="add-photo">'+
'<button onclick="addPhoto();" type="button" class="btn btn-warning">Add Photo</button>'+
'<button onclick="removePhoto();" type="button" class="btn btn-warning">Remove Photo</button>'+
							'</div>'+
						'</div>'+
					'</div>'+
					'<input type="hidden" id="pics" name="pics" value="0">';

var fileElement = 	'<div class="form-group">'+
				    	'<label for="file">Add File</label>'+
				    	'<div class="bb-photos">'+
					    		'<input type="file" name="myFile" style="margin-left: 20px;">'+
						'</div>'+
					'</div>';

var videoElement = 	'<div class="form-group">'+
						'<label for="embed_code">Video Url</label>'+
						'<input type="text" class="form-control" name="embed_code">'+
					'</div>';



var count = 1;
function addPhoto(){

   $("#new-photos").append("<input type='file' class='file-up' name='pic"+(count++)+ "'>");
   $("#pics").val(count-1);

};

function removePhoto(){
    	
	if ( (count) > 1 ){
    
    	$("#new-photos input:last").remove();
    	count--;
        $("#pics").val(count-1);
    
    }
};

$( "#categ" ).change(function() {
	$( "#categ option:selected" ).each(function() {
		
		category = $( this ).val();
     	if ( category == "Event Photos" ){

      		$( "#upload" ).html(photosElement);
      	
      	} else if ( category == "Video(online)" || category == "Training Videos(online)" ){

      		$( "#upload" ).html(videoElement);

      	}else {

      		$( "#upload" ).html(fileElement);
      	}
      	
    });
});

</script>
