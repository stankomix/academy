$(document).ready(function () {

	$container=$(".gltum").isotope({
	  itemSelector: '.gltek',
	  layoutMode: 'masonry',
	  masonry: { 
	    isFitWidth: true 
	  }
	});

	$(".fancybox").fancybox();
});
