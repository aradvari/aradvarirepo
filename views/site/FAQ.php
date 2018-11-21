<?
//use kop\y2sp\ScrollPager;
use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\ListView;
use app\widgets\Seo;
//use yii\helpers\ArrayHelper;


$this->title = 'Kérdések és válaszok internetes kártyás fizetésről - Coreshop.hu';

$h1 = 'Kérdések és válaszok internetes kártyás fizetésről';

$description = 'CIB Bank tájékoztató. Kérdések és válaszok internetes kártyás fizetésről.';
		
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
	
        <div class="row justify-content-between pt-5">
            <!-- first column -->
            <div class="col-lg-5">
                <div class="row title pb-5"><?= '<h1 id="title" class="row title mb-5">' . Html::encode($h1) . '</h1>'; ?></div>
				
				<div class="row approach-title">KÁRTYAELFOGADÁS</div>
				<div class="row approach-title">MILYEN TÍPUSÚ KÁRTYÁKKAL LEHET FIZETNI?</div>
				
                <div class="row static-content">A VISA és az Mastercard dombornyomott kártyáival, ill. egyes VISA Electron kártyákkal. A VISA Electron kártyák interneten történő használatának lehetősége a kártyát kibocsátó banktól függ. A CIB által kibocsátott VISA Electron típusú bankkártya használható interneten történő vásárlásra.</div>
				
				
				<div class="row approach-title">MELY BANKOK KÁRTYÁI ALKALMASAK INTERNETES FIZETÉSRE?</div>
				
				<div class="row static-content">Minden olyan VISA és Mastercard (EC/MC) kártyával, mely internetes fizetésre a kártyakibocsátó bank által engedélyeztetve lettek, valamint a kifejezetten internetes használatra hivatott webkártyák.</div>
				
				
				<div class="row approach-title">LEHET-E VÁSÁRLÓKÁRTYÁKKAL FIZETNI?</div>
				
				<div class="row static-content">Hűségpontokat tartalmazó, kereskedők/szolgáltatók által kibocsátott pontgyűjtő kártyákkal nem lehet interneten fizetni.
</div>
				
				
				<div class="row approach-title">LEHET-E CO-BRANDED KÁRTYÁKKAL FIZETNI?</div>				
				
				<div class="row static-content">Bármilyen olyan co-branded kártyával lehetséges fizetni, mely internetes fizetésre alkalmas MasterCard vagy VISA alapú kártya.
</div>
				
				
				<div class="row approach-title">FIZETÉS FOLYAMATA</div>				
				<div class="row approach-title">HOGYAN MŰKÖDIK AZ ONLINE FIZETÉS BANKI HÁTTÉRFOLYAMATA?</div>				
				
				<div class="row static-content">A vásárló a kereskedő/szolgáltató internetes oldalán a bankkártyás fizetési mód választását követően a fizetést kezdeményezi, melynek eredményeként átkerül a Bank biztonságos kommunikációs csatornával ellátott fizetőoldalára. A fizetéshez szükséges megadni kártyaszámát, lejárati idejét, és a kártya hátoldalának aláíráscsíkján található 3 jegyű érvényesítési kódot. A tranzakciót Ön indítja el, ettől kezdve a kártya valós idejű engedélyezésen megy keresztül, melynek keretében a kártyaadatok eredetisége-, fedezet-, vásárlási limit kerül ellenőrzésre. Amennyiben a tranzakció folytatásához minden adat megfelel, a fizetendő összeget számlavezető (kártyakibocsátó) bankja zárolja a kártyáján. Az összeg számlán történő terhelése (levonása) számlavezető banktól függően néhány napon belül következik be.</div>
				
				
				<div class="row approach-title">MIBEN KÜLÖNBÖZIK AZ INTERNETES KÁRTYÁS VÁSÁRLÁS A HAGYOMÁNYOSTÓL?</div>
				
				<div class="row static-content">Megkülönböztetünk kártya jelenlétével történő (Card Present) és kártya jelenléte nélküli (Card not Present) tranzakciókat. A Card Present tranzakció POS terminál eszköz segítségével történik. A kártya lehúzását és a PIN kód beütését követően a terminál kapcsolatba lép a kártyabirtokos bankjával, az engedélyező központon keresztül, és a kártya típusától, illetve a kártya kibocsátójától függően a VISA vagy MasterCard hálózaton keresztül. Itt megtörténik az érvényesség és fedezetvizsgálat (authorizáció). Az előbbi útvonalon visszafelé haladva a POS terminál (illetve a kereskedő) megkapja a jóváhagyást vagy elutasítást. A vásárló aláírja a bizonylatot. A Card not Present olyan tranzakció, melynek lebonyolításakor a bankkártya fizikailag nincs jelen. Ide tartoznak a levélben, telefonon, illetve az elektronikus úton (internet) lebonyolított tranzakciók, amelyek esetében a vásárló (kártyabirtokos) a tranzakciót biztonságos (128 bites titkosítású) fizetőoldalon bekért kártyaadatok megadásával indítja. A sikeres tranzakcióról Ön kap ún. engedélyszámot, mely megegyezik a papír alapú bizonylaton található számmal.</div>
				
				
				<div class="row approach-title">MIT JELENT A FOGLALÁS?</div>
				
				<div class="row static-content">A tranzakciót a bank tudomására jutásakor azonnal foglalás (zárolás) követi, hiszen a tényleges terheléshez előbb a hivatalos adatoknak be kell érkezniük, mely néhány napot igénybe vesz és az alatt a vásárolt összeg újra elkölthető lenne. Ezért a foglalással a levásárolt vagy felvett pénzt elkülönítik, foglalás alá teszik. A foglalt összeg hozzátartozik a számlaegyenleghez, azaz jár rá kamat, de még egyszer nem költhető el. A foglalás biztosítja azon tranzakciók visszautasítását, melyre már nincs fedezet, noha a számlaegyenleg erre elvben még lehetőséget nyújtana. </div>
				
				
				
			              
              
            </div>
			
			
			  <div class="col-lg-5">
			  
				<div class="row approach-title">SIKERTELEN FIZETÉSEK ÉS TEENDŐK</div>
				<div class="row approach-title">MILYEN ESETBEN LEHET SIKERTELEN EGY TRANZAKCIÓ?</div>
				
				<div class="row static-content">Általában a kártyát kibocsátó bank (tehát ahol az ügyfél a kártyát kapta) által el nem fogadott fizetési megbízás; de bankkártya használat esetében ez lehet olyan okból is, hogy távközlési vagy informatikai hiba miatt az engedélykérés nem jut el a kártyát kibocsátó bankhoz.
</div>
				
				
				<div class="row approach-title">KÁRTYA JELLEGŰ HIBA</div>
				
				<div class="row static-content">
				<?=nl2br('• A kártya nem alkalmas internetes fizetésre. 
• A kártya internetes használata számlavezető bank által tiltott. 
• A kártyahasználat tiltott. 
• A kártyaadatok (kártyaszám, lejárat, aláíráscsíkon szereplő kód) hibásan lettek megadva. 
• A kártya lejárt.');?>
</div>
				
				
				<div class="row approach-title">SZÁMLA JELLEGŰ HIBA</div>
				
				<div class="row static-content">
				<?=nl2br('• Nincs fedezet a tranzakció végrehajtásához. 
• A tranzakció összege meghaladja a kártya vásárlási limitét.');?>
</div>
				
				
				<div class="row approach-title">KAPCSOLATI JELLEGŰ HIBA</div>
				
				<div class="row static-content">• A tranzakció során valószínűleg megszakadt a vonal. Kérjük, próbálja meg újra. 
• A tranzakció időtúllépés miatt sikertelen volt. Kérjük, próbálja meg újra.
</div>
				
				
				
				<div class="row approach-title">TECHNIKAI JELLEGŰ HIBA</div>
				
				<div class="row static-content">• Amennyiben a fizetőoldalról nem tért vissza a kereskedő/szolgáltató oldalára, a tranzakció sikertelen. 
• Amennyiben a fizetőoldalról visszatért, de a böngésző "back", "reload" illetve "refresh" segítségével visszatér a fizetőoldalra, tranzakcióját a rendszer biztonsági okokból automatikusan visszautasítja.</div>
				
				
				<div class="row approach-title">MI A TEENDŐ A FIZETÉSI PROCEDÚRA SIKERTELENSÉGE ESETÉN?</div>
				
				<div class="row static-content">A tranzakcióról minden esetben generálódik egy tranzakcióazonosító, melyet javaslunk feljegyezni. Amennyiben a fizetési kísérlet során tranzakció banki oldalról visszautasításra kerül, kérjük vegye fel a kapcsolatot számlavezető bankjával.
</div>
				
				
				<div class="row approach-title">MIÉRT A SZÁMLAVEZETŐ BANKKAL KELL FELVENNI A KAPCSOLATOT A FIZETÉS SIKERTELENSÉGE ESETÉN?</div>
				
				<div class="row static-content">A kártyaellenőrzés során a számlavezető (kártyakibocsátó) bank értesíti az összeget beszedő kereskedő (elfogadó) bankjának, hogy a tranzakció elvégezhető-e. Más bank ügyfelének az elfogadó bank nem adhat ki bizalmas információkat, arra csak a kártyabirtokost azonosító banknak van joga. </div>
				
				
				<div class="row approach-title">MIT JELENT AZ, HA BANKOMTÓL AZONBAN SMS KAPTAM AZ ÖSSZEG FOGLALÁSÁRÓL/ZÁROLÁSÁRÓL, AZONBAN A KERESKEDŐ/SZOLGÁLTATÓ AZT JELZI, HOGY SIKERTELEN VOLT A FIZETÉS?</div>
				
				<div class="row static-content">Ez a jelenség olyan esetben fordulhat elő, ha a kártya ellenőrzése megtörtént a fizetőoldalon, azonban Ön nem tért vissza kereskedő/szolgáltató internetes oldalára. A tranzakció ebben az esetben befejezetlennek, így automatikusan sikertelennek minősül. Ilyen esetben az összeg nem kerül terhelésre kártyáján, a foglalás feloldásra kerül.</div>
				
				
				
				
				<div class="row approach-title">BIZTONSÁG</div>
				<div class="row approach-title">MIT JELENT A VERISIGN ÉS A 128 BITES TITKOSÍTÁSÚ SSL KOMMUNIKÁCIÓS CSATORNA?</div>
				
                <div class="row static-content">Az SSL, a Secure Sockets Layer elfogadott titkosítási eljárás rövidítése. Bankunk rendelkezik egy 128 bites titkosító kulccsal, amely a kommunikációs csatornát védi. A VeriSign nevű cég teszi lehetővé a CIB Bank-nak a 128 bites kulcs használatát, amely segítségével biztosítjuk az SSL alapú titkosítást. Jelenleg a világ elektronikus kereskedelmének 90%-ában ezt a titkosítási módot alkalmazzák. A vásárló által használt böngésző program az SSL segítségével a kártyabirtokos adatait az elküldés előtt titkosítja, így azok kódolt formában jutnak el a CIB Bankhoz, ezáltal illetéktelen személyek számára nem értelmezhetőek.</div>
				
				
				
				<div class="row approach-title">A FIZETÉS UTÁN FIGYELMEZTETETT A BÖNGÉSZŐM, HOGY ELHAGYOM A BIZTONSÁGI ZÓNÁT. A FIZETÉSEM BIZTONSÁGA ÍGY GARANTÁLT?</div>
				
				
				<div class="row static-content">Teljes mértékben igen. A fizetés folyamata 128-bites titkosított kommunikációs csatornán folyik, így teljesen biztonságos. A tranzakciót követően Ön a kereskedő honlapjára jut vissza, amennyiben a kereskedő oldala nem titkosított, a böngészője figyelmezteti, hogy a titkosított csatornát elhagyta. Ez nem jelent veszélyt a fizetés biztonságát illetően.</div>
				
				<div class="row approach-title">MIT JELENT A CVC2/CVV2 KÓD?</div>
				
				
				<div class="row static-content">A MasterCard esetében az ún Card Verification Code, a Visa esetében az ún. Card Verification Value egy olyan, a bankkártya mágnescsíkján kódolt numerikus érték, melynek segítségével megállapítható egy kártya valódisága. Az ún. CVC2 kódot, mely az Mastercard kártyák hátoldalán található számsor utolsó három számjegyében szerepel, az internetes vásárlások során kell megadni.</div>
				
				<div class="row approach-title">MIT JELENT A VERIFIED BY VISA?</div>
				
				
				
				<div class="row static-content">A Verified by Visa rendszerben regisztrált Visa kártyabirtokosok jelszót választanak a kártyát kibocsátó banknál, mely segítségével azonosíthatják magukat internetes vásárlás esetén, és amely védelmet nyújt a Visa kártyák jogosulatlan használata ellen. A CIB Bank elfogadja a Verified by Visa rendszer keretein belül kibocsátott kártyákat.
</div>
				
				<div class="row approach-title">MIT JELENT A UCAF KÓD?</div>
				
				
				
				
				<div class="row static-content">MasterCard kártyák esetén az Ön kártyakibocsátó bankjától esetlegesen kapott egyedi kód. Ha nem kapott ilyet, hagyja üresen a mezőt.</div>		
				
				
              
            </div>
			
        </div>
		
    </div>
	
	
</div>