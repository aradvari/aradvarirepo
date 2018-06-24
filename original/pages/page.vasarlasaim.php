<div class="content-right-headline">Vásárlásaim</div>

<div class="vasarlasaim">

	<div class="vasarlasaim_text">
		Az alábbi listában megtekintheted eddigi vásárlásaid 
		 | <img src="/images/info.jpg" align="absmiddle"> Információ <a href="#coreclub">CoreClub</a> tagságodról
	</div>

<br />
<br />
<br />

<table border="0" align="center" style="width:600px;">
	<tr>
		<td align="center" class="table-row-unpair"><b>Dátum/Idő</b></td>
		<td align="center" class="table-row-unpair"><b>Termék</b></td>
		<td align="center" class="table-row-unpair"><b>Kép</b></td>
		<td align="center" class="table-row-unpair"><b>Menny.</b></td>
		<td align="center" class="table-row-unpair"><b>Ár</b></td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
    
    <!-- 1 vasarlas blokk eleje -->
    <?
    
        $query = mysql_query($vasarlasaim->sql);
        
        $num=0; $reszosszeg=0; $ossz=0;
        
        while ($adatok = mysql_fetch_assoc($query)){
            
            $ossz = $ossz + ($adatok['kikerulesi_ar']*$adatok['db']);
            
            if ($datum != $adatok['kikerulesi_datum']){
                
                $datum = $adatok['kikerulesi_datum'];
                $pd = $adatok['datum'].'<br>'.$adatok['idopont'];
                
                
                if ($num>0)
                echo '
                    <tr>
                        <td colspan="5" class="table-row-unpair">'.next($query).'&nbsp;</td>
                    </tr>
                    
                    <tr>
                        <td colspan="4" align="right"><b>Vásárlás értéke:</b></td>
                        <td align="right"><b>'.number_format($reszosszeg, 0, '', ' ').',-</b></td>
                    </tr>

                    <tr><td colspan="5">&nbsp;</td></tr>

                ';

                $reszosszeg=($adatok['kikerulesi_ar']*$adatok['db']);
                
            }else{
             
                $pd=''; 
                $reszosszeg = $reszosszeg + ($adatok['kikerulesi_ar']*$adatok['db']);
                
            }
            
            $num++;
            
    ?>
    

    <tr>
        <td align="center"><?=$pd?></td>
        <td class="vasarlasaim_data">
			
			<?
				$directory = $func->getHDir($adatok['id']);
			?>
			
			<!--<a href="/<?=$directory;?>/1_large.jpg" class="highslide" onclick="return hs.expand(this)" />-->
            <b><?=!empty($adatok['markanev'])?$adatok['markanev'].' - ':''?></b> <?=!empty($adatok['termeknev'])?$adatok['termeknev']:''?><br />
            <?=!empty($adatok['szin'])?$adatok['szin'].' - ':''?> <?=!empty($adatok['megnevezes'])?$adatok['megnevezes']:''?>
			<!--</a>-->
        </td>
        <td align="center" class="vasarlasaim_data">
    <?        
         
         if (is_file($directory.'/1_small.jpg')){

             echo '<a href="/'.$directory.'/1_large.jpg" class="highslide" onclick="return hs.expand(this)" /><img src="/'.$directory.'/1_small.jpg" alt="" title="" width="25" height="25" /></a>';  
			 }
    ?>
        </td>
        <td align="center" class="vasarlasaim_data"><?=$adatok['db']?></td>
        <td align="right" class="vasarlasaim_data"><?=number_format(($adatok['kikerulesi_ar']*$adatok['db']), 0, '', ' ')?>,-</td>
    </tr>
    
    <?
    
        }
        
        if ($num>0)
        echo '
            <tr>
                <td colspan="5" class="table-row-unpair">'.next($query).'&nbsp;</td>
            </tr>
            
            <tr>
                <td colspan="4" align="right"><b>Vásárlás értéke:</b></td>
                <td align="right"><b>'.number_format($reszosszeg, 0, '', ' ').',-</b></td>
            </tr>
        ';
    ?>
    
    <!-- 1 vasarlas blokk vege -->
    
    <!-- //////////////////////////////////////////////////////////////// -->    
    
    <!-- vasarlasok osszesen eleje -->
    
    <tr>
        <td colspan="5">&nbsp;</td>
    </tr>
    
    <tr>
        <td colspan="4" align="right"><b>Vásárlások összesen:</b></td>
        <td align="right"><b><?=number_format($ossz, 0, '', ' ')?>,-</b></td>
    </tr>
    
    <!-- vasarlasok osszesen vege -->    
    
</table>

<br />
<br />
<br />

<a name="coreclub"></a>
	<div class="vasarlasaim_text">
	
		<img src="/images/info.jpg" align="absmiddle"> 		
		
		<?
		if ($ossz>=($func->getMainParam('klub_hatar')))
			echo 'Már <b>CoreClub</b> tag vagy!';
		else
			echo 'Jelenleg <b>'.number_format($ossz, 0, '', ' ').'</b>,- összértékben vásároltál oldalunkon.
			<br />
			<br />
			Ha következő vásárlásaiddal túlléped az <b>'.number_format($func->getMainParam('klub_hatar'), 0, '', ' ').'</b>,- összeget, automatikusan <b>CoreClub</b> taggá válsz!';
		?>
		
		<br />
		<br />
		<a href="/coreclub" target="_self"><img src="/images/coreclub-logo.png" align="absmiddle"></a> A CoreClub-ról bővebben <a href="/coreclub" target="_self">itt</a> olvashatsz.
		
	</div>
</div>