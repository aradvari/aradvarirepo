BELGA FORGALOM

<form method="post">
<table border="0" cellspacing="1" cellpadding="2">
    <tr>
      <td width="200" class="darkCell" align="center">Lekérdezés intervalluma</td>
      <td width="445" class="lightCell">
        <input type="text" name="datum_tol" value="<?=!ISSET($_POST['datum_tol'])?date("Y-m-d"):$_POST['datum_tol']?>" onclick="displayDatePicker('datum_tol');"> - 
        <input type="text" name="datum_ig" value="<?=!ISSET($_POST['datum_ig'])?date("Y-m-d"):$_POST['datum_ig']?>" onclick="displayDatePicker('datum_ig');"> 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="submit" class="form" value="lekérdezés" name="szures" />
      </td>
    </tr>                               
</table>
</form>

<?

if (ISSET($_POST['szures'])){

$table='<br>';
$datum_tol = $_POST['datum_tol'];
$datum_ig = $_POST['datum_ig'];

/**
* MÁRKÁK STATISZTIKÁJA
*/
$sql = "
SELECT 
m.markanev, 
count(mt.id_megrendeles_tetel) tetelek, 
sum(mt.termek_ar) ar,
(sum(t.ajanlott_beszerzesi_ar)/1.27) netto_besz_ar,
sum(mf.fizetendo-mf.giftcard_osszeg) fizetendo
FROM megrendeles_fej mf
LEFT JOIN megrendeles_tetel mt ON ( mf.id_megrendeles_fej = mt.id_megrendeles_fej ) 
LEFT JOIN markak m ON (m.id = mt.id_marka)
LEFT JOIN termekek t ON t.id = mt.id_termek
WHERE mf.sztorno IS NULL 
AND m.id=121
AND mf.id_statusz >1
AND mf.id_statusz <99
AND DATE_FORMAT(mf.datum, '%Y-%m-%d') >= DATE_FORMAT('".date("Y-m-d", strtotime($datum_tol))."', '%Y-%m-%d')
AND DATE_FORMAT(mf.datum, '%Y-%m-%d') <= DATE_FORMAT('".date("Y-m-d", strtotime($datum_ig))."', '%Y-%m-%d')
GROUP BY id_marka
ORDER BY ar DESC
";

$query = mysql_query($sql);

$osszesen = 0; $osszesen_db = 0; $marka=array();
while ($adatok = mysql_fetch_assoc($query)){
    
    $marka[] = $adatok;
    $osszesen = $osszesen + $adatok['ar'];
    $osszesen_db = $osszesen_db + $adatok['tetelek'];    
}

$table.= '<table cellpadding="5" cellspacing="1">';
$table.= '<col width="220">';
$table.= '<col width="130">';
$table.= '<col width="130">';
$table.= '<col width="130">';
$table.= '<col width="130">';
$table.= '<col width="130">';
$table.= '<tr style="height:25px;font-weight:bold">
		<td class="darkCell">Márka</td>
		<td align="right" class="darkCell">Darab</td>
		<td align="right" class="darkCell">Bruttó kisker ár</td>
		
		<!--<td align="right" class="darkCell">Összesen (Nettó)</td>
		<td align="right" class="darkCell">ÁFA 27%</td>-->
		
		<td align="right" class="darkCell">Nettó besz.ár</td>
		<td align="right" class="darkCell">Nettó árrés</td>
		<td align="right" class="darkCell">Megoszlás (%)</td></tr>';

if (is_array($marka)){
    reset($marka);
    while ($adatok = each($marka)){
        
        if ($style=='mediumCell') $style="lightCell"; else $style="mediumCell";
        
        $szazalek = round(($adatok[1]['ar']/$osszesen)*100, 2);
		
		// Vans -13% discount
		if($adatok[1]['markanev']=='Vans')	$adatok[1]['netto_besz_ar']=$adatok[1]['netto_besz_ar']*0.87;
		
		$netto_arres=($adatok[1]['ar']/1.27)-$adatok[1]['netto_besz_ar'];
		
		// netto besz ar ossz
		$netto_besz_ar_ossz=$netto_besz_ar_ossz+$adatok[1]['netto_besz_ar'];
		
		//netto arres ossz
		$netto_arres_ossz=$netto_arres_ossz+$netto_arres;
        
        $table.= '<tr class="'.$style.'">
					<td>'.$adatok[1]['markanev']."</td>
					<td align=\"right\">".number_format($adatok[1]['tetelek'], 0, '', ' ')." db</td>
					<td align=\"right\">".number_format($adatok[1]['ar'], 0, '', ' ')." Ft</td>
					<!--<td align=\"right\" style='color:#666;'>".number_format(($adatok[1]['ar']/1.27), 0, '', ' ')."</td>
					<td align=\"right\" style='color:#666;'>".number_format( ($adatok[1]['ar']-($adatok[1]['ar']/1.27)), 0, '', ' ')."</td>-->
					<td align=\"right\" style='color:#666;'>".number_format($adatok[1]['netto_besz_ar'], 0, '', ' ')." Ft</td>
					<td align=\"right\" style='color:#666;'>".number_format($netto_arres,0, '', ' ')." Ft</td>
					<td align=\"right\">".$szazalek."%</td></tr>";
        
    }
}

$table.= '<tr style="height:25px;font-weight:bold">
			<td></td>
			<td align="right" class="darkCell">'.number_format($osszesen_db, 0, '', ' ').'</td>
			<td align="right" class="darkCell">'.number_format($osszesen, 0, '', ' ').'</td>
			
			<!--- <td align="right" class="darkCell" style="color:;">'.number_format(($osszesen/1.27), 0, '', ' ').'</td>
			<td align="right" class="darkCell" style="color:;">'.number_format(($osszesen-($osszesen/1.27)), 0, '', ' ').'</td> -->
			
			<td align="right" class="darkCell" style="color:;">'.number_format($netto_besz_ar_ossz, 0, '', ' ').' Ft</td>
			<td align="right" class="darkCell" style="color:;">'.number_format($netto_arres_ossz, 0, '', ' ').' Ft</td>
			<td align="right" class="darkCell">100%</td></tr>';
$table.= '</table>';

if ($osszesen_db>0) echo "<p>".$table."</p>";

/* INGYENES SZALLITAS */

$sql = "
SELECT *
FROM megrendeles_fej mf
LEFT JOIN markak m ON (m.id = mt.id_marka)
LEFT JOIN termekek t ON t.id = mt.id_termek
WHERE mf.sztorno IS NULL 
AND mf.id_statusz >1
AND m.id=121
AND mf.id_statusz <99
AND mf.fizetendo>10000
AND DATE_FORMAT(mf.datum, '%Y-%m-%d') >= DATE_FORMAT('".date("Y-m-d", strtotime($datum_tol))."', '%Y-%m-%d')
AND DATE_FORMAT(mf.datum, '%Y-%m-%d') <= DATE_FORMAT('".date("Y-m-d", strtotime($datum_ig))."', '%Y-%m-%d')";

$free_shipping_qty=mysql_num_rows(mysql_query($sql));


$shippingtable='<table>
					<tr><td colspan=4 class="darkCell"><b>Ingyenes szállítás</b></td></tr>';
$shippingtable.='<tr>
	<td align="right" class="lightCell">Nettó összesen: <b>'.$free_shipping_qty.'</b> tétel x ~850 Ft = <b>'.number_format(($free_shipping_qty*850), 0, '', ' ').'</b> Ft</td>';
$shippingtable.='<td class="darkCell" align="center">Nettó bevétel: <b>'.number_format(($netto_arres_ossz-($free_shipping_qty*850)), 0, '', ' ').' Ft</b></td></tr>';
$shippingtable.='</table>';
echo '<p>'.$shippingtable.'</p>';
      

/**
* KATEGÓRIÁK STATISZTIKÁJA
*/

$sql = "SELECT id_kategoriak, megnevezes FROM kategoriak k WHERE sztorno IS NULL ORDER BY sorrend";
$foquery = mysql_query($sql);
while ($foadatok = mysql_fetch_array($foquery)){

    $altable="";
    
    $ids = @mysql_result(@mysql_query("SELECT GROUP_CONCAT(id_kategoriak) FROM kategoriak WHERE szulo=".$foadatok['id_kategoriak'].""), 0);
    if (empty($ids)) $ids=0;
    
    $sql = "
        SELECT 
        
        k.megnevezes,
        m.markanev, 
        count(mt.id_megrendeles_tetel) tetelek, 
        sum(mt.termek_ar) ar
        
        FROM megrendeles_fej mf
        LEFT JOIN megrendeles_tetel mt ON ( mf.id_megrendeles_fej = mt.id_megrendeles_fej ) 
        LEFT JOIN termekek t ON (t.id = mt.id_termek)
        LEFT JOIN markak m ON (m.id = mt.id_marka)
        LEFT JOIN kategoriak k ON (k.id_kategoriak = t.kategoria)
        
        WHERE 
		m.id=121 AND		
        mf.sztorno IS NULL AND 
        mf.id_statusz >1 AND 
        mf.id_statusz <99 AND 
        DATE_FORMAT(mf.datum, '%Y-%m-%d') >= DATE_FORMAT('".date("Y-m-d", strtotime($datum_tol))."', '%Y-%m-%d') AND 
        DATE_FORMAT(mf.datum, '%Y-%m-%d') <= DATE_FORMAT('".date("Y-m-d", strtotime($datum_ig))."', '%Y-%m-%d') AND 
        t.kategoria IN ($ids)
        
        GROUP BY t.kategoria, mt.id_marka
        
        ORDER BY k.id_kategoriak, ar DESC
    ";
    
    if ($ids!=0){
        
        $query = mysql_query($sql);

        $osszesen = 0; $osszesen_db = 0; $marka=array();
        while ($adatok = mysql_fetch_assoc($query)){
            
            $marka[] = $adatok;
            $osszesen = $osszesen + $adatok['ar'];
            $osszesen_db = $osszesen_db + $adatok['tetelek'];
            
        }

        $altable.= '<table cellpadding="5" cellspacing="1">';
        $altable.= '<col width="150">';
        $altable.= '<col width="150">';
        $altable.= '<col width="100">';
        $altable.= '<col width="100">';
        $altable.= '<col width="100">';
        $altable.= '<tr style="height:25px;font-weight:bold"><td class="darkCell">'.$foadatok['megnevezes'].'</td><td class="darkCell">Márka</td><td align="right" class="darkCell">Darab</td><td align="right" class="darkCell">Összesen (HUF)</td><td align="right" class="darkCell">Megoszlás (%)</td></tr>';

        reset($marka);
        while ($adatok = each($marka)){
            
            if ($style=='mediumCell') $style="lightCell"; else $style="mediumCell";
            
            $szazalek = round(($adatok[1]['ar']/$osszesen)*100, 2);
            
            $altable.= '<tr class="'.$style.'"><td>'.$adatok[1]['megnevezes']."</td><td>".$adatok[1]['markanev']."</td><td align=\"right\">".number_format($adatok[1]['tetelek'], 0, '', ' ')."</td><td align=\"right\">".number_format($adatok[1]['ar'], 0, '', ' ')."</td><td align=\"right\">$szazalek</td></tr>";
            
        }

        $altable.= '<tr style="height:25px;font-weight:bold"><td></td><td></td><td align="right" class="darkCell">'.number_format($osszesen_db, 0, '', ' ').'</td><td align="right" class="darkCell">'.number_format($osszesen, 0, '', ' ').'</td><td align="right" class="darkCell">100</td></tr>';
        $altable.= '</table>';

        if ($osszesen_db>0) echo "<p>".$altable."</p>";   
        
    } 
    
}


/**
* DIAGRAMM STATISZTIKA
*/
$sql = "
SELECT 
  
  DATE_FORMAT(mf.datum, '%Y-%m') datum,
  sum(mf.fizetendo) ar,
  sum(IFNULL(mf.giftcard_osszeg, 0)) kedvezmeny

FROM megrendeles_fej mf
LEFT JOIN megrendeles_tetel mt ON ( mf.id_megrendeles_fej = mt.id_megrendeles_fej ) 
LEFT JOIN markak m ON (m.id = mt.id_marka)
LEFT JOIN termekek t ON t.id = mt.id_termek

WHERE mf.sztorno IS NULL 
AND m.id=121
AND mf.id_statusz >1
AND mf.id_statusz <99
AND DATE_FORMAT(mf.datum, '%Y-%m-%d') >= DATE_FORMAT('".date("Y-m-d", strtotime($datum_tol))."', '%Y-%m-%d')
AND DATE_FORMAT(mf.datum, '%Y-%m-%d') <= DATE_FORMAT('".date("Y-m-d", strtotime($datum_ig))."', '%Y-%m-%d')

GROUP BY DATE_FORMAT(mf.datum, '%Y-%m')

ORDER BY mf.datum
";

$query = mysql_query($sql);

$diagram = '<table cellpadding="5" cellspacing="1">';
$diagram.= '<col width="70">';
$diagram.= '<col width="130">';
$diagram.= '<col width="430">';

$osszesen = 0;
while ($adatok = mysql_fetch_assoc($query)){
    
    $forgalom[] = $adatok;
    
    if ((int)$max<$adatok['ar']) $max=$adatok['ar'];
    
    if ((int)$max_kedvezmeny2<$adatok['kedvezmeny']) $max_kedvezmeny2=$adatok['kedvezmeny'];

}

if (is_array($forgalom)){
    
    while ($adatok = each($forgalom)){
        
        $szazalek = round(($adatok[1]['ar']/$max)*100, 2);
        
        $osszeg=0;

        $szazalek_kedvezmeny = round(($adatok[1]['kedvezmeny']/$adatok[1]['ar'])*100, 2);
        $osszeg1 = $adatok[1]['kedvezmeny'];
        $szazalek_kedvezmeny2 = round(($adatok[1]['kedvezmeny']/$adatok[1]['ar'])*100, 2);   
        $osszeg2 = $adatok[1]['kedvezmeny'];
        
        $diagram.= '<tr>
                      <td class="darkCell" align="center" rowspan="3">'.$adatok[1]['datum'].'</td>
                      <td class="darkCell" align="right">Összes forgalom</td>
                      <td class="mediumCell">
                        <div style="position:relative; width:'.(int)$szazalek.'%; background-color:#13506C; height:21px; margin: 1px">
                            <div style="position:absolute; width:200px; padding:3px">'.number_format($adatok[1]['ar'], 0, '', ' ').' Ft &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;['.$szazalek.'%]</div>
                        </div>
                      </td>
                    </tr>  
                    <tr>
                      <td class="darkCell" align="right">Számolt bevétel</td>
                      <td class="mediumCell">
                        <div style="position:relative; width:'.($szazalek-($szazalek_kedvezmeny+$szazalek_kedvezmeny2)).'%; background-color:#13506C; height:21px; margin: 1px">
                            <div style="position:absolute; width:200px; padding:3px">'.number_format( ($adatok[1]['ar']-$adatok[1]['kedvezmeny']) , 0, '', ' ').' Ft &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;['.($szazalek-($szazalek_kedvezmeny+$szazalek_kedvezmeny2)).'%]</div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="darkCell" align="right">Kedvezmény</td>
                      <td class="mediumCell">
                        <div style="position:relative; width:'.(int)$szazalek_kedvezmeny2.'%; background-color:#13506C; height:21px; margin: 1px">
                            <div style="position:absolute; width:200px; padding:3px">'.number_format($adatok[1]['kedvezmeny'], 0, '', ' ').' Ft &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;['.$szazalek_kedvezmeny2.'%]</div>
                        </div>
                      </td>
                    </tr>
                    ';    
        
    }

    $diagram.= '</table>';

    echo $diagram;

}

}

?>