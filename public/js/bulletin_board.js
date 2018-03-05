$(document).ready(function () {

	$('select').selectric({ disableOnMobile : false });

	$container=$(".bbtum").isotope({
	  itemSelector: '.bbtek',
	  layoutMode: 'masonry',
	  masonry: { 
	    isFitWidth: true 
	  }
	});

	$("select[name='category']").change(function() {
	  var selector = $(this).val();
	  $('.bbtum').isotope({ filter:selector });
	  return false;
	});

	$(".bbtek a").hover(
		function() {
			$(this).children('.icn').stop().animate(
				{
					backgroundColor : "#666"
				},
				300
			);
		},
		function() {
			$(this).children('.icn').stop().animate(
				{
					backgroundColor : "#b21f24"
				},
				300
			);
		}
	);

	// When all the images have been downloaded, align the masonry proper
	$(window).on("load", function() {
		$('.bbtum').isotope({ filter:'*' });
	});

});
