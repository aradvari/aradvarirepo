<?php
 header('Content-Type: text/html; charset=utf-8');
  ob_start();

  session_start();
  
  
  /*echo 'post: ';
print_r($_POST);

echo '<br />';

echo 'session: ';
print_r($_SESSION);
*/
  
  

  if (ISSET($_POST['belepesarendszerbe'])){
    
      if ($_POST['username']=='coreshop' && $_POST['password']=='murderone'){$_SESSION['logged']='';}
      
  }   
                             
  if (!ISSET($_SESSION['logged'])){
    
      require('login.php'); return false;
      
  }

  require('include/login.php');
  


  mysql_query("SET NAMES 'utf8';");

  require ("classes/functions.class.php");
  $func = new functions();
  
/////////////////////////////////////////////////////////////////////////

$headline = 'Coreshop - ADM';

$mainpage ='index.php';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$uj = number_format(@mysql_num_rows(@mysql_query("SELECT id_megrendeles_fej FROM megrendeles_fej WHERE sztorno IS NULL AND id_statusz=1 AND id_szallitasi_mod=1")),0,".",".");

$uj_forgalom = mysql_fetch_array(mysql_query("SELECT sum(fizetendo) as forg FROM megrendeles_fej WHERE id_statusz=1 AND sztorno IS NULL AND id_szallitasi_mod=1"));
//$uj_forgalom = mysql_fetch_array(mysql_query("SELECT (sum(fizetendo)-sum(giftcard_osszeg)) as forg FROM megrendeles_fej WHERE id_statusz=1 AND sztorno IS NULL AND id_szallitasi_mod=1"));
$uj_forgalom = number_format($uj_forgalom[0],0,".",".");

$gls = number_format(@mysql_num_rows(@mysql_query("SELECT id_megrendeles_fej FROM megrendeles_fej WHERE sztorno IS NULL AND id_statusz=1 AND id_szallitasi_mod=1")),0,".",".");
$szemelyes = number_format(@mysql_num_rows(@mysql_query("SELECT id_megrendeles_fej FROM megrendeles_fej WHERE sztorno IS NULL AND id_statusz=1 AND id_szallitasi_mod=2")),0,".",".");
$sza = number_format(@mysql_num_rows(@mysql_query("SELECT id_megrendeles_fej FROM megrendeles_fej WHERE sztorno IS NULL AND id_statusz=2")),0,".",".");
$zart = number_format(@mysql_num_rows(@mysql_query("SELECT id_megrendeles_fej FROM megrendeles_fej WHERE sztorno IS NULL AND id_statusz=3")),0,".",".");
$szt = number_format(@mysql_num_rows(@mysql_query("SELECT id_megrendeles_fej FROM megrendeles_fej WHERE sztorno IS NULL AND id_statusz=99")),0,".",".");
$ossz = number_format(@mysql_num_rows(@mysql_query("SELECT id_megrendeles_fej FROM megrendeles_fej WHERE sztorno IS NULL")),0,".",".");

$garishibak = number_format(@mysql_num_rows(@mysql_query("SELECT * FROM garancias_hibak WHERE statusz=1")),0,".",".");

$sanyi = number_format(@mysql_num_rows(@mysql_query("SELECT id_megrendeles_fej FROM megrendeles_tetel WHERE id_termek=4810")),0,".",".");

// coreclub
$ujk = @mysql_num_rows(@mysql_query("SELECT 
                                                         f.id, sum(k.kikerulesi_ar) osszeg 
                                                       FROM felhasznalok f 
                                                       LEFT JOIN keszlet k ON (k.id_felhasznalok = f.id)
                                                       WHERE 
                                                         f.torolve IS NULL AND 
                                                         (aktivacios_kod IS NULL OR aktivacios_kod='') AND 
                                                         (kartya_kod IS NULL OR kartya_kod='')
                                                       GROUP BY f.id
                                                       HAVING osszeg > 50000
                                                       "));

////////////////////////////////////////////////////////////////////////
$sql_lejaro = mysql_query("SELECT 
			f.id,
			CONCAT(f.vezeteknev, ' ', f.keresztnev) nev,
			f.email,
			SUM(mf.fizetendo)-SUM(mf.szallitasi_dij) as osszeg,
			MAX(mf.datum)
			FROM megrendeles_fej mf
			LEFT JOIN felhasznalok f ON mf.id_felhasznalo = f.id
			WHERE f.kartya_kod >0
			AND mf.sztorno IS NULL
			AND mf.id_statusz=3
			GROUP BY mf.id_felhasznalo
			ORDER BY MAX(mf.datum)
			");

while ($lejaro=mysql_fetch_array($sql_lejaro))	{
	
	if($lejaro['MAX(mf.datum)'] < date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), date("d"), date("Y")-1)) )
		$ossz_lejaro++;	
}
////////////////////////////////////////////////////////////////////////
													   
echo '<form method="post" action="?lap=felhasznalok" name="klubForm" id="klubForm">
                            <input type="hidden" name="klubtag" value="1" />
                            <input type="hidden" name="klubkartya" value="0" />
                            <input type="hidden" name="szures" value="" />
							</form>';
													   
// nagyker potlas
$potlas = @mysql_num_rows(@mysql_query("SELECT * FROM vonalkodok v LEFT JOIN termekek t ON (v.id_termek = t.id) WHERE v.keszlet_1=0 AND v.keszlet_3>0 AND t.torolve IS NULL"));

// fuggo tranzakciok
$fuggo = @mysql_num_rows(@mysql_query("SELECT id_megrendeles_fej FROM megrendeles_fej WHERE sztorno IS NULL AND id_statusz=50"));


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  
$main_items = array(
		"Megrendelések" => array (
											"új megrendelés <div class='counter'>".$uj."</div>" =>	"megrendelesek&id_statusz=1",
											"személyes átvétel <div class='counter'>".$szemelyes."</div>" =>	"megrendelesek&id_statusz=1&id_szallitasi_mod=2",
											/*"<li>GLS futárszolgálat <div class='counter'>".$gls."</div></li>" =>	"megrendelesek&id_statusz=1&id_szallitasi_mod=1",
											"<li>Személyes átvétel <div class='counter'>".$szemelyes."</div></li>" =>	"megrendelesek&id_statusz=1&id_szallitasi_mod=2",*/
											/*"számlázónak átadva <div class='counter-atadva'>".$sza."</div>" =>	"megrendelesek&id_statusz=2",*/
											/*"Sanyi <div class='counter'>".$sanyi."</div>" =>	"megrendelesek&id_statusz=1&id_termek=4810",*/
											"lezárt megrendelés <div class='counter-inactive'>".$zart."</div>" =>	"megrendelesek&id_statusz=3",
											"sztornó megrendelés <div class='counter-inactive'>".$szt."</div>" =>	"megrendelesek&id_statusz=99",
											"összes megrendelés <div class='counter-inactive'>".$ossz."</div>" =>	"megrendelesek&id_statusz=0"),	
											
		"Forgalom" => 		array (
											"időszakos forgalom" =>	"forgalom",
											"aktuális forgalom<div class='counter'>".$uj_forgalom."</div>"			 =>	"megrendelesek&id_statusz=1"),
											
		"Felhasználók" => array (
											"felhasználók kezelése" =>	"felhasznalok",
											"garanciás hibák <div class='counter-inactive'>".$garishibak."</div>"		=> "garanciak"),	
											
		/*"CoreClub" => 		array (
											"új tagok <a href='onclick=\'document.klubForm.submit()\''></a><div class='counter'>".$ujk."</div>" =>	"felhasznalok",
											"lejáró tagság <div class='counter-inactive'>".$ossz_lejaro."</div>" =>	"cc_lejaro"), */

		"Adminisztráció" => array (
											"paraméterezések" =>	"parameterezes",
											"képmozgatás" =>		"kepmozgatas",
											/*"képmozgatás FEHÉR" =>		"kepmozgatas_feher",*/
											/*"aktuális vásárlók" =>	"session",*/
											"infobox" =>			"infobox",
											"kezdőlap termékajánló" =>	"ajanlat",											
											"Giftcard generálás" =>	"giftcard_generate"),
		
		"APP" => array (		
											"APP paraméterezések" =>	"parameterezes_app",
											"APP hírek" => "app_news"),
											
		"Termékek" => 		array (
											"termékek kezelése" =>	"termekek",
											"termékkapcsolatok" =>	"termekkapcsolatok",
											"vonalkód sorrendek" =>	"vonalkod_sorrendek",
											"top termékek" =>	"termekek_top",
											"keresések" =>	"keresendo_log",
											"VANS képek" =>	"termekkep",
											//"nagyker pótlás <div class='counter'>".$potlas."</div>" =>	"potlas"
											),
		
		"CIB Bank" => 		array (
											"tranzakciók" =>	"tranzakciok",
											"függő megrendelések <div class='counter'>".$fuggo."</div>" =>	"megrendelesek&id_statusz=50"),	
											
		"STAT" => 		array (
											"Szavazás" =>	"stat"),			
		
		);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
<meta name="google" value="notranslate">
<meta name="format-detection" content="telephone=no">



<title><? if($uj>0) echo '('.$uj.') ';?><?=$headline;?></title>

<link href="style/adm_style.css" rel="stylesheet" type="text/css">
<link href="style/style_print.css" rel="stylesheet" type="text/css" media="print">
<link href="style/datepicker.css" rel="stylesheet" type="text/css" />
<script src="js/datepicker.js" type="text/javascript"></script>
<script src="js/shop.js" type="text/javascript"></script>

<!-- highslide JS -->

<script type="text/javascript" src="/js/highslide-with-gallery.js"></script>
<link rel="stylesheet" type="text/css" href="/js/highslide.css" />

<!--
    2) Optionally override the settings defined at the top
    of the highslide.js file. The parameter hs.graphicsDir is important!
-->

<script type="text/javascript">
    hs.graphicsDir = '/js/graphics/';
    hs.align = 'center';
    hs.transitions = ['expand', 'crossfade'];
    hs.outlineType = 'glossy-dark';
    hs.wrapperClassName = 'dark';
    hs.fadeInOut = true;
    hs.dimmingOpacity = 0.7;


    // Add the controlbar
    if (hs.addSlideshow) hs.addSlideshow({
        //slideshowGroup: 'group1',
        interval: 5000,
        repeat: false,
        useControls: false,
        fixedControls: 'fit',
        overlayOptions: {
            opacity: .6,
            position: 'bottom center',
            hideOnMouseOut: true
        }
    });
</script>

<!-- end of highslide JS -->

</head>

<body>

<div class="header">
	<!-- <a href="/<?=$mainpage;?>"><?=$headline;?></a>	-->
	
	<?
	foreach ($main_items as $main_item => $sub_items)	{
		
			echo '<div class="main_item"><p>'.$main_item.'</p>';
			
				foreach ($sub_items as $sub_item => $sub_item_url)
					echo '<div class="sub_item"><a href="'.$mainpage.'?lap='.$sub_item_url.'">'.$sub_item.'</a></div>';
					
			echo '</div>';
			
			}
	?>
			
</div>

<center>

<div class="lap-container">	

	<?php
	  if (!ISSET($_GET['lap']))	{
	   //include('modul.index.php');
	   //include 'modul.megrendelesek.php';		//default page
	   header('Location: /index.php?lap=megrendelesek&id_statusz=1');	//default page
	   
	  }	else	{	
	    if (!is_file('modul.'.$_GET['lap'].'.php')){
		  //include('modul.index.php');
		}else{include('modul.'.$_GET['lap'].'.php');}
	  }
	  
	ob_end_flush();
	
	
	?>
	
	<div style="width:80%;max-width:910px;min-width:910px;padding:5px 0;margin:10px 0;text-align:right;">&copy; <?=date('Y');?> Coreshop.hu</div>
</div>

</center>

</body>
</html>