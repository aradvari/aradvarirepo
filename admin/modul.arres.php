<?
	if(isset($_POST['koltseg']))
		$_SESSION['koltseg']=$_POST['koltseg'];
	else
		$_SESSION['koltseg']=1100000;
?>
	
<form action="" method="POST">
	<table>
		<tr>
			<td align="right">Év</td>
			<td>
				<select name="ev">
					<option value="<?=date('Y');?>"><?=date('Y');?></option>
					<option value="<?=(date('Y')-1);?>"><?=(date('Y')-1);?></option>
					<option value="<?=(date('Y')-2);?>"><?=(date('Y')-2);?></option>
				</select>
				/ Eltelt egész hónap: <input type="text" name="honap" char=2 style="width:40px;" value="<?=date('m')-1;?>" />
			</td>
		</tr>
		<tr>
			<td align="right">Havi költség</td><td><input type="text" name="koltseg" value=<?=$_SESSION['koltseg']?> /> Ft
			</td>
		</tr>
		<tr>
			<td></td><td><input type="submit" value="Lekérdez &rsaquo;">
			</td>
		</tr>
	</table>
</form>

<?

if (!empty($_POST))	{

	echo '<table border=0 cellpadding=10>';

	$honapok = array("01"=>"Január",
	"02"=>"Február",
	"03"=>"Március",
	"04"=>"Április",
	"05"=>"Május",
	"06"=>"Június",
	"07"=>"Július",
	"08"=>"Augusztus",
	"09"=>"Szeptember",
	"10"=>"Október",
	"11"=>"November",
	"12"=>"December");
		
	echo '<tr>
			<td>Hónap</td>
			<td>Bruttó árrés</td>
			<td>Hiány</td>
			<td>FS</a>
			<td>FS költség</td>
			<td>Br árrés - FS</td>
			<td>Br profit</td>
		</tr>';

	foreach ($honapok as $honap=>$honapnev)	{
	
		// ingyenes szallitas
		$free_shipping=mysql_num_rows(mysql_query('SELECT * FROM megrendeles_fej WHERE fizetendo>=10000 AND datum like "'.$_POST['ev'].'-'.$honap.'%" AND id_szallitasi_mod=1 AND id_statusz<>99'));

		echo '<tr>';

		$sql='SELECT sum(bekerulesi_ar) as be, sum(kikerulesi_ar) ki 
		FROM keszlet
		WHERE kikerulesi_datum LIKE "'.$_POST['ev'].'-'.$honap.'%"
		AND kikerulesi_ar>0
		';

		$q = mysql_fetch_assoc(mysql_query($sql));

		$br_arres = $q['ki'] - $q['be'];

		$hiany=0;

		if($br_arres>$_POST['koltseg']) {
			$color='green';	
			$hiany=0;
			}
		else	{
			$color='red';
			$hiany=$_POST['koltseg']-$br_arres;
			}

		echo '<td style="color:'.$color.'">'.$honapnev.'</td>
			<td style="color:'.$color.';text-align:right;">'.number_format($br_arres,0,'',' ').'</td>';

		if ($hiany>0)
			echo '<td style="text-align:right;color:'.$color.'">'.number_format($hiany,0,'', ' ').'</td>';
		else
			echo '<td></td>';
		
		echo '<td style="text-align:right;">'.$free_shipping.' db</td>';
		
		$free_shipping_cost=$free_shipping*990;
		echo '<td style="text-align:right;">'.number_format($free_shipping_cost,0,'', ' ').' Ft</td>';
		
		$br_arres_shipping=$br_arres-$free_shipping_cost;
		if($br_arres_shipping>$_POST['koltseg']) {
			$color='green';	
			}
		else	{
			$color='red';
			}
			
		echo '<td style="text-align:right;color:'.$color.'">'.number_format($br_arres_shipping,0,'', ' ').' Ft</td>';
		
		
		echo '<td style="text-align:right;color:'.$color.'">'.number_format($br_arres_shipping-$_SESSION['koltseg'],0,'', ' ').' Ft</td>';

		$br_ossz=$br_ossz+$br_arres_shipping;
		
		echo '</tr>';
		
	}

	echo '</table>';

	$br_atlag=$br_ossz/$_POST['honap'];

	echo '<br />Havi bruttó átlag árrés: '.number_format($br_atlag,0,'', ' ');

}

?>