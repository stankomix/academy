var ekranheight=$(window).height();
var ekranwidth=$(window).width();
$(window).load(function() {
$(".inptsbt").hover(
function() {
$( this ).stop().animate({backgroundColor:"#666"},300);
}, function() {
$( this ).stop().animate({backgroundColor:"#b21f24"},300);
}
);

$('#email').focus(function() {
$("#lgn1").animate({backgroundColor:"#f0f0f0",borderRadius:"25px",paddingLeft:"18px",height:"51px"},300);
$("#lgn1").css({borderBottom:"0px"});
});
$('#email').focusout(function() {
$("#lgn1").animate({backgroundColor:"transparent",borderRadius:"0px",paddingLeft:"0px",height:"50px"},300);
$("#lgn1").css({borderBottom:"1px solid #dcdcdc"});
emailval=$("#email").val();
if(emailval=="E-Mail Address" || emailval==""){$("#lgnok1").css({display:"none"});$("#lgnok2").css({display:"none"});}
});

$('#pass').focus(function() {
$("#lgn2").animate({backgroundColor:"#f0f0f0",borderRadius:"25px",paddingLeft:"18px",height:"51px"},300);
$("#lgn2").css({borderBottom:"0px"},300);
});
$('#pass').focusout(function() {
$("#lgn2").animate({backgroundColor:"transparent",borderRadius:"0px",paddingLeft:"0px",height:"50px"},300);
$("#lgn2").css({borderBottom:"1px solid #dcdcdc"},300);
});


$( "#email" ).keyup(function() {
emailval=$("#email").val();

if (validateEmail(emailval)) {
$("#lgnok1").css({display:"block"});
$("#lgnok2").css({display:"none"});
}else{
$("#lgnok1").css({display:"none"});
$("#lgnok2").css({display:"block"});
hata="1";
}

});

ekranagore();

});
$(window).resize(ekranagore);

function ekranagore(){
ekranheight=$(window).height();
ekranwidth=$(window).width();

if(ekranwidth<=420){
$(".ubslk").stop().css({fontSize:"4.9vw",lineHeight:"20px"});
$(".abslk").stop().css({fontSize:"3.28vw",lineHeight:"20px"});
$(".inpt,.inptsbt").stop().css({fontSize:"3.28vw"});
$(".pddng").stop().css({padding:"20px 25px"});
$(".lgnlogo").stop().css({width:"66px"});
$(".lgnlogoyz").stop().css({width:"176px"});
}else{
$(".ubslk").stop().css({fontSize:"20px",lineHeight:"24px"});
$(".abslk").stop().css({fontSize:"14px",lineHeight:"24px"});
$(".inpt,.inptsbt").stop().css({fontSize:"14px"});
$(".pddng").stop().css({padding:"35px 40px"});
$(".lgnlogo").stop().css({width:"100px"});
$(".lgnlogoyz").stop().css({width:"267px"});
}
$(".lgnsyf").css({marginTop:(ekranheight-$(".lgnsyf").height())/2});
}

function validateEmail(email) {
var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
return re.test(email);
}