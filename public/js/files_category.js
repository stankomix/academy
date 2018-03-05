$(document).ready(function () {

	$(".dsylr .dsytk a").hover(

		function () {
			$(this).children('.dwn').stop().animate({
				backgroundColor : "#666"
			}, 300);
		},

		function() {
			$(this).children('.dwn').stop().animate({
				backgroundColor : "#b21f24"
			}, 300);
		}
	);

});
