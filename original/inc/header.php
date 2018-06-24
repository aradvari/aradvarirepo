<?
// mobil menu
$fokat = array(92 => array('ferfi_ruhazat', 105, 'ferfi_ruhazat', 90),		
		   107 => array('noi_ruhazat', 116, 'noi_ruhazat', 91),
		   94 => array('cipo', 94, 'cipo', 89),
		   149 => array('kiegeszito', 149, 'kiegeszito', 98),
		   114 => array('gordeszka', 114, 'gordeszka', 112),
		   159 => array('ferfi_cipo', 160, 'outlet', 160)
		   );
		   
?>


<div class="header"> <!-- fixed -->

<div class="header-topline">
<div class="header-topline-container">
<a href="tel:+36706762673" class="header-topline-tel">Telefonos rendelés: +36 70 676 2673</a>
	<span><a href="/hu/rolunk">Rólunk</a></span>
	<span><a href="/hu/uzletunk">Üzletünk</a></span>
	<span><a href="/hu/altalanos-szerzodesi-feltetelek">ÁSZF</a></span>
	<span><a href="/hu/szallitas">Szállítás</a></span>
	<span><a href="/hu/altalanos-szerzodesi-feltetelek#6a">Garancia</a></span>
	<span><a href="/hu/termekcsere">Termékcsere</a></span>
	<span><a href="/hu/kapcsolat">Kapcsolat</a></span>
	<span><a href="/hu/instafeed" class="header-instafeed">Instafeed [Új]</a></span>
	
	
	<a href="http://facebook.com/coreshop" target="_blank" id="facebook"><img src="/images/social_fb-1.svg" alt="Coreshop @facebook.com" /></a>
	<a href="http://instagram.com/coreshop.hu" target="_blank" id="instagram"><img src="/images/social_insta.svg" alt="Coreshop @instagram.com" /></a>
	<a href="https://plus.google.com/103506333733297319481" target="_blank" id="googleplus"><img src="/images/social_g-1.svg" alt="Coreshop @plus.google.com" /></a>
	
</div>
</div>

<div class="header-main">

	<div class="header-main-container">
	<a href="/"><img src="/images/coreshop_logo_w_icon.svg" alt="Coreshop.hu" class="logo" /></a>
	
	<?
	
	// new, hover menu
	include 'inc/topmenu.php';
	
	/*if($_GET['t']==1)
		include 'inc/topmenu.php'; //new, hover menu
	else
		include 'inc/topmenu2016.php';	// old menu */
	?>
		
	<!-- cart float right -->
	<div class="desktop-cart">
	<img src="/images/cart-black.png" alt="Kosár"  />&nbsp;		
	<? include 'inc/top-kosar.php'; ?>
	</div>
	
	<!-- search float right -->
	<div class="desktop-search">
	<form id="ajax_search_form" action="/<?=$_SESSION["langStr"].'/'.$lang->_termekek;?>'" method="post" autocomplete="off" />
	
	<? if(!empty($_REQUEST['keresendo'])) $placeholder=$_REQUEST['keresendo']; else $placeholder="Keresés"; ?>
	
	<input type="text" name="keresendo" id="search-top" placeholder="<?=$placeholder;?>" />	
	
	<!-- search results -->
	<div id="search-result-container" >	
		
	</div>
	
	</form>
	</div>
	
	</div>
	
</div>

</div>


<?

if ($_SESSION['page']=='termekek')	{

$is_fokat=mysql_fetch_array(mysql_query('SELECT id_kategoriak, szulo FROM kategoriak WHERE id_kategoriak='.$_SESSION['kategoria']));
	
	echo '<div class="desktop-subcat">';
						
	$subcat=mysql_query('SELECT k.id_kategoriak, k.nyelvi_kulcs, k.megnevezes, k.szulo
						FROM kategoriak k
						LEFT JOIN termek_kategoria_kapcs tkk ON tkk.id_kategoriak = k.id_kategoriak
						LEFT JOIN termekek t ON t.id = tkk.id_termekek
						LEFT JOIN vonalkodok v ON v.id_termek = t.id
						WHERE k.sztorno IS NULL
						AND t.aktiv =1
						AND v.keszlet_1 >0
						AND t.torolve IS NULL
						AND k.szulo ='.$is_fokat['szulo'].' 
						GROUP BY k.id_kategoriak
						ORDER BY k.sorrend');	
	
	
	while ($row=mysql_fetch_array($subcat))	{	
	
		if($_SESSION['kategoria']==$row['id_kategoriak']) $selected='class="selected"'; else $selected='';
		
		
		echo '<a href="/'.$_SESSION["langStr"].'/'.$lang->_termekek.'/'.$func->convertString($row['megnevezes']).'/'.$row['id_kategoriak'].'" '.$selected.'>'.$lang->$row['nyelvi_kulcs'].'</a> ' ;
	}
	
	echo '</div>';
}
//echo '</div>';
// endof desktop fixed header


// mobile header
echo '<div class="mobile-header">';

echo '<a href="/"><img src="/images/coreshop_logo_w_icon.svg" alt="Coreshop" /></a>';


if (!isset($kosar_db)) $kosar_db=0;	// hogy mobilon megjelenjen a nullas kosar
echo '<div class="mobile-cart"><a href="/'.$_SESSION["langStr"].'/'.$lang->_megrendeles.'">';
echo '<img src="/images/cart-black.png" alt="Kosár" />';
echo '<div class="mobile-cart-item">( '.$kosar_db.' )</div>';
echo '</a></div>';



// mobile menubutton			
echo '<div class="mobile-nav" id="menubutton">
			<img src="/images/menu_mobile.png" alt="Menu" />
		</div>'; 
			
echo '</div>';
// endof mobile header


// mobile main menu
echo '<div class="mobile-menu" id="mobile-menu">';

// kereso
echo '<div class="mobile-search">';
echo '<form action="/'.$_SESSION["langStr"].'/'.$lang->_termekek.'" method="post" />';

if(!empty($_REQUEST['keresendo'])) $placeholder=$_REQUEST['keresendo']; else $placeholder="Termékkeresés";

echo '<input type="text" name="keresendo" id="search-top" placeholder="'.$placeholder.'" style="width:78%; margin-right:2%;"/>';
echo '<input type="submit" value="OK" style="width:16%;" />';

echo '</form>';
echo '</div>';
	
include 'inc/welcome.mainmenu.php';
	
/*
// fokategoriak
foreach($fokat as $fk)	{	

	if($_SESSION['kategoria']==$fk[1]) $maincat='mobile-maincat-selected'; else $maincat='mobile-maincat';
	
	echo '<div class="'.$maincat.'">
	<a href="/'.$_SESSION["langStr"].'/'.$lang->_termekek.'/'.$func->convertString($lang->$fk[0]).'/'.$fk[1].'">
	'.$lang->$fk[2].'</a>
	</div>';	
	}
	
*/


//subpages	
echo '<div class="mobile-subpages-container">
	<a href="/hu/rolunk">Rólunk</a>
	<a href="/hu/uzletunk">Üzletünk</a>
	<a href="/hu/szallitas">Szállítás</a>
	<a href="/hu/altalanos-szerzodesi-feltetelek#6a">Garancia</a>
	<a href="/hu/termekcsere">Termékcsere</a>
	<a href="/hu/kapcsolat">Kapcsolat</a>
	<a href="/hu/instafeed">Instafeed [Új]</a>
</div>';

	
echo '</div>';