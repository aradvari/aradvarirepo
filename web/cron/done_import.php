<?
///// DONE CSV IMPORT

 
require_once ("../config/config.php");
require_once ("../classes/connect.class.php");
require_once ("../classes/functions.class.php");
//require_once ("../classes/phpmailer/class.phpmailer.php");

$db = new connect_db();
//$mail = new PHPMailer();
$func = new functions();

if (!$db->connect(DB_HOST, DB_USER, DB_PW)) die("database connect error: ".$db->error);
if (!$db->select_db(DB_DB)) die("database select error: ".$db->error);

// all
$sql_ffi_vans = "SELECT
		t.id,
		m.markanev, 
		t.termeknev,
		t.szin,
		t.cikkszam,
		t.kisker_ar,
		t.akcios_kisker_ar,
		k.megnevezes,
		t.leiras
		
		FROM termekek t
		
		LEFT JOIN markak m ON m.id=t.markaid
		LEFT JOIN vonalkodok v ON v.id_termek=t.id
		LEFT JOIN kategoriak k ON t.kategoria=k.id_kategoriak
		
		WHERE 
		t.aktiv=1 AND
		t.keszleten>0 AND
		t.markaid <> 121 AND
		v.keszlet_1>0
		
		GROUP BY t.id
		ORDER BY t.id ASC
		
		/*LIMIT 50*/";

$ph = 'id; markanev; termeknev es termekszin; cikkszam; leíras; brutto_kisker_ar; brutto_akcios_kisker_ar'.PHP_EOL;


// all
$query = mysql_query($sql_ffi_vans);

while ($adatok = mysql_fetch_assoc($query))	{

	$adatok['leiras'] = trim(preg_replace('/\s\s+/', ' ', $adatok['leiras']));
	
	//$adatok['kisker_ar'] = ($adatok['kisker_ar']/1.27);
	//$adatok['akcios_kisker_ar'] = ($adatok['akcios_kisker_ar']/1.27);
	
	if(!empty($adatok['szin'])) $adatok['szin']=' '.$adatok['szin'];
	
	$ph .= $adatok['id'].'; "'.$adatok['markanev'].'"; "'.$adatok['termeknev'].''.$adatok['szin'].'"; "'.$adatok['cikkszam'].'"; "'.$adatok['leiras'].'"; "'.$adatok['kisker_ar'].'"; "'.$adatok['akcios_kisker_ar'].'"'.PHP_EOL;
}


$file_handle = fopen("done_import.csv", "w");
$file_contents = $ph;

fwrite($file_handle, $file_contents);
fclose($file_handle);
print "ARUKERESO csv export kesz";





?>