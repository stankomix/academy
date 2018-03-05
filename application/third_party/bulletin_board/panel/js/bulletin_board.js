$(window).load(function() {


$container=$(".bbtum").isotope({
  itemSelector: '.bbtek',
  layoutMode: 'masonry',
  masonry: { 
    isFitWidth: true 
  }
});

$(".bbtek a").hover(
function() {
$( this ).children('.fl').stop().animate({backgroundColor:"#b21f24"},300);
}, function() {
$( this ).children('.fl').stop().animate({backgroundColor:"#666"},300);
}
);

});

function bbekle(){
$(".bosdv").load("ajax-bbekle.php",function(){$(".bbeds").css({left:($(window).width()-$(".bbeds").width())/2});});
}
function bbedit(idne){
$(".bosdv").load("ajax-bbduzenle.php?t=edit&bb_id="+idne,function(){$(".bbeds").css({left:($(window).width()-$(".bbeds").width())/2});});
}
function bbdelete1(idne){
$("#bdelete"+idne).attr("onclick","javascript:bbdelete2("+idne+");");
$("#dicn"+idne).html("<img src='images/question.png' style='width:14px;margin-top:6px;'/>");
setTimeout(function(){
$("#bdelete"+idne).attr("onclick","javascript:bbdelete1("+idne+");");
$("#dicn"+idne).html("<img src='images/delete.png' />");
}, 3000);
}
function bbdelete2(idne){
$(".bosdv").load("ajax-bbduzenle.php?t=delete&bb_id="+idne,function(){
$("#bbtek"+idne).remove();
$container=$(".bbtum").isotope({
  itemSelector: '.bbtek',
  layoutMode: 'masonry',
  masonry: { 
    isFitWidth: true 
  }
});

});
}
