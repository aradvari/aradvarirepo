<?php

use app\models\SzavazasValasz;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<p class="">Szavazatoddal segíted munkánkat, kérjük válassz az alábbi lehetőségek közül:</p>

<?php
echo Html::radioList('vote', null, SzavazasValasz::getData('valasz_id', 'valasz', ['kerdes_id' => $szavazasKerdes->primaryKey]));
?>

<?php
$url = Url::to(['order/ajax-vote']);
$parentId = $szavazasKerdes->primaryKey;
$this->registerJS(<<<JS
    $(document).one("click", '[name="vote"]', function(){
        $.ajax({
          url: '{$url}',
          method: 'post',
          data: {
              parentId: '{$parentId}',
              id: $(this).val()
          }
        }).done(function(response) {
          $('.vote-container').html(response);
        });
    });
JS
);
