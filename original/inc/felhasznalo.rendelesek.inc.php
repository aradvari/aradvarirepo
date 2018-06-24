<div class="textbox" style="max-width:79%;">

<div class="login_once">
<p>megrendelések</p>


<?

//echo $_COOKIE['coreShopLoginID'];

$query_rendelesek=mysql_query('SELECT * FROM megrendeles_fej mf WHERE id_felhasznalo='.$_COOKIE['coreShopLoginID'].' AND id_statusz<>99 ORDER BY datum DESC');

while($megrendeles_fej=mysql_fetch_array($query_rendelesek))	{
	echo '<p style="border-bottom:1px dotted #444;">
		Megrendelés száma: '.$megrendeles_fej['megrendeles_szama'].'<br />
		Megrendelé dátuma:'.$megrendeles_fej['datum'].'<br />
		Szállítási cím: '.$megrendeles_fej['szallitasi_irszam'].' '.$megrendeles_fej['szallitasi_varos'].' '.$megrendeles_fej['szallitasi_utcanev'].' '.$megrendeles_fej['szallitasi_kozterulet'].' '.$megrendeles_fej['szallitasi_hazszam'].' '.$megrendeles_fej['szallitasi_emelet'].'<br />';
		
		$query_megrendeles_tetel=mysql_query('SELECT * FROM megrendeles_tetel mt WHERE id_megrendeles_fej='.$megrendeles_fej['id_megrendeles_fej']);
			while($tetel=mysql_fetch_array($query_megrendeles_tetel))	{
				echo '<a href="/'.$func->getHDir($tetel['id_termek']).'/1_large.jpg" class="highslide"" onclick="return hs.expand(this)">
				<img src="/'.$func->getHDir($tetel['id_termek']).'/1_small.jpg" style="width:50px;" /></a>';
			}
		
		
		echo number_format($megrendeles_fej['fizetendo'],'','',' ').' Ft</p>';
		
		//print_r($row);
	}

?>
</div>

</div>