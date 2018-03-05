$(window).load(function() {

$(".lnklr a.nrml").hover(
function() {
$( this ).stop().animate({backgroundColor:"#444",boxShadow:"0px 0px 0px 0px"},300);
}, function() {
$( this ).stop().animate({backgroundColor:"transparent",boxShadow:"3px 0px 5px 0px rgba(95, 95, 95, 0.75);"},300);
}
);

$("a.rnk").hover(
function() {
$( this ).stop().animate({backgroundColor:"#666"},300);
}, function() {
$( this ).stop().animate({backgroundColor:"#b21f24"},300);
}
);

});

function hdrmblac(){
$(".hmlnklr").css({display:"block"});
}
function hdrmblkapat(){
$(".hmlnklr").css({display:"none"});
}