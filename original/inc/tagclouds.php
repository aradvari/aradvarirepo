<?
// tagcloud - tegfelho :)

echo 'Márkáink: ';

// markak
$table='markak';
$query=mysql_query('SELECT * FROM '.$table.' WHERE sztorno IS NULL ORDER BY RAND() LIMIT 50');

while($row=mysql_fetch_array($query))	{
	echo '<a href="/termekek_uj/ferfi_ruhazat/92">'.$row['markanev'].'</a> ';
	}
	
echo 'Kategóriák: ';

// kategoriak
$table='kategoriak';
$query=mysql_query('SELECT * FROM '.$table.' WHERE publikus=1 ORDER BY RAND() LIMIT 50');

while($row=mysql_fetch_array($query))	{	
	$mit = array("á", "é", "í", "ú", "ü", "ű", "ó", "ö", "ő");
	$mire = array("a", "e", "i", "u", "u", "o", "o", "o", "o");
	$megnevezes=str_replace($mit, $mire, $row['megnevezes']);
	
	echo '<a href="/termekek/'.$megnevezes.'/'.$row['id_kategoriak'].'">'.$row['megnevezes'].'</a> ';
	}

echo 'Termékek: ';
	
// termekek
$table='termekek';
$query=mysql_query('SELECT * FROM '.$table.' INNER JOIN vonalkodok ON termekek.id=vonalkodok.id_termek WHERE vonalkodok.keszlet_1>0 ORDER BY RAND() LIMIT 50');

while($row=mysql_fetch_array($query))	{
	echo '<a href="/termek/'.$row['termeknev'].'/'.$row['id'].'">'.$row['termeknev'].'</a> ';	
	}
?>