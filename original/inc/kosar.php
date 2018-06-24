<table border=0 width=300>

  <tr><th colspan=4>Kosár tartalma</th></tr>
    
  <?

      // KOSÁR EGYSZERŰ ÖSSZESÍTÉSE
      if (ISSET($_SESSION['kosar']))	{

          reset($_SESSION['kosar']);
        
          while($reszletek=each($_SESSION['kosar']))	{
				
              /*echo '
                  <tr>
                    <td><b>'.$reszletek[1][4].'</b></td>
                    <td>'.substr($reszletek[1][5], 0, 12).'</td>
                    <td><b class="alert">'.$reszletek[1][1].'</b></td>
                    <td align="right" width="60">'.number_format($reszletek[1][2] * $reszletek[1][3], 0, '', ' ').'</td>
                  </tr>
                   ';*/		
              
              $kosar_db = $kosar_db + $reszletek[1][2];
			                
              $kosar_fizetendo = $kosar_fizetendo + ( $reszletek[1][3] * $reszletek[1][2] );              
          }
		  
		  echo '<tr><td colspan=3 align="right">'.$kosar_db. ' db termék:</td><td align="right">'.number_format($kosar_fizetendo, 0, '', ' '). ' Ft</td></tr>';
		  
		  //if ($kosar_db>1) $szallitasi_dij = 0;
		  
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
  ?>  
  
  
  <tr>
    <td colspan="3" align="right">Szállítási díj:</td>
    <td align="right"><?=number_format($szallitasi_dij, 0, '', ' ')?> Ft</td>
  </tr>

  <tr>
    <td colspan="3" align="right" style="border-top: 3px double #666;">Összesen fizetendő:</td>
    <td align="right" style="border-top: 3px double #666;"><?=number_format($kosar_fizetendo + $szallitasi_dij, 0, '', ' ')?> Ft</td>
  </tr>
  
  <tr><td colspan="4" style="text-align:center;border:none;"><input type="button" value="Megrendelés" onclick="document.location.href='/megrendeles'" class="submit"></td></tr>
  
  <?
    
      }
	  else
	  {
    
  ?>

  <tr><td colspan="4" align="center">A kosarad üres</td></tr>

  <?
  
      }
  
  ?>
  
</table>