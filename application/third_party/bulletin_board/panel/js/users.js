$(window).load(function() {

$(".std a").hover(
function() {
$( this ).stop().animate({backgroundColor:"#666"},300);
}, function() {
$( this ).stop().animate({backgroundColor:"#b21f24"},300);
}
);

usrsekgore();

});
$(window).resize(usrsekgore);

function usrsekgore(){
$('.mtst_gritk').each(function() {
$(this).children(".b4").children("a").css({lineHeight:"1px"});
var heightne=$(this).children(".b1").height();
$(this).children(".b4").children("a").css({lineHeight:heightne+"px"});
});

}

function uekle(){
$(".bosdv").load("ajax-userekle.php",function(){$(".usrds").css({left:($(window).width()-$(".usrds").width())/2});});
}
function edituser(idne){
$(".bosdv").load("ajax-userduzenle.php?t=edit&bb_id="+idne,function(){$(".usrds").css({left:($(window).width()-$(".usrds").width())/2});});
}
function bbdelete2(idne){
$(".bosdv").load("ajax-userduzenle.php?t=delete&bb_id="+idne,function(){nwpstkpt();$("#usrid"+idne).remove();});
}

function takpt(idne){
var displayne=$("#"+idne).css("display");
if(displayne=="none"){
$("#"+idne).css({display:"table"});
$("#"+idne).children(".b4").children("a").css({lineHeight:"1px"});
var heightne=$("#"+idne).children(".b1").height();
$("#"+idne).children(".b4").children("a").css({lineHeight:heightne+"px"});
}else if(displayne=="table"){
$("#"+idne).css({display:"none"});
}
}