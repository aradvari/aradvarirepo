<?
$query = mysql_query ('
					SELECT
					t.id,
					v.vonalkod,
					m.markanev,
					t.termeknev,
					t.szin,
					v.megnevezes,
					t.ajanlott_beszerzesi_ar,
					t.viszonteladoi_ar,
					t.kisker_ar,
					t.akcios_kisker_ar,
					k.*
					FROM keszlet k
					LEFT JOIN vonalkodok v ON (v.id_vonalkod = k.id_vonalkod)
					LEFT JOIN leltar_tetel l ON (l.id_vonalkod = v.id_vonalkod)
					LEFT JOIN termekek t ON (v.id_termek = t.id)
					LEFT JOIN markak m ON (m.id = t.markaid)
					WHERE
					v.keszlet_1=0 AND
					v.keszlet_3>0 AND
					t.torolve IS NULL
					GROUP BY v.id_vonalkod');
					
echo '<br />Webshop készlet pótlása nagyker készletről<br /><br />';

echo '<table border="0" cellspacing="1" cellpadding="4">
		<tr>
		  <td class="darkCell" align="center">ID</td>
		  <td class="darkCell" align="center">Márka</td>
		  <td class="darkCell" align="center">Terméknév</td>
		  <td class="darkCell" align="center">Szín</td>
		  <td class="darkCell" align="center">Méret</td>
		  <td class="darkCell" align="center">Nagyker készlet</td>		  
		</tr>';

while ( $row = mysql_fetch_array($query) )	{
	
	if ($sorstyle=='lightCell'){
		
		$sorstyle='darkCell';
		$k1='#c6a4de'; $k2='#99cec6'; $k3='#ccd19d'; $ko='#bc948b';
		
	}else{
		
		$sorstyle='lightCell';
		$k1='#d1c0dd'; $k2='#beddd8'; $k3='#c8cab3'; $ko='#ce998d';
		
	}
	
	$keszlet3 = mysql_fetch_array(mysql_query('select keszlet_3 from vonalkodok where id_vonalkod='.$row['id_vonalkod']));

	echo '<tr style="height:25px" class="'.$sorstyle.'" onMouseOver="this.className=\'selectedCell\';this.style.cursor=\'hand\'" onMouseOut="this.className=\''.$sorstyle.'\';">';
					
	echo	'<td onClick="document.location.href=\'index.php?lap=termek&id='.$row['id'].'\'">'.$row['id'].'</td>
			<td onClick="document.location.href=\'index.php?lap=termek&id='.$row['id'].'\'">'.$row['markanev'].'</td>
			<td onClick="document.location.href=\'index.php?lap=termek&id='.$row['id'].'\'">'.$row['termeknev'].'</td>
			<td onClick="document.location.href=\'index.php?lap=termek&id='.$row['id'].'\'">'.$row['szin'].'</td>
			<td onClick="document.location.href=\'index.php?lap=termek&id='.$row['id'].'\'">'.$row['megnevezes'].'</td>
			<td  onClick="document.location.href=\'index.php?lap=termek&id='.$row['id'].'\'" align="right">'.$keszlet3[0].'</td>
		</tr>';	
}

echo '</table>';