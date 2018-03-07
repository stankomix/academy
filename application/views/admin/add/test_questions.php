<?php if($this->session->flashdata('message')){ ?>
	<div class="alert alert-success text-center">
		<?php echo $this->session->flashdata('message'); ?>
	</div>
<?php } ?>

<div class="ort edit-panel">
<div class="banner">
    <div class="panel panel-default">
		<div class="panel-heading">
			<h4>Add Questions to the test</h4>
		</div>
        <div class="panel-body">

        	<form role="form" method="POST" action="/admin/questions/add/<?php echo $test_id; ?>" enctype="multipart/form-data">

				<div class="form-group">
				<label for="title">Question</label>
				<input type="text" required class="form-control" name="title" >
				</div>

				<div class="form-group">
			    	<label for="mandatory">Correct Answer</label>
				    <input type="text" required class="form-control" name="correct_answer" style="width: 80%;" />
					
				</div>
				
				<div class="form-group">
				<label for="mandatory">Add options</label>
				<p class="clearfix"></p>
					<div class="col-md-8">
						<div id="InputsWrapper">
						
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
						<option>0</option>
						<option selected>1</option>
						
					</select>
				</div>

			  	<div class="edit-buttons">
				  	<button type="submit" class="btn btn-danger cfp-red">Add Test</button>
				</div>

			</form>
			
	
		</div>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>All Questions from this test</h4>
		</div>
        <div class="panel-body">
			<table id="question-table">
				<thead>
					<th>Question ID</th>
					<th>Question Title</th>
					<th>Total Options</th>
					<th>Correct answer</th>
					<th>Question Status</th>
					<th>Action</th>
				</thead>
				
				<tbody>
				
				<?php if(count($tests) > 0){ ?>
					<?php foreach($tests as $questions){ ?>
					<tr class="text-center">
						<td><?php echo $questions->id; ?></td>
						<td><?php echo $questions->question; ?></td>
						<td><?php echo count(json_decode($questions->options)); ?></td>
						<td><?php echo $questions->correct_answer; ?></td>
						<td><?php echo $questions->status; ?></td>
						<td><input onClick="window.location='/admin/questions/edit/<?php echo $questions->id; ?>'" type="button" value="Edit" data-id="<?php echo $questions->id; ?>" class="btn btn-primary" >
						<input type="button" onClick="remove(<?php echo $questions->id; ?>)" value="Remove" data-id="<?php echo $questions->id; ?>" class="btn btn-danger" ></td>
					</tr>
					<?php } ?>
				<?php  } ?>
				
					
					
				</tbody>
				
			</table>
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

	$("body").on("click",".removeclass", function(e){ //user click on remove text
			if( x > 1 ) {
					$(this).parent('div').remove(); //remove text box
					x--; //decrement textbox
					$("#AddMoreFileId").show();
					$("#lineBreak").html("");
					// Adds the "add" link again when a field is removed.
					$('AddMoreFileBox').html("Add field");
			}
		return false;
	});
	 
	 jQuery("form").submit(function(e){
		 if(jQuery("#InputsWrapper input").length < 2 || jQuery("#InputsWrapper input").length == undefined){
			 event.preventDefault();
			 alert("Kindly add aleast 2 options to this question!!")
		 }
		 
	 });
	 
});

function remove(id){
	
	var r = confirm("Are you sure you want to remove!");
if (r == true) {
   window.location = "/admin/questions/delete/"+id;
   
}

	
	
}
</script>