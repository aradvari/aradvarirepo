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

    <div class="collapse" id="toggleSearch">
        <form class="form-inline mt-2 mt-md-0" id="ajax_search_form" action="<?= Url::to(['/termekek/index']) ?>"
              method="get" autocomplete="off">
            <input class="form-control search-input" id="search-top" type="text"
                   placeholder="Írd be a keresett terméket..." name="q">
            <!-- search results -->
            <div id="search-result-container">
            </div>
        </form>
    </div>

    <nav class="navbar navbar-expand-md navbar-light btco-hover-menu">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="/"><img src="/images/coreshop_logo_w_icon.svg" alt="Coreshop.hu" class="logo"></a>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ml-auto">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-hover="dropdown" aria-haspopup="true" aria-expanded="false"
                       href="<?= Url::to(['termekek/index', 'mainCategory' => 'ferfi-ruhazat']) ?>">férfi ruha</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php
                        $models = (new TermekekSearch())->searchSubCategory(['mainCategory' => 'ferfi-ruhazat'])->getModels();
                        foreach ($models as $item) {
                            echo Html::beginTag('li');
                            echo Html::a($item['megnevezes'],
                                [
                                    'termekek/index',
                                    'mainCategory' => $item['pk_url_segment'],
                                    'subCategory' => $item['url_segment'],
                                ],
                                ['class' => 'dropdown-item']);
                            echo Html::endTag('li');
                        }
                        ?>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="<?= Url::to(['termekek/index', 'mainCategory' => 'noi-ruhazat']) ?>">női ruha</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <?php
                        $models = (new TermekekSearch())->searchSubCategory(['mainCategory' => 'noi-ruhazat'])->getModels();
                        foreach ($models as $item) {
                            echo Html::beginTag('li');
                            echo Html::a($item['megnevezes'],
                                [
                                    'termekek/index',
                                    'mainCategory' => $item['pk_url_segment'],
                                    'subCategory' => $item['url_segment'],
                                ],
                                ['class' => 'dropdown-item']);
                            echo Html::endTag('li');
                        }
                        ?>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link"
                       href="<?= Url::to(['termekek/index', 'mainCategory' => 'cipo', 'subCategory' => 'ferfi-cipo']) ?>">férfi
                        cipő</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="<?= Url::to(['termekek/index', 'mainCategory' => 'cipo', 'subCategory' => 'noi-cipo']) ?>">női
                        cipő</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="<?= Url::to(['termekek/index', 'mainCategory' => 'kiegeszito']) ?>">kiegészítő</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <?php
                        $models = (new TermekekSearch())->searchSubCategory(['mainCategory' => 'kiegeszito'])->getModels();
                        foreach ($models as $item) {
                            echo Html::beginTag('li');
                            echo Html::a($item['megnevezes'],
                                [
                                    'termekek/index',
                                    'mainCategory' => $item['pk_url_segment'],
                                    'subCategory' => $item['url_segment'],
                                ],
                                ['class' => 'dropdown-item']);
                            echo Html::endTag('li');
                        }
                        ?>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="<?= Url::to(['termekek/index', 'mainCategory' => 'gordeszka']) ?>">gördeszka</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <?php
                        $models = (new TermekekSearch())->searchSubCategory(['mainCategory' => 'gordeszka'])->getModels();
                        foreach ($models as $item) {
                            echo Html::beginTag('li');
                            echo Html::a($item['megnevezes'],
                                [
                                    'termekek/index',
                                    'mainCategory' => $item['pk_url_segment'],
                                    'subCategory' => $item['url_segment'],
                                ],
                                ['class' => 'dropdown-item']);
                            echo Html::endTag('li');
                        }
                        ?>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= Url::to(['termekek/index', 'mainCategory' => 'outlet']) ?>"
                       style="color:red;">SALE %</a>
                </li>

                <li class="nav-item dropdown cart-img">
                    <a class="nav-link dropdown-toggle" data-hover="dropdown"
                       href="<?= Url::to(['cart/view']) ?>"><img src="/images/cart-black.png" alt="Kosár">&nbsp;<span
                                class="cart-count"></span></a>
                    <div class="dropdown-menu dropdown-menu-right cart-dropdown" aria-labelledby="navbarDropdownMenuLink">
                        <div class="cart-container-top"></div>
                    </div>
                </li>

            </ul>
            <a class="search-icon" data-toggle="collapse" href="#toggleSearch" role="button" aria-expanded="false"
               aria-controls="collapseExample">
            </a>

        </div>
    </nav>
</div>