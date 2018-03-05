<div class="ort">
	<div class="bbbslk">Admin</div>
	<div class="row user-heading">
		<div class="col-md-1"></div>
		<div class="col-md-3 col-sm-4">Name</div>
		<div class="col-md-8 col-sm-8">Privileges</div>
	</div>

<?php foreach($admins as $admin): ?>

	<div id="<?php echo $admin->user_id; ?>" class="row user-row"
	style="<?php
				if ($admin->status == 0) {
					echo 'background-color: #ddd;';
				} elseif ($admin->status == 2){
					echo 'background-color: rgb(178, 31, 36);';
				}
			?>cursor: pointer;">

		<div class="col-md-4 col-sm-4 large-text"><?php echo $admin->name_surname; ?></div>
		<div class="col-md-8 col-sm-8">

		<?php foreach($privileges as $privilege): ?>
            
            <?php if ( strrpos($admin->tiles, $privilege) ): ?>
            	<p class="btn cfp-red" style="color:#fff;
            	<?php
            		if ($admin->status == '2'){
            			echo 'border-color:#fff';
            		}
            	?>">
            		<?php echo $privilege; ?>
            	</p>
            <?php else: ?>
            	<p class="btn" style="background-color:#fff;
            	<?php
            		if ($admin->status == '1'){
            			echo 'border-color:#b21f24';
            		}
            	?>">
            		<?php echo $privilege; ?>
            	</p>
            <?php endif ?> 

        <?php endforeach; ?>
				
		</div>

	</div>

<?php endforeach; ?>

</div>
<script>
	$( ".user-row" ).click(function(){
		var id = $( this ).attr('id');
		window.location.href = "/admin/admins/"+id+"/edit";
	});
</script>
