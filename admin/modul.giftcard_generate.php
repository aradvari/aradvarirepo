<?

$table = 'giftcard';

if (isset($_POST['number']))
{
for($i=0; $i<$_POST['number']; $i++)	{

	$query = "select unix_timestamp( '".date('Y-m-d H:i:s')."')+floor(rand()*31536000)";

	$kod= mysql_fetch_array( mysql_query ( $query ));
	
	/*$query2 = 'INSERT INTO '.$table.' 
					(azonosito_kod, 					
					trid,
					osszeg,
					min_vasarlas_osszeg,
					ervenyes_tol,
					ervenyes_ig,
					kikuldve,
					felado_nev,
					felado_email,
					cimzett_nev,
					cimzett_email,
					uzenet,
					id_felhasznalo,
					id_kuldo,
					fizetve,
					felhasznalva,
					felhasznalt_osszeg,
					id_megrendeles_fej)
				VALUES
					(
					"'.$kod[0].'", 					
					'.$kod[0].',
					2000,
					10000,
					"2013-06-17 00:00:00",
					"2013-06-30 23:59:59",
					"2013-06-17 00:00:00",
					"coreshop",
					"info@coreshop.hu",
					"NULL",
					"",					
					"NULL",
					"",
					"",
					"2013-06-17 00:00:00",
					NULL,
					NULL,
					NULL
					)'; */
		
		$query2 = 'INSERT INTO '.$table.' 
					(azonosito_kod, 					
					trid,
					osszeg,
					min_vasarlas_osszeg,
					ervenyes_tol,
					ervenyes_ig,
					kikuldve,
					felado_nev,
					felado_email,
					cimzett_nev,
					cimzett_email,
					uzenet,
					id_felhasznalo,
					id_kuldo,
					fizetve,
					felhasznalva,
					felhasznalt_osszeg,
					id_megrendeles_fej)
				VALUES
					(
					"'.$kod[0].'", 					
					'.$kod[0].',
					'.$_POST['giftcard_osszeg'].',
					'.$_POST['min_vasarlas_osszeg'].',					
					"'.$_POST['ervenyes_tol'].'",
					"'.$_POST['ervenyes_ig'].'",
					"'.$_POST['ervenyes_tol'].'",
					"coreshop",
					"info@coreshop.hu",
					"NULL",
					"",					
					"NULL",
					"",
					"",
					"'.$_POST['ervenyes_tol'].'",
					NULL,
					NULL,
					NULL
					)';
					
		if (mysql_query($query2))
			$generate++;
			
		//else echo 'SQL hiba';
		
		//echo $query2.'<br /><br />';
	}
	echo '<div style="padding:10px;margin:5px 0;border:1px solid green;color:green;background-color:#ccff99;">Létrehozott Giftcard: <b>'.$generate.'</b> db</div>';
}
?>

<form method="POST" action="">

<br />
<br />
Ezt ne tessék használni :)
<br />gábor<br /><br />

<!-- <br /><br />(SQL tábla: <?=$table;?>)<br /><br />
Generálandó giftcard-ok: <input type="text" name="number" />
<input type="submit" value="Generálás" /> -->

<table>
	<tr>
		<td align="right">Giftcard összeg</td>
		<td><input type="text" name="giftcard_osszeg" /></td>
	</tr>
	
	<tr>
		<td align="right">Minimum vásárlás összeg</td>
		<td><input type="text" name="min_vasarlas_osszeg" /></td>
	</tr>
	
	<tr>
		<td align="right">Érvényes -től</td>
		<td><input type="text" name="ervenyes_tol" value="<?=date('Y-m-d 00:00:00')?>" /></td>
	</tr>
	
	<tr>
		<td align="right">Érvényes -ig</td>
		<td><input type="text" name="ervenyes_ig" value="<?=date('Y-m-d 23:59:59')?>" /></td>
	</tr>
	
	
	<tr>
		<td align="right">Generálandó giftcard-ok</td>
		<td><input type="text" name="number" /></td>
	</tr>
	<tr>
		<td align="center" colspan=2><input type="submit" value="           Generálás           " /></td>
	</tr>
</table>

<?
if(isset($_POST))
	echo '<br /><br />QUERY:<br /><br />
		SELECT * FROM '.$table.' WHERE ervenyes_tol="'.$_POST['ervenyes_tol'].'" AND ervenyes_ig="'.$_POST['ervenyes_ig'].'"';
?>


</form>