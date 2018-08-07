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

$sql = "SELECT
		t.id,
		m.markanev, 
		t.termeknev,
		t.leiras,
		t.kisker_ar,
		t.akcios_kisker_ar,
		(CASE WHEN t.akcios_kisker_ar>0 THEN t.akcios_kisker_ar ELSE t.kisker_ar END) vegleges_ar
		
		FROM termekek t
		
		LEFT JOIN markak m ON m.id=t.markaid
		LEFT JOIN vonalkodok v ON v.id_termek=t.id
		
		WHERE 
		(t.markaid=40 OR t.markaid=41) AND /* DC 40, VANS 41 */
		(t.kategoria=94 OR t.kategoria=95) AND /* ferfi cipo 94  noi cipo 95*/
		t.aktiv=1 AND
		v.keszlet_1>0
		
		GROUP BY t.id
		ORDER BY t.markaid,t.id DESC";
		
$query = mysql_query($sql);

$ph = 'Cikkszám|Terméknév|Termékleírás|BruttóÁr|Fotólink|Terméklink|SzállításiIdõ|SzállításiKöltség'.PHP_EOL;

while ($adatok = mysql_fetch_assoc($query)){

	$img = $func->getHDir($adatok['id']);
	
	$ph.= $adatok['id'].'|'.
	$adatok['markanev'].' '.$adatok['termeknev'].'|'.$adatok['leiras'].'|'.
	$adatok['vegleges_ar'].'|http://www.coreshop.hu/'.$img.'1_small.jpg|http://www.coreshop.hu/hu/termek/'.$func->convertString($adatok['termeknev']).'/'.$adatok['id'].'|1 munkanap|Ingyenes'.PHP_EOL;

}

//print $ph;

$file_handle = fopen("argep.csv", "w");
$file_contents = $ph;

fwrite($file_handle, $file_contents);
fclose($file_handle);
print "Argep csv export kesz";





?>