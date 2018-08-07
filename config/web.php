<?php

use yii\web\UrlNormalizer;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'language' => 'hu-HU',
    'timezone' => 'Europe/Budapest',
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
            'class' => 'yii\caching\DummyCache',
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
//            'useFileTransport' => YII_ENV_DEV,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'vserver111.smtp.mcvps.hu',
                'username' => 'coreshop',
                'password' => 'ZW_a6Y6x',
                'port' => '25000',
//                'encryption' => 'tls', // It is often used, check your provider or mail server specs
            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => 'info@coreshop.hu',
            ],
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
            'normalizer' => [
                'class' => 'yii\web\UrlNormalizer',
                'action' => UrlNormalizer::ACTION_REDIRECT_TEMPORARY,
            ],
            'rules' => [
                'regisztracio' => 'user/create',
                'tranzakcio/<userId:\d+>' => 'order/cib',
                ['pattern' => 'kosar', 'route' => 'cart/view',],
                ['pattern' => 'uzletunk', 'route' => 'site/content', 'defaults' => ['page' => 'shop'],],
                ['pattern' => 'szallitas', 'route' => 'site/content', 'defaults' => ['page' => 'shipping'],],
                ['pattern' => 'altalanos-szerzodesi-feltetelek', 'route' => 'site/content', 'defaults' => ['page' => 'contract'],],
                ['pattern' => 'kapcsolat', 'route' => 'site/content', 'defaults' => ['page' => 'contact'],],
                ['pattern' => 'garancia', 'route' => 'site/content', 'defaults' => ['page' => 'warrianty'],],
                ['pattern' => 'termekcsere', 'route' => 'site/content', 'defaults' => ['page' => 'replace'],],
                ['pattern' => 'belepes', 'route' => 'site/login'],
                ['pattern' => 'elfelejtett-jelszo', 'route' => 'site/lost-password'],
                ['pattern' => 'kartyas-fizetes', 'route' => 'site/content', 'defaults' => ['page' => 'payment'],],
                ['pattern' => 'kerdesek-valaszok', 'route' => 'site/content', 'defaults' => ['page' => 'faq'],],
                ['pattern' => 'facebook-belepes', 'route' => 'site/auth', 'defaults' => ['authclient' => 'facebook'],],
                ['pattern' => 'google-belepes', 'route' => 'site/auth', 'defaults' => ['authclient' => 'google'],],
                ['pattern' => 'fiokom', 'route' => 'user/index'],
                ['pattern' => 'kilepes', 'route' => 'site/logout'],
                ['pattern' => 'adataim', 'route' => 'user/modify'],
                ['pattern' => 'rendeleseim', 'route' => 'order/my-orders'],
                ['pattern' => 'vegleges-torles', 'route' => 'user/delete'],
            ],
        ],
        'formatter' => [
            'dateFormat' => 'long',
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
                    'clientId' => '922019182809-d30op6esq27umndhd2vii3t5uorsoibf.apps.googleusercontent.com',
                    'clientSecret' => '9XR3SIoNY9eQOzyJEmkdN3HS',
                ],
            ],
        ],
        'cart' => [
            'class' => 'app\components\Cart',
        ],
        'seo' => [
            'class' => 'app\components\Seo',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        'bootstrap.css' => '/css/bootstrap.min.css',
                    ],
                    'js' => [
                        'bootstrap.js' => '/js/bootstrap.min.js',
                    ],
                    'depends' => [
                        'luya\bootstrap4\Bootstrap4Asset',
                    ],
                ],
            ],
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