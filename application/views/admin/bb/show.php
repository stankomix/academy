	<script src="/js/isotope.pkgd.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="/css/jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="/js/jquery.fancybox.pack.js"></script>
<script src="/js/bulletin_detail.js" type="text/javascript"></script>

<?php

	/**
	 * Formats given $date
	 *
	 * @param string $date Date
	 *
	 * @return string
	 */
	function bbDate($date)
	{
		$d = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date);
		return $d->format('F j, Y');
	}

?>

<div class="ort">

	<div class="dtybslk">
		<a href="/admin/bb">Bulletin Board (Admin)</a>
		<img src="/images/sagok.png">
		<span>
			<?php echo $bulletin->title; ?>
		</span>
		<div class="t"></div>
	</div>

	<div class="fl dtysl">

		<div class="fl icn">
			<img src="/images/bbico<?php echo $bulletin->category; ?>.png" class="ico1" />
		</div>

		<div class="fl yzlr">
			<div class="trh">
				<?php echo $categoryNames[$bulletin->category]; ?> / <?php echo date('F d, Y', strtotime($bulletin->create_date)); ?>
			</div>
			<div class="bslk">
				<?php echo $bulletin->title; ?>
			</div>

			<div class="yz <?php if (!$bulletin->small_url) echo "bo0"; ?>">
				<?php echo htmlspecialchars_decode($bulletin->content); ?>
			</div>

			<div class="rsmlr">

				<?php foreach ($bulletin_photos as $bulletin_photo): ?>
	
					<a href="/<?php echo $bulletin_photo->large_url; ?>" class="fancybox" rel="group">
						<img src="/<?php echo $bulletin_photo->small_url; ?>">
					</a>
				<?php endforeach; ?>

			</div>
		</div>

		<?php if ( $is_admin ): ?>
			<div class="edit-btn">
				<a href="/admin/bb/<?php echo $bb_id; ?>/edit">
					<button class="btn btn-danger cfp-red">Edit</button>
				</a>
			</div>

		<?php endif; ?>

		<div class="t"></div>

	</div>

	<div class="fr dtysg">
		<div class="dtysgubslk">BULLETIN BOARD<span style="color:#b21f24;">(ADMIN)</span></div>
		<div class="dtysgabslk">RECENTLY ADDED POSTS</div>
		<div class="dtysgpsts">

		<?php foreach ($bulletins as $recent): ?>

			<a href="/admin/bb/details/<?php echo $recent->id; ?>">
				<div class="icnds">
					<div class="icn">
						<img src="/images/bbico<?php echo $recent->category; ?>.png" class="ico<?php echo $recent->category; ?>" />
					</div>
				</div>
				<div class="yzlr">
					<?php echo $recent->title; ?>
					<br>
					<span><?php echo $categoryNames[$recent->category]; ?> / <?php echo date('F d, Y', strtotime($recent->create_date)); ?></span>
				</div>
			</a>

		<?php endforeach; ?>

		</div>
	</div>

	<div class="t"></div>

</div>
