<?php

use app\components\helpers\Coreshop;
use app\models\GlobalisAdatok;
use app\models\Kategoriak;
use app\models\TermekekSearch;
use yii\helpers\Html;
use yii\helpers\Url;

?>

  <div class="container-fluid">
    <div class="row">

      <!--Column 1-->
      <div class="col-md-3 col-sm-6 blue-bg">
      
        <div class="footer-pad">
          <img src="/images/coreshop-logo-white.png" alt="Coreshop logo" title="Coreshop logo" class="img-responsive">

            <div class="media margin-top-50">
                  <img class="mr-3" src="/images/icons/location.png" alt="Cím">
                  <div class="media-body">
                    <p>1163 Budapest, <br> Cziráki utca 26-32. Fsz. 24/A </p>
                  </div>
            </div>

            <div class="media">
                  <img class="mr-3" src="/images/icons/mobile.png" alt="Telefonszám">
                  <div class="media-body">
                     <a href="tel:+36706762673" class="white">+36 70 676 2673</a><br>
                    <a href="tel:+36706311717" class="white">+36 70 631 1717 </a><br>
                  </div>
            </div>

            <div class="media">
                  <img class="mr-3" src="/images/icons/address.png" alt="Email-cím">
                  <div class="media-body">
                     <a href="mailto:info@coreshop.hu" class="white">info@coreshop.hu</a><br>
                     <a href="mailto:garancia@coreshop.hu" class="white">garancia@coreshop.hu </a>
                  </div>
            </div>

                <div class="col-sm-2 col-xs-12">
                    <div class="phone-icon"></div>
                </div>
                <div class="col-sm-10 col-xs-12 phone-numbers">
                   
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-2 col-xs-12">
                    <div class="email-icon"></div>
                </div>
                <div class="col-sm-10 col-xs-12 email-container">
                    <p class="location-text">
                      
                    </p>
                </div>
        </div> <!-- //footer-pad -->
      </div> <!-- //col-md-3 col-sm-6 -->
      <!-- //column 1 -->

      <!-- Column 2 -->
      <div class="col-md-3 col-sm-6">
        <div class="footer-pad">
            <!--<img src="/images/cxs.svg" alt="Coreshop Express Shipping logo">
            <img src="/images/express.svg" alt="CXS logo"> -->
            <h4>Coreshop <span class="alice-blue">express shipping</span> </h4>
            <div class="clearfix"></div>
            <p class="quote">"Ma megrendeled, <br>holnap hordhatod!"</p>

            <p>
            Ha most rendelsz, csomagod <br>
              <span class="white-highlighted">
                <strong>
                      <?php
                      if (GlobalisAdatok::getParam('egyedi_szallitas_idopont'))
                          echo GlobalisAdatok::getParam('egyedi_szallitas_idopont');

                      else
                          echo Coreshop::dateToHU(Coreshop::GlsDeliveryDate()) . ' </strong><br> 8:00 - 16:00 óra';
                      ?>
                        
              </span>
              <br>
            között kerül kiszállításra.
            </p>


            <!--<img src="/images/box.svg" alt="box">
            <img src="/images/free.svg" alt="Ingyenes kiszállítás">-->
             <h4>Coreshop <span class="alice-blue">free shipping</span> </h4>

            <p>
              Az ingyenes szállításhoz <?= Yii::$app->formatter->asDecimal(GlobalisAdatok::getParam('ingyenes_szallitas')) ?> Ft szükséges.
            </p>  <!-- //footer-pad -->
          </div>
      </div>  <!-- //col-md-3 col-sm-6 -->
      <!-- //column 2 -->

      <!--Column 3 -->
      <div class="col-md-3 col-sm-6">

        <div class="footer-pad">
          <h4>Fizetési <span class="alice-blue">tudnivalók</span> </h4>
          <p>A bankkártyás fizetés szolgáltatója a</p>

            <a href="/hu/kartyas-fizetes"><img src="/images/cibbank-logo.png" alt="Kártyás fizetés szolgáltatója"
                                               title="Tájékoztató a bankkártyás fizetésről" style="margin:10px 0;"></a>

            <br>

            <p class="margin-top-20" >Elfogadott bankkártya típusok</p>

            <a href="/hu/kartyas-fizetes"><img src="/images/cib-kartyalogok.png" alt="Elfogadott bankkártya típusok"
                                               style="margin:10px 0;"></a>

            <br>
            <br>

            <p><a href="/hu/kartyas-fizetes" class="white link">Tájékoztató a bankkártyás fizetésről</a></p>

            <p><a href="/hu/kerdesek-valaszok" class="white link">Gyakran feltett kérdések</a></p>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <!--Column1-->
        <div class="footer-pad">
          <h4>Oldaltérkép</h4>
          <ul class="list-unstyled">
            <li><a class="white link" href="<?= Url::to(['termekek/index', 'mainCategory' => 'ferfi-ruhazat']) ?>">Férfi ruha</a></li>
            <li><a class="white link" href="<?= Url::to(['termekek/index', 'mainCategory' => 'noi-ruhazat']) ?>">Női ruha</a></li>
            <li><a class="white link" href="<?= Url::to(['termekek/index', 'mainCategory' => 'cipo', 'subCategory' => 'ferfi-cipo']) ?>">Férfi cipő</a></li>
            <li><a class="white link" href="<?= Url::to(['termekek/index', 'mainCategory' => 'cipo', 'subCategory' => 'noi-cipo']) ?>">Női  cipő</a></li>
            <li> <a class="white link" href="<?= Url::to(['termekek/index', 'mainCategory' => 'kiegeszito']) ?>">Kiegészítő</a></li>
            <li><a class="white link" href="<?= Url::to(['termekek/index', 'mainCategory' => 'gordeszka']) ?>">Gördeszka</a></li>
            <li><a class="white link" href="<?= Url::to(['termekek/index', 'mainCategory' => 'outlet']) ?>" >SALE %</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div class="footer-bottom">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12">
          <!--Footer Bottom-->
          <p class="text-right">&copy; Copyright 2018 - Coreshop.hu</p>
        </div>
      </div>
    </div>


<!-- <footer class="footer container-fluid">
    <div class="row">


        <div class="col" id="block">

            <img src="/images/footer-logo.svg" alt="Coreshop logo" title="Coreshop logo" class="img-responsive" style="max-width:200px;">

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


        <div class="col">

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



        <div class="col" >

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
</footer> -->