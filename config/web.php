<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'language' => 'hu-HU',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'D40F3Fennp-ibyKZk4h_y9K7coIQz2qi',
            'enableCookieValidation' => false,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Felhasznalok',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from'=>'info@coreshop.hu',
            ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'class' => 'app\components\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'regisztracio' => 'user/create',
                'tranzakcio/<userId:\d+>' => 'order/cib',
                ['pattern' => 'uzletunk', 'route' => 'site/content', 'defaults' => ['page' => 'shop'],],
                ['pattern' => 'szallitas', 'route' => 'site/content', 'defaults' => ['page' => 'shipping'],],
                ['pattern' => 'altalanos-szerzodesi-feltetelek', 'route' => 'site/content', 'defaults' => ['page' => 'contract'],],
                ['pattern' => 'kapcsolat', 'route' => 'site/content', 'defaults' => ['page' => 'contact'],],
                ['pattern' => 'garancia', 'route' => 'site/content', 'defaults' => ['page' => 'warrianty'],],
            ],
        ],
        'formatter' => [
            'dateFormat' => 'yyyy.mm.dd',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'Ft',
        ],
        'mobileDetect' => [
            'class' => '\skeeks\yii2\mobiledetect\MobileDetect',
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'authUrl' => 'https://www.facebook.com/dialog/oauth',
                    'clientId' => '550827275293006',
                    'clientSecret' => '8c735cf3fc65f17e577938add202ac65',
                    'attributeNames' => ['name', 'email', 'first_name', 'last_name'],
                ],
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => '386760716692-p2rr1k25745d7ss2j0dtr1rpmu318ubq.apps.googleusercontent.com',
                    'clientSecret' => 'DWaopw7hO5NpcEUDx4sbI23b',
                ],
            ],
        ],
        'cart' => [
            'class' => 'app\components\Cart',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
