<?php

/** @var yii\web\View $this */

/** @var app\forms\ToFifthForm $form */

/** @var Districts $district */

use app\forms\FirstForm;
use app\models\Districts;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$toFourthForm = $form->toFourthForm;
$toThirdForm = $toFourthForm->toThirdForm;
$secondForm = $toThirdForm->secondForm;

$this->title = 'Анкета';
?>
<div class="d-flex flex-column" style="min-height: 100%">
    <?php $activeForm = ActiveForm::begin([
        'action' => Url::to(['/6']),
        'method' => 'POST',
        'options' => ['style' => 'flex: 1 1 auto', 'id' => 'form']
    ]) ?>

    <div class="d-flex justify-content-between" style="margin-bottom: -25px">
        <?= Html::a('< назад', '/4') ?>
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
    <div class="d-flex justify-content-between">
        <div class="w-50 mr-4">
            <div class="d-flex justify-content-between" style="line-height: 14px;">
                <p>0-10</p>
                <p class="font-weight-bold">
                    <?= $toThirdForm->price_0_10 ?> руб/т
                </p>
            </div>

            <div class="d-flex justify-content-between" style="line-height: 14px;">
                <p>10-20</p>
                <p class="font-weight-bold">
                    <?= $toThirdForm->price_10_20 ?> руб/т
                </p>
            </div>

            <div class="d-flex justify-content-between mb-4" style="line-height: 14px;">
                <p>20-40</p>
                <p class="font-weight-bold">
                    <?= $toThirdForm->price_20_40 ?> руб/т
                </p>
            </div>
        </div>
        <div class="w-50 ml-4">
            <div class="d-flex justify-content-between" style="line-height: 14px;">
                <p>40-60</p>
                <p class="font-weight-bold">
                    <?= $toFourthForm->price_40_60 ?> руб/т
                </p>
            </div>

            <div class="d-flex justify-content-between" style="line-height: 14px;">
                <p>60-80</p>
                <p class="font-weight-bold">
                    <?= $toFourthForm->price_60_80 ?> руб/т
                </p>
            </div>

            <div class="d-flex justify-content-between mb-4" style="line-height: 14px;">
                <p>80-100</p>
                <p class="font-weight-bold">
                    <?= $toFourthForm->price_80_100 ?> руб/т
                </p>
            </div>
        </div>
    </div>

    <?= $activeForm->field($form, 'phone', ['options' => [
    ]])
        ->label('Ваш телефон для связи', ['style' => 'flex: 1 0 50%; font-weight: bold'])
        ->input('tel', [
            'class' => 'form-control bg-gray w-100',
            'id' => 'phone'
        ])
    ?>

    <?php ActiveForm::end() ?>

    <button
            type="submit"
            form="form"
            class="btn btn-gray w-100 mb-5"
    >Далее >
    </button>
</div>


<script>
    let param,
        token,
        globalPhone

    addEventListener('load', () => {
        token = yii.getCsrfToken()
        param = yii.getCsrfParam()


        $("form").submit(async function (e) {
            e.preventDefault()

            const phone = $('#phone').val()
            if (!phone || phone == globalPhone) {
                return;
            }

            globalPhone = phone

            await sendCode(phone)
            e.target.submit()
        });
    })


    async function sendCode(phone) {
        if (!phone) {
            console.error('empty phone')
            return;
        }

        try {
            let data = {}
            data[param] = token;
            return $.ajax({
                url: '/api/send-code?phone=' + phone,
                type: 'POST',
                data: data
            });
        } catch (e) {
            alert('Error sms sending')
        }
    }
</script>

