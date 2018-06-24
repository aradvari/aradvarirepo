<?

$sql = "SELECT
        m.markanev,
        t.termeknev,
		t.kisker_ar,
		t.akcios_kisker_ar,
		t.klub_ar,
        t.id,
		t.szin,
        t.fokep,
		t.opcio
        FROM termekkapcsolatok tk
        INNER JOIN termekek t ON t.kategoria = tk.kapcsolat
        INNER JOIN vonalkodok vk ON vk.id_termek=t.id
        LEFT JOIN markak m ON m.id = t.markaid
        WHERE 
        t.aktiv=1 AND
        t.torolve IS NULL AND
		vk.keszlet_1>0
        ".((int)$_GET['kategoria']>0?' AND tk.kategoriaid = '.(int)$_GET['kategoria']:'')."
        GROUP BY t.id
        ORDER BY rand()
        LIMIT 0, 5";
  
  $query = mysql_query($sql);
  
  if(mysql_num_rows($query) >0)	{
  
  echo '<div class="content-right-headline" style="clear:both;">'.$lang->Termekajanlo.'</div> 	
  
		<div class="ajanlo-container">

		<div class="thumbnail-container" style="max-width:1280px;">';
		
  
  while ($arr = mysql_fetch_array($query))	{
  
  echo '<div class="product-thumb" onclick="location.href=\'/'.$_SESSION["langStr"].'/'.$lang->_termek.'/'.$func->convertString($arr['markanev']).'-'.$func->convertString($arr['termeknev']).'/'.$arr['id'].'\'" style="cursor:pointer;">';

  if($arr['dealoftheweek'] == 1)
   echo '<div class="product-image-container-horizontal-dotw">
				<img src="/images/coreshop_dealoftheweek_small.png" />
			</div>';

  // opcio icon
  echo '<div class="product-opcio-container">';  
  // DEAL OF THE WEEK
  if($arr['opcio'] == 'ZZZ_DOTW') 	{
		if ($func->isMobile()!=0)	
				echo '<span class="dotw">ajándék napszemüveggel</span>';
		else
				{
				echo '<span class="dotw">Deal of the Week</span>';
				echo '<span class="dotw_bottom">ajándék<br />vans napszemüveggel</span>';
				}
				
	}  

	
  
  echo '</div>';

  $directory=$func->getHDir($arr['id']);
  
  if(!is_file($directory.'/'.$arr['fokep'].'_small.jpg'))
  {

   echo '<a href="/'.$_SESSION["langStr"].'/'.$lang->_termek.'/'.$func->convertString($arr['markanev']).'-'.$func->convertString($arr['termeknev']).'/'.$arr['id'].'"><img src="/images/none.jpg?17" alt="'.$arr['markanev'].' - '.$arr['termeknev'].'"  /></a>';
  }
  else
  {

   echo '<a href="/'.$_SESSION["langStr"].'/'.$lang->_termek.'/'.$func->convertString($arr['markanev']).'-'.$func->convertString($arr['termeknev']).'/'.$arr['id'].'">';
   
   echo '<img src="/'.$directory.'/1_small.jpg?17" alt="'.$arr['markanev'].' - '.$arr['termeknev'].'" /></a>'; 
   
   //echo '<img src="/image_resize.php?w=300&img=/'.$directory.'/1_large.jpg" alt="'.$arr['markanev'].' - '.$arr['termeknev'].'" />';
   echo '</a>';
  }


	

  if(empty($arr['szin'])) $arr['szin']='&nbsp;';		// ha nincs szin, akkor kell a sor a tarto div magassag miatt
  
  
  
  echo '<div class="product-info">

	<a href="/'.$_SESSION["langStr"].'/'.$lang->_termek.'/'.$func->convertString($arr['markanev']).'-'.$func->convertString($arr['termeknev']).'/'.$arr['id'].'"><h2>'.$arr['markanev'].' '.$arr['termeknev'].'</h2></a>
	<a href="/'.$_SESSION["langStr"].'/'.$lang->_termek.'/'.$func->convertString($arr['markanev']).'-'.$func->convertString($arr['termeknev']).'/'.$arr['id'].'">'.$arr['szin'].'</a>';


  echo '<div class="products-prise-container">';

  if($lang->defaultCurrencyId == 0)
  { //MAGYARORSZÁG ESETÉN
   if($arr['akcios_kisker_ar'] > 0)
   {
	
	
	//if ($func->isMobile()==0)
	echo '<span class="products-thumb-originalprise"><del>'.number_format($arr['kisker_ar'],0,'','.').'</del> Ft</span><br />';    
	echo '<span class="products-thumb-saleprise">'.number_format($arr['akcios_kisker_ar'],0,'','.').' Ft</span>';
	
   }
   else
    echo $lang->Ar.' '.number_format($arr['kisker_ar'],0,'','.').' Ft';

  }else
  {

   //ÁTVÁLTÁS

   if($arr['akcios_kisker_ar'] > 0)
   {
	echo '<span class="products-thumb-originalprise">€ <del>'.$func->toEUR($arr['kisker_ar']).'</del></span><br />';
    echo '<span class="products-thumb-saleprise">€ '.$func->toEUR($arr['akcios_kisker_ar']).'</span>';
   }
   else
    echo $lang->Ar.' € '.$func->toEUR($arr['kisker_ar']);
	
  }


  echo '</div>
	  </div>
  </div>';
 }
  
  
      
echo '</div>';


}