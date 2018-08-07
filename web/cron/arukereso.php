<?
///// ARUKERESO CSV IMPORT

 
require_once ("../config/config.php");
require_once ("../classes/connect.class.php");
require_once ("../classes/functions.class.php");
//require_once ("../classes/phpmailer/class.phpmailer.php");

$db = new connect_db();
//$mail = new PHPMailer();
$func = new functions();

if (!$db->connect(DB_HOST, DB_USER, DB_PW)) die("database connect error: ".$db->error);
if (!$db->select_db(DB_DB)) die("database select error: ".$db->error);

// FFI VANS CIPO
$sql_ffi_vans = "SELECT
		t.id,
		m.markanev, 
		t.termeknev,
		t.szin,
		k.megnevezes,
		(CASE WHEN t.akcios_kisker_ar>0 THEN t.akcios_kisker_ar ELSE t.kisker_ar END) brutto_ar,
		t.leiras
		
		FROM termekek t
		
		LEFT JOIN markak m ON m.id=t.markaid
		LEFT JOIN vonalkodok v ON v.id_termek=t.id
		LEFT JOIN kategoriak k ON t.kategoria=k.id_kategoriak
		
		WHERE 
		t.markaid=41 AND /* Vans */
		t.kategoria=94 AND /*  ferfi cipo */
		t.aktiv=1 AND
		v.keszlet_1>0 
		/* AND t.keszleten>0 */
		
		GROUP BY t.id
		ORDER BY t.markaid,t.id DESC";
		
		
// NOI VANS CIPO
$sql_noi_vans = "SELECT
		t.id,
		m.markanev, 
		t.termeknev,
		t.szin,
		k.megnevezes,
		(CASE WHEN t.akcios_kisker_ar>0 THEN t.akcios_kisker_ar ELSE t.kisker_ar END) brutto_ar,
		t.leiras
		
		FROM termekek t
		
		LEFT JOIN markak m ON m.id=t.markaid
		LEFT JOIN vonalkodok v ON v.id_termek=t.id
		LEFT JOIN kategoriak k ON t.kategoria=k.id_kategoriak
		
		WHERE 
		t.markaid=41 AND /* Vans */
		t.kategoria=95 AND /*  noi cipo */
		t.aktiv=1 AND
		v.keszlet_1>0 
		/* AND t.keszleten>3 */
		
		GROUP BY t.id
		ORDER BY t.markaid,t.id DESC";
		
// FFI VANS POLO
$sql_ffi_vans_polo = "SELECT
		t.id,
		m.markanev, 
		t.termeknev,
		t.szin,
		k.megnevezes,
		(CASE WHEN t.akcios_kisker_ar>0 THEN t.akcios_kisker_ar ELSE t.kisker_ar END) brutto_ar,
		t.leiras
		
		FROM termekek t
		
		LEFT JOIN markak m ON m.id=t.markaid
		LEFT JOIN vonalkodok v ON v.id_termek=t.id
		LEFT JOIN kategoriak k ON t.kategoria=k.id_kategoriak
		
		WHERE 
		t.markaid=41 AND /* Vans */
		t.kategoria=92 AND /*  ferfi polo */
		t.aktiv=1 AND
		v.keszlet_1>0 
		/* AND t.keszleten>0 */
		
		GROUP BY t.id
		ORDER BY t.markaid,t.id DESC";
		
		
// NOI VANS POLO
$sql_noi_vans_polo = "SELECT
		t.id,
		m.markanev, 
		t.termeknev,
		t.szin,
		k.megnevezes,
		(CASE WHEN t.akcios_kisker_ar>0 THEN t.akcios_kisker_ar ELSE t.kisker_ar END) brutto_ar,
		t.leiras
		
		FROM termekek t
		
		LEFT JOIN markak m ON m.id=t.markaid
		LEFT JOIN vonalkodok v ON v.id_termek=t.id
		LEFT JOIN kategoriak k ON t.kategoria=k.id_kategoriak
		
		WHERE 
		t.markaid=41 AND /* Vans */
		t.kategoria=116 AND /*  ferfi polo */
		t.aktiv=1 AND
		v.keszlet_1>0 
		/* AND t.keszleten>0 */
		
		GROUP BY t.id
		ORDER BY t.markaid,t.id DESC";
		
// VANS NAPSZEMUVEG
$sql_vans_napszemuveg = "SELECT
		t.id,
		m.markanev, 
		t.termeknev,
		t.szin,
		k.megnevezes,
		(CASE WHEN t.akcios_kisker_ar>0 THEN t.akcios_kisker_ar ELSE t.kisker_ar END) brutto_ar,
		t.leiras
		
		FROM termekek t
		
		LEFT JOIN markak m ON m.id=t.markaid
		LEFT JOIN vonalkodok v ON v.id_termek=t.id
		LEFT JOIN kategoriak k ON t.kategoria=k.id_kategoriak
		
		WHERE 
		t.markaid=41 AND 
		t.kategoria=121 AND /*  napszemuveg */
		t.aktiv=1 AND
		v.keszlet_1>0 
		
		GROUP BY t.id
		ORDER BY t.markaid,t.id DESC";
		
		
// VANS TASKA
$sql_vans_taska = "SELECT
		t.id,
		m.markanev, 
		t.termeknev,
		t.szin,
		k.megnevezes,
		(CASE WHEN t.akcios_kisker_ar>0 THEN t.akcios_kisker_ar ELSE t.kisker_ar END) brutto_ar,
		t.leiras
		
		FROM termekek t
		
		LEFT JOIN markak m ON m.id=t.markaid
		LEFT JOIN vonalkodok v ON v.id_termek=t.id
		LEFT JOIN kategoriak k ON t.kategoria=k.id_kategoriak
		
		WHERE 
		t.markaid=41 AND 
		t.kategoria=110 AND /*  TASKA */
		t.aktiv=1 AND
		v.keszlet_1>0 
		
		GROUP BY t.id
		ORDER BY t.markaid,t.id DESC";
		


$ph = 'identifier,manufacturer,name,category,product_url,image_url,price,net_price,description,delivery_cost,delivery_time	'.PHP_EOL;

// ffi vans cipok
$query = mysql_query($sql_ffi_vans);

while ($adatok = mysql_fetch_assoc($query))	{

	$img = $func->getHDir($adatok['id']);
	
	$ph.= '"'.$adatok['id'].'", "'.$adatok['markanev'].'", "'.$adatok['termeknev'].' - '.$adatok['szin'].'", "Divat és ruházat > Férfi lábbeli > Férfi cipő", "https://coreshop.hu/hu/termek/'.$func->convertString($adatok['termeknev']).'/'.$adatok['id'].'", "https://coreshop.hu/'.$img.'1_large.jpg", "'.$adatok['brutto_ar'].'", "'.round($adatok['brutto_ar']/1.27).'", "'.$adatok['leiras'].'", "ingyenes", "1 munkanap" '.PHP_EOL;
}


// noi vans cipok
$query = mysql_query($sql_noi_vans);

while ($adatok = mysql_fetch_assoc($query))	{

	$img = $func->getHDir($adatok['id']);
	
	$ph.= '"'.$adatok['id'].'", "'.$adatok['markanev'].'", "'.$adatok['termeknev'].' - '.$adatok['szin'].'", "Divat és ruházat > Női lábbeli > női cipő", "https://coreshop.hu/hu/termek/'.$func->convertString($adatok['termeknev']).'/'.$adatok['id'].'", "https://coreshop.hu/'.$img.'1_large.jpg", "'.$adatok['brutto_ar'].'", "'.round($adatok['brutto_ar']/1.27).'", "'.$adatok['leiras'].'", "ingyenes", "1 munkanap" '.PHP_EOL;
}

// ffi vans polok
$query = mysql_query($sql_ffi_vans_polo);

while ($adatok = mysql_fetch_assoc($query))	{

	$img = $func->getHDir($adatok['id']);
	
	$ph.= '"'.$adatok['id'].'", "'.$adatok['markanev'].'", "'.$adatok['termeknev'].' - '.$adatok['szin'].'", "Főoldal > Divat és ruházat > Férfi póló > Vans Férfi póló", "https://coreshop.hu/hu/termek/'.$func->convertString($adatok['termeknev']).'/'.$adatok['id'].'", "https://coreshop.hu/'.$img.'1_large.jpg", "'.$adatok['brutto_ar'].'", "'.round($adatok['brutto_ar']/1.27).'", "'.$adatok['leiras'].'", "ingyenes", "1 munkanap" '.PHP_EOL;
}

// noi vans polok
$query = mysql_query($sql_noi_vans_polo);

while ($adatok = mysql_fetch_assoc($query))	{

	$img = $func->getHDir($adatok['id']);
	
	$ph.= '"'.$adatok['id'].'", "'.$adatok['markanev'].'", "'.$adatok['termeknev'].' - '.$adatok['szin'].'", "Főoldal > Divat és ruházat > Női póló > Vans Női póló", "https://coreshop.hu/hu/termek/'.$func->convertString($adatok['termeknev']).'/'.$adatok['id'].'", "https://coreshop.hu/'.$img.'1_large.jpg", "'.$adatok['brutto_ar'].'", "'.round($adatok['brutto_ar']/1.27).'", "'.$adatok['leiras'].'", "ingyenes", "1 munkanap" '.PHP_EOL;
}


// vans napszemuvegek
$query = mysql_query($sql_vans_napszemuveg);

while ($adatok = mysql_fetch_assoc($query))	{

	$img = $func->getHDir($adatok['id']);
	
	$ph.= '"'.$adatok['id'].'", "'.$adatok['markanev'].'", "'.$adatok['termeknev'].' - '.$adatok['szin'].'", "Főoldal > Divat és ruházat > Napszemüveg > Unisex napszemüveg > Vans Unisex napszemüveg", "https://coreshop.hu/hu/termek/'.$func->convertString($adatok['termeknev']).'/'.$adatok['id'].'", "https://coreshop.hu/'.$img.'1_large.jpg", "'.$adatok['brutto_ar'].'", "'.round($adatok['brutto_ar']/1.27).'", "'.$adatok['leiras'].'", "ingyenes", "1 munkanap" '.PHP_EOL;
}


// vans taska
$query = mysql_query($sql_vans_taska);

while ($adatok = mysql_fetch_assoc($query))	{

	$img = $func->getHDir($adatok['id']);
	
	$ph.= '"'.$adatok['id'].'", "'.$adatok['markanev'].'", "'.$adatok['termeknev'].' - '.$adatok['szin'].'", " Főoldal > Divat és ruházat > Hátizsák > Vans Hátizsák", "https://coreshop.hu/hu/termek/'.$func->convertString($adatok['termeknev']).'/'.$adatok['id'].'", "https://coreshop.hu/'.$img.'1_large.jpg", "'.$adatok['brutto_ar'].'", "'.round($adatok['brutto_ar']/1.27).'", "'.$adatok['leiras'].'", "ingyenes", "1 munkanap" '.PHP_EOL;
}


$file_handle = fopen("arukereso.csv", "w");
$file_contents = $ph;

fwrite($file_handle, $file_contents);
fclose($file_handle);
print "ARUKERESO csv export kesz";





?>