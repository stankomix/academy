<script src="/js/files_category.js" type="text/javascript"></script>

<div class="ort">
	<div class="dtybslk fmbslk">
		<a href="/files">File Manager</a>
		<img src="/images/sagok.png">
		<span>
			<?php echo $category; ?>
		</span>
		<div class="t"></div>
	</div>

	<div class="dtybbslk"><?php echo $category; ?> (<?php echo $files_count; ?>)</div>

	<div class="dsylr">

	<?php foreach($files as $file): ?>

		<div class="dsytk">
			<div class="icnds">
				<div class="icn">
					<img src="/images/fmsico2.png">
				</div>
			</div>
			<div class="di">
				<?php echo $file->title ?>
			</div>
			<div class="db">
				<?php echo $file->file_size ?>
			</div>
			
			<a href="javascript:;" onclick="embeddedContent(<?php echo $file->id; ?>);">
				<div class="dwn" style="background-color: rgb(178, 31, 36);">
					Watch
				</div>
				<div class="downico">
					<img src="/images/downico.png">
				</div>
			</a>
		</div>

	<?php endforeach; ?>

	</div>

</div>
