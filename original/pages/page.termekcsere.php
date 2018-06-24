<div class="textbox">

<div class="login_once">

<p>Termékcsere lehetőségek</p>


<? echo nl2br('Kedves Vásárlónk!

A megrendelt termék átvételétől számított 8 napon belül, sértetlen állapotú termék esetén lehetőséged van a terméket cseréltetni.

Amennyiben nem vagy megelégedve a termékkel (nem jó a méret, nem tetszik a szín, nem egészen olyan élőben, mint a fotón volt, stb...), akkor az alábbi lehetőségek közül választhatsz:<ul><li>Termékcsere más méretre</li>
<li>A rendelés végösszegének levásárlása</li>
<li>Pénzvisszautalás</li></ul>
<b>FONTOS</b>, hogy csak az oldalon található, azaz raktárkészleten lévő termékek közül válassz csereterméket. </b>

');

?>


<p>GLS termékcsere</p>

<center>
<a href="/images/csomagcsere-hibas.jpg" class="highslide" onclick="return hs.expand(this)" style="border:none; padding:0;">
<img src="/images/csomagcsere-hibas.jpg" style="width:47%;"  style="border:none; padding:0;" />
</a>

<a href="/images/csomagcsere-jo.jpg" class="highslide" onclick="return hs.expand(this)" style="border:none; padding:0;">
<img src="/images/csomagcsere-jo.jpg" style="width:47%;" style="border:none; padding:0;" />
</a>
</center>

A GLS csomagcseréhez kérjük, csomagold be a terméket szállításra készen. 
<br /><br />
A csomagot nem kell megcímezned, mert a futár teszi rá a GLS címkét.
<br /><br />
Mivel a cipősdoboz is a termék részét képezi, így a visszaküldésnél pl. egy újságpapírba becsomagolva add át a terméket a GLS futárnak. Így a GLS címke nem közvetlenül a dobozra kerül. Köszönjük, ha figyelsz erre és ezzel munkánkat segíted.
<br /><br />

</div>

</div>



<div class="textbox">

<div class="login_once">

<p>Termékcsere menete, díja</p>

<?
echo nl2br('1. - Küldj e-mail-t az <a href="mailto:'.$func->getMainParam('main_email').'?subject=Termekcsere">'.$func->getMainParam('main_email').'</a> címre, amiben az alábbi információkat szükséges megadnod:<ul>	<li>Név</li>
	<li>Szállítási cím</li>
	<li>Vásárlásodról kapott e-mail-ben található RENDELÉSI SZÁM</li>
	<li>Melyik terméket mire szeretnéd cserélni</li></ul>Példa e-mail:
<div class="arrow_box" style="text-align:left;">Kis Gábor
    
    1234 Budapest, Példa utca 1.
    
	Rendelési szám: '.date('Y').'/00000001
		
	Termékcsere:
		
	Vans Old Skool black/white 41-es méret (US 8,5) 
	CSERÉLTETNÉM
	Vans Old Skool black/white 42-es méretre (US 9)	
</div>2. - Munkatársunk visszajelez a regisztráción megadott elérhetőségeiden (e-mailen vagy telefonon)

3. - Csomagold be a terméket szállítható állapotúra (pl. újságpapírba).

4. - A kiválasztott új termék feladásra kerül. Kiszállítása a következő munkanapon várható.

5. - A GLS termékcsere díja 1500 Ft, mely tartalmazza a cseretermék és a visszaküldött termék szállítási díját is.


');
?>

</div>
</div>

<!-- <div class="textbox" style="border:1px solid red; width:100%;">

<>
<p style="width:92%;">Visszaküldés</p> 

<img src="/images/csomagcsere-hibas.jpg" style="width:40%;" />

<img src="/images/csomagcsere-jo.jpg" style="width:40%;" />

</div> -->


<!-- 
<div class="textbox" style="border:1px solid red; width:100%;">
<p style="">Csomag visszaküldés<p>
</div>
-->


<?
/*
echo '<div class="right-container">';

echo '<div class="content-right-headline">Termékcsere</div>';

echo nl2br('<div style="padding:0 140px;">


Kedves Vásárlónk!

Amennyiben nem vagy megelégedve a megvásárolt termékkel (nem jó a méret, nem tetszik a szín, nem egészen olyan élőben, mint a fotón volt, stb...), lehetőséged van azt visszacserélni.

<b class="alert">A csere menete:</b>

1. - Küldj e-mail-t az <a href="mailto:'.$func->getMainParam('main_email').'?subject=Termekcsere">'.$func->getMainParam('main_email').'</a> címre, amiben az alábbi információkat szükséges megadnod:
<ul>
	<li>Név</li>
	<li>Szállítási cím</li>
	<li>Vásárlásodról kapott e-mail-ben található RENDELÉSI SZÁM</li>
	<li>Melyik terméket mire szeretnéd cserélni</li>
</ul>
<b class="alert">Példa e-mail:</b>

	
	<div style="border:1px solid #0088e3; color:#eee; font-size:16px; padding:20px 40px; margin:20px 0 !important;">Kis Gábor
    
    1234 Budapest
    Példa u. 1.
    
		Rendelési szám: 2009/00000002
		
		Termékcsere:
		
		Vans AV Era Star Bandana/Black 41-es méret (US 8,5) cipőt cseréltetni szeretném:
		Vans AV Era Star Bandana/Black 42-es méretre (US 9)	
	</div>
	
<b>FONTOS</b>, hogy csak az oldalon található, azaz raktárkészleten lévő termékek közül válassz csereterméket! </b>


2. - Munkatársunk visszajelez a regisztráción megadott elérhetőségeiden (emailen vagy telefonon)


3. - A terméket <b>EREDETI ÁLLAPOTÁBAN, SZÁMLA MÁSOLATÁVAL EGYÜTT</b> küldd vissza az alábbi címre:
<b class="alert">
Coreshop Kft. 

1163 Budapest
Cziráki u. 26-32.

Földszint 24/A</b>


4. - A kiválasztott új termék feladásra kerül. <span>Az ismételt csomagküldés díja a <b>VÁSÁRLÓT</b> terheli.
</div>

</div>');
?>

</div>

<? */ ?>