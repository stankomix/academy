$(window).load(function() {
$container=$(".fmtum").isotope({
  itemSelector: '.fmtek',
  layoutMode: 'masonry',
  masonry: { 
    isFitWidth: true 
  }
});

$(".fmtek a").hover(
function() {
$( this ).children('.icn').stop().animate({backgroundColor:"#666"},300);
}, function() {
$( this ).children('.icn').stop().animate({backgroundColor:"#b21f24"},300);
}
);

});

function fmekle(idne){
$(".bosdv").load("ajax-fmekle.php?cat="+idne,function(){$(".fmds").css({left:($(window).width()-$(".fmds").width())/2});});
}
function fmpekle(){
$(".bosdv").load("ajax-fmpekle.php",function(){$(".fmds").css({left:($(window).width()-$(".fmds").width())/2});});
}

