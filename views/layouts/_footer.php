<?php

use app\components\helpers\Coreshop;
use app\models\GlobalisAdatok;
use app\models\Kategoriak;
use app\models\TermekekSearch;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="footer">
    <div class="footer-container">


        <div id="block" style="width:33%;">

            <img src="/images/footer-logo.svg" alt="Coreshop logo" title="Coreshop logo">

            <br>

            <a href="tel:+36706762673">+36 70 676 2673</a>&nbsp;&nbsp;<a href="tel:+36706311717">+36 70 631 1717</a>

            <br>

            1163 Budapest, Cziráki utca 26-32. Fsz. 24/A

            <br>

            <a href="mailto:info@coreshop.hu">info@coreshop.hu</a>, <a href="mailto:garancia@coreshop.hu">garancia@coreshop.hu</a>

            <br>
            <br>

            <a href="https://www.facebook.com/coreshop" target="_blank"><img src="/images/social_fb-1.svg"
                                                                             alt="Coreshop @facebook.com"
                                                                             class="soc-icon"></a>
            <a href="https://www.instagram.com/coreshop.hu/" target="_blank"><img src="/images/social_insta.svg"
                                                                                  alt="Coreshop @instagram.com"
                                                                                  class="soc-icon"></a>
            <a href="https://plus.google.com/+coreshop" target="_blank"><img src="/images/social_g-1.svg"
                                                                             alt="Coreshop @plus.google.com"
                                                                             class="soc-icon"></a>

            <br>
            © 2018 Coreshop.hu

        </div>


        <div id="block" style="border-left:1px solid #fff;border-right:1px solid #fff;width:25%;padding:0 4%;">

            <img src="/images/cxs.svg" alt="Coreshop Express Shipping logo">
            <img src="/images/express.svg" alt="CXS logo">
            <span>"Ma megrendeled, holnap már hordhatod!"</span>

            <br>
            <br>

            <span>
	Ha most rendelsz, csomagod <br><font style="color:#2a87e4;">
                    <?php
                    if (GlobalisAdatok::getParam('egyedi_szallitas_idopont'))
                        echo GlobalisAdatok::getParam('egyedi_szallitas_idopont');
                    else
                        echo Coreshop::dateToHU(Coreshop::GlsDeliveryDate()) . ' / 8:00 - 16:00 óra';
                    ?></font><br>
	között kerül kiszállításra.
	</span>

            <br>
            <br>

            <img src="/images/box.svg" alt="box">
            <img src="/images/free.svg" alt="Ingyenes kiszállítás">

            <br>

            <span>
	Az ingyenes szállításhoz <?= Yii::$app->formatter->asDecimal(GlobalisAdatok::getParam('ingyenes_szallitas')) ?> Ft szükséges	</span>


        </div>


        <!-- CIB -->
        <div id="block" style="width:29%;padding-left:4%;">

            <p>A bankkártyás fizetés szolgáltatója a</p>

            <a href="/hu/kartyas-fizetes"><img src="/images/cibbank-logo.png" alt="Kártyás fizetés szolgáltatója"
                                               title="Tájékoztató a bankkártyás fizetésről" style="margin:10px 0;"></a>

            <br>
            <br>

            <p>Elfogadott bankkártya típusok</p>

            <a href="/hu/kartyas-fizetes"><img src="/images/cib-kartyalogok.png" alt="Elfogadott bankkártya típusok"
                                               style="margin:10px 0;"></a>

            <br>
            <br>

            <p><a href="/hu/kartyas-fizetes">Tájékoztató a bankkártyás fizetésről</a></p>

            <p><a href="/hu/kerdesek-valaszok">Gyakran feltett kérdések</a></p>

        </div>

    </div>
</div>