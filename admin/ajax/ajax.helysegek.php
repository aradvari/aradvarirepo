<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i: s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-type:text/html; charset=UTF-8");

require_once ("../config/config.php");
require_once ("../classes/connect.class.php");
require_once ("../classes/functions.class.php");

$db = new connect_db();

if (!$db->connect(DB_HOST, DB_USER, DB_PW)) die("adatbázis kapcsolódási hiba: ".$db->error);

if (!$db->select_db(DB_DB)) die("adatbázis választási hiba: ".$db->error);

$func = new functions();

$rows = mysql_num_rows(mysql_query("SELECT * FROM helyseg WHERE id_megye='".(int)$_POST['id_megye']."' ORDER BY helyseg_nev"));

if ($rows>0){

    echo $func->createSelectBox("SELECT * FROM helyseg WHERE id_megye='".(int)$_POST['id_megye']."' ORDER BY helyseg_nev", $_POST['selectedid'], "name=\"".$_POST['selectname']."\"");

}else{

    //echo iconv("utf-8", "iso-8859-2", $_POST['uzenet']);
    
}

?>