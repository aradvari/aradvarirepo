<?php

namespace app\controllers;

use app\components\web\Controller;
use app\models\Termekek;
use yii\helpers\Inflector;

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
        $items = Termekek::find()->all();
        foreach ($items as $item) {
            $segment = Inflector::slug($item->termeknev . '-' . $item->szin);
            $find = Termekek::findAll(['url_segment' => $segment]);
            $item->url_segment = $find ? $segment . (string)(count($find) + 1) : $segment;
            if (!$item->save())
                var_dump($item->getErrors());
        }
//
//        $items = Vonalkodok::find()->all();
//        foreach ($items as $item){
//            $item->url_segment = Inflector::slug($item->megnevezes);
//            if (!$item->save())
//                var_dump($item->getErrors());
//        }
//
//

//
//
        /*
         *
         *

        ALTER TABLE megrendeles_fej ADD gls_kod varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci
        ALTER TABLE felhasznalok ADD auth_type varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'normal'
        ALTER TABLE termekek ADD tipus varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci


        CREATE TABLE `termek_ertekeles` (
    `id_termek_ertekeles` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_termek` int(11) DEFAULT NULL,
  `ertek1` int(11) DEFAULT NULL,
  `ertek2` int(11) DEFAULT NULL,
  `ertek3` int(11) DEFAULT NULL,
  `ertek4` int(11) DEFAULT NULL,
  `ertek5` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_termek_ertekeles`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        CREATE TABLE `termek_ertekeles_felhasznalo` (
    `id_termek_ertekeles_felhasznalo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_termek` int(11) DEFAULT NULL,
  `id_felhasznalo` int(11) DEFAULT NULL,
  `datum` datetime DEFAULT NULL,
  `ertek` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_termek_ertekeles_felhasznalo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        CREATE TABLE `fizetesi_mod` (
`id_fizetesi_mod` int(11) unsigned NOT NULL AUTO_INCREMENT,​
`nev` varchar(50) DEFAULT NULL,​
PRIMARY KEY (`id_fizetesi_mod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        INSERT INTO `fizetesi_mod` (`id_fizetesi_mod`,​ `nev`)
VALUES
    (1,​'Átvételkor készpénzben vagy bankkártyával'),​
    (2,​'Bankártya (CIB)');


        CREATE TABLE `szallitasi_mod` (
`id_szallitasi_mod` int(11) unsigned NOT NULL AUTO_INCREMENT,​
`nev` varchar(50) DEFAULT NULL,​
`sorrend` int(11) DEFAULT NULL,​
PRIMARY KEY (`id_szallitasi_mod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `szallitasi_mod` (`id_szallitasi_mod`,​ `nev`,​ `sorrend`)
VALUES
    (1,​'Csomagküldő szolgálattal',1),​
    (2,​'Személyes átvétel irodánkban',3),​
    (3,​'GLS csomagpontba',2);


        */

    }

}
