<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\widgets\gls;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class GlsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'http://online.gls-hungary.com/psmap/default.css'
    ];
    public $forceCopy = true;
    public $js = [
//        'http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js',
        'http://maps.googleapis.com/maps/api/js?v=3&sensor=false&key=AIzaSyD77lZrm6N5pB7RtInyV3iGJJbMBviYIwg',
        'http://online.gls-hungary.com/psmap/psmap.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];

}
