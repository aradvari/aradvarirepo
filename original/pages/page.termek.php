<? 
// hibak kikapcsolva ezen az oldalon
ini_set("display_errors", 0); 
?>

<!-- ha be van linkelve, akkor nem mukodik a lenyilo menu -->
<script src="/js/prototype.js" type="text/javascript"></script>
<script src="/js/ajax.2015.js" type="text/javascript"></script>

<!-- TOP NAV -->
<div class="product-nav"><?=$termek->topnav?></div>

<!-- THUMB, MAINIMAGE, INFOBOX container -->
<div class="product-container">

<!-- KEP ELEJE -->
<select id="optionlist" onChange="javascript:changeImage()" style="display:none">
<?
	if (is_array($termek->kepek)){

		while ($pic = each($termek->kepek)){
			
	
			echo '<option value="/'.$pic[1].'">First Image</option>';
			
		}
		
	}
?>
</select>

<?

// MOBILE PRODUCT DETAILS
if($func->isMobile())	{
echo '<div class="product-details-mobile">';

echo '<h1>'.$termek->termek['markanev'].' '.$termek->termek['termeknev'].'</h1> <h2>'.$termek->termek['szin'].'</h2>';


echo '</div>';
}



echo '<div class="product-thumbs">';

// THUMBS, ASZTALIN BAL SZELEN
$i=0;
foreach($termek->kepek as $kep)	{		
	// img resizing with script
	echo '<img src="/image_resize.php?w=110&img=/'.$kep.'" 
	id="'.thumb.$i.'" 
	name="'.thumb.$i.'" 
	onClick="javascript:nextImage(\''.$i.'\')"  
	alt="'.$termek->termek['markanev'].' '.$termek->termek['termeknev'].' '.$termek->termek['szin'].' '.$i.' - coreshop.hu" 
	title="'.$termek->termek['markanev'].' '.$termek->termek['termeknev'].' '.$termek->termek['szin'].' '.$i.' - coreshop.hu"  />';

	$i++;
	}
	

echo '</div>';



echo '<div class="product-image-container">';

// 3x jelenik meg a keplapozas info
if($_SESSION['product-image-nav-info']<1)	{
	if(!$func->isMobile())
		echo '<div class="product-image-nav-info">További nézetekhez klikkelj a képre</div>';
	else
		echo '<div class="product-image-nav-info" style="padding:1px;">További nézetekhez klikkelj a képre</div>';
		
	$_SESSION['product-image-nav-info']++;
	}


// a regi allokepek miatt, itt kell megnezni, hogy mi legyen a szelesseg
if ($termek->sizes[0]>=$termek->sizes[1])
	$style="width:100%;z-index:1;";	//fekvokep style
else
	$style="width:60%;z-index:1;";	//allokep style 
	

?>

<div class="product-image">

<!-- PRODUCT IMAGE, DESC -->
<img name="mainimage" 
id="mainimage" src="/images/loading.gif" 
onClick="javascript:nextImage()" 
alt="<?=$termek->termek['markanev'].' '.$termek->termek['termeknev'].' '.$termek->termek['szin'].' - coreshop.hu';?>" 
title="<?=$termek->termek['markanev'].' '.$termek->termek['termeknev'].' '.$termek->termek['szin'].' - coreshop.hu';?>" 
style=<?=$style?> />

<div id="zoom-icon" class="zoom-div-icon"><img src="/images/search.svg" alt="zoom" /></div>

</div>
	
<?
echo '<div class="product-description" style="display:block; margin-bottom:10px;">'.nl2br($termek->termek['leiras']).'</div>';
?>

</div>
<!-- ENDOF PRODUCT IMAGE, DESC -->


<!-- zoom div 100% -->
<div id="zoom-div" class="zoom-div">
<?
// close
echo '<div id="zoom-close" class="zoom-close">X</div>';

// thumbs
echo '<div class="product-thumbs-zoom">';

// thumbs bal szelen
$i=0;
foreach($termek->kepek as $kep)	{		
	// img resizing with script
	echo '<img src="/image_resize.php?w=110&img=/'.$kep.'" id="'.thumbzoom.$i.'" name="'.thumbzoom.$i.'" onClick="javascript:nextImage(\''.$i.'\')"  alt="'.$termek->termek['markanev'].' - '.$termek->termek['termeknev'].' - '.$termek->termek['szin'].' - coreshop.hu" />';

	$i++;
	}
echo '</div>';
?>
<img name="mainzoomimage" id="mainzoomimage" src="" onClick="javascript:nextImage()" s_tyle="width:60%;outline:1px solid red;" />
</div>
<!-- endof zoom div -->
	
	
	


<!-- product-order-desktop -->
<div class="product-order-desktop">

<?	

// termek infobox
echo '<div class="product-details-desktop">';

echo '<img src="/pictures/markak/'.$termek->termek['markaid'].'.png?17" alt="'.$termek->termek['markanev'].' - Coreshop"/>';

echo '<h1>'.$termek->termek['markanev'].' '.$termek->termek['termeknev'].'</h1>';

echo '<h2>'.$termek->termek['szin'].'</h2>';

if(!empty($termek->termek['cikkszam'])) echo 'Cikkszám: '.$termek->termek['cikkszam'];

echo '</div>';

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

		echo '<div class="product-prise">';

		// ar
		if($termek->termek['akcios_kisker_ar']>0)	{				
			/*echo '<h1><del style="color:#2a87e4;margin-right:10%;">'.number_format($termek->termek['kisker_ar'], 0, '', '.').' Ft</del>';	//eredeti ar
			echo number_format($termek->termek['akcios_kisker_ar'], 0, '', '.').' Ft</h1>'; 		//akcios ar	 */
			
			echo '<span class="eredeti_ar">'.number_format($termek->termek['kisker_ar'], 0, '', '.').' Ft</span>';			//eredeti ar
			echo '<span class="ar">'.number_format($termek->termek['akcios_kisker_ar'], 0, '', '.').' Ft</span>'; 	//akcios ar	 
			
			}
		else
			echo '<span class="ar">'.number_format($termek->termek['kisker_ar'], 0, '', '.').' Ft</span>';

		echo '</div>';	
}



// meretek
$sizes = $termek->getSizes($termek->termek['id'], 1, '');    //WEB RAKTÁR 

if($sizes)	{
	echo '<div id="termek-meretek">';
	echo '<p>Válassz méretet';

	// merettabla
	if ( ($termek->termek['kategoria']==94) || ($termek->termek['kategoria']==95) ) //ffi, v noi cipok
	echo '<a href="#'.$termek->termek['kategoria'].'_'.$termek->termek['markaid'].'" rel="facebox" style="float:right;padding:4px 10px 0 0;"><img src="/images/merettabla.png" style="vertical-align:middle;"> '.$lang->Merettablazat.'</a>';
	
	echo '</p>';	
	echo $sizes;
	echo '</div>';	
}
?>


<div id="termek-meretek">		

<form method="post">
			  <input type="hidden" name="termekid" value="<?=$termek->termek['id']?>" />
			  <input type="hidden" name="termeknev" value="<?=$termek->termek['termeknev']?>" />
			  <input type="hidden" name="ar" value="<?=$termek->termek['kosar_ar']?>" />
			  <input type="hidden" name="marka" value="<?=$termek->termek['markanev']?>" />
			  <input type="hidden" name="cikkszam" value="<?=$termek->termek['cikkszam']?>" />
			  <input type="hidden" name="opciostr" value="<?=$termek->termek['opcio']?>" />
	
<? 
/* $sql = "SELECT
		v.vonalkod, v.megnevezes, v.keszlet_1
		FROM termekek t
		LEFT JOIN vonalkodok v ON (v.id_termek = t.id AND v.aktiv=1 AND v.keszlet_1>0)
		LEFT JOIN vonalkod_sorrendek vs ON (vs.vonalkod_megnevezes=v.megnevezes)
		WHERE t.id=".$termek->termek['id']."
		ORDER BY vs.sorrend, v.megnevezes"; */
	 
$tomb = mysql_fetch_array(mysql_query($sql));
$rows = mysql_num_rows(mysql_query($sql));

if ($rows>0 && !empty($tomb[1]))	{

	if ($rows==1){
		echo '<div style="display:none">';
		echo $func->createSelectBox($sql, "", "name=\"meret\"", null);
		echo '<script>divKeszletMobile(\'keszlet\', \''.$tomb[0].'\')</script>';
		echo '</div>';
	}else{		    
		echo $func->createSelectBox($sql, "", "style='display:none;' name=\"meret\" id=\"meret\" onchange=\"divKeszletMobile('keszlet', this.options[this.selectedIndex].value)\"", "Válassz");
	}
	
	echo '<span id="keszlet"></span>';	// ajax
	
	
	// endof product-order-desktop
	echo '</div>';
	
	echo '<div class="product-shipping-info">

			<img src="/images/cxs_logo.svg" alt="CXS logo - Coreshop.hu" />
			<p>Kiszállítás: <a href="/hu/szallitas" target="_blank">'.$func->dateToHU($func->GlsDeliveryDate('HU')).'</a></p>

			<br />

			<img src="/images/shipping_logo.svg" alt="Shippin logo - Coreshop.hu" />
			<p>Ingyenes kiszállítás '.number_format($func->getMainParam('ingyenes_szallitas'), 0, '.', '.').' Ft felett.</p>

			<br />

			<img src="/images/shop_logo.svg" alt="Shop logo - Coreshop.hu" />
			<p>Gyere el és nézd meg <a href="/hu/uzletunk">bemutatótermünkben</a>.</p>

			</div>';
			
/* // XMAS
echo '<div class="xmas-shipping">
<p>Karácsonyig megérkezik?<br />Igen, garantáljuk!</p>

<b>Ha megrendelésed még MA 15:00 ÓRA ELŐTT adod le, akkor a GLS futár pénteken kézbesíti csomagod.</b>
</div>';*/
	
}
else
	{
	echo '<div class="kifutott_termek">
			<h2>KIFUTOTT TERMÉK!</h2>			
			Sajnáljuk, ez a termék elfogyott :(
			<br />
			<br />
			<br />
			Nézd meg aktuális kínlatunkat, bízunk benne találsz kedvedre valót újdonságaink között.
			</div>';
	// endof product-order-desktop
	echo '</div>';
	echo '</div>';
	}

?>	
</form>

</div>





<!-- endof THUMB, MAINIMAGE, INFOBOX container -->
</div>

<!-- endof product page container -->	
</div>	

<?

if (!empty($_COOKIE['prev1']))	{ 
	if(!$func->isMobile()) include('inc/inc.elozmeny.php');
}
elseif (!$func->isMobile()) { 
	include('inc/inc.ajanlo.php');
	setcookie( 'prev1', $_SESSION['termek_id'], strtotime( '+30 days' ), '/' );
}
?>


<?
//echo $func->getHDir($_SESSION['termek_id']);
?>

<!-- keplapozas -->
<script>
changeImage();
</script>