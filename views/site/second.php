<?php

/** @var yii\web\View $this */

/** @var \app\forms\SecondForm $form */
/** @var array $regions */
/** @var array $districts */
/** @var array $cars */

$this->title = 'Анкета';
?>
<div class="d-flex flex-column" style="min-height: 100%">
    <?php $activeForm = \yii\widgets\ActiveForm::begin([
        'action' => \yii\helpers\Url::to(['/3']),
        'method' => 'POST',
        'options' => ['style' => 'flex: 1 1 auto', 'id' => 'form']
    ]) ?>
    <div class="d-flex justify-content-between" style="margin-bottom: -25px">
        <?= \yii\helpers\Html::a('< назад', Yii::$app->request->referrer) ?>
        <p>Моя заявка</p>
    </div>
    <hr>
    <div class="d-flex justify-content-between">
        <p>Тип уборки:</p>
        <p class="font-weight-bold"><?= \app\forms\FirstForm::$types[$form->firstForm->type] ?></p>
    </div>
    <?= $activeForm->field($form, 'auto')
        ->label(false)
        ->dropDownList($cars, [
            'prompt' => 'Выберите тип автомобиля',
            'class' => 'form-control bg-gray'
        ]) ?>
    <?= $activeForm->field($form, 'region')
        ->label(false)
        ->dropDownList($regions, [
            'prompt' => 'Выберите регион погрузки',
            'class' => 'form-control bg-gray',
            'onchange' => 'loadDistricts(this)',
            'id' => 'regions'
        ]) ?>
    <?= $activeForm->field($form, 'district_id')
        ->label(false)
        ->dropDownList($districts, [
            'prompt' => 'Выберите регион погрузки выше',
            'class' => 'form-control bg-gray',
            'id' => 'districts'
        ]) ?>

    <?php \yii\widgets\ActiveForm::end() ?>
    <button type="submit" form="form" class="btn btn-gray w-100 mb-5">Далее ></button>
</div>
<script>
    function loadDistricts(e) {
        const regionID = e.options[e.selectedIndex].value

        fetch('/api/districts?id=' + regionID)
            .then(res => res.json())
            .then(districts => {
                let select = document.querySelector('#districts')

                select.innerHTML = '<option value="">Выберите район погрузки</option>'
                districts.forEach(district => {
                    let option = document.createElement('option')
                    option.value = district.id
                    option.text = district.name

                    select.add(option, null)
                })

            })
    }
</script>

