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
$(".bosdv").load("ajax-adminekle.php",function(){$(".adminds").css({left:($(window).width()-$(".adminds").width())/2});});
}
function editadmin(idne){
$(".bosdv").load("ajax-adminduzenle.php?t=edit&bb_id="+idne,function(){$(".adminds").css({left:($(window).width()-$(".adminds").width())/2});});
}
function bbdelete2(idne){
$(".bosdv").load("ajax-adminduzenle.php?t=delete&bb_id="+idne,function(){nwpstkpt();$("#usrid"+idne).remove();});
}