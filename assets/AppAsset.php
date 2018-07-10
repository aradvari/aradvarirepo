<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css',
        'css/site.css?v=4',
    ];
    public $publishOptions = [
        'forceCopy' => YII_ENV_DEV,
    ];
    public $js = [
        '//cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js',
//        'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js',
        'js/site.js?v=11',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'luya\bootstrap4\Bootstrap4Asset',
//        'yii\bootstrap\BootstrapAsset',
    ];

}
