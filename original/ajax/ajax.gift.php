<?
session_start();

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i: s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-type:text/html; charset=UTF-8");

require_once ("../config/config.php");
require_once ("../classes/connect.class.php");
require_once ("../classes/functions.class.php");

if ($_POST['code']!=$_SESSION["giftcard_code"]){

    echo 'ERROR###<font color="red">X</font>';
    
}else{
    
    echo 'SUCCESS###<font color="green">►</font>';
    
}

?>