<?
///// ADWORDS CSV IMPORT

 
require_once ("../config/config.php");
require_once ("../classes/connect.class.php");
require_once ("../classes/functions.class.php");
//require_once ("../classes/phpmailer/class.phpmailer.php");

$db = new connect_db();
//$mail = new PHPMailer();
$func = new functions();

if (!$db->connect(DB_HOST, DB_USER, DB_PW)) die("database connect error: ".$db->error);
if (!$db->select_db(DB_DB)) die("database select error: ".$db->error);

// FFI CIPOK
$sql_ffi_cipok = "SELECT
		t.id,
		m.markanev, 
		t.termeknev,
		t.szin,
		k.megnevezes,
		t.kisker_ar,
		t.akcios_kisker_ar,
		t.leiras,
		t.markaid
		
		FROM termekek t
		
		LEFT JOIN markak m ON m.id=t.markaid
		LEFT JOIN vonalkodok v ON v.id_termek=t.id
		LEFT JOIN kategoriak k ON t.kategoria=k.id_kategoriak
		
		WHERE 
		/* t.markaid=41 AND /* Vans */
		t.kategoria=94 AND /*  ferfi cipo */
		t.aktiv=1 AND
		v.keszlet_1>0 AND
		t.kisker_ar>0
		/* AND t.keszleten>5  HA CSAK A NAGYOBB KESZLETU CIPOKET LISTAZZUK */
		
		GROUP BY t.id
		ORDER BY t.markaid,t.id DESC";
		
		


//$ph = 'ID;ID2;Item title;Item subtitle;Item description;Item address;Price;Sale price;Image URL;Destination URL;Item category;Contextual keywords;Final URL'.PHP_EOL;

$ph = 'ID,ID2,Item title,Item subtitle,Item description,Item address,Price,Sale price,Image URL,Destination URL,Item category,Contextual keywords,Final URL'.PHP_EOL;

$query = mysql_query($sql_ffi_cipok);

while ($adatok = mysql_fetch_assoc($query))	{

	$img = $func->getHDir($adatok['id']);
	
	//$termeknev_teljes = $adatok['markanev'].' '.$adatok['termeknev'].'  '.$adatok['szin'];
	$termeknev = $adatok['markanev'].' '.$adatok['termeknev'];
	
	// alapertelmezett subtitle markak szerint - ide kerul a teljes termeknev folytatasa 25 karaktertol
	if($adatok['markaid']==40)  { $item_subtitle = 'DC férfi cipő'; $item_description = 'DC férfi cipők jó áron'; }
	if($adatok['markaid']==41)  { $item_subtitle = 'Vans férfi cipő'; $item_description = 'Vans férfi cipők jó áron'; }
	if($adatok['markaid']==42)  { $item_subtitle = 'Etnies férfi cipő'; $item_description = 'Etnies férfi cipők jó áron'; }
	if($adatok['markaid']==43)  { $item_subtitle = 'éS férfi cipő'; $item_description = 'éS férfi cipők jó áron'; }
	if($adatok['markaid']==44)  { $item_subtitle = 'Emerica férfi cipő'; $item_description = 'Emerica férfi cipők jó áron'; }
	if($adatok['markaid']==58)  { $item_subtitle = 'Volcom férfi cipő'; $item_description = 'Volcom férfi cipők jó áron'; }
	if($adatok['markaid']==68)  { $item_subtitle = 'Fallen férfi cipő'; $item_description = 'Fallen férfi cipők jó áron'; }
	
	if(strlen($termeknev)>25) {		
		$termeknev = substr($termeknev,0,24);	// 25 karakterig
		}
		
	if($adatok['akcios_kisker_ar']>0)
		$akcios_kisker_ar = '"'.$adatok['akcios_kisker_ar'].' HUF"';
	else
		$akcios_kisker_ar = '';
	
	//$ph .= $adatok['id'].';;'.$termeknev.';'.$item_subtitle.';'.$item_description.';1163 Cziráki utca 26-32, Budapest, Hungary, 47.507638, 19.161153;'.$adatok['kisker_ar'].' HUF;'.	$akcios_kisker_ar.';https://coreshop.hu/'.$img.'1_large.jpg;Vans férfi cipő;;https://coreshop.hu/hu/termek/'.$func->convertString($adatok['termeknev']).'/'.$adatok['id'].';'.PHP_EOL;
	
	// csak vesszo
	//$ph .= $adatok['id'].',,'.$termeknev.','.$item_subtitle.','.$item_description.',1163 Cziráki utca 26-32, Budapest, Hungary, 47.507638, 19.161153,'.$adatok['kisker_ar'].' HUF,'.	$akcios_kisker_ar.',https://coreshop.hu/'.$img.'1_large.jpg,Vans férfi cipő,,https://coreshop.hu/hu/termek/'.$func->convertString($adatok['termeknev']).'/'.$adatok['id'].PHP_EOL; */
	
	// idezojel
	//$ph .= '"'.$adatok['id'].'";;"'.$termeknev.'";"'.$item_subtitle.'";"'.$item_description.'";"1163 Cziráki utca 26-32; Budapest; Hungary; 47.507638; 19.161153";"'.$adatok['kisker_ar'].' HUF";"'.	$akcios_kisker_ar.'";"https://coreshop.hu/'.$img.'1_large.jpg";"Vans férfi cipő";;"https://coreshop.hu/hu/termek/'.$func->convertString($adatok['termeknev']).'/'.$adatok['id'].'"'.PHP_EOL;
	
	
	$ph .= $adatok['id'].',,"'.$termeknev.'","'.$item_subtitle.'","'.$item_description.'","1163 Cziráki utca 26-32, Budapest, Hungary, 47.507638, 19.161153","'.$adatok['kisker_ar'].' HUF",'.$akcios_kisker_ar.',"https://coreshop.hu/'.$img.'1_large.jpg",,"'.$item_subtitle.'",,"https://coreshop.hu/hu/termek/'.$func->convertString($adatok['termeknev']).'/'.$adatok['id'].'"'.PHP_EOL;
	
	
}

$file_handle = fopen("adwords.csv", "w");
$file_contents = $ph;

fwrite($file_handle, $file_contents);
fclose($file_handle);
print "ADWORDS csv export kesz";