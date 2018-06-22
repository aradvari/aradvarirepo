WOOC
<br /><br />
<?

$query= mysql_query("SELECT *  FROM termekek t 
					LEFT JOIN vonalkodok v ON v.id_termek=t.id
					WHERE /*t.id=4454
					AND*/
					t.aktiv=1 AND 
					v.keszlet_1>0
					ORDER BY v.megnevezes");

while($row = mysql_fetch_array($query))	{
	$i++;
	/*echo $row['megnevezes'].' : '.$row['keszlet_1'];
	echo '<br /><br />';*/
}

echo 'i: '.$i;