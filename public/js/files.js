$(document).ready(function () {

	$container=$(".fmtum").isotope({
	  itemSelector: '.fmtek',
	  layoutMode: 'masonry',
	  masonry: { 
	    isFitWidth: true 
	  }
	});

	$(".fmtek a").hover(
		function() {
			$(this).children('.icn').stop().animate({backgroundColor:"#666"},300);
		},
		function() {
			$(this).children('.icn').stop().animate({backgroundColor:"#b21f24"},300);
		}
	);

});
