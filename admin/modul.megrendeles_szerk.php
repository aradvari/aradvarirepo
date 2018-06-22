<?

if($_POST)	{
	
	$szallitasi_dij=0;
	
	// GLS / ingyenes szallitas
	if(($_POST['id_szallitasi_mod']==1) && ($_POST['fizetendo']< ($func->getMainParam('ingyenes_szallitas')) ))
		$szallitasi_dij=990;
	
	// szemelyes atvetel
	if($_POST['id_szallitasi_mod']==2) $szallitasi_dij=0;
	
	$sql='UPDATE megrendeles_fej SET
			
			szallitasi_nev="'.$_POST['szallitasi_nev'].'",
			szallitasi_irszam="'.$_POST['szallitasi_irszam'].'",
			szallitasi_varos="'.$_POST['szallitasi_varos'].'",
			szallitasi_utcanev="'.$_POST['szallitasi_utcanev'].'",
			szallitasi_kozterulet="'.$_POST['szallitasi_kozterulet'].'",
			szallitasi_hazszam="'.$_POST['szallitasi_hazszam'].'",
			szallitasi_emelet="'.$_POST['szallitasi_emelet'].'",
			szamlazasi_nev="'.$_POST['szamlazasi_nev'].'",
			szamlazasi_irszam="'.$_POST['szamlazasi_irszam'].'",
			szamlazasi_varos="'.$_POST['szamlazasi_varos'].'",
			szamlazasi_utcanev="'.$_POST['szamlazasi_utcanev'].'",
			szamlazasi_kozterulet="'.$_POST['szamlazasi_kozterulet'].'",
			szamlazasi_hazszam="'.$_POST['szamlazasi_hazszam'].'",
			szallitasi_dij='.$szallitasi_dij.',
			megjegyzes="'.$_POST['megjegyzes'].'",
			id_szallitasi_mod='.$_POST['id_szallitasi_mod'].',
			id_statusz='.$_POST['id_statusz'].'
			
			WHERE id_megrendeles_fej='.$_GET['id'];
			
			//echo nl2br($sql);
			
			if(mysql_query($sql))
				header("Location: index.php?lap=megrendeles&id=".$_GET[id]); // mentes
			else
				echo 'mySQL hiba!';
}



$sql = "
    SELECT 
        mf.*, 
        mf.szallitasi_nev megrendelo_neve,
		o.orszag_nev,
		mf.szallitasi_irszam,
		mf.szallitasi_varos,
		mf.szallitasi_utcanev,
		mf.szallitasi_kozterulet,
		mf.szallitasi_hazszam,
		mf.szallitasi_emelet,
		
        mf.szamlazasi_irszam,
		mf.szamlazasi_varos,
		mf.szamlazasi_utcanev,
		mf.szamlazasi_kozterulet,
		mf.szamlazasi_hazszam,
		
        CONCAT(f.email,' | ',f.telefonszam1,' | ',f.telefonszam2) megrendelo_elerhetosegei,
        ms.*,
        f.klubtag_kod, f.kartya_kod, f.id id_felhasznalo,
        bt.trid,
        bt.id_bank_tranzakcio
        
		FROM megrendeles_fej mf
        LEFT JOIN felhasznalok f ON (f.id = mf.id_felhasznalo)
        LEFT JOIN megrendeles_statuszok ms ON (ms.id_megrendeles_statusz = mf.id_statusz)
        LEFT JOIN bank_tranzakciok bt ON (bt.id_megrendeles_fej = mf.id_megrendeles_fej)
        LEFT JOIN orszag o ON (o.id_orszag = mf.id_orszag)
		
		WHERE mf.id_megrendeles_fej=".(int)$_GET['id']."
		GROUP BY mf.id_megrendeles_fej
    ";

$m = mysql_fetch_array(mysql_query($sql));

$keyCell="darkCell";

if ($m["trid"]!="") $keyCell="greenCell";												//kartyas
if ($m["giftcard_osszeg"]!="") $keyCell="orangeCell";									//kedvezmeny
if (($m["trid"]!="")&&($m["giftcard_osszeg"]!="")) $keyCell="blueCell";					//kartyas + kedvezmeny
if ($m['id_szallitasi_mod']==2) $keyCell='redCell';										// szemelyes atvetel
if (($m['id_szallitasi_mod']==2) && ($m['trid']!="")) $keyCell='purpleCell';			// kartyas + szemelyes atvetel
if (($m['id_szallitasi_mod']==2) && ($m['giftcard_osszeg']!="")) $keyCell='oliveCell';	// szemelyes atvetel + giftcard

?>

<form method="post" action="" class="megrendeles_szerk" />

<input type="hidden" name="fizetendo" value="<?=$m['fizetendo']?>" />

<table width="700" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td width="700" align="right"><span class="<?=$keyCell?>" style="padding:4px;"><img src="/images/edit.png" style="width:14px;height:14px;vertical-align:middle;padding:0 10px 2px 0;opacity:0.8;" />Szerkesztés | <a href="index.php?lap=megrendeles&id=<?=$_GET['id']?>">Mégse</a></span>
        <table width="700" border="0" cellspacing="1" cellpadding="6">
		  
          <tr>
            <td class="<?=$keyCell?>" width=170>Megrendelés száma:</td>
            <td colspan="3" class="lightCell" style="padding-left:8px">
                <b><?=$m['megrendeles_szama']?></b>
            </td>
          </tr>
          <tr>
            <td class="<?=$keyCell?>">Megrendelés dátuma:</td>
            <td colspan="3" class="lightCell" style="padding-left:8px">
                <b><?=$m['datum']?></b>
            </td>
          </tr>
          <tr>
            <td class="<?=$keyCell?>">SZÁLLÍTÁSI Név:</td>
            <td colspan="3" class="lightCell">
                <!-- <a href="index.php?lap=felhasznalo&id=<?=$m['id_felhasznalo']?>"><b><?=$m['megrendelo_neve']?></b></a> -->
				<input type="text" name="szallitasi_nev" value="<?=$m['megrendelo_neve']?>" placeholder="szállítási név" />
            </td>
          </tr>
          <tr>
            <td class="<?=$keyCell?>">Szállítási cím:</td>
            <td colspan="3" class="lightCell">                
				<b style="padding-left:4px"><?=$m['orszag_nev']?></b><br />
				<input type="text" name="szallitasi_irszam" value="<?=$m['szallitasi_irszam']?>" size=4 placeholder="irsz" />
				<input type="text" name="szallitasi_varos" value="<?=$m['szallitasi_varos']?>" size=<?=strlen($m['szallitasi_varos'])?> placeholder="város" />
				<input type="text" name="szallitasi_utcanev" value="<?=$m['szallitasi_utcanev']?>" size=<?=strlen($m['szallitasi_utcanev'])?> placeholder="utcanév" />
				<input type="text" name="szallitasi_kozterulet" value="<?=$m['szallitasi_kozterulet']?>" size=<?=strlen($m['szallitasi_kozterulet'])?> placeholder="út, utca, stb." />
				<input type="text" name="szallitasi_hazszam" value="<?=$m['szallitasi_hazszam']?>" size=<?=strlen($m['szallitasi_hazszam'])?> placeholder="házszám" />
				<input type="text" name="szallitasi_emelet" value="<?=$m['szallitasi_emelet']?>" size=<?=strlen($m['szallitasi_emelet'])?> placeholder="emelet, ajtó, stb." />
            </td>
          </tr>
          <tr>
            <td class="<?=$keyCell?>">SZÁMLÁZÁSI Név:</td>
            <td colspan="3" class="lightCell">
                <input type="text" name="szamlazasi_nev" value="<?=$m['szamlazasi_nev']?>" placeholder="számlázási név" />
            </td>
          </tr>
          <tr>
            <td class="<?=$keyCell?>">Számlázási cím:</td>
            <td colspan="3" class="lightCell">
                <b style="padding-left:4px"><?=$m['orszag_nev']?></b><br />
				<input type="text" name="szamlazasi_irszam" value="<?=$m['szamlazasi_irszam']?>" placeholder="irsz" size=4 />
				<input type="text" name="szamlazasi_varos" value="<?=$m['szamlazasi_varos']?>" placeholder="város" size=<?=strlen($m['szamlazasi_varos'])?> />
				<input type="text" name="szamlazasi_utcanev" value="<?=$m['szamlazasi_utcanev']?>" placeholder="utcanév" size=<?=strlen($m['szamlazasi_utcanev'])?> />
				<input type="text" name="szamlazasi_kozterulet" value="<?=$m['szamlazasi_kozterulet']?>" placeholder="út, utca, stb" size=<?=strlen($m['szamlazasi_kozterulet'])?> />
				<input type="text" name="szamlazasi_hazszam" value="<?=$m['szamlazasi_hazszam']?>" placeholder="házszám" size=<?=strlen($m['szamlazasi_hazszam'])?> />
            </td>
          </tr>
          <tr>
            <td class="<?=$keyCell?>">Elérhetőségei:</td>
            <td colspan="3" class="lightCell" style="padding-left:8px">
                <b><?=$m['megrendelo_elerhetosegei']?></b>
            </td>
          </tr>
          <tr>
            <td class="<?=$keyCell?>">Megjegyzése:</td>
            <td colspan="3" class="lightCell">
			<?
			//if($m['megjegyzes'])						
						//echo '<span class="bubble-yellow">'.$m['megjegyzes'].'</span>';
						echo '<textarea name="megjegyzes" style="background-color:#ffff99;width:100%;h_eight:60px;border:none;">'.$m['megjegyzes'].'</textarea>';
			//else
				//echo '&nbsp;';
			?>			
			</td>
          </tr>
          <?
            //if ($func->isClubUser($m['id_felhasznalo']) && $m['kartya_kod']==''){
            if ($m['klubkartya']==1){
          ?>
          <tr>
            <td class="<?=$keyCell?>">Rendszer üzenet:</td>
            <td colspan="3" class="lightCell">
                <a href="index.php?lap=felhasznalo&id=<?=$m['id_felhasznalo']?>"><b>A felhasználó klubtag lett!</b></a>
            </td>
          </tr>
          <?    
            }elseif ($m['klubtag_kod']!='' && $m['kartya_kod']==''){
          ?>
          <tr>
            <td class="<?=$keyCell?>">Rendszer üzenet:</td>
            <td colspan="3" class="lightCell">
                <a href="index.php?lap=felhasznalo&id=<?=$m['id_felhasznalo']?>"><b>A felhasználó már klubtag, de még nem kapott kártyát!</b></a>
            </td>
          </tr>
          <?
            }
          ?>
          <tr>
            <td class="<?=$keyCell?>">Szállítás:</td>
            <td colspan="3" class="lightCell">                
				<?
				$statusz=array(1=>'GLS csomagküldő',2=>'Személyes átvétel');
                
				echo '<select name="id_szallitasi_mod">';
				
					foreach($statusz as $kulcs=>$ertek)	{
						if($m['id_szallitasi_mod']==$kulcs) $selected='selected'; else $selected='';
						echo '<option value='.$kulcs.' '.$selected.'>'.$ertek.'</option>';
					}
					
                echo '</select>';
				?>				
            </td>
          </tr>    
          <tr>
            <td class="<?=$keyCell?>" colspan="4">Megrendelt tételek:</td>
          </tr>
          <tr>
            <td colspan="4" class="lightCell" style="padding: 0;">
                <table style="min-width:910px;width:100%;" cellpadding="3">
                    <tr align="center">
                        <td class="<?=$keyCell?>" align="left">Kép</td>
                        <td class="<?=$keyCell?>" align="left">Vonalkód</td>
						<td class="<?=$keyCell?>" align="left">Márka</td>
						<td class="<?=$keyCell?>" align="left">Megnevezés</td>
                        <td class="<?=$keyCell?>" align="left">Szín</td>
                        <td class="<?=$keyCell?>">Méret</td>                        
                        <td class="<?=$keyCell?>" align="right">Bruttó ár</td>
                        <td class="<?=$keyCell?>" align="right">Mennyiség</td>
                        <td class="<?=$keyCell?>" align="right">Összesen</td>
                    </tr>
                    <?
					
						// kikommenteltem a termek_ar_deviza mezot, mert nem talalhato a tablaban - gabor
                        $sql = "SELECT 
                                mt.*,
								m.markanev,
                                count(mt.id_megrendeles_tetel) mennyiseg,
                                sum(mt.termek_ar) osszesen,
                                sum(mt.termek_ar_deviza) osszesen_deviza
                                FROM megrendeles_tetel mt 
								LEFT JOIN markak m ON mt.id_marka=m.id
                                WHERE mt.id_megrendeles_fej=".$m['id_megrendeles_fej']." AND 
                                mt.sztorno IS NULL
                                GROUP BY mt.id_megrendeles_fej, mt.vonalkod
                                ";
                        
                        $query = mysql_query($sql);
                        
                        $osszes_ft = 0;
                        $osszes_db = 0;
                        
                        while ($t = mysql_fetch_array($query)){
                            
                            $osszes_ft = $osszes_ft + $t['osszesen'];
                            $osszes_eur = $osszes_eur + $t['osszesen_deviza'];
                            $osszes_db = $osszes_db + $t['mennyiseg'];
                    ?>					
                    <tr>
                        <td class="mediumCell" align="center"><a href="http://www.coreshop.hu/<?=$func->getHDir($t['id_termek']);?>1_large.jpg" class="highslide" onclick="return hs.expand(this)"><img src="http://coreshop.hu/<?=$func->getHDir($t['id_termek']);?>1_small.jpg" style="width:40px;height:40px;outline:2px solid #eee;" /></a></td>
                        <td class="mediumCell"><?=$t['vonalkod']?></td>
						<td class="mediumCell"><a href="index.php?lap=termek&id=<?=$t['id_termek']?>" target="_blank"><?=$t['markanev']?></a></td>
						<td class="mediumCell"><a href="index.php?lap=termek&id=<?=$t['id_termek']?>" target="_blank"><?=$t['termek_nev']?></a></td>
                        <td class="mediumCell"><a href="index.php?lap=termek&id=<?=$t['id_termek']?>" target="_blank"><?=$t['szin']?></a></td>
                        <td class="mediumCell" align="center"><a href="index.php?lap=termek&id=<?=$t['id_termek']?>" target="_blank" class="meret"><?=$t['tulajdonsag']?></a></td>                        
                        <td class="mediumCell" align="right">
                            <?=number_format($t['termek_ar'], 0, '', ' ')?> Ft
                            <?if ($m["id_penznem"]!=0){?>
                                <br /><b><?=number_format($t['termek_ar_deviza'], 2, '.', ' ')?> &euro;</b>                          
                            <?}?>                                                        
                        </td>
                        <td class="mediumCell" align="right"><?=number_format($t['mennyiseg'], 0, '', ' ')?> db</td>
                        <td class="mediumCell" align="right">
                            <?=number_format($t['osszesen'], 0, '', ' ')?> Ft
                            <?if ($m["id_penznem"]!=0){?>
                                <br /><b><?=number_format($t['osszesen_deviza'], 2, '.', ' ')?> &euro;</b>                          
                            <?}?>                                                        
                        </td>
                    </tr>
                    <?
                        }
                        
                    ?>
                    <tr>
                        <td class="lightCell" colspan=5>&nbsp;</td>
                        <td class="mediumCell">Szállítási díj</td>
                        <td class="mediumCell" align="right">
							<? if ($m['id_szallitasi_mod']==2) $m['szallitasi_dij']=0; ?>
                            <?=number_format($m['szallitasi_dij'], 0, '', ' ')?> Ft
                            <?if ($m["id_orszag"]!=1){?>
                                <br /><b><?=$func->toEUR($m['szallitasi_dij'], $m["deviza_arfolyam"])?> &euro;</b>                          
                            <?}?>                                                        
                        </td>
                        <td class="mediumCell" align="right">1 útra</td>
                        <td class="mediumCell" align="right">
                            <?=number_format($m['szallitasi_dij'], 0, '', ' ')?> Ft
                            <?if ($m["id_penznem"]!=0){?>
                                <br /><b><?=$func->toEUR($m['szallitasi_dij'], $m["deviza_arfolyam"])?> &euro;</b>                          
                            <?}?>                                                        
                        </td>
                    </tr>
                    <?
                        if ($m['giftcard_osszeg']>0){
                    ?>
                    <tr>
                        <td class="lightCell" colspan=5>&nbsp;</td>
                        <td class="lightCell" colspan="2" align="right"><b>Ajándékkártya összege</b></td>
                        <td class="<?=$keyCell?>" align="right"><b>1 db</b></td>
                        <td class="<?=$keyCell?>" align="right">
                            <b><?=number_format($m['giftcard_osszeg'], 0, '', ' ')?> Ft</b>
                            <?if ($m["id_penznem"]!=0){?>
                                <br /><b><?=number_format($m['giftcard_osszeg_deviza'], 2, '.', ' ')?> &euro;</b>                          
                            <?}?>                                                        
                        </td>
                    </tr>
                    <?
                        }
                    ?>
                    <tr>
                        <td class="lightCell" colspan=5>&nbsp;</td>
                        <td class="lightCell" colspan="2" align="right"><b>Összesen fizetendő</b></td>
                        <td class="<?=$keyCell?>" align="right"><b><?=number_format($osszes_db, 0, '', ' ')?> db</b></td>
                        <td class="<?=$keyCell?>" align="right">
                            <b><?=number_format($osszes_ft + $m['szallitasi_dij'] - $m['giftcard_osszeg'], 0, '', ' ')?> Ft</b>
                            <?if ($m["id_penznem"]!=0){?>
                                <br /><b><b><?=number_format($osszes_eur + $func->toEUR($m['szallitasi_dij'], $m["deviza_arfolyam"], false) - $m['giftcard_osszeg_deviza'], 2, '.', ' ')?> &euro;</b>                          
                            <?}?>                                                        
                        </td>
                    </tr>
                    <?
                        if ($m['kedvezmeny_erteke']>0){
                    ?>        
                    <tr>
                        <td class="lightCell" colspan=4>&nbsp;</td>
                        <td class="lightCell" colspan="2" align="right"><b>Kedvezmény</b></td>
                        <td class="<?=$keyCell?>" align="right">1 db</b></td>
                        <td class="<?=$keyCell?>" align="right">
                            <b><?=number_format($m['kedvezmeny_erteke'], 0, '', ' ')?> Ft</b>
                            <?if ($m["id_orszag"]!=1){?>
                                <br /><b><?=number_format($m['kedvezmeny_erteke_deviza'], 2, '.', ' ')?> &euro;</b>                          
                            <?}?>                                                        
                        </td>
                    </tr>
                    <tr>
                        <td class="lightCell" colspan=4>&nbsp;</td>
                        <td class="lightCell" colspan="2" align="right"><b>Kedvezménnyel számítva</b></td>
                        <td class="<?=$keyCell?>" align="right"><?=number_format($osszes_db, 0, '', ' ')?> db</b></td>
                        <td class="<?=$keyCell?>" align="right">
                            <b><?=number_format( ($osszes_ft - $m['kedvezmeny_erteke']) + $m['szallitasi_dij'], 0, '', ' ')?> Ft</b>
                            <?if ($m["id_orszag"]!=1){?>
                                <br /><b><b><?=number_format($osszes_eur + $func->toEUR($m['szallitasi_dij'], $m["deviza_arfolyam"], false) - $m['kedvezmeny_erteke_deviza'], 2, '.', ' ')?> &euro;</b>                          
                            <?}?>                                                        
                        </td>
                    </tr>
                    <?        
                        }
                    ?>
                </table>
            </td>
          </tr>
          <tr>
            <td valign="top" align="right" class="<?=$keyCell?>">CIB tranzakció azonosító:</td>
            <td colspan="3" class="<?=$keyCell?>">
                <a href="index.php?lap=tranzakcio&id=<?=$m['id_bank_tranzakcio']?>"><b><?=$m['trid'];?></b></a>
            </td>
          </tr>
          <tr>
            <td align="right" class="<?=$keyCell?>">Státusz:</td>
            <td colspan="3" class="<?=$keyCell?>">
			<?
				$statusz=array(1=>'Új',3=>'Lezárva',99=>'Sztornózott');
                
				echo '<select name="id_statusz">';
				
					foreach($statusz as $kulcs=>$ertek)	{
						if($m['id_statusz']==$kulcs) $selected='selected'; else $selected='';
						echo '<option value='.$kulcs.' '.$selected.'>'.$ertek.'</option>';
					}
					
                echo '</select>';
			?>	
            </td>
          </tr>
          <tr>
            <td colspan="4" class="<?=$keyCell?>" align="center">				
                
				<input type="submit" class="form" value="Megrendelés mentése" style="width:88%" />
				<input type="button" class="form" value="Mégse" style="width:10%" onclick="document.location.href='index.php?lap=megrendeles&id=<?=$_GET['id']?>'"/>
                
            </td>
          </tr>		  
		  
        </table>
    </td>
  </tr>
</table>

</form>


<span class="greenCell" style="padding:0 2px; margin-right:0px; border:0px solid green">&nbsp;&nbsp;</span> Bankkártya &nbsp;&nbsp;&nbsp;&nbsp;
<span class="redCell" style="padding:0 2px; margin-right:0px; border:0px solid red">&nbsp;&nbsp;</span> Személyes átvétel &nbsp;&nbsp;&nbsp;&nbsp;
<span class="orangeCell" style="padding:0 2px; margin-right:0px; border:0px solid orange">&nbsp;&nbsp;</span> Giftcard &nbsp;&nbsp;&nbsp;&nbsp;
<span class="purpleCell" style="padding:0 2px; margin-right:0px; border:0px solid orange">&nbsp;&nbsp;</span> Bankkártya + Személyes &nbsp;&nbsp;&nbsp;&nbsp;
<span class="blueCell" style="padding:0 2px; margin-right:0px; border:0px solid orange">&nbsp;&nbsp;</span> Bankkártya + Giftcard &nbsp;&nbsp;&nbsp;&nbsp;
<span class="oliveCell" style="padding:0 2px; margin-right:0px; border:0px solid orange">&nbsp;&nbsp;</span> Személyes + Giftcard &nbsp;&nbsp;&nbsp;&nbsp;