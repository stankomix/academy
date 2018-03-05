<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<script src="js/genel.js" type="text/javascript"></script>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,600,300,300italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href="css/landing.css" rel="stylesheet" type="text/css" />
<script>
var ekranheight=$(window).height();
$(window).load(function() {
	
ekranagore();

});
function ekranagore(){
ekranheight=$(window).height();

$(".ort").css({marginTop:((ekranheight-$(".ort").height())/2)-80});
}
$(window).resize(ekranagore);
</script>
</head>
<body>

<div class="lust"><img src="images/lndglogo.png" /></div>
<div class="ort">
<div class="fl lndgk"><a href="index.php"><img src="images/lndg1.png" onmouseover="this.src='images/lndg1h.png';" onmouseout="this.src='images/lndg1.png';" /></a></div>
<div class="fl lndgk"><a href="panel/"><img src="images/lndg2.png" onmouseover="this.src='images/lndg2h.png';" onmouseout="this.src='images/lndg2.png';" /></a></div>
<div class="t"></div>
</div>
<div class="lftr"><img src="images/lndgflogo.png" /></div>
</body>
</html>