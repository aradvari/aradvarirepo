<?php

namespace app\widgets\gls;

use yii\base\Widget;
use yii\helpers\Html;
use yii\web\View;

class GlsWidget extends Widget
{

    public function init()
    {
        parent::init();
        GlsAsset::register($this->view);
    }

    public function run()
    {
        $this->view->registerJs(<<<JS
            var glsMap;
            
            window.initGLSPSMap = function(){ 
                $('#big-canvas').html('');
                glsMap = new GLSPSMap();
                glsMap.init('HU', 'big-canvas', '1116,Budapest,HU', 0);
            } 
            
            google.maps.event.trigger(glsMap, 'resize'); 
            
JS
, View::POS_BEGIN);

        return Html::tag('div', '', ['id' => 'big-canvas', 'style' => 'width:100%; height:400px']);
//        return Html::encode($this->message);
    }
}

?>