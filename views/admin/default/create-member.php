<?php
use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;


?>
<div class="card">
    <div class="card-header">
        <h5>ds</h5>
    </div>
    <div class="card-body">


        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'firstname') ?>
        <?= $form->field($model, 'lastname') ?>
        <div class="form-group text-center">
            <?= Html::submitButton(Yii::t('app/default', 'SEND'), ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
