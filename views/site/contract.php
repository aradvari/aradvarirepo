<?
//use kop\y2sp\ScrollPager;
use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\ListView;
use app\widgets\Seo;
//use yii\helpers\ArrayHelper;


$this->title = 'Általános szerződési feltételek - Coreshop.hu';

$h1 = 'Általános szerződési feltételek';

$description = 'Tájékoztató az általános szerződési feltételekről. Tájékoztatónk elérhető nyomtatható PDF formátumban is.';
		
$keywords = $this->title;

$image = Url::to('/images/coreshop-logo-social.png', true);

//SEO DEFAULT
Yii::$app->seo->registerMetaTag(['name' => 'description', 'content' => $description]);
Yii::$app->seo->registerMetaTag(['name' => 'keywords', 'content' => $keywords]);
Yii::$app->seo->registerMetaTag(['itemprop' => 'name', 'content' => $this->title]);
Yii::$app->seo->registerMetaTag(['itemprop' => 'description', 'content' => $description]);
Yii::$app->seo->registerMetaTag(['itemprop' => 'image', 'content' => $image]);
//SEO OPEN GRAPH
Yii::$app->seo->registerMetaTag(['property' => 'og:title', 'content' => $this->title]);
Yii::$app->seo->registerMetaTag(['property' => 'og:type', 'content' => 'product']);
Yii::$app->seo->registerMetaTag(['property' => 'og:url', 'content' => Url::current([], true)]);
Yii::$app->seo->registerMetaTag(['property' => 'og:image', 'content' => $image]);
Yii::$app->seo->registerMetaTag(['property' => 'og:description', 'content' => $description]);
Yii::$app->seo->registerMetaTag(['property' => 'og:site_name', 'content' => 'Coreshop.hu']);
Yii::$app->seo->registerMetaTag(['property' => 'fb:app_id', 'content' => '550827275293006']);

?>

<div class="container-fluid shop-container grey my-3">
    <div class="container">
        <div class="row justify-content-between pt-5 pb-5">
            <div class="col-lg-9 title"><?= '<h1 id="title" class="row title mb-5">' . Html::encode($h1) . '</h1>'; ?></div>
            <div class="col-lg-3 text-right">
                <a class="contract-download-link" href="https://coreshop.hu/coreshop_aszf.pdf">⇓ Letöltés (PDF)</a>
            </div>
        </div>

        <div class="container-fluid">
            <div class="contract-link-container row pb-4">
                <div class="col-lg-4 col-12">
                    <a class="contract-link mr-5" href="#1">1. Bevezetés</a>
                </div>
                <div class="col-lg-4 col-12">
                    <a class="contract-link mr-5" href="#2">2. A Webáruház használata</a> 
                </div> 
                <div class="col-lg-4 col-12">
                    <a class="contract-link mr-5" href="#3">3. Fizetés, Szállítás</a> 
                </div>
                <div class="col-lg-4 col-12">
                    <a class="contract-link mr-5" href="#4">4. Szállítási díj</a>
                </div>
                <div class="col-lg-4 col-12">
                    <a class="contract-link mr-5" href="#5">5. Elállás joga</a>
                </div>
                <div class="col-lg-4 col-12">
                    <a class="contract-link mr-5" href="#6a">6/A Jótállás, Szavatosság, Garancia</a> 
                </div>
                <div class="col-lg-4 col-12">
                    <a class="contract-link mr-5" href="#6b">6/B Egyéb jogérvényesítési lehetőségek</a>
                </div>
                <div class="col-lg-4 col-12">
                    <a class="contract-link mr-5" href="#7">7. Visszaküldés menete</a> 
                </div>
                <div class="col-lg-4 col-12">
                    <a class="contract-link mr-5" href="#8">8. Tulajdonjog fenntartása</a>
                </div>
                <div class="col-lg-4 col-12">
                    <a class="contract-link mr-5" href="#9">9. Adatvédelem</a> 
                </div>
                <div class="col-lg-4 col-12">
                    <a class="contract-link" href="#10">10. Hírlevél feliratkozás, lemondás</a>
                </div>
            </div>
            
            <div class="row justify-content-between">
                <!-- first column -->
                <div class="col-lg-5">
                    <h4 id="1" class="text-center pb-4">1. Bevezetés</h4>
                    <div class="row">
                    <p>
                        Az alábbi részletezett Általános Szerződési Feltételek (továbbiakban ÁSZF) egymással kölcsönös szerződésben álló felekre (továbbiakban: Felek) vonatkozik. Egyrészről a Coreshop Kft.-re, mint eladóra (továbbiakban: Eladó), másrészről a Coreshop Kft.-től árut, vagy szolgáltatást vásárlóra (továbbiakban: Vevő), amennyiben Vevő az 1959. évi IV. törvény (Polgári Törvénykönyv, továbbiakban: PTK) 685. § d) értelmében fogyasztónak minősül.
                    </p>
                    </div>
                    <div class="row">Eladó adatai:</div>
                    <div class="row">Cégnév: Coreshop Kft.</div>
                    <div class="row pb-4">Cég székhelye: 1163 Budapest, Cziráki utca 26-32.</div>
                    <div class="row">Telefon: +36 70 676 2673, +36 70 631 1717</div>
                    <div class="row">E-mail: info@coreshop.hu</div>
                    <div class="row">Cégjegyzékszám: 01-09-928198</div>
                    <div class="row pb-4">Adószám: 14849705-2-42</div>
                    <div class="row pb-4">
                        A Felek közötti szerződés és az ÁSZF nyelve: Magyar. A jelen ÁSZF 2009.11.11-től érvényesek Eladó és Vevő közötti gazdasági kapcsolat tekintetében (a Honlapon történő rendelésre és vásárlásra), azok nem alkalmazhatóak a korábban megkötött szerződésekre és visszavonásig érvényesek. Ettől eltérő feltételeket csak Vevő és Eladó közös akaratával írásban lehet kikötni. Vevő a Honlapon történő vásárlással és rendeléssel az itt elolvasott feltételeket feltétel nélkül elfogadja. Vevő tudomásul veszi, hogy a végrehajtott megrendelés következményeként a megrendelt termékre közötte és az Eladó között adás-vételi ill. szállítási szerződés jön létre.
                    </div>
                    <div class="row pb-5">
                        Coreshop.hu webáruházunk cookie-kat (sütiket) használ a felhasználói élmény fokozása és az egyszerűbb oldalkezelés érdekében. Az oldalra belépéskor erről felugó üzenet tájékoztatás látható.
                    </div>

                    <h4 id="2" class="text-center pb-4">2. A webáruház használata, kosárhasználat, rendelés leadása</h4>
                    <div class="row">- A Webáruház használata</div>
                    <div class="row">A Coreshop webáruház, katalógusrendszer segítségével jeleníti meg a vásárolható termékeket. A katalógusrendszer logikusan, több szintre bontva segíti a tájékozódást.</div>
                    <div class="row pb-4">
                        A katalógusban megtekinthetők felsorolásszerű terméklisták, az ebben szereplő termékek nevére, vagy képére kattintva pedig a konkrét termék részletes adatlapja (termékloldal) annak lényeges tulajdonságaival. A mindenkori vételár, vagyis az áruért a fogyasztói forgalomban fizetendő bruttó ár az információs oldalon az áru mellett van feltüntetve, amely magában foglalja az általános forgalmi adót.
                    </div>
                    <div class="row">- Kosár használata:</div>
                    <div class="row">A rendszer virtuális kosárral segíti a vásárlást. A kosár használatához nem szükséges regisztráció.</div>
                    <div class="row">A termékoldalon a méretválasztás, majd mennyiség megadása után a "Hozzáadás a kosárhoz" gombbal adható a termék a kosárhoz.</div>
                    <div class="row">A kosárba csak a valós raktárkészlet erejéig helyezhető a termék.</div>
                    <div class="row pb-4">A kosár tartalma összesítve állandóan megtekinthető az oldal fejlécében.</div>
                    <div class="row pb-4">- Termék eltávolítása a kosárból:</div>
                    <div class="row">A fejlécben található kosár összesítőben a "Megrendelés" hivatkozást megnyitva található a kosár részletes tartalma.</div>
                    <div class="row">Az egyes termékkek sorainak jobb oldalán a piros X-el távolítható el 1 DARABONKÉNT az adott termék.</div>
                    <div class="row pb-4">Ha pl. 5 db azonos terméket tett korábban kosarába, akkor annak eltávolításhoz 5x szükséges megnyomni a piros X, törlés gombot.</div>
                    <div class="row pb-4">- Rendelés leadása</div>
                    <div class="row">A rendelés leadásához két mód választható:</div>
                    <div class="row pb-4">
                        A termékoldalon kosárhoz adás után közvetlenül, a felugró ablakban található "Megrendelés" hivatkozást megnyitva, vagy a Honlap fejlécében található kosárösszesítőnél található "Megrendelés" hivatkozásra rákattintva.
                    </div>
                    <div class="row pb-4">A Megrendelés oldalon bejelentkezés szükséges a rendelés leadásához.</div>
                    <div class="row pb-4">- Belépés már létező Coreshop felhasználói azonosítóval</div>
                    <div class="row">A korábbi regisztrációnál megadott felhasználói fiók adataival jelentkezhet be Webáruházunkba.</div>
                    <div class="row pb-4">A kék sáv E-mail cím és Jelszó mezőit megadva választható a "Bejelentkezés" gomb.</div>
                    <div class="row pb-4">- Új regisztráció létrehozása</div>
                    <div class="row pb-4">
                        Ha nincs érvényes Coreshop regisztrációja, akkor a "Regisztrálj most a Coreshop-ra" hivatkozás megnyitásával léphet a regisztrációs űrlapra. Az űrlap érvényes kitöltése után bejelentkezett állapotban nyílik meg a Megrendelés oldal.
                    </div>
                    <div class="row pb-4">- Szállítási cím, számlázási cím</div>
                    <div class="row">A csomag címzése a felhasználó fiók létrehozásakor megadott szállítási címre történik.</div>
                    <div class="row pb-4">Ez bármikor módosítható, a Megrendelés oldalon található szállítási cím adatokra, vagy a jobb felső sarok Szerkesztés hivatkozásra kattitva.</div>
                    <div class="row">A megrendelést igazoló számla alapesetben a szállítási cím adatok alapján kerül kiállításra.</div>
                    <div class="row pb-4">Eltérő számlázási adatok esetén a Számlázási adatok mezők kitöltése szükséges.</div>
                    <div class="row">- Megjegyzés mező:</div>
                    <div class="row">A rendeléssel kapcsolatos megjegyzésekhez használja a Megjegyzés mezőt (pl: Kérem délután kézbesítsék a csomagot.)</div>
                    <div class="row pb-5">
                        A kiszállítással kapcsolatos megjegyzéseket továbbítjuk a GLS Csomagküldő Szolgálatnak tájékoztatásul, akik lehetőségeikhez képest igyekszenek kiszállításkor a Vevő tájékoztatását figyelembe venni, azonban ez garanciát nem jelent a pontos kézbesítési időpontot illetően.
                    </div>

                    <h4 id="3" class="text-center pb-4">3. Fizetés, Szállítás, Szállítás díja</h4>
                    <div class="row pb-5">Vevő a következő fizetési módok közül választhat:</div>
                    <ul class="pb-5">
                        <li class="pb-4">Utánvét - Fizetés a GLS Csomagküldő Szolgálat futárnál készpénzben.</li>
                        <li class="pb-4">Bankkártyás fizetés - Fizetés a CIB Bank internetes bankkártyaelfogadó felületén.</li>
                        <li class="pb-4">Személyes átvétel irodánkban - Fizetés irodánkban személyesen készpénzben.</li>
                    </ul>
                    <div class="row">A vételár teljes kiegyenlítéséig az áru Eladó tulajdonában marad. Amennyiben Vevő a fizetési határidőig nem egyenlíti ki a vételárat, úgy Eladó jogosult elállni a szerződéstől.</div>
                    <div class="row pb-4">
                        <p>
                        A kiszállítást Magyarországon a GLS Hungary Kft. végzi. A küldemény csomagszámát a csomagfeladás munkanapján, 17:00 órakor elküldi az Eladó a Vevő regisztrációjánál megadott e-mail címére. Ennek alapján követheti nyomon a küldemény hollétét A GLS Csomagküldő weboldalán <span>(<a class="shipping-link" href="http://connect.gls-hungary.com/index.php">http://connect.gls-hungary.com/</a>)</span>. A Vevőnek kell gondoskodnia arról, hogy olyan szállítási címet adjon meg, ahol biztosított a küldemény munkaidőben (munkanapokon 8-17 óra között) történő átvétele. Az átvételre Vevő, illetve a Vevő által megadott szállítási címen tartózkodó egyéb személy jogosult. A kiszállítás várható napjáról és időpontjáról Vevő Szállítmányozóval utóbbi ügyfélszolgálati telefonszámán tud egyeztetni (+36) 1 802-0265. A küldemény sértetlenségéért a felelősség a küldemény kézbesítésétől kezdve átszáll Vevőre, ezért Vevő kötelessége kézbesítéskor a küldeményt megvizsgálni és amennyiben azon külsérelmi nyomokat talál, választása szerint:
                        </p>
                    </div>
                    <div class="row pb-4">a) megtagadni az átvételt,</div>
                    <div class="row pb-4">b) jegyzőkönyvet felvetetni a sérülésről a kézbesítő futárral, annak egy példányát megtartani. Vevő bármilyen sérülést köteles Eladónak haladéktalanul írásban, vagy telefonon jelenteni.</div>

                    <h4 id="4" class="text-center pb-4">4. Szállítási díj</h4>
                    <div class="row pb-4">
                        <p>
                            Csomagküldő szolgálattal történő szállítás esetén a házhozszállítás díja alapesetben <span class="font-weight-bold">990 Ft</span>  az ország egész területére, amennyiben a vásárlás végösszege nem érte el az Ingyenes szállítás értékhatárát.
                        </p>
                    </div>
                    <div class="row">
                        <p>A belföldi ingyenes szállítás értékhatára: <span class="blue">20.000 Ft</span>.</p>
                    </div>
                </div>

                <!-- second column -->
                <div class="col-lg-5">
                    <h4 id="5" class="text-center pb-4">5. Elállás joga</h4>
                    <div class="row pb-4">
                        A 17/1999. Kormányrendelet szerinti távértékesítési rendszer keretében fogyasztó részére történő értékesítésre Vevőt elállási jog illeti meg az alábbiak szerint: Vevő a szerződéstől az áru átvételétől számított 8 munkanapon belül indoklás nélkül elállhat. Írásban történő elállás esetén azt határidőben érvényesítettnek kell tekinteni, ha Vevő nyilatkozatát a határidő lejárta előtt elküldi. A terméket Vevő köteles haladéktalanul és hiánytalanul Eladónak visszajuttatni, a visszaszállítás költsége Vevőt terheli. A haladéktalan és hiánytalan visszajuttatás kapcsán vevő vállalja, hogy legkésőbb az elállási nyilatkozat megtételét követő munkanapon a terméket Eladónak visszajuttatja, vagy mindent megtesz a termék visszajuttatása érdekében, így például a terméket küldeményként feladja. A vevőnek felróható késedelem esetében a Ptk. általános kártérítési felelősségre vonatkozó szabályai szerint kell eljárni. Eladó köteles a Vevő által megfizetett összeget az elállástól számítva 30 napon belül banki átutalással visszatéríteni Vevőnek. Eladó a visszatérítendő összegből jogosult a termék nem rendeltetésszerű használatából eredő károk és a nem megfelelő kezelésből adódó értékcsökkenés megtérítésére megfelelő összeget kártérítésként visszatartani.
                    </div>

                    <h4 id="6a" class="text-center pb-4">6 / A Jótállás, Szavatosság, Garancia</h4>
                    <div class="row">
                        A jótállási idő a törvényben előírt 6 hónap. Ha a gyártó a fogyasztási cikkre az e rendeletben foglaltaknál kedvezőbb jótállási feltételeket vállal, a jótállás alapján a forgalmazót megillető jogok a fogyasztói szerződés teljesítésének időpontjában átszállnak a fogyasztóra. A jótállási jogokat a termék tulajdonosa érvényesítheti, feltéve, hogy fogyasztónak minősül. (Fogyasztó: a gazdasági, vagy szakmai tevékenység körén kívül eső célból szerződést kötő személy - Ptk. 685.§ d) pont). A jótállási idő a termék fogyasztó részére történő átadás napjával kezdődik.
                    </div>
                    <div class="row pb-4">
                        A jótállási igény a jótállási jegy, vagy a Coreshop Kft. által kiállított számla másolatának bemutatásával érvényesíthető. Amennyiben a termék mellett nincs külön jótállási jegy, akkor a számla egyben jótállási jegyként is szolgál. Garanciális kifogás esetén a termék az Eladóhoz történő visszajuttatásának költsége a Vevőt terheli.
                    </div>
                    <div class="row pb-4">Garanciális kifogás esetén a terméket a következő címre kell személyesen beszállítani, vagy posta-, illetve futárszolgálattal elküldeni:</div>
                    <div class="row font-weight-bold pb-4">Coreshop Kft.</div>
                    <div class="row font-weight-bold pb-4">1163 Budapest, </div>
                    <div class="row font-weight-bold pb-4">Cziráki utca 26-32.</div>
                    <div class="row font-weight-bold pb-5">Földszint 24/A iroda</div>
                    <div class="row pb-4">Jótállási igény nem érvényesíthető:</div>
                    <div class="row">a.) Nem rendeltetésszerű használat</div>
                    <div class="row">b.) Szakszerűtlen ápolás, tisztítás hiánya</div>
                    <div class="row">c.) Szakszerűtlen tisztítás</div>
                    <div class="row">d.) Felfedezett hiba (rejtett anyag, vagy gyártási) nem azonnali jelzése</div>
                    <div class="row">e.) Sérülés, vagy erőszakos külső behatás, rongálás</div>
                    <div class="row pb-5">f.) Házilagos javítás</div>

                    <h4 id="6b" class="text-center pb-4">6 / B Egyéb jogérvényesítési lehetőségek</h4>
                    <div class="row pb-4">
                        Amennyiben Szolgáltató és Vásárló között esetlegesen fennálló fogyasztói jogvita Szolgáltatóval való tárgyalások során nem rendeződik, a fogyasztónak minősülő Vásárló, a lakóhelye vagy tartózkodási helye szerint illetékes békéltető testülethez fordulhat és kezdeményezheti a Testület eljárását, illetve fordulhat a Szolgáltató székhelye szerint illetékes Békéltet Testülethez is, továbbá a következő jogérvényesítési lehetőségek állnak nyitva Vásárló számára:
                    </div>
                    <div class="row">– Panasztétel a fogyasztóvédelmi hatóságnál,</div>
                    <div class="row pb-4">– Békéltető testület eljárásának kezdeményezése</div>
                    <div class="row pb-4">Az eladó székhelye szerint illetékes Testület: Budapesti Békéltető Testület</div>
                    <div class="row pb-4">Székhely: 1016 Budapest, Krisztina krt. 99.III. em. 310.</div>
                    <div class="row pb-4">Levelezési cím: 1253 Budapest, Pf.: 10.</div>
                    <div class="row pb-4">Telefon: 06 (1) 488 21 31</div>
                    <div class="row pb-4">Fax: 06 (1) 488 21 86</div>
                    <div class="row pb-4">
                        Békéltető Testületre vonatkozó szabályok alkalmazásában fogyasztónak minősül a külön törvény szerinti civil szervezet, egyház, társasház, lakásszövetkezet, mikro-, kis- és középvállalkozás is, aki árut vesz, rendel, kap, használ, igénybe vesz, vagy az áruval kapcsolatos kereskedelmi kommunikáció, ajánlat címzettje.
                    </div>
                    <div class="row pb-4">– Bírósági eljárás kezdeményezése.</div>

                    <h4 id="7" class="text-center pb-4">7. Visszaküldés menete</h4>
                    <div class="row">
                        Amennyiben Vevő a terméket Eladónak visszaküldi (elállás, 15 munkanapos pénz-visszafizetés és garanciális visszaküldés esetén), az alábbiak szerint kell eljárnia: A fogyasztási cikk szállításra alkalmas csomagolásáról Vevő köteles gondoskodni, a nem megfelelő csomagolásból eredő, a szállítás során bekövetkező károkért az Eladó felelősséget nem vállal. A termék szállítási költsége elállás, 8 munkanapos pénz-visszafizetési garancia, jótállás, illetve kiterjesztett jótállás esetén a Vevőt terheli. Minden esetben mellékelni kell a számla másolatát, vagy a jótállási jegyet.
                    </div>
                    <div class="row pb-4 font-weight-bold">Utánvéttel terhelt küldeményt az Eladó nem vesz át.</div>
                    <div class="row pb-4">15 munkanapos pénz-visszafizetés és garanciális visszaküldés esetén a terméket erre a címre kell eljuttatni:</div>
                    <div class="row font-weight-bold pb-4">Coreshop Kft.</div>
                    <div class="row font-weight-bold pb-4">1163 Budapest, </div>
                    <div class="row font-weight-bold pb-4">Cziráki utca 26-32.</div>
                    <div class="row font-weight-bold pb-5">Földszint 24/A iroda</div>

                    <h4 id="8" class="text-center pb-4">8. Tulajdonjog fenntartása</h4>
                    <div class="row pb-4">
                        A termék Eladó tulajdonában marad mindaddig, amíg Vevő az összes (fő és mellékes) fizetési kötelezettségének nem tesz teljes mértékben eleget. Ez idő alatt Vevő nem engedheti át a terméket harmadik félnek és nem veszélyeztetheti más módon Eladó tulajdonát.
                    </div>

                    <h4 id="9" class="text-center pb-4">9. Adatvédelem</h4>
                    <div class="row pb-4">
                        Bizonyos információk, adatok elengedhetetlenek a rendelés felvételéhez, a vásárlás teljesítéséhez, a számlakiállításhoz, a garanciához, jótállási szerződéshez. Nélkülük a rendelés visszavonható és érvénytelennek minősül. A honlap használatával a Vevő teljes körű felelősséget vállal azért, hogy a megadott adatok hitelesek és a valóságnak megfelelnek. A Vevő által megadott adatokhoz állandó hozzáférhetőségi és helyreigazítási joga van, az aktuális európai és nemzeti törvénynek megfelelően. Eladó nem adja át harmadik fél részére a személyes adatokat, kivételt képez, amikor a harmadik fél Eladó szerződéses alvállalkozója, (pl. futárszolgálat) és a Vevővel kötött vásárlási szerződés teljesítéséhez elengedhetetlen, továbbá amennyiben ezt törvény vagy a hatóság kötelezővé teszi.
                    </div>

                    <h4 id="10" class="text-center pb-4">10. Hírlevél</h4>
                    <div class="row pb-4">
                        Eladó promóciós e-maileket (Hírlevél) küld, amennyiben a Vevő regisztrációjánál elfogadta a "Feliratkozom a Coreshop hírlevelére" opciót. A regisztrált e-mail címre kizárólag Eladónak áll jogában akciós anyagokat, reklámokat küldeni. Vevő adatai megadásával hozzájárul a tájékoztatás, reklámok, ajánlatok fogadásához. Vevő a hírlevél szolgáltatást a későbbiekben lemondhatja, a Coreshop hírlevél alján található "Leiratkozás" hivatkozás megnyitásával.
                    </div>
                    <div class="row pb-5">
                        <a class="contract-link" href="https://coreshop.hu/coreshop_aszf.pdf">⇓ Az ÁSZF letölthető itt nyomtatható PDF formátumban</a>
                    </div>


                </div>

            </div>

        </div>
    </div>
</div>