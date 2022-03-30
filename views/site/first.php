<?php

/** @var yii\web\View $this */

/** @var \app\forms\FirstForm $form */

use yii\helpers\Html;

$this->title = 'Анкета';

?>
<div>
    <?php $activeForm = \yii\widgets\ActiveForm::begin([
        'method' => 'POST',
        'action' => \yii\helpers\Url::to(['/2'])
    ]) ?>
    <img src="/images/image 1.jpg" alt="" class="mb-3">
    <p class="font-weight-bold text-center mb-4" style="font-size: 19px">
        Чтобы записаться на уборку 2022г. заполните форму ниже
    </p>
    <p class="text-center mb-5">Откуда и куда вы планируете возить:</p>

    <div class="d-flex justify-content-center flex-column">

        <?= $activeForm->field($form, 'type')
            ->label(false)
            ->dropDownList(\app\forms\FirstForm::$types, ['prompt' => 'Выбрать', 'class' => 'form-control bg-gray']) ?>
        <button
                type="submit"
                class="btn btn-gray w-100 mt-5"
        >Далее >
        </button>
    </div>
    <?php \yii\widgets\ActiveForm::end() ?>
</div>
