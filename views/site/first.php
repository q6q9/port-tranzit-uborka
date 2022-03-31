<?php

/** @var yii\web\View $this */

/** @var \app\forms\FirstForm $form */

$this->title = 'Анкета';

?>
<div class="d-flex flex-column" style="min-height: 100%">
    <?php $activeForm = \yii\widgets\ActiveForm::begin([
        'method' => 'POST',
        'action' => \yii\helpers\Url::to(['/2']),
        'options' => [
            'class' => 'd-flex flex-column',
            'id' => 'form',
            'style' => 'flex: 1 1 auto'
        ]
    ]) ?>

    <img src="/images/image 1.jpg" alt="" class="mb-3">
    <p class="font-weight-bold text-center mb-4" style="font-size: 19px">
        Чтобы записаться на уборку 2022г. заполните форму ниже
    </p>
    <p class="text-center mb-5">Откуда и куда вы планируете возить:</p>


    <?= $activeForm->field($form, 'type')
        ->label(false)
        ->dropDownList(\app\forms\FirstForm::$types, ['prompt' => 'Выбрать', 'class' => 'form-control bg-gray']) ?>


    <?php \yii\widgets\ActiveForm::end() ?>
    <button
            type="submit"
            class="btn btn-gray w-100 mb-5"
            form="form"
    >Далее >
    </button>
</div>