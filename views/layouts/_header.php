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
    <div class="header-main">
        <div class="header-main-container">
            <a href="/"><img src="/images/coreshop_logo_w_icon.svg" alt="Coreshop.hu" class="logo"></a>
            <div class="mainmenu_1"><a href="<?= Url::to(['termekek/index', 'mainCategory' => 'ferfi-ruhazat']) ?>">férfi
                    ruha</a></div>
            <div class="mainmenu_2"><a href="<?= Url::to(['termekek/index', 'mainCategory' => 'noi-ruhazat']) ?>">női
                    ruha</a></div>
            <div class="mainmenu_3"><a
                        href="<?= Url::to(['termekek/index', 'mainCategory' => 'cipo', 'subCategory' => 'ferfi-cipo']) ?>">férfi cipő</a>
            </div>
            <div class="mainmenu_4"><a
                        href="<?= Url::to(['termekek/index', 'mainCategory' => 'cipo', 'subCategory' => 'noi-cipo']) ?>">női cipő</a>
            </div>
            <div class="mainmenu_5"><a href="<?= Url::to(['termekek/index', 'mainCategory' => 'kiegeszito']) ?>">kiegészítő</a></div>
            <div class="mainmenu_6"><a href="<?= Url::to(['termekek/index', 'mainCategory' => 'gordeszka']) ?>">gördeszka</a></div>
            <div class="mainmenu_6"><a href="<?= Url::to(['termekek/index', 'mainCategory' => 'outlet']) ?>" style="color:red;">SALE %</a></div>
            <!-- </div> -->
            <!-- cart float right -->
            <a href="<?= Url::to(['cart/view']) ?>" class="desktop-cart">
                <img src="/images/cart-black.png" alt="Kosár">&nbsp;
                <span class="cart-count"></span>
            </a>
            <!-- search float right -->
            <div class="desktop-search">
                <form id="ajax_search_form" action="<?= Url::to(['/termekek/index']) ?>" method="get"
                      autocomplete="off">
                    <input type="text" name="q" id="search-top" placeholder="Keresés">
                    <!-- search results -->
                    <div id="search-result-container">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>