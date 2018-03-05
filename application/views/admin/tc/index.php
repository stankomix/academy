<script src="/js/add_timecard_admin.js" type="text/javascript"></script>

<div class="ort edit-panel" id="home">
<div class="banner">
    <div class="panel panel-default">
		<div class="panel-heading">
			<h4>Timecards</h4>
		</div>
        <div class="panel-body">
   
    <form method="post" name="bbform" id="bbform">

        <div class="form-group" id="userslist">
	    	
	    	<div class="col-md-12">
	    	<label for="job">User</label>
		     <div class="row">
				
				<div class="col-md-6">
					<input type="text" id="ddusers" class="form-control" />
					<input type="hidden" id="user_id" name="user_id" class="form-control" />
					<img id="clear_user" align="right" src="/images/clear.png" width="20px" style="position: relative;top: -26px;left: -5px;">
				</div>

				<div class="col-md-6">
				<?php if ($admin_overtime): ?>
			  		<a id="tc_user">
			  			<button type="button" class="btn btn-danger cfp-red" style="padding:10px 20px;">
			  				Mark Overtimes
			  			</button>
			  		</a>
				<?php endif; ?>
				</div>
		
		  	 </div>
		
		</div>
		<hr>
		<div class="form-group">
			<label>Workorder</label>
			<input type="text" class="form-control" id="workorder_id" name="workorder_id">
		</div>
			
		<div class="form-group">
			<label>Date</label>
			<input type="date" class="form-control" name="date" value="<?php echo date("Y-m-d"); ?>">
		</div>

		<div class="row">
		  <div class="col-md-6 col-sm-6 col-xs-12">
			
			<!-- Start Time-->
			<div class="yzlr4">Start Time</div><br>
			
			<div class="form-group time-box start-time row">
				<div class="col-md-4 col-sm-3 col-xs-5">
					<input type="text" value="" name="start_hour" id="timecard_hour" class="form-control">
				</div>

				<div class="col-md-1 col-sm-1 col-xs-1"><b>:</b></div>

				<div class="col-md-4 col-sm-3 col-xs-5">
					<input type="text" value="" name="start_min" id="timecard_min" class="form-control">
				</div>
					
				<div class="col-md-5 col-sm-3 col-xs-6 marg">
			    	<select class="form-control" id="timecard_pmam" name="start_pmam">
			    		<option value="AM">AM</option>
			    		<option value="PM">PM</option>
			    	</select>
				</div>
			</div>
		 </div>
		
		 <div class="col-md-6 col-sm-6 col-xs-12">

			<!-- End Time-->
			<div class="yzlr4">End Time</div><br>
			
			<div class="form-group time-box end-time row">
				<div class="col-md-4 col-sm-3 col-xs-5">
					<input type="text" value="" name="stop_hour" id="stop_hour" class="form-control">
				</div>

				<div class="col-md-1 col-sm-1 col-xs-1"><b>:</b></div>

				<div class="col-md-4 col-sm-3 col-xs-5">
					<input type="text" value="" name="stop_min" id="stop_min" class="form-control">
				</div>
					
				<div class="col-md-5 col-sm-3 col-xs-6">
			    	<select class="form-control marg" id="stop_pmam" name="stop_pmam">
			    		<option value="AM">AM</option>
			    		<option value="PM">PM</option>
			    	</select>
				</div>
			</div>

		  </div>
		</div>

		<div class="form-group">
			<b>Timecard is for overtime</b>
			<input type="checkbox" id="overtime" name="overtime" />
		</div>

		<div class="ot">
			<div class="form-group">
	        	<label>Overtime reason</label>
	            <input type="text" value="" name="overtime_reason" id="overtime_reason" class="form-control">
	        </div>

	        <div class="form-group">
		        <label>Hours limit</label>
	    	    <input type="text" value="" name="hours_limit" id="hours_limit" class="form-control" style="width: 80px;text-align: center;">
	        </div>
	    </div>


		<div class="edit-buttons">
		  	<button type="button" class="btn btn-danger cfp-red" onclick="npstgndr();">Add Timecard</button>
		</div>

	  </form>
		<!-- End of Panel Body -->
		</div>
	</div>
<!-- End of Banner -->
</div>
</div>

<script src="/js/vue.js" type="text/javascript"></script>
<script type="text/javascript">

	$(document).ready(function() {

	// data arrays
	var users = [];
	var userData = [];

   	<?php foreach ($users as $user): ?>

	// add user name to list
	users.push(
		"<?php echo $user->name_surname; ?> (<?php echo $user->email; ?>)"
	);

	userData["<?php echo $user->email; ?>"] = "<?php echo $user->id; ?>";
	
	<?php endforeach; ?>

	BindControls();

	$( "#ddusers" ).focusout(function(){
		
		var user = $( this ).val();
		var email = user.split("(").pop();
		email = email.slice(0, -1);

		// set the user id field
		$( "#user_id" ).val( userData[ email ] );
		
		// update mark overtimes link
		user_id = $( "#user_id" ).val();
		$( '#tc_user' ).attr('href', '/admin/timecard/'+user_id);

	});

	$( "#clear_user" ).click(function(){
		
		$( "#ddusers" ).val("");
		$( "#user_id" ).val("");

		// update mark overtimes link
		user_id = $( "#user_id" ).val();
		$( '#tc_user' ).attr('href', "#");
	});

	function BindControls() {        

        $( '#ddusers' ).autocomplete({
            source: users,
            minLength: 0,
            scroll: true
        }).focus(function() {
            $(this).autocomplete("search", "");
        });

        // reset the dropdown style
        $( ".ui-autocomplete" ).attr( "style", "" );
    
    }
});

</script>