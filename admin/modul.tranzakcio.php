<?

$adatok = mysql_fetch_array(mysql_query("SELECT 
                                         bt.datum datum_tol, bt.*, mf.*, concat(f.vezeteknev,' ',f.keresztnev) megrendelo, f.id idf
                                         FROM bank_tranzakciok bt
                                         LEFT JOIN megrendeles_fej mf ON (mf.id_megrendeles_fej = bt.id_megrendeles_fej)
                                         LEFT JOIN felhasznalok f ON (f.id = bt.id_felhasznalo)
                                         WHERE bt.id_bank_tranzakcio=".(int)$_GET['id']));    
    
?>

<table width="800" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td width="800">
    
        <table width="800" border="0" cellspacing="1" cellpadding="6" style="font-weight:bold;table-layout:fixed">

          <tr>
            <td class="headerCell" colspan="4">ID: <b><?=$_GET['id']?></b></td>
          </tr>                           

          <tr>
            <td class="darkCell">Tranzakció azonosító:</td>
            <td colspan="3" class="lightCell"><?=$adatok['trid']?></td>
          </tr>

          <tr>
            <td class="darkCell">Megrendelés azonosító:</td>
            <td colspan="3" class="lightCell"><a href="index.php?lap=megrendeles&id=<?=$adatok['id_megrendeles_fej']?>"><?=$adatok['megrendeles_szama']?></a></td>
          </tr>

          <tr>
            <td class="darkCell">Megrendelő:</td>
            <td colspan="3" class="lightCell"><a href="index.php?lap=felhasznalo&id=<?=$adatok['idf']?>"><?=$adatok['megrendelo']?></a></td>
          </tr>

          <tr>
            <td class="darkCell">Banki felhasználó azonosító:</td>
            <td colspan="3" class="lightCell"><?=$adatok['uid']?></td>
          </tr>

          <tr>
            <td class="darkCell">Tranzakció összege:</td>
            <td colspan="3" class="lightCell"><?=number_format($adatok['amo'], 2, '.', ' ')?> <?=$adatok['cur']?></td>
          </tr>

          <tr>
            <td class="darkCell">Időbélyeg:</td>
            <td colspan="3" class="lightCell"><?=$adatok['ts']?></td>
          </tr>

          <tr>
            <td class="darkCell">Válaszkód:</td>
            <td colspan="3" class="lightCell"><?=$adatok['rc']?></td>
          </tr>

          <tr>
            <td class="darkCell">Válaszüzenet:</td>
            <td colspan="3" class="lightCell"><?=$adatok['rt']?></td>
          </tr>

          <tr>
            <td class="darkCell">Engedélyszám:</td>
            <td colspan="3" class="lightCell"><?=$adatok['anum']?></td>
          </tr>

          <tr>
            <td class="darkCell">Tranzakció történet:</td>
            <td colspan="3" class="lightCell">
            <?

                $exp = explode(",", $adatok["history"]); $num=0;
                foreach($exp as $statusz){
                    
                    $result = mysql_result(mysql_query("SELECT leiras FROM bank_statuszok WHERE id_bank_statusz=".$statusz), 0);
                    if ($result=="") $result="Ismeretlen";
                    echo ++$num.". $result<br />";
                    
                }
            ?>
            </td>
          </tr>

          <tr>
            <td class="darkCell">Indítva:</td>
            <td colspan="3" class="lightCell"><?=$adatok['datum_tol']?></td>
          </tr>

          <tr>
            <td class="darkCell">Lezárva:</td>
            <td colspan="3" class="lightCell"><?=$adatok['lezarva']?></td>
          </tr>

        </table>
        
    </td>
  </tr>
</table>