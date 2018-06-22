<?                      

    function generateCode($id){

        $dt0 = substr(date("U"), 1, 3);
        $dt1 = substr(date("U"), 6, 2);
        $dt2 = substr(date("U"), 8, 2);
        
        return str_pad($id, 6, 0, STR_PAD_LEFT).$dt1.$dt2.$dt0;

    }

    if (ISSET($_POST['kikuldes'])){
        
        $sql = "
        SELECT 
        f.id 
        FROM felhasznalok f
        LEFT JOIN kedvezmenyek k ON (k.id_felhasznalo = f.id)
        WHERE 
        DATE_FORMAT( CONCAT( f.szuletesi_ev, '-', f.szuletesi_honap, '-', f.szuletesi_nap ) , '%m-%d' ) = DATE_FORMAT( NOW() , '%m-%d' ) AND
        ( DATE_FORMAT(k.letrehozva , '%Y-%m-%d' ) <> DATE_FORMAT( NOW() , '%Y-%m-%d') OR k.letrehozva IS NULL )
        ";
        
        $query = mysql_query($sql);
        
        while($adatok = mysql_fetch_assoc($query)){
            
            $sql = "INSERT INTO kedvezmenyek (kod, kedvezmeny_tipusa, kedvezmeny_erteke, id_felhasznalo, ervenyes, letrehozva) VALUES ('".generateCode($adatok['id'])."', 1, ".(int)$func->getMainParam("szulinapi_kedvezmeny").", ".$adatok['id'].", DATE_ADD( NOW(), INTERVAL ".(int)$func->getMainParam("kedvezmeny_ervenyesseg")." DAY), NOW())";
                
            mysql_query($sql);
                
        }
        
        unset ($_SESSION['kedvezmenyek']);
        unset ($_SESSION['kedvezmenyek_query']);
        unset ($_POST);
        $_POST['szures'] = true;
        $_SESSION['kedvezmenyek']['letrehozva'] = date("Y-m-d");
        
    }
    
    if (ISSET($_POST['delid'])){

        mysql_query("UPDATE kedvezmenyek SET ervenyes=NOW() WHERE id_kedvezmeny = '".(int)$_POST['delid']."'");
        
    }
    
    //SZŰRÉS
    if (ISSET($_POST['alaphelyzet'])){
        
        unset ($_SESSION['kedvezmenyek']);
        unset ($_SESSION['kedvezmenyek_query']);
        
    }

    if (ISSET($_POST['szures'])){
        
        $_SESSION['kedvezmenyek']['id_tol'] = $_POST['id_tol'];
        $_SESSION['kedvezmenyek']['id_ig'] = $_POST['id_ig'];
        $_SESSION['kedvezmenyek']['kod'] = $_POST['kod'];
        $_SESSION['kedvezmenyek']['tipus'] = $_POST['tipus'];
        $_SESSION['kedvezmenyek']['ertek_tol'] = $_POST['ertek_tol'];
        $_SESSION['kedvezmenyek']['ertek_ig'] = $_POST['ertek_ig'];
        $_SESSION['kedvezmenyek']['tarsitva'] = $_POST['tarsitva'];
        $_SESSION['kedvezmenyek']['felhasznalta'] = $_POST['felhasznalta'];
        $_SESSION['kedvezmenyek']['felhasznalhato'] = $_POST['felhasznalhato'];
        $_SESSION['kedvezmenyek']['felhasznalva_tol'] = $_POST['felhasznalva_tol'];
        $_SESSION['kedvezmenyek']['felhasznalva_ig'] = $_POST['felhasznalva_ig'];
        $_SESSION['kedvezmenyek']['ervenyes_tol'] = $_POST['ervenyes_tol'];
        $_SESSION['kedvezmenyek']['ervenyes_ig'] = $_POST['ervenyes_ig'];
        
        $_SESSION['kedvezmenyek_query']=
            ($_POST['id_tol']==""?"":' AND k.id_kedvezmeny >= '.$_POST['id_tol'])
           .($_POST['id_ig']==""?"":' AND k.id_kedvezmeny <= '.$_POST['id_ig'])
           .($_POST['kod']==""?"":" AND k.kod LIKE '%".$_POST['kod']."%'")
           .($_POST['tipus']==""?"":' AND k.kedvezmeny_tipusa='.$_POST['tipus'])
           .($_POST['ertek_tol']==""?"":' AND k.kedvezmeny_erteke >= '.$_POST['ertek_tol'])
           .($_POST['ertek_ig']==""?"":' AND k.kedvezmeny_erteke <= '.$_POST['ertek_ig'])
           .($_POST['tarsitva']==""?"":" AND CONCAT(f.vezeteknev, ' ', f.keresztnev) LIKE '%".$_POST['tarsitva']."%'")
           .($_POST['felhasznalta']==""?"":" AND CONCAT(f2.vezeteknev, ' ', f2.keresztnev) LIKE '%".$_POST['felhasznalta']."%'")
           .($_POST['felhasznalhato']==""?"":' AND k.ervenyes '.$_POST['felhasznalhato'].' NOW()')
           .($_POST['felhasznalva_tol']==""?"":" AND DATE_FORMAT(k.felhasznalas_datuma, '%Y-%m-%d') >= DATE_FORMAT('".date("Y-m-d", strtotime($_POST['felhasznalva_tol']))."', '%Y-%m-%d')")
           .($_POST['felhasznalva_ig']==""?"":" AND DATE_FORMAT(k.felhasznalas_datuma, '%Y-%m-%d') <= DATE_FORMAT('".date("Y-m-d", strtotime($_POST['felhasznalva_ig']))."', '%Y-%m-%d')")
           .($_POST['ervenyes_tol']==""?"":" AND DATE_FORMAT(k.ervenyes, '%Y-%m-%d') >= DATE_FORMAT('".date("Y-m-d", strtotime($_POST['ervenyes_tol']))."', '%Y-%m-%d')")
           .($_POST['ervenyes_ig']==""?"":" AND DATE_FORMAT(k.ervenyes, '%Y-%m-%d') <= DATE_FORMAT('".date("Y-m-d", strtotime($_POST['ervenyes_ig']))."', '%Y-%m-%d')")
           .($_SESSION['kedvezmenyek']['letrehozva']==""?"":" AND DATE_FORMAT(k.letrehozva, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d')");
           
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
        <input type="text" style="width:50px" name="id_tol" value="<?=$_SESSION['kedvezmenyek']['id_tol']?>"> - <input type="text" style="width:50px" name="id_ig" value="<?=$_SESSION['kedvezmenyek']['id_ig']?>">
      </td>
      <td width="100" class="darkCell" align="center">Kód</td>
      <td width="200" class="lightCell"><input type="text" style="width:100%" name="kod" value="<?=$_SESSION['kedvezmenyek']['kod']?>"></td>
      <td width="100" class="darkCell" align="center">Típus</td>
      <td width="200" class="lightCell">
      <?
        echo $func->createArraySelectBox(array("1"=>"%", "2"=>"fix", ""=>"Mindegyik"), $_SESSION['kedvezmenyek']['tipus'],  "name=\"tipus\"", "");
      ?>
      </td>
    </tr>
    <tr>
      <td width="100" class="darkCell" align="center">Érték</td>
      <td width="200" class="lightCell">
        <input type="text" style="width:50px" name="ertek_tol" value="<?=$_SESSION['kedvezmenyek']['ertek_tol']?>"> - <input type="text" style="width:50px" name="ertek_ig" value="<?=$_SESSION['kedvezmenyek']['ertek_ig']?>">
      </td>
      <td width="100" class="darkCell" align="center">Társítva</td>
      <td width="200" class="lightCell"><input type="text" style="width:100%" name="tarsitva" value="<?=$_SESSION['kedvezmenyek']['tarsitva']?>"></td>
      <td width="100" class="darkCell" align="center">Felhasznalta</td>
      <td width="200" class="lightCell"><input type="text" style="width:100%" name="felhasznalta" value="<?=$_SESSION['kedvezmenyek']['felhasznalta']?>"></td>
    </tr>
    <tr>
      <td width="100" class="darkCell" align="center">Felhasználható</td>
      <td width="200" class="lightCell">
      <?
        echo $func->createArraySelectBox(array("<>"=>"Mindegyik", ">"=>"Igen", "<"=>"Nem"), $_SESSION['kedvezmenyek']['felhasznalhato'],  "name=\"felhasznalhato\"", "");
      ?>
      </td>
      <td width="100" class="darkCell" align="center">Felhasználva</td>
      <td width="200" class="lightCell">
        <input type="text" style="width:80px" name="felhasznalva_tol" value="<?=$_SESSION['kedvezmenyek']['felhasznalva_tol']?>" onclick="displayDatePicker('felhasznalva_tol');"> - <input type="text" style="width:80px" name="felhasznalva_ig" value="<?=$_SESSION['kedvezmenyek']['felhasznalva_ig']?>" onclick="displayDatePicker('felhasznalva_ig');">
      </td>
      <td width="100" class="darkCell" align="center">Érvényes</td>
      <td width="200" class="lightCell">
        <input type="text" style="width:80px" name="ervenyes_tol" value="<?=$_SESSION['kedvezmenyek']['ervenyes_tol']?>" onclick="displayDatePicker('ervenyes_tol');"> - <input type="text" style="width:80px" name="ervenyes_ig" value="<?=$_SESSION['kedvezmenyek']['ervenyes_ig']?>" onclick="displayDatePicker('ervenyes_ig');">
      </td>
    </tr>
    <tr>
      <td class="darkCell" align="center" colspan="6">
        <input type="submit" class="form" value="szűrés" name="szures" />
        <input type="submit" class="form" value="alaphelyzet" name="alaphelyzet" />
        <input type="submit" class="form" value="napi kódok kiküldése" name="kikuldes" />
      </td>
    </tr>
</table>
</form>

<br>

<table border="0" cellspacing="1" cellpadding="2">
<tr align="center">
  <td width="36" class="darkCell">ID</td>
  <td width="180" class="darkCell">Kód</td>
  <td width="60" class="darkCell">Típus</td>
  <td width="100" class="darkCell">Érték</td>
  <td width="150" class="darkCell">Társítva</td>
  <td width="150" class="darkCell">Felhasználta</td>
  <td width="120" class="darkCell">Felhasználva</td>
  <td width="120" class="darkCell">Érvényesség</td>
  <td width="50" class="darkCell">&nbsp;</td>
</tr>

<?php

  if (!ISSET($_GET['oldal'])) $oldal = 0;
  else $oldal = (int)$_GET['oldal'];

  $sql = "
    SELECT 
      id_kedvezmeny,
      kod,
      (CASE WHEN kedvezmeny_tipusa=1 THEN '%' ELSE 'fix' END) tipus,
      kedvezmeny_erteke,
      CONCAT(f.vezeteknev, ' ', f.keresztnev) nev,
      CONCAT(f2.vezeteknev, ' ', f2.keresztnev) nev_tenyleges,
      felhasznalas_datuma,
      ervenyes,
      (CASE WHEN ervenyes>NOW() THEN 1 ELSE 0 END) aktiv,
      kedvezmeny_tipusa
    FROM kedvezmenyek k
    LEFT JOIN felhasznalok f ON (f.id = k.id_felhasznalo)
    LEFT JOIN felhasznalok f2 ON (f2.id = k.id_felhasznalo_tenyleges)
    WHERE 1=1 ".$_SESSION['kedvezmenyek_query']."
    ORDER BY k.id_kedvezmeny DESC
  ";
  
  $_SESSION['excel_export'] = "
    SELECT 
      id_kedvezmeny `ID`,
      kod `Kód`,
      (CASE WHEN kedvezmeny_tipusa=1 THEN '%' ELSE 'fix' END) `Kedvezmény típusa`,
      kedvezmeny_erteke `Kedvezmény értéke`,
      CONCAT(f.vezeteknev, ' ', f.keresztnev) nev `Felhasználó neve`,
      felhasznalas_datuma ´Felhasználás dátuma´,
      ervenyes `Érvényes`
    FROM kedvezmenyek k
    LEFT JOIN kedvezmenyk f ON (f.id = k.id_kedvezmeny)
    WHERE 1=1 ".$_SESSION['kedvezmenyek_query']."
    ORDER BY k.id DESC
  ";

  $sorok = mysql_num_rows(mysql_query($sql));

  $query_user=mysql_query($sql." LIMIT ".($oldal*50).", 50"); 
  
  $lapok = ceil($sorok/50);
  
  $sorstyle='#FFFFFF';
  
  for ($go=1; $go<=$lapok; $go++){
  
    if ($oldal == $go-1) $st = 'style="color:yellow; font-weight:bold"';
    else $st = 'style="color:white"';
      
    $p[] = '<a href="index.php?lap=kedvezmenyek&oldal='.($go-1).'" '.$st.'>'.$go.'</a>';                      
      
  }
  
  echo '<tr align="center"><td colspan="9" class="darkCell">'.@implode("..", $p).'</td></tr>';
  
  while ($adatok=mysql_fetch_array($query_user)){
    
    $sorstyle=='lightCell'?$sorstyle='darkCell':$sorstyle='lightCell';

    if ($adatok['aktiv']==1) $delstr='<img style="cursor:pointer" onclick="delCategory('.$adatok['id_kedvezmeny'].')" src="images/icons/delete.png" width="13" alt="Kód érvénytelenítése">';
    else $delstr='';
    
    echo '<tr style="height:25px" class="'.$sorstyle.'" onMouseOver="this.className=\'mediumCell\';" onMouseOut="this.className=\''.$sorstyle.'\';">';
    echo '<td><div align="right">'.$adatok['id_kedvezmeny'].'&nbsp;</div></td>
          <td><div align="left">'.$adatok['kod'].'&nbsp;</div></td>
          <td><div align="left">'.$adatok['tipus'].'&nbsp;</div></td>
          <td><div align="right">'.number_format($adatok['kedvezmeny_erteke'], 0, '', ' ').' '.($adatok['kedvezmeny_tipusa']==1?'%':'Ft').'</div></td>
          <td><div align="left">'.$adatok['nev'].'&nbsp;</div></td>
          <td><div align="left">'.$adatok['nev_tenyleges'].'&nbsp;</div></td>
          <td><div align="left">'.$adatok['felhasznalas_datuma'].'</div></td>
          <td><div align="left">'.$adatok['ervenyes'].'</div></td>
          <td><div align="center">'.$delstr.'</div></td>';
    echo '</tr>';
    
  }
  
  echo '<tr align="center"><td colspan="9" class="darkCell">'.@implode("..", $p).'</td></tr>';

?>

</table>