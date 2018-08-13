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
      <div class="col-12 col-sm-12 col-lg-3 blue-bg">
      
        <div class="footer-pad">
          <img src="/images/coreshop-logo-white.png" alt="Coreshop logo" title="Coreshop logo" class="img-fluid">

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

        <div class="container social-icons">
          <div class="row justify-content-center">
            <div class="col-xl-3 col-4">
              <a href="https://www.facebook.com/coreshop">
                <img src="/images/icons/facebook_white.png" alt="Facebook">
              </a>
            </div>
            <div class="col-xl-3 col-4">
              <a href="https://plus.google.com/103506333733297319481">
                <img src="/images/icons/google_white.png" alt="Google">
              </a>
            </div>
            <div class="col-xl-3 col-4">
              <a href="https://www.instagram.com/coreshop.hu/">
                <img src="/images/icons/instagram_white.png" alt="Instagram">
              </a>
            </div>
          </div>
        </div>
        
         <!-- <div class="social-icon-container">
          <a href="https://www.facebook.com/coreshop"><div class="facebook-icon"></div></a>
          <a href="https://plus.google.com/103506333733297319481"><div class="google-icon"></div></a>
          <a href="https://www.instagram.com/coreshop.hu/"><div class="instagram-icon"></div></a>          

        </div> -->

        <!-- <div class="container">
          <div class="row justify-content-center">
            <img class="img-fluid px-1" src="images/icons/facebook_white.png" alt="facebook" style="width:20%">
            <img class="img-fluid px-1" src="images/icons/google_white.png" alt="google" style="width:20%">
            <img class="img-fluid px-1" src="images/icons/instagram_white.png" alt="instagram" style="width:20%">
          </div>
        </div> -->

      </div> <!-- //col-md-3 col-sm-6 -->
      <!-- //column 1 -->

      <!-- Column 2 -->
      <div class="col-md-3 col-sm-6 hidden-md-down">
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
			
			
			<p>
			<h4>Coreshop <span class="alice-blue">free shipping</span> </h4>

             <div class="row">
               <div class="col-xl-12">
                Az ingyenes szállításhoz 
               </div>
               <div class="col-xl-12">
                <?= Yii::$app->formatter->asDecimal(GlobalisAdatok::getParam('ingyenes_szallitas')) ?> Ft szükséges.
               </div>
             </div>
			 
			</p> 
			
			<p>
			<h4>Coreshop <span class="alice-blue">garancia</span> </h4>

             <div class="row">
               <div class="col-xl-12">
                Termékeinkre 15 napos pénzvisszafizetés garanciát adunk. <a href="/altalanos-szerzodesi-feltetelek#5">Részletek</a>
               </div>               
             </div>
			</p> 
			 
			 

			<!--
             <h4>Coreshop <span class="alice-blue">free shipping</span> </h4>

             <div class="row">
               <div class="col-xl-12">
                Az ingyenes szállításhoz 
               </div>
               <div class="col-xl-12">
                <?= Yii::$app->formatter->asDecimal(GlobalisAdatok::getParam('ingyenes_szallitas')) ?> Ft szükséges.
               </div>
             </div>
			 -->

            <!-- //footer-pad -->
          </div>
      </div>  <!-- //col-md-3 col-sm-6 -->
      <!-- //column 2 -->

      <!--Column 3 -->
      <div class="col-md-3 col-sm-6 col-12 hidden-md-down">

        <div class="footer-pad">
          <h4>Fizetési <span class="alice-blue">tudnivalók</span> </h4>
          <p>A bankkártyás fizetés szolgáltatója a</p>

            <a href="/kartyas-fizetes"><img src="/images/cibbank-logo.png" alt="Kártyás fizetés szolgáltatója"
                                               title="Tájékoztató a bankkártyás fizetésről" style="margin:10px 0;"></a>

            <br>

            <!-- <p class="margin-top-20" >Elfogadott bankkártya típusok</p> -->
            <h4 class="margin-top-20">Elfogadott <span class="alice-blue">bankkártya típusok</span></h4>

            <a href="/kartyas-fizetes">
              <!-- <img src="/images/cib-kartyalogok.png" alt="Elfogadott bankkártya típusok" style="margin:10px 0;"> -->

              <div class="row">
                <div class="col-xl-4 col-4">
                  <img src="/images/mastercard.png" alt="Elfogadott bankkártya típusok">
                </div>
                <div class="col-xl-8 col-8">
                  <img src="/images/maestro.png" alt="Elfogadott bankkártya típusok">
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-xl-4 col-4">
                  <img src="/images/visa.png" alt="Elfogadott bankkártya típusok"> 
                </div>
                <div class="col-xl-8 col-8">
                  <img src="/images/visa_e.png" alt="Elfogadott bankkártya típusok">
                </div>
              </div>
              
            </a>

            <br>
            <br>

            <p><a href="/kartyas-fizetes" class="white link">Tájékoztató a bankkártyás fizetésről</a></p>

            <p><a href="/kerdesek-valaszok" class="white link">Gyakran feltett kérdések</a></p>
        </div>
      </div>

       <!--Column 4 -->
      <div class="col-md-3 col-sm-6 hidden-md-down">
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
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = 'https://connect.facebook.net/hu_HU/sdk.js#xfbml=1&version=v3.1&appId=281370311969142&autoLogAppEvents=1';
		fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>

		<div class="fb-page" data-href="https://www.facebook.com/coreshop/" data-tabs="timeline" data-width="360"
             data-height="360" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-hide-cta="true"><blockquote cite="https://www.facebook.com/coreshop/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/coreshop/">Coreshop</a></blockquote></div>
      </div>
    </div>
  </div>
  </div>
  <div class="footer-bottom">
    <div class="container-fluid hidden-md-down">
          <!--Footer Bottom-->
          <p>&copy; Copyright 2018 - Coreshop.hu</p>
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

            <a href="/kartyas-fizetes"><img src="/images/cibbank-logo.png" alt="Kártyás fizetés szolgáltatója"
                                               title="Tájékoztató a bankkártyás fizetésről" style="margin:10px 0;"></a>

            <br>
            <br>

            <p>Elfogadott bankkártya típusok</p>

            <a href="/kartyas-fizetes"><img src="/images/cib-kartyalogok.png" alt="Elfogadott bankkártya típusok"
                                               style="margin:10px 0;"></a>

            <br>
            <br>

            <p><a href="/kartyas-fizetes">Tájékoztató a bankkártyás fizetésről</a></p>

            <p><a href="/kerdesek-valaszok">Gyakran feltett kérdések</a></p>

        </div>

    </div>
</footer> -->