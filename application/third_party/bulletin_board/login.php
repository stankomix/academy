<?PHP
session_start();
ob_start();
include ("mysqlbaglanti/baglan.php");
if($_SESSION['nrmlkullaniciadi']!="")
{ header("Location:index.php");}

include_once 'lib/helper.php';
echo $_SESSION['nrmlkullanici'];
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" id="vpne" content="width=device-width, initial-scale=1,maximum-scale=1">
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<script src="js/login.js" type="text/javascript"></script>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,300&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href="css/genel.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">(function() {var walkme = document.createElement('script'); walkme.type = 'text/javascript'; walkme.async = true; walkme.src = 'https://cdn.walkme.com/users/cfd32f3e794c43c2850e39dd70428743/test/walkme_cfd32f3e794c43c2850e39dd70428743_https.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(walkme, s); window._walkmeConfig = {smartLoad:true}; })();</script>
</head>
<body>

<div class="lgnsyf">
<div class="lgnlogo"><img src="images/logo.png" /></div>
<div class="lgnlogoyz"><img src="images/logoyz.png" /></div>
<div class="lgnbyz">
<div class="pddng">
<div class="ubslk">WELCOME TO CFP ACADEMY!</div>
<div class="abslk">Enter your information and login to the system.</div>
<form method="post" name="loginform" id="loginform" action="login_islem.php" >
<div class="lgninpt" id="lgn1"><input type="email" name="email" id="email" class="inpt" placeholder="E-Mail Address" /><img src="images/lgnok1.png" id="lgnok1" /><img src="images/lgnok2.png" id="lgnok2" /></div>
<div class="lgninpt" id="lgn2"><input type="password" name="password" id="password" class="inpt" placeholder="Password" /></div>
<div class="lgnbtn"><input type="submit" name="submit" id="submit" class="inptsbt" value="LOGIN" action="login_islem.php" /></div>
</form>
</div>
</div>
<div style="width: 25%; margin: auto;">
<?php $commit = Helper::getCommit(); ?>
<a href="https://bitbucket.org/gdly/cfpacademyv1/commits/<?php echo $commit; ?>">
<font style="color:#cccccc; font-size:10px"><?php echo substr($commit, 0, 7); ?></font>
</a>
</div>
</div>
</body>
</html>
