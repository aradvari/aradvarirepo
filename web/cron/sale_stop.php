<?
require_once ("../config/config.php");
require_once ("../classes/connect.class.php");
require_once ("../classes/functions.class.php");
//require_once ("../classes/phpmailer/class.phpmailer.php");

$db = new connect_db();
//$mail = new PHPMailer();
$func = new functions();

if (!$db->connect(DB_HOST, DB_USER, DB_PW)) die("database connect error: ".$db->error);
if (!$db->select_db(DB_DB)) die("database select error: ".$db->error);

$sql = "UPDATE termekek_20151028 set akcios_kisker_ar=0, batch=0 WHERE batch=1";
		
mysql_query($sql);