<script>
	var iframeheight = $(".bbfmaln iframe").attr("height");
	var iframewidth = $(".bbfmaln iframe").attr("width");
	var embedwidth = $(".embdds").width();
	var heightne=0;

	$(document).ready(function() {
		$(".tklmaln").css({
			width : $("body").width(),
			height : $("body").height()
		});

		$(".tklmaln").click(function () {
			nwpstkpt();
		});

		embedegore();
	});

	$(window).resize(embedegore);

	function embedegore () {
		$(".bosdv,.tklmaln").css({width:"100%"});
		$(".embdds").css({
			left : ($(window).width() - $(".embdds").width()) / 2,
			top: $(window).scrollTop() + 10
		});

		iframeheight = $(".bbfmaln iframe").attr("height");
		iframewidth = $(".bbfmaln iframe").attr("width");
		embedwidth = $(".embdds").width();

		heightne = (embedwidth * iframeheight) / iframewidth;
		$(".bbfmaln iframe").css({
			width : "100%",
			height : heightne
		});
	}

	function nwpstkpt () {
		$(".bosdv").css({
			width : "auto"
		});
		$(".bosdv").html("");
	}

</script>

<div class="tklmaln"></div>
<div class="embdds">
	<div class="bslk">
		<?php echo $file->title; ?>
	</div>
	<div class="bbfmaln">
		<?php echo htmlspecialchars_decode($file->embed_code); ?>
	</div>
</div>
