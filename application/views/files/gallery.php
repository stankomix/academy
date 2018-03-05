<link rel="stylesheet" href="/css/jquery.fancybox.css" type="text/css" media="screen" />
<script src="/js/isotope.pkgd.min.js" type="text/javascript"></script>
<script src="/js/gallery.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/jquery.fancybox.pack.js"></script>

<div class="ort">
	<div class="dtybslk fmbslk">
		<a href="/files">
			File Manager
		</a>
		<img src="/images/sagok.png" />
		<a href="/files/category/photos">
			Event Photos
		</a>
		<img src="/images/sagok.png" />
		<span>
			<?php echo $galleryInformation->title; ?>
		</span>
		<div class="t"></div>
	</div>

	<div class="dtybbslk">
		<?php echo $galleryInformation->title; ?> (<?php echo count($photos) ?>)
	</div>

	<div class="gltum">

		<?php foreach ($photos as $photo): ?>

			<div class="gltek ct" >
				<a href="<?php echo '/' . $photo->large_url; ?>" class="fancybox" rel="group" >
					<img src="<?php echo '/' . $photo->small_url; ?>" />
				</a>
			</div>

		<?php endforeach; ?>

		<div class="t"></div>

	</div>

</div>
