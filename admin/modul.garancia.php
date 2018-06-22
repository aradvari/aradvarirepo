<?
//error_reporting(E_ALL); ini_set('display_errors', 'On'); 


//felhasznalo kereses
if(!empty($_POST['keres']))	{

		$q='SELECT * FROM felhasznalok f
			WHERE CONCAT(f.vezeteknev," ",f.keresztnev," ",f.cegnev) LIKE "%'.$_POST['keres'].'%" OR
			email LIKE "%'.$_POST['keres'].'%" OR
			telefonszam1 LIKE "%'.$_POST['keres'].'%" OR
			telefonszam2 LIKE "%'.$_POST['keres'].'%"
			ORDER BY f.id DESC';
		
		$res=mysql_query($q);
		
		if(mysql_num_rows($res)<1)	$error="Ismeretlen felhasználó!";
		
}


//mentes
if( (!empty($_POST['termeknev'])) || (!empty($_POST['hiba'])) || (!empty($_POST['megjegyzes'])) )	{
	
	// update
	if (!empty($_GET['hiba_id']))	{
		
		if($_POST['statusz']==2) $statusz=', statusz='.$_POST['statusz'].', lezarva="'.date('Y-m-d H:i:s').'"'; else $statusz='' ;
		
		$q='UPDATE garancias_hibak SET hibas_termek="'.$_POST['termeknev'].'", hibaleiras="'.$_POST['hiba'].'", megjegyzes="'.$_POST['megjegyzes'].'" '.$statusz.' WHERE hiba_id='.$_GET['hiba_id'];
		
		mysql_query($q);		
	}
	
	// insert
	else	{
		
		$datetime=date('Y-m-d H:i:s');
		
		mysql_query('INSERT INTO garancias_hibak 
					(datum, id_felhasznalo, hibas_termek, hibaleiras, megjegyzes, statusz)
					VALUES
					("'.$datetime.'", '.$_GET['id'].', "'.$_POST['termeknev'].'", "'.$_POST['hiba'].'", "'.$_POST['megjegyzes'].'", 1 )');	 			
		
	}

echo 'header loc';
header("Location: index.php?lap=garanciak");

}
?>


<div style="padding:20px;">

GARANCIÁLIS HIBARÖGZÍTÉS &rsaquo;

<br />
<br />

<?

if(!isset($_GET['id']))	{


echo '<form method="post" action="index.php?lap=garancia">

<font style="vertical-align:middle;font-size:16px;">

	<input type="text" name="keres" id="keres" style="width:300px" placeholder="Keresés (név, e-mail, telefon)"  autofocus />
	<input type="submit" value="Felhasználó keresése" />';	
		
	if(isset($_POST['keres']))	{
	
	$talalatok=mysql_num_rows($res);
	
	if($talalatok==0)	echo '<p style="color:red;">Nincs találat! (<b><i>'.$_POST['keres'].'</i></b>)</p>';
	
	if($talalatok>30)	echo '<p style="color:red;">A keresés túl sok találatok eredményezett ('.$talalatok.' találat)! Pontosítsd a keresőszót.</p>';
	
	if( ($talalatok<=30) && ($talalatok>0)) {
		echo '
			<p style="color:green;">Válaszd ki a felhasználót ('.$talalatok.' találat) &rsaquo;</p>


			<table class="darkCell">
			<tr>
				<td>ID</th>
				<td>Név</th>
				<td>E-mail</th>
				<td>Cím</th>
				<td>Telefonszám</th>
			</tr>';
	
	while($row=mysql_fetch_array($res))	{
				
			$sorstyle=='lightCell'?$sorstyle='darkCell':$sorstyle='lightCell';

			echo '<tr style="height:25px" class="'.$sorstyle.'" onMouseOver="this.className=\'mediumCell\';this.style.cursor=\'hand\'" onMouseOut="this.className=\''.$sorstyle.'\';">';
				
				echo '<td onClick="document.location.href=\'index.php?lap=garancia&id='.$row['id'].'\'">'.$row['id'].'</td>';
				echo '<td onClick="document.location.href=\'index.php?lap=garancia&id='.$row['id'].'\'"><b>'.$row['vezeteknev'].' '.$row['keresztnev'].' '.$row['cegnev'].'</b></td>';
				echo '<td onClick="document.location.href=\'index.php?lap=garancia&id='.$row['id'].'\'">'.$row['email'].'</td>';
				echo '<td onClick="document.location.href=\'index.php?lap=garancia&id='.$row['id'].'\'">'.$row['irszam'].' '.$row['varos_nev'].', '.$row['utcanev'].' '.$row['kozteruletnev'].' '.$row['hazszam'].' '.$row['emelet'].'</td>';
				echo '<td onClick="document.location.href=\'index.php?lap=garancia&id='.$row['id'].'\'">'.$row['telefonszam1'].' '.$row['telefonszam2'].'</td>';
				
			echo '</tr>';
			}
	}
	
echo '</table>';
	}
	
	
echo '</font>
	
</form>';

}

elseif (isset($_GET['id']))	{


	// listazas
	$q='SELECT * FROM felhasznalok f WHERE f.id = '.$_GET['id'];
	$row=mysql_fetch_array(mysql_query($q));
	
	//hiba_id
if (!empty($_GET['hiba_id']))	{
	$q2='SELECT * FROM garancias_hibak WHERE hiba_id='.$_GET['hiba_id'];
	$hiba=mysql_fetch_array(mysql_query($q2));
}
	
	if(isset($hiba['datum'])) $date=$hiba['datum']; else $date=date('Y-m-d H:i:s');
	
	echo '
			<form action="" method="POST" />
			<table>
			<tr><td class="darkCell">Dátum:</td><td class="lightCell">'.$date.'</td></tr>';
	
	echo '	<tr><td valign="top" class="darkCell">Felhasználó:</td>';
			
	
	$tel1 = substr_replace($row['telefonszam1'], ' ', 10, 0);
	$tel2 = substr_replace($row['telefonszam2'], ' ', 10, 0);
	
	echo '<td valign="top" class="lightCell"><b>'.$row['vezeteknev'].' '.$row['keresztnev'].'</b>
			<br />
			'.$row['email'].'
			<br />
			<br />
			'.$row['irszam'].' '.$row['varos_nev'].', '.$row['utcanev'].' '.$row['kozteruletnev'].' '.$row['hazszam'].' '.$row['emelet'].'
			<br />
			<br />
			'.$tel1.' '.$tel2.'</td>
		</tr>';
		
	echo '<tr><td class="darkCell">Hibás termék:</td><td><input type="text" placeholder="Márka, terméknév, méret" name="termeknev" value="'.$hiba['hibas_termek'].'"  style="width:300px;"/></td></tr>';
	
	echo '<tr><td class="darkCell">Hiba:</td><td><input type="text" placeholder="Rövid hibaleírás" value="'.$hiba['hibaleiras'].'" name="hiba"  style="width:300px;"/></td></tr>';
	
	echo '<tr><td class="darkCell">Megjegyzés:</td><td><textarea name="megjegyzes" style="width:300px; height:200px;" />'.$hiba['megjegyzes'].'</textarea></td></tr>';
	
	if($hiba['statusz']!=2)	
		echo '<tr><td class="darkCell">Státusz:</td><td>
				<select name="statusz">
					<option value=1>ÚJ</option>
					<option value=2>LEZÁRT</option>
				</select>
		</td></tr>';
	
	echo '<tr><td class="darkCell" colspan=2 align="center"><input type="submit" style="width:100%" value="           Mentés           " /></td></tr>';
	
	echo '</table>
		</form>';
}


?>

</div>