<?php
header('Content-type: application/xml');

require_once ("config/config.php");
require_once ("classes/connect.class.php");
require_once ("classes/functions.class.php");

$db = new connect_db();
$func = new functions();

if (!$db->connect(DB_HOST, DB_USER, DB_PW)) die("database connect error: ".$db->error);
if (!$db->select_db(DB_DB)) die("database select error: ".$db->error);

// configuration
$url_prefix = 'https://coreshop.hu/hu/';
$blog_timezone = 'UTC';
$timezone_offset = '+00:00';
$W3C_datetime_format_php = 'Y-m-d\Th:i:s'; // See http://www.w3.org/TR/NOTE-datetime
$null_sitemap = '<urlset><url><loc></loc></url></urlset>';

//$max_date = date('2017-11-03 10:01:02');

$header = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$header .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

echo $header;

// main url
echo '<url>
		<loc>https://coreshop.hu</loc>
	</url>';

// statikus oldalak	
$aloldalak = array(
				'vans-old-skool',
				'rolunk',
				'uzletunk',					
				'altalanos-szerzodesi-feltetelek',
				'altalanos-szerzodesi-feltetelek#6a',
				'termekcsere',
				'szallitas',
				'kapcsolat',					
				'instafeed',
				'kartyas-fizetes',
				'kerdesek-valaszok'					
				);
				
foreach($aloldalak as $page)
	echo '<url>
	  <loc>'.$url_prefix.$page.'</loc>
	  <changefreq>monthly</changefreq>
	</url>';
	

// kategoria oldalak	
$kategoriak_query = mysql_query('SELECT k.id_kategoriak, k.megnevezes FROM kategoriak k
								LEFT JOIN termekek t ON t.kategoria = k.id_kategoriak
								WHERE 
								t.keszleten >0 AND
								t.aktiv=1 AND
								k.szulo<>0 AND 
								k.publikus=1 
								GROUP BY k.id_kategoriak 
								ORDER BY k.szulo,k.sorrend');

while($kat = mysql_fetch_array($kategoriak_query))	{

	// alkategoria, osszes marka
	echo '<url>
			<loc>'.$url_prefix.'termekek/'.$func->convertString($kat['megnevezes']).'/'.$func->convertString($kat['id_kategoriak']).'</loc>
			<changefreq>monthly</changefreq>
		</url>';
		
	// alkategoria markakra lebontva
	$kategoria_markak_query = mysql_query('SELECT m.id,m.markanev FROM kategoriak k
								LEFT JOIN termekek t ON t.kategoria = k.id_kategoriak
								LEFT JOIN markak m ON t.markaid = m.id
								LEFT JOIN vonalkodok v ON v.id_termek=t.id
								WHERE 
								t.kategoria='.$kat['id_kategoriak'].' AND
								v.keszlet_1>0 AND
								t.aktiv=1 AND
								k.szulo<>0 AND 
								k.publikus=1 
								GROUP BY m.id
								ORDER BY m.id');
								
		while($kat_marka = mysql_fetch_array($kategoria_markak_query))	{

		echo '<url>
				<loc>'.$url_prefix.'termekek/'.$func->convertString($kat['megnevezes']).'/'.$func->convertString($kat['id_kategoriak']).'/'.strtolower($kat_marka['markanev']).'/'.$kat_marka['id'].'</loc>
				<changefreq>weekly</changefreq>
			</url>';
		}
	
}



// kiemelt termektipus oldalak
$kiemelt_termektipus = array(
				'termekek/ferfi-cipo/94/Vans/41?keresendo=old%20skool',
				'ferfi-cipo/94/Vans/41?keresendo=vans%20rapidweld',
				'ferfi-cipo/94/Vans/41?keresendo=vans%20kyle%20walker',
				'ferfi-cipo/94/Vans/41?keresendo=vans%20gilbert%20crockett',
				'ferfi-cipo/94/Vans/41?keresendo=vans%20tnt',
				'ferfi-cipo/94/Vans/41?keresendo=vans%20sk8-hi',
				'ferfi-cipo/94/Vans/41?keresendo=vans%20iso',
				'ferfi-cipo/94/Vans/41?keresendo=vans%20atwood',
				'ferfi-cipo/94/Vans/41?keresendo=vans%20half%20cab',
				'ferfi-cipo/94/Vans/41?keresendo=vans%20half%20era',
				'ferfi-cipo/94/Vans/41?keresendo=vans%20half%20authentic',
				'ferfi-cipo/94/Vans/41?keresendo=vans%20half%20slip-on',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				);
				
foreach($kiemelt_termektipus as $page)
	echo '<url>
	  <loc>'.$url_prefix.'termekek/'.$page.'</loc>
	  <changefreq>monthly</changefreq>
	</url>';




// termek oldalak
// termek/vans-old-skool/4454
$termek_query = mysql_query('SELECT m.markanev, t.termeknev, t.id FROM termekek t
								LEFT JOIN markak m ON t.markaid = m.id
								LEFT JOIN vonalkodok v ON t.id=v.id_termek
								WHERE t.aktiv=1 AND 
								v.keszlet_1>0
								GROUP BY t.id
								ORDER BY t.id DESC
								');

while($termek = mysql_fetch_array($termek_query))	{
	
	$termek_url_friendly =$termek['markanev'].' '.$termek['termeknev'];
	
	$termek_url_friendly = $func->convertString(strtolower(str_replace(' ', '-', $termek_url_friendly)));
	
	echo '<url>
			<loc>'.$url_prefix.'termek/'.$termek_url_friendly.'/'.$func->convertString($termek['id']).'</loc>
			<changefreq>daily</changefreq>
		</url>';
}


echo '</urlset>';