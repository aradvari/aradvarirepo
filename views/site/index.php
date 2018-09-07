<?php
/* @var $this yii\web\View */

use app\models\TermekekSearch;
use yii\helpers\Url;

$this->title = 'Coreshop - Vans, éS Footwear, Etnies, Emerica, Volcom, Bones, Powell Peralta';
$description = 'Coreshop online gördeszkás ruházati webshop, a Vans, Etnies, éS Footwear, Emerica, Volcom, Bones, Powell Peralta, DC Shoes, magyarországi forgalmazója, gördeszka hardware-ek.';
$keywords = 'Coreshop, Vans, Vans off The Wall, DC Shoes, Etnies, éS Footwear, Emerica, Volcom, Bones, Powell Peralta, baseball sapka, kiegészítők, gördeszka hardware, skateboard';
$image = Url::to('/images/coreshop-logo-social.png', true);

//SEO DEFAULT
Yii::$app->seo->registerMetaTag(['name' => 'description', 'content' => $description]);
Yii::$app->seo->registerMetaTag(['name' => 'keywords', 'content' => $keywords]);
Yii::$app->seo->registerMetaTag(['itemprop' => 'name', 'content' => $this->title]);
Yii::$app->seo->registerMetaTag(['itemprop' => 'description', 'content' => $description]);
Yii::$app->seo->registerMetaTag(['itemprop' => 'image', 'content' => $image]);
//SEO OPEN GRAPH
Yii::$app->seo->registerMetaTag(['name' => 'og:title', 'content' => $this->title]);
Yii::$app->seo->registerMetaTag(['name' => 'og:type', 'content' => 'website']);
Yii::$app->seo->registerMetaTag(['name' => 'og:url', 'content' => Url::current([], true)]);
Yii::$app->seo->registerMetaTag(['name' => 'og:image', 'content' => $image]);
Yii::$app->seo->registerMetaTag(['name' => 'og:description', 'content' => $description]);
Yii::$app->seo->registerMetaTag(['name' => 'og:site_name', 'content' => 'Coreshop']);
Yii::$app->seo->registerMetaTag(['name' => 'article:section', 'content' => 'fashion']);
Yii::$app->seo->registerMetaTag(['name' => 'article:tag', 'content' => $keywords]);
Yii::$app->seo->registerMetaTag(['name' => 'fb:app_id', 'content' => '550827275293006']);

?>

<div class="mobile-container">
    <!-- Slider -->
    <div class="row d-none d-sm-block">
        <div id="coreshopCarousel" class="alice-blue-bg carousel slide" data-ride="carousel">
            
			<!-- //carousel-indicators
			<ol class="carousel-indicators">
                <li data-target="#coreshopCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#coreshopCarousel" data-slide-to="1"></li>
                <li data-target="#coreshopCarousel" data-slide-to="2"></li>
            </ol> 
			//endof carousel-indicators -->

            <!--Desktop slider -->
            <div class="carousel-inner">
                <div class="carousel-item active">                    
					<a href="/termekek?q=independent">
                    <img class="d-block w-100" src="images/banner-carousel/2018/20180904-vans-x-independent.jpg" alt="Vans x Independent">
					</a>
                    <!-- <div class="carousel-caption d-none d-md-block">
                        <h5>Ultra <span class="blue">range</span></h5>
                        <p>Kényelem és lazaság</p>
                    </div> -->
                </div>

            </div> <!-- //carousel-inner -->
			

            <!-- <a class="carousel-control-prev" href="#coreshopCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Előző</span>
            </a>
            <a class="carousel-control-next" href="#coreshopCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Következő</span>
            </a> -->

        </div> <!-- //coreshopCarousel carousel-->
    </div> <!-- //row -->
    <!-- //slider -->



   <!--Mobile slider -->
    <div class="row d-block d-sm-none">
        <div id="coreshopCarouselMobile" class="alice-blue-bg  carousel slide" data-ride="carousel">

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <a href="/termekek?q=independent"><img class="d-block w-100" src="images/banner-mobile/2018/20180904-vans-x-independent.jpg" alt="Vans x Independent"></a>
                    <div class="carousel-caption d-md-block">
                        <h5>Vans x Independent</h5>
                        <p>A Vans egyesíti erőit az Independent-tel, az egyik legkultikusabb gördeszka felfüggesztés gyártó céggel.
						<br />
						<br />Limitált kollekció, ne maradj le róla!</p>
                        <a href="/termekek?q=independent" class="btn btn-primary">Megnézem</a>
                    </div>
                </div>

				<!-- 2nd item carousel mobile
                <div class="carousel-item">
                    <img class="d-block w-100" src="images/slider/vans-ave_main-desk-chino-640x500.jpg" alt="First slide">
                    <div class="carousel-caption d-md-block">
                        <h5>Vans AV Rapidwelt PRO</h5>
                        <p>Mobilnézetben ez a slider ujjal is mozgatható, ugye? </p>
                        <a href="" class="btn btn-primary">Megnézem </a>
                    </div>
                </div>
				-->

                
            </div> <!-- //carousel-inner -->
            
			<div class="justify-content-center mt-3 d-flex">
                <ol class="carousel-indicators carousel-indicators-mobile">
                        <!-- <li data-target="#coreshopCarouselMobile" data-slide-to="0" class="active"></li> -->
                        <!-- <li data-target="#coreshopCarouselMobile" data-slide-to="1"></li> -->
                </ol> 
                <!-- //carousel-indicators -->
            </div>
			
            <!-- <a class="carousel-control-prev" href="#coreshopCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Előző</span>
            </a>
            <a class="carousel-control-next" href="#coreshopCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Következő</span>
            </a> -->

        </div> <!-- //coreshopCarousel carousel-->
    </div> <!-- //row -->

    <!-- //slider -->

    <!-- Brands -->
    <section class="container-fluid customer-logo-container">
        <div id="customerLogos" class="row alice-blue-bg">

                <a class="col-md col-3 align-self-center" href="vans">
                    <img class="img-fluid mx-auto brand-picker vans" src="images/markak/vans_logo.png" alt="Vans">
                </a>
                <a class="col-md col-3" href="etnies">
                    <img class="img-fluid mx-auto brand-picker" src="images/markak/etnies_logo.png" alt="Etnies">
                </a>
               
                <a class="col-md col-3" href="emerica">
                    <img class="img-fluid mx-auto brand-picker" src="images/markak/emerica_logo.png" alt="Emerica">
                </a>
                <a class="col-md col-3" href="es">
                    <img class="img-fluid mx-auto brand-picker" src="images/markak/es_logo.png" alt="és">
                </a>
              
                <a class="col-md col-3" href="neff">
                    <img class="img-fluid mx-auto brand-picker" src="images/markak/neff_logo.png" alt="Neff">
                </a>
                <a class="col-md col-3" href="powell-peralta">
                    <img class="img-fluid mx-auto brand-picker" src="images/markak/powell-peralta-logo.png" alt="Powell Peralta">
                </a>
                <a class="col-md col-3" href="volcom">
                    <img class="img-fluid mx-auto brand-picker" src="images/markak/volcom_logo.png" alt="Volcom">
                </a>
               <a class="col-md col-3" href="altamont">
                    <img class="img-fluid mx-auto brand-picker" src="images/markak/altamont_logo.png" alt="Altamont">
                </a>
               

        </div>
    </section>
    <!-- //brands -->

    
	
	
	<!-- 1 -->
	<section class="white-bg">
        <div class="row">			
			<div class="col-md col-12" style="padding:0;">
			<a href="/cipo/ferfi-cipo/vans/sk8-hi-pro-blackwhite-7132"><img src="../images/banner-box/2018/20180905-sk8-hi-pro.jpg" style="width:100%;" alt="Vans Sk8-hi Pro cipő" /></a>
            </div>	
            
            <div class="col-md col-12 align-self-center">
                <h2 class="text-center">Vans Sk8-Hi <span class="blue">Pro</span></h2>
                <p class="text-center">
				Az SK8-Hi Pro a klasszikus Vans SK8-Hi felturbózott változata. Jellemzői az UltraCush HD talpbetét ami extra kényelmet biztosít, továbbá a Duracap megerősítés a fokozottan igénybe vett részeken, amely a tartósságért felelős. A felsőrész hasított bőr és textil kombinációja.
				</p>
                <p class="text-center margin-top-50">
                    <a href="/cipo/ferfi-cipo/vans/sk8-hi-pro-blackwhite-7132" class="btn btn-primary">Megnézem</a>
                </p>
            </div>
        </div>
    </section>
	
	
	<!-- 2 -->
	<section>
        <div class="row blue-bg">
            <div class="col-md col-12 align-self-center order-1">
                <h2 class="text-center inverse">Vans Ultrarange</h2>
                <p class="text-center white">Kényelem és lazaság! Légáteresztő felsőrész, RapidWeld (hegesztett) technológiával készült illesztések. Ugorj bele és nem fogsz hinni a lábadnak!

                <p class="text-center margin-top-50">
                    <a href="/cipo?q=ultrarange" class="btn btn-transparent">Megnézem</a>
                </p>
            </div>
            <div class="col-md-5 order-md-2 col-12" style="padding:0;">
			<a href="/cipo?q=ultrarange"><img src="../images/banner-box/2018/20180905-vans-ultrarange.jpg" style="width:100%;" alt="Vans Ultrarange cipő" /></a>
            </div>
        </div>
    </section>
	
	<!-- 3 -->
    <section class="white-bg">
        <div class="row">
            <div class="col-md col-12" style="padding:0;">
			<a href="/powell-peralta"><img src="../images/banner-box/2018/20180905-powell-peralta-logo.jpg" style="width:100%;" alt="Powell Peralta" /></a>
            </div>
			
            <div class="col-md col-12 align-self-center">
                <h2 class="text-center">Powell <span class="blue">Peralta</span></h2>
                <p class="text-center">Pólóújdonságok Santa Barbara, Kaliforniából! Az egyik legkultikusabb gördeszka gyártótól pólók, komplett deszkák, gördeszka lapok és kerekek érkeztek kínálatunkba.
					</p>
                <p class="text-center margin-top-50">
                    <a href="/powell-peralta" class="btn btn-primary">Megnézem</a>
                </p>
            </div>
        </div>
    </section>
	
	
	
	
	
<div class="alice-blue-bg m--15">
    <div class="container">
            <div class="row justify-content-center">
                <h2 class="mt-5 my-5 text-center"> Legújabb <span class="blue">termékek</span> </h2>
            </div>
    </div>

<?php
// echo '<h2 class="mt-5 my-5 text-center"> Legújabb <span class="blue">termékek</span> </h2>';
$dataProvider = (new TermekekSearch())->search(['subCategory' => ['ferfi-cipo', 'noi-cipo']]);
$dataProvider->pagination = false;
$dataProvider->query->andWhere(['opcio' => 'UJ']);
$dataProvider->query->limit(12);
$dataProvider->query->orderBy('rand()');

if ($dataProvider->getCount() > 0)
    echo $this->render('/termekek/_index_ajanlo', ['dataProvider' => $dataProvider]);
?>
</div>

<div class="alice-blue-bg m--15">
    <div class="container" style="padding-bottom:50px;">
            <div class="row justify-content-center">
                <h2 class="mt-5 my-5 text-center">Rólunk</h2>
            </div>
    
	Köszönjük, hogy benéztél, ha már itt vagy akkor szeretnénk megosztani veled egy kis Coreshop történelmet.
	<br />
	<br />
	Ott kezdődött minden, ahol a nap nyugszik, a nyugati parton, Dél-Kaliforniában.  Ahol olyan termékeket készítenek, amelyeket szívesen hordunk, és bő szívvel ajánljuk mindenki másnak is. 
	<br />
	<br />
	Cégünk 2007. májusában kezdte meg működését, mely az első webshop volt a kategóriájában. Akkor még Zoneshop néven kínáltuk a gördeszkás cipőket, textileket és hardvereket, majd 2009. őszétől Coreshop néven folytattuk - utalva rá, hogy Magyarországon mi voltunk ebben a kategóriában a mag, de ennek a teljes története egészen a '90-es évekig nyúlik vissza. Megalakulásunk óta kényesen ügyelünk arra, hogy termékválasztékban és szolgáltatásban is kompromisszum-mentes minőséget kínáljunk. Szezononként újra és újra, a vásárlói igények alapján válogatjuk össze a legjobb márkák (Vans, etnies, éS, Emerica) legjobb termékeit.
	<br />
	<br />
	Az elmúlt közel tíz év alatt több ezer elégedett vásárló visszajelzése igazolja, hogy jó úton haladunk.
	</div>
</div>

</div>
