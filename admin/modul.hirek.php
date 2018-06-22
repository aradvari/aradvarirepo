<?

    if (ISSET($_POST['delid'])){

        mysql_query("UPDATE cikkek SET sztorno=NOW() WHERE id_cikk = '".(int)$_POST['delid']."'");
        
    }
    
    
    //SZŰRÉS
    if (ISSET($_POST['alaphelyzet'])){
        
        unset ($_SESSION['cikkek']);
        unset ($_SESSION['cikkek_query']);
        
    }

    if (ISSET($_POST['szures'])){
        
        $_SESSION['cikkek']['id'] = $_POST['id'];    
        $_SESSION['cikkek']['bevezeto'] = $_POST['bevezeto'];
        $_SESSION['cikkek']['teljes_cikk'] = $_POST['teljes_cikk'];
        $_SESSION['cikkek']['datum_tol'] = $_POST['datum_tol'];
        $_SESSION['cikkek']['datum_ig'] = $_POST['datum_ig'];
        
        $_SESSION['cikkek_query']=
            ($_POST['id']==""?"":" AND c.id_cikk = ".(int)$_POST['id'])
           .($_POST['bevezeto']==""?"":" AND c.bevezeto LIKE '%".$_POST['bevezeto']."%'")
           .($_POST['teljes_cikk']==""?"":" AND c.teljes_cikk LIKE '%".$_POST['teljes_cikk']."%'")
           .($_POST['datum_tol']==""?"":" AND DATE_FORMAT(c.datum, '%Y-%m-%d') >= DATE_FORMAT('".date("Y-m-d", strtotime($_POST['datum_tol']))."', '%Y-%m-%d')")
           .($_POST['datum_ig']==""?"":" AND DATE_FORMAT(c.datum, '%Y-%m-%d') <= DATE_FORMAT('".date("Y-m-d", strtotime($_POST['datum_ig']))."', '%Y-%m-%d')");
           
    }

?>
<script>
    
    function delCategory(str){
    
        if (confirm("Valóban törli véglegesen a hírt?")){

            document.delCatForm.delid.value=str;
            document.delCatForm.submit();

        }
        
    }

    </script>

<br>

<form method="post">
<table border="0" cellspacing="1" cellpadding="2">
    <tr>
      <td width="100" class="darkCell" align="center">ID</td>
      <td width="200" class="lightCell"><input type="text" style="width:100%" name="id" value="<?=$_SESSION['cikkek']['id']?>"></td>
      <td width="100" class="darkCell" align="center">Dátum</td>
      <td width="200" class="lightCell">
        <input type="text" style="width:80px" name="datum_tol" value="<?=$_SESSION['cikkek']['datum_tol']?>" onclick="displayDatePicker('datum_tol');"> - <input type="text" style="width:80px" name="datum_ig" value="<?=$_SESSION['cikkek']['datum_ig']?>" onclick="displayDatePicker('datum_ig');">
      </td>
    </tr>
    <tr>
      <td width="100" class="darkCell" align="center">Bevezető</td>
      <td width="200" class="lightCell"><input type="text" style="width:100%" name="bevezeto" value="<?=$_SESSION['cikkek']['bevezeto']?>"></td>
      <td width="100" class="darkCell" align="center">Teljes hír</td>
      <td width="200" class="lightCell"><input type="text" style="width:100%" name="teljes_cikk" value="<?=$_SESSION['cikkek']['teljes_cikk']?>"></td>
    </tr>                               
    <tr>
      <td class="darkCell" align="center" colspan="4"><input type="submit" class="form" value="szűrés" name="szures" /> <input type="submit" class="form" value="alaphelyzet" name="alaphelyzet" /></td>
    </tr>
</table>
</form>

<br>

<form method="post" name="delCatForm" id="delCatForm">
    <input type="hidden" id="delid" name="delid" />
</form>
      
<table width="100%" border="0" cellspacing="0" cellpadding="10">
          <tr>
            <td>
              <table border="0" cellspacing="1" cellpadding="2">
                <tr align="center">
                  <td width="36" class="darkCell">ID</td>
                  <td width="300" class="darkCell">Bevezető</td>
                  <td width="400" class="darkCell">Hír részlet</td>
                  <td width="100" class="darkCell">Dátum</td>
                  <td width="50" class="darkCell">&nbsp;</td>
                </tr>
				
                <?php
                
                  if (!ISSET($_GET['oldal'])) $oldal = 0;
                  else $oldal = (int)$_GET['oldal'];
                
                  $sql = "
                    SELECT 
                    *
                    FROM cikkek c
                    WHERE c.sztorno IS NULL ".$_SESSION['cikkek_query']."
                    ORDER BY c.id_cikk DESC
                  ";
                  
                  $_SESSION['excel_export'] = "
                    SELECT 
                    c.id_cikk `ID`,
                    c.bevezeto `Bevezető`,
                    c.teljes_cikk `Teljes hír`,
                    c.datum `Dátum`
                    FROM cikkek c
                    WHERE c.sztorno IS NULL ".$_SESSION['cikkek_query']."
                    ORDER BY c.id_cikk DESC
                  ";
                  
                  $sorok = mysql_num_rows(mysql_query($sql));
                
				  $query_user=mysql_query($sql." LIMIT ".($oldal*50).", 50"); 
                  
                  $lapok = ceil($sorok/50);
                  
                  $sorstyle='#FFFFFF';
				  
                  for ($go=1; $go<=$lapok; $go++){
                  
                    if ($oldal == $go-1) $st = 'style="color:yellow; font-weight:bold"';
                    else $st = 'style="color:white"';
                      
                    $p[] = '<a href="index.php?lap=hirek&oldal='.($go-1).'" '.$st.'>'.$go.'</a>';                      
                      
                  }
                  
                  echo '<tr align="center"><td colspan="9" class="darkCell">'.@implode("..", $p).'</td></tr>';
                  
                  while ($adatok=mysql_fetch_array($query_user)){
				    
                    $sorstyle=='lightCell'?$sorstyle='darkCell':$sorstyle='lightCell';

				    echo '<tr style="height:25px" class="'.$sorstyle.'" onMouseOver="this.className=\'mediumCell\';this.style.cursor=\'hand\'" onMouseOut="this.className=\''.$sorstyle.'\';">';
                    echo '<td onClick="document.location.href=\'index.php?lap=hire&id='.$adatok['id_cikk'].'\'"><div align="right">'.$adatok['id_cikk'].'&nbsp;</div></td>
                          <td onClick="document.location.href=\'index.php?lap=hir&id='.$adatok['id_cikk'].'\'"><div align="left">'.$adatok['bevezeto'].'&nbsp;</div></td>
                          <td onClick="document.location.href=\'index.php?lap=hir&id='.$adatok['id_cikk'].'\'"><div align="left">'.substr(strip_tags($adatok['teljes_cikk']), 0, 80).'&nbsp;</div></td>
                          <td onClick="document.location.href=\'index.php?lap=hir&id='.$adatok['id_cikk'].'\'"><div align="left">'.$adatok['datum'].'&nbsp;</div></td>
                          <td><div align="center"><img style="cursor:pointer" onclick="delCategory('.$adatok['id_cikk'].')" src="images/icons/delete.png" width="13" alt="termék törlése"></div></td>';
                    echo '</tr>';
                    
				  }
                  
                  echo '<tr align="center"><td colspan="9" class="darkCell">'.@implode("..", $p).'</td></tr>';
                  echo '<tr align="left"><td colspan="9" class="darkCell"><a href="excel_export.php">Excel export</a></td></tr>';

				?>
               
            </table></td>
          </tr>
</table>