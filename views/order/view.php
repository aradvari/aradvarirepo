<?php

use app\assets\OrderAsset;

OrderAsset::register($this);

echo $this->render('/user/_login', ['model' => $model, 'felhasznaloModel' => $felhasznaloModel]);
echo $this->render('/user/_reg', ['model' => $model, 'felhasznaloModel' => $felhasznaloModel]);
echo $this->render('/cart/_cart');