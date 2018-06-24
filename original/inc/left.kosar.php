<?

      // KOSÁR EGYSZERŰ ÖSSZESÍTÉSE
      /*if (ISSET($_SESSION['kosar'])){
          
          $ingyenes_szallitas = false;
	

          //KLUB ESETÉN NINCS SZÁLLÍTÁSI KÖLTSÉGE
          if ($user->isClubUser()) $ingyenes_szallitas=true;
		  
          $szallitasi_dij = $ingyenes_szallitas?0:(int)$func->getMainParam("szallitasi_dij");

          reset($_SESSION['kosar']);
        
          while($reszletek=each($_SESSION['kosar'])){
          
              echo '
                  <tr>
                    <td><b>'.$reszletek[1][4].'</b></td>
                    <td>'.substr($reszletek[1][5], 0, 100).'</td>
                    <td><b class="alert">'.$reszletek[1][1].'</b></td>
                    <td align="right" width="60">'.number_format($reszletek[1][2] * $reszletek[1][3], 0, '', '.').',-</td>
                  </tr>
                   ';
              
              $kosar_db = $kosar_db + $reszletek[1][2];
              
              $kosar_fizetendo = $kosar_fizetendo + ( $reszletek[1][3] * $reszletek[1][2] );
              
          }
      
      }
	  */
	  
	  
	  
	  if (ISSET($_SESSION['kosar']))	{

          reset($_SESSION['kosar']);
        
          while($reszletek=each($_SESSION['kosar'])){
          
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
		  
		  echo $kosar_db.' / ';
		  echo number_format($kosar_fizetendo, 0, '', '.').' Ft';
		  
		  $ingyenes_szallitas = false;
          
		  // KLUB ESETÉN NINCS SZÁLLÍTÁSI KÖLTSÉGE
          // if ($user->isClubUser()) $ingyenes_szallitas=true;
		  
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
      
      /*if (count($_SESSION['kosar'])>0){
  
  ?>  
  
  <tr>
    <td colspan="3" align="right">Szállítási díj</td>
    <td align="right" width="60"><?=number_format($szallitasi_dij, 0, '', '.')?>,-</td>
  </tr>

  <tr>
    <td colspan="3" align="right">Összesen fizetendő</td>
    <td align="right"><b><?=number_format($kosar_fizetendo + $szallitasi_dij, 0, '', '.')?>,-</b></td>
  </tr>
  
  <tr><td colspan="4" style="text-align:center;border:none;"><input type="button" value="               Megrendelés               " onclick="document.location.href='/megrendeles'" class="submit"></td></tr>
  
  <?
    
      }else{
    
  ?>

  <tr><td colspan="4" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A kosarad üres&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>

  <?
  
      }*/