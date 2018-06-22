<?

$adatok = mysql_fetch_array(mysql_query("SELECT 
                                         t.*, m.markanev 
                                         FROM termekek t
                                         LEFT JOIN markak m ON (m.id = t.markaid)
                                         WHERE t.id=".$_GET['id']));    
    
?>

<table border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td width="800">
        <table border="0" cellspacing="1" cellpadding="6" style="min-width:910px;font-weight:bold;table-layout:fixed">

          <tr>
            <td class="headerCell" colspan="4">ID: <b><?=$_GET['id']?></b><input type="hidden" name="id" value="<?=$_GET['id']?>"></td>
          </tr>                           

          <tr>
            <td class="darkCell">Terméknév:</td>
            <td colspan="3" class="lightCell"><?=$adatok['termeknev']?></td>
          </tr>
          <tr>
            <td class="darkCell">VTSZ besorolás:</td>
            <td class="lightCell"><?=$adatok['cikkszam']?></td>
            <td class="darkCell">Szín:</td>
            <td class="lightCell"><?=$adatok['szin']?></td>
          </tr>
          <tr>
            <td class="darkCell">Márka:</td>
            <td class="lightCell" colspan="3"><?=$adatok['markanev']?></td>
          </tr>

          <tr>
            <td class="headerCell" colspan="4">ÁRAK</td>
          </tr>                           
          
          <tr>
            <td class="darkCell">Kisker ár:</td>
            <td class="lightCell"><?=number_format($adatok['kisker_ar'], 0, '', ' ')?> Ft 
			&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; <b>~<?=number_format(($adatok['kisker_ar']/$func->getMainParam('gbp_arfolyam')), 4, '.', ' ')?> GBP
			</td>
            <td class="darkCell">Akciós kisker ár:</td>
            <td class="lightCell"><?=number_format($adatok['akcios_kisker_ar'], 0, '', ' ')?> Ft</td>
          <tr>
            <td class="darkCell">Klub termék:</td>
            <td class="lightCell"><?=$adatok['klub_termek']==0?'Nem':'Igen'?></td>
            <td class="darkCell">Klub ár:</td>
            <td class="lightCell"><?=number_format($adatok['klub_ar'], 0, '', ' ')?> Ft </td>

          <tr>
            <td class="headerCell" colspan="4">TOVÁBBI ADATOK</td>
          </tr>                           

          <tr>
            <td class="darkCell">opció:</td>
            <td colspan="3" class="lightCell"><?=$adatok['opcio']?></td>
          </tr>
          <tr>
            <td valign="top" class="darkCell">leírás:</td>
            <td colspan="3" class="lightCell"><?=$adatok['leiras']?></td>
          </tr>
          <tr>
            <td class="darkCell">kategória:</td>
            <td colspan="3" class="lightCell">
                <?php
                
                  $alkategoria = @mysql_result(mysql_query("SELECT megnevezes FROM kategoriak WHERE id_kategoriak=".$adatok['kategoria']), 0);
                  $alkategoria_id = @mysql_result(mysql_query("SELECT szulo FROM kategoriak WHERE id_kategoriak=".$adatok['kategoria']), 0);
                  $fokategoria = @mysql_result(mysql_query("SELECT megnevezes FROM kategoriak WHERE id_kategoriak=".$alkategoria_id), 0);
                
                  echo $fokategoria." / ".$alkategoria;
                ?>
            </td>
          </tr>
          <tr>
            <td valign="top" class="darkCell">A termék látható :</td>
            <td colspan="3" class="lightCell"><?=$adatok['aktiv']==0?'Nem':'Igen'?></td>
          </tr>

          <tr>
            <td valign="top" class="darkCell">Képek :</td>
            <td colspan="3" class="lightCell">
                <?
                
                    $dir = $func->getHDir($_GET['id']);
                    
                    foreach (glob("../coreshop.hu/".$dir."*_large.jpg") as $filename) {
                        
                        $e = explode("_", $filename);
                        $e = explode("/", $e[0]);
                        $mfn = $e[count($e)-1];

                        $size = getimagesize($filename);                        

                        if ($size[0]>=$size[1]) $ss = "width:150px";
                        else $ss = "height:150px";

                        echo '<div style="'.$ss.'; padding:3px; float:left;text-align: center">';
						
						echo '<a href="http://www.coreshop.hu/'.$dir.basename($filename).'" class="highslide" onclick="return hs.expand(this)">';
                        echo '<img style="'.$ss.'" src="http://www.coreshop.hu/'.$dir.basename($filename).'" '.$style.' /></a></div>';
                        
                        $kepek_szama++;
                        
                    }
                    
                    if ($kepek_szama<1) echo 'Nincsen rögzített kép!';

                ?>
            </td>
          </tr>

        </table>
        
        <table border="0" cellspacing="1" cellpadding="6" style="font-weight:bold;min-width:910px;">

          <tr>
            <td class="headerCell" colspan="4">KÉSZLET</td>
          </tr>                           
          
          <tr>
            <td class="headerCell">Vonalkód</td>            
            <td class="headerCell">Méret</td>
			<td class="headerCell">Utolsó beszerzés</td>
			<td class="headerCell">Utolsó eladás</td>
            <td class="headerCell" width="80">Mennyiség</td>
          </tr>
          
          <?
          
            $sql = " SELECT v.vonalkod, v.megnevezes, v.keszlet_1,MAX(k.bekerulesi_datum) AS utolso_beerkezes,
					MAX(k.kikerulesi_datum) AS utolso_kikerules
					FROM vonalkodok v
					LEFT JOIN keszlet k ON k.id_vonalkod = v.id_vonalkod
					WHERE v.id_termek =".(int)$_GET['id']." 
					GROUP BY v.id_vonalkod
					ORDER BY v.megnevezes";
                    
            $query = mysql_query($sql); $ossz=0;
            
            while ($keszlet = mysql_fetch_assoc($query)){
          
                if ($sorstyle=='lightCell'){
                    
                    $sorstyle='darkCell';
                    $k1='#c6a4de'; $k2='#99cec6'; $k3='#ccd19d'; $ko='#bc948b';
                    
                }else{
                    
                    $sorstyle='lightCell';
                    $k1='#d1c0dd'; $k2='#beddd8'; $k3='#c8cab3'; $ko='#ce998d';
                    
                }
				
				$add='color:#000;';
				if ($keszlet['keszlet_1']==0) $add='color:#999;font-weight:normal;';
                
                $ossz = $ossz + $keszlet['keszlet_1'];
                
          ?>
          <tr>
            <td class="<?=$sorstyle?>" style="<?=$add?>"><?=$keszlet['vonalkod']?></td>
            <td class="<?=$sorstyle?>" style="<?=$add?>"><?=$keszlet['megnevezes']?></td>
            <td class="<?=$sorstyle?>" style="<?=$add?>"><?=$keszlet['utolso_beerkezes']?></td>
            <td class="<?=$sorstyle?>" style="<?=$add?>"><?=$keszlet['utolso_kikerules']?></td>
            <td class="<?=$sorstyle?>" style="background-color:<?=$k1?>;<?=$add?>" align="right"><?=$keszlet['keszlet_1']?> db</td>
          </tr>
          <?
            }
          ?>

          <tr style="font-weight:bold">
            <td class="headerCell" colspan="4" align="right">Összesen</td>
            <td class="headerCell" align="right"><?=number_format($ossz, 0, '', ' ')?> db</td>
          </tr>

          <tr>
            <td colspan="4" class="lightCell">
              <input type="button" class="form" value="Vissza a listához" onclick="document.location.href='index.php?lap=termekek'" />
            </td>
          </tr>
          
        </table>

    </td>
  </tr>
</table>