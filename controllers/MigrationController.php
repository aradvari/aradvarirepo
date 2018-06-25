<?php

namespace app\controllers;

use app\components\web\Controller;
use app\models\Kategoriak;
use app\models\Markak;
use app\models\Termekek;
use app\models\Vonalkodok;
use yii\helpers\Inflector;

class MigrationController extends Controller
{

    public function actionIndex($key)
    {
        if ($key == 1) {
            $items = Kategoriak::find()->all();
            foreach ($items as $item) {
                $item->url_segment = Inflector::slug($item->megnevezes);
                if (!$item->save())
                    var_dump($item->getErrors());
            }
        }

        if ($key == 2) {
            $items = Markak::find()->all();
            foreach ($items as $item) {
                $item->url_segment = Inflector::slug($item->markanev);
                if (!$item->save())
                    var_dump($item->getErrors());
            }
        }

        if ($key == 3) {
            $items = Termekek::find()->all();
            foreach ($items as $item) {
                $segment = Inflector::slug($item->termeknev . '-' . $item->szin);
                $find = Termekek::findAll(['url_segment' => $segment]);
                $item->url_segment = $find ? $segment . (string)(count($find) + 1) : $segment;
                if (!$item->save())
                    var_dump($item->getErrors());
            }
        }

        if ($key == 4) {
            $items = Vonalkodok::find()->all();
            foreach ($items as $item) {
                $item->url_segment = Inflector::slug($item->megnevezes);
                if (!$item->save())
                    var_dump($item->getErrors());
            }
        }



//
//
        /*
         *
         *
         *

                ALTER TABLE vonalkodok ADD url_segment varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci;
        ALTER TABLE kategoriak ADD url_segment varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci;
        ALTER TABLE markak ADD url_segment varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci;
        ALTER TABLE termekek ADD url_segment varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci;

        ALTER TABLE megrendeles_fej ADD gls_kod varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci;
        ALTER TABLE felhasznalok ADD auth_type varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'normal';
        ALTER TABLE termekek ADD tipus varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci;


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
`id_fizetesi_mod` int(11) unsigned NOT NULL AUTO_INCREMENT,
`nev` varchar(50) DEFAULT NULL,
PRIMARY KEY (`id_fizetesi_mod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        INSERT INTO `fizetesi_mod` (`id_fizetesi_mod`, `nev`)
VALUES
    (1,'Átvételkor készpénzben vagy bankkártyával'),
    (2,'Bankártya (CIB)');


        CREATE TABLE `szallitasi_mod` (
  `id_szallitasi_mod` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nev` varchar(50) DEFAULT NULL,
  `sorrend` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_szallitasi_mod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `szallitasi_mod` (`id_szallitasi_mod`, `nev`, `sorrend`)
VALUES
	(1,'Csomagküldő szolgálattal',1),
	(2,'Személyes átvétel irodánkban',3),
	(3,'GLS csomagpontba',2);

CREATE FUNCTION toSlug(s NVARCHAR(500)) RETURNS NVARCHAR(500) DETERMINISTIC

RETURN REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
REPLACE(REPLACE(LOWER(TRIM(s)),
':', ''), ')', ''), '(', ''), ',', ''), '\\', ''), '/', ''), '"', ''), '?', ''),
"'", ''), '&', ''), '!', ''), '.', ''), ' ', '-'), '--', '-'), '--', '-'),'ù','u'),
'ú','u'),'û','u'),'ü','u'),'ý','y'),'ë','e'),'à','a'),'á','a'),'â','a'),'ã','a'),
'ä','a'),'å','a'),'æ','a'),'ç','c'),'è','e'),'é','e'),'ê','e'),'ë','e'),'ì','i'),
'í','i'),'ě','e'), 'š','s'), 'č','c'),'ř','r'), 'ž','z'), 'î','i'),'ï','i'),'ð','o'),
'ñ','n'),'ò','o'),'ó','o'),'ô','o'),'õ','o'),'ö','o'),'ø','o'),'%', '');

        UPDATE kategoriak set url_segment = toSlug(megnevezes)
        UPDATE markak set url_segment = toSlug(markanev)
        UPDATE termekek set url_segment = toSlug(concat(IFNULL(termeknev, ''), '-', IFNULL(szin, ''), '-', id))
        UPDATE vonalkodok set url_segment = toSlug(megnevezes)


        */

    }

}
