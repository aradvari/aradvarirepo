<?php

use yii\helpers\ArrayHelper;

?>

<div class="container mb-3">
    <div class="row">
        <div class="col-lg-3 col-md-4 col-12 align-self-center">
            <div class="brand-site-logo">
                <p class="text-center">
                    <img src="https://coreshop.hu/pictures/markak/<?= ArrayHelper::getValue($brandModel, 'id') ?>.png"
                     class="img-fluid">
                </p>
            </div>
        </div>
        <div class="col-lg-9 col-md-8 col-12">
            <?php
            try {
                echo $this->render('/termekek/brands/_' . ArrayHelper::getValue($brandModel, 'url_segment'));
            }catch (Exception $e){
                
            }
            ?>
        </div>
    </div>
</div>