<div class="ort">
	<div class="tstust">
		<div class="form-group">
			<div class="col-md-12 text-center"><h2>Test Name : <?php echo $current_test->title; ?></h2></div>
		</div>
		
		<form class="form-horizontal" style="padding: 29px;">
			<div class="">
			
			
		  <ol>
		  <?php $quesionNo = 1; ?>
		  <?php if(count($all_questions) > 0){ ?>
			  <?php foreach($all_questions as $question){ 
			  $options = json_decode($question->options);
			  ?>
					
					<li>

						<h3><?php echo $question->question; ?></h3>
						
						<?php
						$answerNo = 1;
						if(count($options) > 0){
							foreach($options as $all_question){
								?>
						<div>
							<input type="radio" class="answers_radio" name="question-<?php echo $quesionNo; ?>-answers" id="question-<?php echo $quesionNo; ?>-answers-<?php echo $answerNo; ?>" value="<?php echo $all_question ?>" />
							<label for="question-<?php echo $quesionNo; ?>-answers-<?php echo $answerNo; ?>"><?php echo $answerNo; ?>) <?php echo $all_question ?> </label>
						</div>
								<?php 
								 $answerNo++;
							}
						}
						 ?>
								<?php $quesionNo++; ?>
						<?php } ?>
					</li>
			  <?php } ?>

            </ol>
		</div>
			<input type="button" id="end_test" class="btn btn-primary" value="End Test">
		</form>
		<div class="alert alert-danger">
		</div>
		
		<table class="table">
			<thead>
				<th>Total Questions</th>
				<th>Correct</th>
				<th>Wrong</th>
				<th>Pass Or Faile</th>
			</thead>
			<tbody>
				<tr>
				<td id="total"></td>
				<td id="correct"></td>
				<td id="wrong"></td>
				<td id="passorfail"></td>
				</tr>
			</tbody>
		</table>
		
	</div>
</div>
<script>
jQuery(document).ready(function(e){
	jQuery(".alert-danger").hide();
	jQuery("#end_test").click(function(){
		var totalQas = 0;
		var correctAnswers = 0;
		var incorrectAnwers = 0
		var passingPercentage = 50;
		jQuery(".answers_radio").each(function(e){
			totalQas++;
			currentAnswerName = jQuery(this).attr("name");
			if(!jQuery("[name='"+currentAnswerName+"']").is(":checked")){
				jQuery(".alert-danger").html("Please answer all questions").show();
				return false;
			}else{
				
				if(jQuery(this).is(':checked')){
					if(jQuery(this).val() == jQuery(this).attr("data-correct")){
						correctAnswers++;
					}else{
						incorrectAnwers++;
					}
				}
				
				jQuery(".alert-danger").html("Please answer all questions").hide();
				
			}
		});

		
		 $.ajax({url: "/testResult", type:"POST",data:{
		 fields : jQuery('.form-horizontal').serializeArray(),
		 test_id:<?php echo $current_test->id ?>,
 		 },dataType:"json",
			 success: function(result){
				 
			   jQuery("#total").html(result.total);
			   jQuery("#correct").html(result.correct);
			   jQuery("#wrong").html(result.wrong);
			   jQuery("#passorfail").html(result.passOrfail);
		 }});
	
	});
})
</script>