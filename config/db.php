<?php
declare(strict_types = 1);

use yii\db\Connection;

return [
    'class' => Connection::class,
    'dsn' => 'mysql:host=americor-mysql;dbname=americor-test',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
