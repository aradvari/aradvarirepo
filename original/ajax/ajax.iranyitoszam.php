<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i: s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-type:text/html; charset=ISO-8859-2");

require_once ("../config/config.php");
require_once ("../classes/connect.class.php");
require_once ("../classes/functions.class.php");

$db = new connect_db();

if (!$db->connect(DB_HOST, DB_USER, DB_PW)) die("adatbázis kapcsolódási hiba: ".$db->error);

if (!$db->select_db(DB_DB)) die("adatbázis választási hiba: ".$db->error);

$func = new functions();

if ((int)$_POST['iszam'][0]==1) $_POST['iszam']='1011';
$hely = @mysql_fetch_array(@mysql_query("SELECT id_helyseg, id_megye FROM helyseg WHERE iranyitoszam='".(int)$_POST['iszam']."'"));

echo $hely['id_megye']."#".$hely['id_helyseg'];

?>