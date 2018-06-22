<?

    if (ISSET($_POST['delid'])){

        mysql_query("UPDATE felhasznalok SET modositva=1, modositva2=1, modositva3=1, torolve=NOW() WHERE id = '".(int)$_POST['delid']."'");
        
    }
    
    //SZŰRÉS
    if (ISSET($_POST['alaphelyzet'])){
        
        unset ($_SESSION['felhasznalok']);
        unset ($_SESSION['felhasznalok_query']);
        
    }

    if (ISSET($_POST['szures'])){
        
        $_SESSION['felhasznalok']['nev'] = $_POST['nev'];
        $_SESSION['felhasznalok']['lakcim'] = $_POST['lakcim'];
        $_SESSION['felhasznalok']['email'] = $_POST['email'];
        $_SESSION['felhasznalok']['hirlevel'] = $_POST['hirlevel'];
        $_SESSION['felhasznalok']['aktiv'] = $_POST['aktiv'];
        $_SESSION['felhasznalok']['telefon'] = $_POST['telefon'];
        $_SESSION['felhasznalok']['klubtag'] = $_POST['klubtag'];
        $_SESSION['felhasznalok']['id_tol'] = $_POST['id_tol'];
        $_SESSION['felhasznalok']['id_ig'] = $_POST['id_ig'];
        $_SESSION['felhasznalok']['klubkartya'] = $_POST['klubkartya'];
        
        $_SESSION['felhasznalok_query']=
            ($_POST['nev']==""?"":" AND CONCAT(f.vezeteknev,' ',f.keresztnev,' ',f.cegnev) LIKE '%".$_POST['nev']."%'")
           .($_POST['lakcim']==""?"":" AND CONCAT(f.irszam,' ',f.varos_nev,' ',f.utcanev,' ',f.kozterulet_nev,' ',f.hazszam,' ',f.emelet) LIKE '%".$_POST['lakcim']."%'")
           .($_POST['email']==""?"":" AND f.email LIKE '%".$_POST['email']."%'")
           .($_POST['hirlevel']==""?"":' AND f.hirlevel='.$_POST['hirlevel'])
           .($_POST['aktiv']==""?"":($_POST['aktiv']==1?' AND (f.aktivacios_kod=\'\' OR f.aktivacios_kod IS NULL)':' AND (f.aktivacios_kod!=\'\' AND f.aktivacios_kod IS NOT NULL)'))
           .($_POST['telefon']==""?"":" AND CONCAT(f.telefonszam1,' ',f.telefonszam2) LIKE '%".$_POST['telefon']."%'")
           .($_POST['id_tol']==""?"":' AND f.id >= '.$_POST['id_tol'])
           .($_POST['id_ig']==""?"":' AND f.id <= '.$_POST['id_ig'])
           .($_POST['klubtag']==""?"":' AND (f.klubtag_kod IS NULL OR f.klubtag_kod<1)')
           .($_POST['klubkartya']==""?"": ($_POST['klubkartya']==1?' AND f.kartya_kod > 0':' AND (f.kartya_kod IS NULL OR f.kartya_kod<1)') );
           
        $_SESSION['felhasznalok_having']=
           ($_POST['klubtag']==""?"": ($_POST['klubtag']==1?' HAVING osszeg>50000':'') );
     
		// ID-ig sutiben tarolva 10 napig
		setcookie('admin_felhasznalokid_ig', $_SESSION['felhasznalok']['id_ig'], time() + 86400 * 10);
    }
    
?>
<script>

function delCategory(str){

    if (confirm("Valóban törli véglegesen a felhasználót?")){

        document.delCatForm.delid.value=str;
        document.delCatForm.submit();

    }
    
}

</script>

<form method="post" name="delCatForm" id="delCatForm">
    <input type="hidden" id="delid" name="delid" />
</form>

<br>

<form method="post">
<table border="0" cellspacing="1" cellpadding="2">
    <tr>
      <td width="100" class="darkCell" align="center">ID</td>
      <td width="200" class="lightCell">
        <input type="text" style="width:80px" name="id_tol" value="<?=$_SESSION['felhasznalok']['id_tol']?>" placeholder="<?=($_COOKIE['admin_felhasznalokid_ig']+1);?>" /> - <input type="text" style="width:80px" name="id_ig" value="<?=$_SESSION['felhasznalok']['id_ig']?>" />
      </td>
      <td width="100" class="darkCell" align="center">Név</td>
      <td width="200" class="lightCell"><input type="text" style="width:100%" name="nev" value="<?=$_SESSION['felhasznalok']['nev']?>"></td>
      <td width="100" class="darkCell" align="center">Telefon</td>
      <td width="200" class="lightCell"><input type="text" style="width:100%" name="telefon" value="<?=$_SESSION['felhasznalok']['telefon']?>"></td>
    </tr>
    <tr>
      <td width="100" class="darkCell" align="center">E-mail cím</td>
      <td width="200" class="lightCell"><input type="text" style="width:100%" name="email" value="<?=$_SESSION['felhasznalok']['email']?>"></td>
      <td width="100" class="darkCell" align="center">Lakcím</td>
      <td width="200" class="lightCell"><input type="text" style="width:100%" name="lakcim" value="<?=$_SESSION['felhasznalok']['lakcim']?>"></td>
      <td width="100" class="darkCell" align="center">Hírlevél</td>
      <td width="200" class="lightCell">
      <?
        echo $func->createArraySelectBox(array("1"=>"igen", "0"=>"nem", ""=>"Mindegyik"), $_SESSION['felhasznalok']['hirlevel'],  "name=\"hirlevel\"", "");
      ?>
      </td>
    </tr>
    <tr>
      <td width="100" class="darkCell" align="center">Aktív</td>
      <td width="200" class="lightCell">
      <?
        echo $func->createArraySelectBox(array("1"=>"igen", "0"=>"nem", ""=>"Mindegyik"), $_SESSION['felhasznalok']['hirlevel'],  "name=\"hirlevel\"", "");
      ?>
      </td>
      <td width="100" class="darkCell" align="center">Klubtag</td>
      <td width="200" class="lightCell">
      <?
        echo $func->createArraySelectBox(array("1"=>"igen", "0"=>"nem", ""=>"Mindegyik"), $_SESSION['felhasznalok']['klubtag'],  "name=\"klubtag\"", "");
      ?>
      </td>
      <td width="100" class="darkCell" align="center">Van klubkártyája</td>
      <td width="200" class="lightCell">
      <?
        echo $func->createArraySelectBox(array("1"=>"igen", "0"=>"nem", ""=>"Mindegyik"), $_SESSION['felhasznalok']['klubkartya'],  "name=\"klubkartya\"", "");
      ?>
      </td>
    </tr>
    <tr>
      <td class="darkCell" align="center" colspan="6"><input type="submit" class="form" value="szűrés" name="szures" /> <input type="submit" class="form" value="alaphelyzet" name="alaphelyzet" /></td>
    </tr>
</table>
</form>

<br>

<table border="0" cellspacing="1" cellpadding="2">
<!-- <tr align="center">
  <td width="36" class="darkCell">ID</td>
  <td width="150" class="darkCell">Név</td>
  <td width="300" class="darkCell">Lakcím</td>
  <td width="150" class="darkCell">E-mail</td>
  <td width="70" class="darkCell">Telefon</td>
  <td width="70" class="darkCell">Klubtag</td>
  <td width="70" class="darkCell">Hírlevél</td>
  <td width="70" class="darkCell">Aktív</td>
  <td width="50" class="darkCell">&nbsp;</td>
</tr> -->

<?php

  if (!ISSET($_GET['oldal'])) $oldal = 0;
  else $oldal = (int)$_GET['oldal'];

  $sql = "
    SELECT 
      f.id,
      (CASE WHEN length(f.cegnev)<3 THEN CONCAT(f.vezeteknev, ' ', f.keresztnev) ELSE f.cegnev END) nev,
      concat(f.irszam, ' ', f.varos_nev, ', ', f.utcanev, ' ', f.kozterulet_nev, ' ', f.hazszam, '(', f.emelet, ')') cim,
      f.email,
      concat(telefonszam1, '<br>', telefonszam2) tel,
      f.klubtag_kod,
      f.hirlevel,
      f.aktivacios_kod,
      sum(IFNULL(k.kikerulesi_ar,0)) osszeg
      /* (CASE WHEN fk.igenyelt IS NOT NULL THEN 1 ELSE 0 END) karkoto */
    FROM felhasznalok f
    /* LEFT JOIN felhasznalok_karkoto fk ON (fk.id_felhasznalo = f.id) */
    LEFT JOIN keszlet k ON (k.id_felhasznalok = f.id)
    WHERE f.torolve IS NULL ".$_SESSION['felhasznalok_query']."
    GROUP BY f.id
    ".$_SESSION['felhasznalok_having']."	
    ORDER BY f.id DESC	
  ";
  
  //echo $sql;
  
  $_SESSION['excel_export'] = "
    SELECT 
    f.id `ID`,
    f.email `E-mail`,
    f.vezeteknev `Vezetéknév`,
    f.keresztnev `Keresztnév`,
    f.irszam `Ir.szám`,
    f.varos_nev `Város`,
    f.utcanev `Utca`,
    f.kozterulet_nev `Közterület típusa`,
    f.hazszam `Házszám`,
    f.emelet `Emelet`,
    telefonszam1 `Telefonszám 1.`,
    telefonszam2 `Telefonszám 2.`,
    (CASE WHEN f.hirlevel=1 THEN 'igen' ELSE 'nem' END) `Hírlevelet kér`,
    (CASE WHEN f.aktivacios_kod=1 THEN 'igen' ELSE 'nem' END) `Aktivált`,
    f.regisztralva `Regisztrálva`,
    f.utolso_belepes `Utolsó belépés`
    FROM felhasznalok f
    LEFT JOIN felhasznalok_karkoto fk ON (fk.id_felhasznalo = f.id)
    WHERE f.torolve IS NULL ".$_SESSION['felhasznalok_query']."
    ORDER BY f.id DESC
  ";

  $_SESSION['gls_export'] = "
    SELECT 
    f.id,
    (CASE WHEN length(f.cegnev)<3 THEN concat(f.vezeteknev,' ',f.keresztnev) ELSE f.cegnev END),
    f.email,
    f.irszam,
    f.varos_nev,
    concat(f.utcanev,' ',f.kozterulet_nev,' ',f.hazszam,' (', f.emelet, ')'),
    /*concat(f.telefonszam1, ' ', f.telefonszam2),*/
	concat(insert(telefonszam1, 11, 0, ' '), ' ', insert(telefonszam2, 11, 0, ' ')),
	f.orszag_nev
    FROM felhasznalok f
    WHERE f.torolve IS NULL ".$_SESSION['felhasznalok_query']."
	/*AND f.id IN (SELECT id_felhasznalok FROM keszlet)*/
    ORDER BY f.id DESC
  ";
  
  $_SESSION['dpd_export'] = "
    SELECT 
    f.id,
    (CASE WHEN length(f.cegnev)<3 THEN concat(f.vezeteknev,' ',f.keresztnev) ELSE f.cegnev END),
    f.email,
    f.irszam,
    f.varos_nev,
    concat(f.utcanev,' ',f.kozterulet_nev,' ',f.hazszam,' (', f.emelet, ')'),
    concat(f.telefonszam1, ' ', f.telefonszam2)
    FROM felhasznalok f
    WHERE f.torolve IS NULL ".$_SESSION['felhasznalok_query']."
    ORDER BY f.id DESC
  ";

  //$sorok = mysql_num_rows(mysql_query($sql));
  $sorok = mysql_num_rows(mysql_query($sql." LIMIT 500"));

  $query_user=mysql_query($sql." LIMIT ".($oldal*100).", 100"); 
  //$query_user=mysql_query($sql." LIMIT 100");   
  
  
  $lapok = ceil($sorok/100);
  
  $sorstyle='#FFFFFF';
  
  for ($go=1; $go<=$lapok; $go++){
  
    if ($oldal == $go-1) $st = 'style="color:yellow; font-weight:bold"';
    else $st = 'style="color:white"';
      
    $p[] = '<a href="index.php?lap=felhasznalok&oldal='.($go-1).'" '.$st.'> '.$go.' </a>';                      
      
  }
 
  
  // export
  echo '<tr><td colspan="9" class="darkCell" align="center">Felhasználó export: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="infocentrum_export.php">INFOCENTRUM EXPORT</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="gls_export.php">GLS CONNECT EXPORT</a></td></tr>';
  // pagestepper
  //echo '<tr align="center"><td colspan="9" class="darkCell"><div class="pagestepper">'.@implode("..", $p).'</div></td></tr>';
  
  // header
  echo '<tr align="center">
		  <td width="36" class="darkCell">ID</td>
		  <td width="150" class="darkCell">Név</td>
		  <td width="300" class="darkCell">Lakcím</td>
		  <td width="150" class="darkCell">E-mail</td>
		  <td width="70" class="darkCell">Telefon</td>
		  <td width="70" class="darkCell">Klubtag</td>
		  <td width="70" class="darkCell">Hírlevél</td>
		  <td width="70" class="darkCell">Aktív</td>
		  <td width="50" class="darkCell">&nbsp;</td>
	</tr>';
  
  while ($adatok=mysql_fetch_array($query_user)){
    
    $sorstyle=='lightCell'?$sorstyle='darkCell':$sorstyle='lightCell';
	
	if($adatok['aktivacios_kod']=='login_once')	$login_once='<span style="color:blue;font-size:10px;">(1x)</span>'; else $login_once='';

    echo '<tr style="height:25px" class="'.$sorstyle.'" onMouseOver="this.className=\'mediumCell\';this.style.cursor=\'hand\'" onMouseOut="this.className=\''.$sorstyle.'\';">';
    echo '<td onClick="document.location.href=\'index.php?lap=felhasznalo&id='.$adatok['id'].'\'"><div align="right">'.$adatok['id'].'&nbsp;</div></td>
          <td onClick="document.location.href=\'index.php?lap=felhasznalo&id='.$adatok['id'].'\'"><div align="left">'.$adatok['nev'].'&nbsp;</div></td>
          <td onClick="document.location.href=\'index.php?lap=felhasznalo&id='.$adatok['id'].'\'"><div align="left">'.str_replace("()", "", $adatok['cim']).'&nbsp;</div></td>
          <td onClick="document.location.href=\'index.php?lap=felhasznalo&id='.$adatok['id'].'\'"><div align="left">'.$adatok['email'].'&nbsp;'.$login_once.'</div></td>
          <td onClick="document.location.href=\'index.php?lap=felhasznalo&id='.$adatok['id'].'\'"><div align="left">'.$adatok['tel'].'</div></td>
          <td onClick="document.location.href=\'index.php?lap=felhasznalo&id='.$adatok['id'].'\'"><div align="center">'.((int)$adatok['klubtag_kod']>'0'?'igen':'nem').'</div></td>
          <td onClick="document.location.href=\'index.php?lap=felhasznalo&id='.$adatok['id'].'\'"><div align="center">'.($adatok['hirlevel']=='1'?'igen':'nem').'</div></td>
          <td onClick="document.location.href=\'index.php?lap=felhasznalo&id='.$adatok['id'].'\'"><div align="center">'.($adatok['aktivacios_kod']==''?'aktív':'nem aktív').'</div></td>
          <td><div align="center"><img style="cursor:pointer" onclick="delCategory('.$adatok['id'].')" src="images/icons/delete.png" width="13" alt="felhasználó törlése"></div></td>';
    echo '</tr>';
    
  }
  
  // pagestepper
  echo '<tr align="center"><td colspan="9" class="darkCell"><div class="pagestepper">'.@implode("..", $p).'</div></td></tr>';
  
  // export
  echo '<tr align="center"><td colspan="9" class="darkCell">Felhasználó export: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="infocentrum_export.php">INFOCENTRUM EXPORT</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="gls_export.php">GLS CONNECT EXPORT</a></td></tr>';

?>

</table>