<div class="lgnsyf">
	<div class="lgnlogo"><img src="/images/logo.png" /></div>
	<div class="lgnlogoyz"><img src="/images/logoyz.png" /></div>
	<div class="lgnbyz">
		<div class="pddng">
			<div class="ubslk">WELCOME TO CFP ACADEMY!</div>
			<div class="abslk">
				Enter your email to recover your password.
			</div>
			<form method="post" name="loginform" id="loginform" action="/login/recover" >
				<div class="lgninpt" id="lgn1">
					<input type="email" name="email" id="email" class="inpt" placeholder="E-Mail Address" />
					<img src="/images/lgnok1.png" id="lgnok1" />
					<img src="/images/lgnok2.png" id="lgnok2" />
				</div>
				<div class="lgnbtn">
					<input type="submit" name="submit" id="submit" class="inptsbt" value="SUBMIT" action="recover" />
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


