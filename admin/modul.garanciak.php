<?
		
// listazas
$q='SELECT * FROM garancias_hibak gh
	LEFT JOIN felhasznalok f ON f.id=gh.id_felhasznalo
	ORDER BY gh.hiba_id DESC';
$res=mysql_query($q);
		
?>


<div style="padding:20px;">

GARANCIÁLIS HIBÁK &rsaquo;

<br />
<br />

<p><a href="?lap=garancia">+ ÚJ HIBA RÖGZÍTÉSE</a></p>

<?

echo '<table>
		<tr class="darkCell">
		<td style="width:140px;">Bejelentve</td>
		<td>Felhasználó</td>
		<td style="width:140px;">Hibás termék</td>
		<td style="width:140px;">Hibaleírás</td>
		<td style="width:140px;">Megjegyzés</td>
		<td style="width:140px;text-align:center">Státusz</td>
		<td style="width:140px;text-align:center">Eltelt napok</td>
		<td>Lezárva</td>
</tr>';


	while($row=mysql_fetch_array($res))	{
				
			
			if($row['statusz']==1) { $sorstyle='redCell'; $statusz='FOLYAMATBAN';} else { $sorstyle='lightCell'; $statusz='LEZÁRVA'; }
			
			//$eltelt_napok=
			
			if($row['lezarva']!='0000-00-00 00:00:00') $lezarva=$row['lezarva']; else $lezarva='';

			echo '<tr style="height:25px" class="'.$sorstyle.'" onMouseOver="this.className=\'mediumCell\';this.style.cursor=\'hand\'" onMouseOut="this.className=\''.$sorstyle.'\';">';
				
				echo '<td onClick="document.location.href=\'index.php?lap=garancia&id='.$row['id'].'&hiba_id='.$row['hiba_id'].'\'">'.$row['datum'].'</td>';
				echo '<td onClick="document.location.href=\'index.php?lap=garancia&id='.$row['id'].'&hiba_id='.$row['hiba_id'].'\'"><b>'.$row['vezeteknev'].' '.$row['keresztnev'].' '.$row['cegnev'].'</b></td>';
				echo '<td onClick="document.location.href=\'index.php?lap=garancia&id='.$row['id'].'&hiba_id='.$row['hiba_id'].'\'">'.$row['hibas_termek'].' </td>';
				echo '<td onClick="document.location.href=\'index.php?lap=garancia&id='.$row['id'].'&hiba_id='.$row['hiba_id'].'\'">'.$row['hibaleiras'].' </td>';
				echo '<td onClick="document.location.href=\'index.php?lap=garancia&id='.$row['id'].'&hiba_id='.$row['hiba_id'].'\'">'.nl2br($row['megjegyzes']).' </td>';
				echo '<td onClick="document.location.href=\'index.php?lap=garancia&id='.$row['id'].'&hiba_id='.$row['hiba_id'].'\'" style="text-align:center">'.$statusz.'</td>';				
				echo '<td onClick="document.location.href=\'index.php?lap=garancia&id='.$row['id'].'&hiba_id='.$row['hiba_id'].'\'" style="text-align:center">'.$eltelt_napok.'</td>';				
				echo '<td onClick="document.location.href=\'index.php?lap=garancia&id='.$row['id'].'&hiba_id='.$row['hiba_id'].'\'">'.$lezarva.'</td>';				
				
			echo '</tr>';
			}

echo '</table>';

?>

</div>