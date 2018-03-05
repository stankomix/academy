$(window).load(function() {

$('.pie_progress').asPieProgress({
namespace: 'pie_progress',
speed: 20,
delay: 300
});

$(".std a").hover(
function() {
$( this ).stop().animate({backgroundColor:"#666"},300);
}, function() {
$( this ).stop().animate({backgroundColor:"#b21f24"},300);
}
);

});
