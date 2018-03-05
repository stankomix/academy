$(window).load(function() {

$(".inptgri").hover(
function() {
$( this ).stop().animate({backgroundColor:"#b21f24"},300);
}, function() {
$( this ).stop().animate({backgroundColor:"#666"},300);
}
);

$(".inptsbt").hover(
function() {
$( this ).stop().animate({backgroundColor:"#666"},300);
}, function() {
$( this ).stop().animate({backgroundColor:"#b21f24"},300);
}
);

$(".saesr").hover(
function() {
$( this ).stop().animate({backgroundColor:"#b21f24"},300);
}, function() {
$( this ).stop().animate({backgroundColor:"#666"},300);
}
);

});

function edittest()
{
$.ajax({
type: 'POST',
url :'ajax-testedit-islem.php',
data: $('form#newtest').serialize(),
success: function(answer)
{
location.href = "tests.php";
}
});
}