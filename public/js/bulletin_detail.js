$(document).ready(function () {

	$container=$(".dtysl .yzlr .rsmlr").isotope({
	 	itemSelector: 'a',
		layoutMode: 'masonry',
	  	masonry: { 
	    	isFitWidth: true 
	  	}
	});

	$(".dtysgpsts a").hover(
		function () {
			$(this).children('.icn').stop().animate({ backgroundColor : "#b21f24" }, 300);
		},
		function() {
			$(this).children('.icn').stop().animate({ backgroundColor : "#666" }, 300);
		}
	);

	$(document).ready(function () {
		$(".fancybox").fancybox();
	});

});
