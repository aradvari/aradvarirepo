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

$db = (int)@mysql_result(@mysql_query("SELECT keszlet_1 FROM vonalkodok WHERE vonalkod='".$_POST['vonalkod']."'"),0);

if ($db>0) {
    
    for ($go=1; $go<=$db; $go++) $dbszam[$go]=(string)$go;
	//echo 'Add meg a mennyiséget<br /><br />'; 
    echo $func->createArraySelectBox_noLang($dbszam, 1, "name=\"mennyiseg\" style=\"margin-top:20px;\"", "Add meg a mennyiséget");
	
	// submit, ha van mennyiseg
	echo '<input type="submit" class="arrow_box" value="Hozzáadás a kosárhoz" />';	
    
}

?>