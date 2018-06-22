<style type="text/css">
<!--
tr:hover {outline:1px solid #999;}
-->
</style>

<table width="100%" border=0 cellspacing="0" cellpadding="5">

<th>Keresések</th>

<tr>
	<td width=5 class="darkCell">ID</td>
	<td width=45 class="darkCell">Keresőszó</td>
	<td width=50 class="darkCell">Találat (db)</td>
	<td width=200 class="darkCell">Dátum</td>
	<td width=200 class="darkCell">IP cím</td>
	<td width=200 class="darkCell">OP rendszer / böngésző</td>
</tr>

<?
$sql = "SELECT * FROM keresendo_log ORDER BY id DESC";
$query = mysql_query($sql);

$cell='darkCell';
while ($adatok = mysql_fetch_array($query)){
	
	if ($cell=='darkCell') $cell='lightCell'; else $cell='darkCell';

	echo '<tr>';
	
	for($i=0; $i<6;$i++)	{
		$style='';
		
		if($i==1) $style='color:blue;';
				
		if($i==5)	{
			$cut=substr($adatok[$i],0,30).'...';
			echo '<td class="'.$cell.'" style="'.$style.'" title="'.$adatok[$i].'">'.$cut.'</td>';
			}
		else
			echo '<td class="'.$cell.'" style="'.$style.'">'.$adatok[$i].'</td>';
		}
		
	echo '</tr>';
}
?>

</table>