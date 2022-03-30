<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex align-content-center justify-content-center  fy-content-center p-5">
<?php $this->beginBody() ?>

<div class="wrapper d-flex flex-column align-items-center shadow rounded px-3 pb-5 pt-4 my-1">
    <div class="w-100">
    <header class="d-flex mb-3 justify-content-end">
        <img src="/images/pt-logo.svg">
        <div class="title d-flex flex-column    ">
            <div class="top ml-3 mb-2">
                <img src="/images/Port.svg">
                <img src="/images/Tranzit.svg">
            </div>
            <img src="/images/экспедирование.svg">
        </div>
    </header>
    <?=$content?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
