<link href="/css/selectric.css" rel="stylesheet" type="text/css" />

<script src="/js/jquery.selectric.min.js" type="text/javascript"></script>
<script src="/js/isotope.pkgd.min.js" type="text/javascript"></script>
<script src="/js/bulletin_board.js" type="text/javascript"></script>

<div class="ort">

	<div class="fl bbbslk">
		BULLETIN BOARD
	</div>

	<div class="fr slct">
		<select id="basic" name="category">
			<option value="*">All</option>
			<option value=".ct1">News</option>
			<option value=".ct2">New Hires</option>
			<option value=".ct3">Birthday</option>
		</select>
	</div>

	<div class="t"></div>

	<div class="bbtum">

		<?php foreach ($bulletins as $bulletin): ?>

			<div class="bbtek ct<?php echo $bulletin->category; ?>" >
				<a href="/bb/details/<?php echo $bulletin->id; ?>">

					<?php if ($bulletin->small_url): ?>

						<div class="rsm">
							<img src="/<?php echo $bulletin->small_url; ?>" />
						</div>

					<?php endif; ?>

					<div class="icn<?php if ($bulletin->small_url) echo " icnr"; ?>">
						<img src="images/bbico<?php echo $bulletin->category; ?>.png" class="ico<?php echo $bulletin->category; ?>"/>
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
