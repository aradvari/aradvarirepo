<?

//LAPLÉPTETŐ FORM
echo '<form method="post" name="pageStepForm" id="pageStepForm">';
echo '<input type="hidden" name="oldal" id="oldal" />';
echo '</form>';
  
// Belga shop img
//echo '<a href="/'.$_SESSION["langStr"]."/".$lang->_termekek.'/belga/150" ><img src="/images/belga.coreshop.hu.mod.jpg" alt="belga.coreshop.hu" style="margin-bottom:10px;" /></a>';
// Sanyi fejlec
echo '<a href="/'.$_SESSION["langStr"]."/".$lang->_termekek.'/belga/150" ><img src="/images/belga.coreshop.hu.sanyi.jpg" alt="belga.coreshop.hu" style="margin-bottom:10px;" /></a>';

  
?>



<!-- transparent container eleje -->
<div class="right-container">

<!-- alkategoriak -->
<?
/*
if($_GET['kategoria']<>0)	{
	
	echo '<div class="subcat-container">';
	
	$i=0;
	foreach(belga-relikviak->alkategoriak as $alkat)	{
	$i++;
	if($i==count(belga-relikviak->alkategoriak)) $style="style=\"border-right:none;\"";		// utolso elem jobb border nelkul
		
		if ($alkat["selected"])	{ //Ha ki van választva a kategória
		
		?>
				<a href="<?="/".$_SESSION["langStr"]."/".$lang->_termekek."/".$func->convertString($lang->$alkat["nyelvi_kulcs"])."/".$alkat["id_kategoriak"]?>" <?=$style;?> >
					<b><?=$lang->$alkat['nyelvi_kulcs']?></b>
				</a>
		<?
		
		}else{
		
		?>
				<a href="<?="/".$_SESSION["langStr"]."/".$lang->_termekek."/".$func->convertString($lang->$alkat["nyelvi_kulcs"])."/".$alkat["id_kategoriak"]?>" <?=$style;?>>
					<?=$lang->$alkat['nyelvi_kulcs']?>
				</a>
		<?		
		}
	}
	
	echo '</div>';
}
*/
?>


<!-- filter 
<div class="grey-container" style="font-size:12px;"><? //=$belga_relikviak->filter?></div>
-->

<center>

<div class="pagestepper"><? //=$belga_relikviak->echoPageStepper();?></div>



<!-- termék thumbnail-ek -->
<table align="center" class="products_table" >
  
	<?
  
	$num=0;
	$row=0;
	while ($lista=mysql_fetch_array($belga_relikviak->lista_query)) { 
		
		if (++$num==1) {
					echo '<tr>';
					$row++;
					}
		
		$notopborder='';
		if ($row==1)	$notopborder='border-top:none;';
		
		$noleftborder='';
		if ($num%5==1)	$noleftborder='border-left:none;';
	 
		echo '<td align="center" valign="top" style="'.$noleftborder.$notopborder.'">';
		
		////// DIV /////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		echo '<div class="product-thumb">';
		 
		 if($lista['dealoftheweek']==1)
			echo '<div class="product-image-container-horizontal-dotw">
				<img src="/images/coreshop_dealoftheweek_small.png" />
			</div>';
		 
		 // opcio icon
			echo '<div class="product-opcio-container">';				
				if ($lista['opcio']=='UJ') echo '<img src="/images/opcio-uj.png" />';
			echo '</div>';
           
         $directory = $func->getHDir($lista['id']);		 
         
         if (!is_file($directory.'/'.$lista['fokep'].'_small.jpg')){

             echo '<a href="/'.$_SESSION["langStr"].'/'.$lang->_termek.'/'.$func->convertString($lista['termeknev']).'/'.$lista['id'].'"><img src="/images/none.jpg" alt="'.$lista['termeknev'].'" style="width:200px; height:200px;" /></a>';                     

         }else{
         
             echo '<a href="/'.$_SESSION["langStr"].'/'.$lang->_termek.'/'.$func->convertString($lista['termeknev']).'/'.$lista['id'].'"><img src="/'.$directory.'/'.$lista['fokep'].'_small.jpg" alt="'.$lista['termeknev'].'"  style="width:200px; height:200px;" /></a>';
             
         }
		 
         
         echo '<div class="product-info"> 				
                
                <div class="products-thumb-zoom">';

                 if (!is_file($directory.'/'.$lista['fokep'].'_large.jpg')){

                     echo '<a href="#" class="highslide">';

                 }else{
					
					
                     echo '<a href="/'.$directory.'/'.$lista['fokep'].'_large.jpg" class="highslide" onclick="return hs.expand(this)">';
                     
                 }
                  
                  
         echo     '[+] zoom</a>                
                </div>
               
                  <a href="/'.$_SESSION["langStr"].'/'.$lang->_termek.'/'.$func->convertString($lista['termeknev']).'/'.$lista['id'].'"><h1>'.$lista['markanev'].'</h1></a>        
                  <a href="/'.$_SESSION["langStr"].'/'.$lang->_termek.'/'.$func->convertString($lista['termeknev']).'/'.$lista['id'].'">'.$lista['termeknev'].'</a>
				  <br />
                  <a href="/'.$_SESSION["langStr"].'/'.$lang->_termek.'/'.$func->convertString($lista['termeknev']).'/'.$lista['id'].'">'.$lista['szin'].'</a>';

		
			echo '<div class="products-prise-container">';

			if($lista['keszlet_1']>0)	{	// ha keszleten van, akkor ir arat
				if ($lang->defaultCurrencyId == 0){ //MAGYARORSZÁG ESETÉN
					
					if ($lista['akcios_kisker_ar']>0)	{
							echo	'<span class="products-thumb-originalprise">'.$lang->Eredeti_ar.': <del>'.number_format($lista['kisker_ar'], 0, '', ' ').'</del> Ft</span><br />';
							echo	'<span class="products-thumb-saleprise">'.$lang->Akcios_ar.': '.number_format($lista['akcios_kisker_ar'], 0, '', ' ').' Ft</span>';
							}
					else
							echo	$lang->Ar.' '.number_format($lista['kisker_ar'], 0, '', ' ').' Ft';
					

		
				}else{

					//ÁTVÁLTÁS

					if ($lista['akcios_kisker_ar']>0)	{
							echo	'<span class="products-thumb-originalprise">'.$lang->Eredeti_ar.': € <del>'.$func->toEUR($lista['kisker_ar']).'</del></span><br />';
							echo	'<span class="products-thumb-saleprise">'.$lang->Akcios_ar.': € '.$func->toEUR($lista['akcios_kisker_ar']).'</span>';
							}
					else
							echo	$lang->Ar.' € '.$func->toEUR($lista['kisker_ar']);
					

					
				}
			
			}
			else
				echo 'elfogyott :(';
            
			
			echo '</div>';

			    
            echo '</div>

               </div>';
		
		////// END OF DIV /////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		echo '</td>';
		
		if ($num==5){
		
			echo '</tr>';
			$num=0;
			
		}
		
	}

	if ($num<>0) echo '</tr>';
	
	?>
  
</table>

<div style="margin-top:10px;"><? //=$belga_relikviak->echoPageStepper();?></div>

</center>
<!-- termék thumbnail-ek vége -->

</div>
<!-- transparent container vege -->