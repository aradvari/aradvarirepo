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
                    $messages[$key][] = $m;
                }
            } else {
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
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
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
