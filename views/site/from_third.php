<?php

/** @var yii\web\View $this */

/** @var \app\forms\FromThirdForm $form */
/** @var \app\models\Districts $district */

$this->title = 'Анкета';
?>
<div class="d-flex flex-column" style="min-height: 100%">
    <?php $activeForm = \yii\widgets\ActiveForm::begin([
        'action' => \yii\helpers\Url::to(['/4']),
        'method' => 'POST',
        'options' => ['style' => 'flex: 1 1 auto', 'id' => 'form']
    ]) ?>

    <div class="d-flex justify-content-between" style="margin-bottom: -25px">
        <?= \yii\helpers\Html::a('< назад', '/2') ?>
        <p>Моя заявка</p>
    </div>
    <hr>
    <div class="d-flex justify-content-between" style="line-height: 14px;">
        <p>Тип уборки:</p>
        <p class="font-weight-bold">
            <?= \app\forms\FirstForm::$types[$form->secondForm->firstForm->type] ?>
        </p>
    </div>
    <div class="d-flex justify-content-between" style="line-height: 14px;">
        <p>Автомобиль:</p>
        <p class="font-weight-bold">
            <?= $form->secondForm->auto ?>
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

    <p class="text-center font-weight-bold" style="margin-bottom: 2px; font-size: 18px">Предложите ваши расценки в
        руб/т</p>
    <p class="text-center" style="line-height: 18px">С вашего района в следующие порты</p>

    <?= $activeForm->field($form, 'novorossiyskPrice', ['options' => [
        'class' => 'd-flex justify-content-between flex-wrap mb-3'
    ]])
        ->label('Новороссийск', ['style' => 'flex: 1 0 50%'])
        ->input('number', [
            'class' => 'form-control bg-gray w-50',
            'onkeyup' => 'checkPrice("novorossiysk", this)'
        ])->error(['style' => 'flex-basis: 100%; text-align: right']) ?>

    <?= $activeForm->field($form, 'azovPrice', ['options' => [
        'class' => 'd-flex justify-content-between flex-wrap mb-3',
    ]])
        ->label('Азов', ['style' => 'flex: 1 0 50%'])
        ->input('number', [
            'class' => 'form-control bg-gray w-50',
            'onkeyup' => 'checkPrice("azov", this)'
        ])->error(['style' => 'flex-basis: 100%; text-align: right']) ?>

    <?= $activeForm->field($form, 'volnaPrice', ['options' => [
        'class' => 'd-flex justify-content-between flex-wrap mb-3'
    ]])
        ->label('Волна', ['style' => 'flex: 1 0 50%'])
        ->input('number', [
            'class' => 'form-control bg-gray w-50',
            'onkeyup' => 'checkPrice("volna", this)'
        ])->error(['style' => 'flex-basis: 100%; text-align: right']) ?>

    <?php \yii\widgets\ActiveForm::end() ?>

    <button type="submit" form="form" class="btn btn-gray w-100 mb-5">Далее ></button>
</div>


<?php

\yii\bootstrap4\Modal::begin([
    'title' => <<<HTML
<div>
    <p style="color: #606060;font-size: 20px">
        Вы указали цену на <b>Новороссийск</b>
    </p>
    <p class="font-weight-bold" style="font-size: 30px; margin-bottom: 10px">
    <span id="setting_price">0</span> руб/т</p>
</div>
HTML
    ,
    'id' => 'modal',
]);

echo <<<HTML
<p class="text-danger" style="font-size: 14px">Цена выше среднего предложения от других перевозчиков</p>
    <p style="font-size: 20px; margin-bottom: 45px;" >
        Средняя цена <br> <b><span id="middle_price">1000</span> руб/т</b>
    </p>
    <button class="btn btn-gray w-100 mb-5 font-weight-bold w-100" id="btn_change_price">
        Изменить цену
    </button>
<button class="btn bg-gray w-100 mb-5 w-100" onclick="modal.modal('toggle')">
        Оставить и продолжить
    </button>
HTML;

\yii\bootstrap4\Modal::end();
?>


<script>
    let cities = {
        novorossiysk: {
            wasCheck: false,
            price: <?=getenv('NOVOROSSIYSK_PRICE') ?: 0?>
        },
        azov: {
            wasCheck: false,
            price: <?=getenv('AZOV_PRICE') ?: 0?>
        },
        volna: {
            wasCheck: false,
            price: <?=getenv('VOLNA_PRICE') ?: 0?>
        },
    }

    let modal,
        buttonChangePrice

    addEventListener('load', () => {
        modal = $('#modal')
        buttonChangePrice = $('#btn_change_price')
    })

    function checkPrice(city, elem) {
        price = elem.value

        if (
            price <= cities[city].price
            || cities[city].wasCheck
            || !cities[city].price
        ) {
            return
        }
        buttonChangePrice.click(() => {
            modal.modal('toggle')
            elem.focus()
        })

        cities[city].wasCheck = true

        $('#setting_price').text(price)
        $('#middle_price').text(cities[city].price)

        modal.modal('toggle')
    }
</script>

