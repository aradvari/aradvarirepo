<?
include 'inc/'.$lang->defaultLangStr.'/welcome.spot.php';			// main slider

echo '<div class="welcome-pattern-container">';						// terulo, volt

include 'inc/'.$lang->defaultLangStr.'/welcome.infobox.php';		// 3 info line 8

//echo '<br />';
//include 'inc/welcome.mainmenu.php';									// mobilon fomenu a kezdolapon
if($func->isMobile()) include 'inc/welcome.maincat.php';									// mobilon fokategoriak a kezdolapon
echo '<br />';


// XMAS
/* echo '<div class="xmas-shipping" style="padding:1% 2%; margin-bottom:20px;">
<p>Karácsonyig megérkezik?<br />Igen, garantáljuk!</p>

<b>Ha megrendelésed még MA 15:00 ÓRA ELŐTT adod le, akkor a GLS futár pénteken kézbesíti csomagod.</b>
</div>'; */


include 'inc/'.$lang->defaultLangStr.'/welcome.bannerbox.php';		// 3 box


/* // Spicoli topbanner
//if(!$func->isMobile()) {											// mobilon nincs spicoli banner
	echo '<div class="content-right-headline" style="clear:both;">ajándék vans napszemüveg!</div>';
	include "inc/banner.vans-spicoli4shades-2017-apr.php";			
	echo '<br /><br />';
	//} */

	
/*	echo '<a href="/hu/termekek/gordeszka-lapok/114">';

	include "inc/banner.free_griptape_20170530.php";
	
echo '</a>'; */
	
//echo '<div class="topbanner"><img src="/banner_product_page/2017/20171018_ajandek_beched_bag.jpg" /></div>';	// ajandek benched bag
	
if(!$func->isMobile()) include 'inc/welcome.ajanlo.php';			// mobilon nincs ajanlo
/* if($func->isMobile()) echo '<a href="/hu/termekek/ferfi-cipo/94"><img src="/newsletter/2017/41/chill_n_shop_header.jpg" alt="Chill \'n Shop - 20% akció!" title="Chill \'n Shop - 20% akció!" style="width:96%;"/></a>';
include 'inc/welcome.ajanlo.php';			// mobilon nincs ajanlo */

echo '</div>';

?>