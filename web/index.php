<?php

//$visitor = $_SERVER['REMOTE_ADDR'];
//var_dump($visitor);
//if (preg_match("/192.168.0.1/",$visitor)) {
//    header('Location: http://www.coreshop.hu');
//} else {
//    header('Location: http://www.yoursite.com/index.html');
//};

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();