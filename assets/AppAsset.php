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
        'css/bootstrap.min.css',
        'css/site.css',
    ];
    public $publishOptions = [
        'forceCopy' => YII_ENV_DEV,
    ];
    public $js = [
        'js/tether.min.js',
        'js/bootstrap.min.js',
        'js/site.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'luya\bootstrap4\Bootstrap4Asset',
//        'yii\bootstrap\BootstrapAsset',
    ];

}
