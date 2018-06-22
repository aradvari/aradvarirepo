<?
//print_r($_POST);
//echo "<br /><br /><br /><br /><br /><br />"; 



    //SZŰRÉS
    if (ISSET($_POST['alaphelyzet'])){
        
        unset ($_SESSION['megrendelesek']);
        unset ($_SESSION['megrendelesek_query']);
        
    }

    if (ISSET($_GET['id_statusz'])){
    
        if ($_GET['id_statusz']==1) $_SESSION['megrendelesek']['statusz'] = ' AND mf.id_statusz=1';
        elseif ($_GET['id_statusz']==2) $_SESSION['megrendelesek']['statusz'] = ' AND mf.id_statusz=2';
        elseif ($_GET['id_statusz']==3) $_SESSION['megrendelesek']['statusz'] = ' AND mf.id_statusz=3';
        elseif ($_GET['id_statusz']==99) $_SESSION['megrendelesek']['statusz'] = ' AND mf.id_statusz=99';
        elseif ($_GET['id_statusz']==50) $_SESSION['megrendelesek']['statusz'] = ' AND mf.id_statusz=50';
        elseif ($_GET['id_statusz']==0) $_SESSION['megrendelesek']['statusz'] = '';
        
    }
	
    
    if (ISSET($_GET['id_szallitasi_mod'])){
    
        if ($_GET['id_szallitasi_mod']==1) $_SESSION['megrendelesek']['szallitasi_mod'] = ' AND mf.id_szallitasi_mod=1';
        elseif ($_GET['id_szallitasi_mod']==2) $_SESSION['megrendelesek']['szallitasi_mod'] = ' AND mf.id_szallitasi_mod=2';
        
    }
    
    if (!ISSET($_SESSION['megrendelesek']['statusz'])) $_SESSION['megrendelesek']['statusz'] = '';
    if (!ISSET($_SESSION['megrendelesek']['szallitasi_mod'])) $_SESSION['megrendelesek']['szallitasi_mod'] = '';
    
    if (ISSET($_POST['szures'])){
        
        $_SESSION['megrendelesek']['megrendeles_szama'] = $_POST['megrendeles_szama'];    
        $_SESSION['megrendelesek']['megrendelo_neve'] = $_POST['megrendelo_neve'];
        $_SESSION['megrendelesek']['marka'] = $_POST['marka'];
        $_SESSION['megrendelesek']['vonalkod'] = $_POST['vonalkod'];
        $_SESSION['megrendelesek']['trid'] = $_POST['trid'];
        $_SESSION['megrendelesek']['termeknev'] = $_POST['termeknev'];
        $_SESSION['megrendelesek']['ar_tol'] = $_POST['ar_tol'];
        $_SESSION['megrendelesek']['ar_ig'] = $_POST['ar_ig'];
        $_SESSION['megrendelesek']['kedvezmeny_tol'] = $_POST['kedvezmeny_tol'];
        $_SESSION['megrendelesek']['kedvezmeny_ig'] = $_POST['kedvezmeny_ig'];
        $_SESSION['megrendelesek']['db_tol'] = $_POST['db_tol'];
        $_SESSION['megrendelesek']['db_ig'] = $_POST['db_ig'];
        $_SESSION['megrendelesek']['datum_tol'] = $_POST['datum_tol'];
        $_SESSION['megrendelesek']['datum_ig'] = $_POST['datum_ig'];
		$_SESSION['megrendelesek']['szalldij'] = $POST['szalldij'];
        
        $_SESSION['megrendelesek_query']=
		($_POST['megrendeles_szama']==""?"":" AND mf.megrendeles_szama LIKE '%".$_POST['megrendeles_szama']."%'")
	   .($_POST['megrendelo_neve']==""?"":" AND concat(mf.szallitasi_nev, ' ', mf.szamlazasi_nev) LIKE '%".$_POST['megrendelo_neve']."%'")
	   .($_POST['marka']==""?"":" AND mt.id_marka = ".$_POST['marka'])
	   .($_POST['vonalkod']==""?"":" AND mt.vonalkod LIKE '%".$_POST['vonalkod']."%'")
	   .($_POST['trid']==""?"":" AND bt.trid LIKE '%".$_POST['trid']."%'")
	   .($_POST['termeknev']==""?"":" AND mt.termek_nev LIKE '%".$_POST['termeknev']."%'")
	   .($_POST['ar_tol']==""?"":' AND mf.fizetendo >= '.$_POST['ar_tol'])
	   .($_POST['ar_ig']==""?"":' AND mf.fizetendo <= '.$_POST['ar_ig'])
	   .($_POST['kedvezmeny_tol']==""?"":' AND mf.giftcard_osszeg >= '.$_POST['kedvezmeny_tol'])
	   .($_POST['kedvezmeny_ig']==""?"":' AND mf.giftcard_osszeg <= '.$_POST['kedvezmeny_ig'])
	   .($_POST['db_tol']==""?"":' AND mf.tetel_szam >= '.$_POST['db_tol'])
	   .($_POST['db_ig']==""?"":' AND mf.tetel_szam <= '.$_POST['db_ig'])
	   .($_POST['datum_tol']==""?"":" AND DATE_FORMAT(mf.datum, '%Y-%m-%d') >= DATE_FORMAT('".date("Y-m-d", strtotime($_POST['datum_tol']))."', '%Y-%m-%d')")
	   .($_POST['datum_ig']==""?"":" AND DATE_FORMAT(mf.datum, '%Y-%m-%d') <= DATE_FORMAT('".date("Y-m-d", strtotime($_POST['datum_ig']))."', '%Y-%m-%d')")
	   .($_POST['szalldij']==""?"":" AND szallitasi_dij=".$_POST['szalldij'])
	   ;
		}

?>

<br />

<form method="post">
<table border="0" cellspacing="1" cellpadding="2">
    <tr>
      <td width="100" class="darkCell" align="center">megrendelés száma</td>
      <td width="200" class="lightCell"><input type="text" style="width:100%" name="megrendeles_szama" value="<?=$_SESSION['megrendelesek']['megrendeles_szama']?>"></td>
      <td width="100" class="darkCell" align="center">Megrendelő neve</td>
      <td class="lightCell"><input type="text" style="width:100%" name="megrendelo_neve" value="<?=$_SESSION['megrendelesek']['megrendelo_neve']?>"></td>
      <td width="100" class="darkCell" align="center">Terméknév</td>
      <td width="200" class="lightCell"><input type="text" style="width:100%" name="termeknev" value="<?=$_SESSION['megrendelesek']['termeknev']?>"></td>
    </tr>
    <tr>
      <td width="100" class="darkCell" align="center">Márka</td>
      <td width="200" class="lightCell">
		<?
		echo $func->createSelectBox("SELECT * FROM markak WHERE sztorno IS NULL ORDER BY markanev", $_SESSION['megrendelesek']['marka'],  "name=\"marka\"", "Mindegyik")
		?>
      </td>
      <td width="100" class="darkCell" align="center">Vonalkód</td>
      <td width="200" class="lightCell"><input type="text" style="width:100%" name="vonalkod" value="<?=$_SESSION['megrendelesek']['vonalkod']?>"></td>
      <td width="100" class="darkCell" align="center">Dátum</td>
      <td width="200" class="lightCell">
        <input type="text" style="width:80px" name="datum_tol" value="<?=$_SESSION['megrendelesek']['datum_tol']?>" onclick="displayDatePicker('datum_tol');"> - <input type="text" style="width:80px" name="datum_ig" value="<?=$_SESSION['megrendelesek']['datum_ig']?>" onclick="displayDatePicker('datum_ig');">
      </td>
    <tr>
      <td width="100" class="darkCell" align="center">Végösszeg</td>
      <td width="200" class="lightCell">
        <input type="text" style="width:80px" name="ar_tol" value="<?=$_SESSION['megrendelesek']['ar_tol']?>"> - <input type="text" style="width:80px" name="ar_ig" value="<?=$_SESSION['megrendelesek']['ar_ig']?>">
      </td>
      <td width="100" class="darkCell" align="center">Kedvezmény</td>
      <td width="200" class="lightCell">
        <input type="text" style="width:80px" name="kedvezmeny_tol" value="<?=$_SESSION['megrendelesek']['kedvezmeny_tol']?>"> - <input type="text" style="width:80px" name="kedvezmeny_ig" value="<?=$_SESSION['megrendelesek']['kedvezmeny_ig']?>">
      </td>
      <td width="100" class="darkCell" align="center">Tételszám</td>
      <td width="200" class="lightCell">
        <input type="text" style="width:80px" name="db_tol" value="<?=$_SESSION['megrendelesek']['db_tol']?>"> - <input type="text" style="width:80px" name="db_ig" value="<?=$_SESSION['megrendelesek']['db_ig']?>">
      </td>
    </tr>  
    <tr>
      <td width="100" class="darkCell" align="center">Tranzakció azonosító</td>
      <td width="200" class="lightCell" colspan="3"><input type="text" style="width:100%" name="trid" value="<?=$_SESSION['megrendelesek']['trid']?>"></td>
	  
	  <td width="100" class="darkCell" align="center">Szállítási díj</td>
	  <td width="200" class="lightCell" colspan="">
		<label><input type="radio" name="szalldij" value=990 <? if($_SESSION['megrendelesek']['szalldij']==900) //echo 'checked'; ?> />Van</label>
		<label><input type="radio" name="szalldij" value=0 <? if($_SESSION['megrendelesek']['szalldij']==0) //echo 'checked'; ?> />Nincs</label>
	  </td>
    </tr>                             
    <tr>
      <td class="darkCell" align="center" colspan="6"><input type="submit" class="form" value="szűrés" name="szures" /> <input type="submit" class="form" value="alaphelyzet" name="alaphelyzet" /></td>
    </tr>
</table>
</form>

<br />

<a href="<?=$_SERVER['REQUEST_URI']?>&reszletes=1">Megrendelés tételek:</a> | <input type="button" value="nyomtatás" onClick="window.print()" />

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<span class="greenCell" style="padding:0 2px; margin-right:0px; border:0px solid green">&nbsp;&nbsp;</span> Bankkártya &nbsp;&nbsp;&nbsp;&nbsp;
<span class="redCell" style="padding:0 2px; margin-right:0px; border:0px solid red">&nbsp;&nbsp;</span> Személyes átvétel &nbsp;&nbsp;&nbsp;&nbsp;
<span class="orangeCell" style="padding:0 2px; margin-right:0px; border:0px solid orange">&nbsp;&nbsp;</span> Giftcard &nbsp;&nbsp;&nbsp;&nbsp;
<span class="purpleCell" style="padding:0 2px; margin-right:0px; border:0px solid orange">&nbsp;&nbsp;</span> Bankkártya + Személyes &nbsp;&nbsp;&nbsp;&nbsp;
<span class="blueCell" style="padding:0 2px; margin-right:0px; border:0px solid orange">&nbsp;&nbsp;</span> Bankkártya + Giftcard &nbsp;&nbsp;&nbsp;&nbsp;
<span class="oliveCell" style="padding:0 2px; margin-right:0px; border:0px solid orange">&nbsp;&nbsp;</span> Személyes + Giftcard &nbsp;&nbsp;&nbsp;&nbsp;



<br />
<br />

<?
$sql = "SELECT id_felhasznalo, szallitasi_nev
		FROM megrendeles_fej
		WHERE id_statusz=1
		GROUP BY id_felhasznalo
		HAVING count(*) > 1
		LIMIT 10";
		
$res=mysql_query($sql);

if($res)	{
	echo 'Több megrendelés: ';
	while($row=mysql_fetch_array($res))	{
		echo '<a href="" class="bubble-yellow">'.$row[1].'</a>&nbsp;';
	}
}
?>

  <table border=0 style="min-width:910px">				
	<?php
	
	  if (!ISSET($_GET['oldal'])) $oldal = 0;
	  else $oldal = (int)$_GET['oldal'];
	
	  $sql = "
		SELECT 
			mf.id_megrendeles_fej,
			mf.megrendeles_szama,
			mf.szallitasi_nev,
			mf.szamlazasi_nev,
			(mf.fizetendo-IFNULL(mf.giftcard_osszeg,0)) fizetendo,
			(mf.fizetendo_deviza-IFNULL(mf.giftcard_osszeg_deviza,0)) fizetendo_deviza,
			mf.tetel_szam,
			mf.megjegyzes,
			mf.datum,
			ms.statusz_nev,
			mf.giftcard_osszeg,
			mf.szallitasi_dij,
			mf.giftcard_osszeg_deviza,
			mf.szallitasi_dij_deviza,
			mf.id_fizetesi_mod,
			mf.id_szallitasi_mod,
			mf.id_penznem,
			o.orszag_nev,
			bt.trid,
			f.aktivacios_kod
		FROM megrendeles_fej mf
		LEFT JOIN megrendeles_tetel mt ON (mt.id_megrendeles_fej = mf.id_megrendeles_fej)
		LEFT JOIN megrendeles_statuszok ms ON (mf.id_statusz = ms.id_megrendeles_statusz)
		LEFT JOIN bank_tranzakciok bt ON (bt.id_megrendeles_fej = mf.id_megrendeles_fej)
		LEFT JOIN orszag o ON (o.id_orszag = mf.id_orszag)
		LEFT JOIN felhasznalok f ON mf.id_felhasznalo=f.id
		WHERE mf.sztorno IS NULL AND mt.sztorno IS NULL ".$_SESSION['megrendelesek_query'].$_SESSION['megrendelesek']['statusz'].$_SESSION['megrendelesek']['szallitasi_mod']."
		GROUP BY mf.id_megrendeles_fej
		ORDER BY mf.datum DESC
	  ";
	  
	  
	  // Fogyasjelentes
				  $_SESSION['fogyasjelentes'] = "
					SELECT
					mf.datum `Megrendelés dátum`,
					mf.megrendeles_szama `Megrendelés szám`,
					mf.giftcard_osszeg as `Kedvezmény értéke`,
					mt.vonalkod `Vonalkód`,							
					t.cikkszam `Cikkszám`,
					t.termeknev `Terméknév`,
					t.szin `Szín`,
					ROUND(t.ajanlott_beszerzesi_ar/1.27) as `Nettó besz.ár`,
					ROUND(mt.termek_ar/1.27) as `Nettó kisker ár`
					
					FROM megrendeles_tetel mt
					LEFT JOIN megrendeles_fej mf ON (mt.id_megrendeles_fej = mf.id_megrendeles_fej)
					LEFT JOIN megrendeles_statuszok ms ON (mf.id_statusz = ms.id_megrendeles_statusz) 
					LEFT JOIN termekek t ON (t.id = mt.id_termek)
                    WHERE mf.sztorno IS NULL 
					AND mf.id_statusz<>99 
					AND mt.sztorno IS NULL ".$_SESSION['megrendelesek_query']."
                    /*GROUP BY mf.id_megrendeles_fej*/
                    ORDER BY mf.datum ASC
                  ";
				  
	  
	  // GLS Connect	  
	  $_SESSION['gls_rendelesek'] = "
		SELECT 
		
		mf.id_megrendeles_fej,
		mf.szallitasi_nev szallitasi_nev,
		
		f.orszag_nev orszag,
		mf.szallitasi_irszam irsz,
		mf.szallitasi_varos varos,
		
		CONCAT(mf.szallitasi_utcanev, ' ', mf.szallitasi_kozterulet, ' ', mf.szallitasi_hazszam,'. ',
		
		(CASE WHEN mf.szallitasi_emelet>'' THEN CONCAT('(',mf.szallitasi_emelet,')') ELSE '' END)
		
		) cim,
		
		
		(CASE WHEN mf.id_fizetesi_mod=1 THEN (mf.fizetendo+mf.szallitasi_dij)-COALESCE(mf.giftcard_osszeg,0) ELSE '' END) fizetendo,
		
		f.email,
		
		CONCAT(f.telefonszam1, 
		(CASE WHEN f.telefonszam2>'' THEN ' | ' ELSE '' END), 
		f.telefonszam2) telefon,
		
		mf.megjegyzes
		
		
		FROM megrendeles_fej mf
		LEFT JOIN megrendeles_tetel mt ON (mt.id_megrendeles_fej = mf.id_megrendeles_fej)
		LEFT JOIN megrendeles_statuszok ms ON (mf.id_statusz = ms.id_megrendeles_statusz)
		LEFT JOIN bank_tranzakciok bt ON (bt.id_megrendeles_fej = mf.id_megrendeles_fej)
		LEFT JOIN felhasznalok f ON (mf.id_felhasznalo = f.id)
		
		WHERE mf.sztorno IS NULL AND 
		mf.id_szallitasi_mod=1 AND
		mf.id_felhasznalo != 11039 AND /* zsuti77@gmail.com Coreshop user */
		mt.sztorno IS NULL ".$_SESSION['megrendelesek_query'].$_SESSION['megrendelesek']['statusz']."
		GROUP BY mf.id_megrendeles_fej
		ORDER BY mf.datum DESC
	  ";	

	/*echo '<br /><br /><br />';
	echo nl2br($_SESSION['gls_rendelesek']);	  
	echo '<br /><br /><br />';*/
	  
						
	  $sorok = mysql_num_rows(mysql_query($sql));
	
	  $query_user=mysql_query($sql." LIMIT ".($oldal*100).", 100"); 
	  
	  $lapok = ceil($sorok/100);
	  
	  $sorstyle='#FFFFFF';
	  
	  for ($go=1; $go<=$lapok; $go++){
	  
		if ($oldal == $go-1) $st = 'style="color:yellow; font-weight:bold"';
		else $st = 'style="color:white"';
		  
		$p[] = '<a href="index.php?lap=megrendelesek&oldal='.($go-1).'" '.$st.'>'.$go.'</a>';                      
		  
	  }
	
	// talalatok szama / gls rendelesek
	/*echo '<tr><td colspan="2" class="darkCell" align="center">Találatok száma: <b>'.number_format($sorok,0,".",".").'</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
	<a href="gls_rendelesek.php"><b>Megrendelések &nbsp;&raquo;  &nbsp; GLS CONNECT</b></a> 
	&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;*/
	
	echo '<tr>
	<td colspan="2" class="darkCell" align="center">Találatok száma: <b>'.number_format($sorok,0,".",".").'</b> 
	
	<td colspan="4" class="darkCell" align="center"><a href="gls_rendelesek.php"><b>Megrendelések &nbsp;&raquo;  &nbsp; GLS CONNECT</b></a> </td>
	
	<td colspan="4" class="darkCell" align="center"><a href="szamlaatadas_szamlazz_hu.php"><b>Számlaátadás &nbsp;&raquo;  &nbsp; SZÁMLÁZZ.HU</b></a>
	
	</td></tr>';				
	
	/*&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
	<a href="vevo_export_szamlazz_hu.php"><b>Vevők &nbsp;&raquo;  &nbsp; SZÁMLÁZZ.HU</b></a>*/
	
	
	  
	echo '<tr align="center">
			  <td width="90" class="darkCell">Megr. száma</td>
			  <td width="280" class="darkCell">Megrendelő</td>
			  <td width="100" class="darkCell">Ország</td>
			  <td width="90" class="darkCell">Fizetendő</td>
			  <!--<td width="60" class="darkCell">Kedv.</td>
			  <td width="40" class="darkCell">Száll.</td>
			  <td width="50" class="darkCell">Tételek</td>-->
			  <td width="80" class="darkCell">Fizetési mód</td>
			  <td width="80" class="darkCell">Szállítási mód</td>
			  <td width="80" class="darkCell">Szállítási díj</td>
			  <td width="120" class="darkCell">Dátum</td>
			  <td width="100" class="darkCell">Tranz. azon.</td>
			  <td width="100" class="darkCell">Státusz</td>
			  <td width="300" class="darkCell">Megjegyzés</td>
	</tr>';
	  
	  while ($adatok=mysql_fetch_array($query_user)){
		
		$sorstyle=='lightCell'?$sorstyle='darkCell':$sorstyle='lightCell';
		if ($adatok['trid']!="") $sorstyle='greenCell';											// kartyas
		if ($adatok['giftcard_osszeg']!="") $sorstyle='orangeCell';								// kedvezmeny
		if ( ($adatok['trid']!="") && ($adatok['giftcard_osszeg']!="")) $sorstyle='blueCell';	// kartyas + kedvezmeny
		if ($adatok['id_szallitasi_mod']==2) $sorstyle='redCell';								// szemelyes atvetel
		if (($adatok['id_szallitasi_mod']==2) && ($adatok['trid']!="")) $sorstyle='purpleCell';	// kartyas + szemelyes atvetel
		if (($adatok['id_szallitasi_mod']==2) && ($adatok['giftcard_osszeg']!="")) $sorstyle='oliveCell';	// szemelyes atvetel + giftcard
		
		//if ($adatok['id_szallitasi_mod']==2) $adatok['szallitasi_dij']=0;

		if ($adatok['id_penznem']==0){ //HUF
			$fizetendo = number_format($adatok['fizetendo'], 0, '', ' ').' Ft';
			$giftcard_osszeg = number_format($adatok['giftcard_osszeg'], 0, '', ' ').' Ft';
			$szallitasi_dij = number_format($adatok['szallitasi_dij'], 0, '', ' ').' Ft';
		}else{
			$fizetendo = '<b>'.number_format($adatok['fizetendo_deviza'], 2, '.', ' ').' &euro;</b>';
			//<br />'.number_format($adatok['fizetendo'], 0, '', ' ').' Ft';
			$giftcard_osszeg = '<b>'.number_format($adatok['giftcard_osszeg_deviza'], 2, '.', ' ').' &euro;</b>';
			//<br />'.number_format($adatok['giftcard_osszeg_deviza'], 0, '', ' ').' Ft';
			$szallitasi_dij = '<b>'.number_format($adatok['szallitasi_dij_deviza'], 2, '.', ' ').' &euro;</b>';
			//<br />'.number_format($adatok['szallitasi_dij_deviza'], 0, '', ' ').' Ft';
		}
		
		$rend_ossz = $rend_ossz+$adatok['fizetendo'];
		
		$fizetesi_modok = array(1=>"Utánvét", 2=>"Bankkártyás");
		$szallitasi_modok = array(1=>"GLS", 2=>"Személyes", 3=>"GLS pont");
		
		$megjegyzes='&nbsp;';
		if($adatok['megjegyzes'])
			$megjegyzes='<div align="left" class="bubble-yellow" style="line-height:12px;font-size:10px;letter-spacing:-1px;">'.nl2br(substr($adatok['megjegyzes'], 0, 60)).'</div>';
		
		$once='';
		if($adatok['aktivacios_kod']=='login_once') $once='<br /><span style="color:blue;display:inline;">(reg. nélkül)</span>';

		echo '<tr style="height:25px" class="'.$sorstyle.'" onMouseOver="this.className=\'mediumCell\';this.style.cursor=\'hand\'" onMouseOut="this.className=\''.$sorstyle.'\';">';					
		echo '<td onClick="document.location.href=\'index.php?lap=megrendeles&id='.$adatok['id_megrendeles_fej'].'\'"><div valign="middle" align="right">'.$adatok['megrendeles_szama'].'&nbsp;</div></td>
			  <td onClick="document.location.href=\'index.php?lap=megrendeles&id='.$adatok['id_megrendeles_fej'].'\'"><div valign="middle" align="left">'.$adatok['szallitasi_nev'].' '.$once.'</div></td>
			  <td onClick="document.location.href=\'index.php?lap=megrendeles&id='.$adatok['id_megrendeles_fej'].'\'"><div valign="middle" align="left">'.$adatok['orszag_nev'].'&nbsp;</div></td>
			  <td onClick="document.location.href=\'index.php?lap=megrendeles&id='.$adatok['id_megrendeles_fej'].'\'"><div valign="middle" align="right">'.$fizetendo.'</div></td>
			  <!--<td onClick="document.location.href=\'index.php?lap=megrendeles&id='.$adatok['id_megrendeles_fej'].'\'"><div valign="middle" align="right">'.$giftcard_osszeg.'</div></td>
			  <td onClick="document.location.href=\'index.php?lap=megrendeles&id='.$adatok['id_megrendeles_fej'].'\'"><div valign="middle" align="right">'.$szallitasi_dij.'</div></td>
			  <td onClick="document.location.href=\'index.php?lap=megrendeles&id='.$adatok['id_megrendeles_fej'].'\'"><div valign="middle" align="right">'.number_format($adatok['tetel_szam'], 0, '', ' ').' db</div></td>-->
			  <td onClick="document.location.href=\'index.php?lap=megrendeles&id='.$adatok['id_megrendeles_fej'].'\'"><div valign="middle" align="center">'.$fizetesi_modok[$adatok['id_fizetesi_mod']].'&nbsp;</div></td>
			  <td onClick="document.location.href=\'index.php?lap=megrendeles&id='.$adatok['id_megrendeles_fej'].'\'"><div valign="middle" align="center">'.$szallitasi_modok[$adatok['id_szallitasi_mod']].'&nbsp;</div></td>
			  <td onClick="document.location.href=\'index.php?lap=megrendeles&id='.$adatok['id_megrendeles_fej'].'\'"><div valign="middle" align="right">'.$adatok['szallitasi_dij'].'&nbsp;</div></td>
			  <td onClick="document.location.href=\'index.php?lap=megrendeles&id='.$adatok['id_megrendeles_fej'].'\'"><div valign="middle" align="left">'.$adatok['datum'].'&nbsp;</div></td>
			  <td onClick="document.location.href=\'index.php?lap=megrendeles&id='.$adatok['id_megrendeles_fej'].'\'"><div valign="middle" align="center">'.$adatok['trid'].'&nbsp;</div></td>
			  <td onClick="document.location.href=\'index.php?lap=megrendeles&id='.$adatok['id_megrendeles_fej'].'\'"><div valign="middle" align="center">'.$adatok['statusz_nev'].'&nbsp;</div></td>
			  <td onClick="document.location.href=\'index.php?lap=megrendeles&id='.$adatok['id_megrendeles_fej'].'\'">'.$megjegyzes.'</td>';
		echo '</tr>';
		
		if ($_GET['reszletes']==1)	{
		// részletező eleje					

		$sql = "SELECT 
				mt.*,
				count(mt.id_megrendeles_tetel) mennyiseg,
				sum(mt.termek_ar) osszesen
				FROM megrendeles_tetel mt 
				WHERE mt.id_megrendeles_fej=".$adatok['id_megrendeles_fej']." AND 
				mt.sztorno IS NULL
				GROUP BY mt.id_megrendeles_fej, mt.vonalkod
				";
		
		$query = mysql_query($sql);
		
		$osszes_ft = 0;
		$osszes_db = 0;
		
		while ($t = mysql_fetch_array($query)){
			
			$osszes_ft = $osszes_ft + $t['osszesen'];
			$osszes_db = $osszes_db + $t['mennyiseg'];

		echo '<tr>
				<td class="mediumCell"><a href="index.php?lap=termek&id='.$t['id_termek'].'" target="_blank">'.$t['vonalkod'].'</a></td>
				<td class="mediumCell"><a href="index.php?lap=termek&id='.$t['id_termek'].'" target="_blank"><img src="http://coreshop.hu/'.$func->getHDir($t['id_termek']).'1_small.jpg" style="width:50px; border:2px solid #ccc;" /></a></td>
				<td class="mediumCell"><a href="index.php?lap=termek&id='.$t['id_termek'].'" target="_blank">'.$t['szin'].'</a></td>
				<td class="mediumCell"><a href="index.php?lap=termek&id='.$t['id_termek'].'" target="_blank">'.$t['tulajdonsag'].'</a></td>
				<td class="mediumCell"><a href="index.php?lap=termek&id='.$t['id_termek'].'" target="_blank">'.$t['termek_nev'].'</a></td>
				<td class="mediumCell" align="right">'.number_format($t['termek_ar'], 0, '', ' ').' Ft</td>
				<td class="mediumCell" align="right">'.number_format($t['mennyiseg'], 0, '', ' ').' db</td>
				<td class="mediumCell" align="right">'.number_format($t['osszesen'], 0, '', ' ').' Ft</td>
			</tr>';
			}					
		
		echo '<tr><td colspan="13"><hr></td></tr>';
		// részletező vége
		}
		
	  }
	  
	// talalatok szama / gls rendelesek
	echo '<tr><td colspan="13" class="darkCell" align="left">Találatok száma: <b>'.number_format($sorok,0,".",".").'</b> | ';
	
	if ($_GET['id_statusz']==1) echo 'Összeg: <b>'.number_format($rend_ossz, 0, '', '.').'</b> | ';
	
	echo '<a href="gls_rendelesek.php"><b>Megrendelések &nbsp;&raquo;  &nbsp; GLS CONNECT</b></a> &nbsp;&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;&nbsp; <a href="fogyasjelentes.php"><b>Fogyásjelentés (Excel)</b></a>
	</td></tr>';
	
	// pagestepper
	echo '<tr><td colspan="13" class="darkCell" align="center"><div class="pagestepper">'.@implode(" .. ", $p).'</div></td></tr>';
	?>
   
</table>	