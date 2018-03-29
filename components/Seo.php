<?php

namespace app\components;

use yii\base\Component;
use yii\base\Exception;

class Seo extends Component
{

    public $requiedMetaTags = [
        ['name' => 'description'],
        ['name' => 'keywords'],

        ['itemprop' => 'name'],
        ['itemprop' => 'description'],
        ['itemprop' => 'image'],

//        ['name' => 'twitter:card'],
//        ['name' => 'twitter:site'],
//        ['name' => 'twitter:title'],
//        ['name' => 'twitter:description'],
//        ['name' => 'twitter:creator'],
//        ['name' => 'twitter:image:src'],

        ['property' => 'og:title'],
        ['property' => 'og:type'],
        ['property' => 'og:url'],
        ['property' => 'og:image'],
        ['property' => 'og:description'],
        ['property' => 'og:site_name'],
//        ['property' => 'article:published_time'],
//        ['property' => 'article:modified_time'],
//        ['property' => 'article:section'],
//        ['property' => 'article:tag'],

        ['property' => 'fb:app_id'],
    ];

    public $metaTags = [];

    public function registerMetaTag($options)
    {

        $this->metaTags[] = $options;
        \Yii::$app->view->registerMetaTag($options);

    }

    /**
     * {@inheritdoc}
     */
    public function validate()
    {
        foreach ($this->requiedMetaTags as $requiedMetaTag) {
            $requiredError = true;
            foreach ($this->metaTags as $metaTag) {
                foreach ($metaTag as $attrName => $attrValue) {
                    if ($requiedMetaTag[$attrName] === $attrValue) {
                        $requiredError = false;
                    }
                }
            }
            if ($requiredError) {
                throw new Exception('Missing meta tag: ' . key($requiedMetaTag) . '::' . $requiedMetaTag[key($requiedMetaTag)]);
            }
        }
    }

    public function generate(){

    }

}
