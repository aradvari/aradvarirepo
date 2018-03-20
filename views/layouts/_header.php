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
       <form class="form-inline mt-2 mt-md-0" id="ajax_search_form" action="<?= Url::to(['/termekek/index']) ?>" method="get" autocomplete="off">
        <input class="form-control search-input" id="search-top" type="text" placeholder="Írd be a keresett terméket..." name="q">
        <!-- search results -->
            <div id="search-result-container">
            </div>
        </form>
    </div>

     <nav class="navbar navbar-toggleable-md bg-light navbar-light">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="/"><img src="/images/coreshop_logo_w_icon.svg" alt="Coreshop.hu" class="logo"></a>
    <div class="collapse navbar-collapse" id="navbarCollapse">
         <ul class="navbar-nav mr-auto">
         </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?= Url::to(['termekek/index', 'mainCategory' => 'ferfi-ruhazat']) ?>">férfi ruha</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= Url::to(['termekek/index', 'mainCategory' => 'noi-ruhazat']) ?>">női ruha</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= Url::to(['termekek/index', 'mainCategory' => 'ferfi-cipo']) ?>">férfi cipő</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= Url::to(['termekek/index', 'mainCategory' => 'cipo', 'subCategory' => 'noi-cipo']) ?>">női cipő</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= Url::to(['termekek/index', 'mainCategory' => 'kiegeszito']) ?>">kiegészítő</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= Url::to(['termekek/index', 'mainCategory' => 'gordeszka']) ?>">gördeszka</a>
            </li>
             <li class="nav-item">
                <a class="nav-link" href="<?= Url::to(['termekek/index', 'mainCategory' => 'outlet']) ?>" style="color:red;">SALE %</a>
            </li>
        </ul>
         <a class="search-icon" data-toggle="collapse" href="#toggleSearch" role="button" aria-expanded="false" aria-controls="collapseExample">
        </a>
      
         <!-- cart float right -->
        <a href="<?= Url::to(['cart/view']) ?>" class="nav-item desktop-cart">
            <img src="/images/cart-black.png" alt="Kosár">&nbsp;
            <span class="cart-count"></span>
        </a>
      </div>
    </nav>
</div>