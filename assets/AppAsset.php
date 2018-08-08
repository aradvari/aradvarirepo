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
        'css/bootstrap.min.css?v=1',
        'css/site.css?v=180802',
    ];
    public $publishOptions = [
        'forceCopy' => YII_ENV_DEV,
    ];
    public $js = [
        'js/tether.min.js?v=1',
        'js/bootstrap.min.js?v=1',
        'js/site.js?v=16',
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'luya\bootstrap4\Bootstrap4Asset',
//        'yii\bootstrap\BootstrapAsset',
    ];

}
