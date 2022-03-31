<?php

$driver = getenv('DB_DRIVER') ?: 'mysql';
$host = getenv('DB_HOST') ?: 'localhost';
$dbname = getenv('DB_NAME') ?: 'dbname';

return [
    'class' => \yii\db\Connection::class,
    'dsn' => "{$driver}:host={$host};dbname={$dbname}",
    'username' => getenv('DB_USER') ?: 'root',
    'password' => getenv('DB_PASSWORD') ?: '',
    'charset' => getenv('DB_CHARSET') ?: 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
