<?
ob_start();
mysql_connect ( "localhost", "loovetcfp", "a1@loovetCf" ); 
mysql_query("SET NAMES utf8"); 
mysql_query("SET CHARACTER SET utf8"); 
mysql_query("SET COLLATION_CONNECTION='utf8_general_ci'");
mysql_select_db ("loovetcfp");

ob_end_flush();
?>
