$(window).load(function() {

$(".std a").hover(
function() {
$( this ).stop().animate({backgroundColor:"#666"},300);
}, function() {
$( this ).stop().animate({backgroundColor:"#b21f24"},300);
}
);

});

function fmekle(idne){
$(".bosdv").load("ajax-fmekle.php?cat="+idne,function(){$(".fmds").css({left:($(window).width()-$(".fmds").width())/2});});
}
function fmpekle(){
$(".bosdv").load("ajax-fmpekle.php",function(){$(".fmds").css({left:($(window).width()-$(".fmds").width())/2});});
}
function delfile(idne){
$(".bosdv").load("ajax-fmduzenle.php?t=delete&fmid="+idne,function(){
$("#fmtrid"+idne).remove();
});
}
function editfile(idne){
$(".bosdv").load("ajax-fmduzenle.php?fmid="+idne,function(){$(".fmds").css({left:($(window).width()-$(".fmds").width())/2});});
}
function editpfile(idne){
$(".bosdv").load("ajax-fmpduzenle.php?fmid="+idne,function(){$(".fmds").css({left:($(window).width()-$(".fmds").width())/2});});
}
function embdac(idne){
$(".bosdv").load("../ajax-embed.php?id="+idne,function(){$(".embdds").css({left:($(window).width()-$(".embdds").width())/2});});
}