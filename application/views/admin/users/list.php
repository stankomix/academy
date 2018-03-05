<div class="ort" id="list">
	<div class="bbbslk">Users</div>

	<br>
	<div class="col-md-12">
		<div class="col-md-3">
			filter by name:
		</div>
		<div class="col-md-7">
			<input type="text" v-model="firit" class="form-control" style="width: 60%">
		</div>
	</div>
	<br><br>

	<div class="row user-heading">
		<div class="col-md-1"></div>
		<div class="col-md-3 col-sm-4">Name</div>
		<div class="col-md-3 col-sm-3">Email</div>
		<div class="col-md-3 col-sm-3">Job</div>
		<div class="col-md-2 col-sm-2">Birthday</div>
	</div>

	<div id="user-wrapper">

		<div id="{{ user.name }}" class="row user-row" style="cursor: pointer;" v-for="user in users  | filterBy firit in 'name'">
			<div class="col-md-4 col-sm-4 large-text">{{ user.name }}</div>
			<div class="col-md-3 col-sm-3">{{ user.email }}</div>
			<div class="col-md-3 col-sm-3">{{ user.job }}</div>
			<div class="col-md-2 col-sm-2">{{ user.birthday }}</div>
		</div>

	</div>

	<?php
	/*
	if ($user->status == 0) {
		echo 'background-color: #ddd;';
	} elseif ($user->status == 2){
		echo 'background-color: rgb(178, 31, 36);';
	}
	*/?>

</div>
<script src="/js/vue.js" type="text/javascript"></script>
<script type="text/javascript">

	$(document).ready(function() {

		new Vue({
		  el: '#list',
		  
		  data: {
		  	firit: "",
		    users: [
			  <?php foreach ($users as $user): ?>	
		      	{
		      		id: "<?php echo $user->id;?>",
		      		name: "<?php echo $user->name_surname; ?>",
		      		email: "<?php echo $user->email; ?>",
		      		job: "<?php echo $user->job; ?>",
		      		birthday: "<?php echo $user->birthday; ?>",
		      	},	
			  <?php endforeach; ?>
		    ]
		  }

		});

		$( ".user-row" ).click(function(){
			var id = $( this ).attr('id');
			window.location.href = "/admin/users/"+id+"/edit";
		});
	});
</script>
