<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

try {
    $dotEnv = Dotenv\Dotenv::createUnsafeImmutable(dirname(__DIR__));
    $dotEnv->load();
} catch (Exception $e) {
    throw new Exception('Not set .env file');
}


$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
