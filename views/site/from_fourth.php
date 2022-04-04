<?php

/** @var yii\web\View $this */

/** @var FromFourthForm $form */

/** @var Districts $district */

use app\forms\FirstForm;
use app\forms\FromFourthForm;
use app\models\Districts;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JqueryAsset;
use yii\widgets\ActiveForm;

$fromThirdForm = $form->fromThirdForm;
$secondForm = $fromThirdForm->secondForm;

$this->registerJsFile(
    '/js/jquery.maskedinput.min.js',
    ['depends' => [JqueryAsset::className()]]
);

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

        $('#phone').mask("+7(999) 999-9999");

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
            return await $.ajax({
                url: '/api/send-code?phone=' + phone + '&type=' + '<?=FirstForm::FROM_TOK_ELEVATOR?>',
                type: 'POST',
                data: data
            });
        } catch (e) {
            alert('Error sms sending')
        }
    }
</script>

