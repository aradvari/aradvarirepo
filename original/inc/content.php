<?
// Belga shop img
$BelgaKat = array(154,150,151,152,153,155);

$url = $_GET['query'];
$exp = explode("/", $url);

if (in_array($exp[3], $BelgaKat))
	// belga disco
    //echo '<a href="/' . $_SESSION["langStr"] . "/" . $lang->_termekek . '/belga/153" ><img src="/banner/2015/belga_disco_header.jpg" alt="belga.coreshop.hu" class="belga-spot"	/></a>';
    echo '<a href="/' . $_SESSION["langStr"] . "/" . $lang->_termekek . '/belga/153" ><img src="/banner/2016/20160610_belga_cover.jpg" alt="belga.coreshop.hu" class="belga-spot"	/></a>';
	//include "inc/inc.infobox-extra.php"; 
	
// SPICOLI TOPBANNER 
$nobanner=array('termek','uzletunk', 'tranzakcio', 'temp', /*'megrendeles',*/ 'sikeres_vasarlas', 'termekcsere', 'kapcsolat', 'altalanos_szerzodesi_feltetelek', 'etnies_birthday_pack', 
/*'vans-old-skool'*/);
$nobanner_pages=array(
				'/hu/termekek/0/0/vans/41',	
				'/hu/etnies-x-plan-b',
				'/hu/termekek/napszemuveg/121',
				'/hu/termekek/napszemuveg/121/Vans/41',
				);


// top banner
 /*if ( ((!in_array($page, $nobanner)) && (!in_array($exp[3], $BelgaKat))) && (!in_array($_SERVER['REQUEST_URI'], $nobanner_pages)) )
	 include 'inc/banner.vans-kiegeszitok-2017-xmas.php';*/
	//include "inc/banner.vans-spicoli4shades-2017-apr.php";
	/*	echo '<div class="topbanner"><img src="/banner_product_page/2017/20171018_ajandek_beched_bag.jpg" /></div>';
	echo '<div class="topbanner">
	<a href="/hu/termekek/ferfi-cipo/160">
	<img src="/banner_product_page/2017/20171125_blackenedweekend.jpg" alt="Blackened Weekend! 2017. nov. 24-26." title"Blackened Weekend! 2017. nov. 24-26." />
	</a></div>';*/

	
	
// glamour banner
//echo '<div class="topbanner"><img src="/banner_product_page/2017/glamour17-topbanner-coreshop.jpg" /></div>';


/* // griptape topbanner
$hardware_pages=array(
				'/hu/termekek/gordeszka-lapok/114',	
				'/hu/termekek/gordeszka-lapok/114/Almost/70',
				'/hu/termekek/gordeszka-lapok/114/Darkstar/72',
				'/hu/termekek/gordeszka-lapok/114/Enjoi/71',
				'/hu/termekek/gordeszka-lapok/114/Jart/118',
				'/hu/termekek/gordeszka-lapok/114/Mini%20Logo/53',
				'/hu/termekek/gordeszka-lapok/114/SK8MAFIA/55',
				'/hu/termekek/gordeszka/114/',
				'/hu/termekek/gordeszka-lapok/114?oldal=0',				
				'/hu/termekek/gordeszka-lapok/114?oldal=1',
				'/hu/termekek/gordeszka-lapok/114?oldal=2',
				'/hu/termekek/gordeszka-lapok/114?oldal=3',
				'/hu/termekek/gordeszka-lapok/114?oldal=4',
				'/hu/termek/mini-logo-small-bomb/6873',
				'/hu/termek/mini-logo-small-bomb/6872',
				'/hu/termek/mini-logo-small-bomb/6871',
				'/hu/termek/jart-sk8-or-die/6819',
				'/hu/termek/jart-sk8-or-die/6818',
				'/hu/termek/jart-team/6817',
				'/hu/termek/jart-team/6816',
				'/hu/termek/jart-biggie/6815',
				'/hu/termek/jart-biggie/6814',
				'/hu/termek/jart-biggie/6813',
				'/hu/termek/jart-biggie/6812',
				'/hu/termek/sk8mafia-kellen-james/6870',
				'/hu/termek/sk8mafia-wes-kremer/6845',
				'/hu/termek/sk8mafia-jimmy-cao/6843',
				'/hu/termek/sk8mafia-larelle-gray/6842',
				'/hu/termek/sk8mafia-every-day/6841',
				'/hu/termek/sk8mafia-love/6840',
				'/hu/termek/sk8mafia-wet/6839',
				'/hu/termek/sk8mafia-gabby/6838',
				'/hu/termek/sk8mafia-wet-3/6837',
				'/hu/termek/sk8mafia-wet-2/6836',
				'/hu/termek/sk8mafia-jammin/6835',
				'/hu/termek/sk8mafia-rudis/6834',
				'/hu/termek/sk8mafia-house-logo/6833',
				'/hu/termek/sk8mafia-og-logo/6832',
				'/hu/termek/sk8mafia-og-logo/6831',
				'/hu/termek/enjoi-cat-series/6655',
				'/hu/termek/enjoi-jim-houser-series/6654',
				'/hu/termek/almost-batman-split-face/6652',
				'/hu/termek/darkstar-molten/6649',
				'',
				);
				
if (in_array($_SERVER['REQUEST_URI'], $hardware_pages))
include "inc/banner.free_griptape_20170530.php"; */
	
	
echo '<div class="content">';

// errormessage
if(!empty($error->error))	{
	echo '<div class="alertbox">';
	foreach( ($error->error) as $errormessage)
		echo $errormessage.'<br />';
	echo '</div>';
}


// kosarba utan uzenet
if(!empty($error->cart))
	include 'inc/inc.checkout.php';
	
  
if (is_file("pages/page.$page.php")) include 'pages/page.'.$page.'.php';


echo '</div>';


/* // spicoli banner
if ( ((!in_array($page, $nobanner)) && (!in_array($exp[3], $BelgaKat))) && (!in_array($_SERVER['REQUEST_URI'], $nobanner_pages)) )
	include "inc/banner.vans-spicoli4shades-2017-apr.php"; */