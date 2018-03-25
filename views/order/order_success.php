<h2>Köszönjük! A megrendelést megkaptuk</h2>

<?php
echo $this->render('_order_data', ['model' => $model]);
echo $this->render('/termekek/_ajanlo');