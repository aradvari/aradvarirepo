<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Seo;
use yii\helpers\Html;
use luya\bootstrap4\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="HandheldFriendly" content="true">
    <meta name="viewport" content="width=device-width, height=device-height, user-scalable=yes">
    <meta name="robots" content="all">

    <meta http-equiv="cache-control" content="max-age=0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT">
    <meta http-equiv="pragma" content="no-cache">

    <link rel="icon" href="/favicon.ico" type="image/png">
    <link rel="apple-touch-icon" href="/images/coreshop-logo-social.png">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent -->
    <link rel="stylesheet" type="text/css" href="/css/cookieconsent.min.css" />
    <script src="/js/cookieconsent.min.js"></script>
    <script>
    window.addEventListener("load", function(){
    window.cookieconsent.initialise({
      "palette": {
        "popup": {
          "background": "#252e39"
        },
        "button": {
          "background": "#0062cc"
        }
      },
      "position": "bottom-right",
      "content": {
        "message": "Oldalunk a tartalmak könnyebb személyessé tétele, hirdetéseink személyre szabása és mérése érdekében cookie-kat használ.",
        "dismiss": "Elfogadom",
        "link": "Részletek"
      }
    })});
    </script>
    <!-- End Cookie Consent plugin -->
    <!-- Facebook Pixel Code -->
    <script>
        !function (f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function () {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window,
            document, 'script', '//connect.facebook.net/en_US/fbevents.js');

        fbq('init', '1425657147763024');
        fbq('track', "PageView");</script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=1425657147763024&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Facebook Pixel Code -->
    <!-- Google Analytics Universal -->
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-17488049-1', 'auto');
        ga('require', 'displayfeatures');
        ga('require', 'linkid', 'linkid.js');
        <?if (Yii::$app->controller->route == 'termekek/view'
            && Yii::$app->request->getQueryParam('subCategory') == 'ferfi-cipo') {
            echo 'ga("set","dimension1",';
            echo json_encode($_SESSION['termek_id']);
            echo ');';
            echo "ga('set','dimension2','offerdetail');";
        }
        ?>
        ga('send', 'pageview');
    </script>
    <!-- End Google Analytics Universal -->
</head>

<body>
<?php $this->beginBody() ?>

<header class="header">
    <?= $this->render('_header') ?>
</header>

<main>
    <div class="container-fluid">
        <div class="arrow_box_light notice" style="display:none"></div>
        <?php
        $messages = [];
        foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
            if (is_array($message)) {
                foreach ($message as $m) {
                    if ($m)
                        $messages[$key][] = $m;
                }
            } else {
                if ($m)
                    $messages[$key][] = $m;
            }
        }

        foreach ($messages as $key => $message) {
            echo Html::beginTag('div', ['class' => 'alert alert-' . $key, 'role' => 'alert']);
            foreach ($message as $item) {
                echo Html::tag('small', $item, ['class' => 'clearfix']);
            }
            echo Html::endTag('div');
        }

        //        echo '<div class="alert alert-' . $key . '" role="alert">' . $m . '</div>';

        ?>

        <div class="container" id="temp-header">
        
        </div>

        <div class="container">
            <div class="row">

                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>

            </div>
        </div>

        

        <?= $content ?>
    </div>

    <div id="backtotop">
        <a href="#top">
            <img src="/images/backtotop.png" alt="Coreshop - Back to top">
        </a>
    </div>

</main>

<footer class="footer">
    <?= $this->render('_footer') ?>
</footer>

<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alertModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Rendben</button>
            </div>
        </div>
    </div>
</div>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
