<div class="footer-container">


<div id="block" style="width:33%;">		
	
	<img src="/images/footer-logo.svg" alt="Coreshop logo" title="Coreshop logo" />
	
	<br />
	
	<a href="tel:+36706762673">+36 70 676 2673</a>&nbsp;&nbsp;<a href="tel:+36706311717">+36 70 631 1717</a>
	
	<br />
	
	1163 Budapest, Cziráki utca 26-32. Fsz. 24/A
	
	<br />
	
	<a href="mailto:info@coreshop.hu">info@coreshop.hu</a>, <a href="mailto:garancia@coreshop.hu">garancia@coreshop.hu</a>
	
	<br />
	<br />
	
	<a href="https://www.facebook.com/coreshop" target="_blank"><img src="/images/social_fb-1.svg" alt="Coreshop @facebook.com" class="soc-icon" /></a>
	<a href="https://www.instagram.com/coreshop.hu/" target="_blank"><img src="/images/social_insta.svg" alt="Coreshop @instagram.com" class="soc-icon" /></a>
	<a href="https://plus.google.com/+coreshop" target="_blank"><img src="/images/social_g-1.svg" alt="Coreshop @plus.google.com" class="soc-icon" /></a>
	
	<br />
	&copy; <?=date('Y')?> Coreshop.hu
	
</div>


<div id="block" style="border-left:1px solid #fff;border-right:1px solid #fff;width:25%;padding:0 4%;">
	
	<img src="/images/cxs.svg" alt="Coreshop Express Shipping logo" />
	<img src="/images/express.svg" alt="CXS logo" /></span>
	<span>"Ma megrendeled, holnap már hordhatod!"</span>
	
	<br />
	<br />

	<span>
	Ha most rendelsz, csomagod <br /><font style="color:#2a87e4;"><?=$func->dateToHU($func->GLSDeliveryDate('HU'))?> / 8:00 - 16:00 óra</font></br >
	között kerül kiszállításra.
	</span>
	
	<br />
	<br />
	
	<img src="/images/box.svg" alt="box" />
	<img src="/images/free.svg" alt="Ingyenes kiszállítás" />
	
	<br />
	
	<span>
	<?
	// ingyenes szallitas ertekhatar
	while($reszletek=each($_SESSION['kosar']))	{              
		$kosar_fizetendo = $kosar_fizetendo + ( $reszletek[1][3] * $reszletek[1][2] );
	}
	
	$ingyenes_szallitas_ertekhatar = $func->getMainParam('ingyenes_szallitas') - $kosar_fizetendo;
	if ( ($ingyenes_szallitas_ertekhatar) >0 )	{
		echo 'Az ingyenes szállításhoz '.number_format($ingyenes_szallitas_ertekhatar, 0, '', '.').' Ft szükséges';
		}
	else
		echo 'Elérted a '.number_format($func->getMainParam('ingyenes_szallitas'), 0, '.', '.').' Ft ingyenes szállítás értékhatárát!';
	?>
	</span>
	
	
</div>


<!-- CIB -->
<div id="block" style="width:29%;padding-left:4%;">

<p>A bankkártyás fizetés szolgáltatója a</p>

<a href="/<?=$lang->defaultLangStr?>/kartyas-fizetes"><img src="/images/cibbank-logo.png" alt="Kártyás fizetés szolgáltatója" title="Tájékoztató a bankkártyás fizetésről" style="margin:10px 0;" /></a>

<br />
<br />

<p>Elfogadott bankkártya típusok</p>

<a href="/<?=$lang->defaultLangStr?>/kartyas-fizetes"><img src="/images/cib-kartyalogok.png" alt="Elfogadott bankkártya típusok" style="margin:10px 0;" /></a>

<br />
<br />

<p><a href="/<?=$lang->defaultLangStr?>/<?=$lang->_kartyas_fizetes?>">Tájékoztató a bankkártyás fizetésről</a></p>

<p><a href="/<?=$lang->defaultLangStr?>/<?=$lang->_kerdesek_valaszok?>">Gyakran feltett kérdések</a></p>

</div>

</div>