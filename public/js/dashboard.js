$(document).ready(function () {

	$(".fmpost a").hover(
		function() {
			$(this).children('.icn').stop().animate({ backgroundColor:"#dedede"}, 300);
		},
		function() {
			$(this).children('.icn').stop().animate({backgroundColor:"#fafafa"}, 300);
		}
	);

	$(".bbpost a").hover(
		function() {
			$(this).children('.icn').stop().animate({backgroundColor:"#666"}, 300);
		},
		function() {
			$(this).children('.icn').stop().animate({backgroundColor:"#b21f24"}, 300);
		}
	);

	$('.pie_progress').asPieProgress({
		namespace: 'pie_progress',
		speed: 20,
		delay: 300
	});

});
