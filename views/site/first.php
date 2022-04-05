<?php

/** @var yii\web\View $this */

/** @var FirstForm $form */

use app\forms\FirstForm;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Анкета';

?>
<div class="d-flex flex-column" style="min-height: 100%">
    <?php $activeForm = ActiveForm::begin([
        'method' => 'POST',
        'action' => Url::to(['/2']),
        'options' => [
            'class' => 'd-flex flex-column',
            'id' => 'form',
            'style' => 'flex: 1 1 auto'
        ]
    ]) ?>

    <img style="
      display: flex;
      align-items: flex-start;
    "
         src="/images/9a609fc952194b5676d66842f8a9d2ce.jpg" alt="" class="mb-3">
    <p class="font-weight-bold text-center mb-4" style="font-size: 19px">
        Чтобы записаться на уборку 2022г. заполните форму ниже
    </p>
    <p class="text-center mb-5">Откуда и куда вы планируете возить:</p>


    <?= $activeForm->field($form, 'type')
        ->label(false)
        ->dropDownList(FirstForm::$types, ['prompt' => 'Выбрать', 'class' => 'form-control bg-gray']) ?>


    <?php ActiveForm::end() ?>
    <button
            type="submit"
            class="btn btn-gray w-100 mb-5"
            form="form"
    >Далее >
    </button>
</div>