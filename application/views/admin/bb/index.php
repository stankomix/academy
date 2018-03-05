<link href="/css/selectric.css" rel="stylesheet" type="text/css" />

<script src="/js/jquery.selectric.min.js" type="text/javascript"></script>
<script src="/js/isotope.pkgd.min.js" type="text/javascript"></script>
<script src="/js/bulletin_board.js" type="text/javascript"></script>

<div class="ort">

	<div class="fl bbbslk">
		BULLETIN BOARD<span style="color:#b21f24;">(ADMIN)</span>
	</div>


	<div class="fr slct">
		<select id="basic" name="category">
			<option value="*">All</option>
			<option value=".ct1">News</option>
			<option value=".ct2">New Hires</option>
			<option value=".ct3">Birthday</option>
			<option value=".st1">Active</option>
			<option value=".st2">Pending</option>
			<option value=".st0">Deleted</option>
		</select>
	</div>

	<div class="t"></div>

	<div class="bbtum">

		<?php foreach ($bulletins as $bulletin): ?>


			<div class="bbtek ct<?php echo $bulletin->category; ?> st<?php echo $bulletin->status; ?>" style="<?php
							if ($bulletin->status == 0) {
								echo 'background-color: #ddd;';
							} elseif ($bulletin->status == 2){
								echo 'background-color: #faa;';
							}
			?>">

				<a href="/admin/bb/details/<?php echo $bulletin->id; ?>">

					<?php if ($bulletin->small_url): ?>

						<div class="rsm">
							<img src="/<?php echo $bulletin->small_url; ?>" />
						</div>

					<?php endif; ?>

					<div class="icn<?php if ($bulletin->small_url) echo " icnr"; ?>">
						<img src="/images/bbico<?php echo $bulletin->category; ?>.png" class="ico<?php echo $bulletin->category; ?>"/>
					</div>

					<div class="yz">
						<?php echo $bulletin->title; ?>
						<br />
						<span>
							<?php echo $categoryNames[$bulletin->category]; ?> / <?php echo date('F d, Y', strtotime($bulletin->create_date)); ?>
						</span>
					</div>

				</a>
			</div>

		<?php endforeach; ?>

		<div class="t"></div>

	</div>

</div>
