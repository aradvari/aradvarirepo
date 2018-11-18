<?php

use app\models\SzavazasKerdes;
use app\models\SzavazasValasz;
use yii\helpers\Html;
use yii\helpers\Url;

$szavazasKerdes = SzavazasKerdes::findOne(12);
?>

<h2><br><?= $szavazasKerdes->kerdes ?></h2>

<?php
if (Yii::$app->session->get('userVote'))
    echo $this->render('_voted', ['szavazasKerdes' => $szavazasKerdes]);
else
    echo $this->render('_vote', ['szavazasKerdes' => $szavazasKerdes]);
?>
