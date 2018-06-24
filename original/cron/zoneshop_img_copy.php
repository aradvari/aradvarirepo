<?

echo 'COPY KIKAPCSOLVA';

ini_set('display_errors', '1');

// ZONESHOP IMAGE COPY -> ALLINONE
require_once ("../config/config.php");
require_once ("../classes/connect.class.php");
require_once ("../classes/functions.class.php");

$db = new connect_db();
$func = new functions();

if (!$db->connect(DB_HOST, DB_USER, DB_PW)) die("database connect error: ".$db->error);
if (!$db->select_db(DB_DB)) die("database select error: ".$db->error);

$sql = "SELECT

	v.id_shoprenter,
	t.cikkszam,
	t.id,
	v.vonalkod,
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
	
	/*t.id=7244 AND*/
	
	/*t.markaid=41 AND*/
	/* tkk.id_kategoriak=92 AND	polok*/	
	
	t.aktiv=1 AND
	v.keszlet_1>0
	
	GROUP BY t.id";


$query = mysql_query($sql);

while ($row = mysql_fetch_assoc($query))	{	
		
	// kep konyvtar
	$img = $func->getHDir($row['id']);
		
	$images_directory = '../'.$func->getHDir($row['id']);
	$scanned_directory = scandir($images_directory);	
	
	foreach($scanned_directory as $index=>$image)	{
		if (strpos($image,'_large'))	{			
			
			$from = '../'.$img.$image;		
						
			$image = explode('_', $image);
			
			$to = '../pictures/termekek_all/'.$row['id'].'_'.$image[0].'.jpg';
			
			// kikapcsolva
			/*
			if(copy($from, $to))
				echo 'masolva, ';
			else
				echo 'hiba!<br />';
			
			*/
			
			echo $from.' -> '.$to.'<br /><br />';	
			
			
			}
	}
		
	
	
	//$to = '/termekek_all/
	
	
	
	}


?>