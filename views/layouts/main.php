<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
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
    <meta name="google-site-verification" content="FJXmdPLEe96Ga1GQNgZjWfg3t7beMJ3rinqkDDVt9CA">
    <meta name="HandheldFriendly" content="true">
    <meta name="viewport" content="width=device-width, height=device-height, user-scalable=yes">
    <meta name="google" content="notranslate">
    <meta name="format-detection" content="telephone=no">
    <meta name="robots" content="all">
    <meta http-equiv="cache-control" content="max-age=0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT">
    <meta http-equiv="pragma" content="no-cache">


    <meta property="og:title" content="Kezdőlap">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://coreshop.hu/">
    <meta property="og:image" content="https://coreshop.hu/images/coreshop-logo-social.png">
    <meta property="og:description"
          content="Gördeszkás webshop Vans, Etnies, éS Footwear, Emerica, Volcom termékek, azonnali szállítással. Coreshop a gördeszka, cipő, ruházat és kiegészítők webáruháza">

    <meta property="article:publisher" content="https://www.facebook.com/coreshop">
    <meta property="article:publisher" content="https://plus.google.com/+coreshop">

    <link rel="icon" href="/favicon.ico" type="image/png">
    <link rel="apple-touch-icon" href="/images/coreshop-logo-social.png">
    <meta property="og:image" content="/images/coreshop-logo-social.png">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
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
        foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
            if (is_array($message)) {
                foreach ($message as $m) {
                    echo '<div class="alert-box alert-' . $key . '">' . $m . '</div>';
                }
            } else {
                echo '<div class="alert-box alert-' . $key . '">' . $message . '</div>';
            }
        }
        ?>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer">
    <?= $this->render('_footer') ?>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
