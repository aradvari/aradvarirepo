<?
echo '<div class="fixed-kosar" onclick="location.href=\'/'.$_SESSION["langStr"].'/'.$lang->_megrendeles.'\';" style="cursor:pointer;">';

echo '<div class="fixed-kosar-header">Kosár</div>';

// KOSÁR EGYSZERŰ ÖSSZESÍTÉSE
if (ISSET($_SESSION['kosar']))	{

  reset($_SESSION['kosar']);

  $kosar_db=0;
  $kosar_fizetendo=0;
  
  while($reszletek=each($_SESSION['kosar']))	{              
    $kosar_db = $kosar_db + $reszletek[1][2];
	                
    $kosar_fizetendo = $kosar_fizetendo + ( $reszletek[1][3] * $reszletek[1][2] ); 
		
	$directory=$func->getHDir($reszletek[1][0]);
		
		
	echo '<div class="fixed-kosar-item">			
			<img src="/'.$directory.'/1_small.jpg" title="'.$reszletek[1][4].' &middot; '.$reszletek[1][5].' &middot; '.$reszletek[1][1].'  />
			
			<font style="color:#00b0ff; ">'.number_format($reszletek[1][3], 0, '', '.').' Ft</font>';
			
	echo '</div>';
  }
  
// ingyenes szallitas
$ingyenes_szallitas = false;

//KLUB ESETÉN NINCS SZÁLLÍTÁSI KÖLTSÉGE
if ($user->isClubUser()) $ingyenes_szallitas=true;

// INGYENES SZALLITAS MAGYARORSZÁGRA
if ($func->getMainParam("ingyenes_szallitas")>0 && !$user->isForeign())	{
if ($kosar_fizetendo>$func->getMainParam("ingyenes_szallitas"))
$ingyenes_szallitas = true;

// INGYENES SZALLITAS KÜLFÖLDRE
}elseif ($func->getMainParam("ingyenes_szallitas_kulfold")>0 && $user->isForeign())	{
if ($func->toEUR($kosar_fizetendo, true)>$func->getMainParam("ingyenes_szallitas_kulfold"))
$ingyenes_szallitas = true;
}

if (!$user->isForeign()){ //MAGYAR
  $szallitasi_dij = $ingyenes_szallitas?0:(int)$func->getMainParam("szallitasi_dij");
}else{
  $szallitasi_dij = $ingyenes_szallitas?0:$func->toHUF( (int)$func->getMainParam("szallitasi_dij_kulfold"), false );
}

  
  if(!$ingyenes_szallitas)	{
	
	if ($lang->defaultCurrencyId==0) {//MAGYAR	
		$kosar_fizetendo = $kosar_fizetendo + (int)$func->getMainParam("szallitasi_dij");
		echo '<div class="fixed-kosar-item">+ '.ucfirst($lang->szallitasi_dij).'<br />'.(int)$func->getMainParam("szallitasi_dij").' Ft</div>';
		}
	else	{	// KULFOLD
		$kosar_fizetendo_kulfold = $func->toEUR($kosar_fizetendo) + (int)$func->getMainParam("szallitasi_dij_kulfold");
		echo '<div class="fixed-kosar-item">+ '.ucfirst($lang->szallitasi_dij).'<br /> EUR '.(int)$func->getMainParam("szallitasi_dij_kulfold").'</div>';
		}
	}
    
	if ($lang->defaultCurrencyId==0) //MAGYAR		
		echo '<div class="fixed-kosar-item" style="border-top:1px solid #1a3766; margin-bottom:20px;"><br /><b>'.$lang->Osszesen.'</b><br />'.number_format($kosar_fizetendo, 0, '', '.').' Ft</div>';
	
	//else	// KULFOLD
		//echo '<tr><td colspan=4 style="padding:10px 2px; font-size:12px;" align="right">'.$lang->Osszesen.': EUR '.number_format($kosar_fizetendo_kulfold, 2, '.', '.');
	
	echo '<div class="fixed-kosar-item">
	<a href="/'.$_SESSION["langStr"].'/'.$lang->_megrendeles.'" class="arrow_box">'.$lang->megrendeles.'</a>
	</div>'; 
}

echo '</a></div>';
?>