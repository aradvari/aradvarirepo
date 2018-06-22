<?

    //SZŰRÉS
    if (ISSET($_POST['alaphelyzet'])){
        
        unset ($_SESSION['tranzakciok']);
        unset ($_SESSION['tranzakciok_query']);
        
    }

    if (ISSET($_POST['szures'])){
        
        $_SESSION['tranzakciok']['id_tol'] = $_POST['id_tol'];
        $_SESSION['tranzakciok']['id_ig'] = $_POST['id_ig'];
        $_SESSION['tranzakciok']['nev'] = $_POST['nev'];
        $_SESSION['tranzakciok']['osszeg_tol'] = $_POST['osszeg_tol'];
        $_SESSION['tranzakciok']['osszeg_ig'] = $_POST['osszeg_ig'];
        $_SESSION['tranzakciok']['allapot'] = $_POST['allapot'];
        $_SESSION['tranzakciok']['megrendeles_szama'] = $_POST['megrendeles_szama'];
        $_SESSION['tranzakciok']['lezarva'] = $_POST['lezarva'];
        $_SESSION['tranzakciok']['lezarva_tol'] = $_POST['lezarva_tol'];
        $_SESSION['tranzakciok']['lezarva_ig'] = $_POST['lezarva_ig'];
        $_SESSION['tranzakciok']['trid'] = $_POST['trid'];
        $_SESSION['tranzakciok']['anum'] = $_POST['anum'];
        
        $_SESSION['tranzakciok_query']=
            ($_POST['id_tol']==""?"":' AND bt.id_bank_tranzakcio >= '.$_POST['id_tol'])
           .($_POST['id_ig']==""?"":' AND bt.id_bank_tranzakcio <= '.$_POST['id_ig'])
           .($_POST['nev']==""?"":" AND mf.szallitasi_nev LIKE '%".$_POST['nev']."%'")
           .($_POST['megrendeles_szama']==""?"":" AND mf.megrendeles_szama LIKE '%".$_POST['megrendeles_szama']."%'")
           .($_POST['trid']==""?"":" AND bt.trid LIKE '%".$_POST['trid']."%'")
           .($_POST['anum']==""?"":" AND bt.anum LIKE '%".$_POST['anum']."%'")
           .($_POST['osszeg_tol']==""?"":' AND bt.amo >= '.$_POST['osszeg_tol'])
           .($_POST['osszeg_ig']==""?"":' AND bt.amo <= '.$_POST['osszeg_ig'])
           .($_POST['lezarva']==""?"": ($_POST['lezarva']==1?' AND bt.lezarva IS NOT NULL > 0':' AND bt.lezarva IS NULL') )
           .($_POST['lezarva_tol']==""?"":" AND DATE_FORMAT(bt.datum, '%Y-%m-%d') >= DATE_FORMAT('".date("Y-m-d", strtotime($_POST['lezarva_tol']))."', '%Y-%m-%d')")
           .($_POST['lezarva_ig']==""?"":" AND DATE_FORMAT(bt.datum, '%Y-%m-%d') <= DATE_FORMAT('".date("Y-m-d", strtotime($_POST['lezarva_ig']))."', '%Y-%m-%d')");
           
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
        <input type="text" style="width:50px" name="id_tol" value="<?=$_SESSION['tranzakciok']['id_tol']?>"> - <input type="text" style="width:50px" name="id_ig" value="<?=$_SESSION['tranzakciok']['id_ig']?>">
      </td>
      <td width="100" class="darkCell" align="center">Név</td>
      <td width="200" class="lightCell"><input type="text" style="width:100%" name="nev" value="<?=$_SESSION['tranzakciok']['nev']?>"></td>
      <td width="100" class="darkCell" align="center">Dátum</td>
      <td width="200" class="lightCell">
        <input type="text" style="width:80px" name="lezarva_tol" value="<?=$_SESSION['tranzakciok']['lezarva_tol']?>" onclick="displayDatePicker('lezarva_tol');"> - <input type="text" style="width:80px" name="lezarva_ig" value="<?=$_SESSION['tranzakciok']['lezarva_ig']?>" onclick="displayDatePicker('lezarva_ig');">
      </td>
    </tr>
    <tr>
      <td width="100" class="darkCell" align="center">Összeg</td>
      <td width="200" class="lightCell">
        <input type="text" style="width:80px" name="osszeg_tol" value="<?=$_SESSION['tranzakciok']['osszeg_tol']?>"> - <input type="text" style="width:80px" name="osszeg_ig" value="<?=$_SESSION['tranzakciok']['osszeg_ig']?>">
      </td>
      <td width="100" class="darkCell" align="center">Megrendelés száma</td>
      <td width="200" class="lightCell"><input type="text" style="width:100%" name="megrendeles_szama" value="<?=$_SESSION['tranzakciok']['megrendeles_szama']?>"></td>
      <td width="100" class="darkCell" align="center">Lezárva</td>
      <td width="200" class="lightCell">
      <?
        echo $func->createArraySelectBox(array("1"=>"igen", "0"=>"nem", ""=>"Mindegyik"), $_SESSION['tranzakciok']['lezarva'],  "name=\"lezarva\"", "");
      ?>
      </td>
    </tr>
    <tr>
      <td width="100" class="darkCell" align="center">TRID</td>
      <td width="200" class="lightCell"><input type="text" style="width:100%" name="trid" value="<?=$_SESSION['tranzakciok']['trid']?>"></td>
      <td width="100" class="darkCell" align="center">ANUM</td>
      <td width="200" class="lightCell" colspan="3"><input type="text" style="width:100%" name="anum" value="<?=$_SESSION['tranzakciok']['anum']?>"></td>
    </tr>
    <tr>
      <td class="darkCell" align="center" colspan="6"><input type="submit" class="form" value="szűrés" name="szures" /> <input type="submit" class="form" value="alaphelyzet" name="alaphelyzet" /></td>
    </tr>
</table>
</form>

<br>

<table border="0" cellspacing="1" cellpadding="2">
<tr align="center">
  <td width="36" class="darkCell">ID</td>
  <td width="120" class="darkCell">Megr. száma</td>
  <td width="120" class="darkCell">TRID</td>
  <td width="150" class="darkCell">Megrendelő</td>
  <td width="70" class="darkCell">Összeg</td>
  <td width="100" class="darkCell">Állapot</td>
  <td width="300" class="darkCell">Üzenet</td>
  <td width="100" class="darkCell">ANUM</td>
  <td width="120" class="darkCell">Indítva</td>
  <td width="120" class="darkCell">Lezárva</td>
</tr>

<?php

  if (!ISSET($_GET['oldal'])) $oldal = 0;
  else $oldal = (int)$_GET['oldal'];

  $sql = "
    SELECT 
      bt.datum datum_tol, 
      bt.*, 
      mf.*, 
      concat(f.vezeteknev,' ',f.keresztnev) megrendelo
    FROM bank_tranzakciok bt
    LEFT JOIN megrendeles_fej mf ON (mf.id_megrendeles_fej = bt.id_megrendeles_fej)
    LEFT JOIN felhasznalok f ON (f.id = bt.id_felhasznalo)
    WHERE 1=1 ".$_SESSION['tranzakciok_query']."
    ORDER BY bt.id_bank_tranzakcio DESC
  ";
  
  $_SESSION['excel_export'] = "
  ";

  $sorok = mysql_num_rows(mysql_query($sql));

  $query_user=mysql_query($sql." LIMIT ".($oldal*100).", 100"); 
  
  $lapok = ceil($sorok/100);
  
  $sorstyle='#FFFFFF';
  
  for ($go=1; $go<=$lapok; $go++){
  
    if ($oldal == $go-1) $st = 'style="color:yellow; font-weight:bold"';
    else $st = 'style="color:white"';
      
    $p[] = '<a href="index.php?lap=tranzakciok&oldal='.($go-1).'" '.$st.'> '.$go.' </a>';                      
      
  }
  
  echo '<tr align="center"><td colspan="10" class="darkCell">'.@implode("..", $p).'</td></tr>';
  
  while ($adatok=mysql_fetch_array($query_user)){
    
    $sorstyle=='lightCell'?$sorstyle='darkCell':$sorstyle='lightCell';

    echo '<tr style="height:25px" class="'.$sorstyle.'" onMouseOver="this.className=\'mediumCell\';this.style.cursor=\'hand\'" onMouseOut="this.className=\''.$sorstyle.'\';">';
    echo '<td onClick="document.location.href=\'index.php?lap=tranzakcio&id='.$adatok['id_bank_tranzakcio'].'\'"><div align="right">'.$adatok['id_bank_tranzakcio'].'&nbsp;</div></td>
          <td onClick="document.location.href=\'index.php?lap=tranzakcio&id='.$adatok['id_bank_tranzakcio'].'\'"><div align="left">'.$adatok['megrendeles_szama'].'&nbsp;</div></td>
          <td onClick="document.location.href=\'index.php?lap=tranzakcio&id='.$adatok['id_bank_tranzakcio'].'\'"><div align="left">'.$adatok['trid'].'&nbsp;</div></td>
          <td onClick="document.location.href=\'index.php?lap=tranzakcio&id='.$adatok['id_bank_tranzakcio'].'\'"><div align="left">'.$adatok['megrendelo'].'&nbsp;</div></td>
          <td onClick="document.location.href=\'index.php?lap=tranzakcio&id='.$adatok['id_bank_tranzakcio'].'\'"><div align="right">'.number_format($adatok['amo'], 0, '', ' ').' '.$adatok['cur'].'</div></td>
          <td onClick="document.location.href=\'index.php?lap=tranzakcio&id='.$adatok['id_bank_tranzakcio'].'\'"><div align="left">'.($adatok['lezarva']==''?'Folyamatban':'Lezárva').'&nbsp;</div></td>
          <td onClick="document.location.href=\'index.php?lap=tranzakcio&id='.$adatok['id_bank_tranzakcio'].'\'"><div align="left">'.$adatok['rt'].'&nbsp;</div></td>
          <td onClick="document.location.href=\'index.php?lap=tranzakcio&id='.$adatok['id_bank_tranzakcio'].'\'"><div align="left">'.$adatok['anum'].'&nbsp;</div></td>
          <td onClick="document.location.href=\'index.php?lap=tranzakcio&id='.$adatok['id_bank_tranzakcio'].'\'"><div align="left">'.$adatok['datum_tol'].'</div></td>
          <td onClick="document.location.href=\'index.php?lap=tranzakcio&id='.$adatok['id_bank_tranzakcio'].'\'"><div align="left">'.$adatok['lezarva'].'</div></td>';
    echo '</tr>';
    
  }
  
  echo '<tr align="center"><td colspan="10" class="darkCell">'.@implode("..", $p).'</td></tr>';

?>

</table>