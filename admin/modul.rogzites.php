<?
if(!empty($_POST['vonalkod']))	{

		// vonalkod check
		
		// listazas
		$q='SELECT * FROM vonalkodok v
			LEFT JOIN termekek t ON v.id_termek=t.id
			LEFT JOIN markak m ON m.id=t.markaid
			WHERE v.vonalkod="'.$_POST['vonalkod'].'"
			';
		
		$res=mysql_query($q);
		
		if(mysql_num_rows($res)<1)	$error="Ismeretlen vonalkód!";
		
		
		// rogzites
		
		/*
		//KÉSZLET CSÖKKENTÉSE
		$sql = "UPDATE vonalkodok SET keszlet_1 = keszlet_1 - ".$reszletek[2]." WHERE vonalkod='".$reszletek[8]."'";
		if (!mysql_query($sql)) $this->error = mysql_error();
		$sql = "UPDATE termekek SET keszleten = keszleten - ".$reszletek[2]." WHERE id=".$reszletek[0];
		if (!mysql_query($sql)) $this->error = mysql_error();
		*/
		
		
		
		
		
}
?>


<div style="padding:40px;">

TERMÉKRÖGZÍTÉS &rsaquo;

<br />
<br />

<form method="post" action="index.php?lap=rogzites">

<font style="vertical-align:middle;font-size:16px;">

	<input type="text" name="db" id="db" style="width:40px;" onClick="input_clear('db');" value=1 /> db / 
	<input type="text" name="vonalkod" id="vonalkod" placeholder="Vonalkód"  autofocus />
	<input type="submit" value="Rögzítés" />
	
	<?
	if(isset($error))
		echo '<br /><br /><font style="color:red;"><b>'.$error.': '.$_POST['vonalkod'].'</b></font><br />';
	?>

</font>
	
</form>

<br />
<br />
RÖGZÍTETT TÉTELEK &rsaquo;
<br />
<br />

<div id="tetelek">

<table>
<tr>
	<td class="darkCell;">Dátum/idő</th>
	<td class="darkCell;">Márka</th>
	<td class="darkCell;">Terméknév</th>
	<td class="darkCell;">Szín</th>
	<td style="text-align:center" class="darkCell;">Méret</th>
	<td style="text-align:center" class="darkCell;">Készlet</th>
</tr>
	<?
	while($row=mysql_fetch_array($res))	{
			echo '<tr>';
				echo '<td><b></b></td>';
				echo '<td><b>'.$row['markanev'].'</b></td>';
				echo '<td><b>'.$row['termeknev'].'</b></td>';
				echo '<td><b>'.$row['szin'].'</b></td>';
				echo '<td style="text-align:center"><b>'.$row['megnevezes'].'</b></td>';
				echo '<td style="text-align:center"><b>'.$row['keszleten'].'</b> db</td>';
			echo '</tr>';
			}
	?>
</table>
</div>  

</div>