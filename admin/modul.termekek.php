<?

    //SZŰRÉS
    if (ISSET($_POST['alaphelyzet'])){
        
        unset ($_SESSION['termekek']);
        unset ($_SESSION['termekek_query']);
        unset ($_SESSION['termekek_having']);
        unset ($_SESSION['termekek_order']);
        unset ($_SESSION['termekek_sort']);
        
    }

    if (ISSET($_POST['szures'])){
        
        $_SESSION['termekek']['id'] = $_POST['id'];    
        $_SESSION['termekek']['cikkszam'] = $_POST['cikkszam'];
        $_SESSION['termekek']['vonalkod'] = $_POST['vonalkod'];
        $_SESSION['termekek']['marka'] = $_POST['marka'];
        $_SESSION['termekek']['szin'] = $_POST['szin'];
        $_SESSION['termekek']['termeknev'] = $_POST['termeknev'];
        $_SESSION['termekek']['aktiv'] = $_POST['aktiv'];
        $_SESSION['termekek']['kategoria'] = $_POST['kategoria'];
        $_SESSION['termekek']['ar_tol'] = $_POST['ar_tol'];
        $_SESSION['termekek']['ar_ig'] = $_POST['ar_ig'];
        $_SESSION['termekek']['db_tol'] = $_POST['db_tol'];
        $_SESSION['termekek']['db_ig'] = $_POST['db_ig'];
        
        $_SESSION['termekek_query']=
            ($_POST['id']==""?"":" AND t.id = ".(int)$_POST['id'])
           .($_POST['cikkszam']==""?"":" AND t.cikkszam LIKE '%".$_POST['cikkszam']."%'")
           .($_POST['vonalkod']==""?"":" AND v.vonalkod LIKE '%".$_POST['vonalkod']."%'")
           .($_POST['marka']==""?"":" AND t.markaid = ".$_POST['marka'])
           .($_POST['szin']==""?"":" AND t.szin LIKE '%".$_POST['szin']."%'")
           .($_POST['termeknev']==""?"":" AND t.termeknev LIKE '%".$_POST['termeknev']."%'")
           .($_POST['aktiv']==""?"":' AND t.aktiv='.$_POST['aktiv'])
           .($_POST['kategoria']==""?"":' AND t.kategoria='.$_POST['kategoria'])
           .($_POST['ar_tol']==""?"":' AND (t.kisker_ar >= '.$_POST['ar_tol'].' OR t.akcios_kisker_ar >= '.$_POST['ar_tol'].' OR t.klub_ar >= '.$_POST['ar_tol'].')')
           .($_POST['ar_ig']==""?"":' AND (t.kisker_ar <= '.$_POST['ar_ig'].' OR t.akcios_kisker_ar <= '.$_POST['ar_ig'].' OR t.klub_ar <= '.$_POST['ar_ig'].')');
           
        $_SESSION['termekek_having']=
           ($_POST['db_tol']==""?"":' AND k1 >= '.$_POST['db_tol'])
           .($_POST['db_ig']==""?"":' AND k1 <= '.$_POST['db_ig']);
           
    }

    if (ISSET($_POST['order'])){
    
        if ($_SESSION['termekek_order_num']==$_POST['order']) $_SESSION['termekek_sort'] = ($_SESSION['termekek_sort']=='asc'?'desc':'asc');
        
        $nyil[$_POST['order']]=($_SESSION['termekek_sort']=='asc'?'<img src="images/order_up.gif" />':'<img src="images/order_down.gif" />');

        switch ($_POST['order']){
        
            case 1:
                $_SESSION['termekek_order'] = 'id';
                $_SESSION['termekek_order_num'] = 1;
            break;
            
            case 2:
                $_SESSION['termekek_order'] = 'termeknev';
                $_SESSION['termekek_order_num'] = 2;
            break;
            
            case 3:
                $_SESSION['termekek_order'] = 'markanev';
                $_SESSION['termekek_order_num'] = 3;
            break;
            
            case 4:
                $_SESSION['termekek_order'] = 'szin';
                $_SESSION['termekek_order_num'] = 4;
            break;
            
            case 5:
                $_SESSION['termekek_order'] = 'kisker_ar';
                $_SESSION['termekek_order_num'] = 5;
            break;
            
            case 6:
                $_SESSION['termekek_order'] = 'akcios_kisker_ar';
                $_SESSION['termekek_order_num'] = 6;
            break;
            
            case 7:
                $_SESSION['termekek_order'] = 'klub_ar';
                $_SESSION['termekek_order_num'] = 7;
            break;
            
            case 8:
                $_SESSION['termekek_order'] = 'k1';
                $_SESSION['termekek_order_num'] = 8;
            break;
        }
        
    }else{
        
        $_SESSION['termekek_order'] = 'id';
        $_SESSION['termekek_order_num'] = 1; 
        $_SESSION['termekek_sort']="desc";
        $nyil[1]=($_SESSION['termekek_sort']=='asc'?'<img src="images/order_up.gif" />':'<img src="images/order_down.gif" />');
                
    }
    
    if (!ISSET($_SESSION['termekek_order'])) $_SESSION['termekek_order']="id";
    if (!ISSET($_SESSION['termekek_sort'])) $_SESSION['termekek_sort']="desc";
    
?>

<br>

<form method="post">
<table border="0" cellspacing="1" cellpadding="2">
    <tr>
      <td width="100" class="darkCell" align="center">ID</td>
      <td width="200" class="lightCell"><input type="text" style="width:100%" name="id" value="<?=$_SESSION['termekek']['id']?>"></td>
      <td width="100" class="darkCell" align="center">VTSZ besorolás</td>
      <td width="200" class="lightCell"><input type="text" style="width:100%" name="cikkszam" value="<?=$_SESSION['termekek']['cikkszam']?>"></td>
      <td width="100" class="darkCell" align="center">Vonalkód</td>
      <td width="200" class="lightCell"><input type="text" style="width:100%" name="vonalkod" value="<?=$_SESSION['termekek']['vonalkod']?>"></td>
    </tr>
    <tr>
      <td width="100" class="darkCell" align="center">Márka</td>
      <td width="200" class="lightCell">
        <?
              
              echo $func->createSelectBox("SELECT * FROM markak WHERE sztorno IS NULL ORDER BY markanev", $_SESSION['termekek']['marka'],  "name=\"marka\"", "Mindegyik");
                         
        ?>
      </td>
      <td width="100" class="darkCell" align="center">Szín</td>
      <td width="200" class="lightCell"><input type="text" style="width:100%" name="szin" value="<?=$_SESSION['termekek']['szin']?>"></td>
      <td width="100" class="darkCell" align="center">Terméknév</td>
      <td width="200" class="lightCell"><input type="text" style="width:100%" name="termeknev" value="<?=$_SESSION['termekek']['termeknev']?>"></td>
    </tr>                               
    <tr>
      <td width="100" class="darkCell" align="center">Eladási ár</td>
      <td width="200" class="lightCell">
        <input type="text" style="width:80px" name="ar_tol" value="<?=$_SESSION['termekek']['ar_tol']?>"> - <input type="text" style="width:80px" name="ar_ig" value="<?=$_SESSION['termekek']['ar_ig']?>">
      </td>
      <td width="100" class="darkCell" align="center">Készleten</td>
      <td width="200" class="lightCell">
        <input type="text" style="width:80px" name="db_tol" value="<?=$_SESSION['termekek']['db_tol']?>"> - <input type="text" style="width:80px" name="db_ig" value="<?=$_SESSION['termekek']['db_ig']?>">
      </td>
      <td width="100" class="darkCell" align="center">Aktív</td>
      <td width="200" class="lightCell">
      <?
        echo $func->createArraySelectBox(array("1"=>"igen", "0"=>"nem", ""=>"Mindegyik"), $_SESSION['termekek']['aktiv'],  "name=\"aktiv\"", "")
      ?>
      </td>
    </tr>                               
    <tr>
      <td width="100" class="darkCell" align="center">Kategória</td>
      <td width="200" class="lightCell" colspan="5">
        <select name="kategoria">
            <option value="">Mindegyik</option>
            <?php
              $q = mysql_query("SELECT * FROM kategoriak WHERE szulo=0 AND sztorno IS NULL");
              
              while ($adatok=mysql_fetch_array($q)){
                  
                  $alquery = mysql_query("SELECT * FROM kategoriak WHERE szulo=".$adatok[0]." AND sztorno IS NULL");
                
                  while ($aladatok=mysql_fetch_array($alquery)){
                  
                      echo('<option value="'.$aladatok[0].'" '.(ISSET($_SESSION['termekek']['kategoria'])?($_SESSION['termekek']['kategoria']==$aladatok[0]?'SELECTED':''):'').'>'.$adatok[1].'->'.$aladatok[1].' kategóriába</option>');
                 
                  }
                  
              }
            ?>
        </select>
      </td>
    </tr>
    <tr>
      <td class="darkCell" align="center" colspan="6"><input type="submit" class="form" value="szűrés" name="szures" /> <input type="submit" class="form" value="alaphelyzet" name="alaphelyzet" /></td>
    </tr>
</table>
</form>

<br>

<form method="post" name="delCatForm" id="delCatForm">
    <input type="hidden" id="delid" name="delid" />
</form>
      
<form method="post" name="orderForm" id="orderForm">
    <input type="hidden" id="order" name="order" />
</form>

<table border="0" cellspacing="0" cellpadding="10">
          <tr>
            <td>
              <table border="0" cellspacing="1" cellpadding="4">
                <tr align="center">
                  <td width="36" class="headerCell" rowspan="2"><a href="#" onclick="document.getElementById('order').value='1';document.orderForm.submit()">ID</a> <?=$nyil[1]?></td>
                  <td width="200" class="headerCell" rowspan="2"><a href="#" onclick="document.getElementById('order').value='2';document.orderForm.submit()">Termék név</a> <?=$nyil[2]?></td>
                  <td width="100" class="headerCell" rowspan="2"><a href="#" onclick="document.getElementById('order').value='3';document.orderForm.submit()">Márka</a> <?=$nyil[3]?></td>
                  <td width="100" class="headerCell" rowspan="2"><a href="#" onclick="document.getElementById('order').value='4';document.orderForm.submit()">Szín</a> <?=$nyil[4]?></td>
                  <td width="210" class="headerCell" colspan="3">ÁRAK</td>
                  <td width="240" class="headerCell" rowspan="2"><a href="#" onclick="document.getElementById('order').value='8';document.orderForm.submit()">Készlet</a> <?=$nyil[8]?></td>
                  <td width="50" class="headerCell" rowspan="2">&nbsp;</td>
                </tr>
                <tr align="center">
                  <td width="70" class="headerCell"><a href="#" onclick="document.getElementById('order').value='5';document.orderForm.submit()">LISTAÁR</a> <?=$nyil[5]?></td>
                  <td width="70" class="headerCell"><a href="#" onclick="document.getElementById('order').value='6';document.orderForm.submit()">AKCIÓS</a> <?=$nyil[6]?></td>
                  <td width="70" class="headerCell"><a href="#" onclick="document.getElementById('order').value='7';document.orderForm.submit()">KLUB</a> <?=$nyil[7]?></td>
                </tr>                
                <?php
                
                  if (!ISSET($_GET['oldal'])) $oldal = 0;
                  else $oldal = (int)$_GET['oldal'];
                
                  $sql = "
                    SELECT 
                    t.*, m.markanev, sum(v.keszlet_1) k1
                    FROM termekek t
                    LEFT JOIN markak m ON (m.id = t.markaid)
                    LEFT JOIN vonalkodok v ON (t.id = v.id_termek)
                    WHERE t.torolve IS NULL ".$_SESSION['termekek_query']."
                    GROUP BY t.id
                    HAVING 1=1 ".$_SESSION['termekek_having']."
                    ORDER BY ".$_SESSION['termekek_order']." ".$_SESSION['termekek_sort']."
                  ";
                  
                  $_SESSION['excel_export'] = "
                    SELECT 
                    t.id `ID`,
                    t.termeknev `Termék neve`,
                    m.markanev `Márka`,
                    t.szin `Szín`,
                    t.kisker_ar `Lista ár`,
                    t.akcios_kisker_ar `Akciós lista ár`,
                    t.klub_ar `Klub ár`,
                    sum(v.keszlet_1) k1,
                    (CASE WHEN t.aktiv=1 THEN 'igen' ELSE 'nem' END) `Aktív`
                    FROM termekek t
                    LEFT JOIN markak m ON (m.id = t.markaid)
                    LEFT JOIN vonalkodok v ON (t.id = v.id_termek)
                    WHERE t.torolve IS NULL ".$_SESSION['termekek_query']."
                    GROUP BY t.id
                    HAVING 1=1 ".$_SESSION['termekek_having']."
                    ORDER BY ".$_SESSION['termekek_order']." ".$_SESSION['termekek_sort']."
                  ";
                  
                  //echo $_SESSION['excel_export'];
                  //echo $sql;
                  
                  $sorok = mysql_num_rows(mysql_query($sql));
                
                  $query_user=mysql_query($sql." LIMIT ".($oldal*50).", 50"); 
                  
                  $lapok = ceil($sorok/50);
                  
                  $sorstyle='#FFFFFF';
                  
                  for ($go=1; $go<=$lapok; $go++){
                  
                    if ($oldal == $go-1) $st = 'style="font-weight:bold;"';
                    else $st = 'style="font-weight:normal;color:#666;"';
                      
                    $p[] = ' <a href="index.php?lap=termekek&oldal='.($go-1).'" '.$st.'>'.$go.'</a> ';                      
                      
                  }
                  
				  // termek export Infocentrum-nak
                  echo '<tr align="left">
							<form action="termek_export.php" method="GET">
							<td colspan="13" class="darkCell" align="center">';
				  
						echo 'Kezdő ID: <input type="text" id="from_id" name="from_id" size=4 align="right" /> |
							Záró ID: <input type="text" id="to_id" name="to_id" size=4 align="right" /> |
							<input type="submit" value=" Termék export Infocentrum számlázónak (CSV) " />						
						</td>
						</form>
						</tr>';
						
					  echo '<tr align="left">
							<form action="termek_export_szamlazz_hu.php" method="GET">
							<td colspan="13" class="darkCell" align="center">';
				  
						echo 'Kezdő ID: <input type="text" id="from_id" name="from_id" size=4 align="right" /> |
							Záró ID: <input type="text" id="to_id" name="to_id" size=4 align="right" /> |
							<input type="submit" value=" Termék export SZÁMLÁZZ.HU-nak (CSV) " />						
						</td>
						</form>
						</tr>';
						
						
				  // pagestepper
                  echo '<tr align="center"><td colspan="13" class="darkCell"><div class="pagestepper">'.@implode("..", $p).'</div></td></tr>';
                  
                  while ($adatok=mysql_fetch_array($query_user)){
                    
                    if ($sorstyle=='lightCell'){
                        
                        $sorstyle='darkCell';
                        $k1='#c6a4de'; $k2='#99cec6'; $k3='#ccd19d'; $ko='#bc948b';
                        
                    }else{
                        
                        $sorstyle='lightCell';
                        $k1='#d1c0dd'; $k2='#beddd8'; $k3='#c8cab3'; $ko='#ce998d';
                        
                    }

                    echo '<tr style="height:25px" class="'.$sorstyle.'" onMouseOver="this.className=\'selectedCell\';this.style.cursor=\'hand\'" onMouseOut="this.className=\''.$sorstyle.'\';">';
                    echo '<td onClick="document.location.href=\'index.php?lap=termek&id='.$adatok['id'].'\'"><div align="right">'.$adatok['id'].'&nbsp;</div></td>
                          <td onClick="document.location.href=\'index.php?lap=termek&id='.$adatok['id'].'\'"><div align="left">'.$adatok['termeknev'].'&nbsp;</div></td>
                          <td onClick="document.location.href=\'index.php?lap=termek&id='.$adatok['id'].'\'"><div align="left">'.$adatok['markanev'].'&nbsp;</div></td>
                          <td onClick="document.location.href=\'index.php?lap=termek&id='.$adatok['id'].'\'"><div align="left">'.$adatok['szin'].'&nbsp;</div></td>

                          <td style="background-color:'.$k1.'" onClick="document.location.href=\'index.php?lap=termek&id='.$adatok['id'].'\'"><div align="right">'.number_format($adatok['kisker_ar'], 0, '', ' ').' Ft</div></td>
                          <td style="background-color:'.$k2.'" onClick="document.location.href=\'index.php?lap=termek&id='.$adatok['id'].'\'"><div align="right">'.number_format($adatok['akcios_kisker_ar'], 0, '', ' ').' Ft</div></td>
                          <td style="background-color:'.$k3.'" onClick="document.location.href=\'index.php?lap=termek&id='.$adatok['id'].'\'"><div align="right">'.number_format($adatok['klub_ar'], 0, '', ' ').' Ft</div></td>

                          <td style="background-color:'.$ko.'" onClick="document.location.href=\'index.php?lap=termek&id='.$adatok['id'].'\'"><div align="right"><b>'.(int)$adatok['k1'].'</b> db</div></td>

                          <td onClick="document.location.href=\'index.php?lap=termek&id='.$adatok['id'].'\'"><div align="center"><img alt="'.($adatok['aktiv']=='1'?'aktív':'nem aktív').'" src="images/'.($adatok['aktiv']=='1'?'dot_green.png':'dot_red.png').'" /></div></td>';
                    echo '</tr>';
                    
                  }
                  
                  // pagestepper
				  echo '<tr align="center"><td colspan="13" class="darkCell"><div class="pagestepper">'.@implode("..", $p).'</div></td></tr>';
				  
				  // termek export Infocentrum-nak
                  echo '<tr align="left">
							<form action="termek_export.php" method="GET">
							<td colspan="13" class="darkCell" align="center">';
				  
						echo 'Kezdő ID: <input type="text" id="from_id" name="from_id" size=4 align="right" /> |
							Záró ID: <input type="text" id="to_id" name="to_id" size=4 align="right" /> |
							<input type="submit" value=" Termék export Infocentrum számlázónak (CSV) " />						
						</td>
						</form>
						</tr>';
						
						
						
				  //<a href="excel_export.php">Excel export</a> | <a href="termek_export.php">Termék export CSV</a></td></tr>';

                ?>
               
            </table></td>
          </tr>
</table>