<script src="js/dashboard.js" type="text/javascript"></script>
<script src="js/jquery-asPieProgress.min.js" type="text/javascript"></script>
<script>
	$(document).ready(function () {
		$('.pie_progress').asPieProgress("go","<?php echo $tests->percentage; ?>%");

		<?php

		if ($prompt_turn_in) echo "loadDialog('timecard/submission_form');";

		?>
	});
</script>


<?php // include("header_mobil.php"); ?>

<div class="ort">

	<div class="banner">

		<div class="tstblm fl">

			<div class="greeting-text">
				Hello <?php echo $cfpname; ?>!
			</div>			

			<div class="fl stats">
				<div class="pie_progress" role="progressbar" data-barcolor="#b11f24" data-trackcolor="#626262" data-barsize="25" >
					<div class="pie_progress__number">0%</div>
				</div>
			</div>

			<div class="fl yzlr">

				<div class="yzb">
					Hello <?php echo $cfpname; ?>!
				</div>
				
				<div class="yzi">
					You’ve completed <strong><?php echo $tests->taken; ?></strong> of your <strong><?php echo $tests->mandatory; ?></strong> mandatory classes!
					
					<br />

					<?php if ($tests->remaining): ?>

						You have <strong><?php echo $tests->remaining; ?></strong> more to take. You’d better start signing up!

					<?php endif; ?>

				</div>
				<a href="/tests" class="rnk" >See Your Tests</a>
			</div>

			<div class="t"></div>
		</div>
		
		<div class="fr sgblm perf">
			<div class="krmczg"></div>
			<div class="blmubslk">PERFORMANCE BONUS INDICATOR</div>
			<?php 
unset($bonuses);
unset($bonus_month1);
unset($bonus_month2);
				if ($bonuses): 
			?>
				<div class="perf-indicator">
				<div class="perf-circ">
					<svg height="190" width="190"> <a transform="translate(90,90)">
					    <g>
					      <circle fill="#b21f24" r="82" stroke="#555" stroke-width="8"></circle>
					    </g>
					    <g>
					      <clippath id="g-clip">
					       <rect height="<?php echo (1-$bonuses) * 164;?>" id="g-clip-rect" width="164" x="-82" y="-82">
					       </rect>
					      </clippath>
					      <circle clip-path="url(#g-clip)" fill="#fff" r="78.4"></circle>
					    </g>
					  </a>
					</svg>
				</div>
				<div class="perf-circ-sm">
					<svg height="140" width="140"> <a transform="translate(70,70)">
					    <g>
					      <circle fill="#b21f24" r="65" stroke="#555" stroke-width="5"></circle>
					    </g>
					    <g>
					      <clippath id="g-clip">
					       <rect height="<?php echo (1-$bonuses) * 130;?>" id="g-clip-rect" width="130" x="-65" y="-65">
					       </rect>
					      </clippath>
					      <circle clip-path="url(#g-clip)" fill="#fff" r="63"></circle>
					    </g>
					  </a>
					</svg>
				</div>
				<span><?php echo $bonuses * 100;?>%</span>
			</div>
			<div class="perf-text">
				your progress so far <br> <?php echo $bonuses * 100;?>%, great work, keep it up!
			</div>
			<?php else: ?>
			<div >
				<span>Bonus progress not updated for the current month for display</span>
			</div>
			<?php endif; ?>

			<?php 
				if ($bonus_month1): 
				echo "<p></p><p>Last month: <strong>" . $bonus_month1 * 100 . "%</strong></p>";
			?>
			<?php endif; ?>
			<?php 
				if ($bonus_month2): 
				echo "<p>2 months ago: <strong>" . $bonus_month2 * 100 . "%</strong></p>";
			?>
			<?php endif; ?>
				<i>* work orders may close after end of month (possible increase or decrease)</i>
		</div>

	</div>

<div class="midd">

	<div class="fl slblm">
		<div class="krmczg"></div>
		<div class="blmubslk">BULLETIN BOARD</div>
		<div class="blmabslk">RECENTLY ADDED POSTS</div>

		<div class="bbpost">

			<?php foreach ( $bulletins as $bb ): ?>

				<a href="/bb/details/<?php echo $bb->id; ?>">
					<div class="icnds">
						<div class="icn">
							<img src="images/bbico<?php echo $bb->category; ?>.png" class="ico<?php echo $bb->category; ?>" />
						</div>
					</div>
					<div class="yzlr">
						<?php echo $bb->title; ?>
						<br />
						<span>
							<?php echo $categoryNames[$bb->category]; ?>  / <?php echo date('F d, Y', strtotime($bb->create_date)); ?>
						</span>
					</div>
				</a>

			<?php endforeach; ?>

		</div>

	<div class="bbpost">

		<?php foreach ( $birthdays as $bb ): ?>

			<a href="/bb/details/<?php echo $bb->id; ?>">
				<div class="icnds">
					<div class="icn">
						<img src="images/bbico<?php echo $bb->category; ?>.png" class="ico<?php echo $bb->category; ?>" />
					</div>
				</div>
				<div class="yzlr">
					<?php echo $bb->title; ?>
					<br />
					<span>
						<?php echo $categoryNames[$bb->category]; ?>  / <?php echo date('F d, Y', strtotime($bb->create_date)); ?>
					</span>
				</div>
			</a>

		<?php endforeach; ?>

	</div>

	<a href="bb" class="sae rnk" >See All Entries</a>
	</div>
	<div class="fl sgblm file-m">
		<div class="krmczg"></div>
		<div class="blmubslk">FILE MANAGER</div>
		<div class="blmabslk">RECENTLY ADDED FILES</div>
		<div class="fmpost">
			<?php
			foreach ( $files as $file ):

				if ($file->category == "Handbooks") { $icone = "images/fmsico1.png"; }

				elseif ($file->category == "Videos") { $icone = "images/fmsico2.png"; }

				elseif ($file->category == "Guides") { $icone = "images/fmsico3.png"; }

				elseif ($file->category == "Event Photos") { $icone = "images/fmsico4.png"; }

				elseif ($file->category == "Manuals") { $icone = "images/fmsico5.png";}

				elseif ($file->category == "Other") { $icone = "images/fmsico6.png";}

				if ($file->embed_code != "") {

					$link = " href='javascript:;' onclick='embeddedContent($file->id);' ";

				} else {

					$link = " href='/files/download/" . $file->id . "'";
				}

				if ($file->category == "Event Photos") {
					$link = " href='/files/gallery/" . $file->id."'";
					$kelimene = "View";
				}
			?>
				<a <?php echo $link; ?> >
					<div class="icn">
						<img src="<?php echo $icone; ?>" />
					</div>
					<div class="yzlr">
						<?php echo $file->title; ?>
					</div>
				</a>
			<?php endforeach; ?>

		</div>
		<a href="/files" class="sae rnk" >See All Files</a>
	</div>
</div>

<div class="t">&nbsp;</div>
