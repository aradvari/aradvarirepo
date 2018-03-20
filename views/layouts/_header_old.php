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
            <div class="mainmenu_1">
                <a href="<?= Url::to(['termekek/index', 'mainCategory' => 'ferfi-ruhazat']) ?>">férfi ruha</a>
                <div class="mainmenu_content_1">
                    <div class="mainmenu_container">
                        <div class="subitem" id="kep">
                            <img src="/banner_header/2017/1201xmas/ferfi_ruha_menu.jpg?" alt="Férfi ruházat"
                                 title="Férfi ruházat">
                        </div>
                        <div class="subitem" id="alkategoria">
                            <p>férfi ruha kategóriák</p>

                            <nav>
                                <?php
                                $models = (new TermekekSearch())->searchSubCategory(['mainCategory' => 'ferfi-ruhazat'])->getModels();
                                foreach ($models as $item) {
                                    echo Html::beginTag('a',
                                        [
                                            'href' => Url::to([
                                                'termekek/index',
                                                'mainCategory' => $item['pk_url_segment'],
                                                'subCategory' => $item['url_segment'],
                                            ]),
                                        ]
                                    );
                                    echo Html::tag('h3', $item['megnevezes']);
                                    echo Html::endTag('a');
                                }
                                ?>
                            </nav>

                        </div>
                        <div class="subitem" id="legnepszerubb">
                            <p>legnépszerűbb termékek</p>

                            <nav>
                                <?php
                                $items = [
                                    ['polo', 'vans', 'Vans póló'],
                                    ['baseball-sapka', 'vans', 'Vans baseball sapka'],
                                    ['nadrag', 'vans', 'Vans nadrág'],
                                    ['polo', 'etnies', 'Etnies póló'],
                                    ['baseball-sapka', 'etnies', 'Etnies baseball sapka'],
                                    ['polo', 'emerica', 'Emerica polo'],
                                    ['baseball-sapka', 'emerica', 'Emerica baseball sapka'],
                                    ['baseball-sapka', 'altamont', 'Altamont baseball sapka'],
                                    ['polo', 'volcom', 'Volcom polo'],
                                ];
                                foreach ($items as $item) {
                                    echo Html::beginTag('a',
                                        [
                                            'href' => Url::to([
                                                'termekek/index',
                                                'mainCategory' => 'ferfi-ruhazat',
                                                'subCategory' => $item[0],
                                                'brand' => $item[1],
                                            ]),
                                        ]
                                    );
                                    echo Html::tag('h4', $item[2]);
                                    echo Html::endTag('a');
                                }
                                ?>
                            </nav>

                        </div>
                        <div class="subitem" id="leiras">
                            <p>leírás</p>
                            Gördeszkás ruházat az év minden napjára.<br>
                            <br>
                            Póló, pulóver, sapka, nadrág, kabát, rövidnadrág: Válogass kedvenc márkáidból!
                        </div>
                    </div>
                </div>
            </div>
            <div class="mainmenu_2">
                <a href="<?= Url::to(['termekek/index', 'mainCategory' => 'noi-ruhazat']) ?>">női ruha</a>
                <div class="mainmenu_content_2">
                    <div class="mainmenu_container">
                        <div class="subitem" id="kep">
                            <img src="/banner_header/2017/1201xmas/noi_ruha_menu.jpg?" alt="Női ruházat"
                                 title="Női ruházat">
                        </div>
                        <div class="subitem" id="alkategoria">
                            <p>női ruha kategóriák</p>

                            <nav>
                                <?php
                                $models = (new TermekekSearch())->searchSubCategory(['mainCategory' => 'noi-ruhazat'])->getModels();
                                foreach ($models as $item) {
                                    echo Html::beginTag('a',
                                        [
                                            'href' => Url::to([
                                                'termekek/index',
                                                'mainCategory' => $item['pk_url_segment'],
                                                'subCategory' => $item['url_segment'],
                                            ]),
                                        ]
                                    );
                                    echo Html::tag('h3', $item['megnevezes']);
                                    echo Html::endTag('a');
                                }
                                ?>
                            </nav>
                        </div>
                        <div class="subitem" id="legnepszerubb">
                            <p>legnépszerűbb termékek</p>

                            <nav>
                                <?php
                                $items = [
                                    ['polo', 'vans', 'Vans női póló'],
                                    ['pulover', 'vans', 'Vans női pulóver'],
                                    ['taska', 'vans', 'Vans női táska'],
                                ];
                                foreach ($items as $item) {
                                    echo Html::beginTag('a',
                                        [
                                            'href' => Url::to([
                                                'termekek/index',
                                                'mainCategory' => 'noi-ruhazat',
                                                'subCategory' => $item[0],
                                                'brand' => $item[1],
                                            ]),
                                        ]
                                    );
                                    echo Html::tag('h4', $item[2]);
                                    echo Html::endTag('a');
                                }
                                ?>
                            </nav>

                        </div>
                        <div class="subitem" id="leiras">
                            <p>leírás</p>
                            Egyedi mintázatú női Vans ruházat és kiegészítők azoknak a lányoknak, akik a
                            dél-kaliforniai stílusból merítenének inspirációt.
                        </div>
                    </div>
                </div>
            </div>
            <div class="mainmenu_3">
                <a href="<?= Url::to(['termekek/index', 'mainCategory' => 'cipo']) ?>">cipő</a>
                <div class="mainmenu_content_3">
                    <div class="mainmenu_container">
                        <div class="subitem" id="kep">
                            <img src="/banner_header/2017/1201xmas/cipo_menu.jpg?" alt="Gördeszkás cipők"
                                 title="Gördeszkás cipők">
                        </div>
                        <div class="subitem" id="alkategoria">
                            <div style="float:left;width:50%;">
                                <p>Férfi cipő</p>

                                <nav>
                                    <?php
                                    $models = (new TermekekSearch())->searchBrand(['mainCategory' => 'cipo', 'subCategory' => 'ferfi-cipo'])->getModels();
                                    foreach ($models as $item) {
                                        echo Html::beginTag('a',
                                            [
                                                'href' => Url::to([
                                                    'termekek/index',
                                                    'mainCategory' => 'cipo',
                                                    'subCategory' => 'ferfi-cipo',
                                                    'brand' => $item['url_segment'],
                                                ]),
                                            ]
                                        );
                                        echo Html::tag('h3', $item['markanev']);
                                        echo Html::endTag('a');
                                    }
                                    ?>

                                    <a href="<?= Url::to(['mainCategory' => 'cipo', 'subCategory' => 'ferfi-cipo']) ?>">
                                        <h3 title="Összes férfi cipő" style="width:100%;">Mutasd mind</h3>
                                    </a>

                                </nav>

                            </div>
                            <div style="float:left;width:50%;">
                                <p>Női cipő</p>

                                <nav>
                                    <?php
                                    $models = (new TermekekSearch())->searchBrand(['mainCategory' => 'cipo', 'subCategory' => 'noi-cipo'])->getModels();
                                    foreach ($models as $item) {
                                        echo Html::beginTag('a',
                                            [
                                                'href' => Url::to([
                                                    'termekek/index',
                                                    'mainCategory' => 'cipo',
                                                    'subCategory' => 'ferfi-cipo',
                                                    'brand' => $item['url_segment'],
                                                ]),
                                            ]
                                        );
                                        echo Html::tag('h3', $item['markanev']);
                                        echo Html::endTag('a');
                                    }
                                    ?>

                                    <a href="<?= Url::to(['mainCategory' => 'cipo', 'subCategory' => 'noi-cipo']) ?>">
                                        <h3 title="Összes női cipő" style="width:100%;">Mutasd mind</h3>
                                    </a>

                                </nav>

                            </div>
                        </div>
                        <div class="subitem" id="legnepszerubb">
                            <p>legnépszerűbb férfi cipők</p>

                            <nav>
                                <?php
                                $items = [
                                    ['vans', 'ultrarange', 'Ultrarange'],
                                    ['vans', 'old skool', 'Old Skool'],
                                    ['vans', 'kyle walker', 'Kyle Walker'],
                                    ['vans', 'iso', 'Iso 1.5'],
                                    ['vans', 'atwood', 'Atwood'],
                                    ['vans', 'tnt', 'TNT SG'],
                                    ['vans', 'rapidweld', 'AV Rapidweld'],
                                    ['vans', 'sk8-hi', 'Sk8-Hi'],
                                    ['vans', 'half cab', 'Half Cab'],
                                    ['vans', 'era', 'Era'],
                                    ['vans', null, 'Vans cipők'],
                                    ['etnies', null, 'Etnies cipők'],
                                    ['emerica', null, 'Emerica cipők'],
                                    ['es', null, 'éS cipők'],
                                ];
                                foreach ($items as $item) {
                                    echo Html::beginTag('a',
                                        [
                                            'href' => Url::to([
                                                'termekek/index',
                                                'mainCategory' => 'cipo',
                                                'subCategory' => 'ferfi-cipo',
                                                'brand' => $item[0],
                                                'keresendo' => $item[1],
                                            ]),
                                        ]
                                    );
                                    echo Html::tag('h4', $item[2]);
                                    echo Html::endTag('a');
                                }
                                ?>
                            </nav>

                            <p>legnépszerűbb női cipők</p>

                            <nav>
                                <?php
                                $items = [
                                    ['vans', 'peanuts', 'Peanuts (Snoopy)'],
                                    ['vans', 'old skool', 'Old Skool'],
                                    ['vans', 'sk8-hi', 'Sk8-Hi'],
                                    ['vans', 'slip on', 'Slip-On'],
                                    ['vans', 'authentic', 'Authentic'],
                                    ['vans', 'era', 'Era'],
                                    ['vans', 'iso', 'Iso 1.5'],
                                ];
                                foreach ($items as $item) {
                                    echo Html::beginTag('a',
                                        [
                                            'href' => Url::to([
                                                'termekek/index',
                                                'mainCategory' => 'cipo',
                                                'subCategory' => 'noi-cipo',
                                                'brand' => $item[0],
                                                'keresendo' => $item[1],
                                            ]),
                                        ]
                                    );
                                    echo Html::tag('h4', $item[2]);
                                    echo Html::endTag('a');
                                }
                                ?>
                            </nav>

                        </div>
                        <div class="subitem" id="leiras">
                            <p>leírás</p>
                            Gördeszkás cipők az év minden napjára. Kínálatunkban egyaránt megtalálod a szezon
                            legújabb férfi cipő modelljeit és a legkedveltebb klasszikusokat. Legyen szó a
                            dél-kaliforniai Vans örökzöldekről, mint a Vans Old Skool, Vans Authentic, Vans Era vagy
                            a SOLE Technology éS, Etnies, Emerica gördeszkás cipőiről.
                        </div>
                    </div>
                </div>
            </div>
            <div class="mainmenu_4">
                <a href="<?= Url::to(['termekek/index', 'mainCategory' => 'kiegeszito']) ?>">kiegészítő</a>
                <div class="mainmenu_content_4">
                    <div class="mainmenu_container">
                        <div class="subitem" id="kep">
                            <img src="/banner_header/2017/1201xmas/kiegeszito_menu.jpg?" alt="Kiegészítők"
                                 title="Kiegészítők">
                        </div>
                        <div class="subitem" id="alkategoria">
                            <p>Kiegészítő kategóriák</p>

                            <nav>
                                <?php
                                $models = (new TermekekSearch())->searchSubCategory(['mainCategory' => 'kiegeszito'])->getModels();
                                foreach ($models as $item) {
                                    echo Html::beginTag('a',
                                        [
                                            'href' => Url::to([
                                                'termekek/index',
                                                'mainCategory' => 'kiegeszito',
                                                'subCategory' => $item['url_segment'],
                                            ]),
                                        ]
                                    );
                                    echo Html::tag('h3', $item['megnevezes']);
                                    echo Html::endTag('a');
                                }
                                ?>

                            </nav>

                        </div>
                        <div class="subitem" id="legnepszerubb">
                            <p>legnépszerűbb termékek</p>

                            <nav>
                                <?php
                                $items = [
                                    ['vans', 'napszemuveg', null, 'Vans napszemüveg'],
                                    ['vans', 'napszemuveg', 'spicoli', 'Spicoli 4 Shades'],
                                    ['vans', 'napszemuveg', 'squared', 'Squared OFF'],
                                    ['vans', 'baseball-sapka', 'trucker', 'Classic Patch Trucker'],
                                    ['vans', 'ov', null, 'Vans öv'],
                                    ['vans', 'hatizsak', null, 'Vans hátizsák'],
                                    ['vans', 'taska', 'benched', 'Vans tornazsák'],
                                    ['vans', 'penztarca', null, 'Vans pénztárca'],
                                    ['vans', 'zokni', null, 'Vans zokni'],
                                    ['oakley', 'napszemuveg', null, 'Oakley napszemüveg'],
                                    ['neff', 'ora', null, 'Neff óra'],
                                    ['etnies', 'ov', null, 'Etnies öv'],
                                    ['emerica', 'ov', null, 'Emerica öv'],
                                    ['emerica', 'penztarca', null, 'Emerica pénztárca'],
                                ];
                                foreach ($items as $item) {
                                    echo Html::beginTag('a',
                                        [
                                            'href' => Url::to([
                                                'termekek/index',
                                                'mainCategory' => 'kiegeszito',
                                                'subCategory' => $item[1],
                                                'brand' => $item[0],
                                                'keresendo' => $item[2],
                                            ]),
                                        ]
                                    );
                                    echo Html::tag('h4', $item[3]);
                                    echo Html::endTag('a');
                                }
                                ?>
                            </nav>

                        </div>
                        <div class="subitem" id="leiras">
                            <p>leírás</p>
                            A gördeszkás stílus elengedhetetlen kiegészítői a Coreshop-on!<br>
                            <br>
                            A tredi külső mellett praktikusság jellemzi a népszerű Vans táskákat és kiegészítőket.
                            Mindenki ruhatárában jól mutathat egy Vans napszemüveg, öv, sapka vagy pénztárca. Vans
                            baseball sapkáinknál pedig egyaránt megtalálod a trucker és a fullcap modelleket.
                        </div>
                    </div>
                </div>
            </div>
            <div class="mainmenu_5">
                <a href="<?= Url::to(['termekek/index', 'mainCategory' => 'gordeszka']) ?>">gördeszka</a>
                <div class="mainmenu_content_5">
                    <div class="mainmenu_container">
                        <div class="subitem" id="kep">
                            <img src="/banner_header/2017/1201xmas/gordeszka_menu.jpg?" alt="Gördeszkák"
                                 title="Gördeszkák">
                        </div>
                        <div class="subitem" id="alkategoria">
                            <p>gördeszka kategóriák</p>

                            <nav>
                                <?php
                                $models = (new TermekekSearch())->searchSubCategory(['mainCategory' => 'gordeszka'])->getModels();
                                foreach ($models as $item) {
                                    echo Html::beginTag('a',
                                        [
                                            'href' => Url::to([
                                                'termekek/index',
                                                'mainCategory' => 'kiegeszito',
                                                'subCategory' => $item['url_segment'],
                                            ]),
                                        ]
                                    );
                                    echo Html::tag('h3', $item['megnevezes']);
                                    echo Html::endTag('a');
                                }
                                ?>

                            </nav>

                        </div>
                        <div class="subitem" id="legnepszerubb">
                            <p>legnépszerűbb termékek</p>

                            <nav>
                                <?php
                                $items = [
                                    ['sk8mafia', 'gordeszka-lapok', null, 'Sk8mafia gördeszkalap'],
                                    ['jart', 'gordeszka-lapok', null, 'Jart gördeszkalap'],
                                    ['almost', 'gordeszka-lapok', null, 'Almost gördeszkalap'],
                                    ['enjoi', 'gordeszka-lapok', null, 'Enjoi gördeszkalap'],
                                    ['baby-miller', 'mini-cruiser', null, 'Baby Miller Mini Cruiser'],
                                    [null, 'kerek', null, 'Gördeszka kerék'],
                                    [null, 'felfuggesztes', null, 'Gördeszka felfüggesztés'],
                                    [null, 'csapagy', null, 'Gördeszka csapágy'],
                                    [null, 'egyeb', null, 'Csavarkészlet'],
                                ];
                                foreach ($items as $item) {
                                    echo Html::beginTag('a',
                                        [
                                            'href' => Url::to([
                                                'termekek/index',
                                                'mainCategory' => 'gordeszka',
                                                'subCategory' => $item[1],
                                                'brand' => $item[0],
                                                'keresendo' => $item[2],
                                            ]),
                                        ]
                                    );
                                    echo Html::tag('h4', $item[3]);
                                    echo Html::endTag('a');
                                }
                                ?>
                            </nav>

                        </div>
                        <div class="subitem" id="leiras">
                            <p>leírás</p>
                            Folyamatosan bővülő kínálatunkban egyaránt megtalálod a legmenőbb vagy épp a legrégebbi
                            amerikai gördeszka cégek deszkáit, komplett gördeszkáit. Továbbá igyekszünk gördeszka
                            kiegészítőkkel, kerekekkel, felfüggesztésekkel, csavarkészletekkel is színesíteni
                            kínálatunk.
                        </div>
                    </div>
                </div>
            </div>
            <div class="mainmenu_6"><a
                        href="<?= Url::to(['termekek/index', 'mainCategory' => 'outlet']) ?>"
                        style="color:red;">SALE %</a></div>
            <!-- </div> -->
            <!-- cart float right -->
            <a href="<?= Url::to(['cart/view']) ?>" class="desktop-cart">
                <img src="/images/cart-black.png" alt="Kosár">&nbsp;
                <span class="cart-count"></span>
            </a>
            <!-- search float right -->
            <div class="desktop-search">
                <form id="ajax_search_form" action="<?= Url::to(['/termekek/index']) ?>" method="get" autocomplete="off">
                    <input type="text" name="q" id="search-top" placeholder="Keresés">
                    <!-- search results -->
                    <div id="search-result-container">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>