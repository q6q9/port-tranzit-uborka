<?php

/** @var yii\web\View $this */

/** @var \app\forms\FromFourthForm $form */
/** @var \app\models\Districts $district */

$fromThirdForm = $form->fromThirdForm;
$secondForm = $fromThirdForm->secondForm;

$this->title = 'Анкета';
?>
<div class="d-flex flex-column" style="min-height: 100%">
    <?php $activeForm = \yii\widgets\ActiveForm::begin([
        'action' => \yii\helpers\Url::to(['/5']),
        'method' => 'POST',
        'options' => ['style' => 'flex: 1 1 auto', 'id' => 'form']
    ]) ?>

    <div class="d-flex justify-content-between" style="margin-bottom: -25px">
        <?= \yii\helpers\Html::a('< назад', '/3') ?>
        <p>Моя заявка</p>
    </div>
    <hr>
    <div class="d-flex justify-content-between" style="line-height: 14px;">
        <p>Тип уборки:</p>
        <p class="font-weight-bold">
            <?= \app\forms\FirstForm::$types[$secondForm->firstForm->type] ?>
        </p>
    </div>
    <div class="d-flex justify-content-between" style="line-height: 14px;">
        <p>Автомобиль:</p>
        <p class="font-weight-bold">
            <?= $secondForm->auto ?>
        </p>
    </div>
    <div class="d-flex justify-content-between" style="line-height: 14px;">
        <p>Регион:</p>
        <p class="font-weight-bold">
            <?= $district->region->name ?>
        </p>
    </div>
    <div class="d-flex justify-content-between" style="line-height: 14px;">
        <p>Район:</p>
        <p class="font-weight-bold">
            <?= $district->name ?>
        </p>
    </div>

    <hr class="mb-4">

    <div class="d-flex justify-content-between" style="line-height: 14px;">
        <p>Новороссийск</p>
        <p class="font-weight-bold">
            <?= $fromThirdForm->novorossiyskPrice ?> руб/т
        </p>
    </div>

    <div class="d-flex justify-content-between" style="line-height: 14px;">
        <p>Азов</p>
        <p class="font-weight-bold">
            <?= $fromThirdForm->azovPrice ?> руб/т
        </p>
    </div>

    <div class="d-flex justify-content-between mb-4" style="line-height: 14px;">
        <p>Волна</p>
        <p class="font-weight-bold">
            <?= $fromThirdForm->volnaPrice ?> руб/т
        </p>
    </div>

    <?= $activeForm->field($form, 'phone', ['options' => [
    ]])
        ->label('Ваш телефон для связи', ['style' => 'flex: 1 0 50%; font-weight: bold'])
        ->input('tel', [
            'class' => 'form-control bg-gray w-100',
            'onkeyup' => 'checkPrice("volna", this)'
        ])
    ?>

    <?php \yii\widgets\ActiveForm::end() ?>

    <button type="submit" form="form" class="btn btn-gray w-100 mb-5">Далее ></button>
</div>


<script>
</script>

