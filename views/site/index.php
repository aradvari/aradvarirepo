<?php
/* @var $this yii\web\View */

use app\models\TermekekSearch;
use yii\helpers\Url;

$this->title = 'gördeszkás webshop: Vans,éS Footwear,Etnies,Emerica';
$description = 'Coreshop online webshop, a Vans, DC Shoes, Supra, Osiris, DVS Shoes magyarországi forgalmazója, gördeszka hardware-ek.';
$keywords = 'Coreshop, Vans, Vans off The Wall, DC Shoes, Osiris, DVS Shoes, baseball sapka, kiegészítők, gördeszka hardware, skateboard';
$image = Url::to('/images/coreshop-logo-social.png', true);

//SEO DEFAULT
Yii::$app->seo->registerMetaTag(['name' => 'description', 'content' => $description]);
Yii::$app->seo->registerMetaTag(['name' => 'keywords', 'content' => $keywords]);
Yii::$app->seo->registerMetaTag(['itemprop' => 'name', 'content' => $this->title]);
Yii::$app->seo->registerMetaTag(['itemprop' => 'description', 'content' => $description]);
Yii::$app->seo->registerMetaTag(['itemprop' => 'image', 'content' => $image]);
//SEO OPEN GRAPH
Yii::$app->seo->registerMetaTag(['name' => 'og:title', 'content' => $this->title]);
Yii::$app->seo->registerMetaTag(['name' => 'og:type', 'content' => 'article']);
Yii::$app->seo->registerMetaTag(['name' => 'og:url', 'content' => Url::current([], true)]);
Yii::$app->seo->registerMetaTag(['name' => 'og:image', 'content' => $image]);
Yii::$app->seo->registerMetaTag(['name' => 'og:description', 'content' => $description]);
Yii::$app->seo->registerMetaTag(['name' => 'og:site_name', 'content' => 'Coreshop']);
Yii::$app->seo->registerMetaTag(['name' => 'article:section', 'content' => 'fashion']);
Yii::$app->seo->registerMetaTag(['name' => 'article:tag', 'content' => $keywords]);
Yii::$app->seo->registerMetaTag(['name' => 'fb:app_id', 'content' => '550827275293006']);

?>

<!-- Slider -->
<div class="row">
    <div id="coreshopCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#coreshopCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#coreshopCarousel" data-slide-to="1"></li>
            <li data-target="#coreshopCarousel" data-slide-to="2"></li>
        </ol> <!-- //carousel-indicators -->

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="images/slider/slide-01_1920_680.png" alt="First slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Ultra <span class="blue">range</span></h5>
                    <p>Kényelem és lazaság</p>
                </div>
            </div>
        </div> <!-- //carousel-inner -->

        <a class="carousel-control-prev" href="#coreshopCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Előző</span>
        </a>
        <a class="carousel-control-next" href="#coreshopCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Következő</span>
        </a>

    </div> <!-- //coreshopCarousel carousel-->
</div> <!-- //row -->
<!-- //slider -->

<!-- Brands -->
<section class="container-fluid customer-logo-container">
    <div id="customerLogos" class="carousel slide row alice-blue-bg" data-ride="carousel" data-interval="9000">
        <div class="carousel-inner row w-100 mx-auto" role="listbox">
            <div class="carousel-item col-md-3 active">
                <img class="img-fluid mx-auto d-block" src="images/logos/vans_logo.png" alt="Vans">
            </div>
            <div class="carousel-item col-md-3">
                <img class="img-fluid mx-auto d-block" src="images/logos/etnies_logo.png" alt="Etnies">
            </div>
            <div class="carousel-item col-md-3">
                <img class="img-fluid mx-auto d-block" src="images/logos/es_logo.png" alt="és">
            </div>
            <div class="carousel-item col-md-3">
                <img class="img-fluid mx-auto d-block" src="images/logos/emerica_logo.png" alt="Emerica">
            </div>
            <div class="carousel-item col-md-3">
                <img class="img-fluid mx-auto d-block" src="images/logos/neff_logo.png" alt="Neff">
            </div>
            <div class="carousel-item col-md-3">
                <img class="img-fluid mx-auto d-block" src="images/logos/bones_logo.png" alt="Bones">
            </div>
            <div class="carousel-item col-md-3">
                <img class="img-fluid mx-auto d-block" src="images/logos/powell_peralta_logo.png" alt="Powell Peralta">
            </div>
            <div class="carousel-item col-md-3">
                <img class="img-fluid mx-auto d-block" src="images/logos/volcom_logo.png" alt="Volcom">
            </div>
        </div>
        <a class="carousel-control-prev" href="#customerLogos" role="button" data-slide="prev">
            <i class="fa fa-chevron-left fa-lg text-muted"></i>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next text-faded" href="#customerLogos" role="button" data-slide="next">
            <i class="fa fa-chevron-right fa-lg text-muted"></i>
            <span class="sr-only">Next</span>
        </a>
    </div>
</section>
<!-- //brands -->

<section class="white-bg">
    <div class="row">
        <div class="col image-vans-x-peanuts">
        </div>
        <div class="col align-self-center">
            <h2 class="text-center">Vans x <span class="blue">peanuts</span></h2>
            <p class="text-center">Charlie Brown és barátai ismét megszállták a legnépszerűbb Vans cipőket.</p>
            <p class="text-center margin-top-50">
                <a href="" class="btn btn-primary">Megnézem</a>
            </p>
        </div>
    </div>
</section>

<section>
    <div class="row blue-bg">
        <div class="col align-self-center">
            <h2 class="text-center inverse">Vans girls</h2>
            <p class="text-center white">Vans ruházat azoknak a lányoknak, akik a dél-kaliforniai stílusból merítenének
                inspirációt. </p>
            <p class="text-center margin-top-50">
                <a href="" class="btn btn-transparent">Megnézem</a>
            </p>
        </div>
        <div class="col-7 image-vans-girls">
        </div>
    </div>
</section>

<section class="white-bg">
    <div class="row">
        <div class="col image-vans-old-skool">
        </div>
        <div class="col align-self-center">
            <h2 class="text-center">Vans old <span class="blue">skool</span></h2>
            <p class="text-center">A Vans kultikus Old Skool modelljéből több mint harminc verziót találsz
                kínálatunkban.</p>
            <p class="text-center margin-top-50">
                <a href="" class="btn btn-primary">Megnézem</a>
            </p>
        </div>
    </div>
</section>

<?php
$dataProvider = (new TermekekSearch())->search(['subCategory' => ['ferfi-cipo', 'noi-cipo']]);
$dataProvider->pagination = false;
$dataProvider->query->andWhere(['opcio' => 'UJ']);
$dataProvider->query->limit(15);
$dataProvider->query->orderBy('rand()');

if ($dataProvider->getCount() > 0)
    echo $this->render('/termekek/_index_ajanlo', ['dataProvider' => $dataProvider]);
?>
