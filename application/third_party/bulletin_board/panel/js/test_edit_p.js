$(window).load(function() {

$('input[type="radio"]').ezMark();
$('select').selectric({disableOnMobile:false});

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

$("input[name='test_type']").change(function() {
valne=$(this).val();
if(valne=="Offline"){$(".srlr,.inptgri").css({display:"none"});}
else if(valne=="Online"){$(".srlr,.inptgri").css({display:"block"});}
});

});

function questionekle(){
ynsrid=question_id+1;
$(".srlr").append('<div class="srtk" id="srtk'+ynsrid+'"><div class="fl bslk">QUESTION '+ynsrid+'</div><div class="fr "><a href="javascript:;" onclick="delquestion('+ynsrid+');" class="sae saesr">Delete Question</a></div><div class="fr slct"><select id="basic" name="correct_answer[]"><option value="A" >A</option><option value="B" >B</option><option value="C" >C</option><option value="D" >D</option></select></div><div class="fr ca">Correct Answer :</div><div class="t"></div><div class="frm2"><input type="text" name="srtitle[]" class="bbfrminpt" value="" placeholder="Type Here" /></div><div class="opbslk">OPTIONS</div><div class="frm3"><input type="text" name="optiona[]" class="bbfrminpt" value="" placeholder="Option A" /></div><div class="frm3"><input type="text" name="optionb[]" class="bbfrminpt" value="" placeholder="Option B" /></div><div class="frm3"><input type="text" name="optionc[]" class="bbfrminpt" value="" placeholder="Option C" /></div><div class="frm3"><input type="text" name="optiond[]" class="bbfrminpt" value="" placeholder="Option D" /></div></div>');
$('select').selectric({disableOnMobile:false});

question_id=question_id+1;
}

function delquestion(idne){
$("#srtk"+idne).remove();
}

function publishtest()
{
$.ajax({
type: 'POST',
url :'ajax-testekle-islem-p.php?status=1',
data: $('form#newtest').serialize(),
success: function(answer)
{
location.href = "tests.php";
}
});
}

function savetest()
{
$.ajax({
type: 'POST',
url :'ajax-testekle-islem-p.php?status=0',
data: $('form#newtest').serialize(),
success: function(answer)
{
location.href = "tests.php";
}
});
}

