<div class="ort edit-panel">
<div class="banner">
    <div class="panel panel-default">
		<div class="panel-heading">
			<h4>Add/Edit Questions to the test</h4>
		</div>
        <div class="panel-body">
        	<form role="form" method="POST" action="/admin/questions/update/<?php echo $test->id; ?>" enctype="multipart/form-data">
				<div class="form-group">
					<label for="title">Title</label>
					<input type="text" required class="form-control" value="<?php echo $test->question; ?>" name="title" >
				</div>

				<div class="form-group">
			    	<label for="mandatory">Correct Answer</label>
				    <input type="text" required value="<?php echo $test->correct_answer; ?>" class="form-control" name="correct_answer" style="width: 80%;" />
					
				</div>
				
				<div class="form-group">
				<label for="mandatory">Add options</label>
				<p class="clearfix"></p>
					<div class="col-md-8">
						<div id="InputsWrapper">
						<!-- <div><input type="text" class="form-control" name="questions[]" id="field_1"> <a href="#" class="removeclass">Remove</a></div> -->
						
						<?php
						
						if(!empty($test->options)){
							$options = json_decode($test->options);
							$count=1;
							foreach($options as $fields){
								?>
								<div><input type="text" class="form-control" name="questions[]" value="<?php echo $fields; ?>" id="field_<?php echo $count; ?>"> <a href="#" class="removeclass">Remove</a></div>
								<?php
							}
						}
						
						?>
						
						</div>
					</div>
					<p class="clearfix"></p>
					<div id="AddMoreFileId">
						<a href="#" id="AddMoreFileBox" class="btn btn-info">Add options</a><br><br>
					</div>
				</div>

				<div class="form-group">
			    	<label for="status">Status</label>
				    <select class="form-control" name="status" style="width: 80%;">
						<option <?php if($test->status == false) echo "selected" ?>>0</option>
						<option <?php if($test->status == true) echo "selected" ?>>1</option>
						
					</select>
				</div>
				
				<input type="hidden" name="test_id" value="<?php echo $test->test_id; ?>">
				
			  	<div class="edit-buttons">
				  	<button type="submit" class="btn btn-danger cfp-red">Update Queston</button>
				</div>
			</form>
		</div>
	</div>
	
<!-- End of Banner -->
</div>
</div>
<script>jQuery(document).ready(function(){
	 jQuery('#question-table').DataTable();
	 
	 //Dynamic Fields
	var MaxInputs       = 10; //maximum extra input boxes allowed
	var InputsWrapper   = $("#InputsWrapper"); //Input boxes wrapper ID
	var AddButton       = $("#AddMoreFileBox"); //Add button ID

	var x = InputsWrapper.length; //initlal text box count
	
	var FieldCount=0; //to keep track of text box added

	//on add input button click
	$(AddButton).click(function (e) {
			//max input box allowed
			if(x <= MaxInputs) {
				FieldCount++; //text box added ncrement
				//add input box
				$(InputsWrapper).append('<div><input type="text" class="form-control" name="questions[]" id="field_'+ FieldCount +'"/> <a href="#" class="removeclass">Remove</a></div>');
				x++; //text box increment
				
				$("#AddMoreFileId").show();
				
				$('AddMoreFileBox').html("Add field");
				
				// Delete the "add"-link if there is 3 fields.
				if(MaxInputs == FieldCount) {
					$("#AddMoreFileId").hide();
					$("#lineBreak").html("<br>");
				}
			}else{
				console.log("full");
			}
			return false;
	});
	
	 jQuery("form").submit(function(e){
		 if(jQuery("#InputsWrapper input").length < 2 || jQuery("#InputsWrapper input").length == undefined){
			 event.preventDefault();
			 alert("Kindly add aleast 2 options to this question!!")
		 }
		 
	 });

	$("body").on("click",".removeclass", function(e){ //user click on remove text
			if( x > 0 ) {
					$(this).parent('div').remove(); //remove text box
					
					$("#AddMoreFileId").show();
					$("#lineBreak").html("");
					// Adds the "add" link again when a field is removed.
					$('AddMoreFileBox').html("Add field");
			}
		return false;
	});
});
</script>