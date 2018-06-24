<div class="content-right-headline">Szállítás</div>

<div class="textbox">

<?=nl2br('<p>Szállítás GLS csomagküldő szolgálattal</p>
A kiszállítást Magyarországon a GLS Hungary Kft. végzi. A küldemény csomagszámát a csomagfeladás munkanapján, 17:00 órakor elküldi az Eladó a Vevő regisztrációjánál megadott e-mail címére. Ennek alapján követheti nyomon a küldemény hollétét A GLS Csomagküldő weboldalán:

<a href="http://online.gls-hungary.com/search_stat.php?Lang=0" target="_blank">http://connect.gls-hungary.com/</a>
vagy
<a href="https://gls-group.eu/HU/hu/csomagkovetes" target="_blank">https://gls-group.eu/HU/hu/csomagkovetes</a>

A Vevőnek kell gondoskodnia arról, hogy olyan szállítási címet adjon meg, ahol biztosított a küldemény munkaidőben (munkanapokon 8-16 óra között) történő átvétele. 

Az átvételre Vevő, illetve a Vevő által megadott szállítási címen tartózkodó egyéb személy jogosult. 

A kiszállítás várható napjáról és időpontjáról Vevő Szállítmányozóval utóbbi ügyfélszolgálati telefonszámán tud egyeztetni (+36) 1 802-0265, kérjük hivatkozzon az e-mailben kapott csomagszámra.


</div><div class="textbox"><p>Szállítás belföldre</p>
Csomagküldő szolgálattal történő szállítás esetén a házhozszállítás díja alapesetben <b>'.number_format($func->getMainParam('szallitasi_dij'), 0, '', ' ').' Ft</b> az ország egész területére, amennyiben a vásárlás végösszege nem érte el az Ingyenes szállítás értékhatárát.

A belföldi ingyenes szállítás értékhatára: <b>'.number_format($func->getMainParam('ingyenes_szallitas'), 0, '', ' ').' Ft</b>.
<img src="/images/cxs-logo.png" style="width:60%; margin:20px 0; opacity:0.8; padding:0 20%;" />
Ha rendelésed most adod le, a várható kiszállítás ideje: 

<font style="color:#2a87e4;">'.$func->dateToHU($func->GLSDeliveryDate('HU')).'</font> / 8:00 - 16:00 óra között.

Partnerünk a GLS csomagküldő szolgálat <img src="/images/gls-small.png" alt="GLS Csomagküldő szolgálat" style="margin:0 10px 0px 0;" />


</div>
</div>
');