<?
//use kop\y2sp\ScrollPager;
use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\ListView;
use app\widgets\Seo;
//use yii\helpers\ArrayHelper;


$this->title = 'Termékcsere - Coreshop.hu';

$h1 = 'Termékcsere';

$description = 'Tájékoztató a termékcsere menetéről.';
		
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

<div class="container-fluid shipping-container my-3">
    <div class="container">	
	<?= '<h1 id="title" class="row title mb-5" style="margin:0;padding:0 0 10px 0;">' . Html::encode($h1) . '</h1>'; ?>
        <div class="row justify-content-between py-5">
            <div class="nav flex-column nav-pills col-lg-5" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="shipping-button nav-link active" id="v-pills-replace-tab" data-toggle="pill" href="#v-pills-replace" role="tab" aria-controls="v-pills-replace" aria-selected="true">
                    Termékcsere lehetőségek
                    <img src="../images/chosen-right-white.png" class="pill-icon float-right mt-2">
                </a>
                <a class="shipping-button nav-link" id="v-gls-replace-tab" data-toggle="pill" href="#v-gls-replace" role="tab" aria-controls="v-gls-replace" aria-selected="false">
                    GLS Termékcsere
                    <img src="../images/chosen-right-white.png" class="pill-icon float-right mt-2">
                </a>
                <a class="shipping-button nav-link mb-5" id="v-pills-replace-price-tab" data-toggle="pill" href="#v-pills-replace-price" role="tab" aria-controls="v-pills-replace-price" aria-selected="false">
                    Termékcsere menete, díja
                    <img src="../images/chosen-right-white.png" class="pill-icon float-right mt-2">
                </a>
            </div>
            <div class="tab-content col-lg-7 static-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-replace" role="tabpanel" aria-labelledby="v-pills-replace-tab">
                    <div class="row title pb-5">Termékcsere lehetőségek</div>
                    <div class="row pb-4">Kedves Vásárlónk!</div>
                    <div class="row pb-4">A megrendelt termék átvételétől számított 8 napon belül, sértetlen állapotú termék esetén lehetőséged van a terméket cseréltetni.</div>
                    <div class="row pb-4">Amennyiben nem vagy megelégedve a termékkel (nem jó a méret, nem tetszik a szín, nem egészen olyan élőben, mint a fotón volt, stb…), akkor az alábbi lehetőségek közül választhatsz:</div>
                    <ul class="pb-4">
                        <li>Termékcsere más méretre</li>
                        <li>A rendelés végösszegének levásárlása</li>
                        <li>Pénzvisszautalás</li>
                    </ul>
                    <div class="row">
                        <p><span class="font-weight-bold">FONTOS,</span> hogy csak az oldalon található, azaz raktárkészleten lévő termékek közül válassz csereterméket.</p> 
                    </div>
                </div>
                <div class="tab-pane fade" id="v-gls-replace" role="tabpanel" aria-labelledby="v-gls-replace-tab">
                    <div class="row title pb-5">GLS termékcsere</div>
                    <div class="row pb-4">A GLS csomagcseréhez kérjük, csomagold be a terméket szállításra készen.</div>
                    <div class="row pb-4">A csomagot nem kell megcímezned, mert a futár teszi rá a GLS címkét.</div>
                    <div class="row pb-4">Mivel a cipősdoboz is a termék részét képezi, így a visszaküldésnél pl. egy újságpapírba becsomagolva add át a terméket a GLS futárnak. Így a GLS címke nem közvetlenül a dobozra kerül.</div>
                    <div class="row pb-5">
                        <div class="col-lg-6 col-12">
                            <img class="img-fluid" src="/images/csomagcsere-hibas.jpg" alt="Csomagcsere hibás">
                        </div>
                        <div class="col-lg-6 col-12">
                            <img class="img-fluid" src="/images/csomagcsere-jo.jpg" alt="Csomagcsere jó">
                        </div>
                    </div>
                    <div class="row">Köszönjük, ha figyelsz erre és ezzel munkánkat segíted.</div>
                </div>
                <div class="tab-pane fade" id="v-pills-replace-price" role="tabpanel" aria-labelledby="v-pills-replace-price-tab">
                    <div class="row title pb-5">Termékcsere menete, díja</div>
                    <div class="row pb-4">
                        <p>1. – Küldj e-mail-t az <a class="shipping-link" href="mailto:info@coreshop.hu">info@coreshop.hu</a> címre, amiben az alábbi információkat szükséges megadnod:</p> 
                    </div>
                    <ul class="pb-5">
                        <li>Név</li>
                        <li>Szállítási cím</li>
                        <li>Vásárlásodról kapott e-mail-ben található RENDELÉSI SZÁM</li>
                        <li>Melyik terméket mire szeretnéd cserélni</li>
                    </ul>
                    <div class="row border-bottom pb-4">Példa e-mail:</div>
                    <div class="row pt-3 pb-4">Kis Gábor</div>
                    <div class="row pb-4">1234 Budapest, Példa utca 1.</div>
                    <div class="row pb-4">Rendelési szám: 2016/00000001</div>
                    <div class="row pb-4">Termékcsere:</div>
                    <div class="row">Vans Old Skool black/white 41-es méret (US 8,5)</div>
                    <div class="row">CSERÉLTETNÉM</div>
                    <div class="row border-bottom pb-4">Vans Old Skool black/white 42-es méretre (US 9)</div>
                    <div class="row pt-3 pb-4">2. – Munkatársunk visszajelez a regisztráción megadott elérhetőségeiden (e-mailen vagy telefonon)</div>
                    <div class="row pb-4">3. – Csomagold be a terméket szállítható állapotúra (pl. újságpapírba).</div>
                    <div class="row pb-4">4. – A kiválasztott új termék feladásra kerül. Kiszállítása a következő munkanapon várható.</div>
                    <div class="row">5. – A GLS termékcsere díja 1500 Ft, mely tartalmazza a cseretermék és a visszaküldött termék szállítási díját is.</div>
                </div>
            </div>
        </div>
    </div>
</div>