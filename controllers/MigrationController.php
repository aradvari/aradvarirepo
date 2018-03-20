<?php

namespace app\controllers;

use app\models\Kategoriak;
use app\models\Markak;
use app\models\Termekek;
use app\models\Vonalkodok;
use Yii;
use yii\db\Exception;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class MigrationController extends Controller
{


    public function actionIndex()
    {
//        try {
//            Yii::$app->db->createCommand('ALTER TABLE vonalkodok DROP COLUMN url_segment')->execute();
//            Yii::$app->db->createCommand('ALTER TABLE kategoriak DROP COLUMN url_segment')->execute();
//            Yii::$app->db->createCommand('ALTER TABLE markak DROP COLUMN url_segment')->execute();
//            Yii::$app->db->createCommand('ALTER TABLE termekek DROP COLUMN url_segment')->execute();
//        } catch (Exception $e) {
//            echo Html::tag('div', $e->getMessage());
//        }
//
//        try {
//            Yii::$app->db->createCommand('ALTER TABLE vonalkodok ADD url_segment varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci')->execute();
//            Yii::$app->db->createCommand('ALTER TABLE kategoriak ADD url_segment varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci')->execute();
//            Yii::$app->db->createCommand('ALTER TABLE markak ADD url_segment varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci')->execute();
//            Yii::$app->db->createCommand('ALTER TABLE termekek ADD url_segment varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci')->execute();
//        } catch (Exception $e) {
//            echo Html::tag('div', $e->getMessage());
//        }
//
//        $items = Kategoriak::find()->all();
//        foreach ($items as $item){
//            $item->url_segment = Inflector::slug($item->megnevezes);
//            if (!$item->save())
//                var_dump($item->getErrors());
//        }
//
//        $items = Markak::find()->all();
//        foreach ($items as $item){
//            $item->url_segment = Inflector::slug($item->markanev);
//            if (!$item->save())
//                var_dump($item->getErrors());
//        }
//
//        $items = Termekek::find()->all();
//        foreach ($items as $item) {
//            $item->url_segment = Inflector::slug($item->termeknev . '-' . $item->szin);
//            if (!$item->save())
//                var_dump($item->getErrors());
//        }
//
//        $items = Vonalkodok::find()->all();
//        foreach ($items as $item){
//            $item->url_segment = Inflector::slug($item->megnevezes);
//            if (!$item->save())
//                var_dump($item->getErrors());
//        }
//
//        try {
//            Yii::$app->db->createCommand('ALTER TABLE megrendeles_fej ADD gls_kod varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci')->execute();
//            Yii::$app->db->createCommand("ALTER TABLE felhasznalok ADD auth_type varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'normal'")->execute();
//        } catch (Exception $e) {
//            echo Html::tag('div', $e->getMessage());
//        }
//
//        $users = Felhasznalok::find(['aktivacios_kod'=>'login_once'])->all();
//        foreach ($users as $user){
//            $user->aktivacios_kod = null;
//            if (!$user->save())
//                var_dump($user->getErrors());
//        }
//
//


    }

}
