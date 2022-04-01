<?php

/** @var yii\web\View $this */

/** @var ToFourthForm $form */

/** @var Districts $district */

use app\forms\FirstForm;
use app\forms\ToFourthForm;
use app\models\Districts;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$toThirdForm = $form->toThirdForm;
$secondForm = $toThirdForm->secondForm;
$this->title = 'Анкета';
?>
<div class="d-flex flex-column" style="min-height: 100%">
    <?php $activeForm = ActiveForm::begin([
        'action' => Url::to(['/5']),
        'method' => 'POST',
        'options' => ['style' => 'flex: 1 1 auto', 'id' => 'form']
    ]) ?>

    <div class="d-flex justify-content-between" style="margin-bottom: -25px">
        <?= Html::a('< назад', '/3') ?>
        <p>Моя заявка</p>
    </div>
    <hr>
    <div class="d-flex justify-content-between" style="line-height: 14px;">
        <p>Тип уборки:</p>
        <p class="font-weight-bold">
            <?= FirstForm::$types[$secondForm->firstForm->type] ?>
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

    <p class="text-center font-weight-bold" style="margin-bottom: 2px; font-size: 18px">Предложите ваши расценки в
        руб/т</p>
    <p class="text-center" style="line-height: 18px">С вашего района в следующие порты</p>

    <?= $activeForm->field($form, 'price_40_60', ['options' => [
        'class' => 'd-flex justify-content-between flex-wrap mb-3'
    ]])
        ->label('40-60 км', ['style' => 'flex: 1 0 50%'])
        ->input('number', [
            'class' => 'form-control bg-gray w-50',
            'onkeyup' => 'checkPrice("price_40_60", this)'
        ])->error(['style' => 'flex-basis: 100%; text-align: right']) ?>

    <?= $activeForm->field($form, 'price_60_80', ['options' => [
        'class' => 'd-flex justify-content-between flex-wrap mb-3',
    ]])
        ->label('60-80 км', ['style' => 'flex: 1 0 50%'])
        ->input('number', [
            'class' => 'form-control bg-gray w-50',
            'onkeyup' => 'checkPrice("price_60_80", this)'
        ])->error(['style' => 'flex-basis: 100%; text-align: right']) ?>

    <?= $activeForm->field($form, 'price_80_100', ['options' => [
        'class' => 'd-flex justify-content-between flex-wrap mb-3'
    ]])
        ->label('80-100 км', ['style' => 'flex: 1 0 50%'])
        ->input('number', [
            'class' => 'form-control bg-gray w-50',
            'onkeyup' => 'checkPrice("price_80_100", this)'
        ])->error(['style' => 'flex-basis: 100%; text-align: right']) ?>

    <?php ActiveForm::end() ?>

    <button type="submit" form="form" class="btn btn-gray w-100 mb-5">Далее ></button>
</div>


<?php

Modal::begin([
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

Modal::end();
?>


<script>
    let prices = {
        price_40_60: {
            wasCheck: false,
            price: <?=getenv('PRICE_40_60') ?: 0?>
        },
        price_60_80: {
            wasCheck: false,
            price: <?=getenv('PRICE_60_80') ?: 0?>
        },
        price_80_100: {
            wasCheck: false,
            price: <?=getenv('PRICE_80_100') ?: 0?>
        },
    }

    let modal,
        buttonChangePrice

    addEventListener('load', () => {
        modal = $('#modal')
        buttonChangePrice = $('#btn_change_price')
    })

    function checkPrice(priceName, elem) {
        let price = elem.value

        if (
            price <= prices[priceName].price
            || prices[priceName].wasCheck
            || !prices[priceName].price
        ) {
            return
        }
        buttonChangePrice.click(() => {
            modal.modal('toggle')
            elem.focus()
        })

        prices[priceName].wasCheck = true

        $('#setting_price').text(price)
        $('#middle_price').text(prices[priceName].price)

        modal.modal('toggle')
    }
</script>

