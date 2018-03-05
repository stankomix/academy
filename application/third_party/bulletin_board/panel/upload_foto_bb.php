<?php
session_start();
ob_start();
include ("../mysqlbaglanti/baglan.php");
include('SimpleImage.php');

$aid=$_REQUEST[aid];

if($aid!=""){
if (!empty($_FILES)) {

	$tempFile = $_FILES['Filedata']['tmp_name'];
	$random1=rand(59,591000);
	$random2=rand(59,591000);
	$random3 =time();
	$upfile=$_FILES['Filedata']['name'];
	$filepath = pathinfo($upfile, PATHINFO_EXTENSION);
	$filepath = strtolower($filepath);
	$targetFile = "../photos/59a-$random1$_SESSION[yonuser_id]$random3$random2.$filepath";
	$yenitarget = "../photos/59-$random1$_SESSION[yonuser_id]$random3$random2.$filepath";
	$yenitargetk = "../photos/59-$random1$_SESSION[yonuser_id]$random3$random2-k.$filepath";
	$oldtargt = "59a-$random1$_SESSION[yonuser_id]$random3$random2.$filepath";
	$sqlurl="photos/59-$random1$_SESSION[yonuser_id]$random3$random2.$filepath";
	$sqlurlk="photos/59-$random1$_SESSION[yonuser_id]$random3$random2-k.$filepath";
	if($filepath=="gif" || $filepath=="jpg" || $filepath=="jpeg" || $filepath=="pjpeg" || $filepath=="x-png" || $filepath=="png"){
	move_uploaded_file($tempFile,$targetFile);
	
	
	$max_en=900;
	$max_boy=650;
	$boyut=getimagesize($targetFile);
     $en    = $boyut[0];
     $boy   = $boyut[1];
	 $x_oran = $max_en  / $en; 
     $y_oran = $max_boy / $boy; 

     if (($en <= $max_en) and ($boy <= $max_boy)){ 
        $son_en  = $en; 
        $son_boy = $boy; 
        } 
     else if (($x_oran * $boy) < $max_boy){ 
        $son_en  = $max_en; 
        $son_boy = ceil($x_oran * $boy); 
        } 
     else { 
        $son_en  = ceil($y_oran * $en); 
        $son_boy = $max_boy; 
        }
	$image = new SimpleImage();
    $image->load("$targetFile");
    $image->resize($son_en,$son_boy);
    $image->save("$yenitarget");
	
	$max_en=310;

	$image = new SimpleImage();
    $image->load("$targetFile");
    $image->resizeToWidth($max_en);
    $image->save("$yenitargetk");
	
    $yeniklasor = "../photos";
	chdir($yeniklasor);
	unlink($oldtargt);

	$addsql = "INSERT INTO bb_photos VALUES ('','$aid','$sqlurl','$sqlurlk','','1')";
	mysql_query($addsql);
	
	}
	}
	}
	echo "1";
?>