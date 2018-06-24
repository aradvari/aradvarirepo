<?


// ezeken az oldalakon nincs banner
$pages= array('app', 'marka', 'temp', 'megrendelesteszt', 'megrendeles');

if (!in_array($_SESSION['page'], $pages))
	echo '<a href="/hu/termekek/kiegeszito/121"><img src="/banner/2015/20150309_vans_spicoli_topbanner.png" alt="Vans Spicoli 4 Shades napszemüveg - Coreshop" style="max-width:1200px;width:100%;" /></a>';
	
	
	
	
	
?>

<div class="infobox-extra" style="display:none;">
	
	<div style="float:left; width:30%; padding-left:10px;">
		<p>Készlet információ</p>
		<br />
		Minden termék raktáron van,
		<br />
		szállításra készen!
		<!--
		Minden termék
		-->
	</div>
	
	<div style="float:left; width: 33%;border-left:0px solid #999;border-right:0px solid #999;padding-right:20px;margin-right:20px;">
		<p>Szállítás</p>
		<br />
		Ha rendelésed most adod le a kiszállítás napja:<br /><b style="color:#0088e3;"><?=$func->dateToHU($func->GLSDeliveryDate('HU'))?></b>
	</div>
		
	<div style="float:left; width:28%;">
		<a href="/hu/uzletunk">
		<p>Bemutatótermünk nyitvatartása</p>
		<br />
		Hétfőtől péntekig: 10:00 - 16:00-ig<br />
		1163 Budapest, Cziráki utca 26-32.
		</a>
	</div>
	
</div>
	
<?
 // }
?>