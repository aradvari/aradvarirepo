<?php
/* @var $this yii\web\View */

use app\components\helpers\Coreshop;
use app\models\FizetesiMod;
use app\models\GlobalisAdatok;
use app\models\SzallitasiMod;

/* @var $searchModel app\models\MegrendelesFej */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">

    <meta name="HandheldFriendly" content="true"/>
    <meta name="viewport" content="width=device-width, height=device-height, user-scalable=yes"/>

    <title>Coreshop - Sikeres vásárlás</title>


    <style type="text/css">
        <!--

        body {
            width: 100% !important;
            margin: 0;
            padding: 0;
            background-color: #fff;
            font-family: Helvetica, sans-serif;
            font-size: 14px;
            font-weight: normal;
            color: #222;
            text-decoration: none;
        }

        .main {
            width: 100%;
            max-width: 800px;
            padding: 0px;
            background-color: #fff;
            text-align: center;
        }

        img {
            width: 100%;
            margin: 0;
            padding: 0;
            border: none;
        }

        a {
            color: #2a87e4;
            border: none;
            outline: none;
            text-decoration: none;
            font-weight: normal;
        }

        a:hover {
            text-decoration: none;
        }

        .content {
            margin-top: 0px;
        }

        .headline-logo {
            margin: 0;
            padding: 10px 0;
            text-align: center;
        }

        .headline-logo img {
            border: none;
            padding: 0 0 0 4%;
            width: 30%;
            max-width: 160px;
        }

        p {
            padding: 0 4%;
            margin: 0;
            text-align: left;
            color: #222;
        }

        h1 {
            color: #2a87e4;
            font-size: 1em;
            font-weight: normal;
            text-decoration: normal;
            margin: 4%;
            padding: 0;
            text-align: center;
        }

        h3 {
            color: #999;
            font-size: 0.8em;
            font-weight: normal;
            text-decoration: normal;
            margin: 0;
            padding: 0 20px;
        }

        .block {
            width: 29%;
            display: inline-block;
            float: left;
            margin: 0 2% 0% 2%;
        }

        .blockp {
            padding: 6%;
            font-weight: normal;
            text-align: center;
        }

        .footer {
            clear: both;
            background-color: #000;
            text-align: center;
            padding: 10% 5%;
            margin: 0;
            color: #fff;
        }

        .footer p {
            color: #fff;
            text-align: center;
            margin: 0px auto;
        }

        .soc-icon {
            width: 40px;
            margin: 0 10px 20px 10px;
        }

        .headline {
            text-transform: uppercase;
            font-weight: bold;
            text-align: center;
            font-size: 20px;
            color: #333;
            padding: 10px;
        }

        table {
            margin: 0;
            padding: 0;
            border: none;
            width: 100%;
            margin: 0;
        }

        td {
            border-bottom: 1px solid #eee;
            padding: 10px 20px;
            margin: 0;
            text-align: left;
        }

        th {
            background-color: #eee;
            font-weight: bold;
            padding: 10px 20px;
            margin: 0;
            text-align: center;
        }

        .productimg {
            border: 1px solid #eee;
            max-width: 100px;
        }

        .instabox {
            width: 100%;
        }

        @media screen and (max-width: 610px) {
            .headline-logo {
                margin: 0 4%;
            }

            .headline-logo img {
                width: 90%;
                padding: 0;
            }
        }

        -->
    </style>
</head>

<body>

<div align="center" style="background-color:#fff;">

    <div style="width:100%; max-width:600px; text-align:center;">


        <div class="content" style="color:#222;">

            <div class="headline-logo"><a href="https://coreshop.hu" target="_blank" border="0">
                    <img src="https://coreshop.hu/images/coreshop-logo-mail.png"></a></div>


            <p>

            <table cellpadding=0 cellspacing=0 border=0>

                <tr>
                    <th colspan="2">Köszönjük a megrendelésedet, melyet a lenti adatokkal igazolunk vissza!</th>
                </tr>

                <?php
                if ($model->id_szallitasi_mod == SzallitasiMod::TYPE_SZEMELYES):
                    ?>
                    <tr>
                        <td colspan="2">Rendelésednél a személyes átvételt válaszottad, ezért kérünk, megrendelésed
                            maximum
                            3 munkanapon belül vedd át <a href="https://coreshop.hu/uzletunk">üzletünkben</a>.
                        </td>
                    </tr>
                <?php
                elseif ($model->id_szallitasi_mod == SzallitasiMod::TYPE_GLS):
                    ?>
                    <tr>
                        <td colspan="2">Rendelésednél GLS csomagpontot válaszottál szállítási címnek.
                        </td>
                    </tr>
                    <tr>
                        <td>Szállítási cím:</td>
                        <td><?= $model->gls_kod ?><br><?= $model->gls_adatok ?></td>
                    </tr>
                    <tr>
                        <td>Csomagpontra érkezés dátuma:</td>
                        <td><?php
                            if (GlobalisAdatok::getParam('egyedi_szallitas_idopont'))
                                echo GlobalisAdatok::getParam('egyedi_szallitas_idopont');

                            else
                                echo Coreshop::dateToHU(Coreshop::GlsDeliveryDate()) . ' </strong><br> 8:00 - 16:00 óra';
                            ?></td>
                    </tr>
                <?php
                else:
                    ?>
                    <tr>
                        <td colspan="2">Rendelésednél GLS csomagszállítást válaszottál.
                        </td>
                    </tr>
                    <tr>
                        <td>Szállítási cím:</td>
                        <td><?= $model->szallitasi_irszam ?> <?= $model->szallitasi_varos ?>
                            <br><?= $model->szallitasi_utcanev ?> <?= $model->szallitasi_kozterulet ?> <?= $model->szallitasi_hazszam ?> <?= $model->szallitasi_emelet ?? '(' . $model->szallitasi_emelet . ')' ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Kiszállítás dátuma:</td>
                        <td><?php
                            if (GlobalisAdatok::getParam('egyedi_szallitas_idopont'))
                                echo GlobalisAdatok::getParam('egyedi_szallitas_idopont');

                            else
                                echo Coreshop::dateToHU(Coreshop::GlsDeliveryDate()) . ' </strong><br> 8:00 - 16:00 óra';
                            ?></td>
                    </tr>
                <?php
                endif;
                ?>

                <tr>
                    <td>Rendelés szám:</td>
                    <td><?= $model->megrendeles_szama ?></td>
                </tr>

                <tr>
                    <td>Rendelés dátum:</td>
                    <td><?= Yii::$app->formatter->asDate($model->datum) ?></td>
                </tr>

                <tr>
                    <td>Fizetendő végösszeg:</td>
                    <td style="text-align:right">
                        <b><?= Yii::$app->formatter->asDecimal($model->fizetendo) ?> Ft</b></td>
                </tr>


                <tr>
                    <td>Szállítási mód:</td>
                    <?php if ($model->id_szallitasi_mod == SzallitasiMod::TYPE_SZEMELYES): ?>
                        <td><a href="https://coreshop.hu/uzletunk">Személyes átvétel üzletünkben</a></td>
                    <?php elseif ($model->id_szallitasi_mod == SzallitasiMod::TYPE_GLS): ?>
                        <td>Csomagpontba szállítás</td>
                    <?php else: ?>
                        <td>Szállítás futárszolgálattal</td>
                    <?php endif; ?>
                </tr>

                <!-- Utánvét esetén -->
                <tr>
                    <td>Fizetési mód:</td>
                    <?php if ($model->id_fizetesi_mod == FizetesiMod::TYPE_KESZPENZ): ?>
                        <td>Átvételkor készpénzben vagy bankkártyával.</td>
                    <?php else: ?>
                        <td>Bankkártyával fizetve.<br/><br/>Tranzakció
                            azonosító: <?= $model->bankTranzakcio->trid ?></td>
                    <?php endif; ?>
                </tr>

                <tr>
                    <th colspan="2">Rendelés részletei</th>
                </tr>

                <tr>
                    <td>Termék(ek):</td>
                    <td style="text-align:right">Összeg</td>
                </tr>

                <?php foreach ($model->tetelek as $item): ?>
                    <tr>
                        <td style="text-align:center;">
                            <img src="http://coreshop.hu/<?= $item->termek->getDefaultImage()->webUrl ?>" class="productimg"/>
                            <br/>
                            <?= $item->termek_nev ?> x 1 db<br>
                            Méret: <?= $item->tulajdonsag ?>
                        </td>
                        <td style="text-align:right">
                            <?= Yii::$app->formatter->asDecimal($item->termek_ar) ?> Ft<br>
                            <span class="small">(<?= Yii::$app->formatter->asDecimal($item->afa_ertek) ?>
                                Ft ÁFA)</span>
                        </td>
                    </tr>

                <?php endforeach; ?>

                <tr>
                    <td>Szállítási díj:</td>
                    <td style="text-align:right"><?= ($model->szallitasi_dij) ? Yii::$app->formatter->asDecimal($model->szallitasi_dij) . ' Ft' : 'INGYENES' ?></td>
                </tr>

                <tr>
                    <td>Összesen fizetendő:</td>
                    <td style="text-align:right">
                        <b><?= Yii::$app->formatter->asDecimal($model->fizetendo + $model->szallitasi_dij) ?>
                            Ft</b><br/>(<?= Yii::$app->formatter->asDecimal($item->afa_ertek) ?>
                        Ft ÁFA)
                    </td>
                </tr>


                <!-- Személyes átvételnél ez a sor nem jelenik meg -->
                <?php
                if ($model->id_szallitasi_mod != SzallitasiMod::TYPE_SZEMELYES):
                    ?>
                    <tr>
                        <th colspan="2" align="center">A kiszállítás várható időpontja:</th>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php
                            if (GlobalisAdatok::getParam('egyedi_szallitas_idopont'))
                                echo GlobalisAdatok::getParam('egyedi_szallitas_idopont');

                            else
                                echo Coreshop::dateToHU(Coreshop::GlsDeliveryDate()) . ' </strong><br> 8:00 - 16:00 óra';
                            ?></td>
                    </tr>
                <?php
                endif;
                ?>
                <tr>
                    <th colspan="2" align="center">Köszönjük, hogy a Coreshop-ot választottad!</th>
                </tr>

            </table>


            </p>
        </div>


        <div class="footer" style="background-color:#000;">

            <img src="https://coreshop.hu/newsletter/2017/coreshop-logo-footer.png" alt="Coreshop logo"
                 title="Coreshop logo" style="width:50%;max-width:260px;margin:0 auto 10px auto;"/>

            <p>Kövess minket hírcsatornáinkon:</p>

            <a href="https://www.facebook.com/coreshop" target="_blank"><img
                        src="https://coreshop.hu/newsletter/2017/social-facebook.png" alt="Coreshop @facebook.com"
                        class="soc-icon"/></a>
            <a href="https://www.instagram.com/coreshop.hu/" target="_blank"><img
                        src="https://coreshop.hu/newsletter/2017/social-instagram.png" alt="Coreshop @instagram.com"
                        class="soc-icon"/></a>
            <a href="https://plus.google.com/+coreshop" target="_blank"><img
                        src="https://coreshop.hu/newsletter/2017/social-googleplus.png"
                        alt="Coreshop @plus.google.com"
                        class="soc-icon"/></a>

            <br/>
            &copy; 2018 Coreshop.hu

        </div>

</body>
</html>
