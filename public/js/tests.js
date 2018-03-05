$(document).ready(function () {

	$('.pie_progress').asPieProgress({
		namespace: 'pie_progress',
		speed: 20,
		delay: 300
	});

	$(".std a.nrml").hover(
		function() {
			$(this).stop().animate({backgroundColor:"#666"},300);
		},
		function() {
			$(this).stop().animate({backgroundColor:"#b21f24"},300);
		}
	);

	$(".std a.sd").hover(
		function() {
			$(this).stop().animate({backgroundColor:"#b21f24"},300);
		},
		function() {
			$(this).stop().animate({backgroundColor:"#666"},300);
		}
	);

	tstblm(1);

	ekranagore();

});

$(window).resize(ekranagore);

function ekranagore () {
	$('.mtst_gritk').each(function () {
		$(this).children(".b4").children("a").css({ lineHeight : "1px" });
		var heightne = $(this).children(".b1").height();
		$(this).children(".b4").children("a").css({ lineHeight : heightne + "px" });
	});
}

function tstblm (idne) {
	$(".tstler").css({ display : "none" });
	$("#tstler"+idne).css({ display : "block" });

	$(".mtstler").css({ display : "none" });
	$("#mtstler"+idne).css({ display : "block" });

	$(".tsts .scl").removeClass("scl").addClass("nrml");
	$("#blmlnk"+idne).removeClass("nrml").addClass("scl");
}

function rndval (idne) {
	$(".bosdv").load("ajax-randevu.php?id="+idne,function(){$(".rndvds").css({left:($(window).width()-$(".rndvds").width())/2});});
}

function takpt (idne) {
	var displayne = $("#"+idne).css("display");
	if (displayne == "none") {
		$("#"+idne).css({display:"table"});
		$("#"+idne).children(".b4").children("a").css({lineHeight:"1px"});
		var heightne=$("#"+idne).children(".b1").height();
		$("#"+idne).children(".b4").children("a").css({lineHeight:heightne+"px"});
	} else if (displayne == "table") {
		$("#"+idne).css({display:"none"});
	}
}
