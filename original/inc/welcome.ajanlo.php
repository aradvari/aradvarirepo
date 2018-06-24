
</div>

<?	

// random 6 cipo
$sql_cipo='
SELECT
m.markanev,
t.termeknev,
t.szin,
t.klub_ar,
t.kisker_ar,
t.akcios_kisker_ar,
t.dealoftheweek,
t.id,
t.opcio,
t.fokep

FROM termekek t

LEFT JOIN markak m ON m.id = t.markaid
LEFT JOIN vonalkodok v ON v.id_termek=t.id

WHERE
t.aktiv=1 AND
t.opcio in ("ZZ_TOP", "UJ") AND
t.kategoria IN (94,95) AND
v.keszlet_1>0

GROUP BY t.id

ORDER BY RAND(), t.opcio DESC

LIMIT 5
';


// random 6 NEM cipo
$sql_nem_cipo='
SELECT
m.markanev,
t.termeknev,
t.szin,
t.klub_ar,
t.kisker_ar,
t.akcios_kisker_ar,
t.dealoftheweek,
t.id,
t.opcio,
t.fokep

FROM termekek t

LEFT JOIN markak m ON m.id = t.markaid
LEFT JOIN vonalkodok v ON v.id_termek=t.id

WHERE
t.aktiv=1 AND
/*t.opcio="ZZ_TOP" AND */
t.opcio="AKCIOS" AND
t.kategoria NOT IN (94,95) AND
v.keszlet_1>0

GROUP BY t.id

ORDER BY RAND()

LIMIT 5
';
  
  
echo '<div class="content-right-headline" style="clear:both;">Legújabb termékek</div>';
//echo '<div class="content-right-headline" style="clear:both;">Chill \'n shop akció Október 15-ig!</div>';

echo '<div class="ajanlo-container">';

echo '<div class="thumbnail-container" style="max-width:1280px;">';	
  
$query = mysql_query($sql_cipo);

while ($arr = mysql_fetch_array($query))	{

	echo $func->thumb($arr['id']);
	
	}	
	
	
?>

</div>