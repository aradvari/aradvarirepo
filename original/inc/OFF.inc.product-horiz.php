<!-- termékinfo oldal fekvőkép -->

<div class="right-container">

<table border=0>

<tr>
  <td rowspan=2 valign="middle">
  
	<div class="grey-container" style="text-align:left; display:none;">
		<h1><?=$termek->termek['markanev'].'&nbsp;&nbsp;&nbsp;&nbsp;'.$termek->termek['termeknev'].'&nbsp;&nbsp;&nbsp;&nbsp;'.str_replace('/', ' / ',$termek->termek['szin'])?></h1>
	</div>
	
    
	<!-- KÉP ELEJE -->
    <select id="optionlist" onChange="javascript:changeImage()" style="display:none">
    <?
        if (is_array($termek->kepek)){

            while ($pic = each($termek->kepek)){
                
        
                echo '<option value="/'.$pic[1].'">First Image</option>';
                
            }
            
        }
    ?>
    </select>
	  
    <div class="product-image-container-horizontal">
	
	<?
	// deal of the week
	if($termek->termek['dealoftheweek']==1)
		echo '<div class="product-image-container-horizontal-dotw">
				<img src="/images/coreshop_dealoftheweek_large.png" />
			</div>';
	?>
 
    <!-- előző kép gomb -->
    <div style="position:absolute; top:0; left:0; z-index:3;"><img src="/images/prev.png" onClick="javascript:prevImage()" style="width:360px; height:480px; outline:none;cursor: pointer"></div>
    <!-- következő kép gomb -->
    <div style="position:absolute; top:0; right:0; z-index:3;"><img src="/images/next.png" onClick="javascript:nextImage()" style="width:360px; height:480px; outline:none;cursor: pointer"></div>
      
      <!-- kép -->
      <img name="mainimage" id="mainimage" src="" alt="<?=$termek->termek['markanev'].' - '.$termek->termek['termeknev'].' - '.$termek->termek['szin'].' - Coreshop.hu';?>" src="" style="width:720px; height:480px; z-index:1" />
      
    </div>
    <!-- KÉP VÉGE -->	
	
	<!-- KÉP NAVIGÁLÁS -->	
	<div class="product-navbar-horiz">
	<a href="#" onClick="javascript:prevImage()">&nbsp;&nbsp;&lsaquo;&nbsp;&nbsp;</a><?=$lang->tovabbi_kepek?><a href="#" onClick="javascript:nextImage()">&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;</a>
	</div>
	
	
	<?
	// termekleiras
	if (!empty($termek->termek['leiras']))	{	
		echo '<div class="product-headline" style="margin-top:-10px; padding:0 0 5px 50px;">'.$lang->leiras.'</div>';
		echo '<div class="product-desc">';
		echo nl2br($termek->termek['leiras']);
		echo '</div>';
		}
	?>
	
	</td>
</tr>

<tr>
  <td valign="top">	
	<div class="prod-horiz-info-container">	
	
	<?
	echo '<div class="product-logo">
			<a href="/'.$_SESSION["langStr"].'/'.$lang->_termekek.'/0/0/'.$termek->termek['markanev'].'/'.$termek->termek['markaid'].'">
			<img src="/pictures/brandlogos/'.$termek->termek['markaid'].'.png" alt="'.$termek->termek['markanev'].' - '.$termek->termek['termeknev'].' - '.$termek->termek['szin'].' - Coreshop.hu" />
			</a>
		</div>';
	
	echo '<h1>'.$termek->termek['markanev'].' &middot; '.$termek->termek['termeknev'].'</h1>';
	
	echo '<h2>'.str_replace('/', ' / ',$termek->termek['szin']).'</h2>';
	
	/*// termekleiras
	if (!empty($termek->termek['leiras']))	{	
		echo '<div class="product-headline">'.$lang->leiras.'</div>';
		echo '<div class="product-desc">';
		echo nl2br($termek->termek['leiras']);
		echo '</div>';
		} */
	
	$sizes = $termek->getSizes($termek->termek['id'], 1, '<p class="sizeButton2">', '</p>', ' ');    //WEB RAKTÁR 
	
    if ($sizes){
	   echo '<div class="product-headline">'.$lang->Kaphato_meret;
		
		// merettabla
		if ( ($termek->termek['kategoria']==94) || ($termek->termek['kategoria']==95) ) //ffi, v noi cipok
		echo '<a href="#'.$termek->termek['kategoria'].'_'.$termek->termek['markaid'].'" rel="facebox" style="float:right;font-weight:normal;font-size:12px;padding:4px 10px 0 0;"><img src="/images/merettabla.png" style="vertical-align:absmiddle;"> '.$lang->Merettablazat.'</a>';
		
	   echo '</div>';
	   echo '<div class="product-data">'.$sizes.'</div>';
    }
	
	/* // merettabla
	if ( ($termek->termek['kategoria']==94) || ($termek->termek['kategoria']==95) ) //ffi, v noi cipok
		echo '<a href="#'.$termek->termek['kategoria'].'_'.$termek->termek['markaid'].'" rel="facebox"><img src="/images/merettabla.png" style="vertical-align:absmiddle;"> '.$lang->Merettablazat.'</a>';*/
	?>	
	</div>
	
	<div class="prod-horiz-info-container">
	
	<div class="product-headline"><?=$lang->Termekar?></div>
	
	<div class="product-data">
	<t*able border=1>
		<?
        
        if ($lang->defaultCurrencyId == 0){ //MAGYARORSZÁG ESETÉN
        
    		// arak
    		if ($termek->termek['akcios_kisker_ar']>0)	{
    			// eredeti es akcios ar
				//echo '<h4 style="color:#666;">'.$lang->Eredeti_ar.': <del>'.number_format($termek->termek['kisker_ar'], 0, '', '.').'</del> Ft</h4>';
				echo '<h4 style="color:#666;"><del>'.number_format($termek->termek['kisker_ar'], 0, '', '.').'</del> Ft</h4>';				
				//echo '<h4 style="color:#ff4c4c;">'.$lang->Akcios_ar.': '.number_format($termek->termek['vegleges_ar'], 0, '', '.').' Ft</h4>';				
				echo '<h4 style="color:#ff4c4c;">'.number_format($termek->termek['vegleges_ar'], 0, '', '.').' Ft</h4>';				
    			}
    		else
    			// normal kisker ar
				echo '<h4>'.$lang->Ar.' '.number_format($termek->termek['kisker_ar'], 0, '', '.').' Ft</h4>';
    		
    		/*
    		// klub ar
    		if ($termek->termek['klub_ar']>0)	{
    			echo '<h2 style="color:#0099ff;">'.$lang->Klub_ar.' '.number_format($termek->termek['klub_ar'], 0, '', '.').' Ft</h2>';
    			}
			*/
            
        }else{        
    		// arak
    		if ($termek->termek['akcios_kisker_ar']>0)	{
    			// eredeti es akcios ar
    			//echo '<h4 style="color:#666;">'.$lang->Eredeti_ar.' <del> € '.$func->toEUR($termek->termek['kisker_ar']).'</del></h2>';
    			echo '<h4 style="color:#666;">€ '.$func->toEUR($termek->termek['kisker_ar']).'</del></h2>';
    			//echo '<h4 style="color:red;">'.$lang->Akcios_ar.' € '.$func->toEUR($termek->termek['vegleges_ar']).'</h2>';
    			echo '<h4 style="color:red;">€ '.$func->toEUR($termek->termek['vegleges_ar']).'</h2>';
    			}
    		else
    			// normal kisker ar
    			echo '<h4>'.$lang->Ar.'€ '.$func->toEUR($termek->termek['kisker_ar']).'</h2>';
    		
    		/*
    		// klub ar
    		if ($termek->termek['klub_ar']>0)	{
    			echo '<h2 style="color:#0099ff;">'.$lang->Klub_ar.' € '.$func->toEUR($termek->termek['klub_ar']).'</h2>';
    			}
			*/
        }        
		?>
	</div>
	
	<!-- csomagfeladas -->
	<div class="product-headline" style="padding:10px 0 16px 0;">
		<!-- <img src="/images/gls-small.png" style="vertical-align:middle;" alt="GLS Hungary"/> -->
		<?//=$func->RemainingDispatchTime()?>
		<?="Kiszállítás: ".$func->dateToHU($func->GlsDeliveryDate('HU'))?>		
	</div>

	
	<div class="product-headline"><?=$lang->Megrendeles?></div>
	
	<form method="post">
                  <input type="hidden" name="termekid" value="<?=$termek->termek['id']?>" />
                  <input type="hidden" name="termeknev" value="<?=$termek->termek['termeknev']?>" />
                  <input type="hidden" name="ar" value="<?=$termek->termek['kosar_ar']?>" />
                  <input type="hidden" name="marka" value="<?=$termek->termek['markanev']?>" />
                  <input type="hidden" name="cikkszam" value="<?=$termek->termek['cikkszam']?>" />
                  <input type="hidden" name="opciostr" value="<?=$termek->termek['opcio']?>" />
	
	<div class="product-data">
	
	<?
	$sql = "SELECT
			v.vonalkod, v.megnevezes, v.keszlet_1
			FROM termekek t
			LEFT JOIN vonalkodok v ON (v.id_termek = t.id AND v.aktiv=1 AND v.keszlet_1>0)
			LEFT JOIN vonalkod_sorrendek vs ON (vs.vonalkod_megnevezes=v.megnevezes)
			WHERE t.id=".$termek->termek['id']."
			ORDER BY vs.sorrend, v.megnevezes";
		 
	$tomb = mysql_fetch_array(mysql_query($sql));
    $rows = mysql_num_rows(mysql_query($sql));

	if ($rows>0 && !empty($tomb[1]))	{
	
        if ($rows==1){
            echo '<div style="display:none">';
			echo $func->createSelectBox($sql, "", "name=\"meret\"", null);
            echo '<script>divKeszlet(\'keszlet\', \''.$tomb[0].'\')</script>';
            echo '</div>';
        }else{
		    echo $lang->valassz_meretet.' '.
			$func->createSelectBox($sql, "", "name=\"meret\" onchange=\"divKeszlet('keszlet', this.options[this.selectedIndex].value)\"", "-").' &nbsp;&nbsp;&nbsp;&nbsp; ';
        }
        

		echo $lang->add_meg_a_mennyiseget.' <span id="keszlet"></span>';
		echo '<br /><br />';
		echo '<input type="submit" value="'.$lang->hozzaadas_a_kosarhoz.'" class="button-yellow" style="width:256px;" />';	
	}
	?>	
	</form>
	
	<!-- uzletunk -->
	<div class="uzletunk-container">
		<a href="/hu/uzletunk" target="_blank">
			<div class="arrow_box_grey" onclick="window.open(\'/hu/uzletunk\')" style="margin-bottom:6px;w*idth:240px;" />Szeretnéd megnézni, felpróbálni?</div>
			<div style="padding:0px 10px;">
			<span style="font-weight:bold;">Nézd meg bemutatótermünkben</span> &rsaquo;
			<br />
			<span style="letter-spacing:-0.5px;">A termék raktáron van, azonnal elvihető.</span>
			</div>
		</a>
	</div>
	<!-- -->
	
	
	
	</td>
</tr>

<?
if(!empty($termek->termek['video']))
	echo '<tr><td colspan="2">'.$termek->termek['video'].'</td></tr>';
	
?>



</table>

<? include('inc/inc.ajanlo.php') ?>

</div>

<script>
changeImage();
</script>