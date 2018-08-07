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

$marka=44;	//DC 40, Vans 41, Fallen 68, Volcom 58, etnies 42, Emerica 44, 
$kategoria=94;	//ffi cipo 94, noi cipo 95
$kat_name="Men Shoes";

$sql = "SELECT
		t.id,
		m.markanev, 
		t.termeknev,
		t.szin,
		t.leiras,
		t.kisker_ar,
		t.akcios_kisker_ar,
		(CASE WHEN t.akcios_kisker_ar>0 THEN t.akcios_kisker_ar ELSE t.kisker_ar END) vegleges_ar
		
		FROM termekek t
		
		LEFT JOIN markak m ON m.id=t.markaid
		LEFT JOIN vonalkodok v ON v.id_termek=t.id
		
		WHERE 
		t.markaid=".$marka." AND
		t.kategoria=".$kategoria." AND
		t.aktiv=1 AND
		v.keszlet_1>0
		
		GROUP BY t.id
		ORDER BY t.markaid,t.id DESC";
		
$query = mysql_query($sql);

$ph = 'Reference;Image URLs;Manufacturer;Name;Category;Final price;Status;'.PHP_EOL;

while ($adatok = mysql_fetch_assoc($query)){

	$img = $func->getHDir($adatok['id']);
	
	$ph.= $adatok['id'].';';
	$ph.= 'http://www.coreshop.hu/'.$img.'1_large.jpg;';
	$ph.= $adatok['markanev'].';';
	$ph.= $adatok['termeknev'].' '.$adatok['szin'].';';
	$ph.= $kat_name.';';
	$ph.= 'EURO;';
	$ph.= '1;'.PHP_EOL;
	
	$_SESSION['markanev']=$adatok['markanev'];
	
}

//print $ph;

$file_handle = fopen("skateboardshoes-import-".date('Ymd')."-".$_SESSION['markanev'].".csv", "w");
$file_contents = $ph;

fwrite($file_handle, $file_contents);
fclose($file_handle);
print "Skateboardshoes csv export kesz";

?>