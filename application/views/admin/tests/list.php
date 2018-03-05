<div class="ort">
	<div class="bbbslk">Tests</div>
	<div class="row user-heading">
		<div class="col-md-1"></div>
		<div class="col-md-3 col-sm-4">Title</div>
		<div class="col-md-3 col-sm-3">Test Type</div>
		<div class="col-md-3 col-sm-3">Mandatory</div>
		<div class="col-md-2 col-sm-2">Status</div>
	</div>

<?php foreach($tests as $test): ?>

	<div id="<?php echo $test->id; ?>" class="row user-row"
	style="<?php
				if ($test->status == 0) {
					echo 'background-color: #ddd;';
				} elseif ($test->status == 2){
					echo 'background-color: rgb(178, 31, 36);';
				}
			?>cursor: pointer;">
		<div class="col-md-4 large-text"><?php echo $test->title; ?></div>
		<div class="col-md-3 col-sm-3"><?php echo $test->test_type; ?></div>
		<div class="col-md-3 col-sm-3"><?php echo $test->mandatory; ?></div>
		<div class="col-md-2 col-sm-2	"><?php echo $test->status; ?></div>
	</div>

<?php endforeach; ?>

</div>
<script>
	$( ".user-row" ).click(function(){
		var id = $( this ).attr('id');
		window.location.href = "/admin/tests/"+id+"/edit";
	});
</script>
