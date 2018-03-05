<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<script src="js/genel.js" type="text/javascript"></script>
<script src="js/dashboard.js" type="text/javascript"></script>
<script src="js/jquery-asPieProgress.min.js" type="text/javascript"></script>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,600,300,300italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href="css/genel.css" rel="stylesheet" type="text/css" />
<link href="css/progress.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div class="header">
<? include("header_ub.php"); ?>
<div class="ab">
<div class="ort">
<div class="lnklr">
<a href="" class="scl" ><span><img src="images/ico1.png" /></span>Dashboard</a>
<a href="" class="nrml" ><span><img src="images/ico2.png" /></span>Your Tests</a>
<a href="" class="nrml" ><span><img src="images/ico3.png" /></span>Bulletin Board</a>
<a href="" class="nrml" ><span><img src="images/ico4.png" /></span>File Manager</a>
<div class="t"></div>
</div>
</div>
</div>
<div class="logo"><img src="images/logo.png" /></div>
</div>

<div class="ort">
<div class="tstblm">
<div class="fl stats">
<div class="pie_progress" role="progressbar" data-barcolor="#b11f24" data-trackcolor="#626262" data-barsize="25" ><div class="pie_progress__number">0%</div></div>
</div>
<div class="fl yzlr">
<div class="yzb">Hello John</div>
<div class="yzi">You’ve completed <strong>3</strong> of your <strong>12</strong> mandatory classes!<br />You have <strong>9</strong> more to take. You’d better start signing up!</div>
<a href="" class="rnk" >See Your Tests</a>
</div>
<div class="t"></div>
</div>

<div class="fl slblm">
<div class="krmczg"></div>
<div class="blmubslk">BULLETIN BOARD</div>
<div class="blmabslk">RECENTLY ADDED POSTS</div>
<div class="bbpost">
<a href=""><div class="icn"><img src="images/bbico1.png" class="ico1" /></div><div class="yzlr">2015 End of The Year Company Dinner details have been announced!<br /><span>News / December 12, 2015</span></div></a>
<a href=""><div class="icn"><img src="images/bbico2.png" class="ico2" /></div><div class="yzlr">Say ‘Welcome’ to our newest general manager,<br />Mr. John Doe.<br /><span>News Hires / December 3, 2015</span></div></a>
<a href=""><div class="icn"><img src="images/bbico3.png" class="ico3" /></div><div class="yzlr">Happy Birthday John Doe!<br /><span>News / December 3, 2015</span></div></a>
</div>
<a href="" class="sae rnk" >See All Entries</a>
</div>

<div class="fl sgblm">
<div class="krmczg"></div>
<div class="blmubslk">FILE MANAGER</div>
<div class="blmabslk">RECENTLY ADDED POSTS</div>
<div class="fmpost">
<a href=""><div class="icn"><img src="images/fmico1.png" /></div><div class="yzlr">Extinguisher 01 User Guide.pdf</div></a>
<a href=""><div class="icn"><img src="images/fmico1.png" /></div><div class="yzlr">Extinguisher 02 User Guide.pdf</div></a>
<a href=""><div class="icn"><img src="images/fmico1.png" /></div><div class="yzlr">Extinguisher 03 User Guide.pdf</div></a>
<a href=""><div class="icn"><img src="images/fmico2.png" /></div><div class="yzlr">How to install equipment.mov</div></a>
</div>
<a href="" class="sae rnk" >See All Entries</a>
</div>
<div class="t"></div>

</div>

<? include("footer.php"); ?>
</body>
</html>