<?php

$visitor = $_SERVER['REMOTE_ADDR'];
if ($visitor != "62.77.233.236" && $visitor != "195.70.40.125") {
    header('Location: https://www.coreshop.hu/index.html?i='.$visitor);
die;
}

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();