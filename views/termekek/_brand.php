<?php

use yii\helpers\ArrayHelper;

?>
<div class="row">
    <div class="col-md-3">
        <div class="brand-site-logo">
            <img src="https://coreshop.hu/pictures/markak/<?= ArrayHelper::getValue($brandModel, 'id') ?>.png"
                 class="img-responsive">
        </div>
    </div>
    <div class="col-md-9">
        <?php
        echo str_repeat('Ide jön a(z) ' . ArrayHelper::getValue($brandModel, 'id') . ' márka leírás. ', 50);
        ?>
    </div>
</div>