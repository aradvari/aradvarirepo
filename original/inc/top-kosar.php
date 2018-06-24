<?

// KOSÁR EGYSZERŰ ÖSSZESÍTÉSE
if (ISSET($_SESSION['kosar']))	{

  reset($_SESSION['kosar']);

  $kosar_db=0;
  $kosar_fizetendo=0;
  
  while($reszletek=each($_SESSION['kosar']))	{              
      $kosar_db = $kosar_db + $reszletek[1][2];
	                
      $kosar_fizetendo = $kosar_fizetendo + ( $reszletek[1][3] * $reszletek[1][2] );              
  }
  
  if ($kosar_db > 0)	{
	//echo '(<a href="/'.$_SESSION["langStr"].'/'.$lang->_megrendeles.'">'.$kosar_db.' '.$lang->db.'</a>)';
	}
  
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

}

if (count($_SESSION['kosar'])>0)	{

    if ($lang->defaultCurrencyId==0){ //MAGYAR
    
    
	/*<a href="/<?=$_SESSION["langStr"]?>/<?=$lang->_megrendeles?>"><?=number_format($kosar_fizetendo, 0, '', '.');?> Ft</a>*/
	echo '<a href="/'.$_SESSION["langStr"].'/'.$lang->_megrendeles.'">'.number_format($kosar_fizetendo, 0, '', '.').' Ft</a>';
	
    }
	
	else{
       
    ?>
	
    <a href="/<?=$_SESSION["langStr"]?>/<?=$lang->_megrendeles?>">€ <?=$func->toEUR($kosar_fizetendo);?></a>

	
    <?
      
    }

}
 else

{
//echo $lang->ures_a_kosarad;
echo '(0)';
}

?>