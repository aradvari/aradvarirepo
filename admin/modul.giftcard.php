<?                      

    if (ISSET($_POST['delid'])){

        mysql_query("UPDATE giftcard SET ervenyes=NOW() WHERE id_giftcard = '".(int)$_POST['delid']."'");
        
    }
    
    //SZŰRÉS
    if (ISSET($_POST['alaphelyzet'])){
        
        unset ($_SESSION['giftcard']);
        unset ($_SESSION['giftcard_query']);
        unset ($_SESSION['giftcard_query_having']);
        
    }

    if (ISSET($_POST['szures'])){
        
        $_SESSION['giftcard']['id_tol'] = $_POST['id_tol'];
        $_SESSION['giftcard']['id_ig'] = $_POST['id_ig'];
        $_SESSION['giftcard']['kod'] = $_POST['kod'];
        $_SESSION['giftcard']['ertek_tol'] = $_POST['ertek_tol'];
        $_SESSION['giftcard']['ertek_ig'] = $_POST['ertek_ig'];
        $_SESSION['giftcard']['vasarolta'] = $_POST['vasarolta'];
        $_SESSION['giftcard']['felhasznalta'] = $_POST['felhasznalta'];
        $_SESSION['giftcard']['egyenleg_tol'] = $_POST['egyenleg_tol'];
        $_SESSION['giftcard']['egyenleg_ig'] = $_POST['egyenleg_ig'];
        $_SESSION['giftcard']['lezarva_tol'] = $_POST['lezarva_tol'];
        $_SESSION['giftcard']['lezarva_ig'] = $_POST['lezarva_ig'];
        $_SESSION['giftcard']['ervenyes_tol'] = $_POST['ervenyes_tol'];
        $_SESSION['giftcard']['ervenyes_ig'] = $_POST['ervenyes_ig'];
        
        $_SESSION['giftcard_query']=
            ($_POST['id_tol']==""?"":' AND g.id_giftcard >= '.$_POST['id_tol'])
           .($_POST['id_ig']==""?"":' AND g.id_giftcard <= '.$_POST['id_ig'])
           .($_POST['kod']==""?"":" AND g.azonosito_kod LIKE '%".$_POST['kod']."%'")
           .($_POST['vasarolta']==""?"":" AND g.felado_nev LIKE '%".$_POST['vasarolta']."%'")
           .($_POST['felhasznalta']==""?"":" AND g.cimzett_nev LIKE '%".$_POST['felhasznalta']."%'")
           .($_POST['lezarva_tol']==""?"":" AND DATE_FORMAT(g.felhasznalva, '%Y-%m-%d') >= DATE_FORMAT('".date("Y-m-d", strtotime($_POST['lezarva_tol']))."', '%Y-%m-%d')")
           .($_POST['lezarva_ig']==""?"":" AND DATE_FORMAT(g.felhasznalva, '%Y-%m-%d') <= DATE_FORMAT('".date("Y-m-d", strtotime($_POST['lezarva_ig']))."', '%Y-%m-%d')")
           .($_POST['ervenyes_tol']==""?"":" AND DATE_FORMAT(g.ervenyes_tol, '%Y-%m-%d') >= DATE_FORMAT('".date("Y-m-d", strtotime($_POST['ervenyes_tol']))."', '%Y-%m-%d')")
           .($_POST['ervenyes_ig']==""?"":" AND DATE_FORMAT(g.ervenyes_ig, '%Y-%m-%d') <= DATE_FORMAT('".date("Y-m-d", strtotime($_POST['ervenyes_ig']))."', '%Y-%m-%d')");
           
        $_SESSION['giftcard_query_having']=
            ($_POST['ertek_tol']==""?"":' AND max_osszeg >= '.$_POST['ertek_tol'])
           .($_POST['ertek_ig']==""?"":' AND max_osszeg <= '.$_POST['ertek_ig'])
           .($_POST['egyenleg_tol']==""?"":' AND min_osszeg >= '.$_POST['egyenleg_tol'])
           .($_POST['egyenleg_ig']==""?"":' AND min_osszeg <= '.$_POST['egyenleg_ig']);
           
    }
    
?>
<script>

function delCategory(str){

    if (confirm("Valóban érvényteleníti a kódot?")){

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
        <input type="text" style="width:50px" name="id_tol" value="<?=$_SESSION['giftcard']['id_tol']?>"> - <input type="text" style="width:50px" name="id_ig" value="<?=$_SESSION['giftcard']['id_ig']?>">
      </td>
      <td width="100" class="darkCell" align="center">Kód</td>
      <td width="200" class="lightCell"><input type="text" style="width:100%" name="kod" value="<?=$_SESSION['giftcard']['kod']?>"></td>
      <td width="100" class="darkCell" align="center"></td>
      <td width="200" class="lightCell">
      <?
        //echo $func->createArraySelectBox(array("1"=>"%", "2"=>"fix", ""=>"Mindegyik"), $_SESSION['giftcard']['tipus'],  "name=\"tipus\"", "");
      ?>
      </td>
    </tr>
    <tr>
      <td width="100" class="darkCell" align="center">Vásárolt összeg</td>
      <td width="200" class="lightCell">
        <input type="text" style="width:50px" name="ertek_tol" value="<?=$_SESSION['giftcard']['ertek_tol']?>"> - <input type="text" style="width:50px" name="ertek_ig" value="<?=$_SESSION['giftcard']['ertek_ig']?>">
      </td>
      <td width="100" class="darkCell" align="center">Vásárolta</td>
      <td width="200" class="lightCell"><input type="text" style="width:100%" name="vasarolta" value="<?=$_SESSION['giftcard']['vasarolta']?>"></td>
      <td width="100" class="darkCell" align="center">Felhasználta</td>
      <td width="200" class="lightCell"><input type="text" style="width:100%" name="felhasznalta" value="<?=$_SESSION['giftcard']['felhasznalta']?>"></td>
    </tr>
    <tr>
      <td width="100" class="darkCell" align="center">Elérhető egyenleg</td>
      <td width="200" class="lightCell">
        <input type="text" style="width:50px" name="egyenleg_tol" value="<?=$_SESSION['giftcard']['egyenleg_tol']?>"> - <input type="text" style="width:50px" name="egyenleg_ig" value="<?=$_SESSION['giftcard']['egyenleg_ig']?>">
      </td>
      <td width="100" class="darkCell" align="center">Lezárva</td>
      <td width="200" class="lightCell">
        <input type="text" style="width:80px" name="lezarva_tol" value="<?=$_SESSION['giftcard']['lezarva_tol']?>" onclick="displayDatePicker('lezarva_tol');"> - <input type="text" style="width:80px" name="lezarva_ig" value="<?=$_SESSION['giftcard']['lezarva_ig']?>" onclick="displayDatePicker('lezarva_ig');">
      </td>
      <td width="100" class="darkCell" align="center">Érvényes</td>
      <td width="200" class="lightCell">
        <input type="text" style="width:80px" name="ervenyes_tol" value="<?=$_SESSION['giftcard']['ervenyes_tol']?>" onclick="displayDatePicker('ervenyes_tol');"> - <input type="text" style="width:80px" name="ervenyes_ig" value="<?=$_SESSION['giftcard']['ervenyes_ig']?>" onclick="displayDatePicker('ervenyes_ig');">
      </td>
    </tr>
    <tr>
      <td class="darkCell" align="center" colspan="6">
        <input type="submit" class="form" value="szűrés" name="szures" />
        <input type="submit" class="form" value="alaphelyzet" name="alaphelyzet" />
      </td>
    </tr>
</table>
</form>

<br>

<table border="0" cellspacing="1" cellpadding="2">
<tr align="center">
  <td width="40" class="darkCell">ID</td>
  <td width="120" class="darkCell">Kód</td>
  <td width="100" class="darkCell">Kezdő egyenleg</td>
  <td width="100" class="darkCell">Elérhető egyenleg</td>
  <td width="120" class="darkCell">Érvényesség</td>
  <td width="120" class="darkCell">Kiküldve</td>
  <td width="120" class="darkCell">Lezárva</td>
  <td width="180" class="darkCell">Feladó</td>
  <td width="180" class="darkCell">Címzett</td>
</tr>

<?php

  if (!ISSET($_GET['oldal'])) $oldal = 0;
  else $oldal = (int)$_GET['oldal'];

  $sql = "
    SELECT 
      g.*, (min(osszeg)-IFNULL(felhasznalt_osszeg,0)) min_osszeg, max(osszeg) max_osszeg, count(g.azonosito_kod) db
    FROM giftcard g
    WHERE 
    fizetve IS NOT NULL AND ervenyes_ig>now()
    ".$_SESSION['giftcard_query']."
    GROUP BY g.azonosito_kod
    HAVING 1=1 
    ".$_SESSION['giftcard_query_having']."
    ORDER BY g.id_giftcard DESC
  ";
  
  $_SESSION['excel_export'] = "
  ";

  $sorok = mysql_num_rows(mysql_query($sql));

  $query_user=mysql_query($sql." LIMIT ".($oldal*50).", 50"); 
  
  $lapok = ceil($sorok/50);
  
  $sorstyle='#FFFFFF';
  
  for ($go=1; $go<=$lapok; $go++){
  
    if ($oldal == $go-1) $st = 'style="color:yellow; font-weight:bold"';
    else $st = 'style="color:white"';
      
    $p[] = '<a href="index.php?lap=giftcard&oldal='.($go-1).'" '.$st.'>'.$go.'</a>';                      
      
  }
  
  echo '<tr align="center"><td colspan="9" class="darkCell">'.@implode(" .. ", $p).'</td></tr>';
  
  while ($adatok=mysql_fetch_array($query_user)){
    
    $sorstyle=='lightCell'?$sorstyle='darkCell':$sorstyle='lightCell';

    //if ($adatok['db']==1) $delstr='<img style="cursor:pointer" onclick="delCategory('.$adatok['id_kedvezmeny'].')" src="images/icons/delete.png" width="13" alt="Kód érvénytelenítése">';
    //else $delstr='';
    
    echo '<tr style="height:25px; cursor:pointer" class="'.$sorstyle.'" onMouseOver="this.className=\'mediumCell\';" onMouseOut="this.className=\''.$sorstyle.'\';" onclick="document.location.href=\'index.php?lap=gift&id='.$adatok['id_giftcard'].'\'">';
    echo '<td><div align="right">'.$adatok['id_giftcard'].'&nbsp;</div></td>
          <td><div align="left">'.$adatok['azonosito_kod'].'&nbsp;</div></td>
          <td><div align="right">'.number_format($adatok['max_osszeg'], 0, '', ' ').' Ft</div></td>
          <td><div align="right">'.number_format($adatok['min_osszeg'], 0, '', ' ').' Ft</div></td>
          <td><div align="left">'.$adatok['ervenyes_tol'].'<br>'.$adatok['ervenyes_ig'].'</div></td>
          <td><div align="right">'.$adatok['kikuldve'].'</div></td>
          <td><div align="right">'.$adatok['felhasznalva'].'</div></td>
          <td><div align="left">'.$adatok['felado_nev'].'<br>'.$adatok['felado_email'].'</div></td>
          <td><div align="left">'.$adatok['cimzett_nev'].'<br>'.$adatok['cimzett_email'].'</div></td>';
          //<td><div align="center">'.$delstr.'</div></td>';
    echo '</tr>';
    
  }
  
  echo '<tr align="center"><td colspan="9" class="darkCell">'.@implode(" .. ", $p).'</td></tr>';

?>

</table>