<?php

/** @var yii\web\View $this */
/** @var \app\forms\SecondForm $form*/
use yii\helpers\Html;

$this->title = 'Анкета';
?>
<div class="w-100">
    <?php $activeForm = \yii\widgets\ActiveForm::begin(['method' => 'POST'])?>
    <div class="d-flex justify-content-between" style="margin-bottom: -25px">
        <p>< назад</p>
        <p>Моя заявка</p>
    </div>
    <hr>
    <div class="d-flex justify-content-between">
        <p>Тип уборки:</p>
        <p class="font-weight-bold"><?=\app\forms\FirstForm::$types[$form->firstForm->type]?></p>
    </div>
    <?= $activeForm->field($form, 'auto')
        ->label(false)
        ->dropDownList(\app\forms\FirstForm::$types, ['prompt' => 'Выбрать', 'class' => 'form-control bg-gray']) ?>
    <?= $activeForm->field($form, 'region')
        ->label(false)
        ->dropDownList(\app\forms\FirstForm::$types, ['prompt' => 'Выбрать', 'class' => 'form-control bg-gray']) ?>
    <?= $activeForm->field($form, 'district')
        ->label(false)
        ->dropDownList(\app\forms\FirstForm::$types, ['prompt' => 'Выбрать', 'class' => 'form-control bg-gray']) ?>
        <button type="submit" class="btn btn-gray w-100 mt-5">Далее ></button>

    <?php \yii\widgets\ActiveForm::end()?>
</div>
