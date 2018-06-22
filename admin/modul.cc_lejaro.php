<br />
Core Club lejáró tagság ( > 1 év)
<br />
<br />

<table border="0" cellspacing="1" cellpadding="2">
<tr align="center">
  <td width="36" class="darkCell">ID</td>
  <td width="150" class="darkCell">Név</td>
  <td width="150" class="darkCell">E-mail</td>
  <td width="70" class="darkCell">Össz.vásárlás</td>
  <td width="140" class="darkCell">Legutolsó vásárlás</td>
  <td width="100" class="darkCell">Lejáró tagság</td>
</tr>

<?php

//////////////////////////////////////////////////////////////////////////////////////

$sql_lejaro = mysql_query("SELECT 
			f.id,
			CONCAT(f.vezeteknev, ' ', f.keresztnev) nev,
			f.email,
			SUM(mf.fizetendo)-SUM(mf.szallitasi_dij) as osszeg,
			MAX(mf.datum)
			FROM megrendeles_fej mf
			LEFT JOIN felhasznalok f ON mf.id_felhasznalo = f.id
			WHERE f.kartya_kod >0
			AND mf.sztorno IS NULL
			AND mf.id_statusz=3
			GROUP BY mf.id_felhasznalo
			ORDER BY MAX(mf.datum)
			");

while ($adatok_lejaro=mysql_fetch_array($sql_lejaro))	{
	
	if($adatok_lejaro['MAX(mf.datum)'] < date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), date("d"), date("Y")-1)) )
		$osszes_lejaro++;	
}

//echo 'össz lejáró: '.$osszes_lejaro.'<br />';
			

//////////////////////////////////////////////////////////////////////////////////////

  if (!ISSET($_GET['oldal'])) $oldal = 0;
  else $oldal = (int)$_GET['oldal'];
  
  $sql = "SELECT 
			f.id,
			CONCAT(f.vezeteknev, ' ', f.keresztnev) nev,
			f.email,
			SUM(mf.fizetendo)-SUM(mf.szallitasi_dij) as osszeg,
			MAX(mf.datum)
			FROM megrendeles_fej mf
			LEFT JOIN felhasznalok f ON mf.id_felhasznalo = f.id
			WHERE f.kartya_kod >0
			AND mf.sztorno IS NULL
			AND mf.id_statusz=3
			GROUP BY mf.id_felhasznalo
			ORDER BY MAX(mf.datum)
			";
			
  
  //echo nl2br($sql);
  
  $_SESSION['excel_export'] = "
    SELECT 
			f.id,
			CONCAT(f.vezeteknev, ' ', f.keresztnev) nev,
			f.email,
			SUM(mf.fizetendo)-SUM(mf.szallitasi_dij) as osszeg,
			MAX(mf.datum)
			FROM megrendeles_fej mf
			LEFT JOIN felhasznalok f ON mf.id_felhasznalo = f.id
			WHERE f.kartya_kod >0
			AND mf.sztorno IS NULL
			AND mf.id_statusz=3
			GROUP BY mf.id_felhasznalo
			ORDER BY MAX(mf.datum) ASC
  ";


  $sorok = mysql_num_rows(mysql_query($sql));

  $query_user=mysql_query($sql." LIMIT ".($oldal*100).", 100"); 
  
  $lapok = ceil($sorok/100);
  
  $sorstyle='#FFFFFF';
  
  for ($go=1; $go<=$lapok; $go++){
  
    if ($oldal == $go-1) $st = 'style="color:yellow; font-weight:bold"';
    else $st = 'style="color:white"';
      
    $p[] = '<a href="index.php?lap=cc_lejaro&oldal='.($go-1).'" '.$st.'> '.$go.' </a>';                      
      
  }
  
  echo '<tr align="center"><td colspan="10" class="darkCell">
  <div style="float:left">Találatok száma: <b>'.number_format($sorok,0,".",".").'</b></div>
  <div style="float:left">&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;Lejáró CoreClub tagság: <b>'.number_format($osszes_lejaro,0,".",".").'</b></div>
  
  <br />
  '.@implode("..", $p).'</td></tr>';
  
  while ($adatok=mysql_fetch_array($query_user)){
    
    $sorstyle=='lightCell'?$sorstyle='darkCell':$sorstyle='lightCell';

    echo '<tr style="height:25px" class="'.$sorstyle.'" onMouseOver="this.className=\'mediumCell\';this.style.cursor=\'hand\'" onMouseOut="this.className=\''.$sorstyle.'\';">';
	
	if($adatok['MAX(mf.datum)'] < date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), date("d"), date("Y")-1)) )	{
		$lejaro='> 1 év';
		$ossz_lejaro++;
		}
	else
		$lejaro='';
    
	echo '<td>'.$adatok['id'].'</td>
			<td onClick="document.location.href=\'index.php?lap=felhasznalo&id='.$adatok['id'].'\'">'.$adatok['nev'].'</td>
			<td onClick="document.location.href=\'index.php?lap=felhasznalo&id='.$adatok['id'].'\'">'.$adatok['email'].'</td>
			<td onClick="document.location.href=\'index.php?lap=felhasznalo&id='.$adatok['id'].'\'" align="right">'.number_format($adatok["osszeg"],0,".",".").',-</td>
			<td onClick="document.location.href=\'index.php?lap=felhasznalo&id='.$adatok['id'].'\'" align="center">'.$adatok['MAX(mf.datum)'].'</td>
			<td onClick="document.location.href=\'index.php?lap=felhasznalo&id='.$adatok['id'].'\'" align="center">'.$lejaro.'</td>
	';
		  
    echo '</tr>';
    
  }
  
  echo '<tr align="center"><td colspan="10" class="darkCell">
  '.@implode("..", $p).'</td></tr>';
  echo '<tr align="left"><td colspan="10" class="darkCell"><a href="excel_export.php">Excel export</a></td></tr>';

?>

</table>