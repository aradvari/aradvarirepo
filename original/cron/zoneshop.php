<?
// ZONESHOP CSV IMPORT
require_once ("../config/config.php");
require_once ("../classes/connect.class.php");
require_once ("../classes/functions.class.php");

$db = new connect_db();
$func = new functions();

if (!$db->connect(DB_HOST, DB_USER, DB_PW)) die("database connect error: ".$db->error);
if (!$db->select_db(DB_DB)) die("database select error: ".$db->error);


##############
##	SETUP	##

$termekkep_konyvtar = '2017';

##############


// title row !important
$ph ='product.sku,product.model,product.product_ring_id,product.status,product.sort_order,product.manufacturer_id,product_to_category.category_name,product.image,product.image_alt,product_image.image.1,product_image.image.2,product_image.image.3,product_image.image.4,product_image.image.5,product_image.image.6,product_image.image.7,product_image.image.8,product_image.image_alt.1,product_image.image_alt.2,product_image.image_alt.3,product_image.image_alt.4,product_image.image_alt.5,product_image.image_alt.6,product_image.image_alt.7,product_image.image_alt.8,product.alapar,product.szorzo,product.tax_class_id,product.gross_price,product.quantity_2,product.instock_status_id,product.minimum,product.shipping,product.available,product.date_available,product_description.name.hu,product_description.quantity_name.hu,product_description.short_description.hu,product_description.description.hu,product_special.price.1,product.product_class_id,attr_values.meret.hu,attr_values.meret_ruha.hu,attr_values.szin.hu'.PHP_EOL;



/*
Nem listázott kategóriák
112: gördeszka
127: media
143: bmx
150: belga
159: outlet
*/


$sql = "SELECT

	v.id_shoprenter,
	t.cikkszam,
	t.id,
	v.vonalkod,
	v.id_vonalkod,
	m.markanev,
	t.termeknev,
	t.szin,
	t.kisker_ar,
	t.akcios_kisker_ar,
	t.leiras,
	t.szinszuro,
	v.keszlet_1,
	t.kategoria,
	k.megnevezes as kategorianev,
	k.szulo,
	v.megnevezes as attributum
	
	FROM termekek t
	
	LEFT JOIN markak m ON m.id=t.markaid
	LEFT JOIN vonalkodok v ON v.id_termek=t.id
	LEFT JOIN kategoriak k ON t.kategoria=k.id_kategoriak
	LEFT JOIN termek_kategoria_kapcs tkk ON tkk.id_termekek = t.id
	
	WHERE 
	
	v.id_shoprenter IS NOT NULL AND
	
	k.szulo NOT IN (112,127,143,150,159) AND
	
	/*	t.id=4454 AND		*/
	/*	t.markaid=41 AND	*/
	
	/* tkk.id_kategoriak IN (103) AND */
	
	t.aktiv=1 AND
	v.keszlet_1>0
	
	GROUP BY v.vonalkod
	ORDER BY t.markaid,t.id,v.id_shoprenter ASC";


$query = mysql_query($sql);

while ($row = mysql_fetch_assoc($query))	{
	
	// szulo az mindig az ID_1, de az elso termeknek nincs szulo id-je
	$szulo_check = explode('_', $row['id_shoprenter']);
	//print_r($szulo_check);
	if($szulo_check[1]>1)
		$szulo=$row['id'].'_01';
	else
		$szulo='';
	
	// kep konyvtar
	$img = $func->getHDir($adatok['id']);
	
	// cikkszam	
	$cikkszam=$row['id_shoprenter'];	
	
	// Vans Old Skool Black/White
	$termeknev = $row['markanev'].' '.$row['termeknev'].' '.$row['szin'];
	
	// img alt
	$alt = $termeknev;
	
	

	//multi kategoria	
	$multikat_query = mysql_query('SELECT id_kategoriak FROM termek_kategoria_kapcs WHERE id_termekek='.$row['id'].' ORDER BY id_kategoriak');
	
	$kategoria = '';
	$tovabbi_kepek = '';
	while ($multikat_id = mysql_fetch_assoc($multikat_query))	{
		
		// szulo kategorianev
		$alkat_szulo = mysql_fetch_array(mysql_query("SELECT szulo FROM kategoriak WHERE id_kategoriak=".$multikat_id['id_kategoriak']));
		$fokat = mysql_fetch_array(mysql_query("SELECT megnevezes FROM kategoriak WHERE id_kategoriak=".$alkat_szulo[0]));		
		
		// alkat kategorianev
		$alkat = mysql_fetch_array(mysql_query("SELECT megnevezes FROM kategoriak WHERE id_kategoriak=".$multikat_id['id_kategoriak']));
		
		if(!empty($kategoria)) $kategoria .= ';';
		$kategoria .= ucfirst($fokat['megnevezes']).' ||| '.ucfirst($alkat['megnevezes']);
		
		$kategoria = str_replace('Cipő ||| Férfi cipő;','',$kategoria);
		$kategoria = str_replace('Cipő ||| Férfi cipő','',$kategoria);
		$kategoria = str_replace('Cipő ||| Női cipő;','',$kategoria);
		$kategoria = str_replace('Cipő ||| Női cipő','',$kategoria);		
		
		// ferfi- noi cipo
		if($multikat_id['id_kategoriak'] == 94 )	$kategoria .= "Férfi cipő";
		if($multikat_id['id_kategoriak'] == 95 )	$kategoria .= "Női cipő";
		
	}
	
	// meret szetvalasztas -> cipo vagy ruha meret attributum	
	$attributum_meret_cipo = '';
	$attributum_meret_ruha = '';
	
	if ($row['kategoria'] == 94 || $row['kategoria'] == 95 )
		{
		$attributum_meret_cipo = $row['attributum'];	
		$termektipus = 'cipo';
		}
	else
		{
		$attributum_meret_ruha = $row['attributum'];
		$termektipus = 'ruhazat';
		}
	
	//echo 'attr m cipo: ('.$row['kategoria'].') '.$attributum_meret_cipo.'<br />';
	//echo 'attr m ruha: '.$attributum_meret_ruha.'<br />';
 
		
	
	$szinszuro='';
	if($row['szinszuro']=='fekete')	$szinszuro="Fekete";
	if($row['szinszuro']=='feher')	$szinszuro="Feher";
	if($row['szinszuro']=='szurke')	$szinszuro="Szürke";
	if($row['szinszuro']=='kek') 	$szinszuro="Kék";
	if($row['szinszuro']=='zold') 	$szinszuro="Zöld";
	if($row['szinszuro']=='piros') 	$szinszuro="Piros";
	if($row['szinszuro']=='lila') 	$szinszuro="Lila";
	if($row['szinszuro']=='sarga') 	$szinszuro="Sárga";
	if($row['szinszuro']=='barna') 	$szinszuro="Barna";
	if($row['szinszuro']=='multi') 	$szinszuro="Multi";
	
	
	$netto_ar = $row['kisker_ar']/1.27;	
	if(!empty($row['akcios_kisker_ar'])) $akcios_netto_ar = $row['akcios_kisker_ar']/1.27; else	$akcios_netto_ar = 0;
	if(!empty($row['leiras'])) $leiras = $row['leiras']; else	$leiras = 0;
	$leiras = str_replace(',','&#44;',$leiras); // vesszo html karakterrel
	
	// temp
	$rovid_leiras ='';
	
	$leiras = '';
	
	$parameterek = '';
	
	// utolso beszerzes datuma
	$utolso_beszerzes = mysql_fetch_array(mysql_query('SELECT MAX(bekerulesi_datum) FROM keszlet WHERE id_vonalkod='.$row['id_vonalkod']));
	$kaphato = $utolso_beszerzes[0];
	
	
	
	$elso_kep 	   =   'product/'.$termekkep_konyvtar.'/'.$row['id'].'_1.jpg';	
	
	$images_directory = '../'.$func->getHDir($row['id']);
	$scanned_directory = scandir($images_directory);	
	
	foreach($scanned_directory as $index=>$image)	{
		if( ($image!='1_large.jpg') && (strpos($image,'_large')) )	{			
			$image = explode("_", $image);			
			$tovabbi_kepek[] .= 'product/'.$termekkep_konyvtar.'/'.$row['id'].'_'.$image[0].'.jpg';			
			}
	}

	
	//$tovabbi_kepek = substr($tovabbi_kepek, 0, -1);	// utolso vesszo eltavolitasa	

	/*
	product.sku,
	product.model,
	product.product_ring_id,	product.status,
	product.sort_order,
	product.manufacturer_id,
	product_to_category.category_name,
	product.image,
	product.image_alt,
	product_image.image.1,
	product_image.image.2,
	product_image.image.3,
	product_image.image.4,
	product_image.image.5,
	product_image.image.6,
	product_image.image.7,
	product_image.image.8,
	product_image.image_alt.1,
	product_image.image_alt.2,
	product_image.image_alt.3,
	product_image.image_alt.4,
	product_image.image_alt.5,
	product_image.image_alt.6,
	product_image.image_alt.7,
	product_image.image_alt.8,
	product.alapar,
	product.szorzo,
	product.tax_class_id,
	product.gross_price,
	product.quantity_2,
	product.instock_status_id,
	product.minimum,
	product.shipping,
	product.available,
	product.date_available,
	product_description.name.hu,
	product_description.quantity_name.hu,
	product_description.short_description.hu,
	product_description.description.hu,
	product_special.price.1,
	product.product_class_id,
	attr_values.meret.hu,
	attr_values.meret_ruha.hu,
	attr_values.szin.hu
	*/
	
	// a coreshop ID minusszal kerul importra, hogy csokkeno sorrendben jelenjen meg, a legujabb ID-vel elol
	//$ph.=$cikkszam.','.$row['vonalkod'].','.$szulo.',1,-'.$row['id'].','.$row['markanev'].','.$kategoria.','.$elso_kep.','.$termeknev.','.$tovabbi_kepek.',0,0,'.$netto_ar.',1.5,27,'.$row['kisker_ar'].','.$row['keszlet_1'].',0,1,1,1,2017.08.16,'.$termeknev.',db,Rövid leírás,'.$leiras.','.$akcios_netto_ar.',cipo,"'.$attributum_meret_cipo.'","'.$attributum_meret_ruha.'","'.$szinszuro.'"'.PHP_EOL;
	
	$ph.= $cikkszam.','.$row['vonalkod'].','.$szulo.',1,-'.$row['id'].','.$row['markanev'].','.$kategoria.','.$elso_kep.','.$alt.','.$tovabbi_kepek[0].','.$tovabbi_kepek[1].','.$tovabbi_kepek[2].','.$tovabbi_kepek[3].','.$tovabbi_kepek[4].','.$tovabbi_kepek[5].','.$tovabbi_kepek[6].','.$tovabbi_kepek[7].','.$alt.','.$alt.','.$alt.','.$alt.','.$alt.','.$alt.','.$alt.','.$alt.','.$netto_ar.',1.5,27,'.$row['kisker_ar'].','.$row['keszlet_1'].',0,1,1,1,'.$kaphato.','.$termeknev.',db,'.$rovid_leiras.','.$leiras.','.$akcios_netto_ar.','.$termektipus.',"'.$attributum_meret_cipo.'","'.$attributum_meret_ruha.'","'.$szinszuro.'"'.PHP_EOL;
	
	}


$file_handle = fopen("zoneshop.csv", "w");
$file_contents = $ph;

fwrite($file_handle, $file_contents);
fclose($file_handle);
print "Zoneshop csv export kesz<br /><br />";

//echo nl2br($ph);
?>