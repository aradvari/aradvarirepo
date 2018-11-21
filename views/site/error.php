<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use app\models\Kategoriak;
use app\models\TermekekSearch;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;
$this->title = "404";
$message = "A keresett oldal sajnos nem található, de használd bátran keresőnket vagy válassz márkáink közül!";
//$message2 = "Vagy nézd meg legkedveltebb márkádat kínálatunkban:";
?>
<div class="site-error container-fluid col-md-9">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <div class="alert alert-danger" style="text-align:center;margin-top:10px">
	
	<img src="../images/404-sad.png" alt="A keresett oldal nem található :(" style="max-width:100px;"; />
	<h1 style="background:none; margin:0;"><?= Html::encode($this->title) ?></h1>
        <?= nl2br(Html::encode($message)) ?>
	
	
	<form class="form-inline mt-2 mt-md-0" id="ajax_search_form" action="<?= Url::to(['/termekek/index']) ?>" method="get" autocomplete="off">     
			
            <div class="input-group search-input-group col-md-6" style="margin:30px auto;">
              <input class="form-control search-input" id="search-top" type="text"
                   placeholder="Írd be a keresett terméket..." name="q">
              <span class="input-group-btn">
                <input type="submit" class="btn btn-primary" value="Keresés">
              </span>
            </div>
        </form>
		
	</div>
	
	
	<p>			
	
	
	<!-- Brands -->
    <section class="container-fluid customer-logo-container">
        <div id="customerLogos" class="row c*ol-md-8" >
		
			

            <a class="col-md col-3 align-self-center" href="/vans">
                <img class="img-fluid mx-auto brand-picker vans" src="/images/markak/vans_logo.png" alt="Vans">
            </a>
            <a class="col-md col-3" href="/etnies">
                <img class="img-fluid mx-auto brand-picker" src="/images/markak/etnies_logo.png" alt="Etnies">
            </a>

            <a class="col-md col-3" href="/emerica">
                <img class="img-fluid mx-auto brand-picker" src="/images/markak/emerica_logo.png" alt="Emerica">
            </a>
            <a class="col-md col-3" href="/es">
                <img class="img-fluid mx-auto brand-picker" src="/images/markak/es_logo.png" alt="és">
            </a>

            <a class="col-md col-3" href="/dc">
                <img class="img-fluid mx-auto brand-picker" src="/images/markak/dc_logo.png" alt="Neff">
            </a>
            <a class="col-md col-3" href="/powell-peralta">
                <img class="img-fluid mx-auto brand-picker" src="/images/markak/powell-peralta-logo.png" alt="Powell Peralta">
            </a>
            <a class="col-md col-3" href="/volcom">
                <img class="img-fluid mx-auto brand-picker" src="/images/markak/volcom_logo.png" alt="Volcom">
            </a>
            <a class="col-md col-3" href="/altamont">
                <img class="img-fluid mx-auto brand-picker" src="/images/markak/altamont_logo.png" alt="Altamont">
            </a>


        </div>
    </section>
    <!-- //brands -->
	
    
	
	
	
	<? /*
    <p>
        ‹ <a href="/">Vissza a kezdőoldalra</a>
    </p>
	*/ ?>
	
	</p>

</div>
