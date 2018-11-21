<?php

use app\models\TermekekSearch;

?>
<div class="alice-blue-bg m--15">
    <div class="container">
        <div class="row justify-content-center">
            <h2 class="mt-5 my-5 text-center"> VANS <span class="blue">akciós termékek</span></h2>
        </div>
    </div>

    <?php
    $dataProvider = (new TermekekSearch())->search(['subCategory' => ['ferfi-cipo', 'noi-cipo']]);
    $dataProvider->pagination = false;
    $dataProvider->query->andWhere(['opcio' => 'UJ']);
    $dataProvider->query->limit(12);
    $dataProvider->query->orderBy('rand()');

    if ($dataProvider->getCount() > 0)
        echo $this->render('/termekek/_index_ajanlo', ['dataProvider' => $dataProvider]);
    ?>
</div>
