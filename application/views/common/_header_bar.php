<body>

<div class="hps">

<!-- small screen header -->

	<nav class="navbar navbar-default small-header navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
             <img class="menu" src="/images/menu-icon.png">Menu
          </button>
          <a class="navbar-brand" href="#"><img src="/images/logoyz.png"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li>
            	<a href="/">
	            	<img src="/public/images/ico1.png" />
	            	Dashboard
            	</a>
            </li>
            <li>
            	<a href="/timecard">
            		<img src="/public/images/timeclockICO.png" />
            		TimeCard
            	</a>
            </li>
            <li>
            	<a href="/tests">
            		<img src="/public/images/ico2.png" />
            		Your Tests
            	</a>
            </li>
            <li>
            	<a href="/bb">
            	<img src="/public/images/ico3.png" />
            	Bulletin Board
      				</a>
      			</li>
      			<li>
      				<a href="/files">
      				<img src="/public/images/ico4.png" />
      				File Manager
      				</a>
      			</li>
        <?php
    
          if ( $is_admin ):
        
        ?>
            <!-- View -->
            
            <li class="dropdown">
              <a id="black" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="/public/images/admin_black.png" />Admin<span class="caret"></span></a>
              <ul class="dropdown-menu">
              
              <?php if ( in_array('users', $user_tiles) ): ?>
                <li><a href="/admin/users"><img src="/public/images/admin_users.png" />Users</a></li>
              <?php endif; ?>

              <?php if ( in_array('bb', $user_tiles) ): ?>
                <li><a href="/admin/bb"><img src="/public/images/admin_bb.png" />Bulletins</a></li>
              <?php endif; ?>

              <?php if ( in_array('files', $user_tiles) ): ?>
                <li><a href="/admin/files"><img src="/public/images/admin_files.png" />Files</a></li>
              <?php endif; ?>

              <?php if ( in_array('tests', $user_tiles) ): ?>
                <li><a href="/admin/tests"><img src="/public/images/admin_tests.png" />Tests</span></a></li>
              <?php endif; ?>

              <?php if ( in_array('admins', $user_tiles) ): ?>
                <li><a href="/admin/admins"><img src="/public/images/admin_admins.png" />Admins</a></li>
              <?php endif; ?>

              <?php if ( in_array('timecards', $user_tiles) ): ?>
                <li><a href="/admin/timecard"><img src="/public/images/admin_timecards.png" />Timecards</a></li>
              <?php endif; ?>

              <?php if ( in_array('payroll', $user_tiles) ): ?>
                <li><a href="/admin/payroll"><img src="/public/images/admin_payroll.png" />Payroll</a></li>
              <?php endif; ?>

              </ul>
            </li>
            
            <!-- Add -->

            <li class="dropdown">
              <a id="black" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="/public/images/admin_add.png" />Add<span class="caret"></span></a>
              <ul class="dropdown-menu">

              <?php if ( in_array('users', $user_tiles) ): ?>
                <li>
                  <a href="/admin/users/add">
                      <img src="/public/images/admin_add_user.png" />Add User
                  </a>
                </li>
              <?php endif; ?>

              <?php if ( in_array('bb', $user_tiles) ): ?>
                <li>
                  <a href="/admin/bb/add">
                      <img src="/public/images/admin_add_bb.png" />Add Bulletin
                  </a>
                </li>
              <?php endif; ?>

              <?php if ( in_array('files', $user_tiles) ): ?>
                <li>
                  <a href="/admin/files/add">
                      <img src="/public/images/admin_add_file.png" />Add File
                  </a>
                </li>
              <?php endif; ?>

              <?php if ( in_array('tests', $user_tiles) ): ?>
                <li>
                  <a href="/admin/tests/add">
                      <img src="/public/images/admin_add_test.png" />Add Test
                  </a>
                </li>
              <?php endif; ?>

              <?php if ( in_array('admins', $user_tiles) ): ?>
                <li>
                  <a href="/admin/admins/add">
                      <img src="/public/images/admin_add_admin.png" />Add Admin
                  </a>
                </li>
              <?php endif; ?>
              
              </ul>
            </li>
        <?php
          endif;
        ?>
            <li class="dropdown">
  	          <a id="black" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="/images/logo.png">
                Hello <?php echo $cfpname; ?><span class="caret"></span></a>
  	          <ul class="dropdown-menu">
  	            <li id="black2"><a href="/login/logout">Logout</a></li>
  	          </ul>
	         </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

<!-- end of-->

<div class="header">
<div class="ub">
<div class="ort">
<div class="fl logoyz"><a href="/"><img src="/images/logoyz.png" /></a></div>
<div class="fr logout"><a href="/login/logout"><img src="/images/logout.png" /></a></div>
<div class="fr hll">Hello <?php echo $cfpname; ?></div>
<div class="t"></div>
</div>
</div>

