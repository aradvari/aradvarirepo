<?
//use kop\y2sp\ScrollPager;
use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\ListView;
use app\widgets\Seo;
//use yii\helpers\ArrayHelper;
use app\models\GlobalisAdatok;


$this->title = 'Üzletünk - Coreshop.hu';

$h1 = 'Üzletünk';

$description = 'Coreshop üzlet, 1163 Budapest, Cziráki utca 26-32. Üzletünkben lehetőséged van termékeink személyes átvételére. Minden termékünk raktárkészleten van, felpróbálható, megvásárolható. Üzletünkben fizethetsz készpénzzel és bankkártyával is. Nyitvatartási idő: Hétköznap 9-17 óra között.';
		
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
    
	<? 
	if (GlobalisAdatok::getParam('uzletinfo'))
 
	echo '<div class="alert alert-danger">
	Kedves Vásárlónk!
	<br />
	<br />
	'.GlobalisAdatok::getParam('uzletinfo').'
	</div>';
	?>
	
        <div class="row justify-content-between pt-5">
            <!-- first column -->
            <div class="col-lg-7">
			
			<?= '<h1 id="title" class="row title mb-5">' . Html::encode($h1) . '</h1>'; ?>

                <div class="row mb-5">
                    <figure>
                        <img src="/images/shop.png" alt="shop" class="img-fluid">
                    </figure>
                </div>

                <div class="row title mb-5">
                    Kedves vásárlónk!
                </div>

                <div class="row mb-5 static-content">
                    Ha termékeinket személyesen szeretnéd megtekinteni, felpróbálni, megvásárolni vagy online megrendelésednél a személyes átvételt választottad, akkor keresd fel bemutatótermünket.
                </div>
                <div class="row mb-5 static-content">
                    Üzletünkben a webshopon megtalálható teljes készletből tudsz válogatni, próbálni és vásárolni.
                </div>

                <div class="row important-container mb-5 px-3 py-4">
                    <div class="col-lg-12 important-title mb-5">
                        Fontos!
                    </div>
                    <div class="col-lg-12 text-white" style="font-size: 18px; line-height: 24px">
                        Személyes vásárlás esetén, mielőtt bemutatótermünkbe látogatnál, nézd meg hogy a kiválasztott termék kapható-e méretedben.
                    </div>
                </div>
                
                <div class="row title mb-5">
                    Fizetési módok üzletünkben
                </div>
                <div class="row mb-5 static-content">
                    Készpénzzel vagy bankkártyával.
                </div>
                <div class="row static-content">
                    Elfogadott bankkártyatípusok (CIB Bank terminál):
                </div>
                <div class="row mb-5 static-content">
                    MasterCard, MasterCard Electronic, Maestro, Visa, Visa Electron
                </div>
                
            </div>
            <!-- second column -->
            <div class="col-lg-4">
                <div class="contact">
                    <div class="row title mb-5">Elérhetőségünk</div>
                    <div class="row">1163 Budapest, Cziráki utca 26-32.</div>
                    <div class="row mb-5">EMG Irodaház, földszint 24/A</div>
                    <div class="row">+36 70 676 2673</div>
                    <div class="row mb-5">+36 70 631 1717</div>
                </div>

                <div class="opening-hours mb-5">
                    <div class="row secondary-title">
                        Nyitvatartás
                    </div>
                    <div>
                        <div class="row">
                            Hétfőtől péntekig 10:00-17:00 óra között.
                        </div> 
                        <div class="row">
                            (Egyéb időpontban előzetes telefonos egyeztetés alapján)
                        </div>
                    </div>
                </div>

                <div class="approach">
                    <div class="row secondary-title">
                        megközelítés
                    </div>
                    <div class="row approach-title">
                        Tömegközlekedéssel
                    </div>
                    <div class="row mb-5">
                        Az Örs Vezér terétől a 44, 45, 176E, 276E busszal, leszállás az “Egyenes utca”-i megállónál. Gyalog kb. 100 méter az Egyenes utcán a Cziráki utca kereszteződésig, majd a Cziráki utcán még 100 méter az EMG Irodaházig.
                    </div>

                    <div class="row approach-title">
                        Autóval
                    </div>
                    <div class="row mb-5">
                        Veres Péter út (3-as út) / Egyenes utca keresz-teződés ›
                        Egyenes utca / Cziráki utca kereszteződés › EMG Irodaház.
                    </div>
                    <div class="row pb-4">
                        Parkolási lehetőség az irodaház előtti utcai parkolóban. A parkolás ingyenes.
                    </div>

                    <div class="row pb-5">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2695.090019481051!2d19.158964514504518!3d47.50763807917817!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4741c4a57ae56a21%3A0xd911a75a9f7a94ea!2sBudapest%2C+Czir%C3%A1ki+u.+26+32%2C+1163!5e0!3m2!1shu!2shu!4v1525940214946" 
                        width="100%" height="410" frameborder="0" style="border:0" allowfullscreen>
                        </iframe>
                    </div>

                    
                </div>
            </div>
        </div>

    </div>
</div>