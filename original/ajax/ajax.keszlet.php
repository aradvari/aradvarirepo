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

if (!$db->connect(DB_HOST, DB_USER, DB_PW)) die("adatb�zis kapcsol�d�si hiba: ".$db->error);

if (!$db->select_db(DB_DB)) die("adatb�zis v�laszt�si hiba: ".$db->error);

$func = new functions();

$db = (int)@mysql_result(@mysql_query("SELECT keszlet_1 FROM vonalkodok WHERE vonalkod='".$_POST['vonalkod']."'"),0);

if ($db>0) {
    
    for ($go=1; $go<=$db; $go++) $dbszam[$go]=(string)$go;
	//echo 'Add meg a mennyis�get<br /><br />'; 
    echo $func->createArraySelectBox_noLang($dbszam, 1, "name=\"mennyiseg\" style=\"margin-top:20px;\"", "Add meg a mennyis�get");
	
	// submit, ha van mennyiseg
	echo '<input type="submit" class="arrow_box" value="Hozz�ad�s a kos�rhoz" />';	
    
}

?>