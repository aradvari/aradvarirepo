<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<h2>Üdvözlet <?= Html::decode(Yii::$app->user->identity->keresztnev) ?>!</h2>
<p>(nem <?= Html::decode(Yii::$app->user->identity->keresztnev) ?>? – <a href="<?= Url::to('/site/logout') ?>">Kijelenetkezés</a>)</p>

<ul>
    <li><a href="<?= Url::to('/user/modify') ?>">Alapadataim módosítása</a></li>

    <?php if (Yii::$app->user->identity->auth_type == 'normal'): ?>
    <li><a href="<?= Url::to('/user/password') ?>">Jelszó módosítása</a></li>
    <?php endif; ?>

    <li><a href="<?= Url::to('/order/my-orders') ?>">Korábbi rendeléseim</a></li>

    <li><a href="<?= Url::to('/user/delete') ?>">Felhasználói fiókom törlése</a></li>

    <li><a href="<?= Url::to('/site/logout') ?>">Kijelentkezés</a></li>
</ul>