<?php

use yii\helpers\Url;

?>
<p>Szia!</p>

<p>A Coreshop.hu on-line áruházunkban jelszómódosítási igényt rögzítettél. Az új jelszavadat ezúttal küldjök meg
    neked:</p>

<p>Jelszó: <?= $password ?></p>

<p>FONTOS! Az új jelszó jelenleg még nem aktív, annak aktiválásához kattints az alábbi linkre:
    <a href="<?= Url::to(['/site/lost-password', 'code' => $jelszoModel->aktiv_kod]) ?>">ÚJ JELSZÓ ÉRVÉNYESÍTÉSE</a>
</p>