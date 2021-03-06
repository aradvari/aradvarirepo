<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=coreshop',
    'username' => 'root',
    'password' => 'mysql',
    'attributes' => [
        PDO::ATTR_PERSISTENT => true,
    ],
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 60,
    'schemaCache' => 'cache',
];
