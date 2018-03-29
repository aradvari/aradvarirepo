<?php

namespace app\models;

use app\components\db\ActiveRecord;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class TermekKep extends ActiveRecord
{
    public $id;
    public $type;
    public $fileName;
    public $webUrl;
    public $serverRoot;
    public $sizes;
    public static $imageDir = 'termek';

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['id', 'type', 'fileName', 'webUrl', 'serverRoot', 'sizes'],
        ];
    }

    public static function findOne($id, $imageId = 1, $type = 'small')
    {

        $directory = Yii::getAlias('@webroot') . '/' . static::$imageDir . '/' . implode('/', str_split($id));
        $filename = $directory . '/' . $imageId . '_' . $type . '.jpg';

        if (is_file($filename)) {

            $exp = explode('_', basename($filename));

            $image = new TermekKep();
            $image->id = $exp[0];
            $image->type = $exp[1];
            $image->fileName = basename($filename);
            $image->webUrl = Yii::getAlias('@web') . '/' . static::$imageDir . '/' . implode('/', str_split($id)) . '/' . basename($filename);
            $image->serverRoot = $filename;
            $image->sizes = @getimagesize($image->serverRoot);

            return $image;

        }

        return false;

    }

    public static function findAll($id, $type = 'small')
    {

        $directory = Yii::getAlias('@webroot') . '/' . static::$imageDir . '/' . implode('/', str_split($id));

        if (is_dir($directory)) {
            $pictures = [];
            foreach (@glob($directory . "/*_{$type}.jpg") as $filename) {

                $exp = explode('_', basename($filename));

                $image = new TermekKep();
                $image->id = $exp[0];
                $image->type = $exp[1];
                $image->fileName = basename($filename);
                $image->webUrl = Yii::getAlias('@web') . '/' . static::$imageDir . '/' . implode('/', str_split($id)) . '/' . basename($filename);
                $image->serverRoot = $filename;
                $image->sizes = @getimagesize($image->serverRoot);

                $pictures[] = $image;
            }
            return $pictures;
        }

        return false;

    }

}
