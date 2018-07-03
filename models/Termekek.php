<?php

namespace app\models;

use app\components\Cart;
use app\components\db\ActiveRecord;
use app\components\db\Model;
use Yii;

/**
 * This is the model class for table "mcrypt_module_open".
 *
 * @property int $id
 * @property int $kategoria
 * @property string $termeknev
 * @property string $cikkszam
 * @property int $markaid
 * @property string $viszonteladoi_ar
 * @property string $akcios_viszonteladoi_ar
 * @property string $kisker_ar
 * @property string $akcios_kisker_ar
 * @property string $klub_ar
 * @property int $klub_termek
 * @property int $dealoftheweek
 * @property string $ajanlott_beszerzesi_ar
 * @property string $leiras
 * @property string $video youtube iframe
 * @property int $aktiv
 * @property string $opcio
 * @property string $fokep
 * @property string $szin
 * @property int $keszleten
 * @property string $torolve
 * @property int $modositva
 * @property int $modositva2
 * @property int $modositva3
 * @property int $batch hetvegi akcio
 * @property int $opcio_sorrend
 * @property int $tarolva tartolas helye
 * @property string $tag
 * @property string $szinszuro
 * @property string $url_segment
 * @property string $seo_name
 * @property string $vegleges_ar
 */
class Termekek extends ActiveRecord
{

    public $seo_name;
    public $vegleges_ar;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'termekek';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kategoria', 'markaid', 'viszonteladoi_ar', 'akcios_viszonteladoi_ar', 'kisker_ar', 'akcios_kisker_ar', 'klub_ar', 'klub_termek', 'dealoftheweek', 'ajanlott_beszerzesi_ar', 'aktiv', 'keszleten', 'modositva', 'modositva2', 'modositva3', 'batch', 'opcio_sorrend', 'tarolva'], 'integer'],
            [['leiras', 'video'], 'string'],
//            [['video', 'tag', 'szinszuro'], 'required'],
            [['torolve', 'url_segment', 'seo_name', 'vegleges_ar'], 'safe'],
            [['termeknev', 'cikkszam', 'fokep'], 'string', 'max' => 255],
            [['opcio'], 'string', 'max' => 100],
            [['szin'], 'string', 'max' => 200],
            [['tag'], 'string', 'max' => 128],
            [['szinszuro'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kategoria' => 'Kategoria',
            'termeknev' => 'Termeknev',
            'cikkszam' => 'Cikkszam',
            'markaid' => 'Markaid',
            'viszonteladoi_ar' => 'Viszonteladoi Ar',
            'akcios_viszonteladoi_ar' => 'Akcios Viszonteladoi Ar',
            'kisker_ar' => 'Kisker Ar',
            'akcios_kisker_ar' => 'Akcios Kisker Ar',
            'klub_ar' => 'Klub Ar',
            'klub_termek' => 'Klub Termek',
            'dealoftheweek' => 'Dealoftheweek',
            'ajanlott_beszerzesi_ar' => 'Ajanlott Beszerzesi Ar',
            'leiras' => 'Leiras',
            'video' => 'Video',
            'aktiv' => 'Aktiv',
            'opcio' => 'Opcio',
            'fokep' => 'Fokep',
            'szin' => 'Szin',
            'keszleten' => 'Keszleten',
            'torolve' => 'Torolve',
            'modositva' => 'Modositva',
            'modositva2' => 'Modositva2',
            'modositva3' => 'Modositva3',
            'batch' => 'Batch',
            'opcio_sorrend' => 'Opcio Sorrend',
            'tarolva' => 'Tarolva',
            'tag' => 'Tag',
            'szinszuro' => 'Szinszuro',
        ];
    }

    public static function findByUrlSegment($urlSegment)
    {
        $model = Termekek::find()
            ->andWhere(['termekek.url_segment' => $urlSegment])
            ->joinWith(['defaultSubCategory.parentCategory'])
            ->joinWith(['marka'])
            ->one();
        return $model;
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->seo_name = $this->marka->markanev . ' ' . $this->termeknev;
        $this->vegleges_ar = (float)$this->akcios_kisker_ar ? $this->akcios_kisker_ar : $this->kisker_ar;

        //Kupon ellenőrzés
        $code = Cart::getStaticCouponCode();
        if ($code['success']) {
            if (array_key_exists($this->id, Yii::$app->params['couponItems'][$code['code']])) {
                $this->vegleges_ar *= (float)Yii::$app->params['couponItems'][$code['code']][$this->id];
            }
        }

    }

    public function getVonalkodok()
    {
        return $this->hasMany(Vonalkodok::className(), ['id_termek' => 'id'])
            ->alias('vk')
            ->andOnCondition(['vk.aktiv' => 1])
            ->andOnCondition(['>', 'vk.keszlet_1', 0])
            ->leftJoin('vonalkod_sorrendek', 'vk.megnevezes = vonalkod_sorrendek.vonalkod_megnevezes')
            ->orderBy('vonalkod_sorrendek.sorrend, vk.megnevezes');
    }

    public function getKeszlet()
    {
        return $this->hasMany(Vonalkodok::className(), ['id_termek' => 'id'])->sum('keszlet_1');
    }

    public function getKategoriak()
    {
        return $this->hasMany(Kategoriak::className(), ['id_kategoriak' => 'id_kategoriak'])
            ->viaTable('termek_kategoria_kapcs', ['id_termekek' => 'id']);
    }

    public function getDefaultSubCategory()
    {
        return $this->hasOne(Kategoriak::className(), ['id_kategoriak' => 'kategoria']);
    }

    public function getDefaultMainCategory()
    {
        return $this->hasOne(Kategoriak::className(), ['id_kategoriak' => 'szulo'])
            ->viaTable('kategoriak k2', ['id_kategoriak' => 'kategoria']);
    }

    public function getMarka()
    {
        return $this->hasOne(Markak::className(), ['id' => 'markaid']);
    }

    public function getDefaultImage($type = 'small')
    {
        return TermekKep::findOne($this->id, 1, $type);
    }

    public function getImages($type = 'small')
    {
        return TermekKep::findAll($this->id, $type);
    }

    public function isAkcios()
    {
        return $this->akcios_kisker_ar > 0;
    }

    public function getErtekeles()
    {
        return $this->hasOne(TermekErtekeles::className(), ['id_termek' => 'id']);
    }

    public function getErtekelesAVG()
    {
        $model = $this->ertekeles;

        if (!$model)
            return 0;


        $sum = ($model->ertek1 * 1) +
            ($model->ertek2 * 2) +
            ($model->ertek3 * 3) +
            ($model->ertek4 * 4) +
            ($model->ertek5 * 5);

        $count = $model->ertek1 + $model->ertek2 + $model->ertek3 + $model->ertek4 + $model->ertek5;

        return $sum / $count;

    }

}
