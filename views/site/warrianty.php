<?
//use kop\y2sp\ScrollPager;
use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\ListView;
use app\widgets\Seo;
//use yii\helpers\ArrayHelper;


$this->title = 'Garancia - Coreshop.hu';

$h1 = 'Garancia';

$description = 'Tájékoztató a garanciális feltételekről. 15 napos pénzvisszatérítés garancia. További tájékoztató nyomtatható formában az Általános szerződési feltételekben.';
		
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

<div class="container-fluid shipping-container grey my-3">
    <div class="container">
	
	<?= '<h1 id="title" class="row title mb-5">' . Html::encode($h1) . '</h1>'; ?>
	
	    <div class="row justify-content-between py-5">		
            <div class="nav flex-column nav-pills col-lg-5" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="shipping-button nav-link active" id="v-pills-warranty-tab" data-toggle="pill" href="#v-pills-warranty" role="tab" aria-controls="v-pills-warranty" aria-selected="true">
                    Jótállás szavatosság
                    <img src="../images/chosen-right-white.png" class="pill-icon float-right mt-2">
                </a>
                <a class="shipping-button nav-link" id="v-guarantee-tab" data-toggle="pill" href="#v-guarantee" role="tab" aria-controls="v-guarantee" aria-selected="false">
                    Garancia
                    <img src="../images/chosen-right-white.png" class="pill-icon float-right mt-2">
                </a>
                <a class="shipping-button nav-link mb-5" id="v-pills-other-tab" data-toggle="pill" href="#v-pills-other" role="tab" aria-controls="v-pills-other" aria-selected="false">
                    Egyéb jogérvényesítési lehetőségek
                    <img src="../images/chosen-right-white.png" class="pill-icon float-right mt-2">
                </a>
            </div>
            <div class="tab-content col-lg-7 static-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-warranty" role="tabpanel" aria-labelledby="v-pills-warranty-tab">
                    <div class="row mb-4">
                        A jótállási idő a törvényben előírt 6 hónap. Ha a gyártó a fogyasztási cikkre az e rendeletben foglaltaknál kedvezőbb jótállási feltételeket vállal, a jótállás alapján a forgalmazót megillető jogok a fogyasztói szerződés teljesítésének időpontjában átszállnak a fogyasztóra. A jótállási jogokat a termék tulajdonosa érvényesítheti, feltéve, hogy fogyasztónak minősül. (Fogyasztó: a gazdasági, vagy szakmai tevékenység körén kívül eső célból szerződést kötő személy – Ptk. 685.§ d) pont). A jótállási idő a termék fogyasztó részére történő átadás napjával kezdődik.
                    </div>
                    <div class="row">
                        A jótállási igény a jótállási jegy, vagy a Coreshop Kft. által kiállított számla másolatának bemutatásával érvényesíthető. Amennyiben a termék mellett nincs külön jótállási jegy, akkor a számla egyben jótállási jegyként is szolgál. Garanciális kifogás esetén a termék az Eladóhoz történő visszajuttatásának költsége a Vevőt terheli.
                    </div>
                </div>
                <div class="tab-pane fade" id="v-guarantee" role="tabpanel" aria-labelledby="v-guarantee-tab">
                    <div class="row mb-4">
                        Garanciális kifogás esetén a terméket a következő címre kell személyesen beszállítani, vagy posta-, illetve futárszolgálattal elküldeni:
                    </div>
                    <div class="row mb-4">
                        Coreshop Kft.
                    </div>
                    <div class="row mb-4">
                        1163 Budapest,
                    </div>
                    <div class="row mb-4">
                        Cziráki utca 26-32.
                    </div>
                    <div class="row mb-5">
                        Földszint 24/A iroda
                    </div>

                    <div class="row font-weight-bold mt-5 mb-4">
                        Jótállási igény nem érvényesíthető:
                    </div>
                    <div class="row">a.) Nem rendeltetésszerű használat</div>
                    <div class="row">b.) Szakszerűtlen ápolás, tisztítás hiánya</div>
                    <div class="row">c.) Szakszerűtlen tisztítás</div>
                    <div class="row">d.) Felfedezett hiba (rejtett anyag, vagy gyártási) nem azonnali jelzése</div>
                    <div class="row">e.) Sérülés, vagy erőszakos külső behatás, rongálás</div>
                    <div class="row">f.) Házilagos javítás</div>
                </div>
                <div class="tab-pane fade" id="v-pills-other" role="tabpanel" aria-labelledby="v-pills-other-tab">
                    <div class="row mb-4">
                        Amennyiben Szolgáltató és Vásárló között esetlegesen fennálló fogyasztói jogvita Szolgáltatóval való tárgyalások során nem rendeződik, a fogyasztónak minősülő Vásárló, a lakóhelye vagy tartózkodási helye szerint illetékes békéltető testülethez fordulhat és kezdeményezheti a Testület eljárását, illetve fordulhat a Szolgáltató székhelye szerint illetékes Békéltet Testülethez is, továbbá a következő jogérvényesítési lehetőségek állnak nyitva Vásárló számára:
                    </div>
                    <div class="row">
                        – Panasztétel a fogyasztóvédelmi hatóságnál,
                    </div>
                    <div class="row mb-4">
                        – Békéltető testület eljárásának kezdeményezése
                    </div>
                    <div class="row mb-4">
                        Az eladó székhelye szerint illetékes Testület: Budapesti Békéltető Testület
                    </div>
                    <div class="row mb-4">Székhely: 1016 Budapest, Krisztina krt. 99.III. em. 310.</div>
                    <div class="row mb-4">Levelezési cím: 1253 Budapest, Pf.: 10.</div>
                    <div class="row mb-4">Telefon: 06 (1) 488 21 31</div>
                    <div class="row mb-4">Fax: 06 (1) 488 21 86</div>
                    <div class="row mb-4">
                        Békéltető Testületre vonatkozó szabályok alkalmazásában fogyasztónak minősül a külön törvény szerinti civil szervezet, egyház, társasház, lakásszövetkezet, mikro-, kis- és középvállalkozás is, aki árut vesz, rendel, kap, használ, igénybe vesz, vagy az áruval kapcsolatos kereskedelmi kommunikáció, ajánlat címzettje.
                    </div>
                    <div class="row">– Bírósági eljárás kezdeményezése.</div>
                </div>
            </div>
        </div>
    </div>
</div>