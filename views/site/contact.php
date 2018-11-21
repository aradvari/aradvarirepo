<?
//use kop\y2sp\ScrollPager;
use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\ListView;
use app\widgets\Seo;
//use yii\helpers\ArrayHelper;


$this->title = 'Kapcsolat - Coreshop.hu';

$h1 = 'Elérhetőségünk';

$description = 'Webáruházunk és üzletünk elérhetőségei.';
		
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
            <div class="col-lg-3">
                <div class="row title pb-5"><?= '<h1 id="title" class="row title mb-5">' . Html::encode($h1) . '</h1>'; ?></div>
                <div class="row static-content">1163 Budapest, Cziráki utca 26-32.</div>
                <div class="row static-content">EMG Irodaház, földszint 24/A</div>
                <div class="row static-content pb-5">(A főbejárattól jobbra)</div>
                <div class="row static-content">+36 70 676 2673</div>
                <div class="row static-content pb-5">+36 70 631 1717</div>
                <div class="row static-content">
                    <a class="grey contact-link" href="mailto:info@coreshop.hu">info@coreshop.hu</a>
                </div>
                <div class="row static-content pb-5">
                    <a class="grey contact-link" href="mailto:garancia@coreshop.hu">garancia@coreshop.hu</a>
                </div>
                <div class="row title pb-5">Nyitvatartás</div>
                <div class="row static-content pb-5">Hétfőtől péntekig 10:00-17:00 óra között. (Egyéb időpontban előzetes telefonos egyeztetés alapján)</div>
                <div class="row title pb-5">Céginformációk</div>
                <div class="row static-content pb-5">Coreshop Kft.<br />1163 Budapest<br />Cziráki utca 26-32.</div>
                <div class="row static-content">Cégjegyzékszám: 01-09-928198</div>
                <div class="row static-content">Adószám: 14849705-2-42</div>
            </div>

            <!-- second column -->
            <div class="col-lg-7">
                <div class="row title pb-5">Megközelítés</div>
                <div class="row approach-title">Tömegközlekedéssel</div>
                <div class="row static-content pb-5">
                    Az Örs Vezér terétől a 44, 45, 176E, 276E busszal, leszállás az “Egyenes utca”-i megállónál. Gyalog kb. 100 méter az Egyenes utcán a Cziráki utca keresz-teződésig, majd a Cziráki utcán még 100 méter az EMG Irodaházig.
                </div>
                <div class="row approach-title">Autóval</div>
                <div class="row static-content pb-5">Veres Péter út (3-as út) / Egyenes utca kereszteződés › Egyenes utca / Cziráki utca kereszteződés › EMG Irodaház.</div>
                <div class="row static-content pb-3">Parkolási lehetőség az irodaház előtti utcai parkolóban. A parkolás ingyenes.</div>
                <div class="row pb-5">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2695.090019481052!2d19.158964515627122!3d47.507638079178285!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4741c4a57ae56a21%3A0xd911a75a9f7a94ea!2sBudapest%2C+Czir%C3%A1ki+u.+26+32%2C+1163!5e0!3m2!1shu!2shu!4v1525955196210" 
                        width="100%" height="450" frameborder="0" style="border:0" allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>