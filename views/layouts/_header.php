<?php

use app\models\Kategoriak;
use app\models\TermekekSearch;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div align="center">
    <div class="header-topline">
        <div class="header-topline-container">
            <a href="tel:+36706762673" class="header-topline-tel">Telefonos rendelés: +36 70 676 2673</a>
            <span><a href="<?= Url::to(['site/content', 'page' => 'shop']) ?>">Üzletünk</a></span>
            <span><a href="<?= Url::to(['site/content', 'page' => 'contract']) ?>">ÁSZF</a></span>
            <span><a href="<?= Url::to(['site/content', 'page' => 'shipping']) ?>">Szállítás</a></span>
            <span><a href="<?= Url::to(['site/content', 'page' => 'warrianty']) ?>">Garancia</a></span>
            <span><a href="<?= Url::to(['site/content', 'page' => 'replace']) ?>">Termékcsere</a></span>
            <span><a href="<?= Url::to(['site/content', 'page' => 'contact']) ?>">Kapcsolat</a></span>

            <?php
            if (Yii::$app->user->isGuest):
                ?>
                <span><a href="<?= Url::to(['/site/login']) ?>" class="header-instafeed">Belépés</a></span>
            <?php
            endif;
            ?>

            <?php
            if (!Yii::$app->user->isGuest):
                ?>
                <span><a href="<?= Url::to(['/user/index']) ?>" class="header-instafeed">Fiókom</a></span>
                <span><a href="<?= Url::to(['/site/logout']) ?>" class="header-instafeed">Kilépés</a></span>
            <?php
            endif;
            ?>

            <a href="http://facebook.com/coreshop" target="_blank" id="facebook"><img src="/images/social_fb-1.svg"
                                                                                      alt="Coreshop @facebook.com"></a>
            <a href="http://instagram.com/coreshop.hu" target="_blank" id="instagram"><img
                        src="/images/social_insta.svg" alt="Coreshop @instagram.com"></a>
            <a href="https://plus.google.com/103506333733297319481" target="_blank" id="googleplus"><img
                        src="/images/social_g-1.svg" alt="Coreshop @plus.google.com"></a>
        </div>
    </div>

    <div class="navbar-search-container">
    <div class="collapse" id="toggleSearch">
        <form class="form-inline mt-2 mt-md-0" id="ajax_search_form" action="<?= Url::to(['/termekek/index']) ?>"
              method="get" autocomplete="off">

            <!-- search results -->
            <!--
            <input class="form-control search-input" id="search-top" type="text" placeholder="Írd be a keresett terméket..." name="q">
            <div id="search-result-container">
            </div>-->
            <div class="input-group search-input-group">
              <input class="form-control search-input" id="search-top" type="text"
                   placeholder="Írd be a keresett terméket..." name="q">
              <span class="input-group-btn">
                <input type="submit" class="btn btn-primary" value="Keresés">
              </span>
            </div>
        </form>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-toggleable-lg">
        <!-- <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button> -->
        
        <button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" 
                aria-label="Toggle navigation">
            <span> </span>
            <span> </span>
            <span> </span>
        </button>
		
        <a class="navbar-brand" href="/">
			<img src="/images/coreshop_logo_w_icon.svg" alt="Coreshop.hu" class="logo" />
		</a>
		
        <a class="hidden-md-up nav-link cart-icon-container cart-link" href="#" data-href="<?= Url::to(['cart/view']) ?>">
            <div class="cart-icon-mobile"></div>
            <span class="cart-count"></span>
         </a>

        

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item hidden-md-up ml-3 mr-2 pb-2">
                    <form class="form-inline hidden-md-up" id="ajax_search_form" action="<?= Url::to(['/termekek/index']) ?>" method="get" autocomplete="off">

                        <!-- search results -->
                        <!--
                        <input class="form-control search-input" id="search-top" type="text" placeholder="Írd be a keresett terméket..." name="q">
                        <div id="search-result-container">
                        </div>-->
                        <div class="input-group search-input-group">
                          <input class="form-control search-input" id="search-top" type="text"
                               placeholder="Írd be a keresett terméket..." name="q">
                          <span class="input-group-btn">
                            <input type="submit" class="btn btn-primary btn-send" value="Keres">
                          </span>
                        </div>
                    </form>
                </li>


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="<?= Url::to(['termekek/index', 'mainCategory' => 'ferfi-ruhazat']) ?>" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">férfi ruha</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item hidden-md-up" href="<?= Url::to(['termekek/index', 'mainCategory' => 'ferfi-ruhazat']) ?>">Összes</a>
                       <?php
                        $models = (new TermekekSearch())->searchSubCategory(['mainCategory' => 'ferfi-ruhazat'])->getModels();
                        foreach ($models as $item) {

                            echo Html::a($item['megnevezes'],
                                [
                                    'termekek/index',
                                    'mainCategory' => $item['pk_url_segment'],
                                    'subCategory' => $item['url_segment'],
                                ],
                                ['class' => 'dropdown-item']);
                        }
                        ?>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="<?= Url::to(['termekek/index', 'mainCategory' => 'noi-ruhazat']) ?>"  id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">női ruha</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown02">
                         <a class="dropdown-item hidden-md-up" href="<?= Url::to(['termekek/index', 'mainCategory' => 'noi-ruhazat']) ?>">Összes</a>
                        <?php
                        $models = (new TermekekSearch())->searchSubCategory(['mainCategory' => 'noi-ruhazat'])->getModels();
                        foreach ($models as $item) {
                            echo Html::a($item['megnevezes'],
                                [
                                    'termekek/index',
                                    'mainCategory' => $item['pk_url_segment'],
                                    'subCategory' => $item['url_segment'],
                                ],
                                ['class' => 'dropdown-item']);
                        }
                        ?>
                    </div>
                </li>

<!--                <li class="nav-item">-->
<!--                    <a class="nav-link"-->
<!--                       href="--><?//= Url::to(['termekek/index', 'mainCategory' => 'cipo', 'subCategory' => 'ferfi-cipo']) ?><!--">férfi-->
<!--                        cipő</a>-->
<!--                </li>-->
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link"-->
<!--                       href="--><?//= Url::to(['termekek/index', 'mainCategory' => 'cipo', 'subCategory' => 'noi-cipo']) ?><!--">női-->
<!--                        cipő</a>-->
<!--                </li>-->

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="<?= Url::to(['termekek/index', 'mainCategory' => 'cipo']) ?>" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">cipő</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown03">
                        <a class="dropdown-item hidden-md-up" href="<?= Url::to(['termekek/index', 'mainCategory' => 'cipo']) ?>">Összes</a>
                        <?php
                        $models = (new TermekekSearch())->searchSubCategory(['mainCategory' => 'cipo'])->getModels();
                        foreach ($models as $item) {
                            echo Html::a($item['megnevezes'],
                                [
                                    'termekek/index',
                                    'mainCategory' => $item['pk_url_segment'],
                                    'subCategory' => $item['url_segment'],
                                ],
                                ['class' => 'dropdown-item']);
                        }
                        ?>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="<?= Url::to(['termekek/index', 'mainCategory' => 'kiegeszito']) ?>" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">kiegészítő</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item hidden-md-up" href="<?= Url::to(['termekek/index', 'mainCategory' => 'kiegeszito']) ?>">Összes</a>
                        <?php
                        $models = (new TermekekSearch())->searchSubCategory(['mainCategory' => 'kiegeszito'])->getModels();
                        foreach ($models as $item) {
                            echo Html::a($item['megnevezes'],
                                [
                                    'termekek/index',
                                    'mainCategory' => $item['pk_url_segment'],
                                    'subCategory' => $item['url_segment'],
                                ],
                                ['class' => 'dropdown-item']);
                        }
                        ?>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="<?= Url::to(['termekek/index', 'mainCategory' => 'gordeszka']) ?>"  id="dropdown05" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">gördeszka</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown05">
                         <a class="dropdown-item hidden-md-up" href="<?= Url::to(['termekek/index', 'mainCategory' => 'gordeszka']) ?>">Összes</a>
                        <?php
                        $models = (new TermekekSearch())->searchSubCategory(['mainCategory' => 'gordeszka'])->getModels();
                        foreach ($models as $item) {
                            echo Html::a($item['megnevezes'],
                                [
                                    'termekek/index',
                                    'mainCategory' => $item['pk_url_segment'],
                                    'subCategory' => $item['url_segment'],
                                ],
                                ['class' => 'dropdown-item']);
                        }
                        ?>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" <?/*text-danger */?>
                       href="<?= Url::to(['termekek/index', 'mainCategory' => 'outlet']) ?>" id="dropdown06" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sale %</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown06">
                         <a class="dropdown-item hidden-md-up" href="<?= Url::to(['termekek/index', 'mainCategory' => 'outlet']) ?>">Összes</a>
                        <?php
                        $models = (new TermekekSearch())->searchSubCategory(['mainCategory' => 'outlet'])->getModels();
                        foreach ($models as $item) {
                            echo Html::a($item['megnevezes'],
                                [
                                    'termekek/index',
                                    'mainCategory' => $item['pk_url_segment'],
                                    'subCategory' => $item['url_segment'],
                                ],
                                ['class' => 'dropdown-item']);
                        }
                        ?>
                    </div>
                </li>

                 <li class="nav-item dropdown hidden-md-down">
                    <a class=" cart-icon dropdown-toggle nav-link cart-link" data-hover="dropdown" href="#" data-href="<?= Url::to(['cart/view']) ?>">
                            <span class="cart-count"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right cart-dropdown" aria-labelledby="navbarDropdownMenuLink">
                        <div class="cart-container-top"></div>
                    </div>
                </li>
                <div class="hidden-md-up secondary-mobile-navigation">
                    <li class="nav-item">
                        <a class="mobile-nav-icon our-shop-mobile" href="<?= Url::to(['site/content', 'page' => 'shop']) ?>">Üzletünk</a>
                    </li>
                    <li class="nav-item">
                         <a class="mobile-nav-icon rule-mobile" href="<?= Url::to(['site/content', 'page' => 'contract']) ?>">ÁSZF</a>
                    </li>
                     <li class="nav-item">
                        <a class="mobile-nav-icon transport-mobile" href="<?= Url::to(['site/content', 'page' => 'shipping']) ?>">Szállítás</a>
                    </li>
                    <li class="nav-item">
                        <a class="mobile-nav-icon guarantee-mobile" href="<?= Url::to(['site/content', 'page' => 'warrianty']) ?>">Garancia</a>
                    </li>
                    <li class="nav-item">
                        <a class="mobile-nav-icon productchange-mobile" href="<?= Url::to(['site/content', 'page' => 'replace']) ?>">Termékcsere</a>
                    </li>
                    <li class="nav-item">
                       <a class="mobile-nav-icon our-shop-mobile" href="<?= Url::to(['site/content', 'page' => 'contact']) ?>">Kapcsolat</a>
                    </li>

                        <?php
                        if (Yii::$app->user->isGuest):
                            ?>
                            <li class="nav-item">
                                <a class="mobile-nav-icon user-mobile" href="<?= Url::to(['/site/login']) ?>" class="header-instafeed">Belépés</a>
                            </li>
                        <?php
                        endif;
                        ?>

                        <?php
                        if (!Yii::$app->user->isGuest):
                            ?>
                            <li class="nav-item">
                                <a href="<?= Url::to(['/user/index']) ?>" class="header-instafeed">Fiókom</a>
                                <a href="<?= Url::to(['/site/logout']) ?>" class="header-instafeed">Kilépés</a>
                            </li>
                        <?php
                        endif;
                        ?>
                </ul>
                <a class="search-icon hidden-md-down" data-toggle="collapse" href="#toggleSearch" role="button" aria-expanded="false"
                   aria-controls="collapseExample">
                </a>
   
            </div>
        </div>
    </nav>
</div> <!-- //navbar-search-container -->
</div>