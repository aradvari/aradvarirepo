<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">

<meta name="HandheldFriendly" content="true" />
<meta name="viewport" content="width=device-width, height=device-height, user-scalable=yes" />

<title>Coreshop -> Zoneshop készlet szinkron</title>

	
<style type="text/css">
<!--
body {background-color:#eee; color:#666; font-weight:bold; font-size:20px; font-family:arial;}

.message { margin:10% auto; width:50%; border:1px solid #666; background-color:#e7e7e7; text-align:center; padding:4% 10%; }
-->
</style>

</head>

<body>
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
$ph ='product.sku,product.alapar,product.szorzo,product.tax_class_id,product.gross_price,product.quantity_2,product.instock_status_id'.PHP_EOL;



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
	t.kisker_ar,
	t.akcios_kisker_ar,
	v.keszlet_1
	
	FROM termekek t
	
	LEFT JOIN markak m ON m.id=t.markaid
	LEFT JOIN vonalkodok v ON v.id_termek=t.id
	LEFT JOIN kategoriak k ON t.kategoria=k.id_kategoriak
	
	WHERE 
	
	v.id_shoprenter IS NOT NULL AND
	
	k.szulo NOT IN (112,127,143,150,159) AND
	
	t.aktiv=1
	
	GROUP BY v.vonalkod
	ORDER BY t.markaid,t.id,v.id_shoprenter ASC";


$query = mysql_query($sql);

while ($row = mysql_fetch_assoc($query))	{
	
	// szulo az mindig az ID_1, de az elso termeknek nincs szulo id-je
	$szulo_check = explode('_', $row['id_shoprenter']);
	//print_r($szulo_check);
	if($szulo_check[1]>1)
		$szulo=$row['id'].'_1';
	else
		$szulo='';
	
	// cikkszam	
	$cikkszam=$row['id_shoprenter'];	
	
	$netto_ar = $row['kisker_ar']/1.27;	
	if(!empty($row['akcios_kisker_ar'])) $akcios_netto_ar = $row['akcios_kisker_ar']/1.27; else	$akcios_netto_ar = 0;	
	
	$ph .= $cikkszam.','.$netto_ar.',1.5,27,'.$row['kisker_ar'].','.$row['keszlet_1'].',1'.PHP_EOL;	
	}


$file_handle = fopen("zoneshop_keszlet_szinkron.csv", "w");
$file_contents = $ph;

fwrite($file_handle, $file_contents);
fclose($file_handle);

//print "Zoneshop keszlet szinkron csv kesz<br /><br />";

echo '<div class="message">Coreshop &rsaquo; Zoneshop<br /><br />Készlet szinkron: kész &#x2714;</div>';

//echo nl2br($ph);
?>

</body>

</html>