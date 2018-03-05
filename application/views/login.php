<div class="lgnsyf">
	<div class="lgnlogo"><img src="images/logo.png" /></div>
	<div class="lgnlogoyz"><img src="images/logoyz.png" /></div>
	<div class="lgnbyz">
		<div class="pddng">
			<div class="ubslk">WELCOME TO CFP ACADEMY!</div>
			<div class="abslk">

				<?php if ($failed): ?>

					Failed to log in with that email and password.


				<?php else: ?>

					Enter your information and login to the system.

				<?php endif; ?>

			</div>
			<form method="post" name="loginform" id="loginform" action="login/enter" >
				<div class="lgninpt" id="lgn1">
					<input type="email" name="email" id="email" class="inpt" placeholder="E-Mail Address" />
					<img src="images/lgnok1.png" id="lgnok1" />
					<img src="images/lgnok2.png" id="lgnok2" />
				</div>
				<div class="lgninpt" id="lgn2">
					<input type="password" name="password" id="password" class="inpt" placeholder="Password" />
				</div>
				<div class="lgnbtn">
					<input type="submit" name="submit" id="submit" class="inptsbt" value="LOGIN" action="login" />
				</div>
				<div class="lgnbtn">
				  <div class="centered_text">
				  <a href="/login/recover">Forgot your password?</a>
				  </div>
				</div>
			</form>
		</div>
	</div>
	<div style="width: 25%; margin: auto;">
		<?php //$commit = Helper::getCommit(); ?>
		<a href="https://bitbucket.org/gdly/cfpacademyv1/commits/<?php echo $commit; ?>">
			<font style="color:#cccccc; font-size:10px"><?php echo substr($commit, 0, 7); ?></font>
		</a>
	</div>
</div>
