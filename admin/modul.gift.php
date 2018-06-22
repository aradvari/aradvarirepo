<?

$adatok = mysql_fetch_array(mysql_query("SELECT 
                                         g.*, bt.id_bank_tranzakcio, 
                                         concat(rf.vezeteknev, ' ', rf.keresztnev) kuldo_nev, rf.id kuldo_id,
                                         concat(vf.vezeteknev, ' ', vf.keresztnev) felhasznalo_nev, vf.id felhasznalo_id
                                         FROM giftcard g
                                         LEFT JOIN bank_tranzakciok bt ON (bt.trid = g.trid)
                                         LEFT JOIN felhasznalok rf ON (rf.id = g.id_kuldo)
                                         LEFT JOIN felhasznalok vf ON (vf.id = g.id_felhasznalo)
                                         WHERE g.id_giftcard=".(int)$_GET['id'])); 
                                         
$egyenleg = @mysql_result(mysql_query("SELECT min(osszeg) FROM giftcard WHERE azonosito_kod='".$adatok['azonosito_kod']."'"), 0);
$osszeg = @mysql_result(mysql_query("SELECT max(osszeg) FROM giftcard WHERE azonosito_kod='".$adatok['azonosito_kod']."'"), 0);
    
?>

<table width="800" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td width="800">
    
        <table width="800" border="0" cellspacing="1" cellpadding="6" style="font-weight:bold;table-layout:fixed">

          <tr>
            <td class="headerCell" colspan="4">ID: <b><?=$_GET['id']?></b></td>
          </tr>                           

          <tr>
            <td class="darkCell">Azonosító kód:</td>
            <td colspan="3" class="lightCell"><?=$adatok['azonosito_kod']?></td>
          </tr>

          <tr>
            <td class="darkCell">Tranzakció azonosító:</td>
            <td colspan="3" class="lightCell"><a href="index.php?lap=tranzakcio&id=<?=$adatok['id_bank_tranzakcio']?>"><?=$adatok['trid']?></a></td>
          </tr>

          <tr>
            <td class="darkCell">Kártya vásárolt összege:</td>
            <td colspan="3" class="lightCell"><?=number_format($osszeg, 0, '', ' ')?> Ft</a></td>
          </tr>

          <tr>
            <td class="darkCell">Kártya elérhető egyenlege:</td>
            <td colspan="3" class="lightCell"><?=number_format($egyenleg-$adatok['felhasznalt_osszeg'], 0, '', ' ')?> Ft</a></td>
          </tr>

          <tr>
            <td class="darkCell">Vásárlás dátuma:</td>
            <td colspan="3" class="lightCell"><?=$adatok['fizetve']?></td>
          </tr>

          <tr>
            <td class="darkCell">Kártya érvényessége:</td>
            <td colspan="3" class="lightCell"><?=$adatok['ervenyes_tol']?> - <?=$adatok['ervenyes_ig']?></td>
          </tr>

          <tr>
            <td class="darkCell">Címzettnek elküldve:</td>
            <td colspan="3" class="lightCell"><?=$adatok['kikuldve']?></td>
          </tr>

          <tr>
            <td class="darkCell">Regisztrált feladó:</td>
            <td colspan="3" class="lightCell"><a href="index.php?lap=felhasznalo&id=<?=$adatok['kuldo_id']?>"><?=$adatok['kuldo_nev']?></a></td>
          </tr>

          <tr>
            <td class="darkCell">Feladó adatai:</td>
            <td colspan="3" class="lightCell"><?=$adatok['felado_nev']?>, <?=$adatok['felado_email']?></td>
          </tr>

          <tr>
            <td class="darkCell">Címzett adatai:</td>
            <td colspan="3" class="lightCell"><?=$adatok['cimzett_nev']?>, <?=$adatok['cimzett_email']?></td>
          </tr>

          <tr>
            <td class="darkCell">Rövid üzenet:</td>
            <td colspan="3" class="lightCell"><?=$adatok['uzenet']?></td>
          </tr>

          <tr>
            <td class="darkCell">Tranzakció történet:</td>
            <td colspan="3" class="lightCell">
            
                <table width="100%" border="0" cellspacing="1" cellpadding="6" style="font-weight:bold;table-layout:fixed">

                  <tr>
                    <td class="headerCell">Dátum</td>
                    <td class="headerCell">Összeg</td>
                    <td class="headerCell">Megrendelés azon.</td>
                    <td class="headerCell">Vásárló</td>
                  </tr>                           

                  <?
                  
                    $sql = "SELECT 
                              g.*, mf.id_megrendeles_fej, mf.megrendeles_szama,
                              concat(vf.vezeteknev, ' ', vf.keresztnev) felhasznalo_nev, vf.id felhasznalo_id
                            FROM giftcard g
                            LEFT JOIN megrendeles_fej mf ON (mf.id_megrendeles_fej = g.id_megrendeles_fej)
                            LEFT JOIN felhasznalok vf ON (vf.id = g.id_felhasznalo)
                            WHERE 
                             g.azonosito_kod='".$adatok['azonosito_kod']."' AND 
                             g.felhasznalva IS NOT NULL 
                            ORDER BY 
                             g.id_giftcard DESC";
                            
                    $qt = mysql_query($sql);
                    
                    while ($tr = mysql_fetch_assoc($qt)){
                        
                        echo '
                          <tr>
                            <td class="darkCell">'.$tr['felhasznalva'].'</td>
                            <td class="darkCell" align="right">'.number_format($tr['felhasznalt_osszeg'], 0, '', ' ').' Ft</td>
                            <td class="darkCell"><a href="index.php?lap=megrendeles&id='.$tr['id_megrendeles_fej'].'">'.$tr['megrendeles_szama'].'</a></td>
                            <td class="darkCell"><a href="index.php?lap=felhasznalo&id='.$adatok['felhasznalo_id'].'">'.$adatok['felhasznalo_nev'].'</a></td>
                          </tr>
                        ';
                        
                    }
                  
                  ?>
                  
                </table>
            
            </td>
          </tr>

        </table>
        
    </td>
  </tr>
</table>