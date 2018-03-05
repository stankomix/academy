tmcvplr=0;
$(window).load(function() {


$('input[type="radio"]').ezMark();

$(":radio").change(function() {
    var names = {};
    $(':radio').each(function() {
        names[$(this).attr('name')] = true;
    });
    var count = 0;
    $.each(names, function() { 
        count++;
    });
    if ($(':radio:checked').length === count) {
        tmcvplr=1;
    }
}).change();

});

function testpost(){
if(tmcvplr==1){
$("body").stop().animate({scrollTop:0},500);
$(".srsnrs").stop().animate({marginLeft:100,opacity:0},750,function(){

$.ajax({
type: 'POST',
url :'ajax-test.php',
data: $('form#bbform').serialize(),
success: function(answer)
{
$(".srsnrs").html(answer);
$(".srsnrs").stop().animate({marginLeft:0,opacity:1},500);
$(".questions").css({display:"none"});
}
});

});
}
}

