	<div class="ab">
	<div class="ort">

		<div id="nf" class="lnklr <?php if($is_admin){ echo "admin-bar"; } ?>">
			<a href="/" class="<?php echo ($currMethod == 'dashboard') ? 'scl' : 'nrml' ?>" >
				<span>
					<img src="/public/images/ico1.png" />
				</span>
				Dashboard
			</a>
			<a href="/timecard" class="<?php echo ($currMethod == 'timecard') ? 'scl' : 'nrml' ?>" >
				<span>
					<img src="/public/images/timeclockICO.png" />
				</span>
				TimeCard
			</a>
			<a href="/tests" class="<?php echo ($currMethod == 'tests') ? 'scl' : 'nrml' ?>" >
				<span>
					<img src="/public/images/ico2.png" />
				</span>
				Your Tests
			</a>
			<a href="/bb" class="<?php echo ($currMethod == 'bb') ? 'scl' : 'nrml' ?>" >
				<span>
					<img src="/public/images/ico3.png" />
				</span>
				Bulletin Board
			</a>
			<a href="/files" class="<?php echo ($currMethod == 'files') ? 'scl' : 'nrml' ?>" >
				<span>
					<img src="/public/images/ico4.png" />
				</span>
				File Manager
			</a>
		<?php
		
			if ( $is_admin ):
		
		?>
		<style>
			.admin-bar {width: 900px !important;}
			/*
			 *admin bar
			 */
			@media screen and (max-width: 900px){
				
				.admin-bar {width: 750px !important;}
				.header .ab .lnklr a {
					width: 125px;
				}

			}

		</style>
			<a id="admin-btn" class="<?php echo ($currMethod == 'admin') ? 'scl' : 'nrml' ?>" >
				<span>
					<img src="/public/images/admin.png" />
				</span>
				Admin
			</a>
			<div class="t"></div>
		<?php
		  endif;
		?>
		</div>
	</div>

</div>
<div class="logo"><a href="/"><img src="/images/logo.png" /></a></div>
</div>

<div class="admin-tiles row" align="center">
	<ul class="wrapper">
	
	<!-- User tiles -->
	<?php if ( in_array('users', $user_tiles) ): ?>
	    <li class="box">
	    	<a href="/admin/users">
	        	<img src="/public/images/admin_users.png" />
	        	<span>Users</span>
	        </a>
	    </li>
	    <li class="box">
	    	<a href="/admin/users/add">
	        	<img src="/public/images/admin_add_user.png" />
    	    	<span>Add User</span>
    	    </a>
	    </li>
	<?php endif; ?>

	<!-- BB tiles -->
	<?php if ( in_array('bb', $user_tiles) ): ?>
	    <li class="box">
	    	<a href="/admin/bb">
	        	<img src="/public/images/admin_bb.png" />
	        	<span>Bulletins</span>
	       	</a>
	    </li>
	    <li class="box">
	    	<a href="/admin/bb/add">
	        	<img src="/public/images/admin_add_bb.png" />
	        	<span>Add Bulletin</span>
	       	</a>
	    </li>
	<?php endif; ?>

	<!-- Files tiles -->
	<?php if ( in_array('files', $user_tiles) ): ?>
	    <li class="box">
	    	<a href="/admin/files">
	        	<img src="/public/images/admin_files.png" />
	        	<span>Files</span>
	        </a>
	    </li>
	    <li class="box">
	    	<a href="/admin/files/add">
	        	<img src="/public/images/admin_add_file.png" />
	        	<span>Add File</span>
	        </a>
	    </li>
	<?php endif; ?>

	<!-- Tests tiles -->
	<?php if ( in_array('tests', $user_tiles) ): ?>
	    <li class="box">
	    	<a href="/admin/tests">
	        	<img src="/public/images/admin_tests.png" />
	        	<span>Tests</span>
	        </a>
	    </li>
	    <li class="box">
	    	<a href="/admin/tests/add">
	        	<img src="/public/images/admin_add_test.png" />
	        	<span>Add Test</span>
	        </a>
	    </li>
	<?php endif; ?>

	<!-- Admin tiles -->
	<?php if ( in_array('admins', $user_tiles) ): ?>
	    <li class="box">
	    	<a href="/admin/admins">
	        	<img src="/public/images/admin_admins.png" />
	        	<span>Admins</span>
	        </a>
	    </li>
	    <li class="box">
	    	<a href="/admin/admins/add">
	        	<img src="/public/images/admin_add_admin.png" />
    	    	<span>Add Admin</span>
    	    </a>
	    </li>
	<?php endif; ?>

	<!-- Timecard tile -->
	<?php if ( in_array('timecards', $user_tiles) ): ?>
	    <li class="box">
	    	<a href="/admin/timecard">
	        	<img src="/public/images/admin_timecards.png" />
	        	<span>Timecards</span>
	        </a>
	    </li>
	<?php endif; ?>

	<!-- Overtime tile >

	    <li class="box">
	    	<a href="/admin/overtime">
	        	<img src="/public/images/admin_overtime.png" />
	        	<span>Overtime</span>
	        </a>
	    </li-->

	<!-- Payroll tiles -->
	<?php if ( in_array('payroll', $user_tiles) ): ?>
	    <li class="box">
	    	<a href="/admin/payroll">
	        	<img src="/public/images/admin_payroll.png" />
	        	<span>Payrolls</span>
	        </a>
	    </li>
	<?php endif; ?>

	</ul>
</div>

<script>
	
	$( "#admin-btn" ).click(function(){

		var display = $( ".admin-tiles" ).css("display");
		
		if (display == "none"){

			$( "#admin-btn" ).addClass("red");
		
			$( ".admin-tiles" ).slideDown( "slow", function() {
				
				$( ".admin-tiles" ).css("display", "inherit");
			
			});
		
		} else {
			
			$( "#admin-btn" ).removeClass("red");
		
			$( ".admin-tiles" ).slideUp( "slow", function() {
			
				$( ".admin-tiles" ).css("display", "none");
			
			});
		
		}

	});

</script>